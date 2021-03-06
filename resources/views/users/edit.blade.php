<!-- Validation Errors -->
<style type="text/css">
    .edit_profile {
        position: absolute;
        display: inline-flex;
        right: 45%;
        border-radius: 50rem;
        height: 1.7rem;
        width: 1.7rem;
    }
</style>
<x-auth-validation-errors :errors="$errors" class="mb-4"></x-auth-validation-errors>
<form action="{{ route("users.update",$user->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <input name="_method" type="hidden" value="PUT">
    <!-- Name -->
    <div class="row">
        <div class="form-group col-sm-12 text-center">
            <input accept=".png,.jpg,.jpeg" hidden="" id="file_input" name="img" type="file" value="">
                <span class="pointer badge badge-primary badge-pill edit_profile" onclick="document.getElementById('file_input').click()">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        </path>
                    </svg>
                </span>
                <img class="rounded-circle m-auto" id="img_file" src="{{ asset($user->photo) }}" style="height: 7rem">
                    <p class="small">
                        (Para efectuar el cambio debe guardar sus actualizaciones)
                    </p>
                </img>
            </input>
        </div>
        <div class="col-6 mb-3">
            <x-label :value="__('Nombre')" for="name">
            </x-label>
            <x-input :value="$user->name" autofocus="" class="block mt-1 w-full" id="name" name="name" required="" type="text">
            </x-input>
        </div>
        <!-- Email Address -->
        <div class="col-6 mb-3">
            <x-label :value="__('Email')" for="email">
            </x-label>
            <x-input :value="$user->email" class="block mt-1 w-full" id="email" name="email" required="" type="email">
            </x-input>
        </div>
        <div class="col-6 mb-3">
            <x-label :value="__('Contrase??a')" for="password">
            </x-label>
            <x-input :value="old('password')" autofocus="" class="block mt-1 w-full" id="password" name="password" type="password">
            </x-input>
        </div>
        <div class="col-6 mb-3">
            <x-label :value="__('Confirmar Contrase??a')" for="password-confirm">
            </x-label>
            <x-input :value="old('password-confirm')" autofocus="" class="block mt-1 w-full" id="password-confirm" name="password-confirm" type="password">
            </x-input>
        </div>
    </div>
    <div class="flex items-center justify-center mt-4">
        <x-button class="ml-4">
            {{ __('Actualizar') }}
        </x-button>
    </div>
</form>
