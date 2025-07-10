@props(['disabled' => false])

<!-- <input @disabled($disabled) {{ $attributes->merge([
'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'
]) }}> -->
<input @disabled($disabled) {{ $attributes->merge([
'class' => 'h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background  placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50'
]) }}>