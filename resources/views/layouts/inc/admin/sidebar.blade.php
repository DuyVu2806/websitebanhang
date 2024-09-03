<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile not-navigation-link">
        <div class="nav-link">
          <div class="user-wrapper">
            <div class="profile-image">
              <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{auth()->guard('admin')->user()->fullname}}" alt="profile image">
            </div>
            <div class="text-wrapper">
              <p class="profile-name">{{auth()->guard('admin')->user()->fullname}}</p>
              <div class="dropdown" data-display="static">
                <a href="#" class="nav-link d-flex user-switch-dropdown-toggler" id="UsersettingsDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <small class="designation text-muted">Manager</small>
                  <span class="status-indicator online"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="UsersettingsDropdown">
                  <a class="dropdown-item p-0">
                    <div class="d-flex border-bottom">
                      <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                        <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                      </div>
                      <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                        <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                      </div>
                      <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                        <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                      </div>
                    </div>
                  </a>
                  <a class="dropdown-item mt-2"> Manage Accounts </a>
                  <a class="dropdown-item"> Change Password </a>
                  <a class="dropdown-item"> Check Inbox </a>
                  <a class="dropdown-item"> Sign Out </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
          <i class="menu-icon mdi mdi-television"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" data-toggle="collapse" href="#basic-ui" aria-expanded="" aria-controls="basic-ui">
          <i class="menu-icon mdi mdi-dna"></i>
          <span class="menu-title">Nghiệp vụ</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="basic-ui">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item ">
              <a class="nav-link" href="{{route('admin.business.view_goods_import')}}">Nhập hàng</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="{{route('admin.business.view_orders')}}">Đơn hàng</a>
            </li>
          </ul>
        </div>
      </li>
  
      <li class="nav-item ">
        <a class="nav-link" href="{{route('admin.product.index')}}">
          <i class="menu-icon mdi mdi-chart-line"></i>
          <span class="menu-title">Sản Phẩm</span>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="{{route('admin.brand.index')}}">
          <i class="menu-icon mdi mdi-table-large"></i>
          <span class="menu-title">Nhãn Hàng</span>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="{{route('admin.category.index')}}">
          <i class="menu-icon mdi mdi-emoticon"></i>
          <span class="menu-title">Danh Mục</span>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" data-toggle="collapse" href="#user-pages" aria-expanded="" aria-controls="user-pages">
          <i class="menu-icon mdi mdi-lock-outline"></i>
          <span class="menu-title">Nhân viên</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse " id="user-pages">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item ">
              <a class="nav-link" href="{{route('admin.permission.index')}}">Danh sách</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.bootstrapdash.com/demo/star-laravel-free/documentation/documentation.html" target="_blank">
          <i class="menu-icon mdi mdi-file-outline"></i>
          <span class="menu-title">Documentation</span>
        </a>
      </li>
    </ul>
  </nav>