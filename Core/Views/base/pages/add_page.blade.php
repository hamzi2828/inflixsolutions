@extends('core::base.layouts.master')

@section('title')
    {{ translate('Add Page') }}
@endsection

@section('custom_css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/select2/select2.min.css') }}">
    <!--  End select2  -->
    <!--Editor-->
    <link href="{{ asset('/public/backend/assets/plugins/summernote/summernote-lite.css') }}" rel="stylesheet" />
    <!--End editor-->
@endsection

@section('main_content')
    <!-- Main Content -->

    <form class="form-horizontal my-4 mb-4" id="page_form" action="{{ route('core.page.store') }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="page_id" name="id" value="">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-30">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4 class="font-20">{{ translate('Add Page') }}</h4>
                        </div>
                        {{-- Title Field --}}
                        <div class="form-group row my-4">
                            <label for="title"
                                class="col-sm-2 font-14 bold black mb-2">{{ translate('Page Title') }}<span
                                    class="text-danger"> * </span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="title" id="title" class="form-control page_title"
                                    value="{{ old('title') }}" placeholder="{{ translate('Add Title') }}" required>
                                <input type="hidden" name="permalink" id="permalink_input_field" required
                                    value="{{ old('permalink') }}">
                                @if ($errors->has('title'))
                                    <p class="text-danger">{{ $errors->first('title') }}</p>
                                @endif
                            </div>
                        </div>
                        {{-- Title Field End --}}
                        <!--Permalink-->
                        <div
                            class="form-row my-4 permalink-input-group d-none @if ($errors->has('permalink')) d-flex @endif">
                            <div class="col-sm-2">
                                <label class="font-14 bold black">{{ translate('Permalink') }} </label>
                            </div>
                            <div class="col-sm-10">
                                <a href="#" onclick="pagePreviewDraft('preview')">{{ url('') }}/page/<span
                                        id="permalink">{{ old('permalink') }}</span><span
                                        class="btn custom-btn ml-1 permalink-edit-btn">{{ translate('Edit') }}</span></a>
                                @if ($errors->has('permalink'))
                                    <div class="invalid-input">{{ $errors->first('permalink') }}</div>
                                @endif
                                <div class="permalink-editor d-none">
                                    <input type="text" class="theme-input-style" id="permalink-updated-input"
                                        placeholder="{{ translate('Type here') }}" value="{{ old('permalink') }}">
                                    <button type="button" class="btn long mt-2 btn-danger permalink-cancel-btn"
                                        data-dismiss="modal">{{ translate('Cancel') }}</button>
                                    <button type="button"
                                        class="btn long mt-2 permalink-save-btn">{{ translate('Save') }}</button>
                                </div>
                            </div>
                        </div>
                        <!--Permalink End-->

                        {{-- Content Field --}}
                        <div class="form-row mt-5">
                            <label class="col-sm-2 font-14 bold black">{{ translate('Content') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="editor-wrap">
                                    <textarea name="content" id="page_content">{{ old('content') }}</textarea>
                                </div>
                                @if ($errors->has('content'))
                                    <p class="text-danger"> {{ $errors->first('content') }} </p>
                                @endif
                            </div>
                        </div>
                        {{-- Content Field End --}}
                    </div>
                </div>
                {{-- Seo Information --}}
                <div class="card card-body mb-4">
                    <h4 class="mb-5 font-20">{{ translate('Seo Meta Tags') }}</h4>
                    <div class="form-row mb-20">
                        <div class="col-sm-2">
                            <label class="font-14 bold black ">{{ translate('Meta Title') }} </label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="meta_title" class="theme-input-style"
                                placeholder="{{ translate('Type here') }}" value="{{ old('meta_title') }}">
                            @if ($errors->has('meta_title'))
                                <div class="invalid-input">{{ $errors->first('meta_title') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row mb-20">
                        <div class="col-sm-2">
                            <label class="font-14 bold black ">{{ translate('Meta Description') }} </label>
                        </div>
                        <div class="col-sm-10">
                            <textarea class="theme-input-style" name="meta_description">{{ old('meta_description') }}</textarea>
                            @if ($errors->has('meta_description'))
                                <div class="invalid-input">{{ $errors->first('meta_description') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row mb-20">
                        <div class="col-sm-2">
                            <label class="font-14 bold black ">{{ translate('Meta Image') }} </label>
                        </div>
                        <div class="col-sm-10">
                            @include('core::base.includes.media.media_input', [
                                'input' => 'meta_image',
                                'data' => old('meta_image'),
                            ])
                            @if ($errors->has('meta_image'))
                                <div class="invalid-input">{{ $errors->first('meta_image') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Seo Information End --}}
            </div>

            {{-- Add Page Side Field --}}
            <div class="col-md-4">
                <div class="row px-3">
                    {{-- Publish Section --}}
                    <div class="card card-body col-12 order-last order-md-first mt-5 mt-md-0">
                        <h4 class="font-16">{{ translate('Publish') }}</h4>
                        {{-- Draft,previe,pending button --}}
                        <div class="row my-4 mx-1 justify-content-between ">
                            <div>
                                <a href="#" class="btn btn-dark sm mr-2"
                                    onclick="pagePreviewDraft('draft')">{{ translate('Draft') }}</a>
                            </div>
                            <a href="#" class="btn btn-info sm mr-2"
                                onclick="pagePreviewDraft('preview')">{{ translate('Preview') }}</a>
                        </div>
                        {{-- visibility part --}}
                        <input type="hidden" name="visibility" id="visibility-radio-public" value="public" />
                        {{-- visibility part end --}}

                        {{-- publish schedule part --}}
                        <div class="row my-2 mx-1">
                            <i class="icofont-ui-calendar icofont-1x mt-2"></i>
                            <span class="font-14 black ml-1 mt-2">{{ translate('Publish') }} :</span>
                            <input type="datetime-local" name="publish_at" class="theme-input-style w-75 ml-2 py-0"
                                value="{{ old('publish_at') }}">
                            @if ($errors->has('visibility'))
                                <div class="invalid-input">{{ $errors->first('publish_at') }}</div>
                            @endif
                        </div>
                        {{-- publish schedule part end --}}
                        <div class="row mx-1 mt-4">
                            <button type="submit" class="col-sm-3 btn sm">{{ translate('Publish') }}</button>
                        </div>
                    </div>
                    {{-- Publish Section End --}}

                    {{-- Page Attributes --}}
                    <div class="card card-body mt-5 mt-md-5 col-12">
                        <h4 class="font-16 mb-2">{{ translate('Page Attributes') }}</h4>
                        <div class="form-group row my-2">
                            <label for="page_parent" class="col-sm-4 font-14 bold black">{{ translate('Parents') }}
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="page_parent" id="page_parent">
                                    <option value="">{{ translate('Select a Parent Page') }}</option>
                                    @foreach ($pages as $page)
                                        <option value="{{ $page->id }}">
                                            @php
                                                $tlpage = Core\Models\TlPage::where('id', $page->id)->first();
                                            @endphp
                                            {{ $tlpage->translation('title', getLocale()) }}
                                        </option>
                                        @if (count($tlpage->childs))
                                            @include('core::base.pages.includes.page_child', [
                                                'child_page' => $tlpage->childs,
                                                'label' => 1,
                                                'parent' => null,
                                            ])
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('page_parent'))
                                <div class="invalid-input">{{ $errors->first('page_parent') }}</div>
                            @endif
                        </div>
                    </div>
                    {{-- Page Attributes End --}}

                    {{-- Featured Image --}}
                    <div class="card card-body mt-5 col-12">
                        <h4 class="font-16">{{ translate('Featured Image') }}<span class="text-danger">*</span></h4>
                        <div class="form-group row justify-content-center align-items-center mt-4">
                            <div class="col-sm-4">
                                @include('core::base.includes.media.media_input', [
                                    'input' => 'page_image',
                                    'data' => old('page_image'),
                                ])
                                @if ($errors->has('page_image'))
                                    <div class="invalid-input">{{ $errors->first('page_image') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Page Image End --}}
                </div>
            </div>
            {{-- Add Page Side Field End --}}
        </div>
    </form>
    @include('core::base.media.partial.media_modal')
    <!-- End Main Content -->
@endsection


@section('custom_scripts')
    <!--Select2-->
    <script src="{{ asset('/public/backend/assets/plugins/select2/select2.min.js') }}"></script>
    <!--End Select2-->
    <!--Editor-->
    <script src="{{ asset('/public/backend/assets/plugins/summernote/summernote-lite.js') }}"></script>
    <!--End Editor-->

    <script>
        (function($) {
            "use strict";
            initDropzone()
            $(document).ready(function() {
                is_for_browse_file = true
                filtermedia()

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                // SUMMERNOTE INIT
                $('#page_content').summernote({
                    tabsize: 2,
                    height: 200,
                    codeviewIframeFilter: false,
                    codeviewFilter: true,
                    codeviewFilterRegex: /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*>|on\w+\s*=\s*"[^"]*"|on\w+\s*=\s*'[^']*'|on\w+\s*=\s*[^\s>]+/gi,
                    toolbar: [
                        ["style", ["style"]],
                        ["font", ["bold", "underline", "clear"]],
                        ["color", ["color"]],
                        ["para", ["ul", "ol", "paragraph"]],
                        ["table", ["table"]],
                        ["insert", ["link", "picture", "video"]],
                        ["view", ["fullscreen", "codeview", "help"]],
                    ],
                    placeholder: 'Page Content',
                    callbacks: {
                        onImageUpload: function(images, editor, welEditable) {
                            sendFile(images[0], editor, welEditable);
                        },
                        onChangeCodeview: function(contents, $editable) {
                            let code = $(this).summernote('code')
                            code = code.replace(
                                /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*>|on\w+\s*=\s*"[^"]*"|on\w+\s*=\s*'[^']*'|on\w+\s*=\s*[^\s>]+/gi,
                                '')
                            $(this).val(code)
                        }
                    }
                });

                $('#page_parent').select2({
                    theme: "classic",
                });
                $('#page_template').select2({
                    theme: "classic",
                });
            });

            /*Generate permalink*/
            $(".page_title").change(function(e) {
                e.preventDefault();
                let name = $(".page_title").val();
                let permalink = string_to_slug(name);
                $("#permalink").html(permalink);
                $("#permalink_input_field").val(permalink);
                $(".permalink-input-group").removeClass("d-none");
                $(".permalink-editor").addClass("d-none");
                $(".permalink-edit-btn").removeClass("d-none");
            });
            /*edit permalink*/
            $(".permalink-edit-btn").on("click", function(e) {
                e.preventDefault();
                let permalink = $("#permalink").html();
                $("#permalink-updated-input").val(permalink);
                $(".permalink-edit-btn").addClass("d-none");
                $(".permalink-editor").removeClass("d-none");
            });
            /*Cancel permalink edit*/
            $(".permalink-cancel-btn").on("click", function(e) {
                e.preventDefault();
                $("#permalink-updated-input").val();
                $(".permalink-editor").addClass("d-none");
                $(".permalink-edit-btn").removeClass("d-none");
            });
            /*Update permalink*/
            $(".permalink-save-btn").on("click", function(e) {
                e.preventDefault();
                let input = $("#permalink-updated-input").val();
                let updated_permalnk = string_to_slug(input);
                $("#permalink_input_field").val(updated_permalnk);
                $("#permalink").html(updated_permalnk);
                $(".permalink-editor").addClass("d-none");
                $(".permalink-edit-btn").removeClass("d-none");
            });
        })(jQuery);

        // add new buttonn toogle -- function
        function ButtonToggle(button, form) {
            "use strict";
            $(button).on('click', function() {
                $(form).toggleClass('d-none');
            });
        }

        /**
         * Generate slug
         *
         */
        function string_to_slug(str) {
            "use strict";
            str = str.replace(/^\s+|\s+$/g, ""); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
            }

            str = str
                .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
                .replace(/\s+/g, "-") // collapse whitespace and replace by -
                .replace(/-+/g, "-"); // collapse dashes

            return str;
        }

        // page preview and draft
        function pagePreviewDraft(action) {
            "use strict";
            var formData = $('#page_form').serializeArray();
            formData.push({
                name: "action",
                value: action
            });

            $.ajax({
                method: 'POST',
                url: '{{ route('core.page.draft.preview') }}',
                dataType: 'json',
                data: formData
            }).done(function(response) {
                if (response.error) {
                    toastr.error(response.error, "Error!");
                } else {
                    switch (action) {
                        case 'draft':
                            $('#page_id').val(response.id);
                            toastr.success(response.success, "Success!");
                            break;
                        case 'preview':
                            $('#page_id').val(response.id);
                            window.open('/page-preview?page=' + response.permalink);
                            break;
                        default:
                            toastr.error(response.error, "Error!");
                            break;
                    }
                }
            });
        }

        // send file function summernote
        function sendFile(image, editor, welEditable) {
            "use strict";
            let imageUploadUrl = '{{ route('core.page.content.image') }}';
            let data = new FormData();
            data.append("image", image);

            $.ajax({
                data: data,
                type: "POST",
                url: imageUploadUrl,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.url) {
                        var image = $('<img>').attr('src', data.url);
                        $('#page_content').summernote("insertNode", image[0]);
                    } else {
                        toastr.error(data.error, "Error!");
                    }
                },
                error: function(data) {
                    toastr.error('Image Upload Failed', "Error!");
                }
            });
        }
    </script>
@endsection
