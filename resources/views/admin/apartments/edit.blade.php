@extends('layouts.admin')

@section('content')
    <section id="apartment-form" class="p-3 bg-container">
        <div class="container">
            <h4 class="text-center">Modifica le info del tuo appartamento </h4>

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
                            <label for="summary" class="form-label">Titolo descrittivo</label>
                            <span class="required">*</span>
                            <input type="text" class="form-control" id="summary" name="summary"
                                placeholder="Aggiungi un titolo descrittivo" value="{{ old('summary', $apartment->summary) }}" required minlength="15" maxlength="150">
                        </div>

                        <div class="row mt-4 ms-2">
                            <div class="form-check col-sm-12 col-lg-6 mb-3">
                                <input class="form-check-input" type="hidden" value="0" id="visible" name="visible">
                                <input class="form-check-input" type="checkbox" value="1" id="visible"
                                    name="visible" value="{{$apartment->visible}}" {{ $apartment->visible ? 'checked' : '' }}>
                                <label class="form-check-label yellow-label" for="visible">Spunta se vuoi nascondere l'appartamento</label>
                            </div>

                            <div class="mb-3">
                                <label for="services" class="form-label">Seleziona almeno un servizio</label>
                                <span class="required">*</span>
                                <div class="row">
                                    @foreach ($services as $service)
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <input type="checkbox" class="service_imput" id="service-{{$service->id}}" name="services[]" onclick="selectChecked()" value="{{ $service->id }}" {{ $apartment->services->contains($service->id) ? 'checked' : '' }}>
                                        {{ $service->name }}</input>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 col-lg-6">
                                <label for="cover_img" class="form-label">Immagine</label>
                                <input type="file" class="form-control" placeholder="Choose an cover_img" id="cover_img"
                                    name="Scegli un immagine" value="{{ old('cover_img', $apartment->cover_img) }}"
                                    accept="jpeg, jpg, png">
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label for="description" class="form-label">Descrizione</label>
                                <span class="required">*</span>
                                <textarea class="form-control" id="description" name="description" placeholder="Aggiungi una descrizione" required minlength="50" maxlength="255">{{ old('description', $apartment->description) }}</textarea>
                            </div>
                        </div>

                        <!-- <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="city" class="form-label">Città</label>
                                <span class="required">*</span>
                                <input class="form-control" id="city" name="city"
                                    value="{{ old('city', $apartment->city) }}" placeholder="Es: Roma"
                                    required minlength="4">
                            </div>
                        </div> -->


                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="address" class="form-label">address</label>
                                <span class="required">*</span>
                                <input class="form-control" id="address" name="address"
                                    value="{{ old('address', $apartment->address) }}" placeholder="Es: Viale Gaetano Arturo Crocco " required minlength="4" onkeyup="searchAddress()">
                                <div class="result" hidden></div>
                            </div>
                        </div>

                        <!-- <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="number" class="form-label">Numero</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="number" name="number"
                                    value="{{ old('number', $apartment->number) }}" placeholder="es: 129"
                                    required min="1">
                            </div>
                        </div>
                        -->



                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="rooms" class="form-label">Stanze</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="rooms" name="rooms"
                                    value="{{ old('rooms', $apartment->rooms) }}" placeholder="Numero di stanze es : 2" required min="1">
                            </div>

                            <div class=" col-sm-12 col-lg-6">
                                <label for="beds" class="form-label">Letti</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="beds" name="beds"
                                    value="{{ old('beds', $apartment->beds) }}" placeholder="Numero di letti es : 1" required min="1">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class=" col-sm-12 col-lg-6">
                                <label for="bathrooms" class="form-label">Bagni</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="bathrooms" name="bathrooms"
                                    value="{{ old('bathrooms', $apartment->bathrooms) }}"
                                    placeholder="Numero di bagni es : 1" required min="1">
                            </div>

                            <div class=" col-sm-12 col-lg-6">
                                <label for="square_meters" class="form-label">Metriquadri</label>
                                <span class="required">*</span>
                                <input type="number" class="form-control" id="square_meters" name="square_meters"
                                    value="{{ old('square_meters', $apartment->square_meters) }}"
                                    placeholder="Metriquadri es : 40 " required min="10" step="5">
                            </div>
                        </div>
                        {{-- Questo deve stare qui se no il form non funziona --}}
                        <button type="submit" class="btn btn-success mt-5 w-100">Modifica il tuo appartamento</button>
                    </form>



                </div>
            </div>
            <h5 class="text-center"><a href="{{ route('admin.apartments.index') }}" class="font-italic">Clicca qui per tornare alla tua dashboard</a></h5>

        </div>
    </section>
@endsection

@push('check')
<script>
    const array = []
    window.addEventListener('load', () => {
        document.querySelectorAll('.service_imput').forEach(item => {
            if(item.hasAttribute('checked')){
                array.push(item.value)
            }
        })
        console.log(array);
    })
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
