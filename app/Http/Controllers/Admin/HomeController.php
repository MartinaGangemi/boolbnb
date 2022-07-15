<?php

namespace App\Http\Controllers\Admin;
use App\Models\Apartment;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
    }
}
