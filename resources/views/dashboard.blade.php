@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Welcome, {{ auth()->user()->fullname ?? auth()->user()->email }}</h2>
  <p>Đây là dashboard (chỉ truy cập khi đã auth).</p>
</div>
<form method="POST" action="{{ route('logout') }}" style="display: inline;">
    @csrf
    <button type="submit">Đăng xuất</button>
</form>
@endsection
