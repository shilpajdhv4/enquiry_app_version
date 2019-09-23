@extends('layouts.app')
@section('title', 'Enquiry-List')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    @if (Session::has('alert-success'))
    <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Success!</h4>
        {{ Session::get('alert-success') }}
    </div>
    @endif  
    <section class="content-header">
      <h1>
        Enquiry-List
      </h1>
    
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Enquiry List</li>
      </ol>
    </section>
  
  <section class="content">
   <div class="box">
            <div class="box-header">
              <h3 class="box-title">ENQUIRY LIST</h3><a href="{{url('home')}}" class="panel-title" style="margin-left: 75%;color: #dc3d59;">BACK</a>
            </div>
            <!-- /.box-header -->
             <?php $x = 1; ?>
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Customer Name</th>
                  <th>Email ID</th>
                  <th>Status Name</th>
                  <th>Source</th>
                  <th>Follow Up Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($status_data as $t)
                    <tr>
                            <td>{{$x++}}</td>
                            <td>{{$t->customer_name}}</td>
                            <td>{{$t->email}}</td>
                            <td>{{$status_nm->status_name}}</td>
                            <td>{{$t->source}}</td>
                            <td><a href="{{ url('edit-enquiry?id='.$t->enquiry_id)}}">{{$t->followup_date}}</a></td>
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
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
    $(".delete").on("click",function(){
        return confirm('Are you sure to delete');
    });
    
});
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@endsection
