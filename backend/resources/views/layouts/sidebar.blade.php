<div class="sidebar"
style="background: #1a1a1a">

<div class="sidebar-wrapper">
    <div class="logo">
        <a href="#" class="simple-text logo-mini">
        <i class="fa fa-user" style="font-size: 20px"></i>
        </a>
        <a href="#" class="simple-text logo-normal">
            {{ Auth::user()->name ?? "" }}
        </a>
    </div>
    <ul class="nav">
        <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class="tim-icons icon-chart-pie-36"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="{{ Request::is('dashboard/messages') ? 'active' : '' }}">
            <a href="{{ route('orders.index') }}">
                <i class="tim-icons icon-delivery-fast "></i>
                <p>Shipments</p>
            </a>
        </li>
        @if (Auth::user()->is_admin)
            <li class="{{ Request::is('dashboard/users') ? 'active' : '' }}">
                <a href="{{ route('all.users') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Users</p>
                </a>
            </li>
        @endif
        <div style="margin-left: 30px" id="google_translate_element"></div>
    </ul>
</div>
</div>
