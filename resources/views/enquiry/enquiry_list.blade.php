@extends('layouts.app')
@section('title', 'Enquiry-List')
@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
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
                            <a href="{{  url('edit-enquiry?id='.$row->enq_id)}}"><span class="fa fa-edit"></span></a>
                            <a href="{{ url('delete-enquiry')}}/{{$row->enq_id}" style="color:red" class="delete"><span class="fa fa-trash"></span></a>
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
        return confirm('Are you sure to delete user');
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
