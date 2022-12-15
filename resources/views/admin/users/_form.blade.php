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
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" id="username" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" id="email" required/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" id=""/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Role User</label>
                            <select class="form-control selectric" id="role_id" name="role_id"
                                    style="width:100%">
                                @foreach(Helper::get_data('roles') as $v)
                                    <option value="{{$v->id}}">{{$v->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Active</label>
                            <select class="form-control selectric" id="active" name="active"
                                    style="width:100%">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
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
                    $('#name').val(data.name);
                    $('#username').val(data.username);
                    $('#email').val(data.email);
                    $('#role_id').val(data.role_id).trigger('change');
                    $('#active').val(data.active).trigger('change');
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
