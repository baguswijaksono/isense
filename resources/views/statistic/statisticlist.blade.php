@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Total Record</th>
                    <th scope="col">Show</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $groupedData)
                    <tr>
                        <td>{{ $groupedData->date }}</td>
                        @php
                            $count = App\Models\cdStatistic::where('deviceid', $id)
                                ->where('date', $groupedData->date)
                                ->count();
                        @endphp
                        <td> {{ $count }}</td>
                        <td><a href="{{route('datarecorddetail',['id' => $id , 'date' => $groupedData->date ])}}" class="btn btn-primary">Show</a></td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $groupedData->date }}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $groupedData->date }}" tabindex="-1" aria-labelledby="exampleModal{{ $groupedData->date }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModal{{ $groupedData->date }}Label">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('delrecord') }}">
                                                @csrf
                                                {{ method_field('POST') }}
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <input type="hidden" name="date" value="{{ $groupedData->date }}">
                                                <p>Sure Want to delete record for {{ $groupedData->date }} with {{ $count }} record in it ?</p>
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
    </div>
@endsection
