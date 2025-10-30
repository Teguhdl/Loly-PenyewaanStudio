<?php
namespace App\Domain\Categories\Entities;

class CategoryEntity
{
    public int $id;
    public string $name;
    public $avatar;
    public ?string $description;
}
