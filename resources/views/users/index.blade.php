@extends('layouts.admin')

@section('title', 'List Users')
@section('content')


<div class="container">
    <div class="dflex-head">
        <h2 class="mb-4 text-center">Danh sách người dùng</h2>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="flex-between">
        <div class="search-product">
            <label>Tìm kiếm:</label>
            <form class="form" action="{{ route('users.index') }}" method="GET">
                <input class="form-control" type="text" name="search" placeholder="Search name, email..." />
                <button class="btn btn-search" type="submit">
                    <svg class="icon " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                </button>
            </form>

        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                @if($users->total() > 0)
                    Hiển thị <strong>{{ $users->firstItem() }}</strong> -
                    <strong>{{ $users->lastItem() }}</strong>
                    trong tổng số <strong>{{ $users->total() }}</strong> users
                @else
                    Không có dữ liệu
                @endif
            </div>
        </div>
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
                <th></th>
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
                <td>
                    <form action="{{ route('users.delete', $user->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary w-100">xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>
@endsection
