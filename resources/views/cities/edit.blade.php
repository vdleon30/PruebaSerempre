<x-auth-validation-errors :errors="$errors" class="mb-4"></x-auth-validation-errors>
<form action="{{ route("cities.update",$city->id) }}" method="post">
    @csrf
    @method("PUT")
    <!-- Name -->
    <div class="row">
        <div class="col-6">
            <x-label :value="__('Codigo')" for="cod">
            </x-label>
            <x-input :value="$city->cod" autofocus="" class="block mt-1 w-full" id="cod" name="cod" required="" type="text">
            </x-input>
        </div>
        <div class="col-6">
            <x-label :value="__('Nombre')" for="name">
            </x-label>
            <x-input :value="$city->name" autofocus="" class="block mt-1 w-full" id="name" name="name" required="" type="text">
            </x-input>
        </div>
        
    </div>
    <div class="flex items-center justify-center mt-4">
        <x-button class="ml-4">
            {{ __('Actualizar') }}
        </x-button>
    </div>
</form>
