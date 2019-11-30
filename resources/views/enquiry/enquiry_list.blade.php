@extends('layouts.app')
@section('title', 'Enquiry-List')
@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
     th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
 
    div.container {
        width: 80%;
    }
</style>
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
                        <?php if(Auth::guard('admin')->check()){ ?>
                        <th>Employee Name</th>
                        <?php } ?>
                        <th>Location</th>
                        <th>Action</th>
                        <th>Order Status</th>
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
                        <?php if(Auth::guard('admin')->check()){ 
                            if($row->name == ""){ ?>
                              <td id="{{$row->enq_id}}">
                                    <a href="{{$row->enq_id}}" type="button" class="assign_model" data-toggle="modal" data-target="#modal-default">
                                        {{Auth::guard('admin')->user()->reg_personname}}
                                    </a>
                                </td>  
                          <?php  }else{
                            ?>
                        <td id="{{$row->enq_id}}">
                            <a href="{{$row->enq_id}}" type="button" class="assign_model" data-toggle="modal" data-target="#modal-default">
                                {{$row->name}}
                            </a>
                        </td>
                        <?php } }?>
                        <td>{{$row->loc_name}}</td>
                        <td>
                            <a href="{{  url('edit-enquiry?id='.$row->enq_id)}}"><span class="fa fa-edit"></span></a>
                            <a href="{{ url('delete-enquiry')}}/{{$row->enq_id}}" style="color:red" class="delete"><span class="fa fa-trash"></span></a>
                        </td>
                        <?php if($row->order_status == 0) { ?>
                        <td>Close</td>
                        <?php } else { ?>
                        <td>{{$row->or_status_name}}</td>
                        <?php } ?>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>   
</section>
<?php if(Auth::guard('admin')->check()){ 
    $cid = Auth::guard('admin')->user()->rid; 
    $employee = App\Employee::select('id','name')->where(['is_active'=>0,'cid'=>$cid])->get();    
?>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
          <form class="form-horizontal" method="POST" action="{{ url('update_assign_to') }}">
              {{ csrf_field() }}
          <!--<form action="{{url('update_assign_to')}}" method="POST" >-->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Assign To Employee</h4>
        </div>
        <div class="modal-body">
            <input type="hidden" name="enq_id" id="enq_id" value="" />
          <div class="form-group">
                <label for="userName" class="col-sm-4 control-label">Assign To Employee</label>
                <div class="col-sm-8">
                    <select class="form-control select2" style="width: 100%;" name="enq_user_id" id="enq_user_id">
                        <option value="">-- Select Location --</option>
                        @foreach($employee as $loc)
                        <option value="{{$loc->id}}">{{$loc->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
          </form>
      </div>
    </div>
</div>
<?php } ?>
        <!-- /.modal -->
<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    $(".assign_model").on("click",function(){
        $('.select2').select2();
        var id = $(this).attr('href');
        $("#enq_id").val(id);
    })
    
    $(".delete").on("click", function () {
        swal({
        title: "Please Conform?",
        text: "Day Or Consumption Detail is Not Enterd for Selected Date.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e74c3c",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                $('#cop_form').submit();
            }
            else {
                swal("Cancelled", "", "error");
            }
    });
        //return confirm('Are you sure to delete user');
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
