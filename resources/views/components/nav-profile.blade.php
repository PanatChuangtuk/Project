<div class="sidebar">
    <div class="card-info main">
        <div class="title-bar d-flex" data-bs-toggle="collapse" data-bs-target="#navProfile">
            <h1 class="h2 text-capitalize text-underline">@lang('messages.profile')</h1>

            <button class="btn btn-menu" type="button">
                <img class="icons svg-js" src="{{ asset('img/icons/icon-add-plus.svg') }}" alt="" />
            </button>
        </div>

        <ul class="nav nav-profile">
            <li class="{{ Request::is('/profile') ? 'active' : '' }}">
                <a href="{{ url('/profile') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-user.svg') }}" alt="" />
                    @lang('messages.my_account')
                </a>
            </li>
            <li class="{{ Request::is('/equipment') ? 'active' : '' }}">
                <a href="{{ url('/equipment') }}">
                    <img class="icons" src="{{ asset('img/icons/icon-user.svg') }}" alt="" />
                    Equipment
                </a>
            </li>


            <li>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="confirmLogout(event)">
                    <img class="icons" src="{{ asset('img/icons/icon-logout.svg') }}" alt="" />
                    @lang('messages.sign_out')
                </a>
            </li>
        </ul>
    </div>
</div>
