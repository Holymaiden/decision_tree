<div class="modal fade" id="ajaxModel" role="dialog" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="formInput" name="formInput" action="">
                @csrf
                <input name="_method" type="hidden" id="methodId">
                <input type="hidden" name="id" id="formId">
                <div class="modal-header">
                    <h5 class="modal-title"> <label id="headForm"></label> Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="name" id="name" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Deskripsi</label>
                            <textarea rows="10" style="height:100px" class="form-control" name="description" id="description" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Harga</label>
                            <input type="number" class="form-control" name="price" id="price" required />
                        </div>
                    </div>
                    {{-- <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Golongan Obat</label>
                            <select class="form-control" name="category" id="category" required>
                                <option value="">-- Pilih Golongan Obat --</option>
                                <option value="bebas">Bebas</option>
                                <option value="bebas terbatas">Bebas Terbatas</option>
                                <option value="keras">Keras</option>
                                <option value="wajib apotek">Wajib Apotek</option>
                                <option value="psikotropika">Psikotropika</option>
                                <option value="narkotika">Narkotika</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Tipe</label>
                            <input type="text" class="form-control" name="type" id="type" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Gambar</label>
                            <input type="file" class="form-control" name="image" id="image" required />
                            <input type="hidden" name="image_old" id="image_old" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="saveBtn" value="create">Save</button>
                    <button type="submit" class="btn btn-success" id="updateBtn" value="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('jsScriptAjax')
    <script type="text/javascript">
        //Tampilkan form input
        function createForm() {
            $('#formInput').trigger("reset");
            $("#headForm").empty();
            $("#headForm").append("Form Input");
            $('#saveBtn').show();
            $('#updateBtn').hide();
            $('#formId').val('');
            $('#ajaxModel').modal('show');
            $('#methodId').val('POST');
            $('#category').val('').trigger('change');
        }

        //Tampilkan form edit
        function editForm(id) {
            let urlx = "{{ $title }}"
            $.ajax({
                url: urlx + '/' + id + '/edit',
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $("#headForm").empty();
                    $("#headForm").append("Form Edit");
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('show');
                    $('#methodId').val('PUT');
                    $('#saveBtn').hide();
                    $('#updateBtn').show();
                    $('#formId').val(data.id);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#price').val(data.price);
                    $('#type').val(data.type);
                    $('#image_old').val(data.image);
                    $('#quantity').val(data.quantity);
                    $('#category').val(data.category).trigger('change');
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
