@extends('core::base.layouts.master')
@section('title')
    {{ translate('Plugings') }}
@endsection
@section('custom_css')
@endsection
@section('main_content')
    <div class="align-items-center border-bottom2 d-flex flex-wrap gap-10 justify-content-between mb-4 pb-3">
        <h4><i class="icofont-plugin"></i> {{ translate('Plugings') }}</h4>
    </div>
    <div class="app-items">
        <div class="row">
            @foreach ($plugins as $plugin)
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-30">
                    <div class="app-item">
                        <div class="app-icon">
                            <img src="{{ asset('/plugins' . '/' . $plugin->location . '/banner.png') }}"
                                alt="{{ $plugin->name }}" />
                        </div>
                        <div class="app-details">
                            <h4 class="app-name">{{ $plugin->name }}</h4>
                        </div>
                        <div class="app-footer">
                            <div class="app-description" title="{{ $plugin->name }}">
                                {{ $plugin->description }}
                            </div>
                            <div class="app-author">
                                By:
                                <a href="{{ $plugin->url }}" target="_blank">{{ $plugin->author }}</a>
                            </div>
                            <div class="app-version">{{ translate('Version') }}: {{ $plugin->version }}</div>
                            <div class="app-actions">
                                @if ($plugin->is_activated == config('settings.general_status.active'))
                                    <button class="btn sm btn-warning btn-trigger-change-status deactive-plugin"
                                        data-plugin="{{ $plugin->id }}">
                                        {{ translate('Deactivate') }}
                                    </button>
                                @else
                                    <button class="btn sm btn-info btn-trigger-change-status active-plugin active-plugin"
                                        data-plugin="{{ $plugin->id }}">
                                        {{ translate('Activate') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <!--Deactive Modal-->
    <div id="deactive-modal" class="delete-modal modal fade show" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Deactive Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to deactive this plugin') }}?</p>
                    <form method="POST" action="{{ route('core.plugins.inactive') }}">
                        @csrf
                        <input type="hidden" id="deactive-plugin-id" name="id">
                        <button type="button" class="btn long mt-2 btn-danger"
                            data-dismiss="modal">{{ translate('Cencel') }}</button>
                        <button type="submit" class="btn long mt-2">{{ translate('Deactivate') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Deactive  Modal-->
    <!--Active Modal-->
    <div id="active-modal" class="delete-modal modal fade show" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('activate Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to active this plugin') }}?</p>
                    <form method="POST" action="{{ route('core.plugins.active') }}">
                        @csrf
                        <input type="hidden" id="active-plugin-id" name="id">
                        <button type="button" class="btn long mt-2 btn-danger"
                            data-dismiss="modal">{{ translate('Cencel') }}</button>
                        <button type="submit" class="btn long mt-2">{{ translate('Activate') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Active  Modal-->
@endsection
@section('custom_scripts')
    <script>
        /**
         * Deactive plugin
         * */
        $('.deactive-plugin').on('click', function(e) {
            "use strict";
            e.preventDefault();
            let $this = $(this);
            let id = $this.data('plugin');
            $("#deactive-plugin-id").val(id);
            $('#deactive-modal').modal('show');
        });
        /**
         * Activate plugin
         * */
        $('.active-plugin').on('click', function(e) {
            "use strict";
            e.preventDefault();
            let $this = $(this);
            let id = $this.data('plugin');
            $("#active-plugin-id").val(id);
            $('#active-modal').modal('show');
        });
    </script>
@endsection
