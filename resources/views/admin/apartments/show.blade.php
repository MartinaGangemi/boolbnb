@extends('layouts.admin')

@section('content')
    <div class="container">
        @if (session('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <h3>{{ $apartment->summary }}</h3>
        <div class="card">

            <img src="{{ asset('storage/' . $apartment->cover_img) }}" alt="">
            <div class="card-body">
                <p>{{ $apartment->description }}</p>

                <div class="d-flex pb-4 gap-2">
                    <div class="col-6 ">
                        <strong><i class="fa-solid fa-map-location"></i> Address : </strong><br><span>{{ $apartment->city }}
                            {{ $apartment->address }} {{ $apartment->number }}</span><br>
                        <strong><i class="fa-solid fa-door-closed"></i> Rooms : </strong><br><span>{{ $apartment->rooms }}</span><br>
                        <strong><i class="fa-solid fa-bed"></i> Beds : </strong><br><span>{{ $apartment->beds }}</span><br>

                    </div>

                    <div class="col-6">
                        <strong><i class="fa-solid fa-toilet"></i> Bathrooms : </strong><br><span>{{ $apartment->bathrooms }}</span><br>
                        <strong><i class="fa-solid fa-ruler-combined"></i> Square Meters :
                        </strong><br><span>{{ $apartment->square_meters }}</span><br>
                        <strong>
                            <i class="fa-solid fa-list"></i>  Servizi : </strong><br>

                            @foreach ($services as $service)

                                <span class="p-1"> {{ $service->name }} </span>


                            @endforeach

                    </div>


                </div>
                <div class="text-center">

                    <a class="btn btn-sm btn-customs text-white" id="message-trigger"
                        href="{{ route('admin.messages.index', $apartment->slug) }}">View Messages</a>
                </div>
            </div>
        </div>



    </div>
@endsection
