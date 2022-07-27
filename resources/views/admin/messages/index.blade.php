@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            @foreach ($messages as $message)
                <div class="col">
                    <div class="card text-start mb-4 p-3">
                        <h4>Appartamento: {{ $apartmentName }}</h4>
                        <div class="card-body">
                            <h5 class="card-title">Da: {{ $message->fullname }}</h5>
                            <address class="card-text">Email: {{ $message->email }}</address>
                            <p>{{ $message->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
