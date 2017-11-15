<table class="table table-responsive" id="projects-table">
    <thead>
        <th>Id</th>
        <th>Title</th>
        <th>Imagen principal</th>
        <th class="hidden-xs">Year</th>
        <th class="hidden-xs">Category</th>
        <th class="hidden-xs">Style</th>
        <th class="hidden-xs">Price</th>
        <th class="hidden-xs">Description</th>
        <th class="hidden-xs">Address</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($projects as $project)
        <tr>
            <td>{!! $project->id !!}</td>
            <td>{!! $project->title !!}</td>
            <td>{!! Html::image($project->image->url,$project->slug, array( 'width' => 70, 'height' => 70 )) !!}</td>
            <td class="hidden-xs">{!! $project->year !!}</td>
            <td class="hidden-xs">{!! $project->category->title !!}</td>
            <td class="hidden-xs">{!! $project->style !!}</td>
            <td class="hidden-xs">{!! $project->price !!}</td>
            <td class="hidden-xs">{!! $project->description !!}</td>
            <td class="hidden-xs">{!! $project->address !!}</td>
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