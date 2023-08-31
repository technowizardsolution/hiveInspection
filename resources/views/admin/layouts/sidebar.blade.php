<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto">
            <a class="navbar-brand" href="{{url('admin/dashboard')}}">
              <span class=""> <img src="{{ URL::asset('resources/uploads/logo/Logo7.png')}}" alt="logo" height="28"></span>
              {{-- <h2 class="brand-text">{{ config('app.name') }}</h2> --}}
            </a>
          </li>
          <li class="nav-item nav-toggle">
            <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
              <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
      </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class=" nav-item @if(Request::is('admin/dashboard') ||Request::is('admin/dashboard/*') ) active @endif">
            <a class="d-flex align-items-center" href="{{url('admin/dashboard')}}">
              <i class="fa fa-home" aria-hidden="true"></i>
              <span class="menu-title text-truncate" data-i18n="Dashboard">
                Dashboard
              </span>
            </a>
          </li>

          @can('user-list')
            <li class=" nav-item @if(Request::is('admin/users') ||Request::is('admin/users/*') ) active @endif">
                <a class="d-flex align-items-center" href="{{url('admin/users')}}">
                <i class="fa fa-user-circle-o"></i>
                <span class="menu-title text-truncate" data-i18n="Users">
                    Users
                </span>
                </a>
            </li>
          @endcan

          @can('hive-list')
            <li class=" nav-item @if(Request::is('admin/hive') ||Request::is('admin/hive/*') ) active @endif">
                <a class="d-flex align-items-center" href="{{url('admin/hive')}}">
                <i class="fa fa-user-circle-o"></i>
                <span class="menu-title text-truncate" data-i18n="Hive">
                   Hive
                </span>
                </a>
            </li>
          @endcan

          @can('inspection-list')
            <li class=" nav-item @if(Request::is('admin/inspection') ||Request::is('admin/inspection/*') ) active @endif">
                <a class="d-flex align-items-center" href="{{url('admin/inspection')}}">
                <i class="fa fa-user-circle-o"></i>
                <span class="menu-title text-truncate" data-i18n="Inspection">
                   Inspection
                </span>
                </a>
            </li>
          @endcan

          <!-- @can('subadmin-list')
            <li class=" nav-item @if(Request::is('admin/subadmins') ||Request::is('admin/subadmins/*') ) active @endif">
                <a class="d-flex align-items-center" href="{{url('admin/subadmins')}}">
                <i class="fa fa-user"></i>
                <span class="menu-title text-truncate" data-i18n="Sub Admins">
                    Sub Admins
                </span>
                </a>
            </li>
          @endcan

          @can('role-list')
          <li class=" nav-item @if(Request::is('admin/roles') ||Request::is('admin/roles/*') ) active @endif">
            <a class="d-flex align-items-center" href="{{url('admin/roles')}}">
              <i class="fa fa-user"></i>
              <span class="menu-title text-truncate" data-i18n="Sub Admins">
                  Roles
              </span>
            </a>
          </li>
          @endcan

          @can('role-user-list')
          <li class=" nav-item @if(Request::is('admin/roleuser') ||Request::is('admin/roleuser/*') ) active @endif">
            <a class="d-flex align-items-center" href="{{url('admin/roleuser')}}">
              <i class="fa fa-user"></i>
              <span class="menu-title text-truncate" data-i18n="Sub Admins">
                  Role User
              </span>
            </a>
          </li>
          @endcan

          @can('country-list')
          <li class=" nav-item  @if(Request::is('admin/countries') ||Request::is('admin/countries/*') ) active @endif">
            <a class="d-flex align-items-center" href="{{url('admin/countries')}}">
              <i class="fa fa-flag"></i>
              <span class="menu-title text-truncate" data-i18n="Manage Country/State/City">
                Manage Country/State/City
              </span>
            </a>
          </li>
          @endcan

          @can('page-list')
          <li class=" nav-item @if(Request::is('admin/pages') ||Request::is('admin/pages/*') ) active @endif">
            <a class="d-flex align-items-center" href="{{url('admin/pages')}}">
              <i class="fa fa-flag"></i>
              <span class="menu-title text-truncate" data-i18n="pages">
                Pages
              </span>
            </a>
          </li>
          @endcan

          @can('categories-list')
          <li class=" nav-item @if(Request::is('admin/categories') ||Request::is('admin/categories/*') ) active @endif">
            <a class="d-flex align-items-center" href="{{url('admin/categories')}}">
              <i class="fa fa-globe"></i>
              <span class="menu-title text-truncate" data-i18n="categories">
                Categories
              </span>
            </a>
          </li>
          @endcan

          @can('sub-categories-list')
          <li class=" nav-item @if(Request::is('admin/sub-categories') ||Request::is('admin/sub-categories/*') ) active @endif">
            <a class="d-flex align-items-center" href="{{url('admin/sub-categories')}}">
              <i class="fa fa-globe"></i>
              <span class="menu-title text-truncate" data-i18n="Sub Category">
                Sub Category
              </span>
            </a>
          </li>
          @endcan -->

          
  </div>
</div>
