@extends('cms::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('cms.name') !!}</p>
@endsection
