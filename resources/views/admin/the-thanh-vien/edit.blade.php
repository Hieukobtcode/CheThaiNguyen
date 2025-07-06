@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Sửa cấp bậc thành viên</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('cap_bac.update', $capBac->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên cấp bậc <span class="text-danger">*</span></label>
                        <input type="text" name="ten" id="ten" class="form-control"
                            value="{{ old('ten', $capBac->ten) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="diem_toi_thieu" class="form-label">Điểm tối thiểu <span
                                class="text-danger">*</span></label>
                        <input type="number" name="diem_toi_thieu" id="diem_toi_thieu" class="form-control"
                            value="{{ old('diem_toi_thieu', $capBac->diem_toi_thieu) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="ti_le_tich_diem" class="form-label">Tỉ lệ tích điểm <span
                                class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="ti_le_tich_diem" id="ti_le_tich_diem"
                            class="form-control" value="{{ old('ti_le_tich_diem', $capBac->ti_le_tich_diem) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="uu_dai" class="form-label">Ưu đãi</label>
                        <textarea name="uu_dai" id="uu_dai" class="form-control" rows="3">{{ old('uu_dai', $capBac->uu_dai) }}</textarea>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('cap_bac.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
