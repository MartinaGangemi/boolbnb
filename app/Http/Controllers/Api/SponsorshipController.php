<?php

namespace App\Http\Controllers\Api;

use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SponsorshipResource;

class SponsorshipController extends Controller
{
    public function index(Request $request){
        $sponsorship = Sponsorship::all();

        return SponsorshipResource::collection($sponsorship);
    }
}
