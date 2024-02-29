@extends('frontend.masterDashboard')
@section('title', 'Add Conveyance Bill')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Add Conveyance Bill</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('conveyances') }}">Conveyance Bill</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Conveyance Bill</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ URl('conveyances-submit') }}" method="Post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Name of the project <span class="error">*</span></label>
                                        <input type="text" name="name_of_the_projects" id="name_of_the_projects" class="form-control" placeholder="Name of the project" required>
                                        <small class="form-control-feedback"></small> </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Name of the assigned person</label>
                                            <input type="text" name="assigned_person" id="assigned_person" class="form-control form-control-danger" placeholder="Name of the assigned person" value="{{ Auth::user()->name }}" readonly>
                                            <small class="form-control-feedback"></small> 
                                            <input type="hidden" name="assigned_person_id" value="{{ Auth::user()->id }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Helping hand of the engineer</label>
                                            <input type="text" name="helping_hand_person" id="helping_hand_person" class="form-control form-control-danger" placeholder="Helping hand of the engineer">
                                        </div>                                       
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Designation</label>
                                            <input type="text" name="designation" id="designation" class="form-control form-control-danger" placeholder="Designation">
                                        </div>                                       
                                    </div>

                                </div>
                            </div>

                            <div class="row" style="padding:30px 30px;">
                                <div class="table-responsive">
                                <table id="zero_config1" class="table table-striped table-bordered bill-list">
                                    <thead>                                   
                                        <tr>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>By</th>
                                            <th>Person</th>
                                            <th>Cost</th>
                                            <td>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="con_date[]" class="form-control" autocomplete="off" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="con_from[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="con_to[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="con_by[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="con_person[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="con_cost[]" class="form-control">
                                            </td>
                                            <td>
                                                <a href="javascript:void()" id="addrow"  class="text-right">
                                                    <button type="button" class="btn btn-success">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i> New
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>                            
                                </table>
                                

                                <div class="row p-t-20">
                                    <div class="col-md-8" id="MainAttachment">
                                        <div class="form-group">
                                            <label class="control-label">Bill Attachment (if any)</label>
                                            <input type="file" name="attachment[]" id="attachment" class="form-control">
                                            <small class="form-control-feedback"></small> 
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">&nbsp;</label>
                                            <a href="javascript:void()" id="newAttachment" class="text-right">
                                                <button type="button" class="form-control btn btn-success">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> New Attachment
                                                </button>
                                            </a>
                                            <small class="form-control-feedback"></small> 
                                        </div>
                                    </div>

                                    <div  class="col-md-12" id="cloneAttachment"></div>
                                </div>
                            </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Bill Submit</button>
                                    <button type="button" onclick="history.back()" class="btn btn-dark">Cancel</button>
                                </div>
                            </div>
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


@endsection