@extends('frontend.masterDashboard')
@section('title', 'Salary Processing')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Salary Processing</h4>                
            </div>

            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Salary Processing</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="m-t-30" action="{{ URl('salary-sheet-pdf') }}" method="post" target="_blank">
                            @csrf
                            <div class="form-body">
                                <div class="card-body p-0">
                                    <div class="row">
                                       <div class="col-md-2"></div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Current Month with Year <span class="error">*</span></label>
                                                <select class="form-control" name="month" id="month">
                                                    @php 
                                                    $i = 1;
                                                    $date = date('Y-01-01');
                                                    $month = strtotime($date);
                                                    while($i <= 12)
                                                    {
                                                        $month_name = date('F', $month);
                                                        echo '<option value="'. date('Y-m-01', $month). '">'.$month_name.' '.date('Y').'</option>';
                                                        $month = strtotime('+1 month', $month);
                                                        $i++;
                                                    }
                                                    @endphp     
                                                </select> 
                                            </div>   
                                        </div>
                                       
                                        <div class="col-md-2" id="processButton">
                                            <div class="form-group">
                                                <label class="control-label">&nbsp;</label>
                                                <button type="button" class="form-control btn btn-success" onclick="salaryProcessing()"><i class="fa fa-undo" aria-hidden="true"></i> Salary Process </button>                                                 
                                            </div>
                                        </div>                                   
                                    </div>

                                    <div class="row" id="pdf" style="display:none">
                                       <div class="col-md-2"></div>
                                       <div class="col-md-6">
                                            <div class="form-group">                        
                                                <button class="form-control btn btn-success">
                                                    <i class="fa fa-download" aria-hidden="true"></i> Salary Sheet Download (PDF)
                                                </button>            
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-danger" onclick="salarySheetDelete()">
                                                    <i class="fa fa-trash" aria-hidden="true"></i> Salary Sheet Delete
                                                </button>
                                            </div>
                                        </div>                                 
                                    </div>
                                    <div class="row" id="processing" style="display:none">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-2">      
                                            <img src="{{ URL::asset('frontend/assets/images/Fountain.gif') }}">
                                            Salary Processing...
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <div class="alert alert-success alert-dismissible" id="successMsg" style="display:none;">
                                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                              <strong>Success!</strong> Successfully salary generated.
                                            </div>
                                            <div class="alert alert-success alert-dismissible" id="deleteMsg" style="display:none;">
                                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                              <strong>Success!</strong> Successfully salary sheet deleted.
                                            </div>
                                            <div class="alert alert-danger alert-dismissible" id="dangerMsg" style="display:none;">
                                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                              <strong>Warning!</strong> Oops ! salary sheet has already been generated.
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>

                            <div id="result"></div>
                        </form>               
                        
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
<script type="text/javascript">
    function salaryProcessing()
    {
        //if (confirm("Are you sure you want to salary process!") == true) {
            
            $.ajaxSetup({
               headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });

            var month = $("#month").val();
            $("#processButton").hide('slow');      
            $("#processing").show('slow');      

            $.ajax({
               url:'{{ URL('salary-processing-submit') }}',
               method:'POST',
               data:{month:month},
               success:function(response){                
                if(response==1)
                {
                    $("#dangerMsg").show('slow');
                    $("#processButton").show('slow');
                    $("#pdf").show('slow');
                    $("#processing").hide('slow');
                    $("#deleteMsg").hide('slow');                 
                }
                else
                {
                    $("#result").html(response);
                    // success
                    $("#processing").hide('slow');
                    $("#pdf").show('slow');
                    $("#successMsg").show('slow');
                    $("#dangerMsg").hide('slow');
                    $("#deleteMsg").hide('slow');    
                }
               },
               error:function(error){
                 $("#result").html(error);
               }
            });
        // } 
        // else {          

        // }        
    }

    function salarySheetDelete()
    {
        if (confirm("Are you sure you want to delete!") == true) {
            
            $.ajaxSetup({
               headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });

            var month = $("#month").val();
            $("#processButton").hide('slow');      
            $("#processing").show('slow');      

            $.ajax({
               url:'{{ URL('salary-processing-delete') }}',
               method:'POST',
               data:{month:month},
               success:function(response){
                    
                    $("#processButton").show('slow');
                    $("#deleteMsg").show('slow');
                    $("#successMsg").hide('slow');
                    $("#dangerMsg").hide('slow');

                    $("#pdf").hide('slow');
                    $("#processing").hide('slow');
               },
               error:function(error){
                 $("#result").html(error);
               }
            });
        }       
    }    
</script>

@endsection