@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Thêm bài viết mới</h5>
                <a href="{{ route('bai_viet.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('bai_viet.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="tieu_de" class="form-label fw-semibold">Tiêu đề <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tieu_de') is-invalid @enderror" id="tieu_de"
                            name="tieu_de" value="{{ old('tieu_de') }}" placeholder="Nhập tiêu đề bài viết">
                        @error('tieu_de')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="noi_dung" class="form-label fw-semibold">Nội dung <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('noi_dung') is-invalid @enderror" id="noi_dung" name="noi_dung" rows="6"
                            placeholder="Nhập nội dung bài viết">{{ old('noi_dung') }}</textarea>
                        @error('noi_dung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="hinh_anh" class="form-label fw-semibold">Hình ảnh</label>
                        <input type="file" class="form-control @error('hinh_anh') is-invalid @enderror" id="hinh_anh"
                            name="hinh_anh">
                        @error('hinh_anh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-semibold">Trạng thái <span
                                class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Xuất bản
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('bai_viet.index') }}" class="btn btn-outline-secondary btn-cancel">
                            Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Lưu
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
            .create(document.querySelector('#noi_dung'), {
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
