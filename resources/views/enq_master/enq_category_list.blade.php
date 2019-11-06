@extends('layouts.app')
@section('title', 'Item-List')
@section('content')
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
        Category List
      </h1>
    
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Category List</li>
      </ol>
    </section>
   
  <section class="content">
   <div class="box">
            <div class="box-header">
              <!--<h3 class="box-title">ITEM LIST</h3>-->
              <a href="{{url('add_enq_category')}}" class="panel-title" style="color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Category</a>
            </div>
             <?php $x = 1; ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Category Name</th>
                  <th>Description</th>
                  <th>Parent Category</th>
                  <th>Action</th>
                  <th></th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($enq_category as $s)
                        <tr id="{{$s->cat_id}}">
                            <td>{{$x++}}</td>
                            <td>{{$s->cat_name}}</td>
                            <td>{{$s->cat_description}}</td>
                            <td>{{$s->parent_cat_name}}</td>
                            <td><a href="{{ url('edit_enq_category?id='.$s->cat_id)}}"><span class="fa fa-edit"></span></a></td>
                            <td><a href="{{ url('delete_enq_category')}}/{{$s->cat_id}}" style="color:red" class="delete"><span class="fa fa-trash"></span></a></td>
                            <td><button type="button" class="btn btn-default add_prod" data-toggle="modal" data-target="#modal-default1">Add Product</button></td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
 </div>   
  </section>
 <div class="modal fade" id="modal-default1">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Add Category</h4>
           </div>
             <form  id="form" method="post" action="{{ url('product') }}" autocomplete="on">
            {{ csrf_field() }}
           <div class="modal-body">
             <div class="inc">
                 
                 <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group" >
                        <div class="col-sm-1">
                           <label for="userName" class="control-label">Action</label>
                        </div>
                        <div class="col-sm-11" >
                            <label for="userName" class="control-label">Product Name</label>
                        </div>
                        <input type="hidden" name="cat_id" id="cat_id" value="" />
<!--                        <div class="col-sm-5">
                           <label for="userName" class="control-label">Category</label>
                        </div>-->
                    </div>
                    <div class="form-group" >
                        <div class="col-sm-1">
                            <i class="fa fa-plus-circle append" id="append" style="color: #0c8a54;font-size: x-large;"></i>
                        </div>
                        <div class="col-sm-11" >
                            <input type="text" class="form-control" placeholder="Product Name" value="" name="product_arr[]"  required >
                        </div>
<!--                        <div class="col-sm-5">
                           <select class="form-control select2" style="width: 100%;" name="parameter_textbox[1][]" id="product_id">
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="logtext">Log Text</option>
                            </select>
                        </div>-->
                    </div>                            
            </div>
                   </div>
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
<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
    $(".delete").on("click",function(){
        return confirm('Are you sure to delete');
    });
    
    var j = 2;
     $("#append").click( function(e) {
          e.preventDefault();
        $(".inc").append('<div class="row" style="margin-bottom: 15px;"><div class="form-group"><div class="col-sm-1"><i class="fa fa-minus-circle remove_this1" style="font-size: x-large;color: red;"></i></div>\
                <div class="col-sm-11" ><input type="text" class="form-control" placeholder="Product Name" value="" name="product_arr[]"  required ></div>\
                </div>\
            </div></div>');
                    j++;
        return false;
        });

    jQuery(document).on('click', '.remove_this1', function() {
        jQuery(this).parent().parent()  .remove();
        return false;
        });
    
    $(".add_prod").click(function(){
         var trid = $(this).closest('tr').attr('id'); 
         $("#cat_id").val(trid);
    })
    
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
