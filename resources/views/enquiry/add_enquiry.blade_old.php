@extends('layouts.app')
@section('title', 'Add Owner')
@section('content')
<?php $role = Auth::user()->role; ?>
<section class="content-header">
    <h1>
        Add New Enquiry
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Enquiry</a></li>
        <li class="active">Add Enquiry</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('add-enquiry') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Enquiry No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="user" placeholder="Enquiry No" value="<?php if(isset($last_entry->enquiry_no)) echo ($last_entry->enquiry_no + 1); else echo "1001"; ?>" name="enquiry_no" readonly >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Mobile No</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="user" placeholder="Mobile No" value="" name="enquiry_no"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Customer Name</label>
                            <div class="col-sm-3">
                                <select class="form-control select2" style="width: 100%;" name="customer_id" required>
                                    <option value="">-- Select Customer -- </option>
                                    @foreach($custome_data as $cust)
                                    <option value="{{$cust->cust_id}}">{{$cust->cust_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="{{url('add_cust')}}" class="col-sm-1">Add</a>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Product Name</label>
                            <div class="col-sm-3">
                                <select class="form-control select2" style="width: 100%;" name="product_id" required>
                                    <option value="">-- Select Product -- </option>
                                    @foreach($product_data as $prod)
                                    <option value="{{$prod->item_id}}">{{$prod->item_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="{{url('add_item')}}" class="col-sm-1">Add</a>
                            <?php if($role == 1){ ?>
                            <label for="gst" class="col-sm-2 control-label">Assign To Employee</label>
                            <div class="col-sm-3">
                                <select class="form-control select2" style="width: 100%;" name="assign_to_emp_id" >
                                    <option value="">-- Select Employee -- </option>
                                    @foreach($employee_data as $emp)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="{{url('register')}}" class="col-sm-1">Add</a>
                            <?php } ?>
                        </div>
                        <div class="form-group">                  
                            <label for="gst" class="col-sm-2 control-label">Enquiry Status</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" style="width: 100%;" name="status_id" required>
                                    <option value="">-- Select Status -- </option>
                                    @foreach($enquiry_status as $enq)
                                    <option value="{{$enq->id}}">{{$enq->status_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--<a href="{{url('add-enquiry-status')}}" class="col-sm-1">Add</a>-->
                            <label for="gst" class="col-sm-2 control-label">Source</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" style="width: 100%;" id="source" name="source" required>
                                    <option value="">-- Select Status -- </option>
                                    <option value="Other" selected>Other</option>
                                    @foreach($source as $su)
                                    <option value="{{$su->name}}">{{$su->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group" id="source_text" style="display: none;">                  
                            <label for="gst" class="col-sm-2 control-label"></label>
                            <div class="col-sm-4"></div>
                            <label for="gst" class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <input type="text" name="source_val" class="form-control" id="source_val" value="" />
                            </div>
                        </div>
                        <table style="margin: 10px 10px 10px 10px;" class="table" >
                            <tbody id="h_lost">
                                <tr class="first">
                                    <td><b>FollowUp 1</b></td>
                                    <td>
                                        <textarea class="form-control" rows="3" placeholder="Enter Here..." name="follow_up[0][0]" required ></textarea>   
                                    </td>
                                    <td><a href="javascript:void(0)" class="btn btn-success btn-mini add_field_button">Add</a></td>
                                    <input type="hidden" name="follow_up[0][1]" value="<?php echo date('Y-m-d h:m:s'); ?>" />
                                </tr>
                            </tbody>
                        </table>
                        </div>
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
<script>
$(document).ready(function () {
    $('.select2').select2();
    $('div.alert').delay(3000).slideUp(300);

    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    var i = 0;
    var x = 1; //initlal text box is_countable
    var s = 14;

    $(add_button).click(function () {
        x++;
        var date = $("#cop_date").val();
        var message = $('.input_fields_wrap tr').length;
        
        $("#h_lost").append('<tr class="first"><td><b>FollowUp '+x+'</b></td><td><textarea class="form-control" rows="3" placeholder="Enter Here..." name="follow_up['+x+'][0]" required ></textarea></td><td><input type="text" class="form-control" name="follow_up['+x+'][1]" value="<?php echo date('Y-m-d h:m:s'); ?>" readonly /></td><td><a href="#" class="btn btn-danger btn-mini remove_field">Remove</a></td></tr>')
       
        $('select').select2();
        $('.datepicker-autoclose').datepicker();        
    });
    
    $("#source").on("change",function(){
        var a = $(this).val();
        if(a == "Event" || a == "Reference") {
            $("#source_text").css("display","block");
        }
    })
    
     $("#h_lost").on('click', '.remove_field', function () {
        $(this).parent().parent().remove();
    });


});
</script>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script type="text/javascript">
//            $("#btnsubmit").on("click",function(){

            var jvalidate = $("#userForm").validate({
                rules: {   
                        email: {required: true},
                        password : {required: true},
                    },
                     messages: {
                         email: "Please Enter Email Address",
                         password: "Please Enter Password"
                       }  
                });
                
                $('#btnsubmit').on('click', function() {
                    $("#orderForm").valid();
                });
                
                
        </script>
@endsection
