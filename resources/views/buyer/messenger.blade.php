@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('body-class', 'gray-dark bg-messages')

@section('extra-css')
@endsection

@section('content')
    <div class="content">
        <div class="container">
            @if (auth()->user())
            <messenger user-id="buyer-{{auth()->user()->id}}"></messenger>
            @endif
        </div>
    </div>
@endsection
