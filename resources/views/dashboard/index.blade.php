@extends('layouts.master')

@section('title' , 'Dashboard Page')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Dashboard</li>

@endsection


@section('content')


<div>
   <div>
       <div class="btn-group" role="group" aria-label="Basic example">
           <button type="button" data-group="day"   class="btn btn-primary">Day</button>
           <button type="button" data-group="week"  class="btn btn-warning">Week</button>
           <button type="button" data-group="month" class="btn btn-success">Month</button>
           <button type="button" data-group="year"  class="btn btn-dark">Year</button>

       </div>
   </div>

  <canvas id="myChart" width="600" height="200" ></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>


<script>
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'line',
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function  displayChart(group='month')
    {
        fetch("{{route('charts.orders')}}?group="+group)
            .then(response => response.json())
            .then(json=>{
                myChart.data.labels=json.labels;
                myChart.data.datasets=json.datasets;
                myChart.update();
            });


    }

    $('.btn-group .btn').on('click', function(e) {
        e.preventDefault();
        displayChart($(this).data('group'));
    });

    displayChart();


</script>

@push('scripts')

<script src="https://cdnjs.com/libraries/Chart.js"><script/>

@endpush


@endsection
