<ul class="scrollable mt-14">
    @foreach ($menu as $item)
        @if (isset($item['type']) && $item['type'] === 'label')
            <li class="side-menu__group-label">
                {{ $item['label'] }}
            </li>
        @else
            @php
                $hasChildUrl = false;
                $isActiveGroup = false;
                if ($item['children'] ?? false) {
                    foreach ($item['children'] as $child) {
                        if (isset($child['route']) && request()->routeIs($child['route'])) {
                            $hasChildUrl = true;
                            $isActiveGroup = true;
                            break;
                        }
                    }
                }
                if (isset($item['route']) && request()->routeIs($item['route'])) {
                    // $hasChildUrl = true;
                    $isActiveGroup = true;
                }

            @endphp
            <li>

                <a href="{{ isset($item['route']) ? route($item['route']) : 'javascript:;' }}"
                    class="side-menu__link {{ $isActiveGroup ? 'side-menu__link--active' : '' }}">
                    @if (isset($item['icon']))
                        @if ($item['icon'] === 'default')
                            <i data-lucide="circle-gauge"></i>
                        @else
                            <i data-lucide="{{ $item['icon'] }}"></i>
                        @endif
                    @endif
                    <div class="side-menu__link__title">{{ $item['title'] }}</div>

                    @if (isset($item['badge']))
                        <div class="side-menu__link__badge">{{ $item['badge'] }}</div>
                    @endif

                    @if (!empty($item['children']))
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" data-lucide="chevron-down"
                            class="lucide lucide-chevron-down size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25 side-menu__link__chevron transition">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg>
                    @endif
                </a>

                @if (!empty($item['children']))
                    <ul class="{{ $hasChildUrl ? 'block' : 'hidden' }}">
                        @foreach ($item['children'] as $child)
                            <li>

                                <a href="{{ isset($child['route']) ? route($child['route']) : 'javascript:;' }}"
                                    class="side-menu__link {{ (isset($child['route']) ? request()->routeIs($child['route']) : false) ? 'side-menu__link--active' : '' }}">
                                    @if (isset($child['icon']))
                                        @if ($child['icon'] === 'default')
                                            <i data-lucide="circle-gauge"></i>
                                        @else
                                            <i data-lucide="{{ $item['icon'] }}"></i>
                                        @endif
                                    @endif
                                    <div class="side-menu__link__title">
                                        {{ $child['title'] }}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endif
    @endforeach
</ul>
