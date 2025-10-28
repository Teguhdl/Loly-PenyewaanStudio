<?php
namespace App\Domain\Categories\Entities;

class CategoryEntity
{
    public int $id;
    public string $name;
    public ?string $description;
}
