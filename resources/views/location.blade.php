<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Location | Axlo</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    @vite('resources/css/app.css')
</head>

<body class="antialiased w-screen flex items-center flex-col">
    <div class="flex bg-slate-500 z-[99999] rounded-lg mt-3 w-[80vw] justify-between px-6 py-4 fixed">
        <ul class="flex flex-column gap-4">
            <li class="capitalize">
                <a href="/">home</a>
            </li>
            <li class="capitalize"><a href="{{ route('post') }}">post</a></li>
            <li class="capitalize"><a href="{{ route('location') }}">location</a></li>
        </ul>
        <a href="/profile/saia" class="flex gap-1">
            <div class="h-6 w-6 rounded-full bg-blue-400 block"></div>
            <p>Heri</p>
        </a>
    </div>
    <div class="flex justify-center items-center rounded-lg">
        <div id="location" class="w-screen h-screen"></div>
    </div>
    <script>
        let map = L.map('location').setView([-7.561542, 110.836945], 6);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        @foreach ($posts as $item)
            @switch($item['type'])
                @case('marker')
                L.marker({!! $item->coordinat !!}).addTo(map)
                    .bindPopup("{{ '@' . $item->username }}");
                @break

                @case('polygon')
                L.polygon({!! $item->coordinat !!}).addTo(map).bindPopup("{{ '@' . $item->username }}");
                @break

                @case('polyline')
                L.polyline({!! $item->coordinat !!}).addTo(map)
                    .bindPopup("{{ '@' . $item->username }}");
                @break

                @case('rectangle')
                L.rectangle({!! $item->coordinat !!}, {
                        weight: 1,
                        color: 'red'
                    }).addTo(map)
                    .bindPopup("{{ '@' . $item->username }}");
                @break

                @case('circle')
                L.circle({!! $item->coordinat !!}, {
                        radius: "{{ $item->radius }}"
                    }).addTo(map)
                    .bindPopup("{{ '@' . $item->username }}");
                @break
            @endswitch
        @endforeach
    </script>
</body>

</html>
