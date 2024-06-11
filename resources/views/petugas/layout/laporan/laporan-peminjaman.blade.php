@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-warning btn-sm mt-2 mb-2 w-100" data-bs-toggle="modal"
                    data-bs-target="#filter">
                    <i class="fa fa-slider"></i>
                    Filter
                </button>
            </div>
            {{-- <div class="col-md-8">
                <a href="/print-petugas" target="blank" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                    <i class="fa-solid fa-print"></i>
                    Print
                </a>
            </div> --}}
            <div class="col-md-8">
                <!-- Form untuk mengirimkan data saat print -->
                <form action="/print-data-peminjaman-pdf" method="GET" target="_blank" id="printForm">
                    @if ($requests == null)
                    @else
                        <input type="hidden" name="date" id="requestsInput" value="{{ $requests->query('date') }}">
                        <input type="hidden" name="role" id="requestsInput" value="{{ $requests->query('role') }}">
                    @endif
                    <button type="submit" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                        <i class="fa-solid fa-print"></i>
                        Print
                    </button>
                </form>
            </div>
        </div>

        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Peminjaman</th>
                    {{-- <th>Merk</th> --}}
                    <th>Tgl. Pinjam-kembali</th>
                    <th>Peminjam</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th data-searhable="false">
                        Action
                    </th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($peminjamans as $peminjaman)
                @php
                    $pegawai = DB::table('pegawais')
                        ->select('*')
                        ->where('nik', '=', $peminjaman->id_pegawai)
                        ->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $peminjaman->no_peminjaman }}</td>
                    <td>{{ $peminjaman->tanggal_peminjaman }} - {{ $peminjaman->tanggal_kembali }}</td>
                    {{-- <td>{{ $peminjaman->jenis_pengadaan }}</td> --}}
                    <td>{{ $pegawai->nama_user }}</td>
                    <td>{{ $peminjaman->status_peminjaman }}</td>
                    <td>{{ $peminjaman->keterangan }}</td>
                    {{-- <td>Rp. {{ number_format($peminjaman->harga) }}</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>{{ $barang->keterangan }}</td> --}}
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#showdata{{ $peminjaman->id }}"
                            class="btn btn-primary mt-1">
                            <i class="fa fa-eye"></i>
                        </button>
                        <a href="/print-data-peminjaman-pdf?no_peminjaman={{ $peminjaman->no_peminjaman }}" target="_blank"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>


    </div>




    {{-- modal --}}

    {{-- modal view data --}}
    @foreach ($peminjamans as $peminjaman)
        @php
            $detail_barangs = DB::table('detail_peminjamans')
                ->join('peminjamans', 'detail_peminjamans.no_peminjaman', '=', 'peminjamans.no_peminjaman')
                ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_peminjamans.kode_barcode')
                ->select('*')
                ->where('detail_peminjamans.no_peminjaman', '=', $peminjaman->no_peminjaman)
                ->get();

        @endphp
        <div class="modal modal-blur fade" id="showdata{{ $peminjaman->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
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
                                    {{-- <th>Jenis Pengadaan</th> --}}
                                    {{-- <th>Status</th> --}}
                                    {{-- <th>Keterangan</th> --}}
                                    <th data-searchable="false">Action</th>
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($detail_barangs as $detail_peminjaman)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td>No Barang: <b>{{ $detail_peminjaman->no_barang }}</b> <br>Barcode:
                                        <b>{!! DNS1D::getBarcodeHTML($detail_peminjaman->kode_barcode, 'UPCA') !!}{{ $detail_peminjaman->kode_barcode }}</b> <br>No
                                        Asset: <b>{{ $detail_peminjaman->no_asset }}</b>
                                    </td>
                                    <td>{{ $detail_peminjaman->merk }}, {{ $detail_peminjaman->spesifikasi }}</td>
                                    {{-- <td>{{ $detail_peminjaman->jenis_pengadaan }}</td> --}}
                                    {{-- <td>Rp. {{ number_format($detail_peminjaman->harga) }}</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>{{ $detail_peminjaman->keterangan }}</td> --}}
                                    <td>
                                        <a href="/print-data-peminjaman-pdf?no_peminjaman={{ $detail_peminjaman->no_peminjaman }}&kode_barcode={{ $detail_peminjaman->kode_barcode }}" target="_blank"
                                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a>
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

    {{-- end modal --}}

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });
    </script>
@endsection
