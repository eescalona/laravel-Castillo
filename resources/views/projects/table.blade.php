<table class="table table-responsive" id="projects-table">
    <thead>
        <th>Title</th>
        <th>Year</th>
        <th>Category Id</th>
        <th>Style Id</th>
        <th>Price</th>
        <th>Description</th>
        <th>Address</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($projects as $project)
        <tr>
            <td>{!! $project->title !!}</td>
            <td>{!! $project->year !!}</td>
            <td>{!! $project->category_id !!}</td>
            <td>{!! $project->style_id !!}</td>
            <td>{!! $project->price !!}</td>
            <td>{!! $project->description !!}</td>
            <td>{!! $project->address !!}</td>
            <td>
                {!! Form::open(['route' => ['projects.destroy', $project->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('projects.show', [$project->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('projects.edit', [$project->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>