{{-- resources/views/components/form/label.blade.php --}}
<label
    @class([
        'font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 opacity-70',
        $attributes->get('class') // permite agregar clases extra desde fuera
    ])
    {{ $attributes->except('class') }}
>
    {{ $slot }}
</label>
