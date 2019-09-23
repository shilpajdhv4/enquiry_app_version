
<?php $role = Auth::user()->role; ?><!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image" style="text-align: center;">
          <img src="dist/img/logo.png" class="" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>iPing Data Labs</p>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active">
          <a href="{{url('home')}}">
            <i class="fa fa-dashboard"></i> <span>Home</span> 
          </a>
        </li>
        <?php if($role == 1){ ?>
        <li class="treeview <?php if(Request::is('item_data') || Request::is('cust_data') || Request::is('enquiry-status') || Request::is('active-inactive')){ ?> menu-open <?php } ?>">
          <a href="#">
            <i class="fa fa-list"></i> <span>MasterData</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            <ul class="treeview-menu" <?php if(Request::is('item_data') || Request::is('cust_data') || Request::is('enquiry-status') || Request::is('active-inactive')){ ?> style="display:block" <?php } ?>>
            <li <?php if(Request::is('item_data')) { ?>class="active" <?php } ?>><a href="{{url('item_data')}}"><i class="fa fa-circle-o"></i>Product</a></li>
            <!--<li <?php // if(Request::is('cust_data')) { ?>class="active" <?php // } ?>><a href="{{url('cust_data')}}"><i class="fa fa-circle-o"></i>Customer</a></li>-->
            <li <?php if(Request::is('enquiry-status')) { ?>class="active" <?php } ?>><a href="{{url('enquiry-status')}}"><i class="fa fa-circle-o"></i>Enquiry Status</a>
                <li <?php if(Request::is('active-inactive')) { ?>class="active" <?php } ?>><a href="{{url('active-inactive')}}"><i class="fa fa-circle-o"></i>Active/Inactive Status</a>
        </li>
          </ul>
        </li> 
        <?php } ?>
        <li <?php if(Request::is('add-enquiry')) { ?>class="active" <?php } ?>>
            <a href="{{url('add-enquiry')}}">
                <i class="fa fa-user"></i>Add Enquiry
            </a>
        </li>
        
        <li <?php if(Request::is('enquiry-list')) { ?>class="active" <?php } ?>>
            <a href="{{url('enquiry-list')}}">
                <i class="fa fa-user"></i>Enquiry List
            </a>
        </li>
        <?php if($role == 1){ ?>
        <li <?php if(Request::is('user-list')) { ?>class="active" <?php } ?>>
            <a href="{{url('user-list')}}">
                <i class="fa fa-user"></i>Employee Master
            </a>
        </li>
        <?php } ?>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>