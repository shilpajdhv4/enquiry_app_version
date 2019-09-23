@extends('layouts.app')
@section('title', 'Edit-Product')
@section('content')
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <section class="content-header">
      <h1>
        Edit Product
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Product</li>
      </ol>
    @if (Session::has('alert-success'))
    <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Success!</h4>
        {{ Session::get('alert-success') }}
    </div>
    @endif
    </section>
    <section class="content">
     <div class="row">
<!--        <div class="col-md-3"></div>-->
       <div class="col-md-10">
         <div class="box box-primary">
           <div class="box-header with-border">
             <h3 class="box-title">Edit Product</h3>
           </div>
             <form action="{{ url('edit-item') }}" method="POST" id="item_form" class="form-horizontal" >
               {{ csrf_field() }}
               <div class="box-body">
                   <div class="form-group">
                       <label for="lbl_type_name" class="col-sm-2 control-label">Product Name</label>
                       <div class="col-sm-6">
                           <input type="text" class="form-control" id="item_name" placeholder="Type" name="item_name" value="{{$item_data->item_name}}" required />
                           <input type="text" class="form-control" id="item_id" placeholder="Type" name="item_id" value="{{$item_data->item_id}}" style="display:none;">
                       </div>
                   </div>
                   <div class="form-group">
                        <label for="lbl_type_desc" class="col-sm-2 control-label">Product Rate</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="item_rate" name="item_rate" value="{{$item_data->item_rate}}" required />
                        </div>
                    </div>
                   <div class="form-group">
                        <label for="lbl_type_desc" class="col-sm-2 control-label">Product GST</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="item_gst" name="item_gst" value="{{$item_data->item_gst}}" required />
                        </div>
                         <div class="col-sm-1">
                            <input type="text" class="form-control number" placeholder="%"  readonly>
                        </div>
                    </div>
               </div>
             <div class="box-footer">
               <button type="submit" class="btn btn-info" id="btn_submit" name="btn_submit">Update</button>
               <a href="{{url('item_data')}}" class="btn btn-danger" >Cancel</a>
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
<script type="text/javascript">
//            $("#btnsubmit").on("click",function(){

            var jvalidate = $("#item_form").validate({
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
                    $("#item_form").valid();
                });
                
                $('.number').keypress(function(event) {
    var $this = $(this);
    if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
       ((event.which < 48 || event.which > 57) &&
       (event.which != 0 && event.which != 8))) {
           event.preventDefault();
    }

    var text = $(this).val();
    if ((event.which == 46) && (text.indexOf('.') == -1)) {
        setTimeout(function() {
            if ($this.val().substring($this.val().indexOf('.')).length > 5) {
                $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
            }
        }, 1);
    }

    if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
    }      
});
        </script>
@endsection
