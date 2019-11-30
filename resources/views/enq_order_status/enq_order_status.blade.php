@extends('layouts.app')
@section('title', 'Location-List')
@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Order Status List
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Enquiry </a></li>
        <li class="active">Order Status List</li>
    </ol>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content">
    <div class="box">
        <div class="box-header">
            <a href="{{url('enq_order_status_add')}}" class="panel-title" style="color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Order Status</a>
        </div>
        <!-- /.box-header -->
        <?php $x = 1; ?>
        <div class="box-body" >
            <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Order Status Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order_status as $row)
                    <?php
                    ?>
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$row->or_status_name}}</td>
                        <td>
                            <a href="{{ url('enq-order-status-edit?id='.$row->or_id)}}"><span class="fa fa-edit"></span></a>
                            <a href="{{ url('enq-order_status-delete')}}/{{$row->or_id}}" style="color:red" class="delete"><span class="fa fa-trash"></span></a>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function () {
//    alert();
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete');
    });
});
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})
</script>
@endsection
