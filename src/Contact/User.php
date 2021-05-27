<?php

namespace Cblink\FeiShu\Contact;

use Cblink\FeiShu\Client;

class User extends Client
{
    public function add(array $userInfo, $user_id_type = '', $department_id_type = '', $client_token = '')
    {
        return $this->httpPostJson('/contact/v3/users', $userInfo + array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
            'client_token' => $client_token,
        ]));
    }
    
    public function getList($user_id_type = '', $department_id = '', $department_id_type = '', $page_token = '', $page_size = 10)
    {
        return $this->httpGet('/contact/v3/users', array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
            'department_id' => $department_id,
            'page_token' => $page_token,
            'page_size' => $page_size,
        ]));
    }

    public function getInfo($user_id, $user_id_type = '', $department_id_type = '')
    {
        return $this->httpGet(sprintf('/contact/v3/users/%s', $user_id), array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
        ]));
    }

    public function updatePartInfo($user_id, $userInfo, $user_id_type = '', $department_id_type = '')
    {
        return $this->request(sprintf('/contact/v3/users/%s', $user_id), 'PATCH', $userInfo + array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
        ]));
    }

    public function updateInfo($user_id, $userInfo, $user_id_type = '', $department_id_type = '')
    {
        return $this->request(sprintf('/contact/v3/users/%s', $user_id), 'PUT', $userInfo + array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
        ]));
    }

    public function removeUser($user_id, $receives = [], $user_id_type = '')
    {
        return $this->request(sprintf('/contact/v3/users/%s', $user_id), 'DELETE', $receives + [
            'user_id_type' => $user_id_type,
        ]);
    }
}