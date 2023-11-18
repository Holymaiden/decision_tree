<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Invoice &mdash; Stisla</title>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <!-- CSS Libraries -->

        <!-- Template CSS -->
        <link type="text/css" rel="stylesheet" href="{{ public_path('stisla/assets/css/style.css') }}" media="dompdf">
        <link type="text/css" rel="stylesheet" href="{{ public_path('stisla/assets/css/components.css') }}" media="dompdf">
</head>

<body>
        <div id="app">
                <section class="section">
                        <!-- Main Content -->
                        <div class="container mt-5">
                                <section class="section">
                                        <div class="section-body">
                                                <div class="invoice">
                                                        <div class="invoice-print">
                                                                <div class="row">
                                                                        <div class="col-lg-12">
                                                                                <div class="invoice-title">
                                                                                        <h2>Invoice</h2>
                                                                                        <div class="invoice-number"></div>
                                                                                </div>
                                                                                <hr />
                                                                                <div class="row">
                                                                                        <div class="col-md-6">
                                                                                                <address>
                                                                                                        <strong>Nama Pembeli: </strong> {{ $transactionNew->name }}
                                                                                                </address>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>

                                                                <div class="row mt-4">
                                                                        <div class="col-md-12">
                                                                                <div class="section-title">Daftar Obat</div>
                                                                                <div class="table-responsive">
                                                                                        <table class="table table-striped table-hover table-md">
                                                                                                <tr>
                                                                                                        <th data-width="40">#</th>
                                                                                                        <th>Obat</th>
                                                                                                        <th class="text-center">Quantity</th>
                                                                                                        <th class="text-right">Totals</th>
                                                                                                </tr>
                                                                                                @foreach ($transactionNew->detail as $i => $v)
                                                                                                <tr>
                                                                                                        <td>{{ $i + 1 }}</td>
                                                                                                        <td>{{ $v->obat->name }}</td>
                                                                                                        <td class="text-center"> {{ $v->quantity }}</td>
                                                                                                        <td class="text-right">Rp. {{ number_format($v->price, 0, ',', '.') }}</td>
                                                                                                </tr>
                                                                                                @endforeach
                                                                                        </table>
                                                                                </div>
                                                                                <div class="row mt-4">
                                                                                        <div class="col-lg-8">
                                                                                                <div class="section-title">Pembayaran</div>
                                                                                                <div class="col-lg-4 text-right">
                                                                                                        <div class="invoice-detail-item">
                                                                                                                <div class="invoice-detail-name">Total</div>
                                                                                                                <div class="invoice-detail-value">Rp. {{ number_format($transactionNew->total_price, 0, ',', '.') }}</div>
                                                                                                        </div>
                                                                                                        <div class="invoice-detail-item">
                                                                                                                <div class="invoice-detail-name">Tunai</div>
                                                                                                                <div class="invoice-detail-value">Rp. {{ number_format($transactionNew->tunai, 0, ',', '.') }}</div>
                                                                                                        </div>
                                                                                                        <hr class="mt-2 mb-2" />
                                                                                                        <div class="invoice-detail-item">
                                                                                                                <div class="invoice-detail-name">Sisa Tunai</div>
                                                                                                                <div class="invoice-detail-value invoice-detail-value-lg">
                                                                                                                        Rp. {{ number_format(($transactionNew->tunai - $transactionNew->total_price), 0, ',', '.') }}
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                </section>
                        </div>
                </section>
        </div>

        <!-- General JS Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="{{ public_path('stisla/assets/js/stisla.js') }}"></script>

        <!-- JS Libraies -->

        <!-- Template JS File -->
        <script src="{{ public_path('stisla/assets/js/scripts.js') }}"></script>
        <script src="{{ public_path('stisla/assets/js/custom.js') }}"></script>

        <!-- Page Specific JS File -->
</body>

</html>