{{ $mails->links() }}
<table class="table table-responsive" id="mails-table">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Name</th>
            <th class="hidden-xs">Mail</th>
            <th class="hidden-xs">Phone</th>
            <th class="hidden-xs">Subject</th>
            <th class="hidden-xs">Body</th>
            <th colspan="1">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($mails as $mail)
        <tr>
            <td>{!! $mail->created_at->format('d-m-Y') !!}</td>
            <td>{!! $mail->name !!}</td>
            <td class="hidden-xs">{!! $mail->mail !!}</td>
            <td class="hidden-xs">{!! $mail->phone !!}</td>
            <td class="hidden-xs">{!! $mail->subject !!}</td>
            <td class="hidden-xs">{!! $mail->body !!}</td>
            <td>
                {!! Form::open(['route' => ['mails.destroy', $mail->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('mails.show', [$mail->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    {{--<a href="{!! route('mails.edit', [$mail->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>--}}
                    {{--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $mails->links() }}