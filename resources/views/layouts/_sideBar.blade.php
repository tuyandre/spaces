<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
     data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Main-->
    <div
        class="d-flex flex-column justify-content-between h-100 hover-scroll-overlay-y my-2 d-flex flex-column"
        id="kt_app_sidebar_main" data-kt-scroll="true" data-kt-scroll-activate="true"
        data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header"
        data-kt-scroll-wrappers="#kt_app_main" data-kt-scroll-offset="5px">
        <!--begin::Sidebar menu-->
        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
             class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg mb-7">
            <!--begin:Menu item-->
            <div class="menu-item here">
                <!--begin:Menu link-->
                <a href="{{ route('admin.dashboard') }}"
                   class="menu-link {{ request()->fullUrl() ==route('admin.dashboard')?'active':'' }}">
                    <div class="menu-icon">
                        <i class="bi bi-speedometer2 fs-1"></i>
                    </div>
                    <span class="menu-title">Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->

            <div data-kt-menu-trigger="click"
                 class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/settings')?'show':'' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
										<span class="menu-icon">
                                            <i class="bi bi-gear fs-1"></i>
										</span>
										<span class="menu-title">
                                            System Settings
                                        </span>
										<span class="menu-arrow"></span>
									</span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">

                    <!--begin:Menu item-->
                    <!--begin:Menu link-->
                    @can(\App\Constants\Permission::MANAGE_USERS)
                        <a class="menu-link {{ request()->url()==route('admin.settings.users.index')?'active':'' }}"
                           href="{{ route('admin.settings.users.index') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">Users</span>
                        </a>
                    @endcan
                    <!--end:Menu link-->
                    <!--begin:Menu link-->
                    @can(\App\Constants\Permission::MANAGE_ROLES)
                        <a class="menu-link  {{ request()->url()==route('admin.settings.roles.index')?'active':'' }}"
                           href="{{ route('admin.settings.roles.index') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">Roles</span>
                        </a>
                        <!--end:Menu link-->
                    @endcan

                    @can(\App\Constants\Permission::MANAGE_PERMISSIONS)
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->url()==route('admin.settings.permissions.index')?'active':'' }}"

                           href="{{ route('admin.settings.permissions.index') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">Permissions</span>
                        </a>
                        <!--end:Menu link-->
                    @endcan

                </div>
                <!--end:Menu item-->
            </div>
            <!--end:Menu sub-->
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <!--begin:Menu link-->
                <span class="menu-link">
										<span class="menu-icon">
                                            <i class="bi bi-file-pdf fs-1"></i>
										</span>
										<span class="menu-title">
                                            Reports
                                        </span>
										<span class="menu-arrow"></span>
									</span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">

                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">
                                Applications
                            </span>
                        </a>
                        <!--end:Menu link-->
                        <!--begin:Menu link-->
                        <a class="menu-link" href="">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">
                                Payments
                            </span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>
            <!--end:Menu item-->
        </div>


    </div>
    <!--end::Sidebar menu-->

</div>
<!--end::Main-->
