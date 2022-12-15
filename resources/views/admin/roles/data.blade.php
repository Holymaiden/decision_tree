@foreach ($data as $key => $v)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $v->role }}</td>
        <td>{{ $v->role_name }}</td>
        <td>
            {!! Helper::btn_action($v->id, $title) !!}
        </td>
    </tr>
@endforeach
