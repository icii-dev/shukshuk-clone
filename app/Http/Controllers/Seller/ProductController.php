<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\SellerController;
use App\Http\Requests\ProductVariant\CreateProductVariantsRequest;
use App\Http\Requests\Seller\ProductCreateRequest;
use App\Http\Requests\Seller\ProductUpdateRequest;
use App\Model\ProductVariant;
use App\Service\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends SellerController
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(
        ProductService $productService
    ) {
        $this->productService = $productService;
    }

    public function index()
    {
        $this->seo()->setTitle('List product');

        $page = request()->get('page', 1);
        $store = auth()->user()->store;

        $pagedProduct = $this->productService->getPagedProductOfStore($store, $page, 25);
        return view('seller.product.index', [
            'pagedProduct' => $pagedProduct
        ]);
    }

    public function create()
    {
        $this->seo()->setTitle('Add Product Details');

        return view('seller.product.create');
    }

    public function store(ProductCreateRequest $request)
    {
        $store = auth()->user()->store;

        $product = $this->productService->createProduct($store, $request);

        return redirect()->route('seller.product.create_product_variants', ['id' => $product->id])
            ->with('Product created successfully');
    }

    public function createProductVariant($id)
    {
        $store = auth()->user()->store;

        if (!$store || !($product = $this->productService->getByIdOfStore($store, $id))) {
            abort(404);
        }

        // Build variants
        $directionalVariants = [];
        if ($product->options->count() === 1) {
            $option = $product->options[0];
            $incrementer = 1;
            foreach ($option->values as $index => $value) {
                $directionalVariants[] = [
                    'id'            => -1 * $incrementer++,
                    'options' => [$value->id],
                    'option_1'      => [
                        'option_id'         => $option->id,
                        'option_name'       => $option->name,
                        'option_value_id'   => $value->id,
                        'option_value_name' => $value->name
                    ]
                ];
            }
        } elseif ($product->options->count() === 2) {
            $option1 = $product->options[0];
            $option2 = $product->options[1];

            $incrementer = 1;

            foreach ($option1->values as $index1 => $value1) {
                foreach ($option2->values as $index2 => $value2) {
                    $directionalVariants[] = [
                        'id'            => -1 * $incrementer++,
                        'options' => [$value1->id, $value2->id],
                        'option_1'      => [
                            'option_id'         => $option1->id,
                            'option_name'       => $option1->name,
                            'option_value_id'   => $value1->id,
                            'option_value_name' => $value1->name
                        ],
                        'option_2'      => [
                            'option_id'         => $option2->id,
                            'option_name'       => $option2->name,
                            'option_value_id'   => $value2->id,
                            'option_value_name' => $value2->name
                        ]
                    ];
                }
            }
        } else {
            $directionalVariants[] = [
                'id'            => -1,
                'options' => [],
            ];
        }

        // Bind data: find model variant & map to corresponding list direction variants
        foreach ($directionalVariants as &$directionalVariant) {
            foreach ($product->variants as $variantModel) {
                $variantModelOptionValues = [];
                $variantModel->option_1 ? ($variantModelOptionValues[] = $variantModel->option_1) : null;
                $variantModel->option_2 ? ($variantModelOptionValues[] = $variantModel->option_2) : null;

                if (empty(array_diff($directionalVariant['options'], $variantModelOptionValues))) {
                    $directionalVariant['id'] = $variantModel['id'];
                    $directionalVariant['model'] = $variantModel;
                    break;
                }
            }
        }

        return view('seller.product.create_product_variant', [
            'product'  => $product,
            'variants' => $directionalVariants
        ]);
    }

    public function storeProductVariant(
        $id,
        Request $request,
        CreateProductVariantsRequest $createProductVariantsRequest,
        ProductService $productService
    ) {
        $store = auth()->user()->store;
        if (!$store || !($product = $this->productService->getByIdOfStore($store, $id))) {
            abort(404);
        }
        $photoRemoves = $createProductVariantsRequest->isRemovePhotos;
        foreach ($photoRemoves as $idVariant=>$photos){
            foreach ($photos as $index=>$isRemove){
                if($isRemove){
                    $productService->removePhoto($idVariant, $index);
                }
            }
        }
        $productService->saveProductVariants($product, $createProductVariantsRequest);

        return redirect()->route('seller.product.index')
            ->with('Product saved successfully');
    }

//    public function removePhoto(
//        $id,
//        Request $request,
//        ProductService $productService
//    ){
//        $store = auth()->user()->store;
//        $product = $this->productService->getByIdOfStore($store, $id);
//        if (!$store || !($product)) {
//            return response(
//                [
//                    "success" => false,
//                    "message" => "not found product"
//                ],
//                403
//            );
//        }
//
//        $productVariant = ProductVariant::find($request->variantId);
//
//        //check variant
//        if(!$productVariant || $productVariant->product_id != $product->id){
//            return response(
//                [
//                    "success" => false,
//                    "message" => "not found the variant"
//                    ],
//              403
//            );
//        }
//        $productService->removePhoto($productVariant, $request->photoIndex);
//        return response(
//            [
//                "success" => true
//            ],
//            200
//        );
//    }

    public function edit($id)
    {
        $store = auth()->user()->store;

        $product = $this->productService->getByIdOfStore($store, $id);

        if (!$product) {
            abort(404, 'The product does not exist.');
        }

        $inputOptions = [];

        foreach ($product->options as $k => $option) {
            $inputOptions[$k]['id'] = $option->id;
            $inputOptions[$k]['name'] = $option->name;

            foreach ($option->values as $value) {
                $inputOptions[$k]['values'][] = [
                    'id'   => $value->id,
                    'name' => $value->name
                ];
            }
            //in case, option no have values
            if(!isset($inputOptions[$k]['values'])){
                $inputOptions[$k]['values'][] = [
                    'id'   => 0,
                    'name' => ''
                ];
            }
        }
        // Place holder for initialOptions
        for ($i = count($inputOptions); $i <= 2 - count($inputOptions); ++$i) {
            $inputOptions[] = [
                'id'     => -1 * $i,
                'name'   => '',
                'values' => [
                    [
                        'id'   => 0,
                        'name' => ''
                    ],
                ]
            ];
        }

        $this->seo()->setTitle('Edit product');

        return view('seller.product.edit', [
            'product'      => $product,
            'inputOptions' => $inputOptions
        ]);
    }

    public function update($id, ProductUpdateRequest $request)
    {
//        return $request;
        $store = auth()->user()->store;

        $product = $this->productService->getByIdOfStore($store, $id);

        $validator = Validator::make(
            $request->all()
            , [
            'name' => [
                'required',
                Rule::unique('products', 'name')->ignore($product->id),
            ],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!$product) {
            abort(404, 'The product does not exist.');
        }

        $this->productService->updateProduct($product, $request);

        return redirect()->route('seller.product.create_product_variants', ['id' => $product->id])
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $store = auth()->user()->store;

        $product = $this->productService->getByIdOfStore($store, $id);

        if (!$product) {
            abort(404, 'The product does not exist.');
        }

        $this->productService->delete($product);

        return back()->with('success', 'The product deleted successfully');
    }
}
