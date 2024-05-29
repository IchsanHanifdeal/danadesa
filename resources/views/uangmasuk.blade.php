@include('layouts.header')
<div class="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table"></i> Data {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <p>No Rekening : Mandiri <b>(1080026752064 a/n MUHAMMAD QOIRUL RODZ)</b></p>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Pukul</th>
                                <th>Sumber</th>
                                <th>Nama Penduduk</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Bukti Transfer</th>
                                <th>Validasi</th>
                                @if ($role == 'admin')
                                    <th>Opsi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($uang_masuk->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center badge-secondary">Tidak ada Transaksi Masuk
                                    </td>
                                </tr>
                            @else
                                @foreach ($uang_masuk as $key => $um)
                                    <tr class="text-center">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $um->created_at }}</td>
                                        <td>{{ ucfirst($um->sumber) }}</td>
                                        <td>{{ (optional($um->users)->nama_depan ?? 'Pemerintah') . ' ' . (optional($um->users)->nama_belakang ?? '') }}</td>
                                        <td>{{ 'Rp ' . number_format($um->jumlah, 2, ',', '.') }}</td>
                                        <td>{{ $um->keterangan }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modalBukti-{{ $um->id_uangmasuk }}"> Lihat Bukti
                                                Transfer</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalBukti-{{ $um->id_uangmasuk }}"
                                                tabindex="-1" role="dialog" aria-labelledby="modalPendudukLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalPendudukLabel">Bukti
                                                                transfer
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('storage/' . $um->bukti_transfer) }}"
                                                                class="img-fluid" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($um->validasi === 'diterima')
                                                <span class="badge badge-success">Diterima</span>
                                            @elseif ($um->validasi === 'ditolak')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @else
                                                <span class="badge badge-secondary">Menunggu Persetujuan</span>
                                            @endif
                                        </td>
                                        @if ($role == 'admin')
                                            <td>
                                                @if ($um->validasi === 'diterima')
                                                    <i class="fas fa-check-circle text-success"></i>
                                                @elseif ($um->validasi === 'ditolak')
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                @else
                                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                                        data-target="#Modalterima-{{ $um->id_uangmasuk }}">Terima</button>

                                                    {{-- Modal Terima --}}
                                                    <div class="modal fade" id="Modalterima-{{ $um->id_uangmasuk }}"
                                                        tabindex="-1" aria-labelledby="ModalTambah" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Terima uang masuk dari
                                                                        {{ $um->users->nama_depan . ' ' . $um->users->nama_belakang }}
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menerima uang masuk dari
                                                                    <b>{{ $um->users->nama_depan . ' ' . $um->users->nama_belakang }}</b>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Tutup</button>
                                                                    <form
                                                                        action="{{ route('update_uangmasuk', ['id_uangmasuk' => $um->id_uangmasuk]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('put')
                                                                        <button type="submit"
                                                                            class="btn btn-success">Ya</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    |
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#Modaltolak-{{ $um->id_uangmasuk }}">Tolak</button>

                                                    <div class="modal fade" id="Modaltolak-{{ $um->id_uangmasuk }}"
                                                        tabindex="-1" aria-labelledby="ModalTambah" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Tolak uang masuk dari
                                                                        {{ $um->users->nama_depan . ' ' . $um->users->nama_belakang }}
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menolak uang masuk dari
                                                                    <b>{{ $um->users->nama_depan . ' ' . $um->users->nama_belakang }}</b>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Tutup</button>
                                                                    <form
                                                                        action="{{ route('tolak_uangmasuk', ['id_uangmasuk' => $um->id_uangmasuk]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('put')
                                                                        <button type="submit"
                                                                            class="btn btn-success">Ya</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($role == 'user')
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mt-3" data-toggle="modal"
                                data-target="#ModalTambah"><i class="fas fa-plus"></i> Tambah Transaksi</button>

                            <div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="ModalTambah"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('pendudukstore_uangmasuk') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah
                                                    {{ $title }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="for">Sumber</label>
                                                        <input type="text" name="sumber" class="form-control"
                                                            id="sumber" value="{{ ucfirst('penduduk') }}"
                                                            readonly>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="nama">Nama Penduduk</label>
                                                        <input type="text" name="nama_penduduk"
                                                            class="form-control"
                                                            value="{{ $nama_depan . ' ' . $nama_belakang }}" readonly>
                                                        <input type="number" name="id_user" class="form-control"
                                                            style="display: none;" value="{{ $id_user }}"
                                                            readonly>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="jumlah">Jumlah</label>
                                                        <input type="number" name="jumlah" id="jumlah"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="keterangan">Keterangan</label>
                                                        <textarea name="keterangan" id="keterangan" class="form-control" cols="4"></textarea>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <input type="file" name="bukti_transfer"
                                                            class="custom-file-input" id="foto_profil"
                                                            onchange="previewFile(this);" required>
                                                        <label class="custom-file-label" for="foto_profil">Pilih Bukti
                                                            Transfer</label>
                                                        <img id="preview" src="#" alt="Preview Foto Profil"
                                                            class="img-fluid" style="display:none;" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($role == 'admin')
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mt-3" data-toggle="modal"
                                data-target="#ModalTambah"><i class="fas fa-plus"></i> Tambah Transaksi</button>

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
                                        <form action="{{ route('store_uangmasuk') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="for">Sumber</label>
                                                        <input type="text" name="sumber" class="form-control"
                                                            id="sumber" value="{{ ucfirst('pemerintah') }}"
                                                            readonly>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="jumlah">Jumlah</label>
                                                        <input type="number" name="jumlah" id="jumlah"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="keterangan">Keterangan</label>
                                                        <textarea name="keterangan" id="keterangan" class="form-control" cols="4"></textarea>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <input type="file" name="bukti_transfer"
                                                            class="custom-file-input" id="inputPreview"
                                                            onchange="previewFile(this);" required>
                                                        <label class="custom-file-label" for="inputPreview">Pilih
                                                            Bukti Transfer</label>
                                                        <img id="imagePreview" src="#"
                                                            alt="Preview Foto Profil" class="img-fluid"
                                                            style="display:none;" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-save"></i> Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')

<script>
    function previewFile(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
            input.nextElementSibling.textContent = file.name;
        }
    }
</script>
