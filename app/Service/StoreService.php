<?php

namespace App\Service;

use App\Events\StoreUpdated;
use App\Model\Bank;
use App\Model\Category;
use App\Model\Store;
use App\Model\Seller;
use App\Model\StoreAddress;
use App\Model\StoreBalance;
use App\Model\StoreRejectCause;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Pagination\Paginator;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StoreService
{
    public function getPublishedByIds(array $ids)
    {
        return Store::published()
            ->find($ids);
    }

    public function getPublishedById($id)
    {
        return store::
        published()
            ->where('id', '=', $id)
            ->first();
    }

    /**
     * @param $slug
     * @return Store|null
     */
    public function getPublishedBySlug($slug)
    {
        return Store::where('slug', 'like', $slug)
            ->where('status', '=', Store::STATUS_ACTIVE)
            ->first();
    }

    public function getListPublishedByTypeId($type)
    {
        return Store::where('type', $type)
            ->where('status', '=', Store::STATUS_ACTIVE)
            ->get();
    }

    public function getListPublishedPagedByType($type, $page = 1, $limit = 9)
    {

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $builder = Store::where('type', '=', $type)
            ->where('status', '=', Store::STATUS_ACTIVE)
            ->orderBy('rating');


        // Implement sort

        // Implement search / filter

        // Return
        return $builder->paginate($limit);
    }

    public function getPending()
    {
        $stores = Store::where('status', Store::STATUS_WAITING_APPROVAL)->get();
        return $stores;
    }

    public function create(Seller $seller, FormRequest $input)
    {
        $store = new Store();

        $store->fill(
            $input->only(
                $store->getFillable()
            )
        );
        $store->slug = toSlug($store->name);
        $store->seller_id = $seller->id;
        $store->user_id = $seller->user->id;

        $store->status = Store::STATUS_DRAFT;
        $store->save();

        event(new StoreUpdated($store));

        $store->balance()->save(new StoreBalance(['total' => 0]));

        if ($input->file('proof_image_upload')) {
            $this->updateProofImages($store, [$input->file('proof_image_upload')]);
        }

        if ($input->file('avatar_image_upload')) {
            $this->updateAvatarImage($store, $input->file('avatar_image_upload'));
        }

        //update address
        $this->createAddress(
            $store->id,
            [
                'province_id' => $input['province'],
                'regency_id' => $input['city'],
                'district_id' => $input['district'],
                'address' => $input['address']
            ]
        );
        return $store;
    }

    public function createAndPublish(Seller $seller, FormRequest $input)
    {
        $store = $this->create($seller, $input);

        $this->publish($store);

        return $store;
    }

    public function update(Store $store, FormRequest $input)
    {
        $store->fill(
            $input->only(
                $store->getFillable()
            )
        );


        // Update payment methods
        if ($paymentMethodIds = $input->get('payment_method_ids')) {
            // Detach all
            $store->paymentMethods()->sync($paymentMethodIds);
        }

        // Update cover image
        if ($input->file('proof_image_upload')) {
            $this->updateProofImages($store, [$input->file('proof_image_upload')]);
        }

        // Update avatar image
        if ($input->file('avatar_image_upload')) {
            $this->updateAvatarImage($store, $input->file('avatar_image_upload'));
        }

        // Update status
        $isClosed = $input->get('is_closed', null);
        if ($isClosed !== null &&
            ($store->status == Store::STATUS_ACTIVE || $store->status == Store::STATUS_DEACTIVE)
        ) {
            $store->status = $isClosed ? Store::STATUS_ACTIVE : Store::STATUS_DEACTIVE;
        }


        if($input->phone){
            $store->seller->phone = $input->phone;
            $store->seller->save();
        }

        $store->save();

        event(new StoreUpdated($store));

        //update address
        $this->createAddress(
            $store->id,
            [
                'province_id' => $input['province'],
                'regency_id' => $input['city'],
                'district_id' => $input['district'],
                'address' => $input['address']
            ]
        );

        return $store;
    }

    public function updateAndPublish(Store $store, FormRequest $input)
    {
        $this->update($store, $input);

        $this->publish($store);

        return $store;
    }

    public function updateStatusTo(Store $store, $status)
    {
        $store->status = $status;
        $store->save();

        event(new StoreUpdated($store));
    }

    public function publish(Store $store)
    {
        $store->status = Store::STATUS_ACTIVE;
        $store->save();

        event(new StoreUpdated($store));
    }

    public function updateCoverImage(Store $store, UploadedFile $image)
    {
        // Save image
        $fileName = md5(uniqid($store->id) . time()) . '.' . $image->getClientOriginalExtension();

        $image->move(
            public_path('img/store-cover/'),
            $fileName
        );

        // Remove old image.
        if ($store->cover_image) {
            @unlink(public_path('img/store-cover/' . $store->cover_image));
        }

        // Save new image.
        $store->cover_image = $fileName;

        $store->save();

        event(new StoreUpdated($store));
    }

    public function updateProofImages(Store $store, $inputImages)
    {
        $images = [];

        foreach ($inputImages as $image) {
            // Save image
            $fileName = md5(uniqid($store->id) . time()) . '.' . $image->getClientOriginalExtension();

            $image->move(
                public_path('img/store-cover/'),
                $fileName
            );

            // Remove old image.
            if ($store->cover_image) {
                @unlink(public_path('img/store-cover/' . $store->cover_image));
            }

            array_push($images, $fileName);
        }


        // Save new image.
        $store->proof_images = $images;

        $store->save();

        event(new StoreUpdated($store));
    }

    public function updateAvatarImage(Store $store, UploadedFile $image)
    {
        // Save image
        $fileName = md5(uniqid($store->id) . time()) . '.' . $image->getClientOriginalExtension();

        $image->move(
            public_path('img/store-avatar/'),
            $fileName
        );

        // Remove old image.
        if ($store->avatar_image) {
            @unlink(public_path('img/store-avatar/' . $store->avatar_image));
        }

        // Save new image.
        $store->avatar_image = $fileName;

        $store->save();

        event(new StoreUpdated($store));
    }

    public function updateAvatarImageFromBase64(Store $store, $base64Image)
    {
        $image = Image::make($base64Image);

        $extension = 'png';

        $fileName = md5(uniqid($store->id) . time()) . '.' . $extension;

        $image->save(
            public_path('img/store-avatar/' . $fileName)
        );

        if ($store->avatar_image) {
            @unlink(public_path('img/store-avatar/' . $store->avatar_image));
        }

        $store->avatar_image = $fileName;

        $store->save();

        event(new StoreUpdated($store));
    }

    public function updateCoverImageFromBase64(Store $store, $base64Image)
    {
        $image = Image::make($base64Image);

        $extension = 'png';

        $fileName = md5(uniqid($store->id) . time()) . '.' . $extension;

        $image->save(
            public_path('img/store-cover/' . $fileName)
        );

        if ($store->cover_image) {
            @unlink(public_path('img/store-cover/' . $store->cover_image));
        }

        $store->cover_image = $fileName;
        $store->save();

        event(new StoreUpdated($store));
    }

    public function getIndustryId($slugType)
    {
        switch ($slugType) {
            case "individual":
                $storeType = Store::TYPE_INDIVIDUAL;
                break;
            case "ngo":
                $storeType = Store::TYPE_NGO;
                break;
            case "Small Medium Enterprise":
                $storeType = Store::TYPE_SMALL_MEDIUM_ENTERPRISE;
                break;
            case "big-company":
                $storeType = Store::TYPE_BIG_COMPANIES;
                break;
            default:
                $storeType = Store::TYPE_INDIVIDUAL;
        }
        return $storeType;
    }

    public function getListStoreBySlugType($slugType, $page = 1, $limit = 9)
    {
        $storeType = $this->getIndustryId($slugType);
        return $stores = Store::where('type', $storeType)
            ->published()
            ->paginate($limit);
    }

    public function getListStoreBySlugTypeAndCatAndRating($slugType, Category $category, $rating, $page = 1, $limit = 9)
    {
        $storeType = $this->getIndustryId($slugType);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        return $stores = $category
            ->stores()
            ->where('rating', ">", $rating)
            ->where('type', $storeType)
            ->published()
            ->paginate($limit);
    }


    public function setStatus(Store $store, $input)
    {
        if ($input->status == Store::STATUS_DEACTIVE) {
            $store->status = Store::STATUS_DEACTIVE;
            $store->save();
            $reject = new StoreRejectCause();
            $reject->message = ($input->code_reason) ? $input->code_reason
                : $input->message;
            $store->rejectCause()->save($reject);
        } elseif ($input->status == Store::STATUS_ACTIVE) {
            $store->status = Store::STATUS_ACTIVE;
            $store->save();
        }
        event(new StoreUpdated($store));
    }

    public function createAddress($storeId, $arryaIdAddress = array())
    {
        StoreAddress::updateOrCreate(
            ['store_id' => $storeId],
            [
                'province_id' => $arryaIdAddress['province_id'],
                'regency_id' => $arryaIdAddress['regency_id'],
                'district_id' => $arryaIdAddress['district_id'],
                'address' => $arryaIdAddress['address']
            ]
        );
    }

    public function createBank($store, $arrayBankInfo = array())
    {
        $bank = \App\Model\Bank::create([
            'name' => $arrayBankInfo['bank_name'],
            'bank_code' => $arrayBankInfo['bank_code'],
            'account_number' => $arrayBankInfo['account_number'],
            'account_holder_name' => $arrayBankInfo['account_holder_name'],
        ]);

        $store->banks()->save($bank);
    }

    public function delete(Store $store){

        $products = $store->products;
        foreach ($products as $product){
            $productService = new ProductService();
            $productService->deleteProduct($product);
        }

        $orders = $store->orders;
        foreach ($orders as $order){
            $order->delete();
        }

        $store->balance()->delete();

        $ava = public_path('img/store-avatar/' . $store->avatar_image);
        if(\File::exists($ava)){
            \File::delete($ava);
        }

        if($store->proof_images){
            foreach ($store->proof_images as $proof_image){
                $proof_image = public_path('img/store-cover/'. $proof_image);
                dd($proof_image);
            }
        }

        $cover_image = public_path('img/store-cover/' . $store->cover_image);
        if(\File::exists($cover_image)){
            \File::delete($cover_image);
        }

        $store->delete();
    }

    public function isBankOfStore(Store $store, $bank_id){
        return $store->banks()->where('id', '=', $bank_id)->count()>0;
    }

    public function get3StoresOfParentCategory($catID){
        $categories = app('App\Service\CategoryService')->getCategories3LevelsOfParent($catID);
        $categoryArr = [];
        flatCategoryList($categories, 1, $categoryArr);

        $categoryArrID = array_column($categoryArr, 'id');

        $stores = Store::whereIn('category_id', $categoryArrID)
            ->published()
            ->take(3)
            ->inRandomOrder()
            ->get();
        return $stores;
    }

    public function getFeaturedStores(){
        return Store::where('featured', Store::FEATURED_ON)->published()->inRandomOrder()->take(5)->get();
    }
}
