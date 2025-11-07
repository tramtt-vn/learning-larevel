@extends('layouts.admin')

@section('title','Xác minh Email')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <h3>Vui lòng xác minh email</h3>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p>
      Một email xác minh đã được gửi tới <strong>{{ session('email') }}</strong>.
      Vui lòng kiểm tra hộp thư (và cả spam).
    </p>
    @if(session('resend'))
    <form method="POST" action="{{ route('verification.resend') }}">
    <input type="hidden" name="id" value="{{ session('id') }}">
      @csrf
      <button type="submit" class="btn btn-primary">Gửi lại link xác minh</button>
    </form>
    @endif
  </div>
</div>
@endsection
