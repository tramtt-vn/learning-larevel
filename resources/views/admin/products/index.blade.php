@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="mb-0">Tổng sản phẩm</h6>
                            <h3 class="mb-0">{{ $products->total() }}</h3>
                        </div>
                        <i class="fas fa-box fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="mb-0">Đang bán</h6>
                            <h3 class="mb-0">{{ $activeCount ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="mb-0">Hết hàng</h6>
                            <h3 class="mb-0">{{ $outOfStockCount ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!-- Main Content Card -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Danh sách sản phẩm</h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="/admin/products/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm sản phẩm mới
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Filters -->
            <form class="form" action="{{ route('admin.products.index') }}" method="GET">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input name="search" type="text" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option selected>Trạng thái</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang bán</option>
                             <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Ngừng bán</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-secondary w-100">
                            <i class="fas fa-filter"></i> Lọc
                        </button>
                    </div>
                    <div class="col-md-2">
                         <a href="{{ route('admin.products.index') }}"
                           class="btn btn-outline-secondary"
                           title="Xóa tất cả filter">
                            <i class="fas fa-times"></i> Xóa lọc
                        </a>
                    </div>
                </div>
            </form>
            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">
                                <input type="checkbox" class="form-check-input">
                            </th>
                            <th width="8%">ID</th>
                            <th width="10%">Hình ảnh</th>
                            <th width="25%">Tên sản phẩm</th>
                            <th width="12%">Vat %</th>
                            <th width="12%">Giá</th>
                            <th width="8%">Tồn kho</th>
                            <th width="10%">Trạng thái</th>
                            <th width="10%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><strong>#{{ $product->id }}</strong></td>
                            <td>
                                <img src="{{ ($product->image) ? asset("storage/".$product->image) : 'https://via.placeholder.com/80x80' }}"
                                     alt="{{ $product->name }}"
                                     class="img-thumbnail"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                <br>
                                <small class="text-muted">Code: {{ $product->code }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $product->vat ?? '0' }}</span>
                            </td>
                            <td>
                                <strong class="text-primary">{{ number_format($product->price) }}₫</strong>
                                @if($product->old_price)
                                <br>
                                <small class="text-muted text-decoration-line-through">
                                    {{ number_format($product->old_price) }}₫
                                </small>
                                @endif
                            </td>
                            <td>
                                @if($product->stock > 10)
                                <span class="badge bg-success">{{ $product->stock }}</span>
                                @elseif($product->stock > 0)
                                <span class="badge bg-warning">{{ $product->stock }}</span>
                                @else
                                <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </td>
                            <td>
                                @if($product->status == 'active')
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Đang bán
                                </span>
                                @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-times"></i> Ngừng bán
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group gap-2" role="group">
                                    <a href="/admin/products/{{ $product->id }}/edit"
                                       class="btn btn-sm btn-warning"
                                       title="Chỉnh sửa">
                                        Sửa
                                    </a>
                                    <form class="form" action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                                title="Xóa"
                                                onclick="return confirm('Bạn có chắc muốn xóa?')">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Không có sản phẩm nào</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="row mt-3">
                <div class="pagination">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Select all checkboxes
    document.querySelector('thead input[type="checkbox"]').addEventListener('change', function() {
        document.querySelectorAll('tbody input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endpush
@endsection
