@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->name }}</td>
    <td>{{ $v->description }}</td>
    <td>Rp. {{ number_format($v->price, 0, ',', '.'); }}</td>
    <td>{{ $v->quantity }}</td>
    <td>{{ ucfirst($v->category) }}</td>
    <td>{{ $v->type }}</td>
    <td>
        <img class="mr-3 rounded" width="80" src="{{ url('/public/uploads/drug') }}/{{ $v->image }}" alt="{{ $v->name }}">
    </td>
    <td>
        {!! Helper::btn_action(1,1,$v->id) !!}
    </td>
</tr>
@endforeach