@extends('layouts.app')
@section('content')
   
    <div class="content">
        <div class="wrapper">
            <div class="checkout container text-center">
               
            <h1>Hi, <br>Let's test a transaction</h1>
                <p>
                    Make a test payment with Braintree using PayPal or a card
                </p>
                {{-- form --}}
                <form method="post" id="payment-form"
                    action="{{ route('admin.sponsorships.checkout', [$apartment->id, $sponsorship->id]) }}">
                    @csrf
                    <section>
                        <label  for="amount">
                            <div class="input-wrapper amount-wrapper pb-3">
                                <span class="input-label">Stai acquistando il piano{{$sponsorship->name}} a</span>
                                <input style="max-width:50px" id="amount" name="amount" type="tel" min="1"
                                    placeholder="{{ $sponsorship->price }} €" value="{{ $sponsorship->price }}" readonly>
                            </div>
                        </label>
                        @if (session('message'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="bt-drop-in-wrapper">
                            <div id="bt-dropin"></div>
                        </div>
                    </section>

                    <input id="nonce" name="payment_method_nonce"  type="hidden"/>
                    <button class="button btn btn-primary text-white" type="submit"><span>Acquista
                        Sponsorizzazione</span></button>
                </form>
            </div>
        </div>
    </div>
  
    <script src="https://js.braintreegateway.com/web/dropin/1.33.2/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "{{ $token }}";
        let Button = document.getElementById('button');
        console.log(braintree);
        braintree.dropin.create({
            authorization: client_token,
            selector: '#bt-dropin',
            /* paypal: {
                flow: 'vault'
            } */
        }, function(createErr, instance) {
            console.log(instance);
            if (createErr) {
                console.log('Create Error', createErr);
                return;
            }
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                instance.requestPaymentMethod(function(err, payload) {
                    console.log(payload);
                    if (err) {
                        console.log('funzione');
                        console.log('Request Payment Method Error', err);
                        return;
                    }
                    // Add the nonce to the form and submit
                    document.querySelector('#nonce').value = payload.nonce;
                    form.submit();
                    Button.classList.add('NotVisible');
                });
            });
        });
    </script>
@endsection