<aside class="left-sidebar with-vertical">
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="index.html" class="text-nowrap logo-img">
            <img src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/logos/logo-light.svg"
                class="dark-logo" alt="Logo-Dark" />
            <img src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/logos/logo-dark.svg"
                class="light-logo" alt="Logo-light" />
        </a>
        <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
        </a>
    </div>

    <div class="scroll-sidebar" data-simplebar>
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="mb-0">

                {{-- Nội dung hiển thị --}}
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link has-arrow info-hover-bg" href="javascript:void(0)" aria-expanded="false">
                        <span class="aside-icon p-2 bg-info-subtle rounded-1">
                            <i class="ti ti-news fs-6"></i>
                        </span>
                        <span class="hide-menu ps-1">Nội dung hiển thị</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('admin.bai-viet.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Bài viết</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.banners.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Banners</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.comments.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Bình luận và đánh giá</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                {{-- Bài viết --}}
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link success-hover-bg" href="{{ route('bai_viet.index') }}"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="mdi:file-document-outline" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Bài viết</span>
                    </a>
                </li>

                {{-- Danh mục --}}
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link primary-hover-bg" href="{{ route('danh_muc.index') }}"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="mdi:view-list" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Danh mục</span>
                    </a>
                </li>

                {{-- Voucher --}}
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link warning-hover-bg" href="{{ route('voucher.index') }}"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="mdi:tag-outline" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Khuyến mãi</span>
                    </a>
                </li>

                {{-- Sản phẩm --}}
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link danger-hover-bg" href="{{ route('san_pham.index') }}"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="mdi:package-variant-closed" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Sản phẩm</span>
                    </a>
                </li>

                {{-- Cấp bậc --}}
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link warning-hover-bg" href="{{ route('cap_bac.index') }}"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="mdi:shield-star" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Cấp bậc</span>
                    </a>
                </li>

                {{-- Banner --}}
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link warning-hover-bg" href="{{ route('banner.index') }}"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="mdi:fire" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Banner</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

    <div class=" fixed-profile mx-3 mt-3">
        <div class="card bg-primary-subtle mb-0 shadow-none">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/profile/user-1.jpg"
                            width="45" height="45" class="img-fluid rounded-circle" alt="spike-img" />
                        <div>
                            {{-- <h5 class="mb-1">{{ Auth::user()->name }}</h5> --}}
                            {{-- <p class="mb-0">{{ Auth::user()->vaitro->ten }}</p> --}}
                        </div>
                    </div>
                    <form id="logout-form" action="" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="javascript:void(0)"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="position-relative" data-bs-toggle="tooltip" data-bs-placement="top" title="Đăng xuất">
                        <iconify-icon icon="solar:logout-line-duotone" class="fs-8"></iconify-icon>
                    </a>

                </div>
            </div>
        </div>
    </div>


</aside>
