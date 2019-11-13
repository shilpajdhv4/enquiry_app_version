@extends('layouts.employee.app')
@section('title', 'Add Enquiry')
@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
@media only screen and (max-width: 600px) {
    .datepicker {
        width: 100px;
        /*height:100px;*/
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
} ?>
<section class="content">
        <div class="container-fluid">
           @if (Session::has('alert-success'))
            <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
                <h4 class="alert-heading">Success!</h4>
                {{ Session::get('alert-success') }}
            </div>
            @endif
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Add New Enquiry</h2>
                        </div>
                        <div class="body">
                            <form  id="userForm" method="post" action="{{ url('add-enquiry') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="en_id" id="en_id" value="" />
                                <div class="form-group form-float">
                                    <label for="userName" class="form-label"><b>Select Enquiry Template</b><span style="color:red"> * </span></label>
                                    <!--<div class="col-sm-9">-->
                                        <?php $l = 0; ?>
                                            @foreach($enq_template as $temp)
                                            <input type="radio" name="enq_template_id" id="optionsRadios2 enq_template_id{{$l}}" class="with-gap" value="{{$temp->enq_temp_id}}" <?php if($l == 0) echo "checked"; ?>>
                                            <label for="optionsRadios2 enq_template_id{{$l}}">{{$temp->temp_name}}</label>
                                            <?php $l++; ?>
                                            @endforeach
                                    <!--</div>-->
                                </div>
                            
                            <?php if(!in_array(2, $setting)) { ?>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="tel" class="form-control" onkeypress="return phoneno(event)" id="enq_mobile_no" onkeyup="check();" name="enq_mobile_no" required>
                                        <label class="form-label">Mobile No</label>
                                    </div>
                                </div>
                            <?php } if(!in_array(4, $setting)) { ?>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="enq_name" id="enq_name" required>
                                        <label class="form-label">Customer Name</label>
                                    </div>
                                </div>
                            <?php } ?>
                                <?php if(!in_array(3, $setting)) { ?>
                        <div id="field_box"></div>
                        <?php } if(!in_array(1, $setting)) { ?>
                        <div id="category_box" class="form-group"></div>
                        
                        <div id="product_box" class="form-group"></div>
                        <?php } if(!in_array(6, $setting)) { ?>
                        <table width="100%">
                            <tbody id="h_lost">                                
                                <tr class="first">
                                    <td>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <textarea name="description" cols="30" rows="5" class="form-control no-resize" required></textarea>
                                                <label class="form-label">Followup Description</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="date" class="form-control" name="enq_name" id="enq_name" required>
                                            <!--<label class="form-label">Followup Date</label>-->
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php } ?>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
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
//    $('.select2').select2();
    //$('input[name="enq_template_id"]:radio').attr('checked', true).trigger('click');
    $("#fpago2").attr('checked', true).trigger('click');
    
	
//	 $('.datepicker').datepicker({
//            format: "dd-mm-yyyy",
//            autoclose: true,
//            todayHighlight: true
//    })
	
    $('input[name="enq_template_id"]:radio').on("click", function(){
        var trid = $(this).val();
         $.ajax({
            url: 'enq_temp_value1/'+ trid,
            type: "GET",
            success: function(data) {
                var jsonData = JSON.parse(data);
                console.log(data);
                $("#field_box").html(jsonData.field);
                $("#category_box").html(jsonData.category);
                $("#field_box").find('.form-control').focus(function () {
                    $(this).closest('.form-line').addClass('focused');
                     $('#optgroup').multiSelect({ selectableOptgroup: true });
                });
            }
        });
    });  
      $("input:radio:first").prop("checked", true).trigger("click");
//    $('input[name="enq_template_id"]:radio').attr('checked', true).trigger('click');
    $(document).on('change', '#category', function(){
        var id = $(this).val();
        $.ajax({
            url: 'enq_sub_cat1/'+ id,
            type: "GET",
            success: function(data) {
                console.log(data);
                var jsonData = JSON.parse(data);
                console.log(jsonData);
//                $('select').select2();
                $("#sub_level_box").html(jsonData.category);
                $("#product_box").html(jsonData.product);
//                $('.select2').select2();
            }
        });
    }); 
        
    $(document).on('change', '#category1', function(){
        var id = $(this).val();
        $.ajax({
            url: 'enq_sub_cat1/'+ id,
            type: "GET",
            success: function(data) {
				console.log(data);
                var jsonData = JSON.parse(data);
                console.log(jsonData);
//                $('select').select2();
                $("#sub_level_box").append(jsonData.category);
                $("#product_box").html(jsonData.product);
//                $('.select2').select2();
            }
        });
    });  
    
        
    $('div.alert').delay(3000).slideUp(300);

    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    var i = 0;
    var x = 1; //initlal text box is_countable
    var s = 14;
    
    $(document).on('click','.add_field_button',function () {
//        alert();
        x++;
        var date = $("#cop_date").val();
        var message = $('.input_fields_wrap tr').length;
        
        $("#h_lost").append('<tr class="first"><td><textarea class="form-control mobile_date" rows="3" cols="40" placeholder="Enter Here..." name="follow_up['+x+'][0]" required ></textarea></td><td><div class="input-group date datepicker"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" name="follow_up['+ x +'][1]" id="datepicker" class="form-control datepicker" value="" /></div></td><input type="hidden" class="form-control" name="follow_up['+x+'][2]" value="<?php echo date('Y-m-d h:m:s'); ?>" readonly /><td><i class="fa fa-minus-circle btn-danger remove_field"></i></td></tr>')
       
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
       if(length > 9) {
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
