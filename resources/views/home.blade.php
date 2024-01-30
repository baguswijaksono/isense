@extends('layouts.app')
@if (Auth::user() && Auth::user()->getRole() == 'admin' || Auth::user()->getRole() == 'superadmin')

    @section('content')
        <div class="container">
            <div class="row">
                @foreach ($data as $key => $item)
                    <div class="col-md-4 mb-4">
                        <div class="fishcard" style="width: 100%;">
                            <div class="card-img-overlay">
                                <a href="{{ route('rawstream', ['id' => $item->id]) }}">
                                    <img src="{{ route('img.show', ['imageName' => $item->image]) }}"
                                         class="rounded card-img-top" alt="...">
                                    <div class="overlay-text">
                                        {{ $item->name }}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    @if(($key + 1) % 3 == 0)
                        </div><div class="row">
                    @endif
                @endforeach
            </div>
        </div>
    @endsection
@elseif(Auth::user() && Auth::user()->getRole() == 'askfor')
    @section('content')
        <div class="container">
            u asked to see, just wait patiently.
        </div>
    @endsection
@else
    @section('content')
        <div class="container">
            u not authorized to see anything <a href="/askforit">ask for it</a>
        </div>
    @endsection

@endif
