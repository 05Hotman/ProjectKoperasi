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
                            <div class="col-2"></div>
                            <div class="panel col-10">
                                <figure class="highcharts-figure">
                                    <div id="container"></div>
                                    <p class="highcharts-description">
                                      Basic line chart showing trends in a dataset. This chart includes the
                                      <code>series-label</code> module, which adds a label to each line for
                                      enhanced readability.
                                    </p>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    var joinedAtData = {!! json_encode(array_keys($totalCustomers)) !!};
    var totalCustomers = {!! json_encode(array_values($totalCustomers)) !!};
    var totalPinjaman = {!! json_encode(array_values($loansData)) !!};
    console.log(totalPinjaman);
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik'
        },
        subtitle: {
            text: 'Sumber: {{ config('app.name') }}'
        },
        xAxis: {
            categories: months,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Angka'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        series: [{
            name: 'Pelanggan',
            data: totalCustomers
        }, {
            name: 'Pinjaman',
            data: totalPinjaman
        }, {
            name: 'Simpanan',
            data: [3, 4, 5, 2, 6, 2, 3, 3, 4, 5, 2, 2]
        }, {
            name: 'Masalah',
            data: [1, 5, 6, 7, 5, 4, 3, 5, 8, 4, 6, 4],
            color: '#ff0000'
        }]
    });
</script>
@endsection

