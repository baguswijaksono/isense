@extends('layouts.app')

@section('content')
    <div class="container">
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample">
            Filter
        </button>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <div class="container">
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select mb-3" name="type" id="type" onchange="redirectBasedOnSelection()">
                            <option value="2" selected>Realtime</option>
                            <option value="1">Filter</option>
                        </select>

                        <script>
                            function redirectBasedOnSelection() {
                                var selectedValue = document.getElementById('type').value;
                        
                                if (selectedValue === '1') {
                                    var redirectUrl = "{{ route('cdstatisticfilt', ['id' => $deviceid]) }}";
                                    window.location.href = redirectUrl;
                                }
                            }
                        </script>
                        
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Stream</label>
                        <select id="streamSelect" class="form-select" name="name" id="name">
                            <option selected>{{ $deviceid }}</option>
     
                        </select>
                    </div>

                </div>
                <div class="row">

                    <div class="col">
                        <a class="btn btn sm btn-dark" href="{{ route('cdstatisticfilt', ['id' => $deviceid]) }}" >Go</a>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <div class="container">
        <iframe src="/rtlc/{{ $deviceid }}" style="width: 100%; height: 700px;"></iframe>
        <iframe src="/rtsr/{{ $deviceid }}" style="width: 100%; height: 800px;"></iframe>
    </div>
    
@endsection
