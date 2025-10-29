<?php

namespace App\Domain\Dashboard\Entities;

class DashboardUserEntity
{
    public $totalRentals;
    public $ongoing;
    public $overdue;
    public $returned;

    public function __construct($totalRentals, $ongoing, $overdue, $returned)
    {
        $this->totalRentals = $totalRentals;
        $this->ongoing = $ongoing;
        $this->overdue = $overdue;
        $this->returned = $returned;
    }
}
