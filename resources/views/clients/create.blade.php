<x-auth-validation-errors :errors="$errors" class="mb-4"></x-auth-validation-errors>
<form action="{{ route("clients.store") }}" method="post">
    @csrf
    <!-- Name -->
    <div class="row">
        <div class="col-6 mb-3">
            <x-label :value="__('Codigo')" for="cod">
            </x-label>
            <x-input :value="old('cod')" autofocus="" class="block mt-1 w-full" id="cod" name="cod" required="" type="text">
            </x-input>
        </div>
        <div class="col-6 mb-3">
            <x-label :value="__('Nombre')" for="name">
            </x-label>
            <x-input :value="old('name')" autofocus="" class="block mt-1 w-full" id="name" name="name" required="" type="text">
            </x-input>
        </div>
        <div class="col-6 mb-3">
            <x-label :value="__('Ciudad')" for="city_id">
            </x-label>
            <select class="custom-select" name="city_id">
                @foreach ($cities as $city)
                    <option value="{{$city->id}}" {{$city->id == old('city_id')?"selected":""}}>{{$city->cod}} - {{$city->name}}</option>
                @endforeach

            </select>
        </div>
        
    </div>
    <div class="flex items-center justify-center mt-4">
        <x-button class="ml-4">
            {{ __('Actualizar') }}
        </x-button>
    </div>
</form>
