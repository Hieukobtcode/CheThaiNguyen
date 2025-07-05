<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chè Thái Nguyên</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('logo/IconPolyFlixAdmin.png') }}" type="image/png" sizes="192x192">

    {{-- Styles --}}
    <link rel="stylesheet" href="https://bootstrapdemos.wrappixel.com/spike/dist/assets/css/styles.css">
    <link rel="stylesheet"
        href="https://bootstrapdemos.wrappixel.com/spike/dist/assets/libs/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @yield('head')
</head>

<body>
    <div id="main-wrapper">
        {{-- Sidebar --}}
        @include('admin.blocks.sidebar')

        {{-- Page Content --}}
        <div class="page-wrapper">
            <div class="body-wrapper">
                <div class="container-fluid">
                    {{-- Header --}}
                    @include('admin.blocks.header')

                    {{-- Alert Notifications --}}
                    @if (session('success') || session('error'))
                        <div class="position-fixed top-0 end-0 m-4" style="z-index: 1055;">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show shadow-sm small d-flex align-items-center"
                                    role="alert">
                                    <i class="ti ti-check me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm small d-flex align-items-center"
                                    role="alert">
                                    <i class="ti ti-alert-circle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Nội dung trang con --}}
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar overlay --}}
    <div class="dark-transparent sidebartoggler"></div>

    {{-- Scripts --}}
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/vendor.min.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/libs/simplebar/dist/simplebar.min.js"></script>

    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/theme/app.init.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/theme/theme.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/theme/app.min.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/theme/sidebarmenu.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/theme/feather.min.js"></script>

    {{-- External Libraries --}}
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/libs/jvectormap/jquery-jvectormap.min.js"></script>
    <script
        src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/extra-libs/jvectormap/jquery-jvectormap-us-aea-en.js">
    </script>
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/dashboards/dashboard.js"></script>
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/widget/widgets-charts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- Code Highlighting --}}
    <script src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/js/highlights/highlight.min.js"></script>
    <script>
        hljs.initHighlightingOnLoad();
        document.querySelectorAll("pre.code-view > code").forEach((codeBlock) => {
            codeBlock.textContent = codeBlock.innerHTML;
        });
    </script>

    {{-- Sidebar menu toggler --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuLinks = document.querySelectorAll('.sidebar-link.has-arrow');

            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parent = this.closest('.sidebar-item');
                    const submenu = parent.querySelector('.first-level');
                    if (submenu) {
                        submenu.classList.toggle('collapse');
                        submenu.classList.toggle('show');
                        this.classList.toggle('active');
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alerts = document.querySelectorAll('.alert-dismissible');

            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                }, 3000); 
            });
        });
    </script>

    {{-- Iconify --}}
    <script src="{{ asset('js/iconify-icon.min.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    {{-- Dynamic Theme --}}
    <script>
        function handleColorTheme(theme) {
            document.documentElement.setAttribute("data-color-theme", theme);
        }
    </script>

    @yield('scripts')
</body>

</html>
