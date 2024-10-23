<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo">
                <img src="{{ asset('storage/upload/logo/' . $profile->village_logo) }}" alt="" width="25">
            </span>
            <span class="app-brand-text menu-text fw-bold ms-2">SIMBADES</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Menu Utama -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Menu Website</span></li>

        <!-- Beranda -->
        <li class="menu-item {{ request()->is('admin/dashboard') ? ' active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate">Beranda</div>
            </a>
        </li>

        @can('view village')
            <li class="menu-item {{ request()->is('admin/village', 'admin/village/*') ? ' active' : '' }}">
                <a href="{{ route('admin.village.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-city"></i>
                    <div class="text-truncate">Dusun</div>
                </a>
            </li>
        @endcan

        @can('view assistance')
            <li class="menu-item {{ request()->is('admin/assistance', 'admin/assistance/*') ? ' active' : '' }}">
                <a href="{{ route('admin.assistance.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-notepad"></i>
                    <div class="text-truncate">Bantuan</div>
                </a>
            </li>
        @endcan
        {{-- 
        @can('view work')
            <li class="menu-item {{ request()->is('admin/work', 'admin/work/*') ? ' active' : '' }}">
                <a href="{{ route('admin.work.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-briefcase"></i>
                    <div class="text-truncate">Pekerjaan</div>
                </a>
            </li>
        @endcan --}}

        @can('view person')
            <li class="menu-item {{ request()->is('admin/person', 'admin/person/*') ? ' active' : '' }}">
                <a href="{{ route('admin.person.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user-pin"></i>
                    <div class="text-truncate">Masyarakat</div>
                </a>
            </li>
        @endcan

        @can('view recipient')
            <li class="menu-item {{ request()->is('admin/recipient', 'admin/recipient/*') ? ' active' : '' }}">
                <a href="{{ route('admin.recipient.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div class="text-truncate">Penerimaan Bantuan</div>
                </a>
            </li>
        @endcan

        @can('view profile')
            <!-- Pengaturan -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan</span></li>

            <li class="menu-item {{ request()->is('admin/profile') ? ' active' : '' }}">
                <a href="{{ route('admin.profile.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-globe"></i>
                    <div class="text-truncate">Profil Website</div>
                </a>
            </li>
        @endcan

        @can('view user')
            <li class="menu-item {{ request()->is('admin/user', 'admin/user/*') ? ' active' : '' }}">
                <a href="{{ route('admin.user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Basic">Pengguna</div>
                </a>
            </li>
        @endcan

        @can('view role')
            <li class="menu-item {{ request()->is('admin/role', 'admin/role/*') ? ' active' : '' }}">
                <a href="{{ route('admin.role.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user-account"></i>
                    <div data-i18n="Basic">Role</div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
