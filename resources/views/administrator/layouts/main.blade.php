<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
-->
<!-- beautify ignore:start -->
<html
lang="en"
class="light-style layout-menu-fixed"
dir="ltr"
data-theme="theme-default"
data-assets-path="{{ URL::asset('administrator') }}/assets/"
data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->

    @yield('title')

    <meta name="description" content="" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('administrator') }}/assets/img/gas_logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ URL::asset('administrator') }}/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <!-- Krajee -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" rel="stylesheet" type="text/css" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('administrator') }}/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ URL::asset('administrator') }}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ URL::asset('administrator') }}/assets/css/demo.css" />

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('administrator') }}/assets/vendor/libs/select2/select2.css" />

    <!-- File Input -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- Theme CSS -->
    {{-- <link rel="stylesheet" href="{{ URL::asset('css/theme.css') }}"> --}}
    
    @yield('stylesheet')
    {{-- <style>
        body {
            font-family: "Prompt", sans-serif;
            --sb-track-color: #ffffff;
            --sb-thumb-color: #a1acb8;
            --sb-size: 8px;
        }
        .file-preview .fileinput-remove{
            display: none;
        }

        .btn-outline-spacial:hover {
            background-color: #ffffff !important;
        }

        .dataTables_info {
            display: none;
        }

        /* scroll bar */

        body::-webkit-scrollbar {
            width: var(--sb-size)
        }

        body::-webkit-scrollbar-track {
            background: var(--sb-track-color);
            border-radius: 3px;
        }

        body::-webkit-scrollbar-thumb {
            background: var(--sb-thumb-color);
            border-radius: 3px;
        
        }

        @supports not selector(::-webkit-scrollbar) {
        body {
                scrollbar-color: var(--sb-thumb-color)
                                var(--sb-track-color);
            }
        }

        .flatpickr-day.selected , .flatpickr-day.selected:hover{
            border-color: #009b48 !important;
        }

        .tablesort tbody tr {
            cursor: move;
        }
    </style> --}}
    <style>  
      .ck-editor__editable_inline{
            min-height: 200px;
            }
            /* .ck.ck-content .image img {

              width:600px;
              height: 510px;

          } */
            </style>
    <!-- Page CSS -->

<style>/* ---- Cross-editor content styles. --------------------------------------------------------------- */
 
  
  /* Make sure all content containers are distinguishable on a web page even of not focused. */
  .ck.ck-content:not(:focus) {
    border: 1px solid var(--ck-color-base-border);
  }
  
  /* Fix for editor styles overflowing into comment reply fields */
  .ck-comment__input .ck.ck-content {
    min-height: unset;
    border: 0;
    padding: 0;
  }
  
  /* Font sizes and vertical rhythm for common elements (headings, lists, paragraphs, etc.) */
  .ck-content h1 {
    font-size: 2.3em;
  }
  .ck-content h2 {
    font-size: 1.84em;
  }
  .ck-content h3 {
    font-size: 1.48em;
  }
  .ck-content h4 {
    font-size: 1.22em;
  }
  .ck-content h5 {
    font-size: 1.06em;
  }
  .ck-content h6 {
    font-size: 1em;
  }
  .ck-content h1,
  .ck-content h2,
  .ck-content h3,
  .ck-content h4,
  .ck-content h5,
  .ck-content h6 {
    line-height: 1.2em;
    padding-top: 0.8em;
    margin-bottom: 0.4em;
  }
  .ck-content blockquote,
  .ck-content ol,
  .ck-content p,
  .ck-content ul {
    font-size: 1em;
    line-height: 1.6em;
    padding-top: 0.2em;
    margin-bottom: var(--ck-spacing-large);
  }


        .select2-container .select2-selection__arrow {
            display: none !important;
        }

        .select2-container .select2-selection__clear {
            display: none !important;
        }

     
      </style>

    <!-- Helpers -->
    <script src="{{ URL::asset('administrator') }}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ URL::asset('administrator') }}/assets/js/config.js"></script>
   
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('administrator.layouts.menu')

        <!-- Layout container -->
        <div class="layout-page">
        <!-- Navbar -->

        
        <nav
        class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="bx bx-menu bx-md"></i>
          </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
          <!-- Search -->
          <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
              {{-- <i class="bx bx-search bx-md"></i> --}}
              <input
                type="text"
                class="form-control border-0 shadow-none ps-1 ps-sm-2"
                {{-- placeholder="Search..." --}}
                aria-label="Search..." />
            </div>
          </div>
          <!-- /Search -->

          <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
              <a
                class="nav-link dropdown-toggle hide-arrow p-0"
                href="javascript:void(0);"
                data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ asset('upload/file/admin/' . Auth::user()->info->avatar) }}"
                    alt="Avatar"
                    style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" />
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="#">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('upload/file/admin/' . Auth::user()->info->avatar) }}"
                            alt="Avatar"
                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" />
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0">{{Auth::user()->info->first_name . ' '. Auth::user()->info->last_name}}</h6>
                        <small class="text-muted">Admin</small>
                      </div>
                    </div>
                  </a>
                </li>
                {{-- <li>
                  <div class="dropdown-divider my-1"></div>
                </li> --}}
                {{-- <li>
                  <a class="dropdown-item" href="#">
                    <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                  </a>
                </li> --}}
                {{-- <li>
                  <a class="dropdown-item" href="#"> <i class="bx bx-cog bx-md me-3"></i><span>Settings</span> </a>
                </li> --}}
                {{-- <li>
                  <div class="dropdown-divider my-1"></div>
                </li> --}}
                <li>
                  <a class="dropdown-item logout-btn" href="javascript:void(0);" data-logout-url="{{ route('administrator.logout') }}">
                      <i class="bx bx-power-off bx-md me-3"></i>
                      <span>Log Out</span>
                  </a>
              </li>
              </ul>
            </li>
            <!--/ User -->
          </ul>
        </div>
      </nav>

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">

                @yield('content')

            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                    <div class="mb-2 mb-md-0">
                        ©
                        <script>
                            document.write(new Date().getFullYear() + 543);
                        </script>
                        , UAV Online All Rights Reserved.
                         {{-- Powered by --}}
                        {{-- <a href="https://gramickhouse.com/" target="_blank" class="footer-link fw-bolder"> GRAMICK HOUSE </a> --}}
                        </div>
                    <div>
                    {{-- <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                    <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                    <a
                        href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                        target="_blank"
                        class="footer-link me-4"
                        >Documentation</a
                    >

                    <a
                        href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                        target="_blank"
                        class="footer-link me-4"
                        >Support</a
                    > --}}
                    </div>
                </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
   
 
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ URL::asset('administrator') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ URL::asset('administrator') }}/assets/vendor/js/menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Vendors JS -->
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/datatables/datatables.min.js"></script>
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <!-- File Input -->
    <script src="{{ URL::asset('administrator') }}/vendor-admin/bootstrap-fileinput/js/plugins/piexif.min.js"></script>
    <script src="{{ URL::asset('administrator') }}/vendor-admin/bootstrap-fileinput/js/plugins/sortable.min.js"></script>
    <script src="{{ URL::asset('administrator') }}/vendor-admin/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="{{ URL::asset('administrator') }}/vendor-admin/bootstrap-fileinput/themes/fas/theme.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/locales/LANG.js"></script>

    <!-- Resumable.js (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.0.3/resumable.min.js"></script>

    <!-- Krajee -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <!-- CKEditor -->
    {{-- <script src="{{ URL::asset('administrator') }}/vendor-admin/ckeditor4/ckeditor.js"></script>
    <script src="{{ URL::asset('administrator') }}/vendor-admin/ckeditor/build/ckeditor.js"></script> --}}

    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/"
            }
        }
    </script>
    <!-- Full Calendar -->
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <!-- Moment -->
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/moment/moment.js"></script>
    
    <!-- Form Validation -->
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Select2 -->
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/select2/select2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Star Ratings -->
    <script src="{{ URL::asset('administrator') }}/assets/vendor/libs/rateyo/rateyo.js"></script>

    <!-- Main JS -->
    <script src="{{ URL::asset('administrator') }}/assets/js/main.js"></script>
    <script src="{{ URL::asset('administrator') }}/assets/js/dashboards-analytics.js"></script>

    <!-- Custom JS -->
    <script src="{{ URL::asset('administrator') }}/js/function.js?{{ <?= time(); ?> }}"></script>
    <script src="{{ URL::asset('administrator') }}/js/custom-alert.js"></script>

    @yield('script')

    <script>
        $(".date-flatpick").flatpickr({
            monthSelectorType: "static"
        });

        $(".date-flatpick-time").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
        });
    </script><script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutButton = document.querySelector('.logout-btn');
            logoutButton.addEventListener('click', function() {
                const logoutUrl = this.dataset.logoutUrl;
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = logoutUrl;
                    }
                });
            });
        });
    </script>
</body>
</html>