<?php

namespace App\Domain\Rentals\Entities;

class RentalEntity
{
    public $id;
    public $user_id;
    public $virtual_world_id;
    public $start_date;
    public $end_date;
    public $status;
    public $is_returned;
    public $total_penalty;
    public $payment_status;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
