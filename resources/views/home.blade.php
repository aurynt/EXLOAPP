@extends('layouts.guestLayout')
@section('title', 'Home')
@section('content')
    <div id="rehan" class="flex flex-col items-center gap-4">
        @foreach ($posts as $item)
            <div id='card' class="flex flex-col gap-2 w-96 rounded shadow-lg bg-slate-200 p-3">
                <div class="flex justify-between">
                    <a id="username" href="{{ route('account', $item['username']) }}">{{ '@' . $item['username'] }}</a>
                    <p id="category">{{ $item['categories']['name'] }}</p>
                </div>
                <img id="image" src="{{ asset('storage/post/' . $item['foto']) }}" alt="{{ $item['foto'] }}">
                <p id="time" class="text-xs">{{ $item['created_at'] }}</p>
                <p id="desc" class="text-justify">{{ $item['description'] }}</p>
                <div class="flex justify-end gap-2 mt-2">
                    <p>like</p>
                    <p>download</p>
                    <p>folow</p>
                </div>
            </div>
        @endforeach
    </div>
    <div id="null" class="hidden w-96 rounded shadow-lg bg-slate-200 p-3">
        <h1>Tidak ada postingan</h1>
    </div>
@endsection
