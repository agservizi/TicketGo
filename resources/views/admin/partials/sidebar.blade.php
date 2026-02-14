@php
    $forcedSidebarLogo = 'uploads/logo/logoticketgo.png';
    $forcedSidebarLogoPath = public_path($forcedSidebarLogo);
    $sidebarLogo = asset($forcedSidebarLogo) . (file_exists($forcedSidebarLogoPath) ? ('?v=' . filemtime($forcedSidebarLogoPath)) : '');
    $sidebarLogoFallback = asset('assets/images/logo.svg');
    $sidebarFav = asset('assets/images/logo-sm.svg');
    $sidebarFavFallback = asset('assets/images/logo-sm.svg');
@endphp

<nav
    class="{{ $customThemeBackground == 'on' ? 'dash-sidebar light-sidebar transprent-bg' : 'dash-sidebar light-sidebar' }}">

       <div class="navbar-wrapper">
           <div class="m-header main-logo">
               <a href="{{ route('admin.dashboard') }}" class="b-brand">
                   <img src="{{ $sidebarLogo }}"
                       onerror="this.onerror=null;this.src='{{ $sidebarLogoFallback }}';"
                       alt="{{ config('app.name', 'TicketGo SaaS') }}" class="logo logo-lg" style="display:block;max-height:42px;width:auto;background:#fff;padding:4px;border-radius:6px;">
                       <img src="{{ $sidebarFav }}"
                       onerror="this.onerror=null;this.src='{{ $sidebarFavFallback }}';"
                       alt="{{ config('app.name', 'TicketGo SaaS') }}" class="logo logo-sm" style="display:block;max-height:34px;width:auto;background:#fff;padding:2px;border-radius:6px;">
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
