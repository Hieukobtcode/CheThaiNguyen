@extends('layouts.admin')

@section('content')
    @php
        $trangThais = [
            'tat_ca' => 'Tất cả',
            'cho_xac_nhan' => 'Chờ xác nhận',
            'da_xac_nhan' => 'Đã xác nhận',
            'dang_giao' => 'Đang giao',
            'da_giao' => 'Đã giao',
            'da_hoan_thanh' => 'Đã hoàn thành',
            'da_huy' => 'Đã hủy',
            'that_bai' => 'Thất bại',
        ];

        $counts = [
            'tat_ca' => $donHangs->total(),
            'cho_xac_nhan' => $donHangs->where('trang_thai', 'cho_xac_nhan')->count(),
            'da_xac_nhan' => $donHangs->where('trang_thai', 'da_xac_nhan')->count(),
            'dang_giao' => $donHangs->where('trang_thai', 'dang_giao')->count(),
            'da_giao' => $donHangs->where('trang_thai', 'da_giao')->count(),
            'da_hoan_thanh' => $donHangs->where('trang_thai', 'da_hoan_thanh')->count(),
            'da_huy' => $donHangs->where('trang_thai', 'da_huy')->count(),
            'that_bai' => $donHangs->where('trang_thai', 'that_bai')->count(),
        ];
    @endphp
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <div class="d-flex justify-content-center mb-5">
                    <div class="bg-light rounded-pill px-3 py-2 shadow-sm" style="max-width: 100%; overflow-x: auto;">
                        <ul class="nav nav-pills flex-nowrap" id="donHangTab" role="tablist"
                            style="gap: 0.5rem; white-space: nowrap;">
                            @foreach ($trangThais as $key => $label)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-1 px-3 small {{ $loop->first ? 'active' : '' }}"
                                        id="{{ $key }}-tab" data-bs-toggle="tab"
                                        data-bs-target="#{{ $key }}" type="button" role="tab"
                                        aria-controls="{{ $key }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $label }} ({{ $counts[$key] }})
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="tab-content" id="donHangTabContent">
                    @foreach ($trangThais as $key => $label)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}"
                            role="tabpanel" aria-labelledby="{{ $key }}-tab">
                            <div class="table-responsive">
                                <table class="table text-nowrap align-middle mb-0">
                                    <thead class="bg-gradient-dark text-white">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Mã đơn hàng</th>
                                            <th class="text-center">Tổng tiền</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Ngày tạo</th>
                                            <th class="text-center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $filtered =
                                                $key === 'tat_ca'
                                                    ? $donHangs
                                                    : $donHangs->filter(fn($d) => $d->trang_thai === $key);
                                        @endphp

                                        @forelse ($filtered as $index => $donHang)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $donHang->ma_van_don ?? 'Không có' }}</td>
                                                <td class="text-center">
                                                    {{ number_format($donHang->tong_tien, 0, ',', '.') }}₫
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-info">
                                                        {{ $trangThais[$donHang->trang_thai] ?? 'Không xác định' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($donHang->created_at)->format('d/m/Y') }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('don_hang.show', $donHang->id) }}"
                                                        class="btn btn-sm btn-outline-primary">Xem</a>

                                                    @if ($donHang->trang_thai === 'cho_xac_nhan')
                                                        <form action="{{ route('don-hang.xac-nhan', $donHang->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Xác nhận đơn hàng này?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">Xác
                                                                nhận</button>
                                                        </form>
                                                    @endif

                                                    @if ($donHang->trang_thai === 'da_xac_nhan')
                                                        <form action="{{ route('don-hang.dang-giao', $donHang->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Xác nhận đơn hàng đã giao cho đơn vị vận chuyển!')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">Giao
                                                                hàng</button>
                                                        </form>
                                                    @endif

                                                    @if ($donHang->trang_thai === 'dang_giao')
                                                        <form action="{{ route('don-hang.da-giao', $donHang->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Xác nhận đơn hàng đã được giao đến khách hàng!')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">Đã
                                                                giao</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="ti ti-folder-open me-1"></i> Không có đơn hàng nào
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <small class="text-muted">
                        Hiển thị {{ $donHangs->count() }} trong tổng số {{ $donHangs->total() }} đơn hàng
                    </small>
                    <div>
                        {{ $donHangs->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
