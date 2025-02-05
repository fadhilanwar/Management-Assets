@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="row">
            <div class="col-md-4"> <button onclick="ShowModal1()" type="button" class="btn btn-warning btn-sm mt-2 mb-2 w-100"
                    data-bs-toggle="modal" data-bs-target="#adddata">
                    <i class="fa-solid fa-cart-flatbed"></i>
                    List Pengadaan
                </button></div>
            <div class="col-md-8"> <a href="/pengadaan-tambah" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                    <i class="fa-solid fa-square-plus"></i>
                    Tambah Pengadaan Baru
                </a></div>
        </div>

        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Pengadaan</th>
                    <th>Tanggal Pengadaan</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($pengadaans as $pengadaan)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pengadaan->no_pengadaan }}</td>
                    <td>{{ $pengadaan->tanggal_pengadaan }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#showdata{{ $pengadaan->id }}"
                            class="btn btn-primary mt-1">
                            <i class="fa fa-eye"></i>
                        </button>
                        <a href="/print/barcode-all?no_pengadaan={{ $pengadaan->no_pengadaan }}" target="blank"
                            class="btn btn-warning mt-1"><i class="fa-solid fa-barcode"></i></a>
                        <button data-bs-toggle="modal" data-bs-target="#deletePengadaan{{ $pengadaan->id }}"
                            class="btn btn-danger mt-1">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>

    {{-- modal --}}

    {{-- modal add data --}}
    <div class="modal modal-blur fade" id="adddata" tabindex="-1" role="dialog" aria-hidden="true"
        style="font-size: 14px;">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6"><strong>List Pengadaan</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/addpengadaan" method="post">
                        @csrf
                        @php
                            use Carbon\Carbon;
                            // $no_last = DB::table('keranjang_pengadaans')->select('*')->orderByDesc('no_pengadaan')->first();
                            $no_last = DB::table('pengadaans')
                                ->select(DB::raw('RIGHT(no_pengadaan, 4) + 1 as noUrut'))
                                ->orderBy('no_pengadaan', 'DESC')
                                ->limit(1)
                                ->get();

                            // $no_count = DB::table('keranjang_pengadaans')->select('*')->count();
                            // dd($no_last);

                            if (!$no_last->isEmpty()) {
                                $noUrut = $no_last[0]->noUrut;
                                $floatValue = floatval($noUrut);
                            }
                            if ($no_last->isEmpty()) {
                                $no_pengadaan_last = '0001';
                            } else {
                                if ($noUrut < 10) {
                                    $no_pengadaan_last = '000' . $noUrut;
                                } elseif ($noUrut < 100) {
                                    $no_pengadaan_last = '00' . $noUrut;
                                } elseif ($noUrut < 1000) {
                                    $no_pengadaan_last = '0' . $noUrut;
                                } elseif ($noUrut < 10000) {
                                    $no_pengadaan_last = $noUrut;
                                } else {
                                    $no_pengadaan_last = '0001';
                                }
                            }

                            $no_pengadaan =
                                'PD-' .
                                Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis') .
                                $no_pengadaan_last;
                        @endphp

                        <div class="row">
                            <div class="col-md-6">

                                <label style="font-size: 16px;"><b>No. Pengadaan</b></label><br>
                                <input class="form-control mb-2" type="text" value="{{ $no_pengadaan }}"
                                    name="no_pengadaan" style="background: #eee" readonly>

                                <label style="font-size: 16px;">Tanggal Pengadaan</label><br>
                                <input class="form-control mb-2" type="date" value="{{ now()->format('Y-m-d') }}"
                                    name="tanggal_pengadaan" style="background: #eee" readonly>

                            </div>
                            <div class="col-md-6">

                                <label style="font-size: 16px;">Pemeriksa</label><br>
                                <input class="form-control mb-2" type="text"
                                    value="[{{ auth()->user()->nik }}] {{ auth()->user()->nama_user }}" name="no_pengadaan"
                                    style="background: #eee" readonly>

                                <label style="font-size: 16px;">Total Harga (Rp.)</label><br>
                                <input class="form-control mb-2" type="text"
                                    value="Rp. {{ number_format($total_harga) }}" name="total_harga"
                                    style="background: #eee" readonly>

                            </div>
                            <strong>*Harap kembali periksa dengan teliti...</strong>
                        </div>



                        <hr>

                        <table class="table table-striped" id="data-tables-keranjang">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>Foto Profil</th> --}}
                                    {{-- <th>Alamat</th> --}}
                                    {{-- <th>No Telepon</th> --}}
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Merk</th>
                                    {{-- <th>Tanggal Pengadaan</th> --}}
                                    <th>Jenis Pengadaan</th>
                                    <th>Kondisi</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Harga</th>
                                    <th>Keterangan</th>
                                    <th data-searchable="false">Action</th>
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($keranjangs as $keranjang)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td>No Barang: <b>{{ $keranjang->no_barang }}</b> <br>Barcode:
                                        <b>{!! DNS1D::getBarcodeHTML($keranjang->kode_barcode, 'UPCA') !!}{{ $keranjang->kode_barcode }}</b> <br>No Asset:
                                        <b>{{ $keranjang->no_asset }}</b><br>Nomor
                                        Kodifikasi: <b>{{ $keranjang->nomor_kodifikasi }}</b>
                                    </td>
                                    <td>{{ $keranjang->nama_barang }}</td>
                                    <td>{{ $keranjang->merk }}, {{ $keranjang->spesifikasi }}</td>
                                    {{-- <td>{{ $keranjang->tanggal_pengadaan }}</td> --}}
                                    <td>{{ $keranjang->jenis_pengadaan }}</td>
                                    <td>{{ $keranjang->kondisi }}</td>
                                    {{-- <td>{{ $keranjang->status }}</td> --}}
                                    <td>Rp. {{ number_format($keranjang->harga) }}</td>
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    <td>{{ $keranjang->keterangan }}</td>
                                    <td>

                                        <a data-bs-toggle="modal" data-bs-target="#deletedata{{ $keranjang->id }}"
                                            class="btn btn-danger mt-1">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-success" style="font-size: 14px;">Add</button>
                </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    {{-- end modal add data --}}

    {{-- modal edit data --}}

    {{-- end modal edit data --}}

    {{-- modal delete data keranjang --}}
    @foreach ($keranjangs as $keranjang)
        <div class="modal modal-blur fade" id="deletedata{{ $keranjang->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
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
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Merk:
                            *<b>{{ $keranjang->merk }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletekeranjang" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_keranjang" value="{{ $keranjang->id }}">
                                    {{-- <input type="hidden" name="no_keranjang" value="{{ $keranjang->no_keranjang }}"> --}}
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
    @endforeach
    {{-- end modal delete data keranjang --}}

    {{-- modal delete data detail --}}
    @foreach ($barangs as $barang)
        <div class="modal modal-blur fade" id="deletedata{{ $barang->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
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
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Merk:
                            *<b>{{ $barang->merk }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal" onclick="refresh()"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletedetail" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_detail" value="{{ $barang->id }}">
                                    <input type="hidden" name="kode_barcode" value="{{ $barang->kode_barcode }}">
                                    {{-- <input type="hidden" name="no_keranjang" value="{{ $keranjang->no_keranjang }}"> --}}
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
    @endforeach
    {{-- end modal delete data detail --}}

    {{-- modal view data --}}
    @foreach ($pengadaans as $pengadaan)
        @php
            $detail_barangs = DB::table('detail_barangs')
                ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
                ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
                ->where('detail_barangs.no_pengadaan', '=', $pengadaan->no_pengadaan)
                ->get();
        @endphp
        <div class="modal modal-blur fade" id="showdata{{ $pengadaan->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Detail Pengadaan {{ $pengadaan->no_pengadaan }}</h4>
                        <br>
                        Pada Tanggal: {{ $pengadaan->tanggal_pengadaan }}
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped" id="data-tables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>Foto Profil</th> --}}
                                    <th>Kode</th>
                                    {{-- <th>Alamat</th> --}}
                                    {{-- <th>No Telepon</th> --}}
                                    <th>Merk</th>
                                    {{-- <th>Tanggal Pengadaan</th> --}}
                                    {{-- <th>Jenis Pengadaan</th> --}}
                                    <th>Kondisi</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Harga</th>
                                    {{-- <th>Keterangan</th> --}}
                                    <th data-searchable="false">Action</th>
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($detail_barangs as $detail_barang)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td>No Barang: <b>{{ $detail_barang->no_barang }}</b> <br>Barcode:
                                        <b>{!! DNS1D::getBarcodeHTML($detail_barang->kode_barcode, 'UPCA') !!}{{ $detail_barang->kode_barcode }}</b> <br>No
                                        Asset: <b>{{ $detail_barang->no_asset }}</b><br>Nomor
                                        Kodifikasi: <b>{{ $detail_barang->nomor_kodifikasi }}</b>
                                    </td>
                                    <td>{{ $detail_barang->merk }}, {{ $detail_barang->spesifikasi }}</td>
                                    {{-- <td>{{ $detail_barang->tanggal_pengadaan }}</td> --}}
                                    {{-- <td>{{ $detail_barang->jenis_pengadaan }}</td> --}}
                                    <td>{{ $detail_barang->kondisi }}</td>
                                    {{-- <td>{{ $detail_barang->status }}</td> --}}
                                    <td>Rp. {{ number_format($detail_barang->harga) }}</td>
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>{{ $detail_barang->keterangan }}</td> --}}
                                    <td>
                                        {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $detail_barang->id }}"
                                        style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button> --}}
                                        <a href="/print/barcode?barcode={{ $detail_barang->kode_barcode }}"
                                            target="blank" class="btn btn-warning mt-1"><i
                                                class="fa-solid fa-barcode"></i></a>
                                        <button data-bs-toggle="modal"
                                            data-bs-target="#deletedata{{ $detail_barang->id }}"
                                            class="btn btn-danger mt-1">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal view data --}}

    {{-- modal delete Pengadaan --}}
    @foreach ($pengadaans as $pengadaan)
        <div class="modal modal-blur fade" id="deletePengadaan{{ $pengadaan->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
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
                        <h6>PERINGATAN !!</h6>
                        <div class="text-muted">Menghapus <b>{{ $pengadaan->no_pengadaan }}</b> ini akan menghapus
                            <b>SEMUA</b> Properti yang ada pada Pengadaan ini akan Terhapus!</div>
                        <hr>
                        <form action="/deletepengadaan" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="form-group">
                                <label for="">Ketik "KONFIRMASI" untuk Menghapus</label>
                                <input type="text" name="konfirmasi" class="form-control" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>

                                <input type="hidden" name="no_pengadaan" value="{{ $pengadaan->no_pengadaan }}">
                                {{-- <input type="hidden" name="no_keranjang" value="{{ $keranjang->no_keranjang }}"> --}}
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
    @endforeach
    {{-- end modal delete Pengadaan --}}

    {{-- end modal --}}

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });

        function refresh() {
            location.reload();
        }
    </script>
@endsection
