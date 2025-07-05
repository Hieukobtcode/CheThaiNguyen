@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('voucher.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="ten_khuyen_mai" class="form-label">Tên khuyến mãi <span
                                class="text-danger">*</span></label>
                        <input type="text" name="ten_khuyen_mai" id="ten_khuyen_mai"
                            class="form-control @error('ten_khuyen_mai') is-invalid @enderror"
                            value="{{ old('ten_khuyen_mai') }}" required>
                        @error('ten_khuyen_mai')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ma" class="form-label">Mã khuyến mãi <span class="text-danger">*</span></label>
                        <input type="text" name="ma" id="ma"
                            class="form-control @error('ma') is-invalid @enderror" value="{{ old('ma') }}" required>
                        @error('ma')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gia_tri" class="form-label">Giá trị giảm (VNĐ) <span
                                class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="gia_tri" id="gia_tri"
                            class="form-control @error('gia_tri') is-invalid @enderror" value="{{ old('gia_tri') }}"
                            required>
                        @error('gia_tri')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="so_luong" class="form-label">Số lượng <span class="text-danger">*</span></label>
                        <input type="number" name="so_luong" id="so_luong"
                            class="form-control @error('so_luong') is-invalid @enderror" value="{{ old('so_luong', 1) }}"
                            required>
                        @error('so_luong')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bat_dau" class="form-label">Thời gian bắt đầu</label>
                        <input type="datetime-local" name="bat_dau" id="bat_dau"
                            class="form-control @error('bat_dau') is-invalid @enderror" value="{{ old('bat_dau') }}">
                        @error('bat_dau')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ket_thuc" class="form-label">Thời gian kết thúc</label>
                        <input type="datetime-local" name="ket_thuc" id="ket_thuc"
                            class="form-control @error('ket_thuc') is-invalid @enderror" value="{{ old('ket_thuc') }}">
                        @error('ket_thuc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('voucher.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-2"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            Lưu khuyến mãi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
