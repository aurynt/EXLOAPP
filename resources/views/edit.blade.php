@extends('layouts.guestLayout')
@section('title', 'Edit')
@section('content')
    <div class="flex justify-center items-center">
        <div class="flex flex-col w-96 rounded-lg p-4 shadow-2xl">
            <h1 class="text-2xl font-bold mb-4">Post</h1>
            <div class="flex flex-col">
                <input id="coordinat" value="{{ old('username', $posts['coordinat']) }}"
                    class="border rounded border-black p-2" type="hidden" name="coordinat">
                <input id="radius" value="{{ old('username', $posts['radius']) }}" class="border rounded border-black p-2"
                    type="hidden" name="radius">
                <input id="type" value="{{ old('type', $posts['type']) }}" class="border rounded border-black p-2"
                    type="hidden" name="type">
                <input value="{{ $posts['id'] }}" class="border rounded border-black p-2" type="hidden" id="id">
                <div class="flex flex-col mb-3">
                    <label for="username" class="capitalize">username</label>
                    <input id="username" value="{{ old('username', $posts['username']) }}"
                        class="border bg-transparent rounded border-black p-2" type="text" name="username">
                    <p id="usernameError" class="text-red-500 text-xs"></p>
                </div>
                <div class="flex flex-col mb-3">
                    <label for="desc" class="capitalize">description</label>
                    <textarea id="desc" class="border bg-transparent rounded border-black p-2" rows="5" name="description">{{ old('description', $posts['description']) }}</textarea>
                    <p id="descError" class="text-red-500 text-xs"></p>

                </div>
                <div class="flex flex-col mb-3">
                    <img id="showImage" class="rounded" src="{{ asset('storage/post/' . $posts['foto']) }}"
                        alt="{{ $posts['foto'] }}">
                    <label for="photo" class="capitalize">photo</label>
                    <input accept="image/*" id="photo" class="border bg-transparent rounded border-black p-2"
                        type="file" name="photo">
                    <p id="photoError" class="text-red-500 text-xs"></p>

                </div>
                <div class="flex flex-col mb-3">
                    <label for="mapupdate" class="capitalize rounded">location</label>
                    <div id="mapupdate" style="height: 300px"></div>
                    <p id="mapError" class="text-red-500 text-xs"></p>

                </div>
                <div class="flex flex-col mb-5">
                    <label for="category" class="capitalize">category</label>
                    <select id="category" class="p-3 rounded bg-transparent" name="category">
                        @foreach ($category as $item)
                            <option {{ old('category', $posts['category']) == $item['id'] ? 'selected' : '' }}
                                class="p-2" value={{ $item['id'] }}>{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    <p id="categoryError" class="text-red-500 text-xs"></p>
                </div>
                <button type="button" id="formUpdate" class="w-full p-2 bg-blue-600 rounded">Save</button>
            </div>
        </div>

    </div>
    <script>
        var map = L.map('mapupdate').setView([-7.541410189934723, 110.44604864790085], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        @switch($posts['type'])
            @case('marker')
            L.marker({!! $posts->coordinat !!}).addTo(map)
            @break

            @case('polygon')
            L.polygon({!! $posts->coordinat !!}).addTo(map)
            @break

            @case('polyline')
            L.polyline({!! $posts->coordinat !!}).addTo(map)
            @break

            @case('rectangle')
            L.rectangle({!! $posts->coordinat !!}, {
                weight: 1,
                color: 'red'
            }).addTo(map)
            @break

            @case('circle')
            L.circle({!! $posts->coordinat !!}, {
                radius: {!! $posts->radius !!}
            }).addTo(map);
            @break
        @endswitch

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
    <script>
        const reset = (data) => {
            $('#username').val(data.username ?? null);
            $('#desc').val(data.description ?? null);
            $('#showImage').attr('src', "{{ asset('storage/post') }}" + '/' + data.foto)
            $('#radius').val(data.radius ?? null);
            $('#type').val(data.type ?? null);
        }
        const displayError = (err) => {
            $('#usernameError').html(err.username)
            $('#mapError').html(err.type)
            $('#categoryError').html(err.category)
            $('#descError').html(err.description)
            $('#photoError').html(err.foto)
        }
        $('#formUpdate').on('click', () => {
            const data = {
                id: $('#id').val(),
                username: $('#username').val(),
                description: $('#desc').val(),
                photo: $('#photo')[0].files[0],
                coordinat: $('#coordinat').val(),
                radius: $('#radius').val(),
                type: $('#type').val(),
                category: $('#category').val(),
            }
            const formData = new FormData();
            formData.append('id', $('#id').val());
            formData.append('username', $('#username').val());
            formData.append('description', $('#desc').val());
            formData.append('photo', $('#photo')[0].files[0]);
            formData.append('coordinat', $('#coordinat').val());
            formData.append('radius', $('#radius').val());
            formData.append('type', $('#type').val());
            formData.append('category', $('#category').val());

            $.ajax({
                url: "{{ route('update') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: (res) => {
                    reset(res.data)
                    console.log(res);
                    Swal.fire({
                        title: "Updated!",
                        text: "Your file has been updated.",
                        icon: "success"
                    })
                },
                error: (err) => {
                    displayError(err.responseJSON.errors)
                    Swal.fire({
                        title: "Failed!",
                        text: err.responseJSON.message,
                        icon: "error"
                    })
                }
            })

        })
    </script>
@endsection
