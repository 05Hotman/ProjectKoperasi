@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Kode Transaksi</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Nasabah</label>
                                    <input type="text" class="form-control-plaintext"
                                        value=""
                                        placeholder="Nasabah" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Nominal Pinjaman (Rp)</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Jangka Waktu (Bulan)</label>
                                    <input type="text" class="form-control-plaintext"
                                        value=""
                                        placeholder="Jangka Waktu (Bulan)" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Nominal Angsuran (Rp)</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Nominal Pengembalian (Rp)</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Terbayar (Rp)</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Sisa Hutang/Pinjaman (Rp)</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Barang Jaminan</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="" placeholder="Barang Jaminan"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label>Nilai Jaminan (Rp)</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control-plaintext"
                                        value=""
                                        placeholder="Keterangan" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.content -->
@endsection
