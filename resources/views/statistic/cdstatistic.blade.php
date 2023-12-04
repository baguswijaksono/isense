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
                        <select class="form-select mb-3" name="type" id="type">
                            @if ($type == 1)
                                <option value="1" selected>Filter</option>
                                <option value="2">Realtime</option>
                            @else
                                <option value="2" selected>Realtime</option>
                                <option value="1">Filter</option>
                            @endif
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">Stream</label>
                        <select id="streamSelect" class="form-select" name="name" id="name">
                            <option selected>{{ $device }}</option>
                            @foreach ($listdata as $astream)
                                @if ($astream->name != $device)
                                    <option value="{{ $astream->name }}">{{ $astream->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="row">

                    <div class="col mb-3">
                        <label class="form-label">Start Date</label>
                        <input class="form-control" type="date" id="date" value="{{ $date }}">
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">End Date</label>
                        <input class="form-control" type="date" id="enddate" value="{{ $finenddate }}">
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">From</label>
                        <input class="form-control" type="time" name="from" id="from"
                            value="{{ $from }}" />
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">To</label>
                        <input class="form-control" type="time" name="to" id="to"
                            value="{{ $to }}" />
                    </div>

                    <div class="col">
                        <button type="button" class="btn btn sm btn-primary" id="goButton">Go</button>
                    </div>
                </div>

                <script>
                    document.getElementById('goButton').addEventListener('click', function() {
                        var streamName = document.getElementById('streamSelect').value;
                        var date = document.getElementById('date').value;
                        var enddate = document.getElementById('enddate').value;
                        var fromTime = document.getElementById('from').value;
                        var toTime = document.getElementById('to').value;
                        var type = document.getElementById('type').value;
                        var redirectUrl = `/statistic/${streamName}/${date}/${enddate}/${fromTime}/${toTime}/${type}`;
                        window.location.href = redirectUrl;
                    });
                </script>

            </div>

        </div>
    </div>


    @if ($type == 1)
        <div class="container">
            @include('layouts.filteredlinechart')

            <div class="h6"> Lowest People Count : {{ $lowestPeopleCount }}</div>
            <div class="h6"> Greatest People Count : {{ $greatestPeopleCount }}</div>
            <div class="h6"> Time Of Greatest PeopleCount : {{ $timeOfGreatestPeopleCount }}</div>
            <div class="h6"> Time Of Lowest People Count : {{ $timeOfLowestPeopleCount }}</div>
            <div class="h6"> Average People Count : {{ $averagePeopleCount }}</div>
            <div class="h6"> Total Data Record : {{ $totalDataRecord }}</div>
        </div>
    @elseif($type == 2)
        <div class="container" style="width : 800px"> <iframe src="/rtlc/{{ $device }}"></iframe>
        </div>
    @endif
@endsection
