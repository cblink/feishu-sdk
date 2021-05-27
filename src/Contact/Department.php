<?php

namespace Cblink\FeiShu\Contact;

use Cblink\FeiShu\Client;

class Department extends Client
{
    public function add(array $departmentInfo, $user_id_type = '', $department_id_type = '', $client_token = '')
    {
        return $this->httpPostJson('/contact/v3/departments', $departmentInfo + array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
            'client_token' => $client_token,
        ]));
    }
    
    public function getList($user_id_type = '', $department_id_type = '', $parent_department_id = '', $fetch_child = '', $page_token = '', $page_size = 10)
    {
        return $this->httpGet('/contact/v3/departments', array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
            'parent_department_id' => $parent_department_id,
            'fetch_child' => $fetch_child,
            'page_token' => $page_token,
            'page_size' => $page_size,
        ]));
    }

    public function getInfo($department_id, $user_id_type = '', $department_id_type = '')
    {
        return $this->httpGet(sprintf('/contact/v3/departments/%s', $department_id), array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
        ]));
    }

    public function getParentDepartmentInfo($department_id, $user_id_type = '', $department_id_type = '', $page_token = '', $page_size = 10)
    {
        return $this->httpGet('/contact/v3/departments/parent', array_filter([
            'department_id' => $department_id,
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
            'page_token' => $page_token,
            'page_size' => $page_size,
        ]));
    }

    public function searchDepartments($query, $user_id_type = '', $department_id_type = '', $page_token = '', $page_size = 10)
    {
        return $this->httpGet('/contact/v3/departments/search', array_filter([
            'query' => $query,
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
            'page_token' => $page_token,
            'page_size' => $page_size,
        ]));
    }

    public function updatePartInfo($department_id, $departmentInfo, $user_id_type = '', $department_id_type = '')
    {
        return $this->request(sprintf('/contact/v3/departments/%s', $department_id), 'PATCH', $departmentInfo + array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
        ]));
    }

    public function updateInfo($department_id, $departmentInfo, $user_id_type = '', $department_id_type = '')
    {
        return $this->request(sprintf('/contact/v3/departments/%s', $department_id), 'PUT', $departmentInfo + array_filter([
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
        ]));
    }

    public function removeUser($department_id, $receives = [], $user_id_type = '', $department_id_type = '')
    {
        return $this->request(sprintf('/contact/v3/users/%s', $department_id), 'DELETE', $receives + [
            'user_id_type' => $user_id_type,
            'department_id_type' => $department_id_type,
        ]);
    }
}