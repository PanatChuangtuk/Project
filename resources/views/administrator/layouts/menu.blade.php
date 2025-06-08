<!-- Menu -->
<style>
    .app-brand-text.demo {
        font-size: 1.75rem;
        letter-spacing: -0.5px;
        text-transform: uppercase;
    }

    .logo-img {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .logo-img:hover {
        transform: scale(1.1);
    }

    .logo-text {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
    }

    .logo-img {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .logo-img {
            height: 20px;
            width: 20px;
        }

        .faculty-name {
            font-size: 0.75rem;
        }

        .university-name {
            font-size: 0.675rem;
        }
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('administrator.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('img/thumb/images.png') }}" alt="Faculty Logo" class="logo-img" />
            </span>
            <span class="app-brand-text demo fw-bold ms-2">ผู้ดูแลระบบ</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ Route::is('administrator.dashboard*') ? 'active' : '' }}">
            <a href="{{ route('administrator.dashboard') }}" class="menu-link">
                <i class="menu-icon fas fa-home"></i>
                <div class="menu-text">แดชบอร์ด</div>
            </a>
        </li>

        <li class="menu-item {{ $main_menu == 'admin' ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon fas fa-user-cog'></i>
                <div class="text-truncate" data-i18n="Layouts">ผู้ดูแลระบบ</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('administrator.admin*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.admin') }}" class="menu-link">
                        <div class="menu-text">ผู้ดูแลระบบ</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::is('administrator.student*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.student') }}" class="menu-link">
                        <div class="menu-text">นักศึกษา</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::is('administrator.adviser*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.adviser') }}" class="menu-link">
                        <div class="menu-text">อาจารย์ที่ปรึกษา</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ $main_menu == 'user' ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon fas fa-user-tie'></i>
                <div class="text-truncate" data-i18n="Layouts">ผู้ใช้งาน</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('administrator.user*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.user') }}" class="menu-link">
                        <div class="menu-text">ผู้ใช้งาน</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::is('administrator.approve-user*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.approve-user') }}" class="menu-link">
                        <div class="menu-text">อนุมัติผู้ใช้งาน</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ $main_menu == 'approve_equipment' ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon fas fa-user-tie'></i>
                <div class="text-truncate" data-i18n="Layouts">คำร้องอุปกรณ์</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('administrator.approve-equipment*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.approve-equipment') }}" class="menu-link">
                        <div class="menu-text">อนุมัติคำร้องอุปกรณ์</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('administrator.return-equipment*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.return-equipment') }}" class="menu-link">
                        <div class="menu-text">คำร้องที่สำเร็จแล้ว</div>
                    </a>
                </li>

            </ul>
        </li>

        <li class="menu-item {{ $main_menu == 'equipment' ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon fas fa-user-tie'></i>
                <div class="text-truncate" data-i18n="Layouts">อุปกรณ์</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('administrator.category-equipment*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.category-equipment') }}" class="menu-link">
                        <div class="menu-text">หมวดหมู่อุปกรณ์</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::is('administrator.item-equipment*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.item-equipment') }}" class="menu-link">
                        <div class="menu-text">ประเภทอุปกรณ์</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::is('administrator.equipment*') ? 'active' : '' }}">
                    <a href="{{ route('administrator.equipment') }}" class="menu-link">
                        <div class="menu-text">อุปกรณ์</div>
                    </a>
                </li>


            </ul>
        </li>
    </ul>
</aside>
<!-- / Menu -->
