<?php

namespace App\Service;

use App\Events\UserUpdated;
use App\Http\Requests\Buyer\UpdateUserRequest;
use App\Model\User;
use ErrorException;

class UserService
{
    /*
     * update user
     */
    function update(User $user, UpdateUserRequest $request)
    {
        if ($request['date_of_birth']) {
            $request['date_of_birth'] = date("Y-m-d", strtotime($request['date_of_birth']));
        }

        //save avatar
        try {
            if ($request->file('avatar')) {
                $this->uploadAvatar($request, $user);
            }
        } catch (ErrorException $e) {
            return back()->with('error_message', $e->getMessage());
        }
        //save password
        if ($request->filled('password')) {
            $request['password'] = bcrypt($request['password']);
        } else {
            $request->offsetUnset('password');
        }

        $user->fill(
            $request->only(
                $user->getFillable()
            )
        );
        $user->save();

        event(new UserUpdated($user));
    }

    /**
     * Update user avatar
     *
     * @param $request
     * @param $user
     * @return bool
     * @throws ErrorException
     */
    function uploadAvatar($request, $user)
    {
        $request->validate(['avatar' => 'required|mimes:jpg,jpeg,png|max:5120']);
        if ($request->file('avatar')) {
            $fileExtension = $request->file('avatar')->getClientOriginalExtension();

            $fileName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999)) . "." . $fileExtension;

            $uploadPath = public_path('/storage/user'); // Thư mục upload

            $request->file('avatar')->move($uploadPath, $fileName);
            $user->avatar = 'user/' . $fileName;
            $user->save();

            event(new UserUpdated($user));

            return true;
        } else {
            // Lỗi file
            throw new ErrorException('The image failed to upload.');
        }
    }

    //save user address
    function saveAddress()
    {

    }
}
