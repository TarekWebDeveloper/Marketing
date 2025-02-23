
@php

    $current_page = Route::currentRouteName();

@endphp

    <!-- Sidebar -->

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('backend/img/logo.jpg') }}" width="45" alt="{{ config('app.name') }}">
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>



                                        <!---------- Admin ------------------------>




    
    <hr class="sidebar-divider my-0">

    @role(['admin'])

        @foreach($Main_menu as $menu)

            @if (count($menu->visibleChildren) == 0)


                <!-- active -->

                <li class="nav-item {{ $menu->id == getParentShow($current_page) ? 'active' : '' }}">

                <!-- route -->


                    <a href="{{ route('admin.'. $menu->as) }}" class="nav-link">

                <!-- name -->

                    <span>{{ $menu->display_name }}</span>
                    <i class="{{ $menu->icon != null ? $menu->icon : 'fa fa-home' }}"></i>

                    </a>
                </li>

                <hr class="sidebar-divider">

            @else

                  <!-- active -->

                <li class="nav-item 
                {{ in_array($menu->parent_show, [getParentShow($current_page),
                                                 getParent($current_page)])
                     ? 'active' : '' }}">
                  <!-- collapse -->

                    <a class="nav-link 
                    {{ in_array($menu->parent_show, [getParentShow($current_page), 
                                                     getParent($current_page)])
                         ? 'collapsed' : '' }}" 

                         href="#" data-toggle="collapse" data-target="#collapse_{{ $menu->route }}"
                          aria-expanded="true" 
                            aria-controls="collapse_{{ $menu->route }}">

                     <!-- name -->

                        <span>{{ $menu->display_name }}</span>

                     <!-- icon -->


                        <i class="{{ $menu->icon != null ? $menu->icon : 'fa fa-home' }}"></i>
                       


                    </a>
                    @if (isset($menu->visibleChildren) && count($menu->visibleChildren) > 0)
                    <div id="collapse_{{ $menu->route }}" class="collapse 
                    {{ in_array($menu->parent_show, [getParentShow($current_page), 
                                                     getParent($current_page)])
                         ? 'show' : '' }}"
                             aria-labelledby="heading_{{ $menu->route }}"
                              data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                
                 <!-- Sub-menu -->
 
                            @foreach($menu->visibleChildren as $subMenu)
                                    <a class="collapse-item" 

                                         href="{{ route('admin.' . $subMenu->as) }}">{{ $subMenu->display_name }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </li>
            @endif
        @endforeach
    @endrole






                                        <!---------- Editor ------------------------>











    @role(['editor'])
    @foreach($Main_menu as $menu)
        @permission($menu->name)
        @if (count($menu->visibleChildren) == 0)


<!-- active -->

<li class="nav-item {{ $menu->id == getParentShow($current_page) ? 'active' : '' }}">

<!-- route -->


    <a href="{{ route('admin.'. $menu->as) }}" class="nav-link">

<!-- name -->

    <span>{{ $menu->display_name }}</span>
    <i class="{{ $menu->icon != null ? $menu->icon : 'fa fa-home' }}"></i>

    </a>
</li>

<hr class="sidebar-divider">

@else

  <!-- active -->

<li class="nav-item 
{{ in_array($menu->parent_show, [getParentShow($current_page), getParent($current_page)])
     ? 'active' : '' }}">
  <!-- collapse -->

    <a class="nav-link 
    {{ in_array($menu->parent_show, [getParentShow($current_page), getParent($current_page)])
         ? 'collapsed' : '' }}" 
         href="#" data-toggle="collapse" data-target="#collapse_{{ $menu->route }}"
          aria-expanded="true" 
            aria-controls="collapse_{{ $menu->route }}">

     <!-- name -->

        <span>{{ $menu->display_name }}</span>

     <!-- icon -->


        <i class="{{ $menu->icon != null ? $menu->icon : 'fa fa-home' }}"></i>
       


    </a>
    @if (isset($menu->visibleChildren) && count($menu->visibleChildren) > 0)
    <div id="collapse_{{ $menu->route }}" class="collapse 
    {{ in_array($menu->parent_show, [getParentShow($current_page), getParent($current_page)])
         ? 'show' : '' }}"
             aria-labelledby="heading_{{ $menu->route }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                
 <!-- Sub-menu -->

            @foreach($menu->visibleChildren as $subMenu)
                    <a class="collapse-item" 

                         href="{{ route('admin.' . $subMenu->as) }}">{{ $subMenu->display_name }}</a>
                @endforeach
            </div>
        </div>
    @endif
</li>
@endif
        @endpermission
     @endforeach
    @endrole



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->









