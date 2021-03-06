<li class="{{ Request::is('home*') ? 'active' : '' }}">
    <a href="{{ url('/home') }}"><i class="fa fa-home"></i><span>Home</span></a>
</li>

<li class="{{ Request::is('projects*') ? 'active' : '' }}">
    <a href="{!! route('projects.index') !!}"><i class="fa fa-edit"></i><span>Projects</span></a>
</li>

<li class="{{ Request::is('promotions*') ? 'active' : '' }}">
    <a href="{!! route('promotions.index') !!}"><i class="fa fa-file-text-o"></i><span>Promotions</span></a>
</li>

<li class="{{ Request::is('mails*') ? 'active' : '' }}">
    <a href="{!! route('mails.index') !!}"><i class="fa fa-copy"></i><span>Mails</span></a>
</li>

<li class="{{ Request::is('catalogs*') ? 'active' : '' }}">
    <a href="{!! route('catalogs.index') !!}"><i class="fa fa-edit"></i><span>Catalogs</span></a>
</li>

<li class="{{ Request::is('blogs*') ? 'active' : '' }}">
    <a href="{!! route('blogs.index') !!}"><i class="fa fa-file-text-o"></i><span>Blogs</span></a>
</li>

<li class="{{ Request::is('register*') ? 'active' : '' }}">
    <a href="{{ route('user.admin.register.view') }}"><i class="fa fa-user"></i><span>Register New User</span></a>
</li>
<li class="{{ Request::is('gallery*') ? 'active' : '' }}">
    <a href="{{ route('gallery.view') }}"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
</li>


