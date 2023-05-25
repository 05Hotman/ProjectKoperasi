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
                                <h2 class="my-3">Hai, {{ Auth::user()->username }}</h2>
                                <p class="card-text h4 font-weight-light">
                                    Selamat datang di halaman dashboard {{ config('app.name') }} SMK BAGIMU NEGERIKU.
                                </p>
                            </div>
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
var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

Highcharts.chart('container', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Grafik Jumlah Pelanggan per Bulan'
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
      text: 'Jumlah Pelanggan'
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
    name: 'New York',
    data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]
  }, {
    name: 'London',
    data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]
  }, {
    name: 'Berlin',
    data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]
  }]
});
</script>
@endsection
