@extends('layouts.app')

@section('content')
<style>
    .iframe-container {
        display: inline-block;
        width: 100%; /* Set the width as needed */
        height: 500px; /* Set the height as needed */
        overflow: hidden; /* Hide any overflowing content */
        margin: 0;
        padding: 0;
    }

    .iframe-container iframe {
        width: 100%;
        height: 100%;
        border: none; /* Remove iframe border */
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="ratio ratio-16x9" style="width: 820px;">
                    <video src="{{ $data->raw_url }}">
                    </video>
                </div>
                <div class="video-info">
                    <div class="row justify-content-between">
                        <div class="col p-2">
                            <h1 class="video-title">{{ $data->name }}</h1>
                        </div>
                        <div class="col-1 p-2">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ $streamtype }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('rawstream', ['id' => $data->id]) }}">Raw</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p class="video-description">{{ $data->description }}</p>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Select Stream</label>
                    <select id="streamSelect" class="form-select" aria-label="Default select example">
                        <option selected>{{ $data->name }}</option>
                        @foreach ($listdata as $astream)
                        @if( $data->name != $astream->name )
                        <option value="{{ $astream->id }}">{{ $astream->name }}</option>
                        @else
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 iframe-container">
                    <iframe src="/rtlc/{{$data->name}}" frameborder="0"></iframe>
                </div>
                <script>
                    var streamSelect = document.getElementById("streamSelect");
                    streamSelect.addEventListener("change", function() {
                        var selectedValue = streamSelect.value;
                        if (selectedValue !== "Select Another Stream") {
                            window.location.href = "/stream/" + selectedValue + "/raw";
                        }
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
