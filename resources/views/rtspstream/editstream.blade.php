@extends('layouts.app')

@section('content')
    <div class="container">

        <form class="row g-3" novalidate action="{{ route('storeUpStream') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}">
                <input type="hidden" class="form-control" name="id" id="id" value="{{ $data->id }}">
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">Raw URL</label>
                <input type="text" class="form-control" name="raw_url" id="raw_url" value="{{ $data->raw_url }}">
            </div>

            <div class="mb-3">
                <div class="form-floating">
                    <textarea id="description" name="description" class="form-control" placeholder="Leave a Description here"
                        id="floatingTextarea">{{ $data->description }}</textarea>
                    <label for="floatingTextarea">Description</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Preview Image</label>
                <input class="form-control" type="file" id="formFile" name="image" accept="image/*">

            </div>

            <div class="mb-3"><button type="submit" class="btn btn-dark">Submit</button></div>


        </form>
    </div>
@endsection
