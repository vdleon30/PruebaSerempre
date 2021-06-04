@props(['success'])

@if ($success)
    <div {{ $attributes->merge(['class' => 'alert alert-success']) }} >
        <h4 class="alert-heading font-weight-bold" style="font-size: 1.5rem;">¡Excelente!</h4>
        <p>{{ $success }}</p>
    </div>
@endif
