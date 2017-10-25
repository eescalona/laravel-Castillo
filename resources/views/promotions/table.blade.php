{{ $promotions->links() }}
<table class="table table-responsive" id="promotions-table">
    <thead>
        <tr>
            <th>Id</th>
        <th>Title</th>
        <th>Image</th>
        <th>Pdf</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($promotions as $promotion)
        <tr>
            <td>{!! $promotion->id !!}</td>
            <td>{!! $promotion->title !!}</td>
            <td>{!! Html::image($promotion->image->url,'alt', array( 'width' => 70, 'height' => 70 )) !!}</td>
            <td>{!! $promotion->pdf !!}</td>
            <td>
                {!! Form::open(['route' => ['promotions.destroy', $promotion->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('promotions.show', [$promotion->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $promotions->links() }}