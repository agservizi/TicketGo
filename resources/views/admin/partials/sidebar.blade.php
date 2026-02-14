@php
    $sidebarLogo = getFile(getSidebarLogo());
    $sidebarLogoFallback = asset('uploads/logo/logoticketgo.png');
    $sidebarFav = getFile(getFavIcon());
    $sidebarFavFallback = asset('uploads/logo/favicon.png');
@endphp

<nav
    class="{{ $customThemeBackground == 'on' ? 'dash-sidebar light-sidebar transprent-bg' : 'dash-sidebar light-sidebar' }}">

       <div class="navbar-wrapper">
           <div class="m-header main-logo">
               <a href="{{ route('admin.dashboard') }}" class="b-brand">
                   <img src="{{ $sidebarLogo }}"
                       onerror="this.onerror=null;this.src='{{ $sidebarLogoFallback }}';"
                       alt="{{ config('app.name', 'TicketGo SaaS') }}" class="logo logo-lg">
                       <img src="{{ $sidebarFav }}"
                       onerror="this.onerror=null;this.src='{{ $sidebarFavFallback }}';"
                       alt="{{ config('app.name', 'TicketGo SaaS') }}" class="logo logo-sm">
               </a>
           </div>
           <div class="navbar-content">
               <ul class="dash-navbar">
                   {!! getMenu() !!}
               </ul>
           </div>

          
       </div>
   </nav>
  <div class="sidebar-submenu"></div>
