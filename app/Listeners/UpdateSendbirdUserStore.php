<?php

namespace App\Listeners;

use App\Chat\ChatService;
use App\Dto\Sendbird\UpdateSendbirdUserDto;
use App\Events\StoreUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateSendbirdUserStore
{
    /**
     * @var ChatService
     */
    private $chatService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Handle the event.
     *
     * @param  StoreUpdated  $event
     * @return void
     */
    public function handle(StoreUpdated $event)
    {
        // Check config
        if (!env('SENDBIRD_APPLICATION_ID') || !env('SENDBIRD_API_TOKEN')) {
            return;
        }

        $store = $event->getStore();

        $changes = $store->getChanges();

        if (isset($changes['name']) || isset($changes['avatar_image'])) {
            $inputDto = new UpdateSendbirdUserDto();
            $inputDto->nickname = $store->name;
            $inputDto->profile_url = getStoreAvatarUrl($store->avatar_image);

            $this->chatService->updateUser('store-' . $store->id, $inputDto);
        }
    }
}
