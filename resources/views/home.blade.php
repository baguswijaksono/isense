@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($data as $item)
    <div class="fishcard" style="width: 24rem;">
        <div class="card-img-overlay">
            <a href="{{route('rawstream',['id' => $item->id])}}">
            <img src="{{ route('img.show', ['imageName' => $item->image]) }}"
                class="rounded card-img-top" alt="...">
            <div class="overlay-text">
                {{$item->name}}
            </div>
        </a>
        </div>
@endforeach
</div>
@endsection
