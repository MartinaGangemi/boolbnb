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

      
        
        $result = $gateway->transaction()->sale([
            'amount' => $sponsorship->price,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if($result->success){
            if(empty($apartment->sponsorships->all())){
                $today = date_create(date("Y-m-d H:i:s",));
                $start = date_create(date("Y-m-d H:i:s"));
                $stop = date_add($today, date_interval_create_from_date_string("$sponsorship->duration Hours"));
                $apartment->sponsorships()->attach($sponsorship->id, ['sponsorship_start' => $start, 'sponsorship_end' => $stop]); 
            }else {
                $data = date("Y-m-d H:i:s");
                foreach ($apartment->sponsorships as $item) {
                    if ($item->sponsor->sponsorship_end > $data) {
                        $data = $item->sponsor->sponsorship_end;
                    }
                }
            $today = date_create($data);
            $start = date_create($data);
            $stop = date_add($today, date_interval_create_from_date_string("$sponsorship->duration Hours"));
            $apartment->sponsorships()->attach($sponsorship->id, ['sponsorship_start' => $start, 'sponsorship_end' => $stop]);
            }
        }else{
            return redirect()->route('admin.apartments.index')->with('message', "Transazione fallita.");
        }
        return redirect()->route('admin.apartments.index')->with('message', "Sponsorizzazione di \"$apartment->summary\" avvenuta con successo");
    }
}

       
 



