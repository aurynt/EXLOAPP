@extends('layouts.guestLayout')
@section('title', 'Post')
@section('content')
    <div class="flex justify-center items-center">
        <div class="flex flex-col w-96 rounded-lg p-4 shadow-2xl shadow-slate-700 backdrop-blur-lg">
            <h1 class="text-2xl font-bold mb-4">Post</h1>
            <form enctype="multipart/form-data" class="flex flex-col">
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
                    <p id="usernameError" class="text-red-500 text-xs"></p>
                </div>
                <div class="flex flex-col mb-3">
                    <label for="desc" class="capitalize">description</label>
                    <textarea id="desc" class="border rounded border-black bg-transparent p-2" rows="5" name="description">{{ old('description') }}</textarea>
                    <p id="descError" class="text-red-500 text-xs"></p>
                </div>
                <div class="flex flex-col mb-3">
                    <label for="photo" class="capitalize">photo</label>
                    <input value="{{ old('photo') }}" id="photo" class="border bg-transparent rounded border-black p-2"
                        type="file" name="photo" accept="image/*">
                    <p id="photoError" class="text-red-500 text-xs"></p>
                </div>
                <div class="flex flex-col mb-3">
                    <label for="map" class="capitalize">location</label>
                    <div id="map" style="height: 300px"></div>
                    <p id="mapError" class="text-red-500 text-xs"></p>
                </div>
                <div class="flex flex-col mb-5">
                    <label for="category" class="capitalize">category</label>
                    <select id="category" class="p-3 rounded bg-transparent" name="category">
                        @foreach ($category as $item)
                            <option {{ old('category') == $item['id'] ? 'selected' : '' }} class="p-2 bg-transparent"
                                value={{ $item['id'] }}>
                                {{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    <p id="categoryError" class="text-red-500 text-xs"></p>
                </div>
                <button id="form" type="button" class="w-full p-2 bg-blue-600 rounded">Save</button>
            </form>
        </div>
    </div>
    <script>
        const reset = () => {
            $('#username').val(null);
            $('#desc').val(null);
            $('#photo').val(null);
            $('#radius').val(null);
            $('#type').val(null);
        }

        const displayError = (err) => {
            $('#usernameError').html(err.username)
            $('#mapError').html(err.type)
            $('#categoryError').html(err.category)
            $('#descError').html(err.description)
            $('#photoError').html(err.foto)
        }

        $('#form').on('click', () => {
            const formData = new FormData();
            formData.append('username', $('#username').val());
            formData.append('description', $('#desc').val());
            formData.append('photo', $('#photo')[0].files[0]);
            formData.append('coordinat', $('#coordinat').val());
            formData.append('radius', $('#radius').val());
            formData.append('type', $('#type').val());
            formData.append('category', $('#category').val());

            $.ajax({
                url: "{{ route('add') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: (res) => {
                    Swal.fire({
                        title: "Woke",
                        text: "successfuly added post",
                        icon: "success"
                    });

                },
                error: (err) => {
                    displayError(err.responseJSON.errors)
                    Swal.fire({
                        title: "Failed!",
                        text: err.responseJSON.message,
                        icon: "error"
                    })
                }
            }).done(() => reset())

        })
    </script>
@endsection
