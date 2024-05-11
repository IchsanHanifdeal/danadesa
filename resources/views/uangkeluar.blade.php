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
                            <tr class="text-center">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Dokumentasi</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($uang_keluar->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center badge-secondary">Tidak ada Transaksi Keluar
                                    </td>
                                </tr>
                            @else
                                @foreach ($uang_keluar as $key => $uk)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $uk->tanggal }}</td>
                                        <td>{{ $uk->keterangan }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalBukti-{{ $uk->id_uangkeluar }}"> Lihat Dokumentasi</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalBukti-{{ $uk->id_uangkeluar }}"
                                                tabindex="-1" role="dialog" aria-labelledby="modalPendudukLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalPendudukLabel">Dokumentasi
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('storage/' . $uk->dokumentasi) }}"
                                                                class="img-fluid" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ 'Rp ' . number_format($uk->jumlah, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($role == 'admin')
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#ModalTambah"><i class="fas fa-plus"></i> Tambah Transaksi</button>
                        </div>

                        <div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="ModalTambah"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah {{ $title }} </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('store_uangkeluar') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="date" name="tanggal" id="tanggal"
                                                        class="form-control"
                                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <label for="Keterangan">Keterangan</label>
                                                    <textarea name="keterangan" id="keterangan" rows="4" class="form-control"></textarea>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <input type="file" name="dokumentasi" class="custom-file-input"
                                                        id="inputPreview" onchange="previewFile(this);" required>
                                                    <label class="custom-file-label" for="inputPreview">Pilih
                                                        Dokumentasi</label>
                                                    <img id="imagePreview" src="#" alt="Preview Dokumentasi"
                                                        class="img-fluid" style="display:none;" />
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="number" name="jumlah" id="jumlah"
                                                        class="form-control @error('jumlah') is-invalid @enderror">
                                                    @error('jumlah')
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
                                    </form>
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
\
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
