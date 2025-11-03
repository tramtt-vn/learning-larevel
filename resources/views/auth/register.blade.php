@extends('layouts.app')

@section('title', 'Register')
@section('content')
<div class="card p-4 shadow-sm register-block">
    <h3 class="text-center mb-4">Register</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="fullname" value="{{ old('fullname') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Age</label>
            <input type="text" name="age" value="{{ old('age') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control">
        </div>
        <div class="flex-d">
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </div>
        <p class="text-center mt-3 mb-0">
            Already have an account? <a href="{{ route('customer.login') }}">Login</a>
        </p>
    </form>
</div>
@endsection
