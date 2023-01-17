<div id="about-menu-accordion">
    @foreach($menuFooters as $menu)
        @if($menu->parent_id == null)
            <div class="card">
                <div class="card-header">
                    <a class="card-link" data-toggle="collapse" href="#collapse{{$menu->id}}">
                        {{$menu->title}}
                        <img class="icon float-right" src="{{ asset('vendor/buyer/Img/arrow-bottom.svg') }}">
                    </a>
                </div>
                <div id="collapse{{$menu->id}}" class="collapse " data-parent="#about-menu-accordion">
                    @foreach($menuFooters as $menuChildren)
                        @if($menuChildren->parent_id == $menu->id)
                            <div class="card-body">
                                <a href="{{$menuChildren->url}}">{{$menuChildren->title}}</a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach()

</div>
