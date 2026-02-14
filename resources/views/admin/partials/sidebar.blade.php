@php
    $forcedSidebarLogoPath = base_path('uploads/logo/logoticketgo.png');
    $sidebarLogo = route('sidebar.logo') . (file_exists($forcedSidebarLogoPath) ? ('?v=' . filemtime($forcedSidebarLogoPath)) : '');
@endphp

<nav
    class="{{ $customThemeBackground == 'on' ? 'dash-sidebar light-sidebar transprent-bg' : 'dash-sidebar light-sidebar' }}">

       <div class="navbar-wrapper">
           <div class="m-header main-logo">
               <a href="{{ route('admin.dashboard') }}" class="b-brand">
                   <img src="{{ $sidebarLogo }}"
                       alt="{{ config('app.name', 'TicketGo SaaS') }}" class="logo logo-lg" style="display:block;max-height:42px;width:auto;background:#fff;padding:4px;border-radius:6px;">
                       <img src="{{ $sidebarLogo }}"
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
