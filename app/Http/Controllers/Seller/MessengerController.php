<?php

namespace App\Http\Controllers\Seller;

use App\Chat\ChatService;
use App\Chat\SendBird;
use App\Model\User;
use App\Service\StoreService;
use Illuminate\Http\Request;
use App\Http\Controllers\SellerController;

class MessengerController extends SellerController
{
    public function index()
    {
        return view('seller.messenger.index');
    }

    public function initChatWithBuyer($buyerId, SendBird $sendBird, ChatService $chatService, StoreService $storeService)
    {
        // Create buyer chat account - if not exist
        /** @var User $user */
        $user = auth()->user();
        $storeId = $user->store->id;
        $buyerChatId = 'buyer-' . $buyerId;
        $buyer = User::where('id', $buyerId)->first();

        $userChatBuyer = $chatService->createUserIfNoExist($buyerChatId, [
            'nickname' => $user->full_name,
            'profile_url' =>  userImage($buyer->avatar),
        ]);

        // Create store chat account - if not exist
        $storeChatId = 'store-' . $storeId;
        $userChatStore = $chatService->getUser($storeChatId);

        if (!$userChatStore) {
            if (!$store = $storeService->getPublishedById($storeId)) {
                return redirect()->route('seller.messenger.index');
            }

            try {
                $userChatStore = $chatService->createUser($storeChatId, [
                    'nickname' => $store->name,
                    'profile_url' => getStoreAvatarUrl($store->avatar_image)
                ]);
            } catch (\Exception $exception) {

            }
        }

        // Create group chat
        $groupData = [
            'channel_url' => $buyerChatId . '-' . $storeChatId,
            'user_id' => $buyerChatId,
            'is_distinct' => true,
            'is_public' => false,
            'user_ids' => [$buyerChatId, $storeChatId],
        ];

        $chatService->createGroup($groupData);

        // Go to messenger page
        return redirect()->route('seller.messenger.index');
    }

}
