@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card p-4 shadow-sm">
            <h5 class="mb-3">Chi tiết bình luận</h5>

            <div class="d-flex align-items-start mb-4">
                <img src="{{ asset('storage/' . ($binhLuan->nguoiDung->anh_dai_dien ?? 'icon/user.png')) }}" alt="Avatar"
                    class="rounded-circle me-3" width="60" height="60">
                <div>
                    <p class="mb-1">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $binhLuan->danh_gia)
                                <i class="text-warning ti ti-star-filled"></i>
                            @else
                                <i class="text-muted ti ti-star"></i>
                            @endif
                        @endfor
                        <span class="ms-1">({{ $binhLuan->danh_gia }}/5)</span>
                    </p>
                    <p class="mb-0">{{ $binhLuan->noi_dung }}</p>
                </div>
            </div>

            <hr>

            <h6>Phản hồi</h6>
            @if ($binhLuan->phanHoi)
                <div class="d-flex align-items-start border rounded p-2 mb-3">
                    <img src="{{ asset('storage/' . ($binhLuan->phanHoi->nguoiDung->anh_dai_dien ?? 'icon/user.png')) }}"
                        alt="Avatar" class="rounded-circle me-3" width="45" height="45">
                    <div>
                        <div class="d-flex justify-content-between">
                            <strong>{{ $binhLuan->phanHoi->nguoiDung->ten ?? '[Ẩn danh]' }}</strong>
                            <small class="text-muted ms-2">{{ $binhLuan->phanHoi->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="mb-0">{{ $binhLuan->phanHoi->noi_dung }}</p>
                    </div>
                </div>
            @else
                <p class="text-muted">Chưa có phản hồi nào.</p>
            @endif


            <hr>

            @if (!$binhLuan->phanHoi)
                <h6>Thêm phản hồi</h6>
                <form action="{{ route('phan_hoi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="binh_luan_id" value="{{ $binhLuan->id }}">
                    <input type="hidden" name="nguoi_dung_id" value="{{ auth()->id() }}">
                    <div class="mb-3">
                        <textarea name="noi_dung" class="form-control" rows="3" placeholder="Nhập phản hồi..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                </form>
            @else
                <p class="text-muted fst-italic">Phản hồi đã được gửi.</p>
            @endif

        </div>
    </div>
@endsection
