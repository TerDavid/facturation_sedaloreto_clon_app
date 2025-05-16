<div
    {{ $attributes->merge([
        'class' =>
            'before:bg-background/30 before:border-foreground/10 after:border-foreground/10 after:bg-background cbox p-5',
    ]) }}>
    {{ $slot }}
</div>
