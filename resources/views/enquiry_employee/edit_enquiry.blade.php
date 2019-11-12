@extends('layouts.app')
@section('title', 'Add Owner')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>
<?php 
if(Auth::guard('admin')->check()){
    $setting =array();
    if(isset(Auth::guard('admin')->user()->enq_setting)){
        $setting = json_decode(Auth::guard('admin')->user()->enq_setting,true);
    }
}else if(Auth::guard('employee')->check()){
        $id = Auth::guard('employee')->user()->cid;
        $client = \App\Admin::select('enq_setting')->where(['rid'=>$id])->first();
        $setting =array();
        if(isset(Auth::guard('admin')->user()->enq_setting)){
            $setting = json_decode(Auth::guard('admin')->user()->enq_setting,true);
        }
        
} 
//exit;
?>
<section class="content-header">
    <h1>
        Edit Enquiry
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
                 {!! Form::model($enquiry_data,[
                'method' => 'PUT',
                'url' => ['update-enquiry',$enquiry_data->enq_id],
                'class'=> 'form-horizontal',
                'id'=>'orderForm'
                ]) !!}
                <?php $enq_temp = \App\EnquiryTemplate::where(['enq_temp_id'=>$enquiry_data->enq_template_id])->first(); ?>
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userName" class="col-sm-3 control-label">Select Enquiry Template<span style="color:red"> * </span></label>
                            <div class="radio" col-sm-9>
                                <?php $l = 0; ?>
                            @foreach($enq_template as $temp)
                            <label>
                                  <input type="radio" name="enq_template_id" id="optionsRadios{{$l}} enq_template_id" value="{{$temp->enq_temp_id}}" <?php if($enquiry_data->enq_template_id == $temp->enq_temp_id) { echo "checked"; } ?>>{{$temp->temp_name}}
                            </label>
                            <?php $l++; ?>
                            @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <?php if(!in_array(2, $setting)) { ?>
                            <label for="userName" class="col-sm-2 control-label">Mobile No<span style="color:red"> * </span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" onkeypress="return phoneno(event)" id="enq_mobile_no" onkeyup="check();"  placeholder="Mobile No" value="{{$enquiry_data->enq_mobile_no}}" name="enq_mobile_no"  required >
                            </div>
                            <?php } if(!in_array(4, $setting)) { ?>
                            <label for="company" class="col-sm-2 control-label">Customer Name <span style="color:red"> * </span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="enq_name" placeholder="Customer Name" value="{{$enquiry_data->enq_name}}" name="enq_name"  required>
                            </div>
                            <?php } ?>
                        </div>
                        <?php if(!in_array(3, $setting)) { ?>
                        <div id="field_box">
                            <?php 
//                            exit;
                            $edit_field = json_decode($enquiry_data->enq_fields,true);
//                            echo "<pre>";print_r($edit_field['Branch']['product'][0]);exit;
                            $field = json_decode($enq_temp['enq_fields'],true);
                            $chk = "";
                            $i = $k = 0; 
                            $field_temp = $cat_temp = $required = "";
                            if(!empty($field)>0){ 
                                foreach($field as $f){
                                     if($i == 2){ 
                                        $field_temp .= '<div class="form-group">';   
                                     }
                                     if($i == 0){
                                         $field_temp .= '<div class="form-group">';   
                                     }
                                     if(isset($f[2])){
                                         if($f[2] == "on")
                                             $required = "required";
                                     }else{
                                         $required = "";
                                     }
                                     $field_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >'.$f[0].'</label>
                                        <div class="col-sm-4">';
                                         if(isset($f[1])){
                                             $type = $f[1];
                                             if($f[1] == "logtext"){
                                                 $field_temp .= '<textarea class="form-control" placeholder="'.$f[0].'" value="" row="3" name="parameter_textbox['.$f[0].'] "'.$required.'>'.$edit_field[$f[0]].'</textarea>';
                                             }
                                                 else if($f[1] == "dropdown"){
                                                     $field_temp .= '<select class="form-control select2" style="width: 100%;" name="parameter_textbox['.$f[0].'][product][] "'.$required.' >';
                                                                   if(isset($f['product'])){
                                                                       foreach($f['product'] as $p){
                                                                           if($edit_field[$f[0]]['product'][0] == $p) $chk = "selected";
                                                                        $field_temp .= '<option value="'.$p.'" '.$chk.'>'.$p.'</option>';
                                                                       }
                                                                   }

                                                              $field_temp .= '</select>';
                                                 }
                                                 else{
                                                     $field_temp .= '<input type="'.$type.'" class="form-control" placeholder="'.$f[0].'" value="'.$edit_field[$f[0]].'" name="parameter_textbox['.$f[0].'] "'.$required.'>';
                                                 }
                                             }
                                            $field_temp .= '</div>';
                                                 $i++; 
                                                 if($i == 2){ 
                                                     $field_temp .= '</div>';$i=0;
                                                 } $k++; 
                                             } 
                                         }
                            echo $field_temp;
//                            exit;
                            ?>
                        </div>
                        <?php } if(!in_array(1, $setting)) { ?>
                        <div id="category_box" class="form-group">
                            <?php 
                            $edit_category = json_decode($enquiry_data->enq_category,true);
                            $i = $prev_cat_id = 0;
                            if(!empty($edit_category)>0){ 
                            foreach($edit_category as $edit_cat){
                                $check = explode(":", $edit_cat);
                                if($i == 0){
                                    $category = json_decode($enq_temp['enq_categories'],true);
                                    if(!empty($category)){
                                        $category_val = \App\EnquiryCategory::select('cat_id','cat_name')->whereIn('cat_id',$category)->get();
                                        $cat_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >Select Category</label>';
                                    }
                                }else{
                                   $category_val = \App\EnquiryCategory::select('cat_id','cat_name')->where('parent_cat_id','=',$prev_cat_id)->get(); 
                                   $cat_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >Level </label>';
                                }
//                                echo "<pre>";print_r($category_val);
//                                exit;
                                //$cat_temp .= '<div class="form-group">';  
                                if(count($category_val)>0){ 
                                $cat_temp .= '<div class="col-sm-2">
                                  <select class="form-control select2" style="width: 100%;" name="category[]" id="category">
                                    <option value="">-- Select --</option>';
                                    foreach($category_val as $cat){ 
                                        $sel = "";
                                        if($check[0] == $cat->cat_id){
                                            $sel = "selected";
                                        }
                                        $cat_temp .= '<option value="'.$cat->cat_id.":".$cat->cat_name.'" '.$sel.'>'.$cat->cat_name.'</option>';
                                    }
                                $cat_temp .= '</select></div><div id="sub_level_box"></div>';
                                 }
                                 $i++;$prev_cat_id = $check[0];
                                
                            }
                            echo $cat_temp;
                            }
                            ?>
                        </div>
                        <div id="product_box" class="form-group">
                         <?php 
                         $prod_arr = array();
                         $prod_temp = "";
                         $edit_product = json_decode($enquiry_data->enq_product,true);
                         if(!empty($edit_product)){
                         foreach($edit_product as $row){
                             $check = explode(":", $row);
                             $prod_arr[] = $check[0];
                         }
//                         echo "<pre>";print_r($prod_arr);exit;
                        }
                         $prd_cat = \App\EnquiryProduct::select(['prod_id','prod_name'])->where(['cat_id'=>$prev_cat_id])->get();
                         if(count($prd_cat)>0){
//                            $prod_temp .= '<div class="col-sm-2">';
                            $prod_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >Product</label>
                                            <div class="col-sm-3"><select class="form-control select2" style="width: 100%;" multiple name="produc_field[]" id="produc_field">
                                            <option value="">-- Select --</option>';
                                foreach($prd_cat as $prod){ 
                                    $sel = "";
                                    if(in_array($prod->prod_id, $prod_arr)){
                                        $sel = "selected";
                                    }
                                    $prod_temp .= '<option value="'.$prod->prod_id.":".$prod->prod_name.'" '.$sel.'>'.$prod->prod_name.'</option>';
                                }
                        }
                            $prod_temp .= '</select></div>';
                            echo $prod_temp;
//                                        $arr['product'] = $prod_temp;
                        //} ?>
                        </div>
                        <?php } ?>
                        
                        <?php if(!in_array(6, $setting)) { ?>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Follow Up</label>
                        </div>
                        <table style="margin: 10px 10px 10px 10px;" class="table" id="myTable" >
                            <tbody id="h_lost">
                                <?php $x=1;$k=0; $json_data = json_decode($enquiry_data->follow_up,true); 
//                                echo "<pre>";print_r($json_data);exit;
                                if(!empty($json_data)>0){
                                foreach($json_data as $json){
//                                    echo "<pre>";print_r($json);exit;
                                ?>
                                <tr class="first">
                                    <td>
                                        <textarea class="form-control mobile_date" rows="3" placeholder="Enter Here..." name="follow_up[{{$k}}][0]" readonly >{{$json[0]}}</textarea>   
                                    </td>
                                    <td>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="follow_up[{{$k}}][1]" class="form-control " value="{{$json[1]}}" readonly  />
                                        </div>
                                    </td>
                                    <input type="hidden" name="follow_up[{{$k}}][2]" value="{{$json[2]}}" />
                                    <?php if($x == 1) { ?>
                                    <td><i class="fa fa-plus-circle btn-success add_field_button"></i></td>
                                    <!--<td><a href="javascript:void(0)" class="btn btn-success btn-mini add_field_button">Add</a></td>-->
                                    <?php }else{ ?><td></td><?php } ?>
                                </tr>
                                <?php $x++;$k++; }}else{ ?>
                                <tr class="first">
                                    <td>
                                        <textarea class="form-control mobile_date" rows="3" placeholder="Enter Here..." name="follow_up[0][0]" required ></textarea>   
                                    </td>
                                    <td>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="follow_up[0][1]" class="form-control  datepicker" value="" />
                                        </div>
                                    </td>
                                    <td><i class="fa fa-plus-circle btn-success add_field_button"></i></td>
                                    <input type="hidden" name="follow_up[0][2]" value="<?php echo date('Y-m-d h:m:s'); ?>" />
                                </tr>    
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Submit</button>
                        <a href="{{url('enquiry-list')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script>
$(document).ready(function () {
    $('.select2').select2();
    //$('input[name="enq_template_id"]:radio').attr('checked', true).trigger('click');
    $("#fpago2").attr('checked', true).trigger('click');
    
	
	 $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
    })
	
    $('input[name="enq_template_id"]:radio').on("click", function(){
        var trid = $(this).val();
         $.ajax({
            url: 'enq_temp_value/'+ trid,
            type: "GET",
            success: function(data) {
                var jsonData = JSON.parse(data);
                console.log(data);
                $("#field_box").html(jsonData.field);
                $("#category_box").html(jsonData.category);
            }
        });
    }); 
//    $('input[name="enq_template_id"]:checked').trigger('click');
//    $('input[name="enq_template_id"]:radio').attr('checked', true).trigger('click');
    $(document).on('change', '#category', function(){
        var id = $(this).val();
        $.ajax({
            url: 'enq_sub_cat/'+ id,
            type: "GET",
            success: function(data) {
                console.log(data);
                var jsonData = JSON.parse(data);
                console.log(jsonData);
                $('select').select2();
                $("#sub_level_box").html(jsonData.category);
                $("#product_box").html(jsonData.product);
                $('.select2').select2();
            }
        });
    });    
       
     $(document).on('change', '#category1', function(){
        var id = $(this).val();
        $.ajax({
            url: 'enq_sub_cat/'+ id,
            type: "GET",
            success: function(data) {
				console.log(data);
                var jsonData = JSON.parse(data);
                console.log(jsonData);
                $('select').select2();
                $("#sub_level_box").append(jsonData.category);
                $("#product_box").html(jsonData.product);
                $('.select2').select2();
            }
        });
    });     
       
    $('div.alert').delay(3000).slideUp(300);

    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    var i = 0;
    var x = $('#myTable tr').length;; //initlal text box is_countable
    var s = 14;
    
    $(document).on('click','.add_field_button',function () {
//        alert();
        x++;
        var date = $("#cop_date").val();
        var message = $('.input_fields_wrap tr').length;
        
        $("#h_lost").append('<tr class="first"><td><textarea class="form-control mobile_date" rows="3" placeholder="Enter Here..." name="follow_up['+x+'][0]" required ></textarea></td><td><div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" name="follow_up['+ x +'][1]" id="datepicker" style="width:50px;"  class="form-control datepicker" value="" /></div></td><input type="hidden" class="form-control" name="follow_up['+x+'][2]" value="<?php echo date('Y-m-d h:m:s'); ?>" readonly /><td><i class="fa fa-minus-circle btn-danger remove_field"></i></td></tr>')
       
//        $('select').select2();
        $('.datepicker-autoclose').datepicker();  
        
         $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
    })
        
    });
       
    $("#h_lost").on('click', '.remove_field', function () {
        $(this).parent().parent().remove();
    });
    
	
    $(document).ready(function() {
        window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    });
    window.onload = function () {
        document.onkeydown = function (e) {
            return (e.which || e.keyCode) != 116;
        };
    }

});

var jvalidate = $("#userForm").validate({
    rules: { 
            password : {required: true},
        },
         messages: {
             enq_mobile_no: "Please Enter Mobile No",
             enq_name: "Please Enter Customer Name"
           }  
    });

    $('#btnsubmit').on('click', function() {
        $("#orderForm").valid();
    });
         
         
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function phoneno(){          
            $('#enq_mobile_no').keypress(function(e) {
                var length = jQuery(this).val().length;
       if(length > 11) {
            return false;
       } else if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
       } else if((length == 0) && (e.which == 48)) {
            return false;
       }
            });
        }
</script>
@endsection
