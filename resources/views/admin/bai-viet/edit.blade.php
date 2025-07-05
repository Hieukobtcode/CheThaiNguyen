@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('bai_viet.update', $baiViet->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="tieu_de" class="form-label fw-semibold">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tieu_de') is-invalid @enderror" id="tieu_de"
                            name="tieu_de" value="{{ old('tieu_de', $baiViet->tieu_de) }}"
                            placeholder="Nhập tiêu đề bài viết">
                        @error('tieu_de')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="noi_dung" class="form-label fw-semibold">Nội dung <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('noi_dung') is-invalid @enderror" id="noi_dung" name="noi_dung" rows="10"
                            placeholder="Nhập nội dung bài viết">{{ old('noi_dung', $baiViet->noi_dung) }}</textarea>
                        @error('noi_dung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="hinh_anh" class="form-label fw-semibold">Hình ảnh</label>
                        <input type="file" class="form-control @error('hinh_anh') is-invalid @enderror" id="hinh_anh"
                            name="hinh_anh">
                        @if ($baiViet->hinh_anh)
                            <img src="{{ asset('storage/' . $baiViet->hinh_anh) }}" alt="Hình hiện tại"
                                class="img-thumbnail mt-2 rounded" style="max-height: 180px;">
                        @endif
                        @error('hinh_anh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="status" class="form-label fw-semibold">Trạng thái <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="published"
                                    {{ old('status', $baiViet->status) === 'published' ? 'selected' : '' }}>Xuất bản
                                </option>
                                <option value="draft" {{ old('status', $baiViet->status) === 'draft' ? 'selected' : '' }}>
                                    Bản nháp</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('bai_viet.index') }}" class="btn btn-outline-secondary" title="Hủy">
                            <i class="ti ti-x me-1"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary" title="Cập nhật">
                            <i class="ti ti-device-floppy me-1"></i> Cập nhật
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
