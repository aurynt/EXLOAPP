@extends('layouts.guestLayout')
@section('title', 'Profile')
@section('content')
    {{-- @dd($posts) --}}
    <div class="flex flex-col items-center gap-4">
        <div class="flex flex-col gap-2 w-96 rounded shadow-lg bg-slate-200 p-3">
            <div class="flex justify-center items-center flex-col gap-2">
                <div class="rounded-full h-16 w-16 bg-slate-400"></div>
                <div class="flex flex-col items-center">
                    <p class="text-lg font-bold capitalize">{{ auth()->user()->name }}</p>
                    <p class="text-sm">{{ '@' . auth()->user()->username }}</p>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit">logout</button>
                    </form>
                </div>
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
        <div id="rehan" class="flex flex-col items-center gap-4">
            @foreach ($posts as $item)
                <div id='card' class="flex flex-col gap-2 w-96 rounded shadow-lg bg-slate-200 p-3">
                    <div class="flex justify-between gap-2">
                        <a href="{{ route('account', $item['username']) }}">{{ '@' . $item['username'] }}</a>
                        <div class="flex gap-2 items-center justify-between">
                            <p>{{ $item['categories']['name'] }}</p>
                            <a class="text-yellow-500" href="{{ route('edit', $item['id']) }}">edit</a>
                            <button class="text-red-600 btn_hapus" type="button"
                                data-id="{{ $item['id'] }}">hapus</button>
                        </div>
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
            <div id="null" class="hidden w-96 rounded shadow-lg bg-slate-200 p-3">
                <h1>Tidak ada postingan</h1>
            </div>
        </div>
        <script>
            const ajaxDel = (data) => {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('hapus') }}",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    success: (res) => {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        })
                    },
                    error: (err) => {
                        Swal.fire({
                            title: "Delete Failed",
                            text: "Your file can't be deleted.",
                            icon: "error"
                        })
                    },
                }).done(() => {
                    $.get('/upost', (res) => {
                        res.length == 0 ?
                            $('#null').removeClass('hidden') : $('#null').addClass(
                                'hidden')
                        $('#rehan').empty()
                        res.map((item, i) => {
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
                                            }).text(item
                                                .username),
                                            $('<div/>', {
                                                'class': 'flex gap-2 items-center justify-between',
                                                'html': [
                                                    $(
                                                        '<p/>'
                                                    )
                                                    .text(
                                                        item
                                                        .category_name
                                                    ),
                                                    $('<a/>', {
                                                        class: 'text-yellow-500',
                                                        href: '/post/' +
                                                            item
                                                            .id
                                                    })
                                                    .text(
                                                        'edit'
                                                    ),
                                                    $('<button/>', {
                                                        class: 'text-red-600 btn_hapus',
                                                        type: 'button',
                                                    })
                                                    .text(
                                                        'hapus'
                                                    )
                                                    .attr(
                                                        'data-id',
                                                        item
                                                        .id
                                                    )
                                                ]
                                            })
                                        ]
                                    }),
                                    $('<img>', {
                                        id: 'image',
                                        src: 'storage/post/' +
                                            item.foto,
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
                                            $('<p>').text(
                                                'like'),
                                            $('<p>').text(
                                                'download'),
                                            $('<p>').text(
                                                'follow')
                                        ]
                                    })
                                ]
                            });
                            $('#rehan').append(card);
                        })
                    })
                })
            }
            $(document).on('click', '.btn_hapus', function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const data = {
                            id: $(this).data("id"),
                        }
                        ajaxDel(data)
                    }
                });
            });
        </script>

    @endsection
