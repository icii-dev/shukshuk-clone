<?php

namespace App\Service;

use App\Http\Requests\ProductVariant\CreateProductVariantsRequest;
use App\Http\Requests\Seller\ProductCreateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Model\Product;
use App\Model\Category;
use App\Model\ProductOption;
use App\Model\ProductOptionValue;
use App\Model\ProductVariant;
use App\Model\Store;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;

class ProductService
{
    public function getProductById($id)
    {
        $product = Product::where('id', $id)
            ->first();

        return $product;
    }

    /**
     * Get product published by slug
     *
     * @param $slug
     * @return Product|null
     */
    public function getPublishedBySlug($slug)
    {
        $product = Product::with('options', 'options.values', 'variants')
            ->published()
            ->where('slug', 'like', $slug)
            ->firstOrFail();

        return new ProductResource($product);
    }

    public function getPagedFeatured($page = 1, $limit = 10)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $products = Product::with('store')
            ->with('variants')
            ->where('featured', '=', '1')
            ->published()
            ->inRandomOrder()
            ->paginate($limit);
        return new ProductCollection($products);
    }

    public function getPagedRelated($id, $page = 1, $limit = 10)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });


        $product = Product::find($id);

        if (!$product) {
            $categoryIds = [];
        } else {
            $categoryIds = Arr::pluck($product->categories()->get(), 'id');
        }

        // same category
        $products = Product::with('store')
            ->published()
            ->whereIn('id', function (Builder $builder) use ($categoryIds) {
                $builder->select('product_id')
                    ->from('category_product')
                    ->whereIn('category_id', $categoryIds);
            })->paginate($limit);

        return $products;
    }

    public function getAllProductOfStore(Store $store)
    {
        return $store->products()
            ->published()
            ->get();
    }

    public function getPagedProductOfStore(Store $store, $page = 1, $limit = 25)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $pagedProduct = $store
            ->products()
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);

        return $pagedProduct;
    }

    public function getProductOfStore($store_id, $page = 1, $limit = 20)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        // same category
        $products = Product::published()
            ->where('store_id', $store_id)
            ->paginate($limit);
        return new ProductCollection($products);
    }

    public function getListProductById($listId)
    {

        $products = Product::with('store')
            ->whereIn('id', $listId)
            ->get();

        return $products;
    }

    public function getProductByCategoryAndRating(Category $category, $rating, $page = 1, $limit = 10)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $products = $category
            ->products()
            ->where('rating_cache', ">", $rating)
            ->published()
            ->with('store')
            ->paginate($limit);
        return new ProductCollection($products);
    }

    public function getByIdOfStore(Store $store, $id)
    {
        return $store->products()->whereId($id)->first();
    }

    public function updateProduct(Product $product, FormRequest $input)
    {
        $product->fill(
            $input->only(
                $product->getFillable()
            )
        );

        // Create slug
        $product->slug = $product->id . '-' . toSlug($product->name);

        $product->save();

        // Update product category
        $this->updateCategories($product, $input);

        // Update option value
        $this->updateOptionValue($product, $input);

        // If user change product options, set program to draft status
        if (true) {// @todo: set condition
            $product->status = Product::STATUS_DEACTIVE;
        }


        $product->save();
    }

    public function updateCategories(Product $product, FormRequest $input)
    {
        // Remove old category
        $product->categories()->detach(
            $product->categories->map(function ($category) {
                return $category->id;
            })
        );

        if ($input->get('category_id')) {
            $product->categories()->attach($input->get('category_id'));
        }

        $product->save();
    }

    public function updateOptionValue(Product $product, FormRequest $input)
    {
        $oldOptions = $product->options()->with('values')->get()->toArray();

        // If disable option -> remove all options and return
        if (!$input->get('is_option_enabled')) {
            // Clear all & re-insert
            foreach ($product->options as $option) {
                $option->values()->delete();

                $option->delete();
            }

            return;
        }

        $maximumOptions = 2;

        $inputOptions = $input->get('options');
        $oldOptionIds = array_map(function ($oldOption) {
            return $oldOption['id'];
        }, $oldOptions);
        $inputOptionIds = array_keys($inputOptions);

        // Remove old Option
        $removalOptionIds = array_diff($oldOptionIds, $inputOptionIds);
        foreach ($removalOptionIds as $removalOptionId) {
            if (!$option = ProductOption::find($removalOptionId)) {
                continue;
            }

            foreach ($option->values as $value) {
                $value->delete();
            }

            $option->delete();
        }

        // Insert new Option
        $newOptionIds = array_diff($inputOptionIds, $oldOptionIds);

        foreach ($newOptionIds as $key) {
            if (!$inputOptions[$key]) {
                continue;
            }

            /** @var ProductOptionValue $option */
            $option = $product->options()->create([
                'name' => $inputOptions[$key]
            ]);

            $inputValues = $input->get('values')[$key];

            foreach ($inputValues as $inputValueId => $inputValueName) {
                if (!$inputValueName) {
                    continue;
                }

                $option->values()->create([
                    'name' => $inputValueName
                ]);
            }
        }

        // Update Option
        $updateOptionIds = array_intersect($inputOptionIds, $oldOptionIds);
        foreach ($updateOptionIds as $inputOptionId) {
            $inputOptionName = $inputOptions[$inputOptionId];

            if (!$option = ProductOption::find($inputOptionId)) {
                continue;
            }

            $option->name = $inputOptionName;

            $inputValues = $input->get('values')[$inputOptionId];
            $oldValues = $option->values->toArray();

            $oldValueIds = array_map(function ($oldValue) {
                return $oldValue['id'];
            }, $oldValues);
            $inputValueIds = array_keys($inputValues);

            // Remove values
            $removalValueIds = array_diff($oldValueIds, $inputValueIds);
            foreach ($removalValueIds as $removalValueId) {
                if ($value = ProductOptionValue::find($removalValueId)) {
                    $value->delete();
                }
            }

            // Update values
            $updateValueIds = array_intersect($oldValueIds, $inputValueIds);
            foreach ($updateValueIds as $updateValueId) {
                if ($value = ProductOptionValue::find($updateValueId)) {
                    $value->name = $inputValues[$updateValueId];
                    $value->save();
                }
            }

            // Create values
            $createValueIds = array_diff($inputValueIds, $oldValueIds);
            foreach ($createValueIds as $createValueId) {
                if (!$inputValues[$createValueId]) {
                    continue;
                }

                $option->values()->create([
                    'name' => $inputValues[$createValueId]
                ]);
            }
        }
    }

    public function getReviewsPagination(Product $product, $page = 1, $limit = 5)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $reviews = $product->reviews()->orderBy('updated_at', 'desc')->paginate($limit);

        return $reviews;
    }

    public function percentageOfRatings($reviews)
    {
        if ($reviews->isEmpty()) {
            return null;
        }
        $calculateRating = array(
            'one'   => 0,
            'two'   => 0,
            'three' => 0,
            'four'  => 0,
            'five'  => 0,
        );
        $totalReviews = $reviews->count();
        foreach ($reviews as $review) {
            switch ($review->rating) {
                case 1:
                    $calculateRating['one']++;
                    break;
                case 2:
                    $calculateRating['two']++;
                    break;
                case 3:
                    $calculateRating['three']++;
                    break;
                case 4:
                    $calculateRating['four']++;
                    break;
                case 5:
                    $calculateRating['five']++;
                default :
                    break;
            }
        }
//        return $calculateRating;
        $percentageOfRatings = array();
        $percentageOfRatings['one'] = round($calculateRating['one'] * 100 / $totalReviews, 1);
        $percentageOfRatings['two'] = round($calculateRating['two'] * 100 / $totalReviews, 1);
        $percentageOfRatings['three'] = round($calculateRating['three'] * 100 / $totalReviews, 1);
        $percentageOfRatings['four'] = round($calculateRating['four'] * 100 / $totalReviews, 1);
        $percentageOfRatings['five'] = round($calculateRating['five'] * 100 / $totalReviews, 1);
        return $percentageOfRatings;
    }

    public function getProductByIds($ids)
    {
        return Product::
        whereIn('id', $ids)
            ->get();
    }

    function getProductInStoreByCategory($id)
    {
        return $categories = Category::with([
            'products' => function ($query) use ($id) {
                $query->where('store_id', $id);
            }
        ])
            ->whereHas('products', function ($query) use ($id) {
                $query->where('store_id', $id);
            })
            ->get();
    }

    public function deleteProduct(Product $product)
    {
        $options = $product->options;
        foreach ($options as $option) {
            $option->values()->delete();
            $option->delete();
        }
        foreach ($product->images as $image) {
            $image = public_path($image);
            if (\File::exists($image)) {
                \File::delete($image);
            }
        }
        $product->delete();
    }

    public function createProduct(Store $store, ProductCreateRequest $input)
    {
        $product = new Product();

        $product->fill(
            $input->only(
                $product->getFillable()
            )
        );

        // Store id
        $product->store_id = $store->id;

        // Status
        $product->status = Product::STATUS_DEACTIVE;

        // tmp slug
        $product->slug = uniqid() . '-' . toSlug($product->name);

        $product->save();

        $product->slug = $product->id . '-' . toSlug($product->name);

        // Product category
        $this->updateCategories($product, $input);

        // Save product options value
        $this->updateOptionValue($product, $input);

        $product->save();

        return $product;
    }

    public function saveProductVariants(Product $product, CreateProductVariantsRequest $createProductVariantsRequest)
    {
        // @todo: validate variants
        $requiredVariants = [];
        if ($product->options->count() === 1) {
            foreach ($product->options[0]->values as $value) {
                $requiredVariants[] = [$value->id];
            }
        } elseif ($product->options->count() === 2) {
            foreach ($product->options[0]->values as $value1) {
                foreach ($product->options[1]->values as $value2) {
                    $requiredVariants[] = [$value1->id, $value2->id];
                }
            }
        } else {
            $requiredVariants[] = [];
        }

        $inputVariants = $createProductVariantsRequest->get('variants');
        $keepProductVariantIds = [];
        foreach ($requiredVariants as $requiredVariant) {
            foreach ($inputVariants as $index => $inputVariant) {
                $inputOptions = isset($inputVariant['options']) ? $inputVariant['options'] : [];
                if (!empty(array_diff($requiredVariant, $inputOptions))) {
                    continue;
                }

                $productVariant = $this->saveProductVariant(
                    $product,
                    $inputVariant,
                    $createProductVariantsRequest->file('variants.' . $index . '.images')
                );

                $keepProductVariantIds[] = $productVariant->id;
            }
        }

        // -------------------------------------
        // Remove another variants
        $removedProductVariants = $product->variants->whereNotIn('id', $keepProductVariantIds);

        foreach ($removedProductVariants as $removedProductVariant) {
            $removedProductVariant->delete();
        }

        // Update product price.
        $minPrice = $product->variants->min('price');

        // Save product Images
        $extractedVariantImages = $product->variants->map(function ($variant) {
            return $variant->images ? $variant->images : [];
        })->toArray();

        $product->images = array_merge(...$extractedVariantImages);

        if (!empty($product->images)) {
            $product->image = $product->images[0];
        }

        // Set product as min price
        $product->price = $minPrice;

        // Update main status
        if ($product->is_published && $product->status == Product::STATUS_DEACTIVE) {
            $product->status = Product::STATUS_ACTIVE;
        }

        // Update product stock quantity
        $listVariantsUnlimitedStock = $product->variants->filter(function ($variant) {
            return $variant->quantity == -1;
        });

        if ($listVariantsUnlimitedStock->count()) {
            $product->quantity = -1;
        } else {
            $product->quantity = $product->variants->reduce(function ($carry, $variant) {
                return $carry + $variant->quantity;
            });
        }

        // Update product discount
        $variantHasMinPrice = $product->variants->firstWhere('price', $product->variants->min('price'));

        if ($variantHasMinPrice
            && $variantHasMinPrice->discount_value
            && $variantHasMinPrice->discount_type) {
            $product->discount = $variantHasMinPrice->discount_value;
            $product->discount_type = $variantHasMinPrice->discount_type === ProductVariant::DISCOUNT_TYPE_PERCENT ?
                Product::DISCOUNT_PERCENT : Product::DISCOUNT_MONEY;
        }

        $product->save();
    }

    protected function saveProductVariant(Product $product, $inputVariant, $inputImages)
    {
        // Update
        if ($inputVariant['id'] > 0) {
            $productVariant = ProductVariant::find($inputVariant['id']);
        }

        // or Create
        if (!isset($productVariant)) {
            $productVariant = new ProductVariant();
            $productVariant->product_id = $product->id;
        }

        $productVariant->fill($inputVariant);

        if (isset($inputVariant['is_quantity_empty']) && $inputVariant['is_quantity_empty']) {
            $productVariant->quantity = -1;
        }
        if(empty($inputVariant['quantity'])){
            $productVariant->quantity = -1;
        }

        if (isset($inputVariant['is_discount_percent']) && $inputVariant['is_discount_percent']) {
            $productVariant->discount_type = ProductVariant::DISCOUNT_TYPE_PERCENT;
        } else {
            $productVariant->discount_type = ProductVariant::DISCOUNT_TYPE_MONEY;
        }

        $productVariant->save();

        // Update image
        $images = $productVariant->images;
        $updateImages = is_array($images) ? $images : [];
        if (!empty($inputImages)) {
            foreach ($inputImages as $k => $imageUploaded) {
                // Save image
                $fileName = md5(uniqid($product->id) . time()) . '.' . $imageUploaded->getClientOriginalExtension();

                $image = Image::make($imageUploaded);
                $image->orientate();
                $image->resize(1024, 1024, function ($constraint) {
                    // Keep ratio
                    $constraint->aspectRatio();

                    // Prevent upsize
                    $constraint->upsize();
                });

                $image->save(
                    public_path('img/products/' . $fileName)
                );

                if (isset($updateImages[$k])) {
                    $updateImages[$k] = '/img/products/' . $fileName;

                    @unlink(
                        public_path( $images[$k])
                    );

                } else {
                    array_push(
                        $updateImages,
                        '/img/products/' . $fileName
                    );
                }
            }
        }

        $productVariant->images = $updateImages;

        if (!empty($updateImages) && $updateImages[0] != $product->image) {
            $productVariant->image = $updateImages[0];
        }

        $productVariant->save();

        return $productVariant;
    }



    public function removePhoto($productVariantId, $photoIndex)
    {
        $productVariant = ProductVariant::find($productVariantId);
        $images = $productVariant->images;
        $updateImages = is_array($images) ? $images : [];
        if (isset($updateImages[$photoIndex])) {
            @unlink(
                public_path($updateImages[$photoIndex])
            );
            array_splice($updateImages,$photoIndex,1);

        }
        $productVariant->images = $updateImages;
        $productVariant->save();
    }
}
