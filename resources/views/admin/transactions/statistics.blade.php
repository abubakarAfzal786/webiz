@extends('layouts.app')

@section('content')
    <div class="col-md-8 offset-2">
        <div class="card mb-5">
            <div class="card-header">
                {{ __('Statistics') }}
                <a href="{{ route('admin.transactions.index') }}"
                   class="btn text-white btn-info btn-sm float-right">Transactions</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('admin.statistics.index') }}">
                            <div class="form-group row">
                                <label for="month" class="col-sm-2 col-form-label">Month</label>
                                <div class="col-sm-6">
                                    <input type="month" id="month" class="form-control" name="month"
                                           value="{{ request()->get('month') ?? date('Y-m') }}">
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-success">Apply</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h4>Credits that have been used for
                            {{ \Carbon\Carbon::createFromFormat('Y-m', request()->get('month') ?? date('Y-m'))->format('F Y') }}
                            <b class="text-success float-right">{{ $used_credits }}</b></h4>

                        <h4>Credits that are yet to be used <b
                                class="text-success float-right">{{ $current_credits }}</b></h4>
                        <h4>Overall credits for whole time <b
                                class="text-success float-right">{{ $overall_credits }}</b></h4>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [{!! $labels !!}],
                datasets: [
                    {
                        data: [{{ $data }}],
                        backgroundColor: "blue",
                        borderColor: "lightblue",
                        fill: false,
                        lineTension: 0,
                        radius: 5
                    },
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Amount of bought credits',
                        fontSize: 25,
                    }
                }
            }
        });
    </script>
@endpush
