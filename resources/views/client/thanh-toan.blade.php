<!DOCTYPE html>
<html lang="vi-VN" data-nhanh.vn-template="T0239">

<head>

    <link rel="preconnect" href="https://web.nvnstatic.net/" crossorigin>
    <link rel="preconnect" href="https://pos.nvncdn.com/" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com/" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="preconnect" href="https://pos.nvnstatic.net/" crossorigin>
    <meta name="robots" content="noindex" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <meta charset="utf-8">
    <title>Thanh toán</title>
    <link
        href="https&#x3A;&#x2F;&#x2F;pos.nvncdn.com&#x2F;eb9ddb-116318&#x2F;store&#x2F;20220301_yuwQBfxunQqfEwmcJ024zvuy.png"
        rel="icon" type="image&#x2F;vnd.microsoft.icon">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/bootstrap/bootstrap-3.3.5.min.css?v=5" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/font-awesome.min.css?v=5" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/js/jquery/fancybox-2.1.5/source/jquery.fancybox.css?v=5"
        type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/appLib.css" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/tp/T0239/css/font.css?v=8" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/tp/T0239/css/checkout.css?v=8" type="text/css">
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery.min.js?v=32"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/lib.js?v=32"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery.cookie.js?v=32"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery-ui.min.js?v=32"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery.number.min.js?v=32"></script>
    <script defer type="text/javascript"
        src="https://web.nvnstatic.net/js/jquery/fancybox-2.1.5/source/jquery.fancybox.js?v=32"></script>
    <style type="text/css"></style>
    <style type="text/css">
        img {
            max-width: 100%;
        }

        .fb-customerchat>span>iframe.fb_customer_chat_bounce_out_v2 {
            max-height: 0 !important;
        }

        .fb-customerchat>span>iframe.fb_customer_chat_bounce_in_v2 {
            max-height: calc(100% - 80px) !important;
        }
    </style>
    <script src="https://pos.nvnstatic.net/cache/location.vn.js?v=20250708_2" defer></script>
    <style>
        figure.image {
            clear: both;
            display: table;
            margin: .9em auto;
            min-width: 50px;
            text-align: center;
            width: auto !important;
        }

        figure.image img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            min-width: 100%;
        }

        figure.image>figcaption {
            background-color: #f7f7f7;
            caption-side: bottom;
            color: #333;
            display: block;
            font-size: .75em;
            outline-offset: -1px;
            padding: .6em;
            word-break: break-word;
        }

        figure.image img,
        img.image_resized {
            height: auto !important;
            aspect-ratio: auto !important;
        }
    </style>
    <script src="https://web.nvnstatic.net/js/translate/vi-vn.js" defer></script>
</head>

<body class="ins_home">
    @if (session('error'))
        <div style="color: red">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    <div id="wrapper" class="clearfix">
        <div class="ins-page">

            <link rel="stylesheet" href="https://web.nvnstatic.net/css/validationEngine.jquery.css?v=5" type="text/css">
            <link rel="stylesheet" href="https://web.nvnstatic.net/css/appLib.css" type="text/css">

            <style>
                #paymentMethod input[type="radio"] {
                    -webkit-appearance: radio;
                }

                #paymentMethod .b {
                    padding: 5px 0;
                }

                .listBank {
                    display: none;
                }

                .listBank>span {
                    padding: 0 1px;
                }

                .listBank>span:hover,
                .listBank>span.active {
                    background: #999;
                    /*border: 1px solid #999;*/
                    transition: all 200ms ease;
                    display: inline-block;
                    cursor: pointer;
                }

                .main,
                .sidebar {
                    padding-top: 0;
                }

                @media screen and (max-width: 1000px) {
                    form#formCheckOut {
                        display: flex;
                        flex-direction: column;
                    }

                    .main {
                        order: 1;
                    }

                    .sidebar {
                        order: 2;
                    }
                }
            </style>

            <div class="content">
                <div class="wrap" style="max-width: none;">
                    <div class="container text-center">
                        <a href="/">
                            <img loading="lazy"
                                src="{{ asset('storage/logo_web/logo.jpg') }}"
                                alt="Logo" style="max-height: 120px; margin: 20px 0;">
                        </a>
                    </div>

                    <div class="row" style="margin: 0;">

                        <form action="{{ route('gio_hang.xu_ly_thanh_toan') }}" method="post">
                            @csrf
                            <div class="sidebar">
                                <input type="hidden" name="dia_chi_id" value="{{ $diaChi->id }}">
                                <div class="sidebar-content">
                                    <div class="order-summary order-summary-is-collapsed" style="height: auto;">
                                        <div class="order-summary-sections">
                                            <div class="order-summary-section order-summary-section-product-list">

                                                <table class="product-table">
                                                    <tbody>
                                                        @foreach ($chiTietGioHangs as $item)
                                                            <tr class="product">

                                                                <td class="product-image">
                                                                    <div class="product-thumbnail">

                                                                        <div class="product-thumbnail-wrapper">
                                                                            <img loading="lazy"
                                                                                class="product-thumbnail-image"
                                                                                alt="Kính Gucci Havana - 40"
                                                                                src="{{ $item->sanPham->hinh_anh ? asset('storage/' . $item->sanPham->hinh_anh) : asset('storage/icon/icon_sp.png') }}" />/>
                                                                        </div>

                                                                        <span class="product-thumbnail-quantity"
                                                                            aria-hidden="true">{{ $item->so_luong }}
                                                                        </span>
                                                                    </div>
                                                                </td>

                                                                <td class="product-description">
                                                                    <span
                                                                        class="product-description-name order-summary-emphasis">
                                                                        {{ $item->sanPham->ten }}
                                                                    </span>
                                                                </td>
                                                                <td class="product-quantity visually-hidden">1</td>
                                                                <td class="product-price">
                                                                    <span class="order-summary-emphasis">
                                                                        {{ number_format($item->sanPham->gia * $item->so_luong) }}₫
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="order-summary-section order-summary-section-discount">
                                                <div class="fieldset">

                                                    <div class="field  ">

                                                        <div class="field-input-btn-wrapper">
                                                            <div class="field-input-wrapper">
                                                                <input id="coupon" type="text"
                                                                    class="field-input" name="couponCode"
                                                                    placeholder="Mã giảm giá" />
                                                            </div>
                                                            <button type="button" id="getCoupon"
                                                                class="field-input-btn btn btn-default">
                                                                <span class="btn-content" id="btn-voucher">Sử
                                                                    dụng</span>
                                                            </button>
                                                        </div>

                                                        <div id="voucher-message"
                                                            style="margin-top: 10px; color: green;">
                                                        </div>

                                                        {{-- =============================================== --}}

                                                        <div class="field-input-btn-wrapper">

                                                            <div class="field-input-wrapper">
                                                                <input id="point" type="text"
                                                                    class="field-input" name="point"
                                                                    placeholder="Đổi điểm" />
                                                            </div>

                                                            <button type="button" id="btn-point"
                                                                class="field-input-btn btn btn-default">
                                                                <span class="btn-content" id="btn-poimt">Sử
                                                                    dụng</span>
                                                            </button>

                                                        </div>
                                                        <p class="text-muted">Số điểm hiện có:
                                                            {{ Auth::user()->tong_diem }}</p>

                                                        <div id="point-message"
                                                            style="margin-top: 10px; color: green;">
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="order-summary-section order-summary-section-total-lines">
                                                <table class="total-line-table">

                                                    <tbody>
                                                        <tr class="total-line total-line-subtotal">
                                                            <td class="total-line-name">Tạm tính</td>
                                                            <td class="total-line-price">
                                                                <span class="order-summary-emphasis">
                                                                    {{ number_format($tongTien) }}₫
                                                                </span>
                                                            </td>
                                                        </tr>

                                                        <tr class="total-line total-line-shipping">
                                                            <td class="total-line-name">Phí vận chuyển</td>
                                                            <td class="total-line-price">
                                                                @php
                                                                    $tongTienxShip = $tongTien + 30000;
                                                                @endphp
                                                                <span class="order-summary-emphasis" id="ship_fee">
                                                                    30,000₫
                                                                </span>
                                                            </td>
                                                        </tr>

                                                    </tbody>

                                                    <tfoot class="total-line-table-footer">
                                                        <input type="hidden" name="total_money" id="total_money"
                                                            value="{{ $tongTienxShip }}">
                                                        <input type="hidden" id="ship_fee_hidden" value="30000">
                                                        <tr class="total-line">
                                                            <td class="total-line-name payment-due-label">
                                                                <span class="payment-due-label-total">Tổng cộng</span>
                                                            </td>
                                                            <td class="total-line-name payment-due">
                                                                <span class="payment-due-price" id="showTotalMoney">
                                                                    {{ number_format($tongTienxShip) }}₫
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                            <div class="step-footer">
                                                <button type="submit" class="step-footer-continue-btn btn"
                                                    style="width: 100%; font-size: 17px;">
                                                    <span class="btn-content">Thanh toán</span>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="main">
                                <div class="main-content">

                                    <div class="step">
                                        <div class="step-sections" step="1">
                                            <div class="section">
                                                <div class="section-header">
                                                    <h2 class="section-title">Thông tin giao hàng</h2>
                                                </div>
                                                <div class="section-content section-customer-information no-mb">

                                                    <div class="fieldset">
                                                        <div class="field   ">
                                                            <div class="field-input-wrapper">
                                                                <label class="field-label"
                                                                    for="billing_address_full_name">Họ và tên</label>
                                                                <input disabled placeholder="Họ và tên"
                                                                    class="field-input validate[required]"
                                                                    size="30" type="text" name="customerName"
                                                                    value="{{ $diaChi->ho_va_ten }}" />
                                                            </div>

                                                        </div>

                                                        <div class="field field-required">
                                                            <div class="field-input-wrapper">
                                                                <label class="field-label"
                                                                    for="billing_address_phone">Số điện thoại</label>
                                                                <input disabled placeholder="Số điện thoại"
                                                                    class="field-input validate[required]"
                                                                    maxlength="11" type="tel"
                                                                    name="customerMobile"
                                                                    value="{{ $diaChi->so_dien_thoai }}" />
                                                            </div>
                                                        </div>

                                                        <div class="field   ">
                                                            <div class="field-input-wrapper">
                                                                <label class="field-label"
                                                                    for="billing_address_address1">Địa chỉ</label>
                                                                <input disabled placeholder="Địa chỉ"
                                                                    class="field-input validate[required]"
                                                                    size="30" type="text"
                                                                    name="customerAddress"
                                                                    value="{{ $diaChi->dia_chi_cu_the }}" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="section-content">
                                                    <div class="fieldset">
                                                        <div class="field field-half  ">
                                                            <div
                                                                class="field-input-wrapper field-input-wrapper-select">
                                                                <label class="field-label"
                                                                    for="customer_shipping_province">Tỉnh /
                                                                    thành</label>
                                                                <select disabled
                                                                    class="field-input validate[required] input"
                                                                    id="cityId" name="customerCityId">
                                                                    <option value='256'>{{ $diaChi->tinh_thanh }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="field field-half  ">
                                                            <div
                                                                class="field-input-wrapper field-input-wrapper-select">
                                                                <label class="field-label"
                                                                    for="customer_shipping_district">Quận /
                                                                    huyện</label>
                                                                <select disabled
                                                                    class="field-input validate[required] input"
                                                                    id="districtId" name="customerDistrictId">
                                                                    <option value="" selected>
                                                                        {{ $diaChi->quan_huyen }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="field field-half  ">
                                                            <div
                                                                class="field-input-wrapper field-input-wrapper-select">
                                                                <label class="field-label"
                                                                    for="customer_shipping_district">Phường /
                                                                    xã</label>
                                                                <select disabled
                                                                    class="field-input validate[required] input"
                                                                    id="wardId" name="customerWardId">
                                                                    <option data-code="null" value="" selected>
                                                                        {{ $diaChi->phuong_xa }}</option>
                                                                </select>
                                                                <input type="hidden" name="selectIdWard">
                                                            </div>
                                                        </div>

                                                        <div class="field   ">
                                                            <div class="field-input-wrapper">
                                                                <label class="field-label"
                                                                    for="billing_address_address1">Ghi chú</label>
                                                                <textarea name="description" name="description" class="input" placeholder="Ghi chú ..." rows="4"
                                                                    style="width: 100%;padding: 5px;box-shadow: 0 0 0 1px #d9d9d9;border-radius: 4px;transition: all .2s ease-out;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="change_pick_location_or_shipping">
                                                    <div class="section-header">
                                                        <h2 class="section-title">Phương thức thanh toán</h2>
                                                    </div>
                                                    <div id="paymentMethod">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="phuong_thuc_thanh_toan" id="cod"
                                                                value="cod" checked>
                                                            <label class="form-check-label" for="cod">
                                                                Thanh toán khi nhận hàng
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="phuong_thuc_thanh_toan" id="online"
                                                                value="online">
                                                            <label class="form-check-label" for="online">
                                                                Thanh toán online
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="step-footer">
                                            <a class="step-footer-previous-link"
                                                href="{{ route('gio-hang.danh-sach') }}">
                                                <i class="fa fa-chevron-left"></i> Giỏ hàng
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <style>
                .listBankWrp {
                    position: relative;
                    display: flex;
                    flex-direction: column;
                }

                .listBankWrp .form-group {
                    border: 1px solid #dedede;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .listBankWrp.deactive_bank {
                    pointer-events: none !important;
                }

                .listBankWrp .form-group.active {
                    border: 1px solid #009cf6;
                    background: #f5f5f5;
                }

                .form-group.active .resultQr {
                    display: block !important;
                }

                @media screen and (max-width: 900px) {
                    .listBankWrp .col-12 {
                        padding: 0 15px !important;
                    }
                }

                @media screen and (max-width: 768px) {
                    .text-banks-title {
                        display: inline-block;
                        max-width: 45%;
                    }

                    .listBankWrp .form-group {
                        padding-top: 10px;
                        padding-bottom: 10px;
                    }
                }

                .deactive_bank .loaderWrp {
                    display: block;
                }

                .loaderWrp {
                    display: none;
                }

                .loaderWrp .loader {
                    margin-top: 7%;
                    width: 48px;
                    height: 48px;
                    border: 3px solid #FFF;
                    border-radius: 50%;
                    display: inline-block;
                    position: relative;
                    box-sizing: border-box;
                    animation: rotation 1s linear infinite;
                }

                .loaderWrp .loader::after {
                    content: '';
                    box-sizing: border-box;
                    position: absolute;
                    left: 50%;
                    top: 50%;
                    transform: translate(-50%, -50%);
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    border: 3px solid;
                    border-color: #FF3D00 transparent;
                }

                .loaderWrp {
                    position: absolute;
                    left: 0;
                    right: 0;
                    text-align: center;
                    bottom: 0;
                    background: #cbcbcbba;
                    top: 0;
                    z-index: 999;
                }

                .float-left {
                    float: left;
                }

                .float-left label strong {
                    display: block;
                }

                .pr-1 {
                    padding-right: 5px;
                }

                .float-left input {
                    margin-top: 2px;
                }

                .col-4 {
                    float: left;
                    width: 33.33%;
                }

                .col-8 {
                    float: left;
                    width: 66.67%;
                }

                .col-4,
                .col-8 {
                    position: relative;
                    min-height: 1px;
                    padding-right: 15px;
                    padding-left: 15px;
                }

                pb-2,
                .py-2 {
                    padding-bottom: 0.5rem !important;
                }

                .pt-2,
                .py-2 {
                    padding-top: 0.5rem !important;
                }

                @keyframes rotation {
                    0% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(360deg);
                    }
                }

                @keyframes rotate {
                    0% {
                        transform: rotate(0deg)
                    }

                    100% {
                        transform: rotate(360deg)
                    }
                }

                @keyframes prixClipFix {
                    0% {
                        clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0)
                    }

                    50% {
                        clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0)
                    }

                    75%,
                    100% {
                        clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%)
                    }
                }
            </style>
        </div>
    </div>

    <script>
        let tongTienBanDau = parseInt(document.getElementById('total_money').value) || 0;
        let giamVoucher = 0;
        let giamPoint = 0;

        function capNhatTongTien() {
            const tongGiam = giamVoucher + giamPoint;
            const tongMoi = tongTienBanDau - tongGiam;
            document.getElementById('showTotalMoney').innerText = tongMoi.toLocaleString('vi-VN') + ' ₫';
            document.getElementById('total_money').value = tongMoi;
        }

        document.getElementById('btn-voucher').addEventListener('click', function() {
            const couponCode = document.getElementById('coupon').value;

            fetch('{{ route('apply.voucher') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        ma_voucher: couponCode
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    const msg = document.getElementById('voucher-message');

                    if (data.success) {
                        msg.style.color = 'green';
                        msg.innerText =
                            `${data.message} – Giảm: ${Number(data.gia_tri).toLocaleString('vi-VN')}₫`;
                        giamVoucher = parseInt(data.gia_tri);
                    } else {
                        msg.style.color = 'red';
                        msg.innerText = data.message;
                        giamVoucher = 0;
                    }

                    capNhatTongTien();
                })
                .catch(err => console.error('Lỗi:', err));
        });

        document.getElementById('btn-point').addEventListener('click', function() {
            const point = parseInt(document.getElementById('point').value) || 0;

            fetch('{{ route('apply.point') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        point: point
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    const msg = document.getElementById('point-message');

                    if (data.success) {
                        msg.style.color = 'green';
                        msg.innerText =
                            `${data.message} – Giảm: ${Number(data.tien_giam).toLocaleString('vi-VN')}₫`;
                        giamPoint = parseInt(data.tien_giam);
                    } else {
                        msg.style.color = 'red';
                        msg.innerText = data.message;
                        giamPoint = 0;
                    }

                    capNhatTongTien();
                })
                .catch(err => console.error('Lỗi:', err));
        });
    </script>




</body>

</html>
