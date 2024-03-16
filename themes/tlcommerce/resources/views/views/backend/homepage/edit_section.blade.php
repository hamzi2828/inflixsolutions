@extends('core::base.layouts.master')
@section('title')
    {{ translate('Update Section') }}
@endsection
@section('custom_css')
    <style>
        .color-picker {
            width: 50px !important;
        }
    </style>
@endsection
@section('main_content')
    <div>
        <form action="{{ route('theme.tlcommerce.home.page.sections.update') }}" method="POST" class="row">
            @csrf
            <div class="col-lg-8">
                <div class="card mb-30">
                    <div class="card-header bg-white border-bottom2">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4>{{ translate('Section') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-row mb-20">
                            <div class="col-sm-12">
                                <select class="area-disabled layout theme-input-style" id="layout"
                                    onchange="selectLayout()" readonly>
                                    <option value="ads" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'ads')>
                                        {{ translate('Ads') }}
                                    </option>
                                    <option value="blogs" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'blogs')>
                                        {{ translate('Blogs') }}
                                    </option>
                                    @if (isActivePluging('flashdeal'))
                                        <option value="flashdeal" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'flashdeal')>
                                            {{ translate('Flash Deal') }}
                                        </option>
                                    @endif
                                    <option value="featured_product" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'featured_product')>
                                        {{ translate('Featured Product') }}
                                    </option>
                                    <option value="category_slider" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'category_slider')>
                                        {{ translate('Category Slider') }}
                                    </option>
                                    <option value="product_collection" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'product_collection')>
                                        {{ translate('Product Collection') }}
                                    </option>
                                    <option value="custom_product_section" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'custom_product_section')>
                                        {{ translate('Custom Product Section') }}
                                    </option>
                                </select>
                                @if ($errors->has('layout'))
                                    <div class="invalid-input">{{ $errors->first('layout') }}</div>
                                @endif
                            </div>
                            <div class="col-sm-12 mt-10">
                                <div
                                    class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'category_slider' ? 'category_slider' : 'd-none' }}">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/category_slide.png') }}">
                                </div>
                                <div
                                    class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'flashdeal' ? 'flashdeal' : 'd-none' }}">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/deals.png') }}">
                                </div>
                                <div
                                    class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'product_collection' ? 'product_collection' : 'd-none' }}">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/collections.png') }}">
                                </div>
                                <div
                                    class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'custom_product_section' ? 'custom_product_section' : 'd-none' }}">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/collections.png') }}">
                                </div>
                                <div
                                    class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'featured_product' ? 'featured_product' : 'd-none' }} ">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/featured_product.png') }}">
                                </div>
                                <div
                                    class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'blogs' ? 'blogs' : 'd-none' }} ">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/blog.png') }}">
                                </div>
                                <div
                                    class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'ads' ? 'ads' : 'd-none' }} ">
                                    <div class="selected_ads_layout row m-0">
                                        @include(
                                            'theme/tlcommerce::backend.homepage.ads_layout_options_edit',
                                            [
                                                'layout' => getHomePageSectionProperties(
                                                    $section_details->id,
                                                    'content'),
                                                'details' => $section_details,
                                            ]
                                        )
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="card mb-30">
                    <div class="card-header bg-white border-bottom2">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4>{{ translate('Section Properties') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="layout-options">
                            @if (getHomePageSectionProperties($section_details->id, 'layout') == 'product_collection')
                                @include('theme/tlcommerce::backend.homepage.collection_options_edit', [
                                    'details' => $section_details,
                                ])
                            @elseif(getHomePageSectionProperties($section_details->id, 'layout') == 'category_slider')
                                @include('theme/tlcommerce::backend.homepage.category_slider_option_edit', [
                                    'details' => $section_details,
                                ])
                            @elseif(getHomePageSectionProperties($section_details->id, 'layout') == 'flashdeal')
                                @include('theme/tlcommerce::backend.homepage.deal_option_edit', [
                                    'details' => $section_details,
                                ])
                            @elseif(getHomePageSectionProperties($section_details->id, 'layout') == 'featured_product')
                                @include(
                                    'theme/tlcommerce::backend.homepage.featured_product_options_edit',
                                    [
                                        'details' => $section_details,
                                    ]
                                )
                            @elseif(getHomePageSectionProperties($section_details->id, 'layout') == 'custom_product_section')
                                @include(
                                    'theme/tlcommerce::backend.homepage.custom_product_section_edit_option',
                                    [
                                        'details' => $section_details,
                                    ]
                                )
                            @elseif(getHomePageSectionProperties($section_details->id, 'layout') == 'blogs')
                                @include('theme/tlcommerce::backend.homepage.blogs_options_edit', [
                                    'details' => $section_details,
                                ])
                            @elseif(getHomePageSectionProperties($section_details->id, 'layout') == 'ads')
                                @include('theme/tlcommerce::backend.homepage.ads_option_edit', [
                                    'details' => $section_details,
                                ])
                            @endif
                        </div>
                        <input type="hidden" name="layout" class="layout-input"
                            value="{{ getHomePageSectionProperties($section_details->id, 'layout') }}">
                        <input type="hidden" name="id" class="layout-input" value="{{ $section_details->id }}">
                        <div class="form-row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn long">{{ translate('Save Changes') }}</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    @include('core::base.media.partial.media_modal')
@endsection
@section('custom_scripts')
    <script>
        initDropzone()
        $(document).ready(function() {
            is_for_browse_file = true
            filtermedia()
        });

        function selectLayout() {
            $('.layout-input').val('');
            let layout = $("select#layout option").filter(":selected").val();
            $('.section_layout').addClass('d-none');
            $('.' + layout).removeClass('d-none');
            $('.layout-input').val(layout);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: "POST",
                data: $('#section-form').serialize(),
                url: '{{ route('theme.tlcommerce.home.page.sections.layout.options') }}',
                success: function(data) {
                    $('.layout-options').html(data)
                }
            });
        }

        function selectColor(e, color) {
            let target = e.target;
            $(target).closest('.addon').find('.color-input').val(color);
        }

        function selectAdsLayout() {
            let selected_ads_layout = $("select#adsLayout option").filter(":selected").val();;
            let data = {
                'layout': selected_ads_layout,
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: "POST",
                data: data,
                url: '{{ route('theme.tlcommerce.home.page.sections.ads.layout.options') }}',
                success: function(data) {
                    $('.selected_ads_layout').html(data);
                }
            });

        }
    </script>
@endsection
