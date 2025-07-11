 <!--  Header Start -->
 <header class="topbar sticky-top">
     <link href="https://unpkg.com/@tabler/icons-webfont@2.42.0/tabler-icons.min.css" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <div class="with-vertical">

         <nav class="navbar navbar-expand-lg p-0">

             <ul class="navbar-nav">
                 <li class="nav-item nav-icon-hover-bg rounded-circle">
                     <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                         <iconify-icon icon="solar:list-bold-duotone" class="fs-7"></iconify-icon>
                     </a>
                 </li>
             </ul>

             <div class="d-block d-lg-none py-3">
                 <img src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/logos/logo-light.svg"
                     class="dark-logo" alt="Logo-Dark" />
                 <img src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/logos/logo-dark.svg"
                     class="light-logo" alt="Logo-light" />
             </div>

             <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

                 <div class="d-flex align-items-center justify-content-between">
                     <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">

                         <li class="nav-item nav-icon-hover-bg rounded-circle">
                             <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                 <iconify-icon icon="solar:moon-line-duotone" class="moon fs-6"></iconify-icon>
                             </a>
                             <a class="nav-link sun light-layout" href="javascript:void(0)">
                                 <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-6"></iconify-icon>
                             </a>
                         </li>

                         <li class="nav-item dropdown">
                             <a class="nav-link position-relative ms-6" href="javascript:void(0)" id="drop1"
                                 aria-expanded="false">
                                 <div class="d-flex align-items-center flex-shrink-0">
                                     <div class="user-profile me-sm-3 me-2">
                                         <img src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/profile/user-1.jpg"
                                             width="40" class="rounded-circle" alt="spike-img">
                                     </div>
                                     <span class="d-sm-none d-block"><iconify-icon
                                             icon="solar:alt-arrow-down-line-duotone"></iconify-icon></span>

                                     <div class="d-none d-sm-block">
                                         <p class="fs-3 lh-base mb-0 profile-subtext">
                                             Admin
                                         </p>
                                     </div>
                                 </div>
                             </a>
                             <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                 aria-labelledby="drop1">
                                 <div class="profile-dropdown position-relative" data-simplebar>

                                     <div class="d-flex align-items-center justify-content-between pt-3 px-7">
                                         <h3 class="mb-0 fs-5">Thông tin</h3>

                                     </div>

                                     <div class="d-flex align-items-center mx-7 py-9 border-bottom">
                                         <img src="https://bootstrapdemos.wrappixel.com/spike/dist/assets/images/profile/user-1.jpg"
                                             alt="user" width="90" class="rounded-circle" />
                                         <div class="ms-4">
                                             <h4 class="mb-0 fs-5 fw-normal">
                                                 {{ Auth::user()->ten }}</h4>
                                             <span class="text-muted">
                                                 {{ Auth::user()->vai_tro_id == 0 ? 'Admin' : 'Khách hàng' }}
                                             </span>
                                             <p class="text-muted mb-0 mt-1 d-flex align-items-center">
                                                 <iconify-icon icon="solar:mailbox-line-duotone"
                                                     class="fs-4 me-1"></iconify-icon>
                                                 {{ Auth::user()->email }}
                                             </p>
                                         </div>
                                     </div>

                                     <form method="POST" action="/logout">
                                         @csrf
                                         <button type="submit" class="btn btn-primary w-100">Đăng xuất</button>
                                     </form>

                                 </div>
                             </div>
                         </li>
                     </ul>
                 </div>
             </div>
         </nav>

     </div>

 </header>
