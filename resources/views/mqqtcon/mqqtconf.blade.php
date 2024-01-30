@extends('layouts.app')

@section('content')
    <div class="container">

        <form class="row g-3" novalidate action="{{ route('storeMqqconf') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="host" class="form-label">Host Name</label>
                <input type="text" class="form-control" name="host" id="host" value="{{ $data->host ?? '' }}">
                <div id="hosthelp" class="form-text">IP default 127.0.0.1 for localhost.</div>
            </div>

            <div class="mb-3">
                <label for="host" class="form-label">Topic Name</label>
                <input type="text" class="form-control" name="topic" id="topic" value="{{ $data->topic ?? '' }}">
                <div id="hosthelp" class="form-text">Topic to Sub.</div>
            </div>

            <div class="mb-3">
                <label for="port" class="form-label">Port</label>
                <input type="number" class="form-control" name="port" id="port" value="{{ $data->port ?? '' }}">
                <div id="hosthelp" class="form-text">Default Post for mqqt is 1883.</div>
            </div>

            <div class="mb-3"><button type="submit" class="btn btn-dark">Submit</button></div>

        </form>
    </div>
@endsection
