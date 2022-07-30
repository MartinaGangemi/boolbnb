<?php

namespace App\Http\Controllers\Admin;
use Braintree;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use Carbon\Carbon;


class SponsorshipController extends Controller
{
    public function select(Apartment $apartment){
        $sponsorships = Sponsorship::all();
        
        return view('admin.sponsorships.index', compact('sponsorships', 'apartment'));
    }

    public function take(Apartment $apartment, Sponsorship $sponsorship)
    {
        $gateway = new Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $token = $gateway->ClientToken()->generate();
        //dd($sponsorship, $apartment, $token);
       
        return view('admin.sponsorships.show', compact('apartment','sponsorship','token'));
        
    }


    public function checkout(Request $request, Apartment $apartment, Sponsorship $sponsorship)
    {   
        $gateway = new Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $amount = $request->amount;
        $nonce = $request->payment_method_nonce;

       
        //dd($resultCustomer->customer->id);
        
        $result =  $gateway->transaction()->sale([
            'paymentMethodNonce' => $nonce,
            'amount' => $amount,
            'options' => [
                'submitForSettlement' => true,
            ]
        ]);

       if($result->success){
       
        //dd($result);
        return redirect()->route('admin.apartments.index')->with('message', "Sponsorizzazione di \"$apartment->summary\" avvenuta con successo");
       }else{
        return redirect()->back()->with('message', "Transazione fallita! Si prega di riprovare");
    }
    }
}

       
 





