@extends('_master')

@section('bodycontent')

  <div class="row">
    <div class ="col-xs-3">
      <h2> Login Page</h2><br>
      {{Form::open(array('url'=>'/','method'=>'POST'))}}
        <div class="form-group">
          <label for="txtEmailAddress">Email address</label>
          <input type="email" name='txtEmailAddress' class="form-control" id="txtEmailAddress" placeholder="Email Address">
        </div>
        <div class="form-group">
          <label for="txtPassword">Password</label>
          <input type="password" class="form-control" id="txtPassword" placeholder="Password" name='txtPassword'>
        </div>
        <button type="submit" class="btn btn-default" name='btnSubmitLogin'>Submit</button>

      {{Form::close()}}
    <div>
    <div class="col-xs-9"></div>
  </div>

@stop