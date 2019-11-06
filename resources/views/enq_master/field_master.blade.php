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
               
        <form class="form-horizontal" id="form" method="post" action="{{ url('enq_field') }}" >
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body">
<!--                        <div class="inc">
                            <div class="form-group" style="margin-left: 50px">
                                <div class="col-sm-1">
                                   <label for="userName" class="control-label">Action</label>
                                </div>
                                <div class="col-sm-4" >
                                    <label for="userName" class="control-label">Label Name</label>
                                </div>
                                <div class="col-sm-4">
                                   <label for="userName" class="control-label">Data Type</label>
                                </div>
                                <div class="col-sm-2">
                                   <label for="userName" class="control-label">Required</label>
                                </div>
                            </div>
                            <div class="form-group" style="margin-left: 50px">
                                <div class="col-sm-1">
                                    <i class="fa fa-plus-circle append" id="append" style="color: #0c8a54;font-size: x-large;"></i>
                                </div>
                                <div class="col-sm-4" >
                                    <input type="text" class="form-control" placeholder="Label Name" value="" name="parameter_textbox[1][]"  required >
                                </div>
                                <div class="col-sm-4">
                                   <select class="form-control select2" style="width: 100%;" name="parameter_textbox[1][]" id="product_id">
                                        <option value="text">Text</option>
                                        <option value="number">Number</option>
                                        <option value="dropdown">Dropdown</option>
                                    </select>
                                    <input type="text" class="form-control" placeholder="data type" value="" name="customer_name"  required>
                                </div>
                                <div class="col-sm-1">
                                    <label>
                                      <input type="checkbox" class="minimal" name="parameter_textbox[1][]" >
                                    </label>
                                </div>
                                
                            </div>
                            
                        </div>-->
                    
                    <br/>
                    <table class="table table-striped table-bordered" border="0">
                                        <thead>
                                            <tr>
                                                <th style="width:5px;"><b>Action</b></th>
                                                <th><b>label Name</b></th>
                                                <th><b>Data Type</b></th>  
                                                <th><b>Requierd</b></th>
                                            </tr>
                                        </thead>
                                        <tbody id="h_lost">
                                            <tr class="input_fields_wrap">
                                                <td style="width:0.5%;"><i class="fa fa-plus-circle add_field_button" style="color: #0c8a54;"></i></td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Label Name" value="" name="parameter_textbox[1][]" id="parameter_textbox[1][]"  required >
                                                </td>
                                                <td>
                                                    <select class="form-control select2" style="width: 100%;" name="parameter_textbox[1][]" id="parameter_textbox[1]">
                                                        <option value="text">Text</option>
                                                        <option value="number">Number</option>
                                                        <option value="dropdown">Dropdown</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="minimal" name="parameter_textbox[1][]" >
                                                    </label>
                                                </td>
                                            </tr>
<!--                                            <tr class="subprocess_row">
                                                <td style="width:2%;"></td>
                                                <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;"></i><i class="fa fa-minus-circle remove_field1" style="color: red;"></i><br/></td>
                                                <td></td>
                                                <td><input type="text" class="form-control" placeholder="Value" value="" name="parameter_textbox[1][]"  required ></td>
                                            </tr>-->
                                        </tbody>
                                    </table>
            </div>  
            <input type="hidden" name="prod_flag" id="prod_flag"  />
            <div class="box-footer">
                <div class="card-body">
                    <!--<button type="button" id="btnsave" class="btn btn-success">Save</button>-->
                    <button type="submit" name="btnsubmit" class="btn btn-primary" value="Submit">Submit</button>
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
    $('select').select2();
    var k = 2;
     $("#append").click( function(e) {
          e.preventDefault();
        $(".inc").append('<div class="form-group" style="margin-left: 50px"><div class="col-sm-1"><i class="fa fa-minus-circle remove_this" style="font-size: x-large;color: red;"></i></div>\
                <div class="col-sm-4" ><input type="text" class="form-control" placeholder="Label Name" value="" name="parameter_textbox['+k+'][]"  required ></div>\
                <div class="col-sm-4">\n\
                <select class="form-control select2" style="width: 100%;" name="parameter_textbox['+k+'][]" id="parameter_textbox['+k+'][]"><option value="text">Text</option><option value="number">Number</option></select>\n\
                </div><div class="col-sm-1"><label><input type="checkbox" name="parameter_textbox['+k+'][]" class="minimal" ></label></div>\
            </div>');
                    k++;
        return false;
        });
        
        


    var i = 2;
    var l=1;
       $(document).on('click','.add_field_button',function(){
        var v = $(this).parents("td").prevAll(".parameter").eq(1).val();
        i++; 
        l++;
        
        $("#h_lost").append('<tr class="input_fields_wrap delparam_'+l+'">\n\
            <td style="width:2%;"><i class="fa fa-plus-circle add_field_button" style="color: #0c8a54;"></i><i class="fa fa-minus-circle remove_field" style="color: red;"></i></td><td><input type="text" class="form-control" placeholder="Label Name" value="" name="parameter_textbox['+i+'][]"  required ></td>\n\
            <td><select class="form-control select2" style="width: 100%;" name="parameter_textbox['+i+'][]" id="parameter_textbox['+i+'][]"><option value="text">Text</option><option value="number">Number</option><option value="dropdown">Dropdown</option></select></td><td><label><input type="checkbox" class="minimal" name="parameter_textbox[1][]" ></label></td></tr>')

            $('select').select2();
            $('.datepicker-autoclose').datepicker();
        });
    j=2;
        $(document).on("change",".select2",function(){
                  var trid = $(this).attr('id');
                  alert(trid);
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
                        <td><i class="fa fa-plus-circle add_field_button1" style="color: blue;"></i><i class="fa fa-minus-circle remove_field1" style="color: red;"></i></td>\n\
                        <td><input type="text" name="'+trid+'[product][]" id="'+trid+'[product][]" class="form-control checkblank" rows="1"  aria-required="true"></textarea></td></tr>');
        }); 
    

    $("#h_lost").on('click','.remove_field',function(){
           var classname = $(this). closest('tr').attr('class');
           var ret = classname.split(" ");
           var ret1 = ret[1].split("_");
            $('.delparam_'+ret1[1]).remove();
        });
        $("#h_lost").on('click','.remove_field1',function(){
            $(this).parent().parent().remove();
        });
  
});
</script>
@endsection
