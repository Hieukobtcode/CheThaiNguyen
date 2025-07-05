@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('danh_muc.update', $danhMuc->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="ten" class="form-control @error('ten') is-invalid @enderror"
                            value="{{ old('ten', $danhMuc->ten) }}" required>
                        @error('ten')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('danh_muc.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-2"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
