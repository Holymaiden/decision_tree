<div class="modal fade" id="ajaxModel1" role="dialog" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Obat Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="transaksi_obat" class="row">
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('jsScriptAjax')
<script type="text/javascript">
    //Tampilkan form edit
    function detailForm(id) {
        let urlx = "{{ $title }}"
        $.ajax({
            url: urlx + '/' + id + '/edit',
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#ajaxModel1').modal('show');
                $('#transaksi_obat').empty();
                data.detail.map((item, index) => {
                    // append item to html
                    $('#transaksi_obat').append(`<div class="col-3"><div class="product-item"><div class="product-image"><img alt="image" src="{{ url("/public/uploads/drug") }}/${item.obat.image}" class="img-fluid"></div><div class="product-details"><div class="product-name">${item.obat.name}</div><div class="text-muted text-small">${item.quantity} Terjual</div><div class="product-name">Rp. ${item.price.toLocaleString('id-ID')}</div></div></div></div>`)
                });
            },
            error: function() {
                iziToast.error({
                    title: 'Failed,',
                    message: 'Unable to display data!',
                    position: 'topRight'
                });
            }
        });
    }
</script>
@endpush