<div class="invoice">
    <div class="invoice-print">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-title">
                    <h2>Keranjang Obat</h2>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <address>
                            <strong>Apoteker</strong><br>
                            {{ auth()->user()->username }}
                            <br>
                        </address>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <address>
                            <strong>Tanggal</strong><br>
                            {{Helper::changeDate(date('Y-m-d'))}}<br><br>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nama Pengunjung</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" id="pengunjung" class="form-control phone-number">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tunai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                </div>
                                <input type="number" id="tunai" class="form-control phone-number">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="section-title">Belanja</div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-md">
                        <tr>
                            <th data-width="40">#</th>
                            <th>Obat</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-right">Harga Satuan</th>
                            <th class="text-right">Harga Total</th>
                            <th class="text-center">Edit</th>
                        </tr>
                        @php $total = 0; @endphp
                        @foreach ($data as $i => $v)
                        @php $total += $v->total*$v->detail->price; @endphp
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $v->detail->name }}</td>
                            <td class="text-center">{{ $v->total }}</td>
                            <td class="text-right">Rp. {{ number_format($v->detail->price, 0, ',', '.'); }}</td>
                            <td class="text-right">Rp. {{ number_format($v->total*$v->detail->price, 0, ',', '.'); }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-icon icon-left" onClick="edit_obat({{ $v->id }},{{ $v->drug_id }},'minus')"><i class="fas fa-minus"></i></button>
                                <button class="btn btn-warning btn-icon icon-left" onClick="edit_obat({{ $v->id }},{{ $v->drug_id }},'delete')"><i class="fas fa-trash"></i></button>
                                <button class="btn btn-warning btn-icon icon-right" onClick="edit_obat({{ $v->id }},{{ $v->drug_id }},'plus')"><i class="fas fa-plus"></i></button>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-8">

                    </div>
                    <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                            <div class="invoice-detail-name">Total</div>
                            <div class="invoice-detail-value invoice-detail-value-lg">Rp. {{ number_format($total, 0, ',', '.'); }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="text-md-right">
        <div class="float-lg-left mb-lg-0 mb-3">
            <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $id . '" title="Delete" class="deleteData">
                <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
            </a>
        </div>
        <button class="btn btn-primary btn-icon icon-left" onClick="proses()"><i class="fas fa-credit-card"></i> Proses</button>
    </div>
</div>

<script type="text/javascript">
    let urlx = "carts";

    function tambah_cart($id) {
        $.ajax({
            type: "POST",
            url: "{{ route('carts.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: $id
            },
            success: function(data) {
                iziToast.success({
                    title: 'Success',
                    message: 'Berhasil Ditambahkan Di Keranjang!',
                    position: 'topRight'
                });
            },
            error: function(data) {
                iziToast.error({
                    title: 'Error',
                    message: 'Stok Obat Tidak Cukup!',
                    position: 'topRight'
                });
            }
        });
    };

    function loaddata() {
        $.ajax({
            url: urlx + '/data',
            type: "GET",
            datatype: "json",
            success: function(data) {
                $(".datatabel").html(data.html);
            }
        });
    }

    function edit_obat(id, drug_id, command) {
        $.ajax({
            url: urlx + "/update/" + id,
            type: "POST",
            dataType: "json",
            data: {
                _token: "{{ csrf_token() }}",
                command: command,
                drug_id: drug_id
            },
            success: function(data) {
                if (data.code == 400)
                    iziToast.error({
                        title: 'Error',
                        message: 'Stok Obat Tidak Cukup!',
                        position: 'topRight'
                    });
                else
                    iziToast.success({
                        title: 'Success',
                        message: 'Stok Obat Berhasil Diubah!',
                        position: 'topRight'
                    });
                loaddata();
            },
        });
    }

    function proses() {
        swal({
                title: 'Konfirmasi Transaksi',
                text: 'Kau yakin ingin konfirmasi transaksi?',
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    confirm: {
                        text: 'Ya, yakin!',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            })
            .then((willDelete) => {
                if ($('#pengunjung').val() == '') {
                    iziToast.error({
                        title: 'Error',
                        message: 'Nama Pengunjung Belum Terisi',
                        position: 'topRight'
                    });
                } else if ($('#tunai').val() == '') {
                    iziToast.error({
                        title: 'Error',
                        message: 'Tunai Belum Terisi',
                        position: 'topRight'
                    });
                } else {
                    if (willDelete) {
                        $.ajax({
                            url: urlx + "/proses/transaksi",
                            type: "POST",
                            datatype: "json",
                            data: {
                                _token: "{{ csrf_token() }}",
                                name: $("#pengunjung").val(),
                                tunai: $("#tunai").val(),
                            },
                            success: function(data) {
                                loaddata();
                                iziToast.success({
                                    title: 'Success',
                                    message: 'Berhasil Melakukan Transaksi!',
                                    position: 'topRight'
                                });
                                if (data.name_pdf != null)
                                    window.open("{{url('pdf')}}/" + data.name_pdf, '_blank');
                            }
                        });
                    } else {
                        swal.close();
                    }
                }
            });

    }
</script>