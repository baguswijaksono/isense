@extends('layouts.app')

@section('content')
    <div class="container">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Device Id</th>
                    <th scope="col">latestRecordtoGet</th>
                    <th scope="col">maxcrowd</th>
                    @if (Auth::check() && Auth::user()->role != 'admin')
                    @else
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->deviceid }}</td>
                        <td>{{ $item->latestRecordtoGet }}</td>
                        <td>{{ $item->maxcrowd }}</td>
                        <td> <a href="{{ route('rtconfig' , ['deviceid' => $item->deviceid  ]) }}">link</td>
                    </tr>
                @endforeach


            </tbody>
        </table>

    </div>
@endsection
