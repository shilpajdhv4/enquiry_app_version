@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
    </div>
    <div class="col-md-6">
    <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Todays FollowUp</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
              <div class="table-responsive">
                <table class="table no-margin" >
                  <thead>
                  <tr>
                    <th>Sr-No</th>
                    <th>Cust. Name</th>
                    <th>Mob. No</th>
                    <!--<th>Prod.Name</th>-->
                  </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1;foreach($today_en as $en){ ?>
                  <tr>
                      <td>{{$i++}}</td>
                      <td>{{$en->enq_name}}</td>
                      <td>{{$en->enq_mobile_no}}</td>
                  </tr>
                 <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
          </div>
        </div>
</div>
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
