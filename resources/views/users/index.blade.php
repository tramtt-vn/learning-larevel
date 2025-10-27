@extends('layouts.app')

@section('title', 'List Users')
@section('content')


<div class="container">
    <div class="dflex-head">
        <h2 class="mb-4 text-center">Danh sách người dùng</h2>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Đăng xuất
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Tuổi</th>
                <th>Email verified</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->age }}</td>
                <td>
                    @if ($user->email_verified_at)
                        ✅ {{ $user->email_verified_at->format('d/m/Y H:i') }}
                    @else
                         Chưa xác minh
                    @endif
                </td>
                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
