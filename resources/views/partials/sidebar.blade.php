<?php
$menu = [

    [
        'label' => 'GESTIONAR',
        'type' => 'label',
    ],

    [
        'title' => 'Dashboard',
        'icon' => 'default',
        'children' => [
            [
                'title' => 'ver Graficos',
                'route' => 'dashboard',
                'icon' => 'default',
            ],


        ],
    ],

    [
        'title' => 'Gestión de Clientes',
        'icon' => 'default',
        'children' => [
            [
                'title' => 'Listado de clientes',
                'route' => 'gestion.clientes.index',
                'icon' => 'default',
            ],


        ],
    ],

      [
        'title' => 'Facturación',
        'icon' => 'default',
        'children' => [
            [
                'title' => 'Eminisión de facturas',
                'route' => 'facturation.consumo.index',
                'icon' => 'default',
            ],
            [
                'title' => 'Editar valores de facturación',
                'route' => 'valores.editAll',
                'icon' => 'default',
            ],
        ],
    ],

    [
        'title' => 'Gestión de Sedes',
        'icon' => 'default',
        'children' => [
            [
                'title' => 'Sedes',
                'route' => 'sede.index',
                'icon' => 'default',
            ],
        ],
],

    // [
    //     'title' => 'Sedes',
    //     'route' => 'sede.index',
    //     'icon' => 'default',
    // ],


    // [
    //     'title' => 'Gestión de Medidores',
    //     'icon' => 'default',
    //     'children' => [
    //         [
    //             'title' => 'Registrar nuevo medidor',
    //             'url' => route('clientes.index'),

    //             'icon' => 'default',
    //         ],
    //         [
    //             'title' => 'Listado de medidores',
    //             // 'url' => route('gestion_clientes2.index2'),
    //             'icon' => 'default',
    //         ],
    //     ],
    // ],

];

?>
<div
    class="side-menu xl:ml-0 transition-[margin] duration-200 fixed top-0 left-0 z-50 group before:content-[&#39;&#39;] before:fixed before:inset-0 before:bg-black/80 dark:before:bg-foreground/5 before:backdrop-blur before:xl:hidden after:content-[&#39;&#39;] after:absolute after:inset-0 after:bg-background after:xl:hidden [&amp;.side-menu--mobile-menu-open]:ml-0 [&amp;.side-menu--mobile-menu-open]:before:block -ml-[320px] before:hidden">
    <div
        class="close-mobile-menu fixed ml-[320px] xl:hidden z-50 cursor-pointer text-background dark:text-foreground [&amp;.close-mobile-menu--mobile-menu-open]:block hidden">
        <div class="ml-5 mt-5 flex size-10 items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x"
                class="lucide lucide-x [--color:currentColor] stroke-(--color) fill-(--color)/25 size-7 stroke-1">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </div>
    </div>
    <div
        class="side-menu__content z-20 relative w-[320px] duration-200 transition-[width] group-[.side-menu--collapsed]:xl:w-[--size-sidebar] group-[.side-menu--collapsed.side-menu--on-hover]:xl:w-[320px] h-screen flex flex-col-reverse xl:flex-col before:absolute before:inset-y-0 before:w-px before:mt-23 before:bg-foreground/[.11] dark:before:bg-foreground/10 before:right-0 before:mr-8 before:hidden xl:before:block">
        <div
            class="relative z-10 mt-3 hidden h-[90px] w-[320px] flex-none items-center overflow-hidden pl-8 pr-14 duration-200 xl:flex group-[.side-menu--collapsed.side-menu--on-hover]:xl:w-[320px] group-[.side-menu--collapsed]:xl:w-[--size-sidebar]">
            <a class="relative flex items-center transition-[margin] duration-200 xl:ml-1.5 group-[.side-menu--collapsed.side-menu--on-hover]:xl:ml-1.5 group-[.side-menu--collapsed]:xl:ml-8"
                href="#">
                {{-- <img class="size-5" src="./Dashboard - Midone - Tailwind Admin Dashboard Template_files/logo.svg"> --}}
                <div
                    class="dark:text-foreground text-background ml-3.5 text-nowrap transition-opacity group-[.side-menu--collapsed.side-menu--on-hover]:xl:opacity-100 group-[.side-menu--collapsed]:xl:opacity-0">
                    <a href="{{ route('dashboard') }}">
                        <img src="https://pagoseguroiquitos.sedaloreto.com.pe/img/logochico.png" alt="Logo"
                            class="block h-9 w-auto" />
                    </a>
                    {{-- <span class="text-base font-medium">Midone</span>
                    <span class="text-base font-light">Enigma</span> --}}
                </div>
            </a>
            <a class="toggle-compact-menu text-background dark:text-foreground border-background/20 bg-background/10 dark:bg-foreground/[.02] dark:border-foreground/[.11] relative ml-auto hidden items-center justify-center rounded-md border py-0.5 pl-0.5 pr-1 opacity-70 transition-[opacity,transform] hover:opacity-100 group-[.side-menu--collapsed]:xl:rotate-180 group-[.side-menu--collapsed.side-menu--on-hover]:xl:opacity-100 group-[.side-menu--collapsed]:xl:opacity-0 2xl:flex"
                href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    data-lucide="chevron-left"
                    class="lucide lucide-chevron-left size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
            </a>
        </div>
        <div class="side-menu__account group/profile relative transition-[width] xl:mb-2 xl:mr-8">

        </div>
        <div class="w-full h-full z-20 pl-4 xl:pl-7 pr-4 xl:pr-14 overflow-y-auto overflow-x-hidden pb-3 [&amp;:-webkit-scrollbar]:w-0 scroll-smooth [&amp;_.simplebar-scrollbar]:before:!bg-foreground/20 xl:[&amp;_.simplebar-track.simplebar-vertical]:mr-9 [-webkit-mask-image:_linear-gradient(to_top,_rgba(0,_0,_0,_0),_black_30px),_linear-gradient(to_bottom,_rgba(0,_0,_0,_0),_black_30px)] [-webkit-mask-composite:_destination-in] simplebar-scrollable-y"
            s="" data-simplebar="init">
            <div class="simplebar-wrapper" style="margin: 0px -56px -12px -28px;">
                <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                </div>
                <div class="simplebar-mask">
                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                            aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                            <div class="simplebar-content" style="padding: 0px 56px 12px 28px;">
                                @include('partials.items-sidebar')

                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder" style="width: --size-sidebar; height: 1332px;"></div>
            </div>
            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
            </div>
            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                <div class="simplebar-scrollbar"
                    style="height: 429px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
            </div>
        </div>
    </div>
</div>
