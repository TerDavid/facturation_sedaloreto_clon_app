{{-- resources/views/clientes/gestion_clientes/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">
            Registrar cliente
        </h2>
    </x-slot>
    <x-slot name="current_view">
        gestion_clientes
    </x-slot>
    <div class="mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Registrar cliente</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">

        <div class="col-span-12 lg:col-span-6">

            <!-- BEGIN: Form Layout -->
            <div
                class="box relative p-5 before:absolute before:inset-0 before:mx-3 before:-mb-3 before:border before:border-foreground/10 before:bg-background/30 before:shadow-[0px_3px_5px_#0000000b] before:z-[-1] before:rounded-xl after:absolute after:inset-0 after:border after:border-foreground/10 after:bg-background after:shadow-[0px_3px_5px_#0000000b] after:rounded-xl after:z-[-1] after:backdrop-blur-md">
                <div class="flex flex-col gap-2.5"><label for="crud-form-1"
                        class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Product
                        Name</label>
                    <input
                        class="h-10 rounded-md border bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:font-medium file:text-foreground placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-full"
                        id="crud-form-1" type="text" placeholder="Input text">
                </div>

                <div class="flex flex-col gap-2.5 mt-3"><label for="crud-form-3"
                        class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Quantity</label>
                    <div class="flex">
                        <input
                            class="h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:font-medium file:text-foreground placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 rounded-e-none border-e-0"
                            type="text" placeholder="Quantity">
                        <div
                            class="bg-(--color)/[.03] border-(--color)/[.08] text-(--color)/70 flex w-16 items-center justify-center rounded-e-lg border [--color:var(--color-foreground)]">
                            pcs</div>
                    </div>
                </div>
                <div class="flex flex-col gap-2.5 mt-3"><label for="crud-form-4"
                        class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Weight</label>
                    <div class="flex">
                        <input
                            class="h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:font-medium file:text-foreground placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 rounded-e-none border-e-0"
                            type="text" placeholder="Weight">
                        <div
                            class="bg-(--color)/[.03] border-(--color)/[.08] text-(--color)/70 flex w-16 items-center justify-center rounded-e-lg border [--color:var(--color-foreground)]">
                            grams</div>
                    </div>
                </div>
                <div class="flex flex-col gap-2.5 mt-3"><label
                        class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Price</label>
                    <div class="grid-cols-3 gap-2 sm:grid">
                        <div class="flex">
                            <div
                                class="bg-(--color)/[.03] border-(--color)/[.08] text-(--color)/70 flex items-center justify-center rounded-s-lg border px-3 [--color:var(--color-foreground)]">
                                Unit</div>
                            <input
                                class="h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:font-medium file:text-foreground placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 rounded-s-none border-s-0"
                                type="text" placeholder="Unit">
                        </div>
                        <div class="mt-2 flex sm:mt-0">
                            <div
                                class="bg-(--color)/[.03] border-(--color)/[.08] text-(--color)/70 flex items-center justify-center rounded-s-lg border px-3 [--color:var(--color-foreground)]">
                                Wholesale</div>
                            <input
                                class="h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:font-medium file:text-foreground placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 rounded-s-none border-s-0"
                                type="text" placeholder="Wholesale">
                        </div>
                        <div class="mt-2 flex sm:mt-0">
                            <div
                                class="bg-(--color)/[.03] border-(--color)/[.08] text-(--color)/70 flex items-center justify-center rounded-s-lg border px-3 [--color:var(--color-foreground)]">
                                Bulk</div>
                            <input
                                class="h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:font-medium file:text-foreground placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 rounded-s-none border-s-0"
                                type="text" placeholder="Bulk">
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2.5 mt-3"><label
                        class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Active
                        Status</label>
                    <div class="relative h-6 w-11">
                        <input class="peer relative z-10 size-full cursor-pointer opacity-0" type="checkbox">
                        <div
                            class="bg-foreground/15 peer-checked:bg-foreground absolute inset-0 rounded-full transition-all">
                        </div>
                        <div
                            class="z-4 bg-background absolute inset-0 inset-y-0 my-auto ml-0.5 size-5 rounded-full shadow transition-[margin] ease-linear peer-checked:ml-[1.35rem]">
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-right">
                    <button
                        class="[--color:var(--color-foreground)] cursor-pointer inline-flex border items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-(--color) hover:bg-(--color)/5 bg-background border-(--color)/20 h-10 px-4 py-2 mr-1 w-24"
                        type="button">
                        Cancel
                    </button>
                    <button
                        class="cursor-pointer inline-flex border items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-(--color)/20 border-(--color)/60 text-(--color) hover:bg-(--color)/5 [--color:var(--color-primary)] h-10 px-4 py-2 w-24"
                        type="button">
                        Save
                    </button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
    <div class="p-6 max-w-4xl mx-auto  rounded-lg shadow">
        {{-- 1) Selector de sector --}}
        <form method="GET" action="{{ route('gestion_clientes2.create2') }}" class="mb-6 flex items-end space-x-4">
            @csrf
            <div
                class="box relative p-5 before:absolute before:inset-0 before:mx-3 before:-mb-3 before:border before:border-foreground/10 before:bg-background/30 before:shadow-[0px_3px_5px_#0000000b] before:z-[-1] before:rounded-xl after:absolute after:inset-0 after:border after:border-foreground/10 after:bg-background after:shadow-[0px_3px_5px_#0000000b] after:rounded-xl after:z-[-1] after:backdrop-blur-md px-6 py-8">
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col gap-2.5"><label
                            class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 opacity-70">Full
                            Name</label>
                        <input type="text" placeholder="John Doe"
                            class="h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:font-medium file:text-foreground placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    <div class="flex flex-col gap-2.5"><label
                            class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 opacity-70">Email</label>
                        <input type="email" placeholder="johndoe@gmail.com"
                            class="h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:font-medium file:text-foreground placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    <div class="flex flex-col gap-2.5"><label
                            class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 opacity-70">When
                            is your
                            event?</label>
                        <input type="date"
                            class="h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:font-medium file:text-foreground placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    <div class="flex flex-col gap-2.5"><label
                            class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 opacity-70">What
                            type of event is
                            it?</label>
                        <select
                            class="bg-(image:--background-image-chevron) bg-[position:calc(100%-theme(spacing.3))_center] bg-[size:theme(spacing.5)] bg-no-repeat relative appearance-none flex h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option>Corporate Event</option>
                            <option>Wedding</option>
                            <option>Birthday</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-2.5"><label
                            class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 opacity-70">Additional
                            details</label>
                        <textarea
                            class="flex min-h-24 w-full rounded-md border border-input bg-background px-3 py-2 ring-offset-background placeholder:text-foreground/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">    </textarea>
                    </div>
                    <div class="flex gap-2.5 flex-row items-center">
                        <div class="bg-background border-foreground/70 relative size-4 rounded-sm border">
                            <input class="peer relative z-10 size-full cursor-pointer opacity-0" type="checkbox"
                                id="email-me">
                            <div
                                class="z-4 bg-foreground invisible absolute inset-0 flex items-center justify-center text-white peer-checked:visible">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" data-lucide="check"
                                    class="lucide lucide-check stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 size-4">
                                    <path d="M20 6 9 17l-5-5"></path>
                                </svg>
                            </div>
                        </div>
                        <label
                            class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 opacity-70"
                            for="email-me">Email me news and special offers</label>
                    </div>
                    <div class="mt-2 flex gap-3">
                        <button
                            class="cursor-pointer inline-flex border items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-(--color)/20 border-(--color)/60 text-(--color) hover:bg-(--color)/5 [--color:var(--color-primary)] h-10 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" data-lucide="rocket"
                                class="lucide lucide-rocket size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path
                                    d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                </path>
                                <path
                                    d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                </path>
                                <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                            </svg>
                            Register Event
                        </button>
                        <button
                            class="[--color:var(--color-foreground)] cursor-pointer inline-flex border items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-(--color) hover:bg-(--color)/5 bg-background border-(--color)/20 h-10 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" data-lucide="book-check"
                                class="lucide lucide-book-check size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path
                                    d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20">
                                </path>
                                <path d="m9 9.5 2 2 4-4"></path>
                            </svg>
                            Show Events
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-2.5"><label
                    class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 opacity-70">What
                    type of event is
                    it?</label>
                <select
                    class="bg-(image:--background-image-chevron) bg-[position:calc(100%-theme(spacing.3))_center] bg-[size:theme(spacing.5)] bg-no-repeat relative appearance-none flex h-10 w-full rounded-md border bg-background px-3 py-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-foreground/5 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option>Corporate Event</option>
                    <option>Wedding</option>
                    <option>Birthday</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="w-1/3">
                <label for="sector_id" class="block text-sm font-medium text-gray-300">
                    Elige primero un sector
                </label>
                <select id="sector_id" name="sector_id" onchange="this.form.submit()"
                    class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
                    <option value="">-- selecciona sector --</option>
                    {{-- @foreach ($sectores as $s)
                        <option value="{{ $s->id }}" {{ request('sector_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->sector }}
                        </option>
                    @endforeach --}}
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Continuar
            </button>
        </form>

        {{-- @if (request('sector_id')) --}}
        {{-- 2) Formulario completo --}}
        <form method="POST" action="{{ route('gestion_clientes2.store2') }}">
            @csrf

            {{-- ocultos básicos --}}
            {{-- <input type="hidden" name="ciudad_id" value="{{ $ciudad->id }}"> --}}
            <input type="hidden" name="sector_id" value="{{ request('sector_id') }}">

            {{-- Estado --}}
            <div class="mb-4">
                <label for="estado" class="block text-sm font-medium text-gray-300">
                    Estado
                </label>
                <select id="estado" name="estado"
                    class="mt-1 block w-1/3 bg-gray-800 text-white border-gray-700 rounded">
                    <option value="1" {{ old('estado') === '1' ? 'selected' : '' }}>Sin deuda</option>
                    <option value="0" {{ old('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                    <option value="2" {{ old('estado') === '2' ? 'selected' : '' }}>Deuda</option>
                    <option value="3" {{ old('estado') === '3' ? 'selected' : '' }}>Corte</option>
                </select>
                @error('estado')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                {{-- Código de suministro --}}
                <div>
                    <label for="codigo_suministro" class="block text-sm font-medium text-gray-300">
                        Código de suministro
                    </label>
                    <x-form.label for="codigo_suministro">
                        Product Name
                    </x-form.label>
                    <input id="codigo_suministro" name="codigo_suministro" type="text"
                        value="{{ old('codigo_suministro') }}"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
                    <x-input-text id="codigo_suministro" name="codigo_suministro" placeholder="00000"
                        class="mt-4" value="{{ old('codigo_suministro') }} />

                    @error('codigo_suministro')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nombre --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-300">Nombre</label>
                    <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Apellido --}}
                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-300">Apellido</label>
                    <input id="apellido" name="apellido" type="text" value="{{ old('apellido') }}"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
                    @error('apellido')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DNI --}}
                <div>
                    <label for="dni" class="block text-sm font-medium text-gray-300">DNI</label>
                    <input id="dni" name="dni" type="text" value="{{ old('dni') }}"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
                    @error('dni')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Celular --}}
                <div>
                    <label for="celular" class="block text-sm font-medium text-gray-300">Celular</label>
                    <input id="celular" name="celular" type="text" value="{{ old('celular') }}"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
                    @error('celular')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Correo --}}
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-300">Correo</label>
                    <input id="correo" name="correo" type="email" value="{{ old('correo') }}"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
                    @error('correo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dirección --}}
                <div class="col-span-2">
                    <label for="direccion" class="block text-sm font-medium text-gray-300">Dirección</label>
                    <input id="direccion" name="direccion" type="text" value="{{ old('direccion') }}"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
                    @error('direccion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Manzana --}}
                <div>
                    <label for="manzana_id" class="block text-sm font-medium text-gray-300">Manzana</label>
                    <select id="manzana_id" name="manzana_id"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
                        <option value="">-- selecciona manzana --</option>
                        {{-- @foreach ($manzanas as $m)
                                <option value="{{ $m->id }}"
                                    {{ old('manzana_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->manzana }}
                                </option>
                            @endforeach --}}
                    </select>
                    @error('manzana_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Medidor --}}
                <div>
                    <label for="medidor_id" class="block text-sm font-medium text-gray-300">Medidor</label>
                    <select id="medidor_id" name="medidor_id"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
                        <option value="">-- selecciona medidor --</option>
                        {{-- @foreach ($medidores as $m)
                                <option value="{{ $m->id }}"
                                    {{ old('medidor_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->codigo_medidor }}
                                </option>
                            @endforeach --}}
                    </select>
                    @error('medidor_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tarifa --}}
                <div>
                    <label for="tarifa_id" class="block text-sm font-medium text-gray-300">Tarifa
                        aplicable</label>
                    <select id="tarifa_id" name="tarifa_id"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"
                        @if (!old('medidor_id')) disabled @endif>
                        <option value="">-- selecciona tarifa --</option>
                        @foreach ($tarifas as $t)
                            <option value="{{ $t->id }}" {{ old('tarifa_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->categoria }}
                            </option>
                        @endforeach
                    </select>
                    @error('tarifa_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Consumo sin medidor --}}
                <div>
                    <label for="consumo_sin_medidor_id" class="block text-sm font-medium text-gray-300">
                        Consumo sin medidor
                    </label>
                    <select id="consumo_sin_medidor_id" name="consumo_sin_medidor_id"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
                        <option value="">-- selecciona opción --</option>
                        @foreach (\App\Models\ConsumoSinMedidor::all() as $c)
                            <option value="{{ $c->id }}"
                                {{ old('consumo_sin_medidor_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->categoria }}
                            </option>
                        @endforeach
                    </select>
                    @error('consumo_sin_medidor_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- botones --}}
            <div class="mt-8 flex justify-end space-x-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                    Guardar cliente
                </button>
                <a href="{{ route('gestion_clientes2.index2') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
                    Cancelar
                </a>
            </div>
        </form>
        {{-- @endif --}}
    </div>
    @section('scripts')
        @vite('resources/js/modules/clientes.js')
    @endsection
</x-app-layout>
