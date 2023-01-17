<?php

namespace App\Http\Controllers\Buyer;

use App\Chat\ChatService;
use App\Chat\SendBird;
use App\Model\Menu;
use App\Model\Page;
use App\Http\Controllers\Controller;
use App\Model\MenuItem;
use App\Service\StoreService;

class MessengerController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $this->seo()->setTitle(
            trans('messenger.title', [])
        );

        $this->seo()->setDescription(
            trans('messenger.description', [])
        );
        if(is_mobile()){
            return view('buyer.mobile.messenger');
        }
        return view('buyer.messenger');
    }

    public function initChatWithStore($storeId, SendBird $sendBird, ChatService $chatService, StoreService $storeService)
    {
        // Create buyer chat account - if not exist
        /** @var User $user */
        $user = auth()->user();

        $buyerChatId = 'buyer-' . $user->id;

        $userChatBuyer = $chatService->createUserIfNoExist($buyerChatId, [
            'nickname' => $user->full_name,
            'profile_url' =>  userImage($user->avatar),
        ]);

        // Create store chat account - if not exist
        $storeChatId = 'store-' . $storeId;
        $userChatStore = $chatService->getUser($storeChatId);

        if (!$userChatStore) {
            if (!$store = $storeService->getPublishedById($storeId)) {
                return redirect()->route('buyer.messenger.index');
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
        return redirect()->route('buyer.messenger.index');
    }

}
