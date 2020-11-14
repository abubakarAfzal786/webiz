<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $new_reviews = Review::query()->orderBy('created_at', 'DESC')->limit(5)->get();

        return view('home', compact('new_reviews'));
    }
}
