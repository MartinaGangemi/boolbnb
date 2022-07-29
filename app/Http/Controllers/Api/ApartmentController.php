<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {

        $beds = $request->query('beds');
        $rooms = $request->query('rooms');
        $visible = $request->query('visible');

        $checkedServices = $request->query('checkedServices');
        if ($checkedServices == null) {
            $checkedServices = [];
        }

        $searchLat = $request->query('searchLat');
        $searchLon = $request->query('searchLon');
        $defaultDistance = $request->query('defaultDistance');
        $geometry = [
            [
                "type" => "CIRCLE",
                "position" => " $searchLat, $searchLon",
                "radius" => $defaultDistance
            ],
        ];
        $geometry_json = json_encode($geometry);
        $pointsOfInterest = [];

        $apartments = Apartment::with('services')->where('beds', '>=', $beds)->where('visible', 'visible==true', $visible)->where('rooms', '>=', $rooms)->whereHas('services', function ($query) use ($checkedServices) {
                $query->whereIn('id', $checkedServices);
            }, '=', count($checkedServices))->orderByDesc('id')->get();

        foreach ($apartments as $apartment) {
            $objectApartment = [
                'id' => $apartment->id,
                "position" => [
                    "lat" => $apartment->lat,
                    "lon" => $apartment->lon
                ]
            ];
            array_push($pointsOfInterest, $objectApartment);
        }

        $pointsOfInterestJson = json_encode($pointsOfInterest);
        //ddd($pointsOfInterestJson);
        $response = Http::get("https://api.tomtom.com/search/2/geometryFilter.json?key=oACbG3tI0HEQEXTTTBi1BjRveNyHAv75&geometryList=$geometry_json&poiList=$pointsOfInterestJson");
        //ddd($response);
        $results = $response->object()->results;

        $apartmentsFiltered = [];
        foreach ($apartments as $apartment) {
            foreach ($results as $result) {
                if ($result->id == $apartment->id) {

                    array_push($apartmentsFiltered, $apartment);
                }
            }
        };

        return $apartmentsFiltered;

    }

    public function show($id)
    {
        $apartment = Apartment::with('services')->where('id', $id)->first();
        if ($apartment) {
            return $apartment;
        } else {
            return response()->json([
                'status_code' => 404,
                'status_text' =>  'not found'
            ]);
        }
        return $apartment;
    }

    public function saveMessage(Request $request)
    {

        $apartment_id = $request->query('apartment_id');
        $fullname = $request->query('fullname');
        $email = $request->query('email');
        $description = $request->query('description');

        $newMessage = new Message;

        $newMessage->apartment_id = $apartment_id;
        $newMessage->fullname = $fullname;
        $newMessage->email = $email;
        $newMessage->description = $description;
        $newMessage->save();
        return 'Messaggio inviato correttamente';
    }
}
