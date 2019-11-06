@extends('layouts.app')

@section('content')
<?php $color_array=array("bg-aqua","bg-green","bg-yellow","bg-red"); $a = 0; ?>
<section class="content">
    <div class="row">
        
        <?php foreach($location as $loc){ if($a > 3){$a=0;} ?>
        <div class="col-lg-2 col-xs-6">
          <div class="small-box <?php echo $color_array[$a];?>">
            <div class="inner">
              {{$loc->loc_name}}
            </div>
            <a href="{{ url('dashboard_enq_list?id='.$loc->loc_id)}}" class="small-box-footer">Click Here <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
        <?php $a++; } ?>
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
                    <!--<th>E-No</th>-->
                    <th>Cust. Name</th>
                    <th>Mob. No</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $i = 1; foreach($today_en as $en){ ?>
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
</section>
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
