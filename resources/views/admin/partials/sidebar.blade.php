@php
    $forcedSidebarLogo = 'uploads/logo/logoticketgo.png';
    $forcedSidebarLogoPath = public_path($forcedSidebarLogo);
    $sidebarLogo = asset($forcedSidebarLogo) . (file_exists($forcedSidebarLogoPath) ? ('?v=' . filemtime($forcedSidebarLogoPath)) : '');
    $sidebarLogoFallback = asset($forcedSidebarLogo);
    $sidebarFav = $sidebarLogo;
    $sidebarFavFallback = $sidebarLogoFallback;
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
