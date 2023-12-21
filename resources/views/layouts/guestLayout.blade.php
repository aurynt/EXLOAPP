<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') | Axlo</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css
    " rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @vite('resources/css/app.css')
</head>

<body
    class="antialiased w-screen flex items-center flex-col overflow-x-hidden bg-gradient-to-tr bg-fixed from-slate-900 to-blue-900 via-gray-600">
    <div class="flex bg-slate-500 z-10 flex-col rounded-b-lg gap-3 justify-center w-[25rem] px-6 py-4 fixed">
        <div class="flex justify-between">
            <ul class="flex flex-column gap-4">
                <li class="capitalize">
                    <a href="/">home</a>
                </li>
                <li class="capitalize"><a href="{{ route('post') }}">post</a></li>
                <li class="capitalize"><a href="{{ route('location') }}">location</a></li>
            </ul>
            <a href="{{ route('profile') }}" class="flex gap-1">
                <div class="h-6 w-6 rounded-full bg-blue-400 block"></div>
                <p>{{ auth()->user()->name ?? 'guest' }}</p>
            </a>
        </div>
        <div class="w-[100%]">
            <select id="select" class="capitalize p-3 rounded-lg w-[100%]" name="search">
                @foreach ($category as $item)
                    <option
                        {{ app('request')->input('search') ? (app('request')->input('search') == $item['id'] ? 'selected' : '') : '' }}
                        value="{{ $item['id'] }}">
                        {{ $item['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-14 relative left-0 w-96">
        <div class="my-16">
            @yield('content')
        </div>
    </div>
    <script>
        $(document).ready(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('#select').change(() => {
                $.post('/search', {
                    search: $('#select').val()
                }, (data) => {
                    data.length == 0 ?
                        $('#null').removeClass('hidden') : $('#null').addClass('hidden')
                    $('#rehan').empty()
                    data.map((item, i) => {
                        var card = $('<div>', {
                            id: 'card',
                            class: 'flex flex-col gap-2 w-96 rounded shadow-lg bg-slate-200 p-3',
                            html: [
                                $('<div>', {
                                    class: 'flex justify-between',
                                    html: [
                                        $('<a>', {
                                            id: 'username',
                                            href: '#'
                                        }).text(item.username),
                                        $('<p>', {
                                            id: 'category'
                                        }).text(item.categories.name)
                                    ]
                                }),
                                $('<img>', {
                                    id: 'image',
                                    src: 'storage/post/' + item.foto,
                                    alt: item.foto
                                }),
                                $('<p>', {
                                    id: 'time',
                                    class: 'text-xs'
                                }).text(item.created_at),
                                $('<p>', {
                                    id: 'desc',
                                    class: 'text-justify'
                                }).text(item.description),
                                $('<div>', {
                                    class: 'flex justify-end gap-2 mt-2',
                                    html: [
                                        $('<p>').text('like'),
                                        $('<p>').text('download'),
                                        $('<p>').text('follow')
                                    ]
                                })
                            ]
                        });
                        $('#rehan').append(card);
                    })
                })
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('select').select2();
        });

        var map = L.map('map').setView([-7.541410189934723, 110.44604864790085], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var drawControl = new L.Control.Draw();
        map.addControl(drawControl);
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;
            $('#type').val(type)

            switch (type) {
                case 'polygon':
                    drawnItems.clearLayers();
                    drawnItems.addLayer(layer);
                    var latlng = e.layer.getLatLngs();
                    var coordinat = []
                    for (var i = 0; i < latlng.length; i++) {
                        for (var j = 0; j < latlng[i].length; j++) {
                            coordinat.push([latlng[i][j].lat, latlng[i][j]
                                .lng
                            ])
                        }
                    }
                    $('#coordinat').val(JSON.stringify(coordinat))
                    break;
                case 'circle':
                    drawnItems.clearLayers();
                    drawnItems.addLayer(layer);
                    var radius = e.layer.getRadius();
                    var latlng = [e.layer.getLatLng().lat, e.layer.getLatLng().lng];
                    $('#coordinat').val(JSON.stringify(latlng))
                    $('#radius').val(JSON.stringify(radius))
                    break;
                case 'polyline':
                    drawnItems.clearLayers();
                    drawnItems.addLayer(layer);
                    var latlng = e.layer.getLatLngs();
                    var coordinat = []
                    for (var i = 0; i < latlng.length; i++) {
                        coordinat.push([latlng[i].lat, latlng[i]
                            .lng
                        ])
                    }
                    $('#coordinat').val(JSON.stringify(coordinat))
                    break;
                case 'rectangle':
                    drawnItems.clearLayers();
                    drawnItems.addLayer(layer);
                    var latlng = e.layer.getLatLngs();
                    var coordinat = []
                    for (var i = 0; i < latlng.length; i++) {
                        for (var j = 0; j < latlng[i].length; j++) {
                            coordinat.push([latlng[i][j].lat, latlng[i][j]
                                .lng
                            ])
                        }
                    }
                    $('#coordinat').val(JSON.stringify(coordinat))
                    break;
                case 'marker':
                    drawnItems.clearLayers();
                    drawnItems.addLayer(layer);
                    var latlng = [e.layer.getLatLng().lat, e.layer.getLatLng().lng];
                    $('#coordinat').val(JSON.stringify(latlng));
                    break;

                default:
                    break;
            }
        });
    </script>
</body>

</html>
