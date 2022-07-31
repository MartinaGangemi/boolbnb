<?php

namespace App\Http\Controllers\Api;

use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SponsorshipResource;
use App\Models\Apartment;

class SponsorshipController extends Controller
{
    public function index(Request $request){
        $sponsorship = Sponsorship::all();

        return view('admin.sponsorships.index', compact('sponsorship'));
    }
}
