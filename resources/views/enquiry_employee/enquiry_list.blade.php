@extends('layouts.employee.app')
@section('title', 'Enquiry-List')
@section('content')
<link href="employee/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Enquiry List
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <a href="{{url('add-enquiry')}}" class="panel-title" style="color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Enquiry</a>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Date</th>
                                            <th>Mobile No.</th>
                                            <th>Customer Name</th>
                                            <th>Follow Up date</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php $x = 1; ?>
                                    <tbody>
                                    @foreach($enquiry_list as $row)
                                    <?php
                                    ?>
                                    <tr>
                                        <td>{{$x++}}</td>
                                        <td>{{$row->insert_date}}</td>
                                        <td>{{$row->enq_mobile_no}}</td>
                                        <td>{{$row->enq_name}}</td>
                                        <td>{{$row->enq_followup_date}}</td>
                                        <td>{{$row->loc_name}}</td>
                                        <td>
                                            <a href="{{ url('edit-enquiry?id='.$row->enq_id)}}"><i class="material-icons">mode_edit</i></a>
                                        </td>
                                        <td>
                                            <a href="{{ url('delete-enquiry')}}/{{$row->enq_id}}" style="color:red" class="delete"><i class="material-icons">delete</i></a>
                                        </td>
                                    </tr>
                                    @endforeach


                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!--<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->
<section class="content-header">
    <h1>
        Enquiry List
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Enquiry </a></li>
        <li class="active">Enquiry List</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <a href="{{url('add-enquiry')}}" class="panel-title" style="color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Enquiry</a>
        </div>
        <!-- /.box-header -->
        <?php $x = 1; ?>
        <div class="box-body" style="overflow-x:auto;">
            <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Date</th>
                        <th>Mobile No.</th>
                        <th>Customer Name</th>
                        <th>Follow Up date</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enquiry_list as $row)
                    <?php
                    ?>
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$row->insert_date}}</td>
                        <td>{{$row->enq_mobile_no}}</td>
                        <td>{{$row->enq_name}}</td>
                        <td>{{$row->enq_followup_date}}</td>
                        <td>{{$row->loc_name}}</td>
                        <td>
                            <a href="{{ url('edit-enquiry?id='.$row->enq_id)}}"><span class="fa fa-edit"></span></a></td>
                        <td><a href="{{ url('delete-enquiry')}}/{{$row->enq_id}}" style="color:red" class="delete"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                    @endforeach


                </tbody>

            </table>
        </div>
        <!-- /.box-body -->
    </div>   
</section>

<!-- END PAGE CONTENT WRAPPER -->
 <!-- Jquery Core Js -->
    <script src="employee/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="employee/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="employee/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="employee/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="employee/plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="employee/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="employee/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="employee/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="employee/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="employee/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="employee/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="employee/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="employee/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="employee/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="employee/js/admin.js"></script>
    <script src="employee/js/pages/tables/jquery-datatable.js"></script>

    <!-- Demo Js -->
    <script src="employee/js/demo.js"></script>
@endsection
