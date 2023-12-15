@extends('layouts.guestLayout')
@section('title', 'Post')
@section('content')
    <div class="flex justify-center items-center">
        <div class="flex flex-col w-96 rounded-lg p-4 shadow-2xl shadow-slate-700 backdrop-blur-lg">
            <h1 class="text-2xl font-bold mb-4">Post</h1>
            <form enctype="multipart/form-data" method="post" class="flex flex-col" action="{{ route('add') }}"
                accept="image/*">
                @csrf
                @method('post')
                <input id="coordinat" value="{{ old('coordinat') }}" class="border rounded border-black p-2" type="hidden"
                    name="coordinat">
                <input id="radius" value="{{ old('radius') }}" class="border rounded border-black p-2" type="hidden"
                    name="radius">
                <input id="type" value="{{ old('type') }}" class="border rounded border-black p-2" type="hidden"
                    name="type">
                <div class="flex flex-col mb-3">
                    <label for="username" class="capitalize">username</label>
                    <input id="username" value="{{ old('username') }}"
                        class="border rounded border-black bg-transparent p-2" type="text" name="username">
                    @error('username')
                        <p class="text-red-700 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col mb-3">
                    <label for="desc" class="capitalize">description</label>
                    <textarea id="desc" class="border rounded border-black bg-transparent p-2" rows="5" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-700 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col mb-3">
                    <label for="photo" class="capitalize">photo</label>
                    <input value="{{ old('photo') }}" id="photo" class="border bg-transparent rounded border-black p-2"
                        type="file" name="photo" accept="image/*">
                    @error('photo')
                        <p class="text-red-700 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col mb-3">
                    <label for="photo" class="capitalize">location</label>
                    <div id="map" style="height: 300px"></div>
                </div>
                <div class="flex flex-col mb-5">
                    <label for="category" class="capitalize">category</label>
                    <select id="select" class="p-3 rounded bg-transparent" name="category">
                        @foreach ($category as $item)
                            <option {{ old('category') == $item['id'] ? 'selected' : '' }} class="p-2 bg-transparent"
                                value={{ $item['id'] }}>
                                {{ $item['name'] }}</option>
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
@endsection
