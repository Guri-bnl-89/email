<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-heading theme-color mx-0">
    <div class="row mx-3 fs-11">
      <div class="col-6 p-0 "> Credit Balance</div>
      <div class="col-6 p-0 text-end">
        <span class="border border-warning rounded p-1 text-warning">{{ auth()->user() ? auth()->user()->credits: '' }}</span>
        <a href="{{ route('purchase') }}" class="border border-warning bg-warning rounded px-2 py-1 text-white">+</a>
      </div>
    </div>  
  </li>
  <hr class="mx-3 my-2 text-secondary">
  <li class="nav-item">
    <a class="nav-link {{ Request::is('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
      <i class="bi bi-grid  "></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <hr class="mx-3 my-2 text-secondary">
  <li class="nav-heading">EMAIL VERIFICATION</li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('list') ||  Request::is('result')  ? '' : 'collapsed' }}" href="{{ route('list') }}">
      <i class="bi bi-database-check  "></i>
      <span>Bulk Verification</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ Request::is('singleEmail') ? '' : 'collapsed' }}" href="{{ route('singleEmail') }}">
      <i class="bi bi-envelope-check  "></i>
      <span>Single Verification</span>
    </a>
  </li>

  <hr class="mx-3 my-2 text-secondary">
  <li class="nav-heading">Billing</li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('purchase') ? '' : 'collapsed' }}" href="{{ route('purchase') }}">
    <i class="bi bi-credit-card  "></i>
      <span>Plan & Purchase</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ Request::is('orders') ? '' : 'collapsed' }}" href="{{ route('orders') }}">
    <i class="bi bi-wallet  "></i>
      <span>Order List</span>
    </a>
  </li>  

  <hr class="mx-3 my-2 text-secondary">
  <li class="nav-heading">Support</li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('support') ? '' : 'collapsed' }}" href="{{ route('support') }}">
      <i class="bi bi-headset  "></i>
      <span>Ticket</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('support') ? '' : 'collapsed' }}" href="{{ route('support') }}">
      <i class="bi bi-chat-dots  "></i>
      <span>Live Chat</span>
    </a>
  </li>

  <hr class="mx-3 my-2 text-secondary">
  <li class="nav-heading">Profile</li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('profile') ? '' : 'collapsed' }}" href="{{ route('profile') }}">
      <i class="bi bi-person"></i>
      <span>Profile</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('logout') }}">
      <i class="bi bi-box-arrow-right  "></i>
      <span>Logout</span>
    </a>
  </li>

  @if(auth()->user()->access == 'admin')
    <hr class="mx-3 my-2 text-secondary">
    <li class="nav-heading">Admin</li>

    <li class="nav-item">
      <a class="nav-link {{ Request::is('usersList') ? '' : 'collapsed' }}" href="{{ route('usersList') }}">
        <i class="bi bi-person-gear "></i>
        <span>User Management</span>
      </a>
    </li>
  @endif


  <!-- <li class="nav-item">
    <a class="nav-link {{ Request::is('front_home') || Request::is('front_about') || Request::is('front_pricing') || Request::is('front_contact') ? '' : 'collapsed' }}" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-gem "></i><span>CRM</span><i class="bi bi-chevron-down ms-auto "></i>
    </a>
    <ul id="icons-nav" class="nav-content collapse {{ Request::is('front_home') || Request::is('front_about') || Request::is('front_pricing') || Request::is('front_contact') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{ route('front_home') }}" class="{{ Request::is('front_home') ? 'active' : '' }}">
          <i class="bi bi-circle "></i><span>Home</span>
        </a>
      </li>
      <li>
        <a href="{{ route('front_about') }}" class="{{ Request::is('front_about') ? 'active' : '' }}">
          <i class="bi bi-circle "></i><span>About Us</span>
        </a>
      </li>
      <li>
        <a href="{{ route('front_pricing') }}" class="{{ Request::is('front_pricing') ? 'active' : '' }}">
          <i class="bi bi-circle "></i><span>Pricing</span>
        </a>
      </li>
      <li>
        <a href="{{ route('front_contact') }}" class="{{ Request::is('front_contact') ? 'active' : '' }}">
          <i class="bi bi-circle "></i><span>Contact</span>
        </a>
      </li>
    </ul>
  </li> -->

</ul>

</aside>
<!-- End Sidebar-->