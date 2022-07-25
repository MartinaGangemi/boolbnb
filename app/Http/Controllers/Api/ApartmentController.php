<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index (Request $request){
        
        $beds = $request->query('beds');
        $rooms = $request->query('rooms');


        $apartments = Apartment::with('services')->where('beds', '>=', $beds)->where('rooms', '>=', $rooms)->orderByDesc('id')->paginate(8);

        return $apartments;
    }

    public function show($id) {
        $apartment = Apartment::with('services')->where('id', $id )->first();
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
