@extends('layout')

@section('content')
<h1>Contact</h1>
@can('home.secret')
 <p>
     <a href="{{ route('secret')}}">
     Go To Special Contact Details
     </a>
 </p>
@endcan

@endsection