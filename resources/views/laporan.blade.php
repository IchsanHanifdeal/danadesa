@include('layouts.header')

<div class="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="card col-lg-10">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table"></i> Laporan Keuangan Desa</h3>
                </div>
                {{-- filter --}}
                <div class="card-body">
                    <div class="box-body">
                        <form method="get" action="{{ route('laporan') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pilih Bulan</label>
                                        <input type="month" class="form-control" name="month" value="{{ $month }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Jenis Sumber</label>
                                        <select class="form-control" name="sumber">
                                            <option value="">Semua</option>
                                            <option value="penduduk" {{ $filter_sumber == 'penduduk' ? 'selected' : '' }}>Penduduk</option>
                                            <option value="pemerintah" {{ $filter_sumber == 'pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="form-group w-100">
                                        <input type="submit" value="TAMPILKAN" class="btn btn-sm btn-primary btn-block">
                                    </div>
                                </div>
                            </div>
                        </form>                        
                    </div>
                    {{-- Header --}}
                    <div class="row" style="display: none;">
                        <div class="col-lg-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">DARI TANGGAL</th>
                                    <th width="1%">:</th>
                                    <td id="display_start_date"></td>
                                </tr>
                                <tr>
                                    <th>SAMPAI TANGGAL</th>
                                    <th>:</th>
                                    <td id="display_end_date"></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Tabel --}}
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Pemasukan</th>
                                <th>Pengeluaran</th>
                                <th>Dokumentasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['tanggal'] }}</td>
                                    <td>{{ $item['kategori'] }}</td>
                                    <td>{{ $item['keterangan'] }}</td>
                                    <td class="text-right">
                                        {{ $item['pemasukan'] ? number_format($item['pemasukan']) : '-' }}</td>
                                    <td class="text-right">
                                        {{ $item['pengeluaran'] ? number_format($item['pengeluaran']) : '-' }}</td>
                                    <td>
                                        @if ($item['dokumentasi'])
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modalBukti-{{ $index }}">
                                                Lihat Dokumentasi
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalBukti-{{ $index }}" tabindex="-1"
                                                role="dialog" aria-labelledby="modalPendudukLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalPendudukLabel">Dokumentasi
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('storage/' . $item['dokumentasi']) }}"
                                                                class="img-fluid" alt="Dokumentasi" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="7">
                                        {{ $isFiltered ? 'Tidak ada transaksi di tanggal ini' : 'Silahkan filter terlebih dahulu' }}
                                    </td>
                                </tr>
                            @endforelse

                            @if (count($data) > 0)
                                <tr class="text-center font-weight-bold">
                                    <td colspan="4">Total</td>
                                    <td class="text-right">{{ number_format($total_pemasukan) }}</td>
                                    <td class="text-right">{{ number_format($total_pengeluaran) }}</td>
                                    <td></td>
                                </tr>
                                <tr class="text-center font-weight-bold">
                                    <td colspan="4">Saldo</td>
                                    <td colspan="2" class="text-right">{{ number_format($saldo) }}</td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

<script>
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;

        document.getElementById('display_start_date').innerText = startDate;
        document.getElementById('display_end_date').innerText = endDate;

        document.querySelector('.result-table').style.display = 'block';
    });
</script>
