@extends('layouts.app')
@section('title', 'Add Process')
@section('content')
<style>
    /*    .wizard > .content {
        background: #fff;}*/
    span .select2-selection__rendered{
        width: 308.063px;
    }
    i{
        font-style: normal;
        width: 35px;
        line-height: 25px;
        font-size: 23px;

        display: inline-block;
        text-align: center;
    }
    .remove_field{
        color: red;
    }
  
</style>

<link href="css/sweetalert.css" rel="stylesheet" />
<section class="content-header">
    <h1>
        Enquiry Fields
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
        <form class="form-horizontal" id="form" method="post" action="{{ url('save_data') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            
            <div class="form-group row">

            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="inc">
                            <div class="form-group" style="margin-left: 50px">
                                <div class="col-sm-4" >
                                    <input type="text" class="form-control" placeholder="Label Name" value="" name="mobile_no"  required >
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="data type" value="" name="customer_name"  required>
                                </div>
                                <i class="fa fa-plus-circle append" id="append" style="color: #0c8a54;font-size: x-large;"></i>
                            </div>
                            
                        </div>
                        <table class="table table-striped table-bordered" border="0">
                            <thead>
                                <tr>
                                    <th style="width:5px;"><b>Action</b></th>
                                    <th ><b>Parameter Label</b></th>
                                    <th colspan="2"><b>Parameter Value</b></th>
                                </tr>
                            </thead>
                            <tbody id="h_lost">
                                <tr class="input_fields_wrap">
                                    <td style="width:0.5%;"><i class="fa fa-plus-circle add_field_button" style="color: #0c8a54;font-size: x-large;"></i></td>
                                    <td class="parameter" ><input type="text" name="parameter_detail[1][]" class="form-control parameter checkblank" /></td>
                                    <td class="parameter" colspan="2"><input type="text" name="parameter_detail[1][]" class="form-control parameter checkblank" /></td>
                                </tr>
                                <tr>
                                    <th style="width:5px;"><b></b></th>
                                    <th style="width:5px;"><b>Action</b></th>
                                    <th ><b>Sub Parameter Label</b></th>
                                    <th colspan="2"><b>Sub Parameter Value</b></th>
                                </tr>
                                <tr class="subprocess_row">
                                    <td style="width:2%;"></td>
                                    <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;font-size: x-large;"></i><i class="fa fa-minus-circle remove_field1" style="color: red;font-size: x-large;"></i><br/></td>
                                    <!--<td></td>-->
                                    <td><textarea name="parameter_detail[1][]" id="remark" class="form-control checkblank" rows="1"  aria-required="true"></textarea></td>
                                    <td><input type="text" name="parameter_detail[1][]" class="form-control number checkblank"   /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>  
            <input type="hidden" name="prod_flag" id="prod_flag"  />
            <div class="box-footer">
                <div class="card-body">
                    <button type="button" id="btnsave" class="btn btn-success">Save</button>
                    <button type="button" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="Submit">Submit</button>
                    <button type="button" name="btnupdate" id="btnupdate" class="btn btn-warning" value="Submit" style="display:none;">Update</button>
                </div>
            </div>
        </form>

    </div>
</div>
    </div>
</section>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">  
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="js/jquery.steps.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
   
$(document).ready(function () {
     $("#append").click( function(e) {
          e.preventDefault();
        $(".inc").append('<div class="form-group" style="margin-left: 50px">\
                <div class="col-sm-4" ><input type="text" class="form-control" onkeypress="return phoneno(event)" id="mobile_no" onkeyup="check();"  placeholder="Mobile No" value="" name="mobile_no"  required ></div>\
                <div class="col-sm-4"><input type="text" class="form-control" onkeypress="return phoneno(event)" id="mobile_no" onkeyup="check();"  placeholder="Mobile No" value="" name="mobile_no"  required ></div>\
                <i class="fa fa-minus-circle remove_this" style="font-size: x-large;color: red;"></i>\
            </div>');
        return false;
        });

    jQuery(document).on('click', '.remove_this', function() {
        jQuery(this).parent().remove();
        return false;
        });
    
    
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    var i = 2;
    var x = 1; //initlal text box count
    var s = 14;
    var l = 1;
    $(document).on('click', '.add_field_button', function () {
        var v = $(this).parents("td").prevAll(".parameter").eq(1).val();
        i++;
        l++;
        $("#h_lost").append('<tr class="input_fields_wrap delparam_' + l + '">\n\
            <td style="width:2%;"><i class="fa fa-plus-circle add_field_button" style="font-size: x-large;;color: #0c8a54;"></i><i class="fa fa-minus-circle remove_field" style="font-size: x-large;color: red;"></i></td>\n\
            <td colspan="2"><textarea name="parameter_detail[' + i + '][]" id="remark" class="form-control parameter checkblank" rows="1"  aria-required="true"></textarea></td>\n\
            <td style="width:5%;"></td>\n\
        </tr>'); //add input box
        $("#h_lost").append('<tr class="subprocess_row delparam_' + l + '">\n\
            <td style="width:2%;"></td>\n\
            <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;font-size: x-large;"></i><i class="fa fa-minus-circle remove_field1" style="color: red;font-size: x-large;"></i></td>\n\
            <td><textarea name="parameter_detail[' + i + '][]" id="remark" class="form-control checkblank" rows="1"  aria-required="true"></textarea></td>\n\
            <td><input type="text" class="form-control number checkblank" name="parameter_detail[' + i + '][]"  style="width: 50px;" /></td>\n\
    </tr>'); //add input box
        $('select').select2();
        $('.datepicker-autoclose').datepicker();
    });
    j = 2;
    var add_button1 = $(".add_field_button1");
    var row = $(this).closest("tr .subprocess_row");
    $(document).on('click', '.add_field_button1', function () {
        var v = $(this).closest('tr').find('.contact_name').val();
        if (v == null)
        {
            v = 0;
        }
        i++;
        $(this).closest('tr').after('<tr class="subprocess_row delparam_' + l + '">\n\
            <td style="width:2%;"></td>\n\
            <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;font-size: x-large;"></i><i class="fa fa-minus-circle remove_field1" style="color: red;font-size: x-large;"></i></td>\n\
            <td><textarea name="parameter_detail[' + i + '][]" id="remark" class="form-control checkblank" rows="1"  aria-required="true"></textarea></td>\n\
            <td><input type="text" class="form-control number checkblank" name="parameter_detail[' + i + '][]"  style="width: 50px;" /><input type="hidden" name="parameter_detail[' + i + '][7]" value="' + v + '" class="contact_name"/><input type="hidden" name="parameter_detail[' + i + '][8]" value="0"/></td>\n\
</tr>'); //add input box
        //i++;
        if (v != "undefined")
        {
        }
        $('select').select2();
        $('.datepicker-autoclose').datepicker();
        j++;
    });

    $("#h_lost").on('click', '.remove_field', function () {
        var classname = $(this).closest('tr').attr('class');
        var ret = classname.split(" ");
        var ret1 = ret[1].split("_");
        $('.delparam_' + ret1[1]).remove();
    });
    $("#h_lost").on('click', '.remove_field1', function () {
        $(this).parent().parent().remove();
    });

    var flag = 0;
    var bflag = 0;
    $("#btnsubmit").click(function () {

        var process_name = $('.process_name').val();
        if (process_name == "")
            flag = 1;
        $(".checkblank").each(function () {
            var val = $(this).val();
            if ($(this).val() == "")
            {
                flag = 1;
                return false;
            } else
            {
                flag = 0;
            }
        });
        $("#prod_flag").val(1);
        $('.loader').show();
        if (flag == 1)
        {
            swal({
                position: 'top-end',
                type: 'warning',
                title: 'Please Fill All Fields',
                showConfirmButton: false,
                timer: 1500
            });
        } else
        {
            $.ajax({
                type: "POST",
                url: 'save_data',
                async: false,
                cache: false,
                beforeSend: function () {
                    // Show image container
                    //alert("hjl");
                    $("#loader").show();
                },
                data: $("#form").serialize(),
                success: function (data) {
                    console.log(data);
                    // swal({ type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "LogSheet Sumbmitted Successfully", confirmButtonText: "Ok" });
                    swal({
                        title: "Successfully Inserted!",
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonColor: "#e74c3c",
                        showLoaderOnConfirm: true
                    },
                            function () {
                                setTimeout(function () {
                                    location.reload(true);
                                }, 1000);
                            });
                    $('.next_btn').attr("disabled", false);
                },
                complete: function (data) {
                    // Hide image container
                    $("#loader").hide();
                }
            });
        }
    });
    $("#btnsave").click(function () {

        var process_name = $('.process_name').val();
        if (process_name == "")
            flag = 1;
        $(".checkblank").each(function () {
            var val = $(this).val();
            if ($(this).val() == "")
            {
                flag = 1;
                return false;
            } else
            {
                flag = 0;
            }

        });
        $("#prod_flag").val(0);
        $('.loader').show();
        //$("#btnsubmit").attr('disabled',true);
        if (flag == 1)
        {
            swal({
                position: 'top-end',
                type: 'warning',
                title: 'Please Fill All Fields',
                showConfirmButton: false,
                timer: 1500
            });
        } else
        {
            $.ajax({
                type: "POST",
                url: 'save_data',
                async: false,
                cache: false,
                beforeSend: function () {
                    // Show image container
                    //alert("hjl");
                    $("#loader").show();
                },
                data: $("#form").serialize(),
                success: function (data) {
                    console.log(data);
                    // swal({ type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "LogSheet Sumbmitted Successfully", confirmButtonText: "Ok" });
                    swal({
                        title: "Successfully Inserted!",
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonColor: "#e74c3c",
                        showLoaderOnConfirm: true
                    },
                            function () {
                                setTimeout(function () {
                                    location.reload(true);
                                }, 1000);
                            });
                    $('.next_btn').attr("disabled", false);
                },
                complete: function (data) {
                    // Hide image container
                    $("#loader").hide();
                }
            });
        }
    });
    $("#btnupdate").click(function () {

        var process_name = $('.process_name').val();
//    var version=$('#version').val();
//    var new_version=parseInt(version) + 1;
        if (process_name == "")
            flag = 1;
        $(".checkblank").each(function () {
            var val = $(this).val();
            if ($(this).val() == "")
            {
                flag = 1;
                return false;
            } else
            {
                flag = 0;
            }

        });
        $("#prod_flag").val(0);
        //$("#version").val(new_version);
        $('.loader').show();
        //$("#btnsubmit").attr('disabled',true);
        if (flag == 1)
        {
            swal({
                position: 'top-end',
                type: 'warning',
                title: 'Please Fill All Fields',
                showConfirmButton: false,
                timer: 1500
            });
        } else
        {
            $.ajax({
                type: "POST",
                url: 'save_data',
                async: false,
                cache: false,
                beforeSend: function () {
                    // Show image container
                    //alert("hjl");
                    $("#loader").show();
                },
                data: $("#form").serialize(),
                success: function (data) {
                    console.log(data);
                    // swal({ type: "success", title: "Good Job!", confirmButtonColor: "#292929", text: "LogSheet Sumbmitted Successfully", confirmButtonText: "Ok" });
                    swal({
                        title: "Successfully Inserted!",
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonColor: "#e74c3c",
                        showLoaderOnConfirm: true
                    },
                            function () {
                                setTimeout(function () {
                                    location.reload(true);
                                }, 1000);
                            });
                    $('.next_btn').attr("disabled", false);
                },
                complete: function (data) {
                    // Hide image container
                    $("#loader").hide();
                }
            });
        }
    });

    $('.process_name').on('change', function () {
        var res = $(this).val();
        var new_version;
        $('#process_id').val("");
        $("#btnsubmit").show();
        $("#btnsave").attr('disabled', false);
        $('#btnupdate').hide();
        $.ajax({
            url: 'fetch_process_details/' + res,
            type: "GET",
            success: function (response) {
                var data = JSON.parse(response);
                new_version = data.version;
                console.log(data);
                $('#h_lost').html(data.result);
                $('#process_id').val(data.process_id);
                $("#client_id").val(data.process.clients).attr("selected", "selected");
                $("#client_id").trigger('change.select2');
                $("#team_leader").val(data.process.team_leader).attr("selected", "selected");
                $("#team_leader").trigger('change.select2');
                $("#area").val(data.process.area).attr("selected", "selected");
                $("#area").trigger('change.select2');
                $("#quality_auditor").val(data.process.quality_auditor).attr("selected", "selected");
                $("#quality_auditor").trigger('change.select2');
                $("#quality_manager").val(data.process.quality_manager).attr("selected", "selected");
                $("#quality_manager").trigger('change.select2');
                i = data.index;
                if (data.flag == 1)
                {
                    $("#btnsubmit").hide();
                    $("#btnsave").attr('disabled', true);
                    $('#btnupdate').show();
                    new_version = parseInt(data.version) + 1;
                }
                $('#version').val(new_version);
                l = data.del_flag;

            }
        });
    });
});
function change_param(val, index)
{
    $("#h_lost").find(".delparam_" + index).each(function () { //get all rows in table
        var ratingTd = $(this).find('.contact_name').val();//Refers to TD element
        $(this).find('.contact_name').val(val);
    });
}
</script>
@endsection
