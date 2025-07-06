@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="tieu_de" class="form-label">Tiêu đề banner <span class="text-danger">*</span></label>
                        <input type="text" name="tieu_de" class="form-control @error('tieu_de') is-invalid @enderror"
                            value="{{ old('tieu_de', $banner->tieu_de) }}" required>
                        @error('tieu_de')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="hinh_anh" class="form-label">Hình ảnh</label>
                        @if ($banner->hinh_anh)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $banner->hinh_anh) }}" alt=""
                                    style="width: 150px; border-radius: 8px;">
                            </div>
                        @endif
                        <input type="file" name="hinh_anh" class="form-control @error('hinh_anh') is-invalid @enderror">
                        @error('hinh_anh')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="trang_thai" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select name="trang_thai" class="form-select @error('trang_thai') is-invalid @enderror" required>
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1" {{ old('trang_thai', $banner->trang_thai) == 1 ? 'selected' : '' }}>Hiển
                                thị</option>
                            <option value="0" {{ old('trang_thai', $banner->trang_thai) == 0 ? 'selected' : '' }}>Ẩn
                            </option>
                        </select>
                        @error('trang_thai')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('banner.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-2"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-device-floppy me-2"></i> Cập nhật banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
