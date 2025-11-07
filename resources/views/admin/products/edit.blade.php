@extends('layouts.admin')

@section('title', 'Profile')
@section('content')
<div class="card p-4 shadow-sm profile-edit">
    <h3 class="text-center mb-4">Chỉnh sửa Sản phẩm </h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.products.update', $products->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <ul>
            <li>
                <label>Tên sản phẩm <span class="required">*</span></label>
                <div>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required value="{{ old('name', $products->name) }}">
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Mô tả:</label>
                <div>
                    <input type="text" name="description" class="form-control" placeholder="Mô tả" required value="{{ old('description', $products->description) }}">
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>Giá <span class="required">*</span></label>
                <div>
                    <input type="text" name="price" class="form-control" placeholder="Nhập giá" required value="{{ old('price', $products->price) }}">
                    @error('price')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label>VAT % <span class="required">*</span></label>
                <div>
                    <input type="text" name="vat" class="form-control" placeholder="Nhập vat" required value="{{ old('vat', $products->vat) }}">
                    @error('vat')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label for="image">Ảnh sản phẩm <span class="required">*</span></label>
                <div class="d-flex gap-3">
                    @if($products->image)
                        <div class="mb-2 position-relative d-inline-block">
                            <img id="current-image"
                                    src="{{ Storage::url($products->image) }}"
                                    alt="Current Image"
                                    class="img-thumbnail"
                                    style="max-width: 200px; display: block;">

                            <!-- Nút xóa ảnh cũ -->
                            <button id="btn-delete-img" type="button"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                    onclick="removeCurrentImage()"
                                    title="Xóa ảnh này">
                                x
                            </button>

                            <!-- Input hidden để đánh dấu xóa ảnh -->
                            <input type="hidden" name="remove_image" id="remove_image" value="0">
                        </div>
                    @endif
                    <div>
                        <small class="text-muted d-block mb-2">Ảnh hiện tại. Chọn ảnh mới để thay đổi.</small>
                        <!-- Input upload ảnh mới -->
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                        <!-- Preview ảnh mới -->
                        <div class="mt-2">
                            <img id="preview-image"
                                    src=""
                                    alt="Preview"
                                    class="img-thumbnail"
                                    style="max-width: 200px; display: none;">
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <label>Số lượng sửa kho <span class="required">*</span></label>
                <div>
                    <input type="text" name="stock" class="form-control" placeholder="Nhập số lượng tồn kho" required value="{{ old('stock', $products->stock) }}">
                    @error('stock')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </li>
            <li>
                <label for="status">Trạng thái <span class="required">*</span></label>
                <div>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="active" {{ old('status',  $products->status) == 'active' ? 'selected' : '' }}>Đang bán</option>
                        <option value="out_of_stock" {{ old('status',  $products->status) == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
                        <option value="draft" {{ old('status',  $products->status) == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="inactive" {{ old('status',  $products->status) == 'inactive' ? 'selected' : '' }}>Ngừng bán</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </li>
            <li>
                <div class="flex-d w-full">
                    <button type="submit" class="btn btn-primary w-100">Cập nhật lại</button>
                </div>
            </li>
        </ul>
    </form>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {

        // Attach event listener cho ảnh chính
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('change', function(event) {
                previewImage(event);
            });
        }

        // Attach event listener cho nhiều ảnh
        const imagesInput = document.getElementById('images');
        if (imagesInput) {
            imagesInput.addEventListener('change', function(event) {
                previewMultipleImages(event);
            });
        }
    });
    // Preview ảnh chính

     function previewImage(event) {
        console.log(event);
        const file = event.target.files[0];
        const preview = document.getElementById('preview-image');
        const currentImage = document.getElementById('current-image');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';

                // Ẩn ảnh cũ khi có ảnh mới
               // if (currentImage) {
                  //  currentImage.style.display = 'none';
               // }
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            if (currentImage) {
                currentImage.style.display = 'block';
            }
        }
    }
    function removeCurrentImage() {
        if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
            document.getElementById('current-image').style.display = 'none';
            document.getElementById('remove_image').value = '1';
            document.getElementById('image').value = '';
            document.getElementById('preview-image').style.display = 'none';
            document.getElementById('btn-delete-img').style.display = 'none';
        }
    }


</script>
@endpush
@endsection
