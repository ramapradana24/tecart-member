@php
    $name = \Request::route()->getName();
@endphp
<div class="be-left-sidebar">
    <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">@yield('page-title')</a>
        <div class="left-sidebar-spacer">
        <div class="left-sidebar-scroll">
            <div class="left-sidebar-content">
            <ul class="sidebar-elements">
                <li class="divider">Menu</li>
                <li class="{{ ($name == 'profile.index') ? 'active' : '' }}"><a href="{{ route('profile.index') }}"><i class="icon mdi mdi-account-o"></i><span>Profile</span></a></li>
                <li><a href="index.html"><i class="icon mdi mdi-search"></i><span>Find Event</span></a></li>
                <li><a href="index.html"><i class="icon mdi mdi-assignment-o"></i><span>My Event</span></a></li>

                @if(Auth::user()->is_admin == 1)
                <li class="parent"><a href="#"><i class="icon mdi mdi-settings"></i><span>Administrator</span></a>
                    <ul class="sub-menu">
                      <li class="{{ ($name == 'event.index') ? 'active' : '' }}"><a href="{{ route('event.index') }}">Event</a>
                      </li>
                      <li><a href="charts-sparkline.html">Member</a>
                      </li>
                    </ul>
                </li>
                @endif
            </ul>
            </div>
        </div>
        </div>
    </div>
</div>