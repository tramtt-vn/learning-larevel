@extends('layouts.admin')

@section('title', 'Product create')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex gap-3">
                    <h3 class="card-title">Thêm sản phẩm mới</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Cột trái -->
                            <div class="col-md-8">
                                <!-- Tên sản phẩm -->
                                <div class="form-group mb-3">
                                    <label for="name">Tên sản phẩm <span class="required">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Nhập tên sản phẩm">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Mô tả -->
                                <div class="form-group mb-3">
                                    <label for="description">Mô tả sản phẩm</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="5"
                                              placeholder="Nhập mô tả sản phẩm">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Ảnh chính -->
                                <div class="form-group mb-3">
                                    <label for="image">Ảnh sản phẩm <span class="required">*</span></label>
                                    <input type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image"
                                           accept="image/*"
                                           onchange="previewImage(event, 'preview-image')">
                                    @error('image')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="preview-image" src="" alt="Preview" style="max-width: 200px; display: none;">
                                    </div>
                                </div>
                            </div>

                            <!-- Cột phải -->
                            <div class="col-md-4">
                                <!-- Giá -->
                                <div class="form-group mb-3">
                                    <label for="price">Giá bán <span class="required">*</span></label>
                                    <input type="number"
                                           class="form-control @error('price') is-invalid @enderror"
                                           id="price"
                                           name="price"
                                           value="{{ old('price') }}"
                                           step="0.01"
                                           placeholder="0">
                                    @error('price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- thuế -->
                                <div class="form-group mb-3">
                                    <label for="vat">Thuế <span class="required">*</span></label>
                                    <input type="number"
                                           class="form-control @error('vat') is-invalid @enderror"
                                           id="vat"
                                           name="vat"
                                           value="{{ old('vat') }}"
                                           step="0.01"
                                           placeholder="0">
                                    @error('vat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Số lượng -->
                                <div class="form-group mb-3">
                                    <label for="stock">Số lượng trong kho <span class="required">*</span></label>
                                    <input type="number"
                                           class="form-control @error('stock') is-invalid @enderror"
                                           id="stock"
                                           name="stock"
                                           value="{{ old('stock', 0) }}"
                                           placeholder="0">
                                    @error('stock')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Trạng thái -->
                                <div class="form-group mb-3">
                                    <label for="status">Trạng thái <span class="required">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Đang bán</option>
                                        <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Ngừng bán</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-center justify-items-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu sản phẩm
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Preview ảnh chính
    function previewImage(event, previewId) {
        const file = event.target.files[0];
        const preview = document.getElementById(previewId);

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }


</script>
@endpush
@endsection
