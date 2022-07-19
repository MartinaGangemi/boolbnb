<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index (){
        $apartments = Apartment::with('services')->orderByDesc('id')->paginate(8);
    
        return $apartments;
    }

    public function show($slug) {
        $apartment = Apartment::with('services')->where('slug', $slug )->first();
        if($apartment){
            return $apartment;
        }else{
           return response()->json([
            'status_code' => 404,
            'status_text' =>  'not found'
           ]) ;
        }
        return $apartment;
    }
}
