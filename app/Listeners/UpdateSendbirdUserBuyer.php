<?php

namespace App\Listeners;

use App\Chat\ChatService;
use App\Dto\Sendbird\UpdateSendbirdUserDto;
use App\Events\UserUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateSendbirdUserBuyer
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
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        // Check config
        if (!env('SENDBIRD_APPLICATION_ID') || !env('SENDBIRD_API_TOKEN')) {
            return;
        }

        $user = $event->getUser();

        $changes = $user->getChanges();

        if (isset($changes['name']) || isset($changes['last_name']) || isset($changes['avatar'])) {
            $inputDto = new UpdateSendbirdUserDto();
            $inputDto->nickname = $user->full_name;
            $inputDto->profile_url = userImage($user->avatar);

            $this->chatService->updateUser('buyer-' . $user->id, $inputDto);
        }
    }
}
