@extends('admin.layout.master')
@section('style')

@endsection
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Exercise</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Add Exercise</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <!-- <div class="card-header">
                <h3 class="card-title">Add Cycle</h3>
              </div> -->
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
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{route('admin.exercise.store')}}" method="post" enctype="multipart/form-data">
            <div class="card-body">
              @csrf


              <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" required="" value="{{old('template_name')}}">
                <span class="text-danger">{{$errors->first('template_name')}}</span>
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" placeholder="Enter Description" name="description" required="" value="{{old('template_name')}}">
                <span class="text-danger">{{$errors->first('template_name')}}</span>
              </div>
              <div class="form-group">
                <label for="">Duration</label>
                <input type="number" class="form-control" id="" placeholder="Enter Total Duration" name="duration" required="" value="{{old('template_name')}}">
                <span class="text-danger">{{$errors->first('template_name')}}</span>
              </div>
              <div class="form-group">
                <label for="">No of Days Per Week</label>
                <input type="number" min="1" max="7" class="form-control" id="" placeholder="Enter No of Days" name="no_of_days_per_week" required="" value="{{old('template_name')}}">
                <span class="text-danger">{{$errors->first('template_name')}}</span>
              </div>


              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </form>
        </div>
        <!-- /.card -->


        <!-- /.card -->

      </div>
      <!--/.col (left) -->
      <!-- right column -->

      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>


@endsection
@section('script')


@endsection