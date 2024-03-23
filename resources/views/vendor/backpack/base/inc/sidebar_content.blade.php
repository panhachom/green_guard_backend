
<style>
    .sidebar.sidebar-pills .nav-link.active .nav-icon, .sidebar.sidebar-pills .nav-link:hover .nav-icon {
        color: #4caf50;
    }
    .sidebar.sidebar-pills .nav-link.active, .sidebar.sidebar-pills .nav-link:hover {
        background-color: rgba(0, 0, 0, .02);
        color: #4caf50 !important;
    }
    .sidebar-pills .nav-link.active, .sidebar-pills .nav-link:hover, .sidebar-pills .nav-link:hover .nav-icon {
        color: #4caf50 !important;
    }
</style>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>{{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('blog') }}"><i class="nav-icon la la-pencil-square"></i>Blogs</a></li>

@role('admin')
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i> Authentication</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-group"></i> <span>Roles</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
        </ul>
    </li>
@else
@endrole

