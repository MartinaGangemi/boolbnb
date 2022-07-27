@extends('layouts.admin')
@section('content')

<!-- pagamento -->
<h2 class="mt-5">Sponsorizza il tuo appartamento</h2>
        <div class="row row-cols-3 g-3 ">
            @foreach($sponsorships as $sponsorship)
            <div class="col">
                <div class="card p-2">
                    <h4 class="mb-0 filter_text py-2 px-1 text-center text-uppercase">Piano: {{$sponsorship->name}}</h4>
                    <div class="card-body">
                    <p><strong>Descrizione: </strong>Il tuo annuncio verra' sponsorizzato e messo in evidenza</p>
                    <p><strong>Prezzo: </strong>{{$sponsorship->price}} €</p>
                    <p class="mb-0"><strong>Durata: </strong>{{$sponsorship->duration}} ore</p>
                    <a class="btn btn-primary btn-sm mt-2 " href="{{route('admin.sponsorships.show',[ $apartment->id ,'sponsorship' => $sponsorship->id])}}" role="button">Acquista </a>
                    </div>
                    
                </div>
            </div>
            
            @endforeach

            
        </div>

        @endsection