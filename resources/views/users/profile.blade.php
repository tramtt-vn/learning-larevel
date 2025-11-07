@extends('layouts.admin')

@section('title', 'Profile')
@section('content')
<div class="card p-4 shadow-sm profile">
    <h3 class="text-center mb-4">Hồ sơ cá nhân </h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <ul>
        <li><label>Tên:</label>{{ $profiles->name ?? 'Chưa cập nhật'}}</li>
        <li><label>Họ và tên đầy đủ:</label>{{ $profiles->fullname ?? 'Chưa cập nhật'}}</li>
        <li><label>Email:</label>{{ $profiles->email ?? 'Chưa cập nhật'}}</li>
        <li><label>Số điện thoại:</label>{{ $profiles->phone ?? 'Chưa cập nhật'}}</li>
        <li><label>Địa chỉ:</label>{{ $profiles->address ?? 'Chưa cập nhật'}}</li>
        <li><label>Tuổi:</label>{{ $profiles->age ?? 'Chưa cập nhật'}}</li>
        <li><label>Ngày sinh:</label>{{ $profiles->birth_day ? $profiles->birth_day->format('d/m/Y H:i') : 'Chưa cập nhật' }}</li>
        <li>
            <div class="flex-d w-full">
                <a href="{{ route('users.edit') }}" class="btn btn-primary">Chỉnh sửa thông tin</a>
            </div>
        </li>
    </ul>
</div>
@endsection
