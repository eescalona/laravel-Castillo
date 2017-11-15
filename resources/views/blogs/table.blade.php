{{ $blogs->links() }}
<table class="table table-responsive" id="blogs-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Imagen</th>
            <th class="hidden-xs">Description</th>
            <th class="hidden-xs">Tags</th>
            <th class="hidden-xs">Url</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($blogs as $blog)
        <tr>
            <td>{!! $blog->id !!}</td>
            <td>{!! $blog->title !!}</td>
            <td>{!! Html::image($blog->image->url,'alt', array( 'width' => 70, 'height' => 70 )) !!}</td>
            <td class="hidden-xs">{!! $blog->description !!}</td>
            <td class="hidden-xs">{!! $blog->tags !!}</td>
            <td class="hidden-xs">{!! $blog->url !!}</td>
            <td>
                {!! Form::open(['route' => ['blogs.destroy', $blog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('blogs.show', [$blog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $blogs->links() }}