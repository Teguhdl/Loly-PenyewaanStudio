<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user','virtualWorld'])->orderBy('start_date','desc')->get();
        return view('admin.rental.index', compact('rentals'));
    }
}
