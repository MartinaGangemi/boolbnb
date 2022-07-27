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
                <strong><i class="fa-solid fa-map-location"></i> Address : </strong><span>{{ $apartment->city }}
                    {{ $apartment->address }} {{ $apartment->number }}</span><br>
                <strong><i class="fa-solid fa-door-closed"></i> Rooms : </strong><span>{{ $apartment->rooms }}</span><br>
                <strong><i class="fa-solid fa-bed"></i> Beds : </strong><span>{{ $apartment->beds }}</span><br>
                <strong><i class="fa-solid fa-toilet"></i> Bathrooms : </strong><span>{{ $apartment->bathrooms }}</span><br>
                <strong><i class="fa-solid fa-ruler-combined"></i> Square Meters :
                </strong><span>{{ $apartment->square_meters }}</span><br>
                <a class="btn btn-sm btn-primary text-white" id="message-trigger"
                    href="{{ route('admin.messages.index', $apartment->slug) }}">View Messages</a>
            </div>
        </div>
    </div>
@endsection
