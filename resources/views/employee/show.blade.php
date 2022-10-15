@extends('layouts.app')
  
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Employee</h2>
            </div>
            <div class="pull-right">
            <a class="btn btn-primary" href="{{  URL::to('/home') }}"> Back</a>
            </div>
        </div>
    </div>
   <br>
   <br>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Emp_ID:</strong>
                {{ $user->Emp_ID }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $user->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                {{ $user->role }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Department:</strong>
                {{ $user->department }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                {{ (@$user->status == '1' ) ? 'Active' : 'InActive' }}
            </div>
        </div>

    </div>
    
@endsection