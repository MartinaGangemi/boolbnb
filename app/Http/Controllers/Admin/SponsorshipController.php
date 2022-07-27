<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SponsorshipResource;
use App\Models\Apartment;

class SponsorshipController extends Controller
{
    public function index(Apartment $apartment){
        $sponsorships = Sponsorship::all();
        
        return view('admin.sponsorships.index', compact('sponsorships', 'apartment'));
    }

    public function show(Apartment $apartment, Sponsorship $sponsorship)
    {
       
        return view('admin.sponsorships.show', compact('apartment','sponsorship'));
    }
}
