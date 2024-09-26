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


            <!--end:Menu item-->
            <div data-kt-menu-trigger="click"
                 class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/bookings')?'show':'' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                        <span class="menu-icon">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-folders">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path
                                    d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2"/>
                                <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2"/>
                            </svg>
                        </span>
                        <span class="menu-title">
                            Bookings
                        </span>
                        <span class="menu-arrow"></span>
                    </span>
                <!--end:Menu link-->

                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ request()->url()==route('admin.bookings.create')?'active':'' }}"
                       href="{{ route('admin.bookings.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">New Booking</span>
                    </a>
                    <!--end:Menu link-->
                    <!--begin:Menu link-->
                    <a class="menu-link {{ request()->fullUrlWithoutQuery(['type'=>'all'])==route('admin.bookings.index')?'active':'' }}"
                       href="{{ route('admin.bookings.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">My Bookings</span>
                    </a>
                    <!--end:Menu link-->
                    @canany([\App\Constants\Permission::ReviewBooking,\App\Constants\Permission::CancelBooking])
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->fullUrlWithoutQuery(['type'=>'all'])==route('admin.bookings.index',['type'=>'all'])?'active':'' }}"
                           href="{{ route('admin.bookings.index',['type'=>'all']) }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">All Bookings</span>
                        </a>
                        <!--end:Menu link-->
                    @endcanany
                </div>
                <!--end:Menu item-->

            </div>


            <!--end:Menu item-->
            @canany([\App\Constants\Permission::MANAGE_BUILDINGS,\App\Constants\Permission::MANAGE_BUILDING_TYPES])
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/buildings')?'show':'' }}">
                    @can(\App\Constants\Permission::MANAGE_BUILDINGS)
                        <!--begin:Menu link-->
                        <span class="menu-link">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="icon icon-tabler icons-tabler-outline icon-tabler-building-skyscraper"><path
                                    stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0"/><path
                                    d="M5 21v-14l8 -4v18"/><path d="M19 21v-10l-6 -4"/><path
                                    d="M9 9l0 .01"/><path d="M9 12l0 .01"/><path d="M9 15l0 .01"/><path
                                    d="M9 18l0 .01"/></svg>
                        </span>
                        <span class="menu-title">
                            Manage Buildings
                        </span>
                        <span class="menu-arrow"></span>
                    </span>
                        <!--end:Menu link-->
                    @endcan
                    @can(\App\Constants\Permission::MANAGE_BUILDING_TYPES)
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url()==route('admin.buildings.index')?'active':'' }}"
                               href="{{ route('admin.buildings.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Buildings</span>
                            </a>
                            <!--end:Menu link-->

                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url()==route('admin.buildings.types.index')?'active':'' }}"
                               href="{{ route('admin.buildings.types.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Building Types</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                </div>
            @endcanany

            @canany([\App\Constants\Permission::MANAGE_ROOM_TYPES,\App\Constants\Permission::MANAGE_ROOM_TYPES])
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/rooms')?'show':'' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
										<span class="menu-icon">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                       fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                       stroke-linejoin="round"
                                       class="icon icon-tabler icons-tabler-outline icon-tabler-bed"><path stroke="none"
                                                                                                           d="M0 0h24v24H0z"
                                                                                                           fill="none"/><path
                                          d="M7 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M22 17v-3h-20"/><path
                                          d="M2 8v9"/><path d="M12 14h10v-2a3 3 0 0 0 -3 -3h-7v5z"/></svg>
										</span>
										<span class="menu-title">
                                            Manage Rooms
                                        </span>
										<span class="menu-arrow"></span>
									</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        @can(\App\Constants\Permission::MANAGE_ROOMS)
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url()==route('admin.rooms.index')?'active':'' }}"
                               href="{{ route('admin.rooms.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Rooms</span>
                            </a>
                            <!--end:Menu link-->
                        @endcan

                        @can(\App\Constants\Permission::MANAGE_ROOM_TYPES)
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url()==route('admin.rooms.types.index')?'active':'' }}"
                               href="{{ route('admin.rooms.types.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Room Types</span>
                            </a>
                            <!--end:Menu link-->
                        @endcan
                    </div>
                    <!--end:Menu item-->
                </div>
            @endcanany

            @canany([\App\Constants\Permission::MANAGE_ROLES,\App\Constants\Permission::VIEW_PERMISSIONS,\App\Constants\Permission::MANAGE_USERS])
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

                        @can(\App\Constants\Permission::VIEW_PERMISSIONS)
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
            @endcanany
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/reports')?'show':'' }}">
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
                        <a class="menu-link {{ request()->url()==route('admin.reports.room-utilization')?'active':'' }}"
                           href="{{ route("admin.reports.room-utilization") }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">
                                Room Utilization
                            </span>
                        </a>
                        <!--end:Menu link-->
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->url()==route('admin.reports.peak-usage-times')?'active':'' }}"
                           href="{{ route("admin.reports.peak-usage-times") }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">
                                Peak Usage Times
                            </span>
                        </a>
                        <!--end:Menu link-->
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->url()==route('admin.reports.popular-rooms')?'active':'' }}"
                           href="{{ route("admin.reports.popular-rooms") }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">
                               Popular Rooms
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
