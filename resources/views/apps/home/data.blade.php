@foreach ($data as $key => $v )
<div class="col-12 col-sm-6 col-md-6 col-lg-3">
    <article class="article article-style-b">
        <div class="article-header">
            <div class="article-image" data-background="{{ url('/public/uploads/drug') }}/{{ $v->image }}" style="background-image: url('{{ url('/public/uploads/drug') }}/{{ $v->image }}')">
            </div>
            <div class="article-title">
                <h2 style="color:white">{{ ucfirst($v->name) }}</h2>
            </div>
        </div>
        <div class="article-details">
            <p>{{ ucfirst($v->description) }}</p>
            <div class="article-cta">
                @if ($v->quantity == 0)
                <button class="btn btn-secondary" disabled>Habis</button>
                @else
                <button class="btn btn-primary" onClick="tambah_cart({{$v->id}})" id="btn-tambah">Tambah</button>
                @endif
            </div>
        </div>
    </article>
</div>
@endforeach

<script type="text/javascript">
    function tambah_cart(id) {
        $.ajax({
            type: "POST",
            url: "{{ route('carts.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(data) {
                if (data.code == 400) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Stok Obat Tidak Cukup!',
                        position: 'topRight'
                    });
                    let button
                } else
                    iziToast.success({
                        title: 'Success',
                        message: 'Berhasil Ditambahkan Di Keranjang!',
                        position: 'topRight'
                    });
            },
        });
    };
</script>