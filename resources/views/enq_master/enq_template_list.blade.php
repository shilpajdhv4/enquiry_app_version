@extends('layouts.app')
@section('title', 'Item-List')
@section('content')
<?php 
if(Auth::guard('admin')->check()){
    $setting =array();
    if(isset(Auth::guard('admin')->user()->enq_setting)){
        $setting = json_decode(Auth::guard('admin')->user()->enq_setting,true);
    }
}
else if(Auth::guard('employee')->check()){
    $client = \App\Admin::select('enq_setting')->where(['rid'=>$id])->first();
    $setting =array();
    if(isset(Auth::guard('admin')->user()->enq_setting)){
        $setting = json_decode(Auth::guard('admin')->user()->enq_setting,true);
    }
}
?>
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
        Template List
      </h1>
    
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Template List</li>
      </ol>
    </section>
   
  <section class="content">
   <div class="box">
            <div class="box-header">
              <!--<h3 class="box-title">ITEM LIST</h3>-->
              <a href="{{url('add_enq_template')}}" class="panel-title" style="color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Template</a>
            </div>
             <?php $x = 1; ?>
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Template Name</th>
                  <th>Description</th>
                  <th>Action</th>
                  <?php if(!in_array(1, $setting)) { ?><th>Category</th><?php } ?>
                  <?php if(!in_array(3, $setting)) { ?><th>Fields</th><?php } ?>
                </tr>
                </thead>
                <tbody>
                    @foreach($enq_template as $s)
                        <tr id="{{$s->enq_temp_id}}">
                            <td>{{$x++}}</td>
                            <td>{{$s->temp_name}}</td>
                            <td>{{$s->temp_description}}</td>
                            <td><a href="{{ url('enq_edit?id='.$s->enq_temp_id)}}"><span class="fa fa-edit"></span></a>
                            <a href="{{ url('enq_template_del')}}/{{$s->enq_temp_id}}" style="color:red" class="delete"><span class="fa fa-trash"></span></a></td>
                            <?php if(!in_array(1, $setting)) { ?><td><button type="button" class="btn btn-default add_prod" data-toggle="modal" data-target="#modal-default">Add New Category</button></td><?php } ?>
                            <?php if(!in_array(3, $setting)) { ?><td><button type="button" class="btn btn-default add_prod" data-toggle="modal" data-target="#modal-default1">Add New Fields</button></td><?php } ?>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
 </div>   
  </section>
    <div class="modal fade" id="modal-default">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Add Category</h4>
           </div>
             <form  id="form" method="post" action="{{ url('update_category') }}" autocomplete="on">
            {{ csrf_field() }}
           <div class="modal-body">
             <table class="table table-striped table-bordered" border="0">
                            <thead>
                                <tr>
                                    <th style="width:5px;"><b>Action</b></th>
                                    <th><b>Select Category</b></th>
                                </tr>
                            </thead>
                            <tbody id="h_lost">
                                <tr class="input_fields_wrap">
                                    <td style="width:0.5%;"><i class="fa fa-plus-circle append" style="color: #0c8a54;font-size: x-large;"></i></td>
                                    <td class="parameter">
                                    <select class="form-control select2" style="width: 100%;" name="parameter_textbox[]" id="product_id">
                                        <option value="">-- Select Category--</option>
                                        @foreach($enq_root_category as $cat)                                        
                                        <option value="{{$cat->cat_id}}">{{$cat->cat_name}}</option>
                                        @endforeach
                                    </select>
                                    </td>
                            <input type="hidden" name="cat_id" class="abc" id="cat_id" value="" />
                                </tr>
                            </tbody>
                        </table>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary">Save</button>
           </div>
             </form>
         </div>
         <!-- /.modal-content -->
       </div>
   </div>
    
    <div class="modal fade" id="modal-default1">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Add Product</h4>
           </div>
              <form  id="form" method="post" action="{{ url('update_field') }}" autocomplete="on">
            {{ csrf_field() }}
           <div class="modal-body">

                <input type="hidden" name="cat_id" class="abc" id="cat_id" value="" />
                <table class="table table-striped table-bordered" border="0">
                                        <thead>
                                            <tr>
                                                <th style="width:5px;"><b>Action</b></th>
                                                <th><b>label Name</b></th>
                                                <th><b>Data Type</b></th>  
                                                <th><b>Requierd</b></th>
                                            </tr>
                                        </thead>
                                        <tbody id="h_lost1">
                                            <tr class="input_fields_wrap">
                                                <td style="width:0.5%;"><i class="fa fa-plus-circle add_field_button" style="color: #0c8a54;"></i></td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Label Name" value="" name="parameter_field[1][]" id="parameter_field[1][]"  required >
                                                </td>
                                                <td>
                                                    <select class="form-control select2 prod_drop" style="width: 100%;" name="parameter_field[1][]" id="parameter_field[1]">
                                                        <option value="text">Text</option>
                                                        <option value="number">Number</option>
                                                        <option value="logtext">Log Text</option>
                                                        <option value="dropdown">Dropdown</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="minimal" name="parameter_field[1][]" >
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>   
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary ">Save</button>
           </div>
              </form>
         </div>
         <!-- /.modal-content -->
       </div>
   </div>
        <!-- /.modal -->
<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function () {
     $('select').select2();
     $(".delete").on("click",function(){
        return confirm('Are you sure to delete');
    });
    
    $(".add_prod").click(function(){
         var trid = $(this).closest('tr').attr('id'); 
         $(".abc").val(trid);
    })
    
    var k = 1;
     $(".append").click( function(e) {
          e.preventDefault();
        $("#h_lost").append('<tr class="input_fields_wrap">\n\
                                <td style="width:0.5%;"><i class="fa fa-minus-circle remove_this" style="font-size: x-large;color: red;"></i></td>\n\
                                <td class="parameter"><select class="form-control select2" style="width: 100%;" name="parameter_textbox[]" id="product_id"><option value="">-- Select Category--</option><?php foreach($enq_root_category as $cat) { ?><option value=<?php echo $cat->cat_id;?>><?php echo $cat->cat_name; ?></option><?php } ?></select></td>\n\
                                </tr>');
                    k++;
        return false;
        });

    jQuery(document).on('click', '.remove_this', function() {
        jQuery(this).parent().parent().remove();
        return false;
        });   
        
        
        //Product/Text Filed Or Drop Down
        var i = 2;
        var l=1;
       $(document).on('click','.add_field_button',function(){
        var v = $(this).parents("td").prevAll(".parameter").eq(1).val();
        i++; 
        l++;
        
        $("#h_lost1").append('<tr class="input_fields_wrap delparam_'+l+'">\n\
            <td style="width:2%;"><i class="fa fa-plus-circle add_field_button" style="color: #0c8a54;"></i><i class="fa fa-minus-circle remove_field" style="color: red;"></i></td><td><input type="text" class="form-control" placeholder="Label Name" value="" name="parameter_field['+i+'][]"  required ></td>\n\
            <td><select class="form-control select2 prod_drop" style="width: 100%;" name="parameter_field['+i+'][]" id="parameter_field['+i+']"><option value="text">Text</option><option value="number">Number</option><option value="logtext">Log Text</option><option value="dropdown">Dropdown</option></select></td><td><label><input type="checkbox" class="minimal" name="parameter_field['+i+'][]" ></label></td></tr>')

            $('select').select2();
            $('.datepicker-autoclose').datepicker();
        });
    j=2;
        $(document).on("change",".prod_drop",function(){
                  var trid = $(this).attr('id');
                  var id = $(this).val();
                  if(id == "dropdown"){
                  var $this     = $(this);
                  $parentTR = $this.closest('tr');
                  $($parentTR).after('<tr class="subprocess_row delparam_'+l+'" >\n\
                        <td style="width:2%;"></td>\n\
                        <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;" id="'+trid+'"></i><i class="fa fa-minus-circle remove_field1" style="color: red;"></i></td>\n\
                        <td><input type="text" name="'+trid+'[product][]" id="'+trid+'[product][]" class="form-control checkblank" rows="1"  aria-required="true"></textarea></td></tr>');
                    }
        });
        
        $(document).on('click','.add_field_button1',function(){
             var trid = $(this).attr('id');
                 // alert(trid);
            $(this).closest('tr').after('<tr class="subprocess_row delparam_'+l+'">\n\
                        <td style="width:2%;"></td>\n\
                        <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;" id="'+trid+'"></i><i class="fa fa-minus-circle remove_field1" style="color: red;"></i></td>\n\
                        <td><input type="text" name="'+trid+'[product][]" id="'+trid+'[product][]" class="form-control checkblank" rows="1"  aria-required="true"></textarea></td></tr>');
        }); 
    

    $("#h_lost1").on('click','.remove_field',function(){
           var classname = $(this). closest('tr').attr('class');
           var ret = classname.split(" ");
           var ret1 = ret[1].split("_");
            $('.delparam_'+ret1[1]).remove();
        });
        $("#h_lost1").on('click','.remove_field1',function(){
            $(this).parent().parent().remove();
        });
        
//        var j = 2;
//     $("#append").click( function(e) {
//          e.preventDefault();
//        $(".inc").append('<div class="row" style="margin-bottom: 15px;"><div class="form-group"><div class="col-sm-1"><i class="fa fa-minus-circle remove_this1" style="font-size: x-large;color: red;"></i></div>\
//                <div class="col-sm-5" ><input type="text" class="form-control" placeholder="Label Name" value="" name="parameter_field['+j+'][]"  required ></div>\
//                <div class="col-sm-4">\n\
//                <select class="form-control select2" style="width: 100%;" name="parameter_field['+j+'][]" id="product_id"><option value="text">Text</option><option value="number">Number</option><option value="logtext">Log Text</option></select>\n\
//                </div><div class="col-sm-2"><label><input type="checkbox" name="parameter_field['+j+'][]" class="minimal" ></label></div>\
//            </div></div>');
//                    j++;
//        return false;
//        });
//
//    jQuery(document).on('click', '.remove_this1', function() {
//        jQuery(this).parent().parent().remove();
//        return false;
//        });
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
