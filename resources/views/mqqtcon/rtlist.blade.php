@extends('layouts.app')

@section('content')
    <div class="container">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Device Id</th>
                    <th scope="col">latestRecordtoGet</th>
                    <th scope="col">maxcrowd</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->deviceid }}</td>
                        <td>{{ $item->latestRecordtoGet }}</td>
                        <td>{{ $item->maxcrowd }}</td>
                        <td> <a class="btn btn-primary"
                                href="{{ route('rtconfig', ['deviceid' => $item->deviceid]) }}">Edit</td>
                        <td> <a class="btn btn-danger"
                                href="{{ route('rtconfig', ['deviceid' => $item->deviceid]) }}">Delete</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
