<nav
    id="menu-{{ $menu->location }}"
    class="menu {{ $class ?? '' }}"
    role="navigation"
>
    <label
        class="menu-toggle"
        for="menu-{{ $menu->location }}-toggle"
    >
        <span class="icon"><i class="fa-solid fa-bars"></i></span>
        <span>{{ site()->trans('common.menu') }}</span>
    </label>

    <input
        class="menu-toggle-checkbox is-hidden"
        id="menu-{{ $menu->location }}-toggle"
        type="checkbox"
    />

    <ul>
        @foreach ($menu->root_items as $item)
            @include('menu.item', ['item' => $item, 'depth' => 0])
        @endforeach
    </ul>
</nav>
