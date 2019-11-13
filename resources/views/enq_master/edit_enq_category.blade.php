@extends('layouts.app')
@section('title', 'Edit Category')
@section('content')
<style>
    @media only screen and (max-width: 600px) {
        .mobile_date {
            width: 160px;
        }
    }
</style>

<section class="content-header">
    <h1>
        Edit Category
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
        <div class="col-md-8">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('update_enq_category') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="cat_id" value="{{$enq_category->cat_id}}" />
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Category Name<span style="color:red"> * </span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  placeholder="Template Name" value="{{$enq_category->cat_name}}" id="temp_name" name="temp_name"  required >
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Category Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control"  placeholder="Category Description"  name="cat_description"  >{{$enq_category->cat_description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Parent Category</label>
                            <div class="col-sm-8">
                                <textarea class="form-control"  placeholder="Parent Category"  name="parent_cat_name"  >{{$enq_category->parent_cat_name}}</textarea>
                            </div>
                        </div>
                        <div class="inc">
                            <div class="form-group" >
                                <label for="userName" class="control-label col-sm-4" >Action</label>
                                <div class="col-sm-8" >
                                    <label for="userName" class="control-label">Product Name</label>
                                </div>
                            </div>
                            <?php $ii=1; 
                            if(count($product)>0){ ?>
                            @foreach($product as $prod)
                            <div class="form-group">
                                <?php if($ii == 1){ ?>
                                <i class="fa fa-plus-circle append control-label col-sm-4" id="append" style="color: #0c8a54;font-size: x-large;"></i>
                                <?php } else { ?>
                                <i class="fa fa-minus-circle control-label col-sm-4 remove_this1" style="font-size: x-large;color: red;"></i>
                                <?php } ?>
                                <div class="col-sm-8" >
                                    <input type="text" class="form-control" placeholder="Product Name" value="{{$prod->prod_name}}" name="product_prev_arr[{{$prod->prod_id}}]"  required >
                                </div>
                            </div>
                            <?php $ii++; ?>
                            @endforeach
                            <?php }else{ ?>
                            <div class="form-group">
                                <i class="fa fa-plus-circle append control-label col-sm-4" id="append" style="color: #0c8a54;font-size: x-large;"></i>
                                <div class="col-sm-8" >
                                    <input type="text" class="form-control" placeholder="Product Name" value="" name="product_arr[]"  required >
                                </div>
                            </div>    
                            <?php } ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Update</button>
                        <a href="{{url('enq_category')}}" class="btn btn-danger" >Cancel</a>
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
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete');
    });

    var j = 2;
    $("#append").click(function (e) {
        e.preventDefault();
        $(".inc").append('<div class="form-group"><i class="fa fa-minus-circle control-label col-sm-4 remove_this1" style="font-size: x-large;color: red;"></i>\
                <div class="col-sm-8" ><input type="text" class="form-control" placeholder="Product Name" value="" name="product_arr[]"  required ></div></div></div>');
        j++;
        return false;
    });

    jQuery(document).on('click', '.remove_this1', function () {
        jQuery(this).parent().remove();
        return false;
    });

    $(".add_prod").click(function () {
        var trid = $(this).closest('tr').attr('id');
        $("#cat_id").val(trid);
    })

});
</script>
@endsection
