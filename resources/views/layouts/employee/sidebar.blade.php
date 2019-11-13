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
<section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li></li>
                    <li style="text-align: center;"><img src="<?php if($logo != "") echo $logo; else echo "dist/img/logo.png";  ?>" class="" alt="User Image" style="width: 100%;max-width: 70px;height: auto;margin: 10px;"></li>
                    <li>
                        <a href="{{url('employee-home')}}">
                            <i class="material-icons">dashboard</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('add-enquiry')}}">
                            <i class="material-icons">donut_large</i>
                            <span>Add Enquiry</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('enquiry-list')}}">
                            <i class="material-icons">donut_large</i>
                            <span>Enquiry List</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- #END# Right Sidebar -->
    </section>