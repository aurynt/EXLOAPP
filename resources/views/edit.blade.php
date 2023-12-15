@extends('layouts.guestLayout')
@section('title', 'Edit')
@section('content')
    <div class="flex justify-center items-center">
        <div class="flex flex-col w-96 rounded-lg p-4 shadow-2xl">
            <h1 class="text-2xl font-bold mb-4">Post</h1>
            <form enctype="multipart/form-data" method="post" class="flex flex-col" action="{{ route('update') }}">
                @csrf
                @method('put')
                <input value="{{ $posts['id'] }}" class="border rounded border-black p-2" type="hidden" name="id">
                <div class="flex flex-col mb-3">
                    <label for="username" class="capitalize">username</label>
                    <input value="{{ old('username', $posts['username']) }}"
                        class="border bg-transparent rounded border-black p-2" type="text" name="username">
                    @error('username')
                        <p class="text-red-700 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col mb-3">
                    <label for="desc" class="capitalize">description</label>
                    <textarea id="desc" class="border bg-transparent rounded border-black p-2" rows="5" name="description">{{ old('description', $posts['description']) }}</textarea>
                    @error('description')
                        <p class="text-red-700 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col mb-3">
                    <img class="rounded" src="{{ asset('storage/post/' . $posts['foto']) }}" alt="{{ $posts['foto'] }}">
                    <label for="photo" class="capitalize">photo</label>
                    <input accept="image/*" id="photo" class="border bg-transparent rounded border-black p-2"
                        type="file" name="photo">
                    @error('foto')
                        <p class="text-red-700 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <input id="coordinat" value="{{ old('username', $posts['coordinat']) }}"
                    class="border rounded border-black p-2" type="hidden" name="coordinat">
                <input id="radius" value="{{ old('username', $posts['radius']) }}"
                    class="border rounded border-black p-2" type="hidden" name="radius">
                <input id="type" value="{{ old('type') }}" class="border rounded border-black p-2" type="hidden"
                    name="type">
                <div class="flex flex-col mb-3">
                    <label for="photo" class="capitalize rounded">location</label>
                    <div id="mapupdate" style="height: 300px"></div>
                    @error('location')
                        <p class="text-red-700 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col mb-5">
                    <label for="photo" class="capitalize">category</label>
                    <select class="p-3 rounded bg-transparent" name="category">
                        @foreach ($category as $item)
                            <option {{ old('category', $posts['category']) == $item['id'] ? 'selected' : '' }}
                                class="p-2" value={{ $item['id'] }}>{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-700 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <button class="w-full p-2 bg-blue-600 rounded">Save</button>
            </form>
        </div>
    </div>
    <script>
        let map = L.map('mapupdate').setView([-7.561542, 110.836945], 6);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        @switch($posts['type'])
            @case('marker')
            const marker = .marker({!! $posts->coordinat !!}).addTo(map)
            marker.bindPopup("I am a marker.");
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
    </script>
@endsection
