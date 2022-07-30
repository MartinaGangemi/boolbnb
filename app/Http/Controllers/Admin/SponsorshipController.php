<?php

namespace App\Http\Controllers\Admin;
use Braintree;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use Braintree\Gateway;
use Illuminate\Support\Carbon;

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
        //dd($publicity, $apartment, $token);
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

        $resultCustomer = $gateway->customer()->create([
            'email' => Auth::user()->email,
        ]);
        //dd($resultCustomer->customer->id);
        $customerId = $resultCustomer->customer->id;

        $resultCreate = $gateway->paymentMethod()->create([
            'customerId' => $customerId,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'verifyCard' => true,
            ]
        ]);

        dd($resultCreate);

        if ($resultCreate->success) {
            $result = $gateway->transaction()->sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);

            
            return redirect()->route('admin.apartments.index')->with('message', "Sponsorizzazione di \"$apartment->title\" avvenuta con successo");
            } else {
            return redirect()->route('admin.apartments.index')->with('message', "Transazione fallita.");
            }
       
    }
}

       
 



