@props(['name', 'class' => 'size-5'])

<svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('home')
            <path d="M3 10.5 12 3l9 7.5M5 9.5V21h14V9.5M9 21v-6h6v6"/>
            @break
        @case('users')
            <path d="M15 19a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3M10 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6M16 11a3 3 0 0 0 0-6M19 19a3 3 0 0 0-2-2.8"/>
            @break
        @case('user')
            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4 21a8 8 0 0 1 16 0"/>
            @break
        @case('calendar')
            <rect x="4" y="5" width="16" height="16" rx="2"/>
            <path d="M8 3v4M16 3v4M4 10h16M8 14h2M14 14h2M8 17h2"/>
            @break
        @case('clipboard')
            <path d="M9 4h6v3H9zM9 5H6a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1h-3M9 12h6M9 16h4"/>
            @break
        @case('pill')
            <path d="M10.5 13.5 13.5 10.5M7.5 16.5a4.2 4.2 0 0 1 0-6l3-3a4.2 4.2 0 0 1 6 6l-3 3a4.2 4.2 0 0 1-6 0Z"/>
            @break
        @case('folder')
            <path d="M3 7a2 2 0 0 1 2-2h4l2 2h6a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/>
            @break
        @case('stethoscope')
            <path d="M6 3v6a4 4 0 0 0 8 0V3M10 13v3a3 3 0 0 0 6 0v-2M18 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
            @break
        @case('shield')
            <path d="M12 3 5 6v5c0 4.5 3 7.7 7 9 4-1.3 7-4.5 7-9V6l-7-3Z"/>
            @break
        @case('logout')
            <path d="M15 12H4m0 0 3-3m-3 3 3 3M10 5V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1v-1"/>
            @break
        @case('plus')
            <path d="M12 5v14M5 12h14"/>
            @break
        @case('search')
            <circle cx="11" cy="11" r="6"/>
            <path d="m20 20-3.5-3.5"/>
            @break
        @case('edit')
            <path d="M4 20h4l10-10a2.8 2.8 0 0 0-4-4L4 16v4Z"/>
            <path d="m13.5 6.5 4 4"/>
            @break
        @case('trash')
            <path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13M10 11v5M14 11v5"/>
            @break
        @case('eye')
            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"/>
            <circle cx="12" cy="12" r="3"/>
            @break
        @case('download')
            <path d="M12 4v10m0 0 4-4m-4 4-4-4M5 20h14"/>
            @break
        @case('clock')
            <circle cx="12" cy="12" r="8"/>
            <path d="M12 8v4l3 2"/>
            @break
        @case('phone')
            <path d="M6 3h3l2 5-2 1a12 12 0 0 0 5 5l1-2 5 2v3a2 2 0 0 1-2 2A16 16 0 0 1 4 5a2 2 0 0 1 2-2Z"/>
            @break
        @case('mail')
            <rect x="3" y="5" width="18" height="14" rx="2"/>
            <path d="m3 7 9 6 9-6"/>
            @break
        @case('map-pin')
            <path d="M12 21s7-6 7-11a7 7 0 1 0-14 0c0 5 7 11 7 11Z"/>
            <circle cx="12" cy="10" r="2.5"/>
            @break
        @case('check')
            <path d="m5 13 4 4L19 7"/>
            @break
        @case('x')
            <path d="M6 6l12 12M18 6 6 18"/>
            @break
        @case('menu')
            <path d="M4 7h16M4 12h16M4 17h16"/>
            @break
        @case('arrow-right')
            <path d="M5 12h14m0 0-5-5m5 5-5 5"/>
            @break
        @case('heart')
            <path d="M12 20s-7-4.3-7-9.5A4 4 0 0 1 12 8a4 4 0 0 1 7 2.5C19 15.7 12 20 12 20Z"/>
            @break
        @case('leaf')
            <path d="M5 19c0-8 6-14 14-14 0 8-6 14-14 14ZM5 19c2-4 5-7 9-9"/>
            @break
        @case('sun')
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>
            @break
        @case('chart')
            <path d="M4 20V10M10 20V5M16 20v-8M2 20h20"/>
            @break
        @case('alert')
            <path d="M12 3 2 20h20L12 3Z"/>
            <path d="M12 9v5M12 17h.01"/>
            @break
        @case('file')
            <path d="M6 3h7l5 5v13H6V3Z"/>
            <path d="M13 3v5h5"/>
            @break
        @case('lock')
            <rect x="5" y="11" width="14" height="10" rx="2"/>
            <path d="M8 11V8a4 4 0 0 1 8 0v3"/>
            @break
        @case('print')
            <path d="M7 8V4h10v4M7 18H5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M7 14h10v7H7v-7Z"/>
            @break
        @case('flask')
            <path d="M9 3h6M10 3v5l-5 9a2 2 0 0 0 1.8 3h10.4a2 2 0 0 0 1.8-3l-5-9V3"/>
            @break
        @case('sparkle')
            <path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3Z"/>
            @break
        @case('chevron-left')
            <path d="m15 18-6-6 6-6"/>
            @break
        @case('chevron-right')
            <path d="m9 18 6-6-6-6"/>
            @break
        @default
            <circle cx="12" cy="12" r="8"/>
    @endswitch
</svg>
