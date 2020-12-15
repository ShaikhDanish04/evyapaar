   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion toggled" id="accordionSidebar">

       <!-- Sidebar - Brand -->
       <a class="sidebar-brand bg-dark d-flex align-items-center justify-content-center" href="<?php echo $addr_space ?>index">
           Hindi Utsav
       </a>

       <!-- Divider -->
       <hr class="sidebar-divider my-0">

       <!-- Nav Item - Dashboard -->
       <li class="nav-item active">
           <a class="nav-link" href="<?php echo $addr_space ?>author/list">
               <i class="fas fa-fw fa-users"></i>
               <span>Authors</span></a>
       </li>
       <li class="nav-item active">
           <a class="nav-link" href="<?php echo $addr_space ?>category/list">
               <i class="fas fa-fw fa-list-alt"></i>
               <span>Category</span></a>
       </li>
       <li class="nav-item active">
           <a class="nav-link" href="<?php echo $addr_space ?>tag/list">
               <i class="fas fa-fw fa-tags"></i>
               <span>Tags</span></a>
       </li>
       <li class="nav-item active">
           <a class="nav-link" href="<?php echo $addr_space ?>post/list">
               <i class="fas fa-fw fa-newspaper"></i>
               <span>Posts</span></a>
       </li>



       <hr class="sidebar-divider d-none d-md-block">

       <!-- Sidebar Toggler (Sidebar) -->
       <div class="text-center d-none d-md-inline">
           <button class="rounded-circle border-0" id="sidebarToggle"></button>
       </div>

   </ul>
   <!-- End of Sidebar -->