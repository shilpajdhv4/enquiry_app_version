@extends('layouts.app')
@section('title', 'Edit Enquiry Template')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>
<?php 
$enq_cat = json_decode($enq_temp['enq_categories'],true); 
$enq_field = json_decode($enq_temp['enq_fields'],true); 
$ii = $jj = 1;$m = 0;
//echo "<pre>";print_r($enq_cat);exit;
?>
<section class="content-header">
    <h1>
        Edit Enquiry Template
    </h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('enq_edit') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="enq_id" value="{{$enq_temp->enq_temp_id}}" />
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userName" class="col-sm-3 control-label">Enquiry template Name<span style="color:red"> * </span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control"  placeholder="Template Name" value="{{$enq_temp->temp_name}}" id="temp_name" name="temp_name"  required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control"  placeholder="Description"  name="temp_description"  >{{$enq_temp->temp_description}}</textarea>
                            </div>
                        </div>
                        <?php $loc_arr = array();
                        if(isset($enq_temp->loc_id))
                        $loc_arr = explode(",",$enq_temp->loc_id); ?>
                        <div class="form-group">
                            <label for="userName" class="col-sm-3 control-label">Assign To Location</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" multiple="multiple" style="width: 100%;" name="loc_id[]" id="loc_id">
                                    <option value="">-- Select Location --</option>
                                    @foreach($location as $loc)
                                    <option value="{{$loc->loc_id}}" <?php if(in_array($loc->loc_id,$loc_arr)) echo "selected"; ?>>{{$loc->loc_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <h4><label for="userName" class="col-sm-3 control-label" style="text-align:center;">Add Category</label></h4>
                        </div>
                        <?php if(!empty($enq_cat)){ ?>
                        
                            <table class="table table-striped table-bordered" border="0">
                            <thead>
                                <tr>
                                    <th style="width:5px;"><b>Action</b></th>
                                    <th><b>Select Category</b></th>
                                </tr>
                            </thead>
                            <tbody id="h_lost">
                                @foreach($enq_cat as $category)
                                <tr class="input_fields_wrap">
                                    <?php if($ii == 1){ ?>
                                        <td style="width:0.5%;"><i class="fa fa-plus-circle append" style="color: #0c8a54;font-size: x-large;"></i></td>
                                    <?php } else { ?>
                                        <td style="width:0.5%;"><i class="fa fa-minus-circle remove_this" style="font-size: x-large;color: red;"></i></td>
                                    <?php } ?>
                                    <td class="parameter">
                                    <select class="form-control select2" style="width: 100%;" name="parameter_textbox[]" id="product_id">
                                        <option value="">-- Select Category--</option>
                                        @foreach($enq_root_category as $cat)                                        
                                        <option value="{{$cat->cat_id}}" <?php if($cat->cat_id == $category) echo "selected"; ?>>{{$cat->cat_name}}</option>
                                        @endforeach
                                    </select>
                                    </td>
                                </tr>
                                <?php $ii++; ?>
                                @endforeach
                            </tbody>
                        </table>
                        <?php } else { ?>
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
                        <?php } ?>
                        <!--</div>-->
                        
                        <!--<div class="form-group">-->
<!--                            <div class="inc">
                            <div class="form-group" style="margin-left: 50px">
                                <div class="col-sm-1">
                                   <label for="userName" class="control-label">Action</label>
                                </div>
                                <div class="col-sm-5" >
                                    <label for="userName" class="control-label">Label Name</label>
                                </div>
                                <div class="col-sm-4">
                                   <label for="userName" class="control-label">Data Type</label>
                                </div>
                                <div class="col-sm-2">
                                   <label for="userName" class="control-label">Required</label>
                                </div>
                            </div>
                            <?php //foreach($enq_field as $field) ?>
                            <?php // echo "<pre>";print_r($field[1]);exit; ?>
                            <div class="form-group total" style="margin-left: 50px">
                                <div class="col-sm-1">
                                    <?php // if($jj == 1) { ?>
                                        <i class="fa fa-plus-circle append1" id="append" style="color: #0c8a54;font-size: x-large;"></i>
                                    <?php // } else { ?>
                                        <i class="fa fa-minus-circle remove_this1" style="font-size: x-large;color: red;"></i>
                                    <?php // } ?>
                                </div>
                                <div class="col-sm-5" >
                                    <input type="text" class="form-control" placeholder="Label Name" value="<?php // echo $field[0]; ?>" name="parameter_field[{{$m}}][]"  required >
                                </div>
                                <div class="col-sm-4">
                                   <select class="form-control select2" style="width: 100%;" name="parameter_field[{{$m}}][]" id="product_id">
                                        <option value="text" <?php // if($field[1] == "text") echo "selected"; ?>>Text</option>
                                        <option value="number" <?php // if($field[1] == "number") echo "selected";?>>Number</option>
                                        <option value="logtext" <?php // if($field[1] == "logtext") echo "selected";?>>LogText</option>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <label>
                                        <input type="checkbox" class="minimal" name="parameter_field[{{$m}}][]" <?php //if(isset($field[2])) if($field[2] == "on") echo "checked"; ?>>
                                    </label>
                                </div>
                            </div>
                            <?php // $jj++;$m++;?>
                            
                        </div>-->
                        <!--</div>-->
                         <div class="form-group">
                            <h4><label for="userName" class="col-sm-3 control-label" style="text-align:center;">Add Fields</label></h4>
                        </div>
                        <?php if(!empty($enq_field)){ $l = 0;
//                        echo "<pre>";print_r($enq_field);exit;
                        ?>
                        <table class="table table-striped table-bordered" border="0">
                            <thead>
                                <tr>
                                    <th style="width:5px;"><b>Action</b></th>
                                    <th><b>label Name</b></th>
                                    <th><b>Data Type</b></th>  
                                    <th><b>Required</b></th>
                                    <th><b>Show On Dashboard</b></th>
                                </tr>
                            </thead>
                            <tbody id="h_lost1">
                                @foreach($enq_field as $field)
                                <tr class="input_fields_wrap delparam_{{$l}}">
                                    <td style="width:0.5%;"><i class="fa fa-plus-circle add_field_button" style="color: #0c8a54;font-size: x-large;"></i> <i class="fa fa-minus-circle remove_field" style="color: red;font-size: x-large;"></i></td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="Label Name" value="{{$field[0]}}" name="parameter_field[{{$m}}][]" id="parameter_textbox[1][]"  required >
                                    </td>
                                    <td>
                                        <select class="form-control select2 prod_drop" style="width: 100%;" name="parameter_field[{{$m}}][]" id="parameter_field[{{$m}}]">
                                            <option value="text" <?php if($field[1] == "text") echo "selected"; ?>>Text</option>
                                            <option value="number" <?php if($field[1] == "number") echo "selected";?>>Number</option>
                                            <option value="logtext" <?php if($field[1] == "logtext") echo "selected";?>>LogText</option>
                                            <option value="dropdown" <?php if($field[1] == "dropdown") echo "selected";?>>Dropdown</option>
                                        </select>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" class="minimal" name="parameter_field[{{$m}}][]" <?php if(isset($field[2])) if($field[2] == "on") echo "checked"; ?>>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" class="minimal" name="parameter_field[{{$m}}][]" <?php if(isset($field[3])) if($field[3] == "on") echo "checked"; ?>>
                                        </label>
                                    </td>
                                </tr>
                                <?php
                                    if($field[1] == "dropdown"){ 
                                        if(isset($field['product'])){
                                        foreach($field['product'] as $p){
                                        ?>
                                        <tr class="subprocess_row delparam_{{$l}}" >
                                        <td style="width:2%;"></td>
                                        <td><i class="fa fa-plus-circle add_field_button12" style="color: blue;font-size: x-large;" id="parameter_field[{{$m}}][product][]"></i><i class="fa fa-minus-circle remove_field1" style="color: red;font-size: x-large;"></i></td>
                                        <td><input type="text" name="parameter_field[{{$m}}][product][]" id="parameter_field[{{$m}}][product][]" class="form-control checkblank" rows="1" value="{{$p}}" aria-required="true"></td></tr>
                                        <?php } }
                                }                                
                                $jj++;$m++; $l++;?>
                            @endforeach
                            </tbody>
                        </table>  
                        <?php  } else { ?>
                            <table class="table table-striped table-bordered" border="0">
                                        <thead>
                                            <tr>
                                                <th style="width:5px;"><b>Action</b></th>
                                                <th><b>label Name</b></th>
                                                <th><b>Data Type</b></th>  
                                                <th><b>Required</b></th>
                                                <th><b>Show On Dashboard</b></th>
                                            </tr>
                                        </thead>
                                        <tbody id="h_lost1">
                                            <tr class="input_fields_wrap">
                                                <td style="width:0.5%;"><i class="fa fa-plus-circle add_field_button" style="color: #0c8a54;font-size: x-large;"></i></td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Label Name" value="" name="parameter_field[1][]" id="parameter_textbox[1][]"   >
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
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="minimal" name="parameter_field[1][]" >
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table> 
                        <?php } ?>
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Update</button>
                        <a href="{{url('enq_templates')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function () {
    $('.select2').select2();
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
        var i = $(".add_field_button").length;
        var l=$(".input_fields_wrap").length;//1;
       $(document).on('click','.add_field_button',function(){
//           alert();
        var v = $(this).parents("td").prevAll(".parameter").eq(1).val();
        i++; 
        l++;
       // alert(i);
        $("#h_lost1").append('<tr class="input_fields_wrap delparam_'+l+'">\n\
            <td style="width:2%;"><i class="fa fa-plus-circle add_field_button" style="color: #0c8a54;font-size: x-large;"></i> <i class="fa fa-minus-circle remove_field" style="color: red;font-size: x-large;"></i></td><td><input type="text" class="form-control" placeholder="Label Name" value="" name="parameter_field['+i+'][]"  required ></td>\n\
            <td><select class="form-control select2 prod_drop" style="width: 100%;" name="parameter_field['+i+'][]" id="parameter_field['+i+']"><option value="text">Text</option><option value="number">Number</option><option value="logtext">Log Text</option><option value="dropdown">Dropdown</option></select></td><td><label><input type="checkbox" class="minimal" name="parameter_field['+i+'][]" ></label></td><td><label><input type="checkbox" class="minimal" name="parameter_field['+i+'][]" ></label></td></tr>')

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
                        <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;font-size: x-large;" id="'+trid+'"></i> <i class="fa fa-minus-circle remove_field1" style="color: red;font-size: x-large;"></i></td>\n\
                        <td><input type="text" name="'+trid+'[product][]" id="'+trid+'[product][]" class="form-control checkblank" rows="1"  aria-required="true"></textarea></td></tr>');
                    }
        });
        
        $(document).on('click','.add_field_button1',function(){
             var trid = $(this).attr('id');
//                  alert(trid);
            $(this).closest('tr').after('<tr class="subprocess_row delparam_'+l+'">\n\
                        <td style="width:2%;"></td>\n\
                        <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;font-size: x-large;" id="'+trid+'"></i> <i class="fa fa-minus-circle remove_field1" style="color: red;font-size: x-large;"></i></td>\n\
                        <td><input type="text" name="'+trid+'[product][]" id="'+trid+'[product][]" class="form-control checkblank" rows="1"  aria-required="true"></textarea></td></tr>');
        }); 
        
        $(document).on('click','.add_field_button12',function(){
             var trid = $(this).attr('id');
//                  alert(trid);
            $(this).closest('tr').after('<tr class="subprocess_row delparam_'+l+'">\n\
                        <td style="width:2%;"></td>\n\
                        <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;font-size: x-large;" id="'+trid+'"></i> <i class="fa fa-minus-circle remove_field1" style="color: red;font-size: x-large;"></i></td>\n\
                        <td><input type="text" name="'+trid+'" id="'+trid+'" class="form-control checkblank" rows="1"  aria-required="true"></textarea></td></tr>');
        }); 
    


//        $(document).on('click','.remove_field',function(){
        $("#h_lost1").on('click','.remove_field',function(){
           var classname = $(this). closest('tr').attr('class');
//           alert(classname);
           var ret = classname.split(" ");
//           alert(ret);
           var ret1 = ret[1].split("_");
//           alert(ret1);
            $('.delparam_'+ret1[1]).remove();
        });
        $("#h_lost1").on('click','.remove_field1',function(){
            $(this).parent().parent().remove();
        });
        
        
//       var j = $(".total").length;
//     $(".append1").click( function(e) {
//          e.preventDefault();
//        $(".inc").append('<div class="form-group" style="margin-left: 50px"><div class="col-sm-1"><i class="fa fa-minus-circle remove_this1" style="font-size: x-large;color: red;"></i></div>\
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
</script>
@endsection
