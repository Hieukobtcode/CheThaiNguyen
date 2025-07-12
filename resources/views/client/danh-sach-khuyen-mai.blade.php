@extends('layouts.client')

@section('content')
    <div class="container py-5">
        <h2 class=" mb-4 fw-bold text-uppercase text-success">Danh sách khuyến mãi hấp dẫn</h2>

        @if ($khuyenMais->isEmpty())
            <p class=" text-muted">Hiện chưa có khuyến mãi nào.</p>
        @else
            <div class="row g-4">
                @foreach ($khuyenMais as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border border-success-subtle shadow-sm rounded-4 bg-white">
                            <div class="card-body d-flex flex-column p-4">

                                <!-- Giá trị giảm -->
                                <div class="mb-3">
                                    <span class="badge bg-danger text-white px-3 py-2 fs-6 rounded-pill">
                                        -{{ number_format($item->gia_tri, 0, ',', '.') }}₫
                                    </span>
                                </div>

                                <!-- Tên khuyến mãi -->
                                <h5 class=" fw-semibold text-dark mb-3">
                                    {{ $item->ten_khuyen_mai }}
                                </h5>

                                <!-- Mã khuyến mãi -->
                                <p class=" mb-3">
                                    <strong>Mã:</strong>
                                    <span class="badge bg-warning text-dark fs-6">{{ $item->ma }}</span>
                                </p>

                                <!-- Thông tin thêm -->
                                <ul class="list-unstyled small text-muted mb-3">
                                    <li><strong>Số lượng:</strong> {{ $item->so_luong }}</li>
                                    <li>
                                        <strong>Thời gian:</strong>
                                        @if ($item->bat_dau && $item->ket_thuc)
                                            {{ \Carbon\Carbon::parse($item->bat_dau)->format('d/m/Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($item->ket_thuc)->format('d/m/Y') }}
                                        @else
                                            Không giới hạn
                                        @endif
                                    </li>
                                </ul>

                                <!-- Nút sao chép -->
                                <button class="btn btn-outline-success mt-auto w-100 rounded-pill"
                                    onclick="copyMa('{{ $item->ma }}')">
                                    Sao chép mã
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>


    <script>
        function copyMa(ma) {
            navigator.clipboard.writeText(ma).then(() => {
                alert('Đã sao chép mã: ' + ma);
            });
        }
    </script>

@endsection
