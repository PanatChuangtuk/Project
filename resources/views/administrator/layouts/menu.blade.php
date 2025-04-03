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
            <span class="app-brand-text demo fw-bold ms-2">ADMIN</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="{{ route('administrator.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div class="menu-text"> Dashboard </div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('administrator.admin') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div class="menu-text"> Admin </div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('administrator.student') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-school'></i>
                <div class="menu-text"> Student </div>
            </a>
        </li>
    </ul>d
</aside>
<!-- / Menu -->
