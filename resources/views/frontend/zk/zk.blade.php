@extends('frontend.masterDashboard')

@section('title', 'Manual Upload')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Import Attendance Data (Manually)</h4>
            </div>
        </div>
    </div>

	<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        {{-- <h6 class="card-subtitle"> Download Attendance Time from Device. </h6> --}}

						<div class="messaage" id="msg">
							<div class="alert alert-info" role="alert">
								Welcome ! <br>
								Click Below Button to Start Upload Attendance Data.
							</div>
						</div>
						<div class="messaage">
							<button id="import_data" class="btn btn-info p-20" type="button">
								<i class="ace-icon fa fa-check bigger-110"></i> Import Attendance Data
							</button>
						</div>
						<img src="{{ URL::asset('frontend/assets/images/processing.gif') }}" id="processing" style="display:none">
                    </div>
                </div>
            </div>
        </div>    
    </div>	
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    @include('/frontend/masterFooter')
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>	

<script src="{{ URL::asset('frontend/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script>
	$(document).ready(function(){
		var CSRF_TOKEN 		= $('meta[name="csrf-token"]').attr('content');
		var post_url 		= '{{ url("/post-att") }}';
		var redirect_url 	= '{{ url("/employeewise-attendance/2") }}';
		var msg         	= $('.alert-info');
		var btn         	= $('#import_data');
		$('.btn-info').each(function() {
			$(this).click(function () {
				var id = this.id;
				$("#processing").show('slow');
				$.ajax({
					url: post_url,
					type: 'POST',
					/* send the csrf-token and the input to the controller */
					data: {_token: CSRF_TOKEN, id: id},
					dataType: 'JSON',
					/* remind that 'data' is the response of the AjaxController */
					beforeSend: function() {
						$(btn).hide();
						$(msg).html('Please Wait....... Processing').css("display", "block").delay(3000).fadeOut("slow");
					},
					success: function (data) {
						//console.log(data);
						$("#processing").show('hide');
						$(btn).show();
						$(msg).html(data.msg).css("display", "block").delay(3000).fadeOut("slow");
						window.location.href = redirect_url;
					}
				});
			});
		});
	});
</script>

@endsection
