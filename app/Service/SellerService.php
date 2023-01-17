<?php

namespace App\Service;

use App\Http\Requests\Sellder\RegistrationStep1Request;
use App\Model\Seller;
use App\Model\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Foundation\Http\FormRequest;

class SellerService
{
    public function getPublishedById($id)
    {
        Seller::published()
            ->where('id', '=', $id)
            ->first();
    }

    public function create(User $user, FormRequest $input)
    {
        $seller = new Seller();

        $seller->fill(
            $input->only(
                $seller->getFillable()
            )
        );
        $seller->user_id = $user->id;
        $seller->status = Seller::STATUS_DRAFT;
        $seller->save();

        if (($image = $input->file('proof_image_upload'))) {
            $this->addProofImage($seller, $image);
        }

        return $seller;
    }

    public function update(Seller $seller, FormRequest $input)
    {
        $seller->fill(
            $input->only(
                $seller->getFillable()
            )
        );

        $seller->save();

        if (($image = $input->file('proof_image_upload'))) {
            $this->addProofImage($seller, $image);
        }

        return $seller;
    }

    public function addProofImage(Seller $seller, UploadedFile $image)
    {
        // Save image
        $fileName = md5(uniqid($seller->id) . time()) . '.' . $image->getClientOriginalExtension();

        $image->move(
            public_path(SELLER_PATH),
            $fileName
        );

        // Remove old image.
        if ($seller->proof_image && file_exists(public_path('img/seller/' . $seller->proof_image))) {
            @unlink(public_path(SELLER_PATH.'/' . $seller->proof_image));
        }

        // Save new image.
        $seller->proof_image = $fileName;

        $seller->save();
    }
}
