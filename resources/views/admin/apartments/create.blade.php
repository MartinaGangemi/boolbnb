@extends('layouts.admin')

@section('content')
    <section id="apartment-form" class="p-3 bg-container">
        <div class="container">
            <h4 class="text-center">Inserisci le informazioni del tuo appartamento</h4>

            <div class="create-edit-wrapper p-3">
                <div class="container create-container">
                    {{-- error handler --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- form for appartment creation --}}
                    <form class="p-2 my_form" action="{{ route('admin.apartments.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- title --}}
                        <div>
                            <label for="summary" class="form-label">Titolo descrittivo</label>
                            <span class="required">*</span>
                            <input type="text" class="form-control" id="summary" name="summary"
                                placeholder="Aggiungi Titolo descrittivo" value="{{ old('summary', $newApartment->summary) }}" required
                                minlength="15" maxlength="150">
                        </div>
                        {{-- visibility --}}
                        <div class="row mt-4 ms-2">
                            <div class="form-check col-sm-12 col-lg-6 mb-3">
                                <input class="form-check-input" type="hidden" value="0" id="visible" name="visible">
                                <input class="form-check-input" type="checkbox" value="1" id="visible"
                                    name="visible">
                                <label class="form-check-label yellow-label" for="visible">Spunta se vuoi nascondere l'appartamento</label>
                            </div>
                            {{-- services --}}
                          <!--chechbox services-->
                            <div class="mb-3">
                                <label for="services" class="form-label">Seleziona almeno un servizio</label>
                                <span class="required">*</span>
                                <div class="row">
                                    @foreach ($services as $service)
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <input type="checkbox" class="service_imput" id="{{$service->id}}" name="services[]" onclick="selectChecked()" required value="{{ $service->id }}" {{ is_array(old('services')) && in_array($service->id, old('services')) ? 'checked' : '' }}>
                                        {{ $service->name }}</input>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- cover image --}}
                        <div class="row mt-3">
                            <div class="col-sm-12 col-lg-6">
                                <label for="cover_img" class="form-label">Immagine</label>
                                <span class="required">*</span>
                                <input type="file" class="form-control" placeholder="Scegli un immagine" id="cover_img"
                                    name="cover_img" value="{{ old('cover_img', $newApartment->cover_img) }}" required
                                    accept="jpeg, jpg, png">
                            </div>
                            {{-- description --}}
                            <div class="col-sm-12 col-lg-6">
                                <label for="description" class="form-label">Descizione</label>
                                <span class="required">*</span>
                                <textarea class="form-control" id="description" name="description" placeholder="Aggiungi una descrizione" required
                                    minlength="50" maxlength="255">{{ old('description', $newApartment->description) }}</textarea>
                            </div>
                        </div>
                        {{-- address --}}



                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="address" class="form-label">Indirizzo</label>
                                <span class="required">*</span>
                                <input class="form-control" id="address" name="address"
                                    value="{{ old('address', $newApartment->address) }}" placeholder="Es: Viale Gaetano Arturo Crocco " required minlength="4" onkeyup="searchAddress()">
                                <div class="result" hidden></div>
                            </div>
                        </div>




                        {{-- rooms --}}
                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="rooms" class="form-label">Stanze</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="rooms" name="rooms"
                                    value="{{ old('rooms', $newApartment->rooms) }}" placeholder="Numero di stanze es : 2"
                                    required min="1">
                            </div>
                            {{-- beds --}}
                            <div class=" col-sm-12 col-lg-6">
                                <label for="beds" class="form-label">Letti</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="beds" name="beds"
                                    value="{{ old('beds', $newApartment->beds) }}" placeholder="Numero di letti es : 1"
                                    required min="1">
                            </div>
                        </div>
                        {{-- bathrooms --}}
                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="bathrooms" class="form-label">Bagni</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="bathrooms" name="bathrooms"
                                    value="{{ old('bathrooms', $newApartment->bathrooms) }}"
                                    placeholder="Numero di bagni es : 1" required min="1">
                            </div>
                            {{-- square_mt --}}
                            <div class=" col-sm-12 col-lg-6">
                                <label for="square_meters" class="form-label">Metriquadri</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="square_meters" name="square_meters"
                                    value="{{ old('square_meters', $newApartment->square_meters) }}"
                                    placeholder="Metriquadri es : 40 " required min="10" step="5">
                            </div>
                        </div>
                        {{-- Questo deve stare qui se no il form non funziona --}}
                        <button type="submit" class="btn btn-success mt-5 w-100">Aggiungi il tuo appartamento</button>
                    </form>



                </div>
            </div>
            <h5 class="text-center"><a href="{{ route('admin.apartments.index') }}" class="font-italic">Clicca qui per tornare alla tua dashboard.</a></h5>

        </div>
    </section>
    @endsection




    @push('check')
    <script>
        const array = []
        function selectChecked() {
            const input = event.target
            input.setAttribute('checked', 'checked')
            if (array.includes(input.value)) {
                const index = array.indexOf(input.value)
                array.splice(index, 1)
                input.removeAttribute('checked')
            } else {
                array.push(input.value)
            }
            if (array.length > 0) {
                document.querySelectorAll('.service_imput').forEach(item => {
                    item.removeAttribute('required')
                })
            } else {
                document.querySelectorAll('.service_imput').forEach(item => {
                    item.setAttribute('required', 'required')
                })
            }
        }
    </script>
    @endpush
