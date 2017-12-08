@extends('layouts.master')

@section('content')
<script>
 
</script>
<div class="content">

    
    <!-- Main charts -->
    <div class="row">
        <div class="page-header-content">
            <div class="page-title">
                <h4>Account Security</h4>
            </div>

        </div>

		<!-- Page content -->
		<div class="page-content col-sm-12">
            <div class="panel panel-flat">

                <div class="panel-body">
                    <form class="form-horizontal" action="/updateprofile">
                        <fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" placeholder="Email Address" value = "{{$user->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Phone Number</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" placeholder="Phone Number" value = "{{$user->phone}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2">New Password</label>
                                <div class="col-lg-10">
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">Confirm Password</label>
                                <div class="col-lg-10">
                                    <input type="password" class="form-control" placeholder="Confirm Password">
                                </div>
                            </div>

                        </fieldset>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
		</div>
		<!-- /page content -->
    </div>

    <div class="row">
        <div class="page-header-content">
            <div class="page-title">
                <h4>Wallet</h4>
            </div>
        </div>

		<!-- Page content -->
		<div class="page-content col-sm-12">
            <!-- Form horizontal -->
            <div class="panel panel-flat">
                <div class="panel-body">
                    <form class="form-horizontal" action="#">
                        <fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Card</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX">
                                </div>
                            </div>
                        </fieldset>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Add Another Card <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form horizontal -->

		</div>
		<!-- /page content -->
    </div>


    <!-- Footer -->
    <div class="footer text-muted">
        &copy; 2015. <a href="#">Postpaidbills</a> by <a href="" target="_blank">Desmond Lee</a>
    </div>
    <!-- /footer -->

</div>    
     
@stop