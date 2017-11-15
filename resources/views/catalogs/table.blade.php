{{ $catalogs->links() }}
<table class="table table-responsive" id="catalogs-table">
    <thead>
        <th>Title</th>
        <th>Imagen</th>
        <th class="hidden-xs">Url</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($catalogs as $catalog)
        <tr>
            <td>{!! $catalog->title !!}</td>
            <td>{!! Html::image($catalog->image->url,'alt', array( 'width' => 70, 'height' => 70 )) !!}</td>
            <td class="hidden-xs">{!! $catalog->url !!}</td>
            <td>
                {!! Form::open(['route' => ['catalogs.destroy', $catalog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('catalogs.show', [$catalog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('catalogs.edit', [$catalog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $catalogs->links() }}