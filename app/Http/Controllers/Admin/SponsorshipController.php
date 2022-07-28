<?php

namespace App\Http\Controllers\Admin;
use Braintree;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderRequest;
use App\Http\Resources\SponsorshipResource;
use App\Models\Apartment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Braintree\Gateway;

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

    public function checkout(OrderRequest $request, Apartment $apartment, Sponsorship $sponsorship, Gateway $gateway)
    {   

        
           
    
       return redirect()->route('admin.apartments.show', compact('apartment'))->with('message', 'Il pagamento e andato a buon fine. Il tuo annuncio verra sponsorizzato per' );
    }
}


