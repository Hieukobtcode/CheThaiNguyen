<?php

if (!function_exists('hienThiTrangThaiDonHang')) {
    function hienThiTrangThaiDonHang($trangThai)
    {
        $danhSach = [
            'cho_xac_nhan' => 'Chờ xác nhận',
            'da_xac_nhan' => 'Đã xác nhận',
            'dang_giao' => 'Đang giao',
            'da_giao' => 'Đã giao',
            'da_hoan_thanh' => 'Đã hoàn thành',
            'da_huy' => 'Đã hủy',
            'that_bai' => 'Thất bại',
        ];

        return $danhSach[$trangThai] ?? ucfirst(str_replace('_', ' ', $trangThai));
    }
}

if (!function_exists('hienThiTrangThaiThanhToan')) {
    function hienThiTrangThaiThanhToan($trangThai)
    {
        $danhSach = [
            'chua_thanh_toan' => 'Chưa thanh toán',
            'da_thanh_toan' => 'Đã thanh toán',
        ];

        return $danhSach[$trangThai] ?? ucfirst(str_replace('_', ' ', $trangThai));
    }
}
