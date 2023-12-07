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
                        <select class="form-select mb-3" name="type" id="type" onchange="redirectToRoute(this)">
                            <option value="1" selected>Filter</option>
                            <option value="2">Realtime</option>
                        </select>
                        @php
                            echo "
                        <script>
                            function redirectToRoute(selectElement) {
                                var selectedValue = selectElement.value;
                                if (selectedValue === '2') {
                                    var device = '" . $device . "';
                                    window.location.href = '/statistic/' + device + '/realtime';
                                }
                            }
                        </script>
                        ";
                        @endphp


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
                </div>
                <div class="col">
                    <button type="button" class="btn btn sm btn-dark" id="goButton">Go</button>
                </div>

                <script>
                    document.getElementById('goButton').addEventListener('click', function() {
                        var streamName = document.getElementById('streamSelect').value;
                        var date = document.getElementById('date').value;
                        var enddate = document.getElementById('enddate').value;
                        var fromTime = document.getElementById('from').value;
                        var toTime = document.getElementById('to').value;
                        var redirectUrl = `/statistic/${streamName}/${date}/${enddate}/${fromTime}/${toTime}`;
                        window.location.href = redirectUrl;
                    });
                </script>

            </div>

        </div>
    </div>
    @if ($nodata)
        <div class="container">
            No Data Found.
        </div>
    @else
        <div class="container">
            @include('layouts.filteredlinechart')

        </div>

        <div class="container">
            <div class="h6"> Lowest People Count : {{ $lowestPeopleCount }}</div>
            <div class="h6"> Greatest People Count : {{ $greatestPeopleCount }}</div>
            <div class="h6"> Time Of Greatest PeopleCount : {{ $timeOfGreatestPeopleCount }}</div>
            <div class="h6"> Time Of Lowest People Count : {{ $timeOfLowestPeopleCount }}</div>
            <div class="h6"> Average People Count : {{ $averagePeopleCount }}</div>
            <div class="h6"> Total Data Record : {{ $totalDataRecord }}</div>
        </div>
    @endif
@endsection
