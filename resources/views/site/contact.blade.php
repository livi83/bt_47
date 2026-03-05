@extends('layouts.app')

@section('title', 'Contact')

@section('content')
  <h1>Kontakt</h1>

  @if ($errors->any())
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <form method="POST" action="{{ url('/contact') }}">
    @csrf

    <div>
      <label>Meno</label>
      <input name="name" value="{{ old('name') }}">
    </div>

    <div>
      <label>Email</label>
      <input name="email" value="{{ old('email') }}">
    </div>

    <div>
      <label>Správa</label>
      <textarea name="message">{{ old('message') }}</textarea>
    </div>

    <button type="submit">Odoslať</button>
  </form>
@endsection