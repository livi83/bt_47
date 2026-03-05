@extends('layouts.app')

@section('title', 'Thanks') 

@section('content')
  <h1>Ďakujem!</h1>
  <p>Meno: {{ $name }}</p>
  <p>Email: {{ $email }}</p>
  <p>Správa: {{ $message }}</p>
@endsection