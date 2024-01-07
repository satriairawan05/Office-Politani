@php
    $pages = \App\Models\User::leftJoin('group_pages', 'users.group_id', '=', 'group_pages.group_id')
        ->leftJoin('groups', 'users.group_id', '=', 'groups.group_id')
        ->leftJoin('pages', 'group_pages.page_id', '=', 'pages.page_id')
        ->where('group_pages.access', '=', 1)
        ->where('group_pages.group_id', '=', auth()->user()->group_id)
        ->select(['group_pages.access', 'pages.page_name', 'pages.action'])
        ->get();

    $archive = 0;
    $jurusan = 0;
    $prodi = 0;
    $jenissurat = 0;
    $user = 0;
    $signature = 0;
    $verifikasi = 0;
    $skCreate = 0;
    $skRead = 0;

    foreach ($pages as $r) {
        if ($r->page_name == 'Surat Keluar') {
            if ($r->action == 'Create') {
                $skCreate = $r->access;
            }
            if ($r->action == 'Read') {
                $skRead = $r->access;
            }
        }

        if ($r->page_name == 'Archive') {
            if ($r->action == 'Read') {
                $archive = $r->access;
            }
        }

        if ($r->page_name == 'Signature') {
            if ($r->action == 'Read') {
                $signature = $r->access;
            }
        }

        if ($r->page_name == 'Verifikasi') {
            if ($r->action == 'Read') {
                $verifikasi = $r->access;
            }
        }

        if ($r->page_name == 'Jurusan') {
            if ($r->action == 'Read') {
                $jurusan = $r->access;
            }
        }

        if ($r->page_name == 'Program Studi') {
            if ($r->action == 'Read') {
                $prodi = $r->access;
            }
        }

        if ($r->page_name == 'Jenis Surat') {
            if ($r->action == 'Read') {
                $jenissurat = $r->access;
            }
        }

        if ($r->page_name == 'User') {
            if ($r->action == 'Read') {
                $user = $r->access;
            }
        }
    }
@endphp

<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <img class="img-80 img-radius" src="{{ asset('assets/images/profile.png') }}" alt="User-Profile-Image">
                <div class="user-details">
                    <span id="more-details">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
        <div class="p-15 p-b-0">
            {{-- <form class="form-material">
                                    <div class="form-group form-primary">
                                        <input type="text" name="footer-email" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label"><i class="fa fa-search m-r-10"></i>Search Friend</label>
                                    </div>
                                </form> --}}
        </div>
        <div class="pcoded-navigation-label">Dashboard</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>H</b></span>
                    <span class="pcoded-mtext">Home</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        @if ($skCreate == 1)
            <div class="pcoded-navigation-label">Registration</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::is('surat_keluar/create') ? 'active' : '' }}">
                    <a href="{{ route('surat_keluar.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti ti-envelope"></i><b>SK</b></span>
                        <span class="pcoded-mtext">Surat Keluar</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
        @endif
        <div class="pcoded-navigation-label">Main Menu</div>
        <ul class="pcoded-item pcoded-left-item">
            @if ($skRead == 1)
                <li class="{{ Request::is('surat_keluar*') && !Request::is('surat_keluar/create') ? 'active' : '' }}">
                    <a href="{{ route('surat_keluar.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti ti-envelope"></i><b>SK</b></span>
                        <span class="pcoded-mtext">Surat Keluar</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
            @if ($archive == 1)
                <li class="{{ Request::is('archive*') ? 'active' : '' }}">
                    <a href="{{ route('archive') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti ti-archive"></i><b>A</b></span>
                        <span class="pcoded-mtext">Archive</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
        </ul>
        <div class="pcoded-navigation-label">Setting</div>
        <ul class="pcoded-item pcoded-left-item">
            @if($signature == 1)
            <li class="{{ Request::is('signature*') ? 'active' : '' }}">
                <a href="{{ route('signature.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti ti-pencil-alt"></i><b>SR</b></span>
                    <span class="pcoded-mtext">Signature</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            @endif
            @if($verifikasi == 1)
            <li class="{{ Request::is('verifikasi*') ? 'active' : '' }}">
                <a href="{{ route('verifikasi.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti ti-pencil"></i><b>VR</b></span>
                    <span class="pcoded-mtext">Verifikasi</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            @endif
            @if ($jurusan == 1)
                <li class="{{ Request::is('jurusan*') ? 'active' : '' }}">
                    <a href="{{ route('jurusan.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti ti-location-arrow"></i><b>JR</b></span>
                        <span class="pcoded-mtext">Jurusan</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
            @if ($prodi == 1)
                <li class="{{ Request::is('prodi*') ? 'active' : '' }}">
                    <a href="{{ route('prodi.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti ti-layers"></i><b>PS</b></span>
                        <span class="pcoded-mtext">Program Studi</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
            @if ($jenissurat == 1)
                <li class="{{ Request::is('jenis_surat*') ? 'active' : '' }}">
                    <a href="{{ route('jenis_surat.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti ti-envelope"></i><b>JS</b></span>
                        <span class="pcoded-mtext">Jenis Surat</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
            @if ($user == 1)
                <li class="{{ Request::is('user*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti ti-user"></i><b>U</b></span>
                        <span class="pcoded-mtext">Users</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->group_id == 1)
                <li class="{{ Request::is('role*') ? 'active' : '' }}">
                    <a href="{{ route('role.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti ti-settings"></i><b>R</b></span>
                        <span class="pcoded-mtext">Roles</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
