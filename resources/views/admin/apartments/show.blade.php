@extends('layouts.admin')

@section('content')
<div class="apartment-img mt-0">
    <img src="{{ asset('storage/' . $apartment->cover_img) }}" alt="">
</div>
<div class="container mt-5">
    @if (session('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    
    
    <div class="card">
    <h3 class="text-uppercase  text-center p-4">{{ $apartment->summary }}</h3>
        <div class="col-6">

        </div>
        <div class="col-6">
            
        </div>
        <div class="card-body">
            <p>{{ $apartment->description }}</p>


            <div class="d-flex pb-4 gap-2">
                <div class="col-6 ">
                    <strong><i class="fa-solid fa-map-location"></i> Indirizzo : </strong><br><span>{{ $apartment->city }}
                        {{ $apartment->address }} {{ $apartment->number }}</span><br>
                    <strong><i class="fa-solid fa-door-closed"></i> Stanze : </strong><br><span>{{ $apartment->rooms }}</span><br>
                    <strong><i class="fa-solid fa-bed"></i> Letti : </strong><br><span>{{ $apartment->beds }}</span><br>

                </div>

                <div class="col-6">
                    <strong><i class="fa-solid fa-toilet"></i> Bagni : </strong><br><span>{{ $apartment->bathrooms }}</span><br>
                    <strong><i class="fa-solid fa-ruler-combined"></i> Metri quadri :
                    </strong><br><span>{{ $apartment->square_meters }}</span><br>
                    <strong>
                        <i class="fa-solid fa-list"></i>  Servizi : </strong><br>

                        @foreach ($services as $service)

                            <span class="p-1"> {{ $service->name }} </span>


                        @endforeach

                </div>


            </div>

            <div class="d-flex">

                <div class="text-center w-100 mb-1">

                    <a class="btn p-custom btn-customs text-white" id="message-trigger"
                        href="{{ route('admin.messages.index', $apartment->slug) }}">Vai ai Messagi</a>
                </div>
                <div class="text-center  w-100">
                    <a class="btn p-custom btn-primary text-white" id="message-trigger"
                    href="{{ route('admin.sponsorships.index', $apartment->slug) }}">Sponsorizza</a>

                </div>

            </div>

        </div>
    </div>



</div>
@endsection


<style>

.p-custom{
    width: 130px !important;
}

</style>
