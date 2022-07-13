@extends('layouts.admin')

@section('content')
<div class="container">
    
    

    <div class="card-body text-center">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <h3>Benvenuto  {{ Auth::user()->name }}</h3>
       
    </div>
     
</div>
@endsection

