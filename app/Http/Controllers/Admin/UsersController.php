<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Buyer\UpdateUserRequest;
use App\Service\UserService;
use App\Http\Controllers\Controller;
use http\Client\Curl\User;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class UsersController extends VoyagerBaseController
{
    /*
     * update put request
     */
    public function updateInfo(UpdateUserRequest $request, UserService $userService)
    {
        $user = auth()->user();

        $userService->update($user, $request);

        return back()->with('success_message', 'Profile updated successfully!');
    }
}
