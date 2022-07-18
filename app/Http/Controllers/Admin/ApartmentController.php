<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\Service;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::where('user_id' , Auth::id())->orderByDesc('id')->get();
        return view ('admin.apartments.index', compact('apartments'));


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
    public function store(Request $request)
    {

        $request->validate([

            'summary' => 'required|string|min:15|max:150',
            'rooms' => 'required|numeric|min:1',
            'beds' => 'required|numeric|min:1',
            'bathrooms' => 'required|numeric|min:1',
            'square_meters' => 'required|numeric|min:9',
            'cover_img' => 'required|image|mimes:jpeg,jpg,png',
            'description' => 'required|min:50|max:255',
            'address' => 'required|string|min:4',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',

        ],
        [
            'required' => ':attribute is required',
            'numeric' => ':attribute should be a number',
            'summary.min' => 'Descriptive title must be longer than 15 characters',
            'summary.max' => 'Descriptive title should not exceed 150 characters',
            'rooms.min' => 'The apartment should have at least 1 room ',
            'cover_img.image' => 'The apartment image should be an image',
            'cover_img.mimes' => 'Image file format should be a .jpeg, .jpg or a .png',
            'beds:min' => 'The apartment should have at least 1 bed ',
            'bathrooms.min' => 'The apartment should have at least 1 bathroom ',
            'square_meters' => 'The apartment should be bigger than 9 meters ',
            'description.min' => 'Apartment description should be longer than 50 characters to increase attractiveness',
            'description.max' => 'Apartment description should not be longer than 255 characters ',
            'address.min' => 'adress attribute should be long at least 4 characters',

        ]);


   /*      $slug = Apartment::generateSlug($request->summary);
 */

        $data = $request->all();



        $data['user_id'] = Auth::id();
        $slug = Apartment::generateSlug($request->summary);
        $data['slug'] = $slug;
        $data['cover_img'] = Storage::put('storage', $request->cover_img);
        $newApartment = new Apartment();

        $newApartment->fill($data);
        $newApartment->save();


        $apartment = $newApartment;


        if(array_key_exists('services', $data)) $newApartment->services()->sync($data['services']);

        return redirect()->route('admin.apartments.show', compact('apartment'))->with('message','Appartamento Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        //
        return view('admin.apartments.show', compact('apartment'));
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
        $apartments = Apartment::where('user_id' , Auth::id());



        if(Auth::user()->id === $apartment->user_id) {
            return view('admin.apartments.edit',compact('apartment','services'));
        } else {
            return redirect()->route('admin.apartments.index')->with('message','access forbidden');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $id , Apartment $apartment )
    {
        $request->validate([

            'summary' => 'required|string|min:15|max:150',
            'rooms' => 'required|numeric|min:1',
            'beds' => 'required|numeric|min:1',
            'bathrooms' => 'required|numeric|min:1',
            'square_meters' => 'required|numeric|min:9',
            'cover_img' => 'image|mimes:jpeg,jpg,png',
            'description' => 'required|min:50|max:255',
            'address' => 'required|string|min:4',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',

        ],
        [
            'required' => ':attribute is required',
            'numeric' => ':attribute should be a number',
            'summary.min' => 'Descriptive title must be longer than 15 characters',
            'summary.max' => 'Descriptive title should not exceed 150 characters',
            'rooms.min' => 'The apartment should have at least 1 room ',
            'cover_img.image' => 'The apartment image should be an image',
            'cover_img.mimes' => 'Image file format should be a .jpeg, .jpg or a .png',
            'beds:min' => 'The apartment should have at least 1 bed ',
            'bathrooms.min' => 'The apartment should have at least 1 bathroom ',
            'square_meters' => 'The apartment should be bigger than 9 meters ',
            'description.min' => 'Apartment description should be longer than 50 characters to increase attractiveness',
            'description.max' => 'Apartment description should not be longer than 255 characters ',
            'address.min' => 'adress attribute should be long at least 4 characters',

        ]);
        
        $data['user_id'] = Auth::user()->id;
        $data = $request->all();

        if(array_key_exists('cover_img', $data)){

            $data['cover_img'] = Storage::put('storage', $request->cover_img);
        }

        $apartment->fill($data);

        $slug = Apartment::generateSlug($request->summary);
        $data['slug'] = $slug;
        $apartment->update($data);

        if(array_key_exists('services', $data)) $apartment->services()->sync($data['services']);

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
