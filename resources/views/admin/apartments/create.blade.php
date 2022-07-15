@extends('layouts.admin')

@section('content')
    <section id="apartment-form" class="p-3 bg-container">
        <div class="container">
            <h4 class="text-center">Insert your apartment's info.</h4>

            <div class="create-edit-wrapper p-3">
                <div class="container create-container">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="p-2 my_form" action="{{route('admin.apartments.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="summary" class="form-label">Title</label>
                            <input type="text" class="form-control" id="summary" name="summary" placeholder="Add a summary" value="{{old('summary', $newApartment->summary)}}">
                        </div>

                        <div class="row mt-4 ms-2">
                            <div class="form-check col-sm-12 col-lg-6 mb-3">
                                <input class="form-check-input" type="hidden" value="0" id="visible" name="visible">
                                <input class="form-check-input" type="checkbox" value="1" id="visible" name="visible">
                                <label class="form-check-label yellow-label" for="visible">Check this if you want your apartment to be visibile</label>
                            </div>

                            <div class="form-group col-sm-12 col-lg-6">
                                <div class="dropdown">

                                    <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Choose your services
                                    </button>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <button class="my_button dropdown-item" type="button">
                                            @foreach ($services as $service)
                                                <div>
                                                    <input type="checkbox" class="form-check-input" id="{{ $service->id }}" value="{{$service->id}}" name="services[]"
                                                        @if(in_array($service->id, old('services', []))) checked @endif>
                                                    <label class="form-check-label" for="{{$service->id}}">{{$service->name}}</label>
                                                </div>
                                            @endforeach
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 col-lg-6">
                                <label for="cover_img" class="form-label">Image</label>
                                <input type="file" class="form-control" placeholder="Choose an cover_img" id="cover_img" name="cover_img" value="{{old('cover_img', $newApartment->cover_img)}}">
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Add a description">{{old('description', $newApartment->description)}}</textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="address" class="form-label">address</label>
                                <input class="form-control" id="address" name="address" value="{{old('address',  $newApartment->address)}}" placeholder="Choose a address">
                            </div>


                                <div class=" col-sm-12 col-lg-6">
                                    <label for="lat" class="form-label">lat</label>
                                    <input class="form-control" id="lat" name="lat" value="{{old('lat',  $newApartment->lat)}}" placeholder="Choose a lat">
                                </div>



                              <div class=" col-sm-12 col-lg-6">
                                        <label for="lon" class="form-label">lon</label>
                                        <input class="form-control" id="lon" name="lon" value="{{old('lon',  $newApartment->lon)}}" placeholder="Choose a lon">
                              </div>



                        </div>



                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="rooms" class="form-label">Rooms</label>
                                <input type="text" class="form-control" id="rooms" name="rooms" value="{{old('rooms', $newApartment->rooms)}}" placeholder="Add your rooms' number">
                            </div>

                            <div class=" col-sm-12 col-lg-6">
                                <label for="beds" class="form-label">Beds</label>
                                <input type="text" class="form-control" id="beds" name="beds" value="{{old('beds', $newApartment->beds)}}" placeholder="Add your beds' number">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="bathrooms" class="form-label">Bathrooms</label>
                                <input type="text" class="form-control" id="bathrooms" name="bathrooms" value="{{old('bathrooms', $newApartment->bathrooms)}}" placeholder="Add your bathrooms' number">
                            </div>

                            <div class=" col-sm-12 col-lg-6">
                                <label for="square_meters" class="form-label">Square Meters</label>
                                <input type="text" class="form-control" id="square_meters" name="square_meters" value="{{old('square_meters', $newApartment->square_meters)}}" placeholder="Add your square meters number">
                            </div>
                        </div>
                        {{-- Questo deve stare qui se no il form non funziona --}}
                        <button type="submit" class="btn btn-success mt-5 w-100" >Add your new apartment</button>
                    </form>



                </div>
            </div>
            <h5 class="text-center"><a href="{{ route('admin.apartments.index') }}" class="font-italic">Click here to go back to your apartments.</a></h5>

        </div>
    </section>
@endsection
