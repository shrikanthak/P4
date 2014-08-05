@extends('_master')

@section('bodycontent')

  <div class="row">
    <div class ="col-xs-3">
      
      <h2> Login Page</h2><br>
      
      {{Form::open(array('url'=>'/resetpassword','method'=>'POST','id'=>'password_reset'))}}
        <div class="form-group">
          <label for="oldpassword">Login ID</label>
          <input type="password" name='oldpassword' class="form-control" id="oldpassword" placeholder="Old Password">
        </div>
        
        <div class="form-group">
          <label for="newpassword">Password</label>
          <input type="password" class="form-control" id="newpassword" placeholder="New Password" name='newpassword'>
        </div>

        <div class="form-group">
          <label for="confirmnewpassword">Password</label>
          <input type="password" class="form-control" id="confirmnewpassword" placeholder="Confirm New Password" name='confirmnewpassword'>
        </div>
        
        <button type="submit" class="btn btn-default" name='submit'>Submit</button>

      {{Form::close()}}

    <div>

    <div class="col-xs-9"></div>

  </div>

@stop