@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="container">
        @if ($data && count($data) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Device ID</th>
                        <th>People Count</th>
                        <th>Time</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->deviceid }}</td>
                            <td>{{ $item->peoplecount }}</td>
                            <td>{{ $item->time }}</td>
                            <td>{{ $item->date }}</td>
                            <td>
                                 <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $item->id }}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModal{{ $item->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModal{{ $item->id }}Label">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('socarchivedel') }}">
                                                @csrf
                                                {{ method_field('POST') }}
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="date">
                                                <p>Sure Want to delete reord in it ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Yes, Delete it</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info" role="alert">
                No overcrowd alerts found.
            </div>
        @endif
    </div>
@endsection
