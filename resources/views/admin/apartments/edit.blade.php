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

                    <form class="p-2 my_form" action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method ('patch')


                        <div>
                            <label for="summary" class="form-label">Title</label>
                            <span class="required">*</span>
                            <input type="text" class="form-control" id="summary" name="summary"
                                placeholder="Add a summary" value="{{ old('summary', $apartment->summary) }}" required minlength="15" maxlength="150">
                        </div>

                        <div class="row mt-4 ms-2">
                            <div class="form-check col-sm-12 col-lg-6 mb-3">
                                <input class="form-check-input" type="hidden" value="0" id="visible" name="visible">
                                <input class="form-check-input" type="checkbox" value="1" id="visible"
                                    name="visible">
                                <label class="form-check-label yellow-label" for="visible">Check this if you want your
                                    apartment to be visibile</label>
                            </div>

                            <div class="form-group col-sm-12 col-lg-6">
                                <div class="dropdown">

                                    <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenu2"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Choose your services
                                    </button>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <button class="my_button dropdown-item" type="button">
                                            @foreach ($services as $service)
                                                <div>
                                                    <input type="checkbox" class="form-check-input"
                                                        id="{{ $service->id }}" value="{{ $service->id }}"
                                                        name="services[]" @if ($apartment->services->contains($service->id)) checked @endif>
                                                    <label class="form-check-label"
                                                        for="{{ $service->id }}">{{ $service->name }}</label>
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
                                <input type="file" class="form-control" placeholder="Choose an cover_img" id="cover_img"
                                    name="cover_img" value="{{ old('cover_img', $apartment->cover_img) }}"
                                    accept="jpeg, jpg, png">
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label for="description" class="form-label">Description</label>
                                <span class="required">*</span>
                                <textarea class="form-control" id="description" name="description" placeholder="Add a description" required minlength="50" maxlength="255">{{ old('description', $apartment->description) }}</textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="address" class="form-label">address</label>
                                <span class="required">*</span>
                                <input class="form-control" id="address" name="address"
                                    value="{{ old('address', $apartment->address) }}" placeholder="Choose a address" required minlength="4">
                            </div>


                            <div class=" col-sm-12 col-lg-6">
                                <label for="lat" class="form-label">lat</label>
                                <span class="required">*</span>
                                <input class="form-control" id="lat" name="lat"
                                    value="{{ old('lat', $apartment->lat) }}" placeholder="Choose a lat" required>
                            </div>



                            <div class=" col-sm-12 col-lg-6">
                                <label for="lon" class="form-label">lon</label>
                                <span class="required">*</span>
                                <input class="form-control" id="lon" name="lon"
                                    value="{{ old('lon', $apartment->lon) }}" placeholder="Choose a lon" required>
                            </div>



                        </div>



                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="rooms" class="form-label">Rooms</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="rooms" name="rooms"
                                    value="{{ old('rooms', $apartment->rooms) }}" placeholder="Add your rooms' number" required min="1">
                            </div>

                            <div class=" col-sm-12 col-lg-6">
                                <label for="beds" class="form-label">Beds</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="beds" name="beds"
                                    value="{{ old('beds', $apartment->beds) }}" placeholder="Add your beds' number" required min="1">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="bathrooms" class="form-label">Bathrooms</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="bathrooms" name="bathrooms"
                                    value="{{ old('bathrooms', $apartment->bathrooms) }}"
                                    placeholder="Add your bathrooms' number" required min="1">
                            </div>

                            <div class=" col-sm-12 col-lg-6">
                                <label for="square_meters" class="form-label">Square Meters</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="square_meters" name="square_meters"
                                    value="{{ old('square_meters', $apartment->square_meters) }}"
                                    placeholder="Add your square meters number" required min="10" step="5">
                            </div>
                        </div>
                        {{-- Questo deve stare qui se no il form non funziona --}}
                        <button type="submit" class="btn btn-success mt-5 w-100">Edit your apartment</button>
                    </form>



                </div>
            </div>
            <h5 class="text-center"><a href="{{ route('admin.apartments.index') }}" class="font-italic">Click here to
                    go back to your apartments.</a></h5>

        </div>
    </section>
@endsection
