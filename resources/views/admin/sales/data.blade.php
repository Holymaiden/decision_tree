@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->detail->name }}</td>
    <td>{{ number_format($v->total_sale, 0, ',', '.'); }}</td>
    <td>{{ Helper::changeDate($v->date) }}</td>
    <td>
        {!! Helper::btn_action(1,1,$v->id) !!}
    </td>
</tr>
@endforeach