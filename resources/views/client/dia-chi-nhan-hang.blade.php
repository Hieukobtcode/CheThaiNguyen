@extends('layouts.client')

@section('content')
    <div id="PageContainer" class="margin-page user-page">

        <div class="head-page">
            <div class="container">
                <h1 class="text-uppercase font-weight-bold mb-0 text-center">Tài khoản của tôi</h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="left-menu col-md-4">
                    <p class="fullname-user font-weight-bold title pb-2">
                        <span>{{ auth()->user()->ho_va_ten ?? 'Người dùng' }}</span>
                    </p>
                    <ul class="py-3 py-md-0 pl-0 mb-0">
                        <li>
                            <a class="d-inline-block" href="{{ route('profile') }}">
                                <span class="d-inline-block">
                                    <img loading="lazy" src="https://web.nvnstatic.net/tp/T0239/img/userProfile.png?v=9"
                                        alt="profile">
                                </span>
                                <span class="active">Hồ sơ của tôi</span>
                            </a>
                        </li>

                        <li>
                            <a class="d-inline-block" href="{{ route('dia-chi') }}">
                                <span class="d-inline-block">
                                    <i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
                                </span>
                                <span>Địa chỉ nhận hàng</span>
                            </a>
                        </li>

                        <li>
                            <a class="d-inline-block" href="{{ route('don-hang.danh-sach') }}">
                                <span class="d-inline-block">
                                    <img loading="lazy" src="https://web.nvnstatic.net/tp/T0239/img/orderfile.png?v=9"
                                        alt="orders">
                                </span>
                                <span>Đơn hàng của tôi</span>
                            </a>
                        </li>

                        <li>
                            <a class="d-inline-block" href="{{ route('lich-su-diem') }}">
                                <span class="d-inline-block">
                                    <i class="fas fa-hand-point-right"></i>
                                </span>
                                <span>Lịch sử điểm</span>
                            </a>
                        </li>

                        <li class="singout-action">
                            <a class="d-inline-block" href="/user/signout">
                                <span class="d-inline-block"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                                <span>Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="right-content col-md-8">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-3">
                        <p class="font-weight-bold title m-0 text-center text-md-left">
                            <span>Địa chỉ nhận hàng</span>
                        </p>

                        @if ($diaChis->count() >= 3)
                            <p class="text-danger m-0">Chỉ được thêm tối đa 3 địa chỉ</p>
                        @else
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#themDiaChiModal">
                                Thêm địa chỉ
                            </button>
                        @endif
                    </div>

                    @foreach ($diaChis as $diaChi)
                        <div class="border rounded p-3 mb-3 d-flex g-5">
                            <div class="info flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <strong>{{ $diaChi->ho_va_ten }}</strong>
                                        <span class="text-muted ms-2">(+84) {{ $diaChi->so_dien_thoai }}</span>
                                    </div>
                                </div>

                                <div class="text-muted">
                                    {{ $diaChi->dia_chi_cu_the }}<br>
                                    {{ $diaChi->phuong_xa }}, {{ $diaChi->quan_huyen }}, {{ $diaChi->tinh_thanh }}
                                </div>

                                @if ($diaChi->mac_dinh == 1)
                                    <button type="button" class="mt-3 btn btn-outline-danger">Mặc định</button>
                                @else
                                    <a href="{{ route('dia-chi.chon-mac-dinh', $diaChi->id) }}">
                                        <button type="button" class="mt-3 btn btn-outline-danger">Đặt làm mặc định</button>
                                    </a>
                                @endif
                            </div>

                            <div class="ms-auto d-flex align-items-center gap-3">
                                <button type="button" class="btn btn-link text-danger p-0 m-0 d-flex align-items-center"
                                    data-bs-toggle="modal" data-bs-target="#suaDiaChiModal-{{ $diaChi->id }}">
                                    Cập nhật
                                </button>

                                <form action="{{ route('dia-chi.xoa', $diaChi->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xoá địa chỉ này không?');"
                                    class="m-0 p-0 d-flex align-items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-link text-danger p-0 m-0 d-flex align-items-center">
                                        Xóa
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Địa Chỉ -->
    <div class="modal fade" id="themDiaChiModal" tabindex="-1" aria-labelledby="themDiaChiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('dia-chi.them') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="themDiaChiModalLabel">Thêm địa chỉ mới</h5>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ten_nguoi_nhan" class="form-label">Tên người nhận</label>
                            <input type="text" class="form-control" name="ten_nguoi_nhan" required>
                        </div>

                        <div class="mb-3">
                            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" name="so_dien_thoai" required>
                        </div>

                        <div class="mb-3">
                            <label for="tinh_thanh" class="form-label">Tỉnh / Thành phố</label>
                            <select id="tinh_thanh" class="form-select" required></select>
                            <input type="hidden" name="tinh_thanh" id="ten_tinh_thanh">
                        </div>

                        <div class="mb-3">
                            <label for="quan_huyen" class="form-label">Quận / Huyện</label>
                            <select id="quan_huyen" class="form-select" required disabled></select>
                            <input type="hidden" name="quan_huyen" id="ten_quan_huyen">
                        </div>

                        <div class="mb-3">
                            <label for="phuong_xa" class="form-label">Phường / Xã</label>
                            <select id="phuong_xa" class="form-select" required disabled></select>
                            <input type="hidden" name="phuong_xa" id="ten_phuong_xa">
                        </div>

                        <div class="mb-3">
                            <label for="dia_chi" class="form-label">Địa chỉ chi tiết</label>
                            <textarea class="form-control" name="dia_chi" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu địa chỉ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Sửa Địa Chỉ -->
    @foreach ($diaChis as $diaChi)
        <div class="modal fade" id="suaDiaChiModal-{{ $diaChi->id }}" tabindex="-1"
            aria-labelledby="suaDiaChiModalLabel-{{ $diaChi->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('dia-chi.cap-nhat', $diaChi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="suaDiaChiModalLabel-{{ $diaChi->id }}">Cập nhật địa chỉ</h5>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" name="ho_va_ten" class="form-control"
                                    value="{{ $diaChi->ho_va_ten }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="so_dien_thoai" class="form-control"
                                    value="{{ $diaChi->so_dien_thoai }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tỉnh / Thành phố</label>
                                <select name="tinh_thanh" class="form-select" required>
                                    <option value="">-- Chọn tỉnh/thành --</option>
                                    <option selected value="">
                                        {{ $diaChi->tinh_thanh }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quận / Huyện</label>
                                <select name="quan_huyen" class="form-select" required>
                                    <option value="">-- Chọn quận/huyện --</option>
                                    <option selected value="">
                                        {{ $diaChi->quan_huyen }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phường / Xã</label>
                                <select name="phuong_xa" class="form-select" required>
                                    <option value="">-- Chọn phường/xã --</option>
                                    <option selected value="">
                                        {{ $diaChi->phuong_xa }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ cụ thể</label>
                                <textarea name="dia_chi_cu_the" class="form-control" rows="3" required>{{ $diaChi->dia_chi_cu_the }}</textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        async function loadDiaChiSelects(diaChiId, diaChiCu) {
            const tinhSelect = document.querySelector(`#suaDiaChiModal-${diaChiId} select[name="tinh_thanh"]`);
            const quanSelect = document.querySelector(`#suaDiaChiModal-${diaChiId} select[name="quan_huyen"]`);
            const phuongSelect = document.querySelector(`#suaDiaChiModal-${diaChiId} select[name="phuong_xa"]`);

            tinhSelect.innerHTML = `<option value="">-- Chọn tỉnh/thành --</option>`;
            quanSelect.innerHTML = `<option value="">-- Chọn quận/huyện --</option>`;
            phuongSelect.innerHTML = `<option value="">-- Chọn phường/xã --</option>`;

            try {
                const resTinh = await axios.get(
                    "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province", {
                        headers: {
                            token: "266f556b-5bb4-11f0-9b81-222185cb68c8"
                        }
                    });

                resTinh.data.data.forEach(tinh => {
                    const selected = tinh.ProvinceName === diaChiCu.tinh_thanh ? 'selected' : '';
                    tinhSelect.innerHTML +=
                        `<option value="${tinh.ProvinceName}" ${selected}>${tinh.ProvinceName}</option>`;
                });

                if (diaChiCu.tinh_thanh) {
                    await loadQuanHuyen(diaChiId, diaChiCu);
                }
            } catch (error) {
                console.error("Lỗi load tỉnh:", error);
            }

            tinhSelect.addEventListener("change", () => {
                loadQuanHuyen(diaChiId);
            });

            quanSelect.addEventListener("change", () => {
                loadPhuongXa(diaChiId);
            });
        }

        async function loadQuanHuyen(diaChiId, diaChiCu = null) {
            const tinhSelect = document.querySelector(`#suaDiaChiModal-${diaChiId} select[name="tinh_thanh"]`);
            const quanSelect = document.querySelector(`#suaDiaChiModal-${diaChiId} select[name="quan_huyen"]`);
            const phuongSelect = document.querySelector(`#suaDiaChiModal-${diaChiId} select[name="phuong_xa"]`);

            quanSelect.innerHTML = `<option value="">-- Chọn quận/huyện --</option>`;
            phuongSelect.innerHTML = `<option value="">-- Chọn phường/xã --</option>`;
            phuongSelect.disabled = true;

            try {
                const resDistrict = await axios.get(
                    "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district", {
                        headers: {
                            token: "266f556b-5bb4-11f0-9b81-222185cb68c8"
                        },
                        params: {
                            province_id: await getProvinceId(tinhSelect.value)
                        }
                    });

                resDistrict.data.data.forEach(quan => {
                    const selected = diaChiCu && quan.DistrictName === diaChiCu.quan_huyen ? 'selected' : '';
                    quanSelect.innerHTML +=
                        `<option value="${quan.DistrictName}" ${selected}>${quan.DistrictName}</option>`;
                });

                quanSelect.disabled = false;

                if (diaChiCu && diaChiCu.quan_huyen) {
                    await loadPhuongXa(diaChiId, diaChiCu);
                }
            } catch (err) {
                console.error("Lỗi load quận/huyện:", err);
            }
        }

        async function loadPhuongXa(diaChiId, diaChiCu = null) {
            const quanSelect = document.querySelector(`#suaDiaChiModal-${diaChiId} select[name="quan_huyen"]`);
            const phuongSelect = document.querySelector(`#suaDiaChiModal-${diaChiId} select[name="phuong_xa"]`);

            phuongSelect.innerHTML = `<option value="">-- Chọn phường/xã --</option>`;

            try {
                const resWard = await axios.get("https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward", {
                    headers: {
                        token: "266f556b-5bb4-11f0-9b81-222185cb68c8"
                    },
                    params: {
                        district_id: await getDistrictId(quanSelect.value)
                    }
                });

                resWard.data.data.forEach(phuong => {
                    const selected = diaChiCu && phuong.WardName === diaChiCu.phuong_xa ? 'selected' : '';
                    phuongSelect.innerHTML +=
                        `<option value="${phuong.WardName}" ${selected}>${phuong.WardName}</option>`;
                });

                phuongSelect.disabled = false;
            } catch (err) {
                console.error("Lỗi load phường/xã:", err);
            }
        }

        async function getProvinceId(provinceName) {
            const res = await axios.get("https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province", {
                headers: {
                    token: "266f556b-5bb4-11f0-9b81-222185cb68c8"
                }
            });

            const province = res.data.data.find(p => p.ProvinceName === provinceName);
            return province ? province.ProvinceID : null;
        }

        async function getDistrictId(districtName) {
            const res = await axios.get("https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district", {
                headers: {
                    token: "266f556b-5bb4-11f0-9b81-222185cb68c8"
                }
            });

            const district = res.data.data.find(d => d.DistrictName === districtName);
            return district ? district.DistrictID : null;
        }

        document.addEventListener("DOMContentLoaded", () => {
            @foreach ($diaChis as $diaChi)
                loadDiaChiSelects({{ $diaChi->id }}, {
                    tinh_thanh: "{{ $diaChi->tinh_thanh }}",
                    quan_huyen: "{{ $diaChi->quan_huyen }}",
                    phuong_xa: "{{ $diaChi->phuong_xa }}"
                });
            @endforeach
        });
    </script>

    <script>
        async function initHanhChinhVN() {
            const tinhSelect = document.getElementById("tinh_thanh");
            const quanSelect = document.getElementById("quan_huyen");
            const phuongSelect = document.getElementById("phuong_xa");

            const inputTenTinh = document.getElementById("ten_tinh_thanh");
            const inputTenQuan = document.getElementById("ten_quan_huyen");
            const inputTenPhuong = document.getElementById("ten_phuong_xa");

            tinhSelect.innerHTML = `<option value="">-- Chọn tỉnh/thành --</option>`;
            quanSelect.innerHTML = `<option value="">-- Chọn quận/huyện --</option>`;
            phuongSelect.innerHTML = `<option value="">-- Chọn phường/xã --</option>`;
            quanSelect.disabled = true;
            phuongSelect.disabled = true;

            try {
                const resTinh = await axios.get(
                    "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province", {
                        headers: {
                            token: "266f556b-5bb4-11f0-9b81-222185cb68c8"
                        }
                    });

                resTinh.data.data.forEach(tinh => {
                    tinhSelect.innerHTML += `<option value="${tinh.ProvinceID}">${tinh.ProvinceName}</option>`;
                });
            } catch (err) {
                console.error("Lỗi API tỉnh/thành:", err);
            }

            tinhSelect.addEventListener("change", async function() {
                const provinceId = this.value;
                inputTenTinh.value = this.options[this.selectedIndex].text;

                quanSelect.innerHTML = `<option value="">-- Chọn quận/huyện --</option>`;
                phuongSelect.innerHTML = `<option value="">-- Chọn phường/xã --</option>`;
                quanSelect.disabled = true;
                phuongSelect.disabled = true;
                inputTenQuan.value = '';
                inputTenPhuong.value = '';

                if (!provinceId) return;

                try {
                    const resQuan = await axios.get(
                        `https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district?province_id=${provinceId}`, {
                            headers: {
                                token: "266f556b-5bb4-11f0-9b81-222185cb68c8"
                            }
                        });

                    resQuan.data.data.forEach(quan => {
                        quanSelect.innerHTML +=
                            `<option value="${quan.DistrictID}">${quan.DistrictName}</option>`;
                    });

                    quanSelect.disabled = false;
                } catch (err) {
                    console.error("Lỗi API quận/huyện:", err);
                }
            });

            quanSelect.addEventListener("change", async function() {
                const districtId = this.value;
                inputTenQuan.value = this.options[this.selectedIndex].text;

                phuongSelect.innerHTML = `<option value="">-- Chọn phường/xã --</option>`;
                phuongSelect.disabled = true;
                inputTenPhuong.value = '';

                if (!districtId) return;

                try {
                    const resPhuong = await axios.get(
                        `https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id=${districtId}`, {
                            headers: {
                                token: "266f556b-5bb4-11f0-9b81-222185cb68c8"
                            }
                        });

                    resPhuong.data.data.forEach(phuong => {
                        phuongSelect.innerHTML +=
                            `<option value="${phuong.WardCode}">${phuong.WardName}</option>`;
                    });

                    phuongSelect.disabled = false;
                } catch (err) {
                    console.error("Lỗi API phường/xã:", err);
                }
            });

            phuongSelect.addEventListener("change", function() {
                inputTenPhuong.value = this.options[this.selectedIndex].text;
            });
        }

        document.addEventListener("DOMContentLoaded", initHanhChinhVN);
    </script>
@endsection
