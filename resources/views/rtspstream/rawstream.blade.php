@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        .iframe-container {
            display: inline-block;
            width: 100%;
            /* Set the width as needed */
            height: 500px;
            /* Set the height as needed */
            overflow: hidden;
            /* Hide any overflowing content */
            margin: 0;
            padding: 0;
        }

        .iframe-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            /* Remove iframe border */
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="ratio ratio-16x9" style="width: 820px;">
                    <video id="video" autoplay="true" controls="controls"></video>
                    <script>
                        if (Hls.isSupported()) {
                            var video = document.getElementById('video');
                            var hls = new Hls();
                            // bind them together
                            hls.attachMedia(video);
                            hls.on(Hls.Events.MEDIA_ATTACHED, function() {
                                console.log("video and hls.js are now bound together !");
                                hls.loadSource("{{ $data->raw_url }}");
                                hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {
                                    console.log("manifest loaded, found " + data.levels.length + " quality level");
                                });
                            });
                        }
                    </script>
                </div>
                <div class="video-info">
                    <div class="row justify-content-between">
                        <div class="col p-2">
                            <h1 class="video-title">{{ $data->name }}</h1>
                        </div>
                        <div class="col-1 p-2">
                            <a href="{{ route('cdstatisticfilt', ['id' => $data->name]) }}" class="btn btn-dark btn-sm" >Stat</a>
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
                            @if ($data->name != $astream->name)
                                <option value="{{ $astream->id }}">{{ $astream->name }}</option>
                            @else
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 iframe-container">
                    <iframe src="/rtlc/{{ $data->name }}" frameborder="0"></iframe>
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
