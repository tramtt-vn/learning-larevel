@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Welcome, {{ auth()->user()->fullname ?? auth()->user()->email }}</h2>
  <p>Đây là dashboard</p>
  @if(session('success'))
     {{ session('success') }}
  @endif
  @if(session('error'))
     {{ session('error') }}
  @endif
</div>
<form method="POST" action="{{ route('logout') }}" style="display: inline;">
    @csrf
    <button type="submit">Đăng xuất</button>
</form>
@endsection
