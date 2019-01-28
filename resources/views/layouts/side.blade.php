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
                <li class="{{ ($name == 'findevent.index') ? 'active' : '' }}"><a href="{{ route('findevent.index') }}"><i class="icon mdi mdi-search"></i><span>Find Event</span></a></li>
                <li class="{{ ($name == 'myevent.index') ? 'active' : '' }}"><a href="{{ route('myevent.index') }}"><i class="icon mdi mdi-assignment-o"></i><span>My Event</span></a></li>

                @if(Auth::user()->is_admin == 1)
                <li class="parent"><a href="#"><i class="icon mdi mdi-settings"></i><span>Administrator</span></a>
                    <ul class="sub-menu">
                      <li class="{{ ($name == 'event.index') ? 'active' : '' }}"><a href="{{ route('event.index') }}">Event</a>
                      </li>
                      <li class="{{ ($name == 'event-validation.index') ? 'active' : '' }}"><a href="{{ route('event-validation.index') }}">Event Validation</a>
                      </li>
                      <li class="{{ ($name == 'member.index') ? 'active' : '' }}"><a href="{{ route('member.index') }}">Member</a>
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