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
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.content -->
@endsection

@section('footer')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
var totalCustomers = @json($totalCustomers);
var totalDepositPokok = @json($totalDepositPokok);
var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

Highcharts.chart('container', {
    title: {
        text: 'U.S Solar Employment Growth by Job Category, 2010-2020',
        align: 'left'
    },
    subtitle: {
        text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>',
        align: 'left'
    },
    yAxis: {
        title: {
            text: 'Number of Employees'
        }
    },
    xAxis: {
        categories: months,
        accessibility: {
            rangeDescription: 'Range: January to December',
            enabled: true
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 0 // Mulai dari indeks 0 (January)
        }
    },
    series: [{
        name: 'Customers',
        data: Object.keys(totalCustomers).map(key => totalCustomers[key])
    }, {
        name: 'Simpanan',
        data: Object.keys(totalDepositPokok).map(key => totalDepositPokok[key]).concat(@json($simpananManual))
    }, {
        name: 'Sales & Distribution',
        data: [1, 43, 2, 5, 10, 7, 3, 6, 9, 4, 8, 12]
    }, {
        name: 'Operations & Maintenance',
        data: [11, 8, 5, 3, 6, 9, 2, 7, 4, 12, 10, 15]
    }, {
        name: 'Other',
        data: [2, 1, 2, 4, 6, 3, 5, 8, 9, 7, 10, 12]
    }],
    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }
});

</script>

@endsection













<!-- /.backup -->







{{-- <div class="panel col-5">
    <figure class="highcharts-figure">
        <div id="container"></div>
        <p class="highcharts-description">
            Chart showing use of multiple y-axes, where each series has a separate
            axis. Multiple axes allows data in different ranges to be visualized
            together. While this in some cases can cause charts to be hard to read,
            it can also be a powerful tool to illustrate correlations.
        </p>
        </figure>
</div> --}}








{{-- <div class="panel col-8">
    <figure class="highcharts-figure">
        <div id="grafik1"></div>
    </figure>
</div> --}}


    {{-- <script>
const chart = new Highcharts.Chart({
    chart: {
        renderTo: 'grafik1',
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 15,
            beta: 15,
            depth: 50,
            viewDistance: 25
        }
    },
    xAxis: {
        categories: {!! json_encode($user) !!}
    },
    yAxis: {
        title: {
            enabled: false
        }
    },
    tooltip: {
        headerFormat: '<b>{point.key}</b><br>',
        pointFormat: 'Simpanan: {point.y}'
    },
    title: {
        text: 'Sold passenger cars in Norway by brand, January 2021',
        align: 'left'
    },
    subtitle: {
        text: 'Source: ' +
            '<a href="https://ofv.no/registreringsstatistikk"' +
            'target="_blank">OFV</a>',
        align: 'left'
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        column: {
            depth: 25
        }
    },
    series: [{
        data: [1318, 1073],
        colorByPoint: true
    }]
});

function showValues() {
    document.getElementById('alpha-value').innerHTML = chart.options.chart.options3d.alpha;
    document.getElementById('beta-value').innerHTML = chart.options.chart.options3d.beta;
    document.getElementById('depth-value').innerHTML = chart.options.chart.options3d.depth;
}

// Activate the sliders
document.querySelectorAll('#sliders input').forEach(input => input.addEventListener('input', e => {
    chart.options.chart.options3d[e.target.id] = parseFloat(e.target.value);
    showValues();
    chart.redraw(false);
}));

showValues();


Highcharts.chart('container', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Production, consumption and trade surplus of electrical power',
        align: 'left'
    },
    subtitle: {
        text: 'Source: <a ' +
            'href="https://www.ssb.no/energi-og-industri/energi/statistikk/elektrisitet/artikler/lavere-kraftproduksjon"' +
            ' target="_blank">SSB</a>',
        align: 'left'
    },
    xAxis: {
        categories: ['Q1 2019', 'Q2 2019']
    },
    yAxis: {
        title: {
            text: 'TWh'
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Total production',
        data: [37.8, 29.3
        ]
    }, {
        name: 'Gross consumption',
        data: [39.9, 29.9
        ]
    }, {
        name: 'Trade surplus',
        data: [-2.2, -0.6]
    }]
});

    </script> --}}

