@extends('layouts.master')

@section('content')
    <div class="content" id = "register-area">

        <!-- Simple login form -->
        <form action="{{ url('register')}}" method="post">
            {{ csrf_field() }}
            <div class="panel panel-body login-form">
                <div class="text-center">
                    <h5 class="content-group">Signup with Email</h5>
                </div>

                <div class="form-group has-feedback has-feedback-left">
                    <input type="text" class="form-control" placeholder="Enter Email" name="email" required>
                    <div class="form-control-feedback">
                        <i class="icon-user text-muted"></i>
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-left">
                    <input type="number" class="form-control" placeholder="Mobile phone number" name="phone" required>
                    <div class="form-control-feedback">
                        <i class="icon-phone"></i>
                    </div>
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Submit <i class="icon-circle-right2 position-right"></i></button>
                </div>

            </div>
        </form>
        <!-- /simple login form -->

    </div>
@stop