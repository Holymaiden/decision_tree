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
                        <div class="mb-5">
                            <!-- Search Button -->
                        </div>
                        <div class="row datatabel">
                        </div>

                        <div class="d-flex justify-content-center flex-wrap">
                            <div class="text-center">
                                <ul class="pagination twbs-pagination">
                                </ul>
                            </div>
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
        let urlx = "";

        $("#pilihan").on('change', function(event) {
            let pilih = $('#pilihan').val();
            if (pilih == '0') {
                $('#option').show();
            } else {
                $('#option').hide();
            }
        });

        loadpage('', 6);

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
                    "jml": jml,
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
                    "jml": jml,
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
                            loaddata(page, cari, jml);
                        }

                    }));
                }
            });
        }

        $("#btnSearch").on('click', function(event) {
            event.preventDefault();
            let cari = $('#pencarian').val();
            loadpage(cari, 6);
        });
    });
</script>
@endpush

@push('jsScriptAjax')
<script type="text/javascript">
    $(document).ready(function() {
        loadKataKunci('');

        function loadKataKunci(cari) {
            $.ajax({
                url: '/kata-kunci',
                data: {
                    "cari": cari,
                },
                type: "GET",
                datatype: "json",
                success: function(data) {
                    $(".search-result").html(`<div class="search-header">Kata Kunci</div>`);
                    data = data.filter((value, index, self) => index === self.findIndex((t) => (
                        t.type === value.type
                    )))
                    data.forEach(function(item) {
                        var search_result = $('.search-result');
                        search_result.append(
                            `<div class="search-item"><a onClick="setStringToPencarian('${item.type}');" href="#">${item.type}</a></div>`
                        );
                    });
                }
            });
        }

        $('#pencarian').on('keyup', function() {
            let cari = $('#pencarian').val();
            loadKataKunci(cari);
        })
    })

    function setStringToPencarian(string) {
        console.log(string);
        $('#pencarian').val(string);
        $('#pencarian').focus();
        $('#btnSearch').click();
    }
</script>
@endpush