<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\Service;
use App\User;
use Illuminate\Validation\Rule;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ApartmentRequest;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::where('user_id', Auth::id())->orderByDesc('id')->get();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $newApartment = new Apartment();

        $services = Service::all();

        return view('admin.apartments.create', compact('newApartment', 'services',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentRequest $request)
    {
        // Validazione dati-->controlla ApartmentRequest
        $data = $request->validated();
        //dd($data);

        //$apiQuery =  str_replace(' ', '-', $data['city']) . '-' .  str_replace(' ', '-', $data['address']) . '-' .  str_replace(' ', '-', $data['number']) ;
        //$response = file_get_contents('https://api.tomtom.com/search/2/geocode/' . $apiQuery . '.json?key=Jpqe16Wf8nfHE1cJGvGsx04P06GgVcIT');
        $apiQuery = str_replace(' ', '-', $data['address']);
        $response = file_get_contents('https://api.tomtom.com/search/2/geocode/' . $apiQuery . '.json?key=Jpqe16Wf8nfHE1cJGvGsx04P06GgVcIT');
        $response = json_decode($response);


        $data['lat'] = $response->results[0]->position->lat;
        $data['lon'] = $response->results[0]->position->lon;
        $currentId = Apartment::orderBy('id', 'desc')->first()->id + 1;
        $data['user_id'] = Auth::id();
        $slug = Apartment::generateSlug($request->summary ).'-'.Auth::id().'-'.$currentId ;
        $data['slug'] = $slug;
        $data['cover_img'] = Storage::put('storage', $request->cover_img);
        $newApartment = new Apartment();

        $newApartment->fill($data);
        $newApartment->save();

        $apartment = $newApartment;

        if (array_key_exists('services', $data)) {
            $newApartment->services()->sync($data['services']);
        }

        return redirect()->route('admin.apartments.show', compact('apartment'))->with('message', 'Appartamento Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $services =  $apartment['services'];
        $sponsorships = Sponsorship::all();
        return view('admin.apartments.show', compact('apartment','sponsorships','services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::all();
        $apartments = Apartment::where('user_id', Auth::id());



        if (Auth::user()->id === $apartment->user_id) {
            return view('admin.apartments.edit', compact('apartment', 'services'));
        } else {
            return redirect()->route('admin.apartments.index')->with('message', 'access forbidden');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(ApartmentRequest $request, User $id, Apartment $apartment)
    {


        // Validazione dati-->controlla ApartmentRequest
        $data = $request->validated();
        //dd($data);

        $data['user_id'] = Auth::user()->id;
        $data = $request->all();



        $apiQuery =str_replace(' ', '-', $data['address']);
        $response = file_get_contents('https://api.tomtom.com/search/2/geocode/' . $apiQuery . '.json?key=Jpqe16Wf8nfHE1cJGvGsx04P06GgVcIT');
        $response = json_decode($response);


        $data['lat'] = $response->results[0]->position->lat;
        $data['lon'] = $response->results[0]->position->lon;
        if (array_key_exists('cover_img', $data)) {
            $data['cover_img'] = Storage::put('storage', $request->cover_img);
        }


        $apartment->fill($data);
        $currentId = Apartment::orderBy('id', 'desc')->first()->id + 1;
        $slug = Apartment::generateSlug($request->summary ).'-'.Auth::id().'-'.$currentId ;
        $data['slug'] = $slug;
        $apartment->update($data);

        if (array_key_exists('services', $data)) {
            $apartment->services()->sync($data['services']);
        }

        return redirect()->route('admin.apartments.show', compact('apartment'))->with('message','Appartamento Modificato');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        Storage::delete($apartment->cover_img);
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('message', 'Il tuo appartamento è stato eliminato!');
    }
}
