@extends('layouts.app')
@section('title', 'Home')
@section('content')
<?php $date = date('Y-m-d'); $id = Auth::guard('admin')->user()->rid; $color_array=array("bg-aqua","bg-green","bg-yellow","bg-red"); $a = 0; ?>
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
    @foreach($template as $temp)
    <div class="col-md-12">
    <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Todays FollowUp For {{$temp->temp_name}}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
        <?php $imp_temp = json_decode($temp->dashboard_field,true); 
//        echo "<pre>"; print_r($imp_temp);//exit;
        ?>
            <!-- /.box-header -->
            <div class="box-body" style="">
              <div class="table-responsive">
                <table class="table no-margin" >
                  <thead>
                  <tr>
                    <th>Sr.No</th>
                    <th>Cust. Name</th>
                    <th>Mob. No</th>
                    <?php if(!empty($imp_temp)){ 
                        foreach($imp_temp as $key=>$val) { ?>
                            <th>{{$key}}</th>
                    <?php } } ?>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $i = 1; 
                  $today_en = DB::table('enq_enquiries')
                            ->select('enquiry_no','enq_name','enq_mobile_no','enq_id','enq_fields')
                            ->where('enq_followup_date','=',$date)
                            ->where('enq_user_id','=',$id)
                            ->where('order_status','!=',0)
                            ->where('is_active','=',0)
                            ->where('enq_template_id','=',$temp->enq_temp_id)
                            ->get();
                  foreach($today_en as $en){ 
                  $enq_field = json_decode($en->enq_fields,true);    
//                  echo "<pre>";print_r($enq_field);print_r($imp_temp);//exit;
                  ?>
                  <tr>
                      <td>{{$i++}}</td>
                      <td>{{$en->enq_name}}</td>
                      <td>{{$en->enq_mobile_no}}</td>
                      <?php if(!empty($imp_temp)){ 
                          if(!empty($enq_field)){
                              foreach($enq_field as $key=>$val) {
                                  if(array_key_exists($key,$imp_temp)){
//                                      print_r($val);//exit;
                                      if(is_array($val)){
                                          foreach($val as $v){ ?>
                                             <td>{{$v[0]}}</td>
                                       <?php   }
                                      }
                                      else{
                                  ?>
                                <td>{{$val}}</td>
                                      <?php } ?>
                                  <?php } }} } ?>
                      <td><a href="{{  url('edit-enquiry?id='.$en->enq_id)}}"><span class="fa fa-edit"></span></a></td>
                  </tr>
                 <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
          </div>
        </div>
    @endforeach
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
