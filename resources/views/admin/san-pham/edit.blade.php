@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Chỉnh sửa sản phẩm</h5>
                <a href="{{ route('san_pham.index') }}" class="btn btn-light btn-sm">
                    <i class="ti ti-arrow-left me-1"></i> Quay lại
                </a>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('san_pham.update', $sanPham->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="ten" id="ten"
                            class="form-control @error('ten') is-invalid @enderror" value="{{ old('ten', $sanPham->ten) }}"
                            required>
                        @error('ten')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="mo_ta" class="form-label fw-semibold">Mô tả sản phẩm</label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" id="mo_ta" name="mo_ta" rows="6"
                            placeholder="Nhập mô tả chi tiết sản phẩm">{{ old('mo_ta', $sanPham->mo_ta) }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gia" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="gia" id="gia"
                            class="form-control @error('gia') is-invalid @enderror" value="{{ old('gia', $sanPham->gia) }}"
                            required>
                        @error('gia')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="so_luong" class="form-label">Số lượng <span class="text-danger">*</span></label>
                        <input type="number" name="so_luong" id="so_luong"
                            class="form-control @error('so_luong') is-invalid @enderror"
                            value="{{ old('so_luong', $sanPham->so_luong) }}" required>
                        @error('so_luong')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="hinh_anh" class="form-label">Hình ảnh sản phẩm</label>
                        <input type="file" name="hinh_anh" id="hinh_anh"
                            class="form-control @error('hinh_anh') is-invalid @enderror">
                        @if ($sanPham->hinh_anh)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $sanPham->hinh_anh) }}" alt="Hình ảnh sản phẩm"
                                    class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                        @error('hinh_anh')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="danh_muc_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select name="danh_muc_id" id="danh_muc_id"
                            class="form-select @error('danh_muc_id') is-invalid @enderror" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($danhMucs as $danhMuc)
                                <option value="{{ $danhMuc->id }}"
                                    {{ old('danh_muc_id', $sanPham->danh_muc_id) == $danhMuc->id ? 'selected' : '' }}>
                                    {{ $danhMuc->ten }}
                                </option>
                            @endforeach
                        </select>
                        @error('danh_muc_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="trang_thai" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select name="trang_thai" id="trang_thai"
                            class="form-select @error('trang_thai') is-invalid @enderror" required>
                            <option value="1" {{ old('trang_thai', $sanPham->trang_thai) == 1 ? 'selected' : '' }}>
                                Hiển thị</option>
                            <option value="0" {{ old('trang_thai', $sanPham->trang_thai) == 0 ? 'selected' : '' }}>Ẩn
                            </option>
                        </select>
                        @error('trang_thai')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('san_pham.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-2"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-2"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#mo_ta'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                    'undo', 'redo'
                ],
                language: 'vi',
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
