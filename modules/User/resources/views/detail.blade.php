@extends('layouts.client')
@section('title','Chi tiet nguoi dung')
@section('content')
 <h1>{{ __('user::custom.title', ['name'=>  'Demo']) }} : {{ $id }}</h1>
@endsection    