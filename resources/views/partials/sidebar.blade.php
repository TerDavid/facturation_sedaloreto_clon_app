<?php
$menu = [
    // [
    //     'label' => 'GENERAL REPORTS',
    //     'type' => 'label',
    // ],
    // [
    //     'title' => 'Dashboard',
    //     'url' => url('/'),
    //     'icon' => 'default',
    //     'active' => true,
    // ],
    // [
    //     'title' => 'Dashboards',
    //     'icon' => 'default',
    //     'badge' => 4,
    //     'active' => true,
    //     'children' => [
    //         [
    //             'title' => 'Overview 1',
    //             'url' => url('dashboard'),
    //             'icon' => 'default',
    //         ],

    //         [
    //             'title' => 'Overview 3',
    //             'url' => url('dashboard'),
    //             'icon' => 'default',
    //         ],
    //     ],
    // ],
    [
        'label' => 'GESTIONAR',
        'type' => 'label',
    ],
    [
        'title' => 'Sedes',
        'route' => 'sede.index',
        'icon' => 'default',
    ],
    // [
    //     'title' => 'Gestión de Sedes',
    //     'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="square-activity" class="lucide lucide-square-activity size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
    //                                                     <rect width="18" height="18" x="3" y="3" rx="2"></rect>
    //                                                     <path d="M17 12h-2l-2 5-2-10-2 5H7"></path>
    //                                                 </svg>',
    //     'children' => [
    //         [
    //             'title' => 'Registrar nueva sede',
    //             'url' => url('dashboard'),
    //             'icon' => 'default',
    //         ],
    //         [
    //             'title' => 'Listado de sedes',
    //             'url' => url('dashboard'),
    //             'icon' => 'default',
    //         ],
    //     ],
    // ],
    [
        'title' => 'Gestión de Medidores',
        'icon' => 'default',
        'children' => [
            [
                'title' => 'Registrar nuevo medidor',
                'url' => route('clientes.indexSelectCity'),

                'icon' => 'default',
            ],
            [
                'title' => 'Listado de medidores',
                'url' => route('gestion_clientes2.index2'),
                'icon' => 'default',
            ],
        ],
    ],
    [
        'title' => 'Gestión de Clientes',
        'icon' => 'default',
        'children' => [
            [
                'title' => 'Registrar nuevo cliente',
                'url' => route('clientes.indexSelectCity'),
                'icon' => 'default',
            ],
            [
                'title' => 'Listado de clientes',
                'url' => route('gestion_clientes2.index2'),
                'route' => 'gestion_clientes2.index2',
                'icon' => 'default',
            ],
        ],
    ],
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
            {{-- <div
                class="border-foreground/[.11] dark:border-foreground/[.11] flex cursor-pointer items-center justify-center border-t py-3 pl-6 pr-5 opacity-90 transition hover:opacity-100 xl:border-b xl:border-t-0 xl:pb-6 xl:pl-8 xl:pt-2.5">
                <div
                    class="border-background/70 dark:border-foreground/20 relative h-11 w-11 flex-none overflow-hidden rounded-full border-4 shadow-sm">
                    <img class="absolute top-0 h-full w-full object-cover"
                        src="./Dashboard - Midone - Tailwind Admin Dashboard Template_files/profile-2.jpg"
                        alt="Midone - Admin Dashboard Template">
                </div>
                <div
                    class="ms-3 flex w-full items-center overflow-hidden transition-opacity group-[.side-menu--collapsed.side-menu--on-hover]:ms-3 group-[.side-menu--collapsed.side-menu--on-hover]:w-full group-[.side-menu--collapsed.side-menu--on-hover]:opacity-100 xl:group-[.side-menu--collapsed]:ms-0 xl:group-[.side-menu--collapsed]:w-0 xl:group-[.side-menu--collapsed]:opacity-0">
                    <div class="text-primary dark:text-foreground w-28">
                        <div class="w-full truncate font-medium">Denzel Washington
                        </div>
                        <div class="mt-0.5 w-full truncate text-xs opacity-60">Administrator</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" data-lucide="move-right"
                        class="lucide lucide-move-right size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 me-4 ms-auto opacity-50">
                        <path d="M18 8L22 12L18 16"></path>
                        <path d="M2 12H22"></path>
                    </svg>
                </div>
            </div> --}}
            {{-- <div class="hidden group-hover/profile:block">
                <div
                    class="box p-5 before:absolute before:inset-0 before:mx-3 before:-mb-3 before:border before:border-foreground/10 before:bg-background/30 before:z-[-1] after:absolute after:inset-0 after:border after:border-foreground/10 after:bg-background after:shadow-[0px_3px_5px_#0000000b] after:z-[-1] after:backdrop-blur-md text-foreground before:shadow-foreground/5 absolute bottom-0 left-[100%] z-50 ml-2 flex w-64 flex-col gap-2.5 px-6 py-5 before:rounded-2xl before:shadow-xl before:backdrop-blur after:rounded-2xl xl:bottom-auto xl:top-0">
                    <div class="flex flex-col gap-0.5">
                        <div class="font-medium">Denzel Washington</div>
                        <div class="mt-0.5 text-xs opacity-70">DevOps Engineer</div>
                    </div>
                    <div class="bg-foreground/5 h-px"></div>
                    <div class="flex flex-col gap-0.5">
                        <a class="hover:bg-foreground/5 -mx-3 flex gap-2.5 rounded-lg px-4 py-1.5"
                            href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" data-lucide="users"
                                class="lucide lucide-users size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            Profile
                        </a>
                        <a class="hover:bg-foreground/5 -mx-3 flex gap-2.5 rounded-lg px-4 py-1.5"
                            href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" data-lucide="shield-alert"
                                class="lucide lucide-shield-alert size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path
                                    d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                </path>
                                <path d="M12 8v4"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                            Add Account
                        </a>
                        <a class="hover:bg-foreground/5 -mx-3 flex gap-2.5 rounded-lg px-4 py-1.5"
                            href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" data-lucide="file-lock"
                                class="lucide lucide-file-lock size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                <rect width="8" height="6" x="8" y="12" rx="1"></rect>
                                <path d="M10 12v-2a2 2 0 1 1 4 0v2"></path>
                            </svg>
                            Reset Password
                        </a>
                        <a class="hover:bg-foreground/5 -mx-3 flex gap-2.5 rounded-lg px-4 py-1.5"
                            href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" data-lucide="file-question"
                                class="lucide lucide-file-question size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path d="M12 17h.01"></path>
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                                <path d="M9.1 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3"></path>
                            </svg>
                            Help
                        </a>
                    </div>
                    <div class="bg-foreground/5 h-px"></div>
                    <div class="flex flex-col gap-0.5">
                        <a class="hover:bg-foreground/5 -mx-3 flex gap-2.5 rounded-lg px-4 py-1.5"
                            href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" data-lucide="power"
                                class="lucide lucide-power size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path d="M12 2v10"></path>
                                <path d="M18.4 6.6a9 9 0 1 1-12.77.04"></path>
                            </svg>
                            Logout
                        </a>
                    </div>
                </div>
            </div> --}}
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
                                {{-- <ul class="scrollable">

                                    <li class="side-menu__group-label">
                                        GENERAL REPORTS
                                    </li>

                                    <li>
                                        <a href="javascript:;" class="side-menu__link side-menu__link--active">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="circle-gauge"
                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <path d="M13.4 10.6 19 5"></path>
                                            </svg>
                                            <div class="side-menu__link__title">Dashboards</div>
                                            <div class="side-menu__link__badge">
                                                4
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="chevron-down"
                                                class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition transform rotate-180">
                                                <path d="m6 9 6 6 6-6"></path>
                                            </svg>
                                        </a>

                                        <ul class="block" style="display: block;">
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-1-page.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="panel-bottom-close"
                                                        class="lucide lucide-panel-bottom-close size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <rect width="18" height="18" x="3" y="3"
                                                            rx="2"></rect>
                                                        <path d="M3 15h18"></path>
                                                        <path d="m15 8-3 3-3-3"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Overview 1
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="<?= url('dashboard') ?>"
                                                    class="side-menu__link side-menu__link--active">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="disc-3"
                                                        class="lucide lucide-disc-3 size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="M6 12c0-1.7.7-3.2 1.8-4.2"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M18 12c0 1.7-.7 3.2-1.8 4.2"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Overview 2
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-3.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="square-activity"
                                                        class="lucide lucide-square-activity size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <rect width="18" height="18" x="3" y="3"
                                                            rx="2"></rect>
                                                        <path d="M17 12h-2l-2 5-2-10-2 5H7"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Overview 3
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-4.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="album"
                                                        class="lucide lucide-album size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <rect width="18" height="18" x="3" y="3"
                                                            rx="2" ry="2"></rect>
                                                        <polyline points="11 3 11 11 14 8 17 11 17 3"></polyline>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Overview 4
                                                    </div>
                                                </a>

                                            </li>
                                        </ul>

                                    </li>

                                    <li>
                                        <a href="javascript:;" class="side-menu__link ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="square-kanban"
                                                class="lucide lucide-square-kanban size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                <rect width="18" height="18" x="3" y="3" rx="2">
                                                </rect>
                                                <path d="M8 7v7"></path>
                                                <path d="M12 7v4"></path>
                                                <path d="M16 7v9"></path>
                                            </svg>
                                            <div class="side-menu__link__title">E-Commerce</div>
                                            <div class="side-menu__link__badge">
                                                2
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="chevron-down"
                                                class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                <path d="m6 9 6 6 6-6"></path>
                                            </svg>
                                        </a>
                                        <!-- BEGIN: Second Child -->
                                        <ul class="hidden">
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-categories.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Categories
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-add-product.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Add Product
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="javascript:;" class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Products
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="chevron-down"
                                                        class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                        <path d="m6 9 6 6 6-6"></path>
                                                    </svg>
                                                </a>
                                                <!-- BEGIN: Third Child -->
                                                <ul class="hidden">
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-product-list.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Product List
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-product-grid.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Product Grid
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!-- END: Third Child -->
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Transactions
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="chevron-down"
                                                        class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                        <path d="m6 9 6 6 6-6"></path>
                                                    </svg>
                                                </a>
                                                <!-- BEGIN: Third Child -->
                                                <ul class="hidden">
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-transaction-list.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Transaction List
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-transaction-detail.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Transaction Detail
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!-- END: Third Child -->
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Sellers
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="chevron-down"
                                                        class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                        <path d="m6 9 6 6 6-6"></path>
                                                    </svg>
                                                </a>
                                                <!-- BEGIN: Third Child -->
                                                <ul class="hidden">
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-seller-list.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Seller List
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-seller-detail.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Seller Detail
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!-- END: Third Child -->
                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-reviews.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Reviews
                                                    </div>
                                                </a>

                                            </li>
                                        </ul>

                                    </li>

                                    <li class="side-menu__group-label">
                                        Gestión interna
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="side-menu__link ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="circle-gauge"
                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <path d="M13.4 10.6 19 5"></path>
                                            </svg>
                                            <div class="side-menu__link__title">Gestión de Sedes</div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="chevron-down"
                                                class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                <path d="m6 9 6 6 6-6"></path>
                                            </svg>
                                        </a>
                                        <!-- BEGIN: Second Child -->
                                        <ul class="hidden">
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-crud-data-list.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Registrar nueva sede
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-crud-form.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Listado de sedes
                                                    </div>
                                                </a>

                                            </li>
                                        </ul>

                                    </li>
                                    <li>
                                        <a href="javascript:;" class="side-menu__link ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="circle-gauge"
                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <path d="M13.4 10.6 19 5"></path>
                                            </svg>
                                            <div class="side-menu__link__title">Pages</div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="chevron-down"
                                                class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                <path d="m6 9 6 6 6-6"></path>
                                            </svg>
                                        </a>
                                        <!-- BEGIN: Second Child -->
                                        <ul class="hidden">
                                            <li>
                                                <a href="javascript:;" class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Wizards
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="chevron-down"
                                                        class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                        <path d="m6 9 6 6 6-6"></path>
                                                    </svg>
                                                </a>
                                                <!-- BEGIN: Third Child -->
                                                <ul class="hidden">
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-wizard-layout-1.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Layout 1
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-wizard-layout-2.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Layout 2
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-wizard-layout-3.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Layout 3
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!-- END: Third Child -->
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Blog
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="chevron-down"
                                                        class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                        <path d="m6 9 6 6 6-6"></path>
                                                    </svg>
                                                </a>
                                                <!-- BEGIN: Third Child -->
                                                <ul class="hidden">
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-blog-layout-1.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Layout 1
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-blog-layout-2.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Layout 2
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-blog-layout-3.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Layout 3
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!-- END: Third Child -->

                                        </ul>

                                    </li>

                                    <li>
                                        <a href="https://midone-html.vercel.app/enigma-side-menu-inbox.html"
                                            class="side-menu__link ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="circle-gauge"
                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <path d="M13.4 10.6 19 5"></path>
                                            </svg>
                                            <div class="side-menu__link__title">Inbox</div>
                                        </a>
                                        <!-- BEGIN: Second Child -->

                                    </li>

                                    <li>
                                        <a href="https://midone-html.vercel.app/enigma-side-menu-file-manager.html"
                                            class="side-menu__link ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="circle-gauge"
                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <path d="M13.4 10.6 19 5"></path>
                                            </svg>
                                            <div class="side-menu__link__title">File Manager</div>
                                            <div class="side-menu__link__badge">
                                                5
                                            </div>
                                        </a>
                                        <!-- BEGIN: Second Child -->

                                    </li>




                                    <li>
                                        <a href="javascript:;" class="side-menu__link ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="circle-gauge"
                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <path d="M13.4 10.6 19 5"></path>
                                            </svg>
                                            <div class="side-menu__link__title">Components</div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="chevron-down"
                                                class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                <path d="m6 9 6 6 6-6"></path>
                                            </svg>
                                        </a>
                                        <!-- BEGIN: Second Child -->
                                        <ul class="hidden">
                                            <li>
                                                <a href="javascript:;" class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Grid
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="chevron-down"
                                                        class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                        <path d="m6 9 6 6 6-6"></path>
                                                    </svg>
                                                </a>
                                                <!-- BEGIN: Third Child -->
                                                <ul class="hidden">
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-regular-table.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Regular Table
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-tabulator.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Tabulator
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!-- END: Third Child -->
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Overlay
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="chevron-down"
                                                        class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                                                        <path d="m6 9 6 6 6-6"></path>
                                                    </svg>
                                                </a>
                                                <!-- BEGIN: Third Child -->
                                                <ul class="hidden">
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-dialog.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Dialog
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-sheet.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Sheet
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://midone-html.vercel.app/enigma-side-menu-toast.html"
                                                            class="side-menu__link ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                data-lucide="circle-gauge"
                                                                class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                                <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M13.4 10.6 19 5"></path>
                                                            </svg>
                                                            <div class="side-menu__link__title">
                                                                Toast
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!-- END: Third Child -->
                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-tabs.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Tabs
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-accordion.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Accordion
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-button.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Button
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-alert.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Alert
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-progress.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Progress
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-tooltip.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Tooltip
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-dropdown-menu.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Dropdown Menu
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-typography.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Typography
                                                    </div>
                                                </a>

                                            </li>
                                            <li>
                                                <a href="https://midone-html.vercel.app/enigma-side-menu-icon.html"
                                                    class="side-menu__link ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="circle-gauge"
                                                        class="lucide lucide-circle-gauge size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__icon">
                                                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7"></path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <path d="M13.4 10.6 19 5"></path>
                                                    </svg>
                                                    <div class="side-menu__link__title">
                                                        Icon
                                                    </div>
                                                </a>

                                            </li>
                                        </ul>

                                    </li>


                                    <!-- END: First Child -->
                                </ul> --}}
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
