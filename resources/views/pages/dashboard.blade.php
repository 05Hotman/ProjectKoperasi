@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{ asset('BN.png') }}" width="100%" class="p-4" alt="{{ config('app.name') }}" srcset="">
                            </div>
                            <div class="col-10">
                                <h2 class="my-3">Hai, {{ Auth::user()->name }}</h2>
                                <p class="card-text h4 font-weight-light">
                                    Selamat datang di halaman dashboard {{ config('app.name') }} SMK BAGIMU NEGERIKU.
                                </p>
                            </div>
                        </div>
                        @if (Auth::user()->role == 'nasabah')
                            <div class="row">
                                <div class="col-12">
                                    <div class="panel">
                                        <canvas id="depositChart"></canvas>
                                        <p class="highcharts-description">
                                            Grafik untuk tabel deposit
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{$totalCustomers}}</h3>
                                            <p>Total Customers</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><sup style="font-size: 20px">IDR</sup> {{$totalDepositC}}</h3>
                                            <p>Total Deposit Sukarela</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3><sup style="font-size: 20px">IDR</sup> {{$totalLoan}}</h3>
                                            <p>Pinjaman yang belum terlunasi</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person-add"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>65</h3>
                                            <p>Unique Visitors</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-pie-graph"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var depositChartCanvas = document.getElementById("depositChart");

        var depositChart = new Chart(depositChartCanvas, {
            // Konfigurasi grafik deposit
            type: 'bar',
            data: {
                labels: ['Pokok', 'Wajib', 'Sukarela'],
                datasets: [{
                    label: 'Total Deposit',
                    data: [
                        {!! json_encode($totalDepositPokok) !!},
                        {!! json_encode($totalDepositWajib) !!},
                        {!! json_encode($totalDepositSukarela) !!}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
