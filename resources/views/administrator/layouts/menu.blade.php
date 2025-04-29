<!-- Menu -->
<style>
    .app-brand-text.demo {
        font-size: 1.75rem;
        letter-spacing: -0.5px;
        text-transform: uppercase;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('administrator.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                    stroke="#696cff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path
                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06A1.65 1.65 0 0 0 15 19.4a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1-.33h-.36a1.65 1.65 0 0 0-1 .33A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-.33 1.82l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.6 15a1.65 1.65 0 0 0-.33-1.82A1.65 1.65 0 0 0 4 12a1.65 1.65 0 0 0 .33-1.82A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06A2 2 0 1 1 7 4.6l.06.06A1.65 1.65 0 0 0 9 4.6a1.65 1.65 0 0 0 1.82-.33A1.65 1.65 0 0 0 12 4a1.65 1.65 0 0 0 1.82.33A1.65 1.65 0 0 0 15 4.6a1.65 1.65 0 0 0 1.82.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 .33 1.82A1.65 1.65 0 0 0 20 12a1.65 1.65 0 0 0-.33 1.82A1.65 1.65 0 0 0 19.4 15z">
                    </path>
                </svg>
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
                        <div class="menu-text">อนุมัติการยืมอุปกรณ์</div>
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
