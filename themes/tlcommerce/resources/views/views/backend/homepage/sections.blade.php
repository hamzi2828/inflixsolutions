@extends('core::base.layouts.master')
@section('title')
    {{ translate('Homepage Builder') }}
@endsection
@section('custom_css')
    <style>
        .ui-state-default {
            cursor: pointer;
        }
    </style>
@endsection
@section('main_content')
    <div class="border-bottom2 pb-3 mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-sm-2"><i class="icofont-ui-home mr-1"></i>{{ translate('Home Page Sections') }}</h4>
        <div class="d-flex flex-wrap">
            <a href="{{ route('theme.tlcommerce.home.page.sections.new') }}"
                class="btn long">{{ translate('Add New Section') }}</a>
        </div>
    </div>
    <div class="card mb-20 py-2">
        <div class="card-bod">
            <div class="payment-method-items">
                <div class="payment-method-item">
                    <div class="payment-method-item-header px-3 py-2">
                        <div class="d-flex align-items-center">
                            <div class="payment-logo">
                                <h5>Banner Slider
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-15">
                            <a href="{{ route('theme.tlcommerce.sliders') }}">
                                {{ translate('Manage Slider') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (count($sections) > 0)
        <div id="sortable">
            @foreach ($sections as $section)
                <div id="item-{{ $section->id }}" class="card mb-20 ui-state-default py-2">
                    <div class="card-bod">
                        <div class="payment-method-items">
                            <div class="payment-method-item">
                                <div class="payment-method-item-header px-3 py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="payment-logo">
                                            <h5><i
                                                    class="icofont-drag mr-1"></i>{{ getHomePageSectionProperties($section->id, 'title') }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-15">
                                        <a
                                            href="{{ route('theme.tlcommerce.home.page.sections.edit', ['id' => $section->id]) }}">
                                            <i class="icofont-ui-edit"></i>
                                        </a>
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" class="change-status" data-section="{{ $section->id }}"
                                                {{ $section->status == config('settings.general_status.active') ? 'checked' : '' }}>
                                            <span class="control"></span>
                                        </label>
                                        <a href="#" class="delete-section text-danger"
                                            data-section="{{ $section->id }}">
                                            <i class="icofont-ui-delete"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="alert alert-danger text-center">{{ translate('No Section Found') }}</p>
    @endif
    <!--Delete Modal-->
    <div id="delete-modal" class="delete-modal modal fade show" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to delete this section') }}?</p>
                    <form method="POST" action="{{ route('theme.tlcommerce.home.page.sections.remove') }}">
                        @csrf
                        <input type="hidden" id="delete-section-id" name="id">
                        <button type="button" class="btn long mt-2 btn-danger"
                            data-dismiss="modal">{{ translate('cancel') }}</button>
                        <button type="submit" class="btn long mt-2">{{ translate('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Delete Modal-->
@endsection
@section('custom_scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $("#sortable").sortable({
            update: function(e, u) {
                var data = $(this).sortable('serialize');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    url: '{{ route('theme.tlcommerce.home.page.sections.sorting') }}',
                    type: 'post',
                    data: data,
                    success: function(result) {
                        location.reload();
                    },
                    complete: function() {
                        location.reload();
                    }
                });
            }

        });
        /**
         * 
         * Delete section
         * 
         * */
        $('.delete-section').on('click', function(e) {
            e.preventDefault();
            let $this = $(this);
            let id = $this.data('section');
            $("#delete-section-id").val(id);
            $('#delete-modal').modal('show');
        });
        /**
         * 
         * Change  status 
         * 
         * */
        $('.change-status').on('click', function(e) {
            e.preventDefault();
            let $this = $(this);
            let id = $this.data('section');
            $.post('{{ route('theme.tlcommerce.home.page.sections.update.status') }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(data) {
                location.reload();
            })

        });
    </script>
@endsection
