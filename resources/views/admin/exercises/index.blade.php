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
        <h1>Template</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Template</li>
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

        @if(session('success'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
          <span class="badge badge-pill badge-success"></span>
          {{session('success')}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        @endif

        @if($errors->any())
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
          <span class="badge badge-pill badge-danger"></span>
          <h4>{{$errors->first()}}</h4>
          <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button> -->
        </div>
        @endif

        <div class="card">
          {{-- 
            <div class="card-header">
            <h3 class="card-title float-right  text-white"><a href="{{ route('admin.exercise.create') }}" class="btn-success btn">Add New</a></h3>
          </div>
            --}}
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th> ID</th>
                  <th>Name</th>

                  <th>View Count</th>
                </tr>
              </thead>
              <tbody>

                @forelse($exercises as $key=> $exercise)

                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$exercise->name}}</td>
                  <td> {{$exercise->view_count}} </td>
                </tr>

                @empty

                @endforelse

              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
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
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

</script>
@endsection