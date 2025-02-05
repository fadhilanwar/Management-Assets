@extends('super_user.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
            data-bs-target="#addpegawai">
            <i class="fa-solid fa-folder-plus me-1"></i> Tambah Data
        </button>
        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>L/P</th>

                    {{-- <th>Alamat</th> --}}
                    <th>No Telp</th>
                    <th>Organisasi</th>
                    {{-- <th>Foto</th> --}}
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($pegawais as $pegawai)
                @php
                    $departemen = DB::table('departemens')
                        ->select('*')
                        ->where('id', '=', $pegawai->id_departemen)
                        ->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>

                        @if ($pegawai->foto == null)
                            <img src="{{ asset('nophoto.png') }}" class="rounded rounded-circle"
                                style="width: 60px; height: 60px;" alt="">
                        @else
                            <img src="{{ asset('storage/' . $pegawai->foto) }}" class="rounded rounded-circle"
                                style="width: 60px; height: 60px;" alt="">
                        @endif


                    </td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>{{ $pegawai->nik }}</td>
                    <td>{{ $pegawai->nama_user }}</td>
                    <td>
                        @if ($pegawai->jenis_kelamin === 'L')
                            L
                        @else
                            P
                        @endif
                    </td>
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    <td>{{ $pegawai->no_telepon }}</td>
                    <td>({{ $departemen->no_departemen }}) {{ $departemen->departemen }}</td>

                    <td>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $pegawai->id }}"
                            style="margin-right: 10px" class="btn btn-primary mr-2"><i
                                class="fa-regular fa-eye"></i></button> --}}

                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $pegawai->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $pegawai->id }}"
                            class="btn btn-danger mt-1">
                            <i class="fa fa-trash"></i>
                        </button>

                        @php
                            // Query untuk memeriksa apakah pegawai sudah ada di tabel 'users'
                            $cekPegawai = DB::table('pegawais')
                                ->leftJoin('users', 'users.nik', '=', 'pegawais.nik')
                                ->where('pegawais.id', '=', $pegawai->id)
                                ->select('users.nik')
                                ->first();
                        @endphp

                        @if ($cekPegawai && $cekPegawai->nik)
                            {{-- Pegawai sudah menjadi user, jadi tombol tidak ditampilkan --}}
                        @else
                            {{-- Pegawai belum menjadi user, jadi tombol ditampilkan --}}
                            <button data-bs-toggle="modal" data-bs-target="#goAdmin{{ $pegawai->id }}"
                                style="margin-right: 10px" class="btn btn-light mr-2">
                                <i class="fa-solid fa-sliders"></i>
                            </button>
                        @endif

                    </td>
                </tr>
            @endforeach
        </table>
    </div>


    {{-- modal add data --}}
    <div class="modal modal-blur fade" id="addpegawai" tabindex="-1" role="dialog" style="font-size: 14px;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/addpegawai" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">NIK* :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nik') is-invalid @enderror" placeholder="NIK.."
                                        id="name" name="nik" required>
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Nama pegawai* :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nama_user') is-invalid @enderror"
                                        placeholder="Nama pegawai.." id="name" name="nama_user" required>
                                    @error('nama_user')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Gender :</label>
                                    <div class="input-group">
                                        <select style="font-size: 14px;"
                                            class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                            name="jenis_kelamin">
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Alamat :</label>
                                    <textarea style="font-size: 14px;" type="text" class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Alamat.." id="name" name="alamat"></textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">No Telepon :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('no_telepon') is-invalid @enderror"
                                        placeholder="No telepon.." id="name" name="no_telepon">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @php
                                        $departemens = DB::table('departemens')->select('*')->get();
                                    @endphp
                                    <label for="name" class="col-form-label">Departemen :</label>
                                    <select style="font-size: 14px;"
                                        class="form-select @error('id_departemen')
                                        is-invalid
                                    @enderror"
                                        id="inputGroupSelect01" name="id_departemen">
                                        @foreach ($departemens as $departemen)
                                            <option value="{{ $departemen->id }}">{{ $departemen->departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_departemen')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <img class="img-preview img-fluid col-3 rounded rounded-circle"
                                        style="display: none; width: 120px; height: 120px;" id="img-preview">
                                    <label for="name" class="col-form-label">Foto(opsional) :</label>
                                    <br>
                                    <input style="font-size: 14px;" type="file"
                                        class="form-control mb-3 @error('foto') is-invalid @enderror"
                                        placeholder="Choose Photo.." id="foto" name="foto"
                                        onchange="previewImage()">
                                    @error('foto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" style="font-size: 14px;">Create Data</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    {{-- end modal add data --}}

    {{-- modal edit data --}}
    @foreach ($pegawais as $pegawai)
        <div class="modal modal-blur fade" id="editdata{{ $pegawai->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-6">Edit {{ $title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/editpegawai" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                @csrf
                                @method('PUT')
                                <input type="hidden" value="{{ $pegawai->id }}" name="id_user">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">NIK :</label>
                                        <input style="font-size: 14px; background: #eee" type="text"
                                            class="form-control readonly @error('nik') is-invalid @enderror"
                                            placeholder="NIK.." id="name" name="nik"
                                            value="{{ $pegawai->nik }}" readonly required>
                                        @error('nik')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Nama Pegawai :</label>
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('nama_user') is-invalid @enderror"
                                            placeholder="Nama pegawai.." id="name" name="nama_user"
                                            value="{{ $pegawai->nama_user }}" required>
                                        @error('nama_user')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Gender :</label>
                                        <div class="input-group">
                                            @if ($pegawai->jenis_kelamin === 'L')
                                                <select style="font-size: 14px;"
                                                    class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                                    name="jenis_kelamin">

                                                    <option value="L" selected><b>Laki-Laki</b></option>
                                                    <option value="P">Perempuan</option>

                                                </select>
                                            @elseif($pegawai->jenis_kelamin === 'P')
                                                <select style="font-size: 14px;"
                                                    class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                                    name="jenis_kelamin">

                                                    <option value="P" selected><b>Perempuan</b></option>
                                                    <option value="L">Laki-Laki</option>

                                                </select>
                                            @endif
                                        </div>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Alamat :</label>
                                        <textarea style="font-size: 14px;" type="text"
                                            class="form-control @error('alamat')
                                        is-invalid
                                    @enderror"
                                            placeholder="Alamat.." id="name" name="alamat">{{ $pegawai->alamat }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">No Telepon :</label>
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('no_telepon')
                                            is-invalid
                                        @enderror"
                                            placeholder="No telepon.." id="name" name="no_telepon"
                                            value="{{ $pegawai->no_telepon }}">
                                        @error('no_telepon')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @php
                                            $departemens = DB::table('departemens')->select('*')->get();
                                        @endphp
                                        <label for="name" class="col-form-label">Departemen :</label>
                                        <select style="font-size: 14px;"
                                            class="form-select @error('id_departemen')
                                        is-invalid
                                    @enderror"
                                            id="inputGroupSelect01" name="id_departemen">
                                            @foreach ($departemens as $departemen)
                                                @if (old('id_departemen', $pegawai->id_departemen) == $departemen->id)
                                                    <option value="{{ $departemen->id }}" selected>
                                                        {{ $departemen->departemen }}</option>
                                                @else
                                                    <option value="{{ $departemen->id }}">
                                                        {{ $departemen->departemen }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('id_departemen')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">preview</label>
                                        <br>
                                        <div class="row d-flex w-100 align-items-center">
                                            <div class="col-md-4">

                                                <img class="img-preview img-fluid col-3 rounded rounded-circle"
                                                    id="img-preview" src="{{ asset('storage/' . $pegawai->foto) }}"
                                                    style="width: 120px; height: 120px;">


                                            </div>
                                            <div class="col-md-4 text-center"><i
                                                    class="fa-solid fa-circle-chevron-right"></i><br>Ubah menjadi</i></div>
                                            <div class="col-md-4">
                                                <img class="img-preview img-fluid col-3 rounded rounded-circle"
                                                    style="display: none;width: 120px; height: 120px; "
                                                    id="img-preview-edit{{ $pegawai->id }}">
                                            </div>


                                        </div>
                                        <br>
                                        <label for="name" class="col-form-label">New Foto(opsional) :</label>

                                        <input type="hidden" name="oldPic" value="{{ $pegawai->foto }}">


                                        <input style="font-size: 14px;" type="file"
                                            class="form-control mb-3 @error('foto') is-invalid @enderror"
                                            placeholder="Choose Photo.." id="fotoedit{{ $pegawai->id }}" name="foto"
                                            onchange="previewImage2({{ $pegawai->id }})">
                                        @error('foto')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                style="font-size: 14px;">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" style="font-size: 14px;">Edit Data</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        </div>
    @endforeach
    {{-- end modal edit data --}}


    {{-- modal add data --}}
    <div class="modal modal-blur fade" id="adddata" tabindex="-1" role="dialog" style="font-size: 14px;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/addpegawai" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">NIK* :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nik') is-invalid @enderror" placeholder="NIK.."
                                        id="name" name="nik" required>
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Nama pegawai* :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nama_user') is-invalid @enderror"
                                        placeholder="Nama pegawai.." id="name" name="nama_user" required>
                                    @error('nama_user')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Gender :</label>
                                    <div class="input-group">
                                        <select style="font-size: 14px;"
                                            class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                            name="jenis_kelamin">
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Alamat :</label>
                                    <textarea style="font-size: 14px;" type="text" class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Alamat.." id="name" name="alamat"></textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">No Telepon :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('no_telepon') is-invalid @enderror"
                                        placeholder="No telepon.." id="name" name="no_telepon">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Organisasi* :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('organisasi') is-invalid @enderror"
                                        placeholder="Organisasi.." id="name" name="organisasi" required>
                                    @error('organisasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <img class="img-preview img-fluid col-3 rounded rounded-circle"
                                        style="display: none; width: 120px; height: 120px;" id="img-preview">
                                    <label for="name" class="col-form-label">Foto :</label>
                                    <br>
                                    <input style="font-size: 14px;" type="file"
                                        class="form-control mb-3 @error('foto') is-invalid @enderror"
                                        placeholder="Choose Photo.." id="foto" name="foto"
                                        onchange="previewImage()">
                                    @error('foto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" style="font-size: 14px;">Create Data</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    {{-- end modal add data --}}

    {{-- modal jadikan adminsitrator --}}

    @foreach ($pegawais as $pegawai)
        <div class="modal modal-blur fade" id="goAdmin{{ $pegawai->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-6">Jadikan ({{ $pegawai->nama_user }}) <b>Petugas..</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <form action="/addpetugasfrompegawai" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="name" class="col-form-label">NIK* :</label>
                                                <input value="{{ $pegawai->nik }}"
                                                    style="font-size: 14px; background: #eee" type="text"
                                                    class="form-control @error('nik')
                          is-invalid
                      @enderror"
                                                    placeholder="NIK.." id="name" name="nik" autocomplete="off"
                                                    readonly required>
                                                @error('nik')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="name" class="col-form-label">Nama Petugas* :</label>
                                                <input value="{{ $pegawai->nama_user }}"
                                                    style="font-size: 14px; background: #eee" type="text"
                                                    class="form-control @error('nama_user')
                          is-invalid
                      @enderror"
                                                    placeholder="Nama petugas.." id="name" name="nama_user"
                                                    autocomplete="off" required readonly>
                                                @error('nama_user')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>


                                        {{-- <label for="name" class="col-form-label">Gender :</label>
                                    <div class="input-group">
                                        @if ($pegawai->jenis_kelamin === 'L')
                                            <select style="font-size: 14px;"
                                                class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                                name="jenis_kelamin">

                                                <option value="L" selected><b>Laki-Laki</b></option>
                                                <option value="P">Perempuan</option>

                                            </select>
                                        @elseif($pegawai->jenis_kelamin === 'P')
                                            <select style="font-size: 14px;"
                                                class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                                name="jenis_kelamin">

                                                <option value="P" selected><b>Perempuan</b></option>
                                                <option value="L">Laki-Laki</option>

                                            </select>
                                        @endif
                                    </div>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror --}}
                                        {{-- <label for="name" class="col-form-label">Alamat :</label>
                                    <textarea style="font-size: 14px;" type="text"
                                        class="form-control @error('alamat')
                  is-invalid
              @enderror" placeholder="Alamat.."
                                        id="name" name="alamat">{{ $pegawai->alamat }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror --}}
                                        {{-- <label for="name" class="col-form-label">No Telepon :</label>
                                    <input value="{{ $pegawai->no_telepon }}" style="font-size: 14px;" type="text"
                                        class="form-control @error('no_telepon')
                  is-invalid
              @enderror"
                                        placeholder="No telepon.." id="name" name="no_telepon" autocomplete="off">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror --}}
                                </div>
                                <div class="form-group">

                                    <label for="name" class="col-form-label"><b>Username*</b> :</label>
                                    <input value="{{ $pegawai->nik }}" style="font-size: 14px;" type="text"
                                        class="form-control @error('username')
                  is-invalid
              @enderror"
                                        placeholder="Username.." id="name" name="username" autocomplete="off"
                                        required>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label"><b>Password*</b> :</label>
                                    <input style="font-size: 14px;" type="password"
                                        class="form-control @error('password')
                  is-invalid
              @enderror"
                                        placeholder="Password.." id="name" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Role :</label>
                                    <select style="font-size: 14px;"
                                        class="form-select @error('role')
                                    is-invalid
                                @enderror"
                                        id="inputGroupSelect01" name="role">
                                        <option value="super_user">Super User</option>
                                        <option value="petugas">Koordinator</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    {{-- <label for="name" class="col-form-label">Foto(opsional) :</label>
                                <br>
                                <input value="{{ $pegawai->foto }}" style="font-size: 14px;" type="file"
                                    class="form-control mb-3 @error('foto') is-invalid @enderror"
                                    placeholder="Choose Photo.." id="foto" name="foto"
                                    onchange="previewImage()">
                                @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <img class="img-preview img-fluid col-3 rounded rounded-circle"
                                            style="display: none;" id="img-preview"> --}}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" style="font-size: 14px;">Create Data</button>
                    </div>
                    </form>
                </div>

            </div>
        </div>
        </div>
    @endforeach

    {{-- end end modal jadikan administrator --}}

    {{-- modal delete data --}}
    @foreach ($pegawais as $pegawai)
        <div class="modal modal-blur fade" id="deletedata{{ $pegawai->id }}" tabindex="-1" role="dialog"
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
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Nama Pegawai:
                            *<b>{{ $pegawai->nama_user }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletepegawai" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_user" value="{{ $pegawai->id }}">
                                    <input type="hidden" name="foto" value="{{ $pegawai->foto }}">
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
    {{-- end modal delete data --}}




    <script>
        function previewImage() {
            const image = document.getElementById("foto")
            console.log(image);
            const imgPreview = document.getElementById('img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }

        }
    </script>
    {{-- PREVIEW IMAGE UNTUK EDIT --}}
    <script>
        function previewImage2(idpegawai) {
            console.log("haha");
            // const idpegawai = document.getElementById('id_petugas').value;
            // const haha = "fotoedit"
            console.log(idpegawai);
            var imageedit = "fotoedit" + idpegawai;
            var imgPreviewedit = "img-preview-edit" + idpegawai;
            const imageedit2 = document.getElementById(imageedit);
            const imgPreviewedit2 = document.getElementById(imgPreviewedit);

            imgPreviewedit2.style.display = 'block';

            const oFReader2 = new FileReader();
            oFReader2.readAsDataURL(imageedit2.files[0]);

            oFReader2.onload = function(oFREvent) {
                imgPreviewedit2.src = oFREvent.target.result;
            }
        }
    </script>
    {{-- END PREVIEW IMAGE UNTUK EDIT --}}
@endsection
