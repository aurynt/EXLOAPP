@extends('layouts.guestLayout')
@section('title', 'Acccount')
@section('content')
    <div class="flex flex-col items-center gap-4">
        <div class="flex flex-col gap-2 w-96 rounded shadow-lg bg-slate-200 p-3">
            <div class="flex justify-center items-center flex-col gap-2">
                <div class="rounded-full h-16 w-16 bg-slate-400"></div>
                <p>{{ request()->segment(count(request()->segments())) }}</p>
            </div>
            <div class="flex justify-center gap-2 mt-2">
                <div class="flex justify-center items-center flex-col">
                    <p class="capitalize">following</p>
                    <p>2K</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <p class="capitalize">post</p>
                    <p>{{ count($posts) }}</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <p class="capitalize">follower</p>
                    <p>2,2M</p>
                </div>
            </div>
        </div>
        @foreach ($posts as $item)
            <div class="flex flex-col gap-2 w-96 rounded shadow-lg bg-slate-200 p-3">
                <div class="flex justify-between">
                    <a href="{{ route('account', $item['username']) }}">{{ '@' . $item['username'] }}</a>
                    <p>{{ $item['categories']['name'] }}</p>
                </div>
                <img src="{{ asset('storage/post/' . $item['foto']) }}" alt="img">
                <p class="text-xs">{{ $item['created_at'] }}</p>
                <p class="text-justify">{{ $item['description'] }}</p>
                <div class="flex justify-end gap-2 mt-2">
                    <p>like</p>
                    <p>download</p>
                    <p>folow</p>
                </div>
            </div>
        @endforeach
        <div
            class="flex {{ count($posts) !== 0 ? 'hidden' : '' }} flex-col gap-2 w-96 z-30 rounded shadow-lg bg-slate-200 p-3">
            <h1>Tidak ada postingan</h1>
        </div>
    </div>
@endsection
