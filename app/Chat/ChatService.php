<?php


namespace App\Chat;


use App\Chat\Dto\ListUserDto;
use App\Dto\Sendbird\UpdateSendbirdUserDto;

class ChatService
{
    /**
     * @var SendBird
     */
    private $sendBird;

    public function __construct(SendBird $sendBird)
    {
        $this->sendBird = $sendBird;
    }

    public function getUser($userId)
    {
        $response = $this->sendBird->get(sprintf('users/%s', $userId));

        $body = json_decode($response->getBody()->getContents(), true);

        if (isset($body['error'])) {
            return null;
        }

        return $body;
    }

    public function getUsers($limit = 50, $next = null): ListUserDto
    {

        $response = $this->sendBird->get(
            'users?limit=' . $limit . '&token=' . $next
        );

        $body = json_decode($response->getBody()->getContents(), true);

        if (isset($body['error'])) {
            $listUserDto = new ListUserDto();

            return $listUserDto;
        }

        $listUserDto = new ListUserDto();
        $listUserDto->users = $body['users'];
        $listUserDto->next = $body['next'];

        return $listUserDto;
    }

    public function createUser($userId, $data)
    {
        $data['user_id'] = $userId;

        $response = $this->sendBird->post('users', $data);

        $user = json_encode($response->getBody()->getContents());

        if (isset($user['error'])) {
            throw new \Exception($user['message']);
        }

        return $user;
    }

    public function updateUser($sendbirdUserId, UpdateSendbirdUserDto $inputDto)
    {
        $data = (array) $inputDto;

        $response = $this->sendBird->put('users/' . $sendbirdUserId, $data);

        $user = json_encode($response->getBody()->getContents());


        return $user;
    }

    public function createUserIfNoExist($userId, $data)
    {
        $user = $this->getUser($userId);

        if (!$user) {
            $data['user_id'] = $userId;

            $response = $this->sendBird->post('users', $data);

            $user = json_encode($response->getBody()->getContents());

            if (isset($user['error'])) {
                throw new \Exception($user['message']);
            }
        }

        return $user;
    }

    public function createGroup($data)
    {
        $response = $this->sendBird->post('group_channels', $data);

        $group = json_encode($response->getBody()->getContents());

        if (isset($user['error'])) {
            throw new \Exception($group['message']);
        }

        return $group;
    }
}
