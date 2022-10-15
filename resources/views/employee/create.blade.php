
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="">
            <h2>Add New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{  URL::to('/home') }}"> Back</a>
        </div>
    </div>
</div>
<div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
</div>
   
    @if (Session::has('message'))
        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if(count($errors) > 0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-danger display-hide" id="successMessage" >
                <button id="successMessage" class="close" data-close="alert"></button>
                <span>{{ $message }}</span>
            </div>
        @endforeach
    @endif

<form action="{{  URL::to('employee/store') }}" method="POST" enctype="multipart/form-data" id="employee">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Full name">            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                <select class="form-control" id="role" name="role">
                    <!-- <option>Choose Role</option> -->
                    <option value="Agent" >Agent</option>
                    <option value="Supervisor" >Supervisor</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Department:</strong>
                <select class="form-control" id="department" name="department">
                    <!-- <option selected  value="0">Choose Role</option> -->
                    <option value="HR" >HR</option>
                    <option value="Software" >Software</option>
                    <option value="IT" >IT</option>
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password:</strong>

                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password">
                    </div>
                </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
   $(document).ready(function(){
       // $('#message').fadeOut(120);
       setTimeout(function() {
           $('#successMessage').fadeOut('fast');
       }, 3000);
   })
</script>