<?php

namespace App\Domain\Users\Entities;

class UserProfileEntity
{
    public $id;
    public $user_id;
    public $address;
    public $phone;
    public $avatar;

    public function __construct($id, $user_id, $address, $phone, $avatar)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->address = $address;
        $this->phone = $phone;
        $this->avatar = $avatar;
    }
}
