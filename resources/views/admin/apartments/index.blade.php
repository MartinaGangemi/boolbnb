@extends('layouts.admin')

@section('content')


<div class="container">

@foreach($apartments as $apartment)
{{$apartment->summary}}
@endforeach
</div>
@endsection