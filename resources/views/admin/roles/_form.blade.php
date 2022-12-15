<div class="modal fade" id="ajaxModel" role="dialog" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="formInput" name="formInput" action="">
                @csrf
                <input type="hidden" name="id" id="formId">
                <div class="modal-header">
                    <h5 class="modal-title"> <label id="headForm"></label> {{ Helper::head($title) }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Role</label>
                            <input type="text" class="form-control" name="role" id="role" required/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Name Role</label>
                            <input type="text" class="form-control" name="role_name" id="role_name" required/>
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
        }

        //Tampilkan form edit
        function editForm(id) {
            let urlx = "{{ $title }}"
            $.ajax({
                url: urlx + '/' + id + '/edit',
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#headForm").empty();
                    $("#headForm").append("Form Edit");
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('show');
                    $('#saveBtn').hide();
                    $('#updateBtn').show();
                    $('#formId').val(data.id);
                    $('#role').val(data.role);
                    $('#role_name').val(data.role_name);
                },
                error: function () {
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
