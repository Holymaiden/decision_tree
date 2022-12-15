<script type="text/javascript">
    $(document).ready(function() {
        let urlx = "{{ $title }}";

        $("#pilihan").on('change', function(event) {
            let pilih = $('#pilihan').val();
            if (pilih == '0') {
                $('#option').show();
            } else {
                $('#option').hide();
            }
        });

        loadpage('', "{{config('constants.PAGINATION')}}");

        var $pagination = $('.twbs-pagination');
        var defaultOpts = {
            totalPages: 1,
            prev: '&#8672;',
            next: '&#8674;',
            first: '&#8676;',
            last: '&#8677;',
        };
        $pagination.twbsPagination(defaultOpts);

        function loaddata(page, cari, jml) {
            $.ajax({
                url: urlx + '/data',
                data: {
                    "page": page,
                    "cari": cari,
                    "jml": jml
                },
                type: "GET",
                datatype: "json",
                success: function(data) {
                    $(".datatabel").html(data.html);
                }
            });
        }

        function loadpage(cari, jml) {
            $.ajax({
                url: urlx + '/data',
                data: {
                    "cari": cari,
                    "jml": jml
                },
                type: "GET",
                datatype: "json",
                success: function(response) {
                    console.log(response);
                    if ($pagination.data("twbs-pagination")) {
                        $pagination.twbsPagination('destroy');
                        $(".datatabel").html('<tr><td colspan="8">Data not found</td></tr>');
                    }
                    $pagination.twbsPagination($.extend({}, defaultOpts, {
                        startPage: 1,
                        totalPages: response.total_page,
                        visiblePages: 8,
                        prev: '&#8672;',
                        next: '&#8674;',
                        first: '&#8676;',
                        last: '&#8677;',
                        onPageClick: function(event, page) {
                            if (page == 1) {
                                var to = 1;
                            } else {
                                var to = page * jml - (jml - 1);
                            }
                            if (page == response.total_page) {
                                var end = response.total_data;
                            } else {
                                var end = page * jml;
                            }
                            $('#contentx').text('Showing ' + to + ' to ' + end + ' of ' + response.total_data + ' entries');
                            loaddata(page, cari, jml);
                        }

                    }));
                }
            });
        }

        $("#pencarian, #jumlah").on('keyup change', function(event) {
            let cari = $('#pencarian').val();
            let jml = $('#jumlah').val();
            loadpage(cari, jml);
        });

        // proses simpan
        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $.ajax({
                data: $('#formInput').serialize(),
                url: "{{ route($title.'.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    loadpage('', "{{config('constants.PAGINATION')}}");
                    iziToast.success({
                        title: 'Successfull.',
                        message: 'Save it data!',
                        position: 'topRight',
                        timeout: 1500
                    });
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    iziToast.error({
                        title: 'Failed,',
                        message: 'Save it data!',
                        position: 'topRight',
                        timeout: 1500
                    });
                }
            });
        });

        // proses update
        $('#updateBtn').click(function(e) {
            let id = $('#formId').val();
            e.preventDefault();
            $.ajax({
                data: $('#formInput').serialize(),
                url: urlx + '/' + id,
                type: "PUT",
                dataType: 'json',
                success: function(data) {
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    loadpage('', "{{config('constants.PAGINATION')}}");
                    iziToast.success({
                        title: 'Successfull,',
                        message: 'Update it data!',
                        position: 'topRight',
                        timeout: 1500
                    });
                },
                error: function(data) {
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    iziToast.error({
                        title: 'Failed.',
                        message: 'Update it data!',
                        position: 'topRight',
                        timeout: 1500
                    });
                }
            });
        });

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
                                loadpage('', "{{config('constants.PAGINATION')}}");
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