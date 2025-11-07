@extends('layouts.admin')

@section('content')
<div class="container">
  <h2 class="text-center">Welcome, {{ auth()->user()->fullname ?? auth()->user()->email }}</h2>
  <p class="text-center">Đây là dashboard</p>
  @if(session('success'))
     {{ session('success') }}
  @endif
  @if(session('error'))
     {{ session('error') }}
  @endif
</div>
<form method="POST" action="{{ route('logout') }}" style="display: inline;">
    @csrf
    <div class="flex-d">
    <button class="btn btn-primary" type="submit">Đăng xuất</button>
    </div>
</form>
@endsection
