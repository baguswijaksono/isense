@extends('layouts.app')

@section('content')
    <div class="container">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Raw Url</th>
                    <th scope="col">Description</th>
                    <th scope="col">Data Record</th>
                    <th scope="col">Statistic</th>
                    <th scope="col">Preview Image</th>
@if(Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'))
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
@else

@endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->raw_url }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            <a href="{{route('datarecord' , ['id' => $item->name])}}" class="btn btn-primary">Data Record</a>
                        </td>
                        <td>
                    
                            
                            <a href="{{ route('cdstatisticfilt', ['id' => $item->name]) }}" class="btn btn-primary"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-graph-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
                                </svg> Statistic</a>
                        </td>
                        <td>
                            <img src="{{ route('img.show', ['imageName' => $item->image]) }}" style="max-width: 150px;">
                        </td>
@if(Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'))
                        <td>
                            <a href="{{ route('editstream', ['id' => $item->id]) }}" class="btn btn-dark"> Edit</a>
                        </td>
                        <td>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $item->id }}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Stream Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Sure Want to delete stream {{ $item->id }}  ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <form method="POST" action="{{ route('delstream') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                        @else

                        @endif
                    </tr>
                @endforeach


            </tbody>
        </table>

    </div>
@endsection
