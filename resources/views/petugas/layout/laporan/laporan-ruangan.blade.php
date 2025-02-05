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
                <form action="/print-data-ruangan-pdf" method="GET" target="_blank" id="printForm">
                    @if ($requests == null)
                    @else
                        <input type="hidden" name="date" id="requestsInput" value="{{ $requests->query('date') }}">
                        <input type="hidden" name="tipe" id="requestsInput" value="{{ $requests->query('tipe') }}">
                    @endif
                    <button type="submit" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                        <i class="fa-solid fa-print"></i>
                        Print
                    </button>
                </form>
            </div>
            <form method="GET" action="/export-laporan-data-ruangan">
                @if ($requests == null)
                @else
                    <input type="hidden" name="date" id="requestsInput" value="{{ $requests->query('date') }}">
                    <input type="hidden" name="tipe" id="requestsInput" value="{{ $requests->query('tipe') }}">
                @endif
                <button type="submit" class="btn btn-success mb-2"><i class="fa-solid fa-download me-2"></i>Download
                    Excel</button>
            </form>
        </div>
        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Ruangan</th>
                    <th>Ruangan</th>
                    <th>Lokasi</th>
                    <th>Kapasitas</th>
                    <th>Foto Ruangan</th>
                    <th>Tipe Ruangan</th>
                    <th>Tanggal Data Dibuat</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($ruangans as $ruangan)
                @php
                    $tipe_ruangan = DB::table('tipe_ruangans')
                        ->select('nama_tipe')
                        ->where('id', '=', $ruangan->tipe_ruangan)
                        ->get();
                    $image_ruangan = DB::table('image_ruangans')
                        ->select('image')
                        ->where('no_ruangan', '=', $ruangan->no_ruangan)
                        ->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    <td>{{ $ruangan->no_ruangan }}</td>
                    <td>{{ $ruangan->ruangan }}</td>
                    <td>{{ $ruangan->lokasi }}</td>
                    <td>{{ $ruangan->kapasitas }}</td>
                    <td>
                        <div class="d-flex flex-column image-ruangan">
                            {{-- @foreach ($image_ruangans as $image_ruangan) --}}
                            {{-- <img src="{{ asset('storage/' . $image_ruangan->image) }}" alt="" width="100px"
                                        class="mb-1"> --}}
                            @if ($image_ruangan)
                                <img src="{{ asset('storage/' . $image_ruangan->image) }}" alt="" width="100px"
                                    class="mb-1">
                            @else
                                <img src="/lol" alt="No Png" width="100px" class="mb-1">
                            @endif
                            {{-- @endforeach --}}
                            <button class="btn btn-primary view-button btn-sm" data-bs-toggle="modal"
                                data-bs-target="#viewimg{{ $ruangan->id }}">
                                <i class="fa-solid fa-eye "></i>
                            </button>
                        </div>
                    </td>
                    <td>{{ $tipe_ruangan[0]->nama_tipe }}</td>
                    <td>{{ $ruangan->created_at }}</td>

                    <td>

                        {{-- <button data-bs-toggle="modal" data-bs-target="#showdata{{ $ruangan->id }}"
                                style="margin-right: 10px" class="btn btn-primary mr-2"><i class="fa fa-eye"></i></button> --}}
                        <a href="/print-data-ruangan-pdf?no_ruangan={{ $ruangan->no_ruangan }}" target="blank"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>


    {{-- modal --}}

    {{-- modal view image --}}
    @foreach ($ruangans as $ruangan)
        <div class="modal modal-blur fade" id="viewimg{{ $ruangan->id }}" tabindex="-1" role="dialog" aria-hidden="true"
            style="font-size: 14px;">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent">
                    <div class="modal-body d-flex justify-content-center">
                        @php
                            $images_view = DB::table('image_ruangans')
                                ->select('*')
                                ->where('no_ruangan', '=', $ruangan->no_ruangan)
                                ->get();
                            $image_view = DB::table('image_ruangans')
                                ->select('*')
                                ->where('no_ruangan', '=', $ruangan->no_ruangan)
                                ->limit(1)
                                ->first();
                            $no = 2;
                            $no1 = 1;
                            // dd($image_view);
                        @endphp
                        <div id="carouselExample{{ $ruangan->id }}" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    {{-- <div class="img-ruangan">
                                        <img src="{{ asset('storage/' . $image_view[0]->image) }}"
                                            class="d-block img-fluid" alt="...">
                                        <div class="delete-button-img-ruangan">
                                            <a class="btn btn-primary btn-lg text-deco  ration-none"
                                                href="http://127.0.0.1:8000{{ asset('storage/' . $image_view[0]->image) }}"
                                                target="blank">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <button class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                                data-bs-target="#deleteimg{{ $image_view[0]->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </div> --}}
                                    @if ($image_view == null)
                                        No Png
                                    @else
                                        <div class="img-ruangan">
                                            <img src="{{ asset('storage/' . $image_view->image) }}"
                                                class="d-block img-fluid" alt="...">
                                            {{-- <div class="delete-button-img-ruangan">
                                            <a class="btn btn-primary btn-lg text-decoration-none"
                                                href="http://127.0.0.1:8000{{ asset('storage/' . $image_view->image) }}"
                                                target="blank">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <button class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                                data-bs-target="#deleteimg{{ $image_view->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div> --}}
                                        </div>
                                    @endif
                                </div>
                                @foreach ($images_view->skip(1) as $image)
                                    <div class="carousel-item">
                                        <div class="img-ruangan">
                                            <img src="{{ asset('storage/' . $image->image) }}" class="d-block img-fluid"
                                                alt="...">
                                            <div class="delete-button-img-ruangan">
                                                <a class="btn btn-primary btn-lg text-decoration-none"
                                                    href="http://127.0.0.1:8000{{ asset('storage/' . $image->image) }}"
                                                    target="blank">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <button class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                                    data-bs-target="#deleteimg{{ $image->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div class="carousel-item">
                                    <div class="img-ruangan">
                                        <label for="file" class="custom-file-upload-view-img-ruangan ms-3 mt-2">
                                            <form action="/addimgruangan" method="POST" enctype="multipart/form-data"
                                                id="uploadimgruangan">
                                                @csrf
                                                <input type="hidden" name="id_ruangan" value="{{ $ruangan->id }}">
                                                <div class="icon">
                                                    <i class="fa-solid fa-camera text-white"></i>
                                                </div>
                                                <div class="text">
                                                    <span>Tambah foto ruangan</span>
                                                </div>
                                                <input id="file" type="file" name="foto[]" multiple>
                                            </form>
                                        </label>
                                    </div>
                                </div> --}}
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExample{{ $ruangan->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExample{{ $ruangan->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal view image --}}

    {{-- modal filter --}}
    <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" style="font-size: 14px;">
                    <label class="mb-1" for="">Filter Berdasarkan Tanggal Dibuat Data Ruangan :</label>
                    <div class="form-group d-flex flex-direction-column">
                        <input type="date" class="form-control form-control-sm" id="startDate">
                        <span class="p-2"> - </span>
                        <input type="date" class="form-control form-control-sm" id="endDate">
                    </div>
                    <label for="">Tipe Ruangan</label>
                    <select style="font-size: 14px;" class="form-select" id="tipe" name="tipe">
                        <option value="">choose..</option>
                        {{-- <option value="super_user">Super User</option>
                    <option value="koordinator">Koordinator</option> --}}
                        @php
                            $tipes = DB::table('tipe_ruangans')->select('*')->get();
                            // dd($kategoris);
                        @endphp
                        @foreach ($tipes as $tipe)
                            <option value="{{ $tipe->id }}">{{ $tipe->nama_tipe }}</option>
                        @endforeach
                    </select>
                    <div class="mt-1">
                        <a href="" id="filterBtn" type="button" class="btn btn-primary btn-sm">Filter</a>
                    </div>
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- end modal filter --}}


    {{-- end modal --}}


    <script>
        $(document).ready(function() {
            $('#file').on('change', function() {
                $('#uploadimgruangan').submit();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const tipeInput = document.getElementById('tipe');
            const filterBtn = document.getElementById('filterBtn');

            console.log(tipeInput);

            function updateFilterHref() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const tipe = tipeInput.value;
                let href = '/laporan-data-ruangan/f=hah';

                if (startDate && endDate && tipe) {
                    href = `/laporan-data-ruangan/f=?date=${startDate}_${endDate}&tipe=${tipe}`;
                } else if (tipe) {
                    href = `/laporan-data-ruangan/f=?tipe=${tipe}`;
                } else if (tipe && startDate) {
                    href = `/laporan-data-ruangan/f=?date=${startDate}&tipe=${tipe}`;
                } else if (tipe && endDate) {
                    href = `/laporan-data-ruangan/f=?date=${endDate}&tipe=${tipe}`;
                    // } else if (startDate && endDate) {
                    //     href = `/laporan-data-ruangan/f=?date=${startDate}_${endDate}&tipe=${tipe}`;
                } else if (startDate) {
                    href = `/laporan-data-ruangan/f=?date=${startDate}`;
                } else if (endDate) {
                    href = `/laporan-data-ruangan/f=?date=${endDate}]`;
                    // href = `/laporan-data-petugas/f=_${endDate}]`;
                }

                // if (tipe && startDate == null && endDate == null) {
                //     // href += (href.includes('?') ? '&' : (href ? '' : '')) + `${tipe}`;
                //     href += (href.includes('?') ? '&' : '') + `${tipe}`;
                // }else if (tipe){
                //     href += (href.includes('?') ? '&' : (href ? '?tipe=' : '')) + `${tipe}`;
                // }

                filterBtn.href = href;
            }

            startDateInput.addEventListener('change', updateFilterHref);
            endDateInput.addEventListener('change', updateFilterHref);
            tipeInput.addEventListener('change', updateFilterHref);
        });
    </script>
@endsection
