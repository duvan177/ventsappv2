@extends('layouts.app')

@section('content')

<example-component v-bind:id="{{ json_encode(Auth::user()->id) }}" ></example-component>
@endsection
