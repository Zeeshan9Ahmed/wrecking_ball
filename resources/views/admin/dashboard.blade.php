@extends('admin.layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('public/admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('public/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/admin/dist/css/adminlte.min.css')}}">
@endsection
@section('content')
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          

            <div class="card">
              <!-- <div class="card-header">
                
              </div>
               -->
              <div class="card-body">

                <!-- Small boxes (Stat box) -->
            <div class="row">

               
                <!-- ./col -->
               

                <!-- ./col -->
               

                <!-- ./col -->
                <div class="col-lg-4 col-4">
                    <!-- small box -->
                    <div class="small-box bg-success" style="background-color: #0a8cfc !important;">
                        <div class="inner">
                            <h3>{{ $exercises_count }} </sup></h3>
                            <p>Total Exercises</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-copy"></i>
                            <!-- <ion-icon name="color-filter-outline"></ion-icon> -->
                        </div>  
                    </div>
                </div>
                
                <div class="col-lg-4 col-4">
                    <!-- small box -->
                    <div class="small-box bg-success" style="background-color: #0a8cfc !important;">
                        <div class="inner">
                            <h3>{{ $total_views_count }} </sup></h3>
                            <p>Total Views Count</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-copy"></i>
                            <!-- <ion-icon name="color-filter-outline"></ion-icon> -->
                        </div>  
                    </div>
                </div>

                
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card --> 
          </div>
          
          <div>
  <canvas id="myChart"></canvas>
</div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      
                            
      <!-- /.container-fluid -->
    </section>
@endsection
@section('script')
<!-- Bootstrap 4 -->
<!-- DataTables  & Plugins -->
<script src="{{asset('public/admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('public/admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('public/admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script >
    /** Income pie chart */
function income_pie_chart(data) {
    var income_pie_chart = $.map(data, function (value, index) {
        return ({ 
            label: value.title + ' ' + value.percentage + "%", 
            name: value.title,
            y: value.forecasted_amount, 
            indexLabel: value.percentage + "%" 
        });
    });

    var chart4 = new CanvasJS.Chart("chartContainer3", {
        backgroundColor: "#eeeefa",
        showInLegend: true,
        //colorSet: "greenShades",
        title: {
            text: "Income Categories",
            fontSize: 22,
            fontColor: "#282828",
            fontWeight: "lighter",
            //verticalAlign: "bottom",
            horizontalAlign: "center",
            padding: 5,
            backgroundColor: "#eeeefa",
        },
        data: [{
            indexLabelPlacement: "inside",
            indexLabelFontColor: "#fff",
            indexLabelTextAlign: "center",
            type: "pie",
            showInLegend: true,
            indexLabelFontSize: 20,
            startAngle: 270,
            yValueFormatString:"$##,###,###.00",
            dataPoints: income_pie_chart
        }]
    });
    chart4.render();
}
</script>
<script>
  const ctx = document.getElementById('myChart');
var labels = @json($exercises_name);
var data = @json($exercises_counts);
// console.log(data)
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Total Views',
        data: data,
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