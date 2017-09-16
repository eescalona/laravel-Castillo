<li class="{{ Request::is('projects*') ? 'active' : '' }}">
    <a href="{!! route('projects.index') !!}"><i class="fa fa-edit"></i><span>Projects</span></a>
</li>

<li class="{{ Request::is('catalogs*') ? 'active' : '' }}">
    <a href="{!! route('catalogs.index') !!}"><i class="fa fa-edit"></i><span>Catalogs</span></a>
</li>

