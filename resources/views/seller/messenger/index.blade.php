@extends('layouts.seller')


@section('content')
    <div class="content">
        <div class="container">
            @if (auth()->user())
                <messenger user-id="store-{{auth()->user()->store->id}}"></messenger>
            @endif
        </div>
    </div>
@endsection
