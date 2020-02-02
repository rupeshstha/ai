@extends('voyager::master')

@section('css')
<style>
    .nugah-alert {
        background: #2c2e3e;
        color: #868aa8!important;
        font-weight: 500;
        border-color: rgba(255,255,255,0.2)!important;
    }
    .nugah-alert input[readonly] {
        border: none;
        background-color: #2c2e3e;
        color: #e74c3c;
    }
    .nugah-alert strong {
        font-weight: 600;
    }
</style>
@stop

@section('content')
<div class="page-content">
    @include('voyager::alerts')
    @include('voyager::dimmers')
    <div class="analytics-container">
        @if ( env('ANALYTICS_VIEW_ID') == null )
            <div class="alert nugah-alert">
                <h4>Analytics View ID Not setup.</h4>
                <p>
                    Please follow these instructions:
                    <ol>
                        <li>
                            Add this email to your google analytics account granting Read Access.
                            <input value="nugah-analytics@nugah-admin.iam.gserviceaccount.com" readonly class="form-control" onclick="this.select();">
                        </li>
                        <li>
                            Get the <strong>VIEW_ID</strong> from the account.
                        </li>
                        <li>
                            Update <strong>.env</strong> file and add <strong>ANALYTICS_VIEW_ID</strong>.
                        </li>
                    </ol>
                </p>
            </div>
        @else
        <div class="nugah-chart">
            <div class="col-md-6">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="panel-heading analytics-panel">
                            <h3>
                                Test <small>( Test )</small>
                            </h3>
                        </div>
                        <span class="chart_loader" id="chart_loader_a">
                            <img src="{{ voyager_asset('images/admin-loader.svg') }}" alt="as">
                        </span>
                        <div>
                            <canvas id="${self_id}"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@stop

@section('javascript')
<script src="{{ voyager_asset('js/chart.js') }}"></script>
<script src="{{ voyager_asset('js/chart_plugin.js') }}"></script>
<script>
    var ctx = document.getElementById("topBrowsers");
    var topBrowsers = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['asd', 'ass', 'iqw'],
            datasets: [{
                data: [5523, 123, 111],
                backgroundColor: [
                    'rgba(52, 152, 219,1.0)',
                    'rgba(231, 76, 60,1.0)',
                    'rgba(230, 126, 34,1.0)',
                ]
            }]
        },
        options: {
            legend: {
                position: 'right'
            },
            plugins: {
                datalabels: {
                    font: {
                        weight: 'bold'
                    },
                    color: '#fff'
                }
            }
        }
    });
</script>
@stop
