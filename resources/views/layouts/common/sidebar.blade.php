
<?php  
$logo = "";
    if(Auth::guard('admin')->check()){
        $permission = json_decode(Auth::guard('admin')->user()->permission,true); 
        $setting =array();
        if(isset(Auth::guard('admin')->user()->enq_setting)){
            $setting = json_decode(Auth::guard('admin')->user()->enq_setting,true);
        }
        $file = Auth::guard('admin')->user()->upload_logo;
        if($file != ""){
            $logo = "logo/".$file;
        }else{
            $logo = "dist/img/logo.png";
        }
        $role = 1;
    }
    elseif(Auth::guard('web')->check()){
        $permission = json_decode(Auth::guard('web')->user()->permission,true); 
        $role = 1;
        $logo = "dist/img/logo.png";
    }
    else if(Auth::guard('employee')->check()){
        $id = Auth::guard('employee')->user()->cid;
        $client = \App\Admin::select('permission','upload_logo','enq_setting')->where(['rid'=>$id])->first();
        if($client->upload_logo != ""){
            $logo = "logo/".$client->upload_logo;
        }else{
            $logo = "dist/img/logo.png";
        }
        $setting =array();
        if(isset(Auth::guard('admin')->user()->enq_setting)){
            $setting = json_decode(Auth::guard('admin')->user()->enq_setting,true);
        }
        $role = Auth::guard('employee')->user()->role;
        $permission = json_decode($client->permission,true); 
    }
    
?>
<style>
    i{
        color: #39fec3;
    }
</style>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="image" style="text-align: center;">
          <img src="<?php if($logo != "") echo $logo; else echo "dist/img/logo.png";  ?>" class="" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>iPing Data Labs</p>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active">
        @if(Auth::guard('admin')->check())
            <a href="{{url('home-admin')}}">
        @elseif(Auth::guard('web')->check())
            <a href="{{url('home')}}">
        @elseif(Auth::guard('employee')->check())
               <a href="{{url('employee-home')}}">
        @endif
            <i class="fa fa-dashboard"></i> <span>Home</span> 
          </a>
        </li>
        @if(Auth::guard('web')->check())
        <li <?php if(Request::is('user_mgt')) { ?>class="active" <?php } ?>>
            <a href="{{url('client_data')}}">
                <i class="fa fa-user"></i>Client Data
            </a>
        </li>
        @endif
        
        @if(Auth::guard('admin')->check())
        <li class="treeview <?php if(Request::is('enq_category') || Request::is('enq_location_list') || Request::is('enq_templates') || Request::is('user-list') || Request::is('enq-setting')){ ?> menu-open <?php } ?>">
          <a href="#">
            <i class="fa fa-list"></i> <span>MasterData</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" <?php if(Request::is('enq_category') || Request::is('enq_location_list') || Request::is('enq_templates') || Request::is('user-list') || Request::is('enq-setting')){ ?> style="display:block" <?php } ?>>
            <?php if(!in_array(1, $setting)) { ?><li <?php if(Request::is('enq_category')) { ?>class="active" <?php } ?>><a href="{{url('enq_category')}}"><i class="fa fa-circle-o"></i>Add Category</a></li><?php } ?>
            <?php if(!in_array(5, $setting)) { ?><li <?php if(Request::is('enq_location_list')) { ?>class="active" <?php } ?>><a href="{{url('enq_location_list')}}"><i class="fa fa-circle-o"></i>Location</a></li><?php } ?>
            <li <?php if(Request::is('enq_templates')) { ?>class="active" <?php } ?>><a href="{{url('enq_templates')}}"><i class="fa fa-circle-o"></i>Enquiry Template</a></li>
            <?php if(!in_array(7, $setting)) { ?><li <?php if(Request::is('user-list')) { ?>class="active" <?php } ?>><a href="{{url('user-list')}}"><i class="fa fa-circle-o"></i>Employee Master</a><?php } ?>
            <li <?php if(Request::is('enq-setting')) { ?>class="active" <?php } ?>><a href="{{url('enq-setting')}}"><i class="fa fa-circle-o"></i>Settings</a>
          </ul>
        </li>
         @endif
         
          @if(Auth::guard('admin')->check() || Auth::guard('employee')->check())
        <?php  if(in_array(2,$permission)) {?>
            <li <?php if(Request::is('add-enquiry')) { ?>class="active" <?php } ?>><a href="{{url('add-enquiry')}}"><i class="fa fa-circle-o"></i>Add Enquiry</a></li>
            <li <?php if(Request::is('enquiry-list')) { ?>class="active" <?php } ?>><a href="{{url('enquiry-list')}}"><i class="fa fa-circle-o"></i>Enquiry List</a></li>
        </li>
        <?php } ?>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>