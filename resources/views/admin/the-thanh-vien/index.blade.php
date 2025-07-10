@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('cap_bac.create') }}"
                        class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 py-2 px-3">
                        <i class="ti ti-plus fs-5"></i> Thêm cấp thẻ
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0">
                        <thead class="bg-gradient-dark text-white">
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th>Tên cấp thẻ</th>
                                <th class="text-center">Tổng chi tiêu</th>
                                <th class="text-center">Ưu đãi (%)</th>
                                <th class="text-center" style="width: 15%">Ngày tạo</th>
                                <th class="text-center" style="width: 10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="capTheTable">
                            @forelse($capThes as $index => $capThe)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($capThe->ten, 50) }}</td>
                                    <td class="text-center">{{ $capThe->diem_toi_thieu }}</td>
                                    <td class="text-center">{{ $capThe->uu_dai }}%</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($capThe->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('cap_bac.edit', $capThe->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">
                                                        <i class="ti ti-edit fs-5"></i>Sửa
                                                    </a>
                                                </li>
                                                {{-- <li>
                                                    <form action="{{ route('cap_bac.destroy', $capThe->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa cấp thẻ này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center gap-2">
                                                            <i class="ti ti-trash fs-5 text-danger"></i> Xóa
                                                        </button>
                                                    </form>
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyRow">
                                    <td colspan="6" class="text-center text-muted py-3">
                                        <i class="ti ti-folder-open me-1"></i> Không có dữ liệu
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
