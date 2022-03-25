@extends('layout')

@section('content')
<h1>Contact</h1>
@can('home.secret')
 <p>This is a secret email</p>
@endcan

@endsection