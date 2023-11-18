@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->name }}</td>
    <td>Rp. {{ number_format($v->total_price, 0, ',', '.'); }}</td>
    <td>Rp. {{ number_format($v->tunai, 0, ',', '.'); }}</td>
    <td>{{ Helper::changeDate($v->date) }}</td>
    <td>
        <a onclick="formPdf('{{$v->pdf}}')" class="">
            <button type="button" class="btn btn-icon btn-round btn-success btn-sm">
                <i class="fa fa-file-pdf"></i>
            </button>
        </a>
    </td>
    <td>
        <a onclick="detailForm('{{$v->id}}')" class="">
            <button type="button" class="btn btn-icon btn-round btn-success btn-sm">
                <i class="fa fa-capsules"></i>
            </button>
        </a>
    </td>
    <td>
        {!! Helper::btn_action(1,1,$v->id) !!}
    </td>
</tr>
@endforeach