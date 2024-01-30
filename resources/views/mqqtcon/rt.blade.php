@extends('layouts.app')

@section('content')
    <div class="container">

        <form class="row g-3" novalidate action="{{ route('rtconfigstore') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="deviceid" value="{{ $data[0]->deviceid }}">
            <div class="mb-3">
                <label for="latestRecordtoGet" class="form-label">latestRecordtoGet</label>
                <input type="text" class="form-control" name="latestRecordtoGet" id="latestRecordtoGet"
                    value="{{ $data[0]->latestRecordtoGet }}">
                <div id="hosthelp" class="form-text">Example 10</div>
            </div>

            <div class="mb-3">
                <label for="maxcrowd" class="form-label">maxcrowd</label>
                <input type="text" class="form-control" name="maxcrowd" id="maxcrowd" value="{{ $data[0]->maxcrowd }}">
                <div id="hosthelp" class="form-text">Example 10</div>
            </div>

            <div class="mb-3"><button type="submit" class="btn btn-dark">Submit</button></div>

        </form>
    </div>
@endsection
