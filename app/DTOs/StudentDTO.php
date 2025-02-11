<?php

namespace App\DTOs;

class StudentDTO
{
    public $id;
    public $uuid;
    public $department_id;
    public $study_plan_id;
    public $created_at;
    public $updated_at;
    public $group_id;
    public $sub_group_id;
    public $user_id;
    public $username;
    public $email;
    public $first_name;
    public $last_name;
    public $phone;
    public $gender;
    public $is_active;
    public $role_id;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->uuid = $data['uuid'];
        $this->department_id = $data['department_id'];
        $this->study_plan_id = $data['study_plan_id'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->group_id = $data['group_id'];
        $this->sub_group_id = $data['sub_group_id'];
        $this->user_id = $data['user_id'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->phone = $data['phone'];
        $this->gender = $data['gender'];
        $this->is_active = $data['is_active'];
        $this->role_id = $data['role_id'];
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}
