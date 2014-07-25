@extends('_master')

@section('bodycontent')

  <div class="row">
    <div class ="col-xs-3">
      
      <h2> Login Page</h2><br>
      
      {{Form::open(array('url'=>'/authenticate','method'=>'POST'))}}
        <div class="form-group">
          <label for="login">Email address</label>
          <input type="password" name='login' class="form-control" id="login" placeholder="Login ID">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Password" name='password'>
        </div>
        
        <button type="submit" class="btn btn-default" name='submit'>Submit</button>

      {{Form::close()}}

    <div>

    <div class="col-xs-9"></div>

  </div>

@stop