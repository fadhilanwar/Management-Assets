<div id="bdSidebar" style="overflow: hidden; height: 100vh;"
    class="d-flex flex-column flex-shrink-0 p-3 bg-white offcanvas-md offcanvas-start" style="width: 280px;">
    <div class="navbar-brand d-flex mt-2">
        {{-- <div class="ms-3"><img src="assets/image/logoPTDIterbarucrop.jpg" width="50" alt=""></div> --}}
        <div class="ms-3"><img src="../assets/image/logoPTDIterbarucrop.jpg" width="50" alt=""></div>
        <div class="ms-3 fw-bold">
            <h5>Management <br>Assets - LC</h5>
        </div>
    </div>
    <hr class="mb-1">
    <div style="height: 100%; width: 245px; overflow-y: scroll; margin-bottom: 5px;">
        <ul class="mynav nav nav-pills d-flex flex-column mb-auto mt-3" style="margin-right: 2px;">

            <li class="nav-item mb-1">
                <a href="/dashboard-koordinator" class="{{ $title === 'Dashboard' ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i>
                    Dashboard
                </a>
            </li>
            <li
                class="nav-item active dropdown-custom @if (
                    $active == 'Data Petugas' ||
                        'Data Pegawai' ||
                        'Kategori Barang' ||
                        'Tipe Ruangan' ||
                        'Data Barang' ||
                        'Data Ruangan') dropdown-active-custom @endif
        {{-- {{ $active === 'Data Petugas' || 'Data Pegawai' || 'Kategori Barang' || 'Tipe Ruangan' || 'Data Barang' || 'Data Ruangan' ? 'dropdown-active-custom' : '' }} --}}
        ">

                <button onclick="toggleDataDropdown()" href="">
                    <div class="customtoogle">
                        <i class="fa-solid fa-database button-icon mt-1"></i>
                        Data
                    </div>
                    <i class="fa-solid fa-chevron-down down mt-1"></i>
                </button>
                <ul class="ms-2" id="dataDropdown"
                    @if ($open == 'yes-1') style="display: block;"
                @elseif ($open == 'yes-2')
                    style="display: none;"
                @else
                    style="display: none;" @endif>
                    <li class="nav-item mb-1">
                        <a href="/petugas-koordinator" class="{{ $title === 'Data Petugas' ? 'active' : '' }}">
                            <i class="fa-solid fa-user-gear"></i>
                            Petugas
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/pegawai-koordinator" class="{{ $title === 'Data Pegawai' ? 'active' : '' }}">
                            <i class="fa-solid fa-users"></i>
                            Pegawai
                        </a>
                    </li>
                    <li
                        class="nav-item mb-0 dropdown-custom-child {{ $active === 'data' ? 'dropdown-active-custom' : '' }}">
                        <button onclick="toggleDataDropdown3()" href=""
                            class="{{ $active === 'data' ? 'active-custom' : '' }}">
                            <div class="customtoogle">
                                <i class="fa-solid fa-share-from-square ms-1"></i>
                                Kategori {{-- Jangan Panjang Panhjang ntar rusak --}}
                            </div>
                            <i class="fa-solid fa-chevron-down down mt-1"></i>
                        </button>
                        <ul id="dataDropdown3" class="ms-2">
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/kategori-barang-koordinator"
                                    class="{{ $title === 'Data Kategori Barang' ? 'active' : '' }}">
                                    <i class="fa-solid fa-dolly"></i>
                                    Kategori Barang
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/tipe-ruangan-koordinator"
                                    class="{{ $title === 'Data Tipe Ruangan' ? 'active' : '' }}">
                                    <i class="fa-solid fa-tags"></i>
                                    Tipe Ruangan
                                </a>
                            </li>



                        </ul>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/barang-koordinator" class="{{ $title === 'Data Barang' ? 'active' : '' }}">
                            <i class="fa-solid fa-computer"></i>
                            Barang - Properti
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/ruangan-koordinator" class="{{ $title === 'Data Ruangan' ? 'active' : '' }}">
                            <i class="fa-solid fa-door-closed"></i>Ruangan
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/departemen-koordinator" class="{{ $title === 'Data Departemen' ? 'active' : '' }}">
                            <i class="fa-solid fa-building"></i>Departemen
                        </a>
                    </li>
                </ul>
            </li>








            <li
                class="nav-item active dropdown-custom @if (
                    $active == 'Data Petugas' ||
                        'Data Pegawai' ||
                        'Kategori Barang' ||
                        'Tipe Ruangan' ||
                        'Data Barang' ||
                        'Data Ruangan') dropdown-active-custom @endif
    {{-- {{ $active === 'Data Petugas' || 'Data Pegawai' || 'Kategori Barang' || 'Tipe Ruangan' || 'Data Barang' || 'Data Ruangan' ? 'dropdown-active-custom' : '' }} --}}
    ">

                <button onclick="toggleDataDropdown4()" href="" class="mt-1">
                    <div class="customtoogle">
                        <i class="fa-solid fa-network-wired"></i>
                        Transaksi
                    </div>
                    <i class="fa-solid fa-chevron-down down mt-1"></i>
                </button>


                <ul class="ms-2" id="dataDropdown4"
                    @if ($open == 'yes-1') style="display: none;"
            @elseif ($open == 'yes-2')
                style="display: block;"
            @else
                style="display: none;" @endif>
                    <li class="nav-item mb-1">
                        <a href="/pengadaan" class="{{ $active === 'Pengadaan' ? 'active' : '' }}">
                            <i class="fa-solid fa-cart-plus"></i>
                            Pengadaan
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/penempatan" class="{{ $active === 'Penempatan' ? 'active' : '' }}">
                            <i class="fa-solid fa-map-location-dot"></i>
                            Penempatan
                        </a>
                    </li>

                    <li class="nav-item mb-1">
                        <a href="/mutasi" class="{{ $active === 'Mutasi' ? 'active' : '' }}">
                            <i class="fa-solid fa-building-circle-arrow-right"></i>
                            Mutasi
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/peminjaman" class="{{ $active === 'Peminjaman' ? 'active' : '' }}">
                            <i class="fa-solid fa-handshake"></i>Peminjaman
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/maintenance" class="{{ $active === 'Maintenance' ? 'active' : '' }}">
                            <i class="fa-solid fa-screwdriver-wrench"></i>Maintenance
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/penghapusan" class="{{ $active === 'Penghapusan' ? 'active' : '' }}">
                            <i class="fa-solid fa-ban"></i>Penghapusan
                        </a>
                    </li>
                </ul>
            </li>

















            <li class="nav-item mb-1 mt-1">
                <a href="/data-aktiva-fasilitas" class="{{ $title === 'Data Aktiva / Fasilitas Ruangan' ? 'active' : '' }}">
                    <i class="fa-solid fa-list"></i>
                    Data Aktiva / Fasilitas
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="/data-assets" class="{{ $title === 'Data Assets' ? 'active' : '' }}">
                    <i class="fa-solid fa-list"></i>
                    Data Assets
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="/pencarian-asset" class="{{ $title === 'Pencarian Asset' ? 'active' : '' }}">
                    <i class="fa-solid fa-search"></i>
                    Pencarian Asset
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="/training-koordinator" class="{{ $title === 'Data Training' ? 'active' : '' }}">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Training / Programs
                </a>
            </li>
            <li
                class="nav-item active dropdown-custom @if (
                    $active == 'Laporan Data Petugas' ||
                        'Laporan Data Pegawai' ||
                        'Laporan Data Kategori Barang' ||
                        'Laporan Data Tipe Ruangan' ||
                        'Laporan Data Barang' ||
                        'Laporan Data Ruangan') dropdown-active-custom @endif
        {{-- {{ $active === 'Data Petugas' || 'Data Pegawai' || 'Kategori Barang' || 'Tipe Ruangan' || 'Data Barang' || 'Data Ruangan' ? 'dropdown-active-custom' : '' }} --}}
        ">

                <button onclick="toggleDataDropdown5()" href="">
                    <div class="customtoogle">
                        <i class="fa-solid fa-scroll button-icon mt-1"></i>
                        Laporan
                    </div>
                    <i class="fa-solid fa-chevron-down down mt-1"></i>
                </button>
                <ul class="ms-2" id="dataDropdown5"
                    @if ($open == 'yes-3') style="display: block;"
                @elseif ($open == 'yes-2')
                    style="display: none;"
                @elseif ($open == 'yes-1')
                    style="display: none;"
                @else
                    style="display: none;" @endif>
                    <li
                        class="nav-item mb-0 dropdown-custom-child {{ $active === 'data' ? 'dropdown-active-custom' : '' }}">
                        <button onclick="toggleDataDropdown6()" href=""
                            class="{{ $active === 'data' ? 'active-custom' : '' }}">
                            <div class="customtoogle">
                                <i class="fa-solid fa-share-from-square ms-1"></i>
                                Laporan Data Master {{-- Jangan Panjang Panhjang ntar rusak --}}
                            </div>
                            <i class="fa-solid fa-chevron-down down mt-1"></i>
                        </button>
                        <ul id="dataDropdown6" class="ms-2" @if ($open == 'yes-3') style="display: block;"
                        @elseif ($open == 'yes-2')
                            style="display: none;"
                        @elseif ($open == 'yes-1')
                            style="display: none;"
                        @else
                            style="display: none;" @endif>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-petugas"
                                    class="{{ $title === 'Laporan Data Petugas' ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-gear"></i>
                                    Laporan Data Petugas
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-pegawai"
                                    class="{{ $title === 'Laporan Data Pegawai' ? 'active' : '' }}">
                                    <i class="fa-solid fa-users"></i>
                                    Laporan Data Pegawai
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-barang"
                                    class="{{ $title === 'Laporan Data Barang' ? 'active' : '' }}">
                                    <i class="fa-solid fa-computer"></i>
                                    Laporan Data Barang
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-ruangan"
                                    class="{{ $title === 'Laporan Data Ruangan' ? 'active' : '' }}">
                                    <i class="fa-solid fa-door-closed"></i>
                                    Laporan Data Ruangan
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-departemen"
                                    class="{{ $title === 'Laporan Data Departemen' ? 'active' : '' }}">
                                    <i class="fa-solid fa-building"></i>
                                    Laporan Data Departemen
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item mb-0 dropdown-custom-child {{ $active === 'data' ? 'dropdown-active-custom' : '' }}">
                        <button onclick="toggleDataDropdown7()" href=""
                            class="{{ $active === 'data' ? 'active-custom' : '' }}">
                            <div class="customtoogle">
                                <i class="fa-solid fa-share-from-square ms-1"></i>
                                Laporan Data Transaksi {{-- Jangan Panjang Panhjang ntar rusak --}}
                            </div>
                            <i class="fa-solid fa-chevron-down down mt-1"></i>
                        </button>
                        <ul id="dataDropdown7" class="ms-2" @if ($open == 'yes-3') style="display: block;"
                        @elseif ($open == 'yes-2')
                            style="display: none;"
                        @elseif ($open == 'yes-1')
                            style="display: none;"
                        @else
                            style="display: none;" @endif>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-pengadaan"
                                    class="{{ $title === 'Laporan Data Pengadaan' ? 'active' : '' }}">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    Laporan Data Pengadaan
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-penempatan"
                                    class="{{ $title === 'Laporan Data Penempatan' ? 'active' : '' }}">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                    Laporan Data Penempatan
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-mutasi"
                                    class="{{ $title === 'Laporan Data Mutasi' ? 'active' : '' }}">
                                    <i class="fa-solid fa-building-circle-arrow-right"></i>
                                    Laporan Data Mutasi
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-peminjaman"
                                    class="{{ $title === 'Laporan Data Peminjaman' ? 'active' : '' }}">
                                    <i class="fa-solid fa-handshake"></i>
                                    Laporan Data Peminjaman
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-maintenance"
                                    class="{{ $title === 'Laporan Data Maintenance' ? 'active' : '' }}">
                                    <i class="fa-solid fa-screwdriver-wrench"></i>
                                    Laporan Data Maintenance
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/laporan-data-penghapusan"
                                    class="{{ $title === 'Laporan Data Penghapusan' ? 'active' : '' }}">
                                    <i class="fa-solid fa-ban"></i>
                                    Laporan Data Penghapusan
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <hr class="mt-0 hr-custom">
    <div class="d-flex user-custom">
        <a href="/profile-koordinator">
            @if (auth()->user()->foto == null)
<<<<<<< HEAD
            <img src="assets/image/user.png" class="img-fluid rounded rounded-circle me-2"
                style="width: 50px; height: 50px; margin-top: 4px;" alt="">
        @else
            <img src="{{ asset('storage/' . auth()->user()->foto) }}" class="img-fluid rounded rounded-circle me-2"
                style="width: 50px; height: 50px; margin-top: 4px;" alt="">
        @endif
=======
                <img src="../assets/image/user.png" class="img-fluid rounded rounded-circle me-2"
                    style="width: 50px; height: 50px; margin-top: 4px;" alt="">
            @else
                <img src="{{ asset('storage/' . auth()->user()->foto) }}"
                    class="img-fluid rounded rounded-circle me-2" style="width: 50px; height: 50px; margin-top: 4px;"
                    alt="">
            @endif
>>>>>>> 10b90c07f49f57de3c0370bef116063539c9aca1
        </a>
        <span style="margin-top: 4px; ">
            <h6 class="mt-1 mb-0">{{ explode(' ', auth()->user()->nama_user)[0] }}</h6>
            <small>Koordinator</small>
        </span>
        <div class="logout" style="margin-bottom: 100px">
            <button class="btn" style="background: #0d3b66" data-bs-toggle="modal" data-bs-target="#logout">
                <i class="fa-solid fa-power-off text-white"></i>
            </button>
        </div>
    </div>

</div>

<div class="modal modal-blur fade" id="logout" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog w-50 modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
                <h6>Are you sure?</h6>
                <div class="text-muted">Yakin? Anda akan Keluar dari halaman ini...</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button></div>
                        <form action="/logout" method="post">
                            @csrf
                            {{-- @method('DELETE') --}}
                            <button class="btn btn-danger w-100">
                                Yakin
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
