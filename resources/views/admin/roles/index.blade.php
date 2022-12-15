@extends('admin._layouts.index')

@push('cssScript')
    @include('admin._layouts.css.css-table')
@endpush

@push('user-settings')
    active
@endpush

@push($title)
    active
@endpush

@section('content')

    <section class="section">

        @component('_card.head')
            {{ $title }}
        @endcomponent

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-form">
                                {!! Helper::btn_create($title) !!}
                            </div>
                        </div>
                        <div class="card-body">

                            @include('_card.filter')

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col" width="8%">No</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" width="12%">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody class="datatabel">
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="text-center">
                                    <div id="contentx"></div>
                                </div>
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

    @include('admin.'.$title.'._form')

@endsection

@push('jsScript')
    @include('admin._layouts.js.js-table')

    @include('_card.show_and_paging')
@endpush


