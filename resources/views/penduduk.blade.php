@include('layouts.header')

<div class="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table"></i> Data Penduduk Desa</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nomor Induk Kependudukan (NIK)</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat/Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($penduduk->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center label label-danger">Tidak ada penduduk</td>
                                </tr>
                            @else
                                @foreach ($penduduk as $key => $p)
                                    <tr class="text-center">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $p->users->nik }}</td>
                                        <td>{{ $p->users->nama_depan . ' ' . $p->users->nama_belakang }}</td>
                                        <td>
                                            @if ($p->jenis_kelamin == 'L')
                                                Laki-laki
                                            @elseif($p->jenis_kelamin == 'P')
                                                Perempuan
                                            @else
                                                Tidak Diketahui
                                            @endif
                                        </td>
                                        <td>{{ $p->tempat_lahir . '/' . $p->tanggal_lahir }}</td>
                                        <td>{{ $p->alamat }}</td>
                                        <td>
                                            <!-- Tombol untuk memicu modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#modalPenduduk-{{ $p->id_user }}">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalPenduduk-{{ $p->id_user }}"
                                                tabindex="-1" role="dialog" aria-labelledby="modalPendudukLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalPendudukLabel">Foto Profil
                                                                Penduduk</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('storage/' . $p->users->foto_profil) }}"
                                                                alt="Foto Profil" class="img-fluid" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            |
                                            <button class="btn btn-warning" data-toggle="modal"
                                                data-target="#modal-edit-{{ $p->id_penduduk }}"><i
                                                    class="fas fa-edit"></i> Ubah</button>

                                            <div class="modal fade" id="modal-edit-{{ $p->id_penduduk }}" tabindex="-1"
                                                aria-labelledby="ModalEdit" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                {{ $title }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('update_penduduk', $p->id_penduduk) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <input type="file" name="foto_profil"
                                                                            class="custom-file-input" id="foto_profil"
                                                                            onchange="previewFile(this);">
                                                                        <label class="custom-file-label"
                                                                            for="foto_profil">Pilih Foto Profil</label>
                                                                        <img id="preview"
                                                                            src="{{ asset('storage/' . $p->users->foto_profil) }}"
                                                                            alt="Preview Foto Profil"
                                                                            class="img-fluid" />
                                                                    </div>
                                                                    <div class="col-12 mt-3">
                                                                        <label for="nik">NIK</label>
                                                                        <input type="number"
                                                                            class="form-control @error('nik')
                                                                is-invalid
                                                            @enderror"
                                                                            name="nik" id="nik"
                                                                            placeholder="NIK"
                                                                            value="{{ $p->users->nik }}">
                                                                        @error('nik')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-6 mt-3">
                                                                        <label for="nama_depan">Nama Depan</label>
                                                                        <input type="text" class="form-control"
                                                                            name="nama_depan" id="nama_depan"
                                                                            placeholder="Nama Depan"
                                                                            value="{{ $p->users->nama_depan }}">
                                                                    </div>
                                                                    <div class="col-6 mt-3">
                                                                        <label for="nama_belakang">Nama
                                                                            Belakang</label>
                                                                        <input type="text" class="form-control"
                                                                            name="nama_belakang" id="nama_belakang"
                                                                            placeholder="Nama Belakang"
                                                                            value="{{ $p->users->nama_belakang }}">
                                                                    </div>
                                                                    <div class="col-12 mt-3">
                                                                        <label for="jenis_kelamin">Jenis
                                                                            Kelamin</label>
                                                                        <select name="jenis_kelamin"
                                                                            id="jenis_kelamin" class="form-control">
                                                                            <option value="">--- Pilih Jenis
                                                                                Kelamin ---</option>
                                                                            <option value="L"
                                                                                {{ $p->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                                Laki-laki</option>
                                                                            <option value="P"
                                                                                {{ $p->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                                Perempuan</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-6 mt-3">
                                                                        <label for="tempat_lahir">Tempat Lahir</label>
                                                                        <input type="text" class="form-control"
                                                                            name="tempat_lahir" id="tempat_lahir"
                                                                            placeholder="Tempat Lahir"
                                                                            value="{{ $p->tempat_lahir }}">
                                                                    </div>
                                                                    <div class="col-6 mt-3">
                                                                        <label for="tanggal_lahir">Tanggal
                                                                            Lahir</label>
                                                                        <input type="date" class="form-control"
                                                                            name="tanggal_lahir" id="tanggal_lahir"
                                                                            placeholder="Tanggal Lahir"
                                                                            value="{{ $p->tanggal_lahir }}">
                                                                    </div>
                                                                    <div class="col-12 mt-3">
                                                                        <label for="alamat">Alamat</label>
                                                                        <textarea class="form-control" name="alamat" id="alamat" placeholder="alamat" cols="4">{{ $p->alamat }}</textarea>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="col-6 mt-3">
                                                                        <label for="username">Username</label>
                                                                        <input type="text"
                                                                            class="form-control @error('username') is-invalid @enderror"
                                                                            name="username" id="username"
                                                                            placeholder="Username"
                                                                            value="{{ $p->users->username }}">
                                                                        @error('username')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-6 mt-3">
                                                                        <label for="email">Email</label>
                                                                        <input type="email"
                                                                            class="form-control @error('email') is-invalid @enderror"
                                                                            name="email" id="username"
                                                                            placeholder="Email"
                                                                            value=" {{ $p->users->email }}">
                                                                        @error('email')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-12 mt-3">
                                                                        <label for="old_password">Password Lama</label>
                                                                        <input type="password"
                                                                            class="form-control @error('old_password') is-invalid @enderror"
                                                                            name="old_password" id="old_password"
                                                                            placeholder="Masukkan password lama">
                                                                        @error('old_password')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <label for="new_password">Password Baru</label>
                                                                        <input type="password"
                                                                            class="form-control @error('new_password') is-invalid @enderror"
                                                                            name="new_password" id="new_password"
                                                                            placeholder="Masukkan password baru">
                                                                        @error('new_password')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <label
                                                                            for="new_password_confirmation">Konfirmasi
                                                                            Password Baru</label>
                                                                        <input type="password"
                                                                            class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                                            name="new_password_confirmation"
                                                                            id="new_password_confirmation"
                                                                            placeholder="Konfirmasi password baru">
                                                                        @error('new_password_confirmation')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary"><i
                                                                    class="fas fa-save"></i>
                                                                Simpan</button>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                            |

                                            {{-- Button Hapus --}}
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal-hapus-{{ $p->id_penduduk }}"><i
                                                    class="fas fa-trash"></i> Hapus</button>


                                            {{-- Modal Hapus --}}
                                            <div class="modal fade" id="modal-hapus-{{ $p->id_penduduk }}"
                                                tabindex="-1" role="dialog" aria-labelledby="modal-hapusLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-hapusLabel">
                                                                Konfirmasi
                                                                Hapus Data</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus data penduduk
                                                            <b>{{ $p->users->nik }}</b>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Tutup</button>
                                                            <form
                                                                action="{{ route('destroy_penduduk', ['id_user' => $p->id_user]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm mt-2" type="button" data-toggle="modal"
                            data-target="#ModalTambah"><i class="fas fa-plus"></i> Tambah</button>

                        <!-- Modal Tambah -->
                        <div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="ModalTambah"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah {{ $title }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('store_penduduk') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="file" name="foto_profil"
                                                        class="custom-file-input" id="foto_profil"
                                                        onchange="previewFile(this);" required>
                                                    <label class="custom-file-label" for="foto_profil">Pilih Foto
                                                        Profil</label>
                                                    <img id="preview" src="#" alt="Preview Foto Profil"
                                                        class="img-fluid" style="display:none;" />
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="nik">NIK</label>
                                                    <input type="number"
                                                        class="form-control @error('nik')
                                                        is-invalid
                                                    @enderror"
                                                        name="nik" id="nik" placeholder="NIK"
                                                        value="{{ old('nik') }}">
                                                    @error('nik')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <label for="nama_depan">Nama Depan</label>
                                                    <input type="text" class="form-control" name="nama_depan"
                                                        id="nama_depan" placeholder="Nama Depan"
                                                        value="{{ old('nama_depan') }}">
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <label for="nama_belakang">Nama Belakang</label>
                                                    <input type="text" class="form-control" name="nama_belakang"
                                                        id="nama_belakang" placeholder="Nama Belakang"
                                                        value="{{ old('nama_belakang') }}">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" id="jenis_kelamin"
                                                        class="form-control">
                                                        <option value="">--- Pilih Jenis Kelamin ---</option>
                                                        <option value="L">Laki-laki</option>
                                                        <option value="P">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input type="text" class="form-control" name="tempat_lahir"
                                                        id="tempat_lahir" placeholder="Tempat Lahir">
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" name="tanggal_lahir"
                                                        id="tanggal_lahir" placeholder="Tanggal Lahir">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="alamat">Alamat</label>
                                                    <textarea class="form-control" name="alamat" id="alamat" placeholder="alamat" cols="4"></textarea>
                                                </div>
                                                <hr>
                                                <div class="col-6 mt-3">
                                                    <label for="username">Username</label>
                                                    <input type="text"
                                                        class="form-control @error('username') is-invalid @enderror"
                                                        name="username" id="username" placeholder="Username"
                                                        value="{{ old('username') }}">
                                                    @error('username')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <label for="email">Email</label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" id="username" placeholder="Email"
                                                        value=" {{ old('email') }}">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="password">Password</label>
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" id="password" placeholder="Password"
                                                        placeholder="Password">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                            Simpan</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

<script src="{{ asset('temp/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('temp/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('temp/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('temp/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('temp/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<script>
    function previewFile(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('preview').style.display = 'block';
            };
            reader.readAsDataURL(file);

            input.nextElementSibling.textContent = file.name;
        }
    }
</script>

<script>
    function previewFile(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            };
            reader.readAsDataURL(file);

            input.nextElementSibling.textContent = file.name;
        }
    }
</script>
