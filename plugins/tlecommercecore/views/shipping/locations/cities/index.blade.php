@extends('core::base.layouts.master')
@section('title')
    {{ translate('Cities') }}
@endsection
@section('custom_css')
@endsection
@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-30">
                <div class="card-body border-bottom2 mb-20">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="font-20">{{ translate('Cities') }}</h4>
                        <div class="d-flex flex-wrap">
                            <a href="{{ route('plugin.tlcommercecore.shipping.locations.cities.add.new') }}"
                                class="btn long">{{ translate('Add New City') }}</a>
                        </div>
                    </div>
                </div>
                <div class="px-2 filter-area d-flex align-items-center">
                    <!--Filter area-->
                    <form method="get" action="{{ route('plugin.tlcommercecore.shipping.locations.cities.list') }}">
                        <input type="text" name="search_key" class="theme-input-style mb-2"
                            value="{{ request()->has('search_key') ? request()->get('search_key') : '' }}"
                            placeholder="Enter city name">
                        <button type="submit" class="btn long">{{ translate('Filter') }}</button>
                    </form>

                    @if (request()->has('search_key'))
                        <a class="btn long btn-danger"
                            href="{{ route('plugin.tlcommercecore.shipping.locations.cities.list') }}">
                            {{ translate('Clear Filter') }}
                        </a>
                    @endif
                    <!--End filter area-->
                </div>
                <div class="table-responsive">
                    <table id="cities_table" class="hoverable text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('State') }}</th>
                                <th>{{ translate('Status') }}</th>
                                <th>{{ translate('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($cities->count() > 0)
                                @foreach ($cities as $key => $city)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $city->name }}</td>
                                        <td>{{ $city->state->name }}</td>
                                        <td>
                                            <label class="switch glow primary medium">
                                                <input type="checkbox" class="change-status"
                                                    data-city="{{ $city->id }}"
                                                    {{ $city->status == '1' ? 'checked' : '' }}>
                                                <span class="control"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="dropdown-button">
                                                <a href="#" class="d-flex align-items-center justify-content-end"
                                                    data-toggle="dropdown">
                                                    <div class="menu-icon mr-0">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a
                                                        href="{{ route('plugin.tlcommercecore.shipping.locations.cities.edit', $city->id) }}">
                                                        {{ translate('Edit') }}
                                                    </a>
                                                    <a href="#" class="delete-city"
                                                        data-city="{{ $city->id }}">{{ translate('Delete') }}</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">
                                        <p class="alert alert-danger text-center">{{ translate('Nothing found') }}</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="pgination px-3">
                        {!! $cities->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5-custom') !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--Delete Modal-->
    <div id="delete-modal" class="delete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to delete this') }}?</p>
                    <form method="POST" action="{{ route('plugin.tlcommercecore.shipping.locations.cities.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-city-id" name="id">
                        <button type="button" class="btn long btn-danger mt-2"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn long mt-2">{{ translate('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Delete Modal-->
@endsection
@section('custom_scripts')
    <script>
        (function($) {
            "use strict";
            /**
             * 
             * Change city status 
             * 
             * */
            $('.change-status').on('click', function(e) {
                e.preventDefault();
                let $this = $(this);
                let id = $this.data('city');
                $.post('{{ route('plugin.tlcommercecore.shipping.locations.cities.status.change') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                }, function(data) {
                    location.reload();
                })
            });
            /**
             * 
             * Delete city
             * 
             * */
            $('.delete-city').on('click', function(e) {
                e.preventDefault();
                let $this = $(this);
                let id = $this.data('city');
                $("#delete-city-id").val(id);
                $('#delete-modal').modal('show');
            });
        })(jQuery);
    </script>
@endsection
