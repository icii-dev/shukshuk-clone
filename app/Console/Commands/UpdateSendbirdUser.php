<?php

namespace App\Console\Commands;

use App\Chat\ChatService;
use App\Dto\Sendbird\UpdateSendbirdUserDto;
use App\Model\Store;
use App\Model\User;
use Illuminate\Console\Command;

class UpdateSendbirdUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-sendbird-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all sendbird users, include: nickname & avatar.';

    /**
     * @var ChatService
     */
    private $chatService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ChatService $chatService)
    {
        parent::__construct();
        $this->chatService = $chatService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $limit = 50;
        $next = null;

        // Loop all Sendbird users and update nickname & avatar url
        do {
            $listUser = $this->chatService->getUsers($limit, $next);
            $next = $listUser->next;

            foreach ($listUser->users as $sendbirdUser) {
                // Update nickname & profile picture.

                if (strpos($sendbirdUser['user_id'], 'buyer-') !== false) {
                    $userId = str_replace('buyer-', '', $sendbirdUser['user_id']);

                    // Find user
                    if (!$user = User::find($userId)) {
                        continue;
                    }

                    $inputDto = new UpdateSendbirdUserDto();
                    $inputDto->nickname = $user->full_name;
                    $inputDto->profile_url = userImage($user->avatar);

                    $this->chatService->updateUser('buyer-' . $user->id, $inputDto);
                } elseif (strpos($sendbirdUser['user_id'], 'store-') !== false) {
                    $storeId = str_replace('store-', '', $sendbirdUser['user_id']);

                    // Find store
                    if (!$store = Store::find($storeId)) {
                        continue;
                    }

                    $inputDto = new UpdateSendbirdUserDto();
                    $inputDto->nickname = $store->name;
                    $inputDto->profile_url = getStoreAvatarUrl($store->avatar_image);

                    $this->chatService->updateUser('store-' . $store->id, $inputDto);
                } else {
                    // Unhandle this user
                }
            }
        } while ($next);
    }
}
