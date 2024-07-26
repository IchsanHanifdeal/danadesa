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
                                        <label>Mulai Tanggal</label>
                                        <input type="date" class="form-control" name="start_date"
                                            value="{{ $start_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Sampai Tanggal</label>
                                        <input type="date" class="form-control" name="end_date"
                                            value="{{ $end_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="form-group w-100">
                                        <input type="submit" value="TAMPILKAN"
                                            class="btn btn-sm btn-primary btn-block">
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
                                <th rowspan="2">No</th>
                                <th rowspan="2">Tanggal</th>
                                <th rowspan="2">Kategori</th>
                                <th rowspan="2">Keterangan</th>
                                <th colspan="2">Jenis</th>
                            </tr>
                            <tr>
                                <th class="text-center">Pemasukan</th>
                                <th class="text-center">Pengeluaran</th>
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
                                        {{ $item['pemasukan'] ? number_format($item['pemasukan']) : '-' }}
                                    </td>
                                    <td class="text-right">
                                        {{ $item['pengeluaran'] ? number_format($item['pengeluaran']) : '-' }}
                                    </td>
                                </tr>
                            @empty
                                @if ($isFiltered)
                                    <tr class="text-center">
                                        <td colspan="6">Tidak ada transaksi di tanggal ini</td>
                                    </tr>
                                @else
                                    <tr class="text-center">
                                        <td colspan="6">Silahkan filter terlebih dahulu</td>
                                    </tr>
                                @endif
                            @endforelse

                            @if (count($data) > 0)
                                <tr class="text-center font-weight-bold">
                                    <td colspan="4">Total</td>
                                    <td class="text-right">{{ number_format($total_pemasukan) }}</td>
                                    <td class="text-right">{{ number_format($total_pengeluaran) }}</td>
                                </tr>
                                <tr class="text-center font-weight-bold">
                                    <td colspan="4">Saldo</td>
                                    <td colspan="2" class="text-right">{{ number_format($saldo) }}</td>
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
