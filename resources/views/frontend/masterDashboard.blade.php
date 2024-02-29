<!DOCTYPE html>
<html dir="ltr" lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('frontend/assets/images/favicon.png') }}">
    <title>@yield('title') - Weblink Portal</title>
    <!-- Custom CSS -->
    <link href="{{ URL::asset('frontend/assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('frontend/assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('frontend/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ URL::asset('frontend/dist/css/style.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('frontend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('frontend/assets/libs/select2/dist/css/select2.min.css') }}">
</head>

<body @if(Auth::user()->dark_theme=='Yes')data-theme="dark"@endif>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <input type="hidden" id="userType" value="{{ Auth::user()->type }}">
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <a href="{{ URL('dashboard') }}" class="logo">
                            <!-- Logo icon -->
                            <b class="logo-icon">
                                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                <!-- Dark Logo icon -->
                                {{-- <img src="{{ URL::asset('frontend/assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" /> --}}
                                <!-- Light Logo icon -->
                                {{-- <img src="{{ URL::asset('frontend/assets/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" /> --}}
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                {{-- <img src="{{ URL::asset('frontend/assets/images/logo-text.png') }}" alt="homepage" class="dark-logo" /> --}}
                                <!-- Light Logo text -->
                                {{-- <img src="{{ URL::asset('frontend/assets/images/logo-light-text.png') }}" class="light-logo" alt="homepage" /> --}}
                                Weblink Portal
                            </span>
                        </a>
                        <a class="sidebartoggler d-none d-md-block" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                            <i class="mdi mdi-toggle-switch mdi-toggle-switch-off font-20"></i>
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <!-- <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        {{-- <li class="nav-item search-box">
                            <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-magnify font-20 mr-1"></i>
                                    <div class="ml-1 d-none d-sm-block">
                                        <span>Search</span>
                                    </div>
                                </div>
                            </a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter">
                                <a class="srh-btn">
                                    <i class="ti-close"></i>
                                </a>
                            </form>
                        </li> --}}
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        {{-- <li class="nav-item dropdown border-right">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-bell-outline font-22"></i>
                                <span class="badge badge-pill badge-info noti pending">0</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <ul class="list-style-none">
                                    <li>
                                        <div class="drop-title bg-primary text-white">
                                            <h4 class="m-b-0 m-t-5 pending1">0 New</h4>
                                            <span class="font-light">Notifications</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-center notifications">
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-danger btn-circle">
                                                    <i class="fa fa-link"></i>
                                                </span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">Luanch Admin</h5>
                                                    <span class="mail-desc">Just see the my new admin!</span>
                                                    <span class="time">9:30 AM</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">
                                            <strong>Check all notifications</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ URL::asset('frontend/assets/images/users/default-user.jpg') }}" alt="user" class="rounded-circle" width="40">
                                <span class="m-l-5 font-medium d-none d-sm-inline-block">{{ Auth::user()->name }}<i class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class="">
                                        <img src="{{ URL::asset('frontend/assets/images/users/default-user.jpg') }}" alt="user" class="rounded-circle" width="60">
                                    </div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0">{{ Auth::user()->name }}</h4>
                                        <p class=" m-b-0">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <div class="profile-dis scrollable">
                                    <a class="dropdown-item" href="{{ route('password') }}">
                                        <i class="ti-lock m-r-5 m-l-5"></i> Change Password</a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('frontend/masterMenu')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        
        @yield('content')

        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    
    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ URL::asset('frontend/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ URL::asset('frontend/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <script src="{{ URL::asset('frontend/dist/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/dist/js/app.init.js') }}"></script>
    <script src="{{ URL::asset('frontend/dist/js/app-style-switcher.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ URL::asset('frontend/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ URL::asset('frontend/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ URL::asset('frontend/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ URL::asset('frontend/dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    {{-- <!--chartis chart-->
    <script src="{{ URL::asset('frontend/assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!--c3 charts -->
    <script src="{{ URL::asset('frontend/assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ URL::asset('frontend/dist/js/pages/dashboards/dashboard1.js') }}"></script>
     --}}

    <!--chartis chart-->
    <script src="{{ URL::asset('frontend/assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!--c3 charts -->
    <script src="{{ URL::asset('frontend/assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/dist/js/pages/dashboards/dashboard3.js') }}"></script>


    <!--This page plugins -->
    <script src="{{ URL::asset('frontend/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    
    <script src="{{ URL::asset('frontend/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>

    <script src="{{ URL::asset('frontend/assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/dist/js/pages/forms/select2/select2.init.js') }}"></script>

    <!--Datatable date format change -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script> 
    <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.24/dataRender/datetime.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">    
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>

    // Datatable Load
    $(document).ready(function(){
      pageWiseDataLoad();
    });

    // Calendar
    $(function() {
        $("#from").datepicker({ 
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });
        
        $("#to").datepicker({ 
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        $("#toDate").datepicker({ 
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        $("#fromDate").datepicker({ 
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });
    });

    // Theme Change
    function themeChange()
    {
        $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        });

        var theme = document.getElementById("theme-view").checked;
        var val = 0 ;
        if(theme == true)
        {
            val = 1;  
        }

        $.ajax({
           url:'{{ URL('theme-change') }}',
           method:'get',
           data:{theme:val},
           success:function(response){
             // success
           },
           error:function(error){
           }
        });
    }    
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
 
             $('#newRow1342').click(function(){

                

              // Selecting last id 
              var lastname_id = $('.input-form input[type=text]:nth-child(1)').last().attr('id');
              var split_id = lastname_id.split('_');

              // New index
              var index = Number(split_id[1]) + 1;

              // Create clone
              var newel = $('.input-form:last').clone(true);

              // Set id of new element   
              $(newel).find('input[type=text]:nth-child(1)').attr("id","date_"+index);
              $(newel).find('input[type=text]:nth-child(1)').attr("id","from_"+index);
              $(newel).find('input[type=text]:nth-child(1)').attr("id","to_"+index);
              $(newel).find('input[type=text]:nth-child(1)').attr("id","by_"+index);
              $(newel).find('input[type=text]:nth-child(1)').attr("id","person_"+index);
              $(newel).find('input[type=text]:nth-child(1)').attr("id","cost_"+index);

              $(newel).find('input[type=text]:nth-child(1)').attr("name","date"+index+"["+index+"]");
              $(newel).find('input[type=text]:nth-child(1)').attr("name","from"+index+"["+index+"]");
              $(newel).find('input[type=text]:nth-child(1)').attr("name","to"+index+"["+index+"]");
              $(newel).find('input[type=text]:nth-child(1)').attr("name","by"+index+"["+index+"]");
              $(newel).find('input[type=text]:nth-child(1)').attr("name","person"+index+"["+index+"]");
              $(newel).find('input[type=text]:nth-child(1)').attr("name","cost"+index+"["+index+"]");

              // Set value
              // $(newel).find('input[type=text]:nth-child(1)').val("from_"+index);
              
              // Insert element
              $(newel).insertAfter(".input-form:last");
             });

            })



        $(document).ready(function() {

            // $("#newRow1342").click(function(){
            //     $('<tr><td><input type="text" id="date_1" name="date[]" class="form-control" autocomplete="off" readonly></td><td><input type="text" id="from_1" name="from[]" class="form-control"></td><td><input type="text" id="to_1" name="to[]" class="form-control"></td><td><input type="text" id="by_1" name="by[]" class="form-control"></td><td><input type="text" id="person_1" name="person[]" class="form-control"></td><td><input type="text" id="cost_1" name="cost[]" class="form-control"></td></tr>').clone().appendTo('#cloneDiv');
            // });

            $("#newAttachment").click(function(){
                $("#MainAttachment").clone().appendTo("#cloneAttachment");
            });

        });

    function newRow()
    {
        //alert("new row working");
        $(document).ready(function(){
            //alert("In");
            var date           = $('#to').val();
            var from           = $('#fromc').val();
            var tofrom         = $('#tofrom').val();
            var by             = $('#by').val();
            var person         = $('#person').val();
            var cost           = $('#cost').val();            

            strCountField = '#prof_count';      
            intFields = $(strCountField).val();
            intFields = Number(intFields);    
            newField = intFields + 1;       
                
            strNewField = '<tr class="prof blueBox" id="prof_' + newField + '">\
                <input type="hidden" id="id' + newField + '" name="id' + newField + '" value="-1" />\
            <td><input type="text" id="date' + newField + '" name="date1[]" value="'+date+'"  class="form-control"/></td>\
            <td><input type="text" id="tofrom' + newField + '" name="from1[]" value="'+from+'"  class="form-control text-right"/></td>\
            <td><input type="text" id="to' + newField + '" name="to1[]" value="'+tofrom+'"  class="form-control text-right"/></td>\
            <td><input type="text" id="by' + newField + '" name="by1[]" value="'+by+'"  class="form-control text-right"/></td>\
             <td><input type="text" id="person' + newField + '" name="person1[]" value="'+person+'"  class="form-control text-right"/></td>\
             <td><input type="text" id="cost' + newField + '" name="cost1[]" value="'+cost+'"  class="form-control text-right"/></td>\
            </tr>\
            <div class="nopass"><!-- clears floats --></div>\
            ';

            $("#prof_" + intFields).after(strNewField);    
            $("#prof_" + newField).slideDown("medium");
            $(strCountField).val(newField);             
            
            $('#to').val('');
            $('#fromc').val('');
            $('#tofrom').val('');
            $('#by').val('');
            $('#person').val('');
            $('#cost').val('');

        });


        function dateGap()
        {
            // Date Gap
            const fromDate = $("#fromDate").val();
            const toDate   = $("#toDate").val();
            alert(fromDate);

            const date1 = new Date(fromDate);
            const date2 = new Date(toDate);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
            console.log(diffTime + " milliseconds");
            console.log(diffDays + " days");
        }
    }

    
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            var numberCount = 1;
            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control" name="con_date[' + numberCount + ']"/></td>';
                cols += '<td><input type="text" class="form-control txt" name="con_from[' + numberCount + ']"/></td>';
                cols += '<td><input type="text" class="form-control txt" name="con_to[' + numberCount + ']"/></td>';
                cols += '<td><input type="text" class="form-control txt" name="con_by[' + numberCount + ']"/></td>';
                cols += '<td><input type="text" class="form-control txt" name="con_person[' + numberCount + ']"/></td>';
                cols += '<td><input type="text" class="form-control txt" name="con_cost[' + numberCount + ']"/></td>';
                cols += '<td class="text-center"><a style="border-radius: 45%;"class="deleteMe btn btn-sm btn-danger text-white" title="Delete"><i class="fa fa-times"></i></a></td>';
                newRow.append(cols);
                $("table.bill-list").append(newRow);
                numberCount++;
            });

            $("table.bill-list").on("click", ".deleteMe", function (event) {
                $(this).closest("tr").remove();       
                numberCount -= 1
            });
        });
    </script>
</body>
</html>