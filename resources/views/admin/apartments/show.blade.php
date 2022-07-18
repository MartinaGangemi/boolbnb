@extends('layouts.admin')

@section('content')
<div class="container">
    @if(session('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>

    @endif
    <h3>{{$apartment->summary}}</h3>
    <div class="card">
        <img src="{{ asset('storage/' . $apartment->cover_img) }}" alt="">
        <div class="card-body">
            <p>{{$apartment->description}}</p>
            <address>{{$apartment->address}}</address>
            <strong>Rooms: </strong><span>{{$apartment->rooms}}</span><br>
            <strong>Beds: </strong><span>{{$apartment->beds}}</span><br>
            <strong>Bathrooms: </strong><span>{{$apartment->bathrooms}}</span><br>
            <strong>Square Meters: </strong><span>{{$apartment->square_meters}}</span><br>
            <cite>{{$apartment->slug}}</cite>
        </div>
    </div>
</div>
@endsection
