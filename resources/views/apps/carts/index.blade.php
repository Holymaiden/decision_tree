@extends('apps._layouts.index')

@push('cssScript')
@include('apps._layouts.css.css-table')
@endpush

@push($title)
active
@endpush

@section('content')

<section class="section">

    <div class="section-body">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="datatabel">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('jsScript')
@include('apps._layouts.js.js-table')

<script type="text/javascript">
    $(document).ready(function() {
        let urlx = "carts";

        loaddata();

        function loaddata() {
            $.ajax({
                url: urlx + '/data',
                type: "GET",
                datatype: "json",
                success: function(data) {
                    $(".datatabel").html(data.html);
                    if (data.drug_minus.length != 0) {
                        let obat = data.drug_minus.join(", ")
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Obat ' + obat + " Melebihi Batas Stok",

                        })
                    }
                }
            });
        }

        $('body').on('click', '.deleteData', function() {
            var id = $(this).data("id");
            swal({
                    title: 'Are you sure?',
                    text: 'You want to delete this data!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: {
                        confirm: {
                            text: 'Yes, delete it!',
                            className: 'btn btn-success'
                        },
                        cancel: {
                            visible: true,
                            className: 'btn btn-danger'
                        }
                    }
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: urlx + '/' + id,
                            success: function(data) {
                                loaddata();
                                iziToast.success({
                                    title: 'Successfull.',
                                    message: 'Delete it data!',
                                    position: 'topRight',
                                    timeout: 1500
                                });
                            },
                            error: function(data) {
                                iziToast.error({
                                    title: 'Failed,',
                                    message: 'Delete it data!',
                                    position: 'topRight',
                                    timeout: 1500
                                });
                            }
                        });
                    } else {
                        swal.close();
                    }
                });
        });

    });
</script>
@endpush