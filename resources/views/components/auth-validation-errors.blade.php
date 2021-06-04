@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'alert alert-danger']) }} >
        <h4 class="alert-heading font-weight-bold" style="font-size: 1.5rem;">¡Ups! Algo ha salido mal</h4>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
