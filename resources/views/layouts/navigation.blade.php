<div
    class="group fixed inset-x-0 mt-3 top-0 z-50 pl-9 xl:pl-6 pr-9 xl:pr-5 transition-[margin,width] duration-200 xl:ml-[320px] xl:mr-5 group-[.content--compact]:xl:ml-[--size-sidebar] before:inset-y-0 before:left-4 before:transition-[margin] before:duration-200 before:right-0 before:absolute xl:before:-ml-[320px] group-[.content--compact]:xl:before:-ml-[--size-sidebar] before:bg-primary before:border dark:before:bg-[color-mix(in_oklch,_var(--color-background),_white_14%)] before:my-3 before:rounded-2xl before:mr-4 xl:before:-mr-1 after:inset-0 after:left-8 after:transition-[margin] after:duration-200 after:right-0 after:absolute xl:after:-ml-[320px] group-[.content--compact]:xl:after:-ml-[--size-sidebar] after:bg-primary/30 after:border dark:after:bg-[color-mix(in_oklch,_var(--color-background),_white_14%)] after:z-[-1] after:mb-3 after:rounded-2xl after:mr-8 xl:after:mr-4">
    <div class="relative z-20 flex h-[90px] items-center gap-5">
        <div
            class="open-mobile-menu bg-(--color-nav-foreground)/10 border-(--color-nav-foreground)/30 mr-auto flex size-9 cursor-pointer items-center justify-center rounded-xl border xl:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                data-lucide="chart-no-axes-column"
                class="lucide lucide-chart-no-axes-column size-4 stroke-[1.5] stroke-(--color) fill-(--color)/25 rotate-90 [--color:var(--color-nav-foreground)]">
                <line x1="18" x2="18" y1="20" y2="10"></line>
                <line x1="12" x2="12" y1="20" y2="4"></line>
                <line x1="6" x2="6" y1="20" y2="14"></line>
            </svg>
        </div>
        <ul
            class="truncate gap-x-6 mr-auto hidden [--background-image-chevron:var(--background-image-chevron-light)] [--color-base:--alpha(var(--color-nav-foreground)/70%)] [--color-link:var(--color-nav-foreground)] xl:flex">
            {{-- <li
                class="[&amp;:not(:last-child)&gt;a]:text-(--color-link) text-(--color-base) before:bg-(image:--background-image-chevron) relative before:absolute before:inset-y-0 before:my-auto before:-ml-4 before:size-2 before:-rotate-90 before:bg-center before:bg-no-repeat before:opacity-70 first:before:hidden">
                <a href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html"
                    class="truncate gap-x-6 mr-auto hidden [--background-image-chevron:var(--background-image-chevron-light)] [--color-base:--alpha(var(--color-nav-foreground)/70%)] [--color-link:var(--color-nav-foreground)] xl:flex">Apps</a>
            </li>
            <li
                class="[&amp;:not(:last-child)&gt;a]:text-(--color-link) text-(--color-base) before:bg-(image:--background-image-chevron) relative before:absolute before:inset-y-0 before:my-auto before:-ml-4 before:size-2 before:-rotate-90 before:bg-center before:bg-no-repeat before:opacity-70 first:before:hidden">
                <a href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html"
                    class="truncate gap-x-6 mr-auto hidden [--background-image-chevron:var(--background-image-chevron-light)] [--color-base:--alpha(var(--color-nav-foreground)/70%)] [--color-link:var(--color-nav-foreground)] xl:flex">Dashboards</a>
            </li>
            <li
                class="[&amp;:not(:last-child)&gt;a]:text-(--color-link) text-(--color-base) before:bg-(image:--background-image-chevron) relative before:absolute before:inset-y-0 before:my-auto before:-ml-4 before:size-2 before:-rotate-90 before:bg-center before:bg-no-repeat before:opacity-70 first:before:hidden">
                <a href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html"
                    class="truncate gap-x-6 mr-auto hidden [--background-image-chevron:var(--background-image-chevron-light)] [--color-base:--alpha(var(--color-nav-foreground)/70%)] [--color-link:var(--color-nav-foreground)] xl:flex">Overview</a>
            </li> --}}
        </ul>
        {{-- <div
            class="quick-search-toggle bg-(--color-nav-foreground)/10 border-(--color-nav-foreground)/30 text-(--color-nav-foreground) hover:ring-foreground/5 flex h-9 cursor-pointer items-center rounded-full border px-4 ring-1 ring-transparent ring-offset-2 ring-offset-transparent">
            <div class="flex items-center gap-3 opacity-70">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    data-lucide="search"
                    class="lucide lucide-search size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                ⌘K
            </div>
        </div> --}}
        {{-- <div class="group/notifications relative flex h-9 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="bell"
                class="lucide lucide-bell size-4 stroke-[1.5] stroke-(--color) fill-(--color)/25 [--color:var(--color-nav-foreground)]">
                <path d="M10.268 21a2 2 0 0 0 3.464 0"></path>
                <path
                    d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326">
                </path>
            </svg>
            <div class="hidden group-hover/notifications:block">
                <div
                    class="box p-5 before:absolute before:inset-0 before:mx-3 before:-mb-3 before:border before:border-foreground/10 before:bg-background/30 before:z-[-1] after:absolute after:inset-0 after:border after:border-foreground/10 after:bg-background after:shadow-[0px_3px_5px_#0000000b] after:z-[-1] after:backdrop-blur-md before:shadow-foreground/5 absolute right-0 top-0 z-50 -mr-0.5 -mt-0.5 flex w-96 flex-col gap-2.5 px-6 py-5 before:rounded-2xl before:shadow-xl before:backdrop-blur after:rounded-2xl">
                    <div class="flex place-content-between items-center">
                        <div class="font-medium">Notifications</div>
                        <a class="text-primary text-xs"
                            href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html">View
                            More</a>
                    </div>
                    <div class="mt-1 flex flex-col gap-2.5">
                        <a class="hover:border-foreground/10 hover:bg-foreground/5 -mx-2 flex items-center gap-3.5 rounded-2xl border border-transparent p-2"
                            href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html">
                            <span data-content=""
                                class="tooltip border-(--color)/5 block relative flex-none overflow-hidden rounded-full border-3 ring-1 ring-(--color)/25 [--color:var(--color-primary)] size-11">
                                <img class="absolute top-0 size-full object-cover"
                                    src="./Dashboard - Midone - Tailwind Admin Dashboard Template_files/profile-14.jpg"
                                    alt="Midone - Tailwind Admin Dashboard Template">
                            </span>
                            <div class="flex flex-col gap-1">
                                <div class="flex place-content-between items-center">
                                    <div class="font-medium">Denzel Washington
                                    </div>
                                    <div class="text-xs opacity-70">05:09 AM
                                    </div>
                                </div>
                                <div class="line-clamp-2 text-xs opacity-70">
                                    It is a long established fact that a reader will be
                                    distracted by the readable content of a page when looking at
                                    its layout. The point of using Lorem
                                </div>
                            </div>
                        </a>
                        <a class="hover:border-foreground/10 hover:bg-foreground/5 -mx-2 flex items-center gap-3.5 rounded-2xl border border-transparent p-2"
                            href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html">
                            <span data-content=""
                                class="tooltip border-(--color)/5 block relative flex-none overflow-hidden rounded-full border-3 ring-1 ring-(--color)/25 [--color:var(--color-primary)] size-11">
                                <img class="absolute top-0 size-full object-cover"
                                    src="./Dashboard - Midone - Tailwind Admin Dashboard Template_files/profile-12.jpg"
                                    alt="Midone - Tailwind Admin Dashboard Template">
                            </span>
                            <div class="flex flex-col gap-1">
                                <div class="flex place-content-between items-center">
                                    <div class="font-medium">John Travolta
                                    </div>
                                    <div class="text-xs opacity-70">06:05 AM
                                    </div>
                                </div>
                                <div class="line-clamp-2 text-xs opacity-70">
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's
                                    standard dummy text ever since the 1500
                                </div>
                            </div>
                        </a>
                        <a class="hover:border-foreground/10 hover:bg-foreground/5 -mx-2 flex items-center gap-3.5 rounded-2xl border border-transparent p-2"
                            href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html">
                            <span data-content=""
                                class="tooltip border-(--color)/5 block relative flex-none overflow-hidden rounded-full border-3 ring-1 ring-(--color)/25 [--color:var(--color-primary)] size-11">
                                <img class="absolute top-0 size-full object-cover"
                                    src="./Dashboard - Midone - Tailwind Admin Dashboard Template_files/profile-7.jpg"
                                    alt="Midone - Tailwind Admin Dashboard Template">
                            </span>
                            <div class="flex flex-col gap-1">
                                <div class="flex place-content-between items-center">
                                    <div class="font-medium">Denzel Washington
                                    </div>
                                    <div class="text-xs opacity-70">03:20 PM
                                    </div>
                                </div>
                                <div class="line-clamp-2 text-xs opacity-70">
                                    There are many variations of passages of Lorem Ipsum
                                    available, but the majority have suffered alteration in some
                                    form, by injected humour, or randomi
                                </div>
                            </div>
                        </a>
                        <a class="hover:border-foreground/10 hover:bg-foreground/5 -mx-2 flex items-center gap-3.5 rounded-2xl border border-transparent p-2"
                            href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html">
                            <span data-content=""
                                class="tooltip border-(--color)/5 block relative flex-none overflow-hidden rounded-full border-3 ring-1 ring-(--color)/25 [--color:var(--color-primary)] size-11">
                                <img class="absolute top-0 size-full object-cover"
                                    src="./Dashboard - Midone - Tailwind Admin Dashboard Template_files/profile-11.jpg"
                                    alt="Midone - Tailwind Admin Dashboard Template">
                            </span>
                            <div class="flex flex-col gap-1">
                                <div class="flex place-content-between items-center">
                                    <div class="font-medium">Kevin Spacey
                                    </div>
                                    <div class="text-xs opacity-70">05:09 AM
                                    </div>
                                </div>
                                <div class="line-clamp-2 text-xs opacity-70">
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's
                                    standard dummy text ever since the 1500
                                </div>
                            </div>
                        </a>
                        <a class="hover:border-foreground/10 hover:bg-foreground/5 -mx-2 flex items-center gap-3.5 rounded-2xl border border-transparent p-2"
                            href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html">
                            <span data-content=""
                                class="tooltip border-(--color)/5 block relative flex-none overflow-hidden rounded-full border-3 ring-1 ring-(--color)/25 [--color:var(--color-primary)] size-11">
                                <img class="absolute top-0 size-full object-cover"
                                    src="./Dashboard - Midone - Tailwind Admin Dashboard Template_files/profile-5.jpg"
                                    alt="Midone - Tailwind Admin Dashboard Template">
                            </span>
                            <div class="flex flex-col gap-1">
                                <div class="flex place-content-between items-center">
                                    <div class="font-medium">Robert De Niro
                                    </div>
                                    <div class="text-xs opacity-70">06:05 AM
                                    </div>
                                </div>
                                <div class="line-clamp-2 text-xs opacity-70">
                                    It is a long established fact that a reader will be
                                    distracted by the readable content of a page when looking at
                                    its layout. The point of using Lorem
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="group/profile relative size-9 flex-none">
            <span data-content=""
                class="tooltip border-(--color)/5 block relative flex-none overflow-hidden rounded-full border-3 ring-1 ring-(--color)/40 size-full [--color:var(--color-nav-foreground)]">
                <img class="absolute top-0 size-full object-cover" src="https://ui-avatars.com/api/?name=John+Doe"
                    alt="Sedaloreto">
            </span>
            <div class="hidden group-hover/profile:block">
                <div
                    class="box p-5 before:absolute before:inset-0 before:mx-3 before:-mb-3 before:border before:border-foreground/10 before:bg-background/30 before:z-[-1] after:absolute after:inset-0 after:border after:border-foreground/10 after:bg-background after:shadow-[0px_3px_5px_#0000000b] after:z-[-1] after:backdrop-blur-md before:shadow-foreground/5 absolute right-0 top-0 z-50 -mr-0.5 -mt-0.5 flex w-64 flex-col gap-2.5 px-6 py-5 before:rounded-2xl before:shadow-xl before:backdrop-blur after:rounded-2xl">
                    <div class="flex flex-col gap-0.5">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="mt-0.5 text-xs opacity-70">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="bg-foreground/5 h-px"></div>
                    <div class="flex flex-col gap-0.5">
                        <a class="hover:bg-foreground/5 -mx-3 flex gap-2.5 rounded-lg px-4 py-1.5"
                            href="{{ route('profile.edit') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" data-lucide="users"
                                class="lucide lucide-users size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            {{ __('Profile') }}
                        </a>
                        {{-- <a class="hover:bg-foreground/5 -mx-3 flex gap-2.5 rounded-lg px-4 py-1.5"
                            href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" data-lucide="shield-alert"
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
                            href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" data-lucide="file-lock"
                                class="lucide lucide-file-lock size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z">
                                </path>
                                <rect width="8" height="6" x="8" y="12" rx="1"></rect>
                                <path d="M10 12v-2a2 2 0 1 1 4 0v2"></path>
                            </svg>
                            Reset Password
                        </a>
                        <a class="hover:bg-foreground/5 -mx-3 flex gap-2.5 rounded-lg px-4 py-1.5"
                            href="https://midone-html.vercel.app/enigma-side-menu-dashboard-overview-2.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" data-lucide="file-question"
                                class="lucide lucide-file-question size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                <path d="M12 17h.01"></path>
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z">
                                </path>
                                <path d="M9.1 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3"></path>
                            </svg>
                            Help
                        </a> --}}
                    </div>
                    <div class="bg-foreground/5 h-px"></div>
                    <div class="flex flex-col gap-0.5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="hover:bg-foreground/5 -mx-3 flex gap-2.5 rounded-lg px-4 py-1.5"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" data-lucide="power"
                                    class="lucide lucide-power size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25">
                                    <path d="M12 2v10"></path>
                                    <path d="M18.4 6.6a9 9 0 1 1-12.77.04"></path>
                                </svg>
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
