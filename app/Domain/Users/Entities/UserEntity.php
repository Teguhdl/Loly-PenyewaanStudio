<?php

namespace App\Domain\Users\Entities;

class UserEntity
{
    public $id;
    public $name;
    public $email;
    public $role;
    public $password;

    public function __construct($id, $name, $email, $role, $password = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
    }
}
