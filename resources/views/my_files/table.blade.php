<table class="table table-responsive" id="myFiles-table">
    <thead>
        <th>Project Id</th>
        <th>Title</th>
        <th>Slug</th>
        <th>Url</th>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($myFiles as $myFile)
        <tr>
            <td>{!! $myFile->project_id !!}</td>
            <td>{!! $myFile->title !!}</td>
            <td>{!! $myFile->slug !!}</td>
            <td>{!! $myFile->url !!}</td>
            <td>{!! $myFile->name !!}</td>
            <td>
                {!! Form::open(['route' => ['myFiles.destroy', $myFile->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('myFiles.show', [$myFile->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('myFiles.edit', [$myFile->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>