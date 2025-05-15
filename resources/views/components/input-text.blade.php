{{-- resources/views/components/input-text.blade.php --}}
<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    value="{{ $value }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge([
        'class' => 'h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background  placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50'
    ]) }}
>
