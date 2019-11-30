@extends('layouts.app')
@section('title', 'Add Category')
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
<?php ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var yourArray = yourArray3 = [];
    yourArray3 = <?php echo json_encode($parent_arr); ?>;
    console.log(yourArray3);
//    yourArray3.push(yourArray1);
//    console.log(yourArray);
        jq162 = jQuery.noConflict( true );
        function myFunction() {
            yourArray = [];
            jq162('.serach_val').each(function() {
                yourArray.push($(this).val());
            });
            var children = yourArray3.concat(yourArray); 
            console.log(children);
            jq162( ".automplete-1" ).autocomplete({
               source: children
            });
        }
</script>
<link href="css/sweetalert.css" rel="stylesheet" />
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content-header">
    <h1>
        Add Category
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
<!--                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>-->
        <form class="form-horizontal" id="form" method="post" action="{{ url('add_enq_category') }}" autocomplete="on">
            {{ csrf_field() }}
            <div class="form-group row">

            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">                        
                        <!--<h3 class="box-title" style="text-align: center;">Add Drop Down Lists</h3>-->
                        <table class="table table-striped table-bordered" border="0">
                            <thead>
                                <tr>
                                    <th style="width:5px;"><b>Action</b></th>
                                    <th><b>Category Name</b></th>
                                    <th><b>Category Desc.</b></th>
                                    <th><b>Parent Category</b></th>
                                </tr>
                            </thead>
                            <tbody id="h_lost">
                                <tr class="input_fields_wrap">
                                    <td style="width:0.5%;"><i class="fa fa-plus-circle append" style="color: #0c8a54;font-size: x-large;"></i></td>
                                    <td class="parameter"><input type="text" name="parameter_detail[0][cat_name]" id="remark" class="form-control parameter checkblank serach_val" rows="1"  aria-required="true"></td>
                                    <td class="parameter"><input type="text" name="parameter_detail[0][cat_description]" id="remark" class="form-control parameter checkblank" rows="1" aria-required="true"></td>
                                    <td class="parameter"><input type="text" name="parameter_detail[0][parent_cat_name]" id="automplete-1" class="form-control parameter checkblank automplete-1" onkeypress="myFunction()" rows="1"  aria-required="true"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>  
            <input type="hidden" name="prod_flag" id="prod_flag"  />
            <div class="box-footer">
                <div class="card-body">
                    <button type="submit" name="btnsubmit" class="btn btn-success" value="Submit">Submit</button>
                    <a href="{{url('enq_category')}}" class="btn btn-danger" >Cancel</a>
                </div>
            </div>
            <input type="hidden" name="search_val_arr" id="search_val_arr"  />
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
var historyVar = [];
$(document).ready(function () {
   
    var k = 1;
     $(".append").click( function(e) {
          e.preventDefault();
        $("#h_lost").append('<tr class="input_fields_wrap">\n\
                                <td style="width:0.5%;"><i class="fa fa-minus-circle remove_this" style="font-size: x-large;color: red;"></i></td>\n\
                                <td class="parameter"><input type="text" name="parameter_detail['+k+'][cat_name]" id="remark" class="form-control parameter checkblank serach_val" rows="1"  aria-required="true"></td>\n\
                                <td class="parameter"><input type="text" name="parameter_detail['+k+'][cat_description]" id="remark" class="form-control parameter checkblank" rows="1"  aria-required="true"></td>\n\
                                <td class="parameter"><input type="text" name="parameter_detail['+k+'][parent_cat_name]" onkeypress="myFunction()" id="remark" class="form-control parameter checkblank automplete-1" rows="1"  aria-required="true"></td>\n\
                                </tr>');
                    k++;
        return false;
        });

        $(".automplete-1").on("focusout",function(){
            var id = $(this).val();
            $.ajax({
                url : "get_prev_cat/"+id,
                type: "GET",
                success : function (data){
                    swal(data)
                }
            })
        })

    jQuery(document).on('click', '.remove_this', function() {
        jQuery(this).parent().parent().remove();        
        return false;
        }); 
        
        
});
</script>
@endsection
