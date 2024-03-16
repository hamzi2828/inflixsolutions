@extends('core::base.layouts.master')
@section('title')
    {{ translate('New Section') }}
@endsection
@section('custom_css')
    <style>
        .color-picker {
            width: 50px !important;
        }

        .elementor-element {
            border-radius: 3px;
            background-color: #fff;
            /* cursor: move; */
            position: relative;
            border: 1px solid #a9a9a97d;
            text-align: center;
        }

        .elementor-element .icon {
            font-size: 28px;
            padding-top: 15px;
        }

        .elementor-element .elementor-element-title-wrapper {
            display: table;
            width: 100%;
        }

        .elementor-element .title {
            font-size: 11px;
            display: table-cell;
            vertical-align: middle;
            height: 40px;
        }
    </style>
@endsection
@section('main_content')
    <div class="row">
        <div class="col-lg-8">
            <form action="#" method="POST" id="section-form">
                @csrf
                <div class="card mb-30">
                    <div class="card-header bg-white border-bottom2">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4>{{ translate('Section Layouts') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="layout-chosse">
                            <div class="layout-header d-flex align-items-center justify-content-center">
                                <h5>Select Yout Structure</h5>
                            </div>
                            <div class="col-8 mx-auto">
                                <div class="layout-options row mt-20">
                                    <div class="col-sm-12 mb-20 ">
                                        <a href="#" data-layout="12" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <rect id="_1" data-name="1" width="60" height="30"
                                                    fill="#d5dadf" />
                                            </svg>
                                        </a>

                                        <a href="#" data-layout="6_6" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <g id="_2" data-name="2" transform="translate(-4849 -2207)">
                                                    <rect id="Rectangle_63" data-name="Rectangle 63" width="29.5"
                                                        height="30" transform="translate(4849 2207)" fill="#d5dadf" />
                                                    <rect id="Rectangle_64" data-name="Rectangle 64" width="29.5"
                                                        height="30" transform="translate(4879.5 2207)" fill="#d5dadf" />
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#" data-layout="4_4_4" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <g id="_3" data-name="3" transform="translate(-4929 -2240)">
                                                    <rect id="Rectangle_64" data-name="Rectangle 64" width="19"
                                                        height="30" transform="translate(4929 2240)" fill="#d5dadf" />
                                                    <rect id="Rectangle_69" data-name="Rectangle 69" width="19.5"
                                                        height="30" transform="translate(4949.2 2240)" fill="#d5dadf" />
                                                    <rect id="Rectangle_68" data-name="Rectangle 68" width="19"
                                                        height="30" transform="translate(4970 2240)" fill="#d5dadf" />
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#" data-layout="3_3_3_3" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <g id="_4" data-name="4" transform="translate(-5009 -2207)">
                                                    <rect id="Rectangle_64" data-name="Rectangle 64" width="14.3"
                                                        height="30" transform="translate(5009 2207)" fill="#d5dadf" />
                                                    <rect id="Rectangle_69" data-name="Rectangle 69" width="14.3"
                                                        height="30" transform="translate(5024.233 2207)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_70" data-name="Rectangle 70" width="14.3"
                                                        height="30" transform="translate(5039.467 2207)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_71" data-name="Rectangle 71" width="14.3"
                                                        height="30" transform="translate(5054.7 2207)"
                                                        fill="#d5dadf" />
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#" data-layout="4_8" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <g id="_5" data-name="5" transform="translate(-5009 -2207)">
                                                    <rect id="Rectangle_64" data-name="Rectangle 64" width="19"
                                                        height="30" transform="translate(5009 2207)" fill="#d5dadf" />
                                                    <rect id="Rectangle_69" data-name="Rectangle 69" width="39.8"
                                                        height="30" transform="translate(5029.2 2207)"
                                                        fill="#d5dadf" />
                                                </g>
                                            </svg>
                                        </a>
                                        <a href="#" data-layout="8_4" class="layout-option"><svg id="_6"
                                                data-name="6" xmlns="http://www.w3.org/2000/svg" width="60"
                                                height="30" viewBox="0 0 60 30">
                                                <rect id="Rectangle_64" data-name="Rectangle 64" width="19"
                                                    height="30" transform="translate(41)" fill="#d5dadf" />
                                                <rect id="Rectangle_69" data-name="Rectangle 69" width="39.8"
                                                    height="30" fill="#d5dadf" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="col-sm-12">
                                        <a href="#" data-layout="3_3_6" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <g id="_7" data-name="7" transform="translate(-4769 -2257)">
                                                    <rect id="Rectangle_64" data-name="Rectangle 64" width="14.3"
                                                        height="30" transform="translate(4769 2257)" fill="#d5dadf" />
                                                    <rect id="Rectangle_69" data-name="Rectangle 69" width="14.3"
                                                        height="30" transform="translate(4784.233 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_70" data-name="Rectangle 70" width="29.533"
                                                        height="30" transform="translate(4799.467 2257)"
                                                        fill="#d5dadf" />
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#" data-layout="6_3_3" class="layout-option"><svg id="_8"
                                                data-name="8" xmlns="http://www.w3.org/2000/svg" width="60"
                                                height="30" viewBox="0 0 60 30">
                                                <rect id="Rectangle_64" data-name="Rectangle 64" width="14.3"
                                                    height="30" transform="translate(45.7)" fill="#d5dadf" />
                                                <rect id="Rectangle_69" data-name="Rectangle 69" width="14.3"
                                                    height="30" transform="translate(30.467)" fill="#d5dadf" />
                                                <rect id="Rectangle_70" data-name="Rectangle 70" width="29.533"
                                                    height="30" fill="#d5dadf" />
                                            </svg>
                                        </a>

                                        <a href="#" data-layout="3_6_3" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <g id="_9" data-name="9" transform="translate(-4929 -2257)">
                                                    <rect id="Rectangle_64" data-name="Rectangle 64" width="14.3"
                                                        height="30" transform="translate(4929 2257)" fill="#d5dadf" />
                                                    <rect id="Rectangle_69" data-name="Rectangle 69" width="14.3"
                                                        height="30" transform="translate(4974.7 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_70" data-name="Rectangle 70" width="29.533"
                                                        height="30" transform="translate(4944.233 2257)"
                                                        fill="#d5dadf" />
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#" data-layout="2_8_2" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <g id="_10" data-name="10" transform="translate(-5009 -2257)">
                                                    <rect id="Rectangle_64" data-name="Rectangle 64" width="11.5"
                                                        height="30" transform="translate(5009 2257)" fill="#d5dadf" />
                                                    <rect id="Rectangle_72" data-name="Rectangle 72" width="11.5"
                                                        height="30" transform="translate(5021.1 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_73" data-name="Rectangle 73" width="11.5"
                                                        height="30" transform="translate(5033.2 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_74" data-name="Rectangle 74" width="11.5"
                                                        height="30" transform="translate(5045.3 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_75" data-name="Rectangle 75" width="11.5"
                                                        height="30" transform="translate(5057.5 2257)"
                                                        fill="#d5dadf" />
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#" data-layout="2_8_2" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <g id="_11" data-name="11" transform="translate(-5089 -2257)">
                                                    <rect id="Rectangle_64" data-name="Rectangle 64" width="11.5"
                                                        height="30" transform="translate(5089 2257)" fill="#d5dadf" />
                                                    <rect id="Rectangle_72" data-name="Rectangle 72" width="35.7"
                                                        height="30" transform="translate(5101.1 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_75" data-name="Rectangle 75" width="11.5"
                                                        height="30" transform="translate(5137.5 2257)"
                                                        fill="#d5dadf" />
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#" data-layout="2_2_2_2_2_2" class="layout-option"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="60" height="30"
                                                viewBox="0 0 60 30">
                                                <g id="_12" data-name="12" transform="translate(-5169 -2257)">
                                                    <rect id="Rectangle_64" data-name="Rectangle 64" width="9.5"
                                                        height="30" transform="translate(5169 2257)" fill="#d5dadf" />
                                                    <rect id="Rectangle_72" data-name="Rectangle 72" width="9.5"
                                                        height="30" transform="translate(5179.1 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_73" data-name="Rectangle 73" width="9.5"
                                                        height="30" transform="translate(5189.2 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_74" data-name="Rectangle 74" width="9.5"
                                                        height="30" transform="translate(5199.3 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_75" data-name="Rectangle 75" width="9.5"
                                                        height="30" transform="translate(5209.4 2257)"
                                                        fill="#d5dadf" />
                                                    <rect id="Rectangle_76" data-name="Rectangle 76" width="9.5"
                                                        height="30" transform="translate(5219.5 2257)"
                                                        fill="#d5dadf" />
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <form action="{{ route('theme.tlcommerce.home.page.sections.new.store') }}" method="POST">
                @csrf
                <div class="card mb-30">
                    <div class="card-header bg-white border-bottom2">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4>{{ translate('Section Properties') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="element-properties" id="elementProperties">

                        </div>
                        <div class="elements"></div>
                        <input type="hidden" name="layout" class="layout-input" value="{{ old('layout') }}">

                        <div class="form-row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn long">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
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

        $('.layout-option').on('click', function(e) {
            e.preventDefault();
            let $this = $(this);
            let layout = $this.data('layout');
            let data = {
                'layout': layout,
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: "POST",
                data: data,
                url: '{{ route('theme.tlcommerce.home.page.sections.layout.set') }}',
                success: function(data) {
                    $('.layout-chosse').html(data);
                }
            });
        });

        function loadElement(e) {
            e.preventDefault();
            let target = e.target;
            let id = $(target).closest('.single-section').attr('id');
            let data = {
                'div_id': id,
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: "POST",
                data: data,
                url: '{{ route('theme.tlcommerce.home.page.sections.load.element') }}',
                success: function(data) {
                    $('.elements').removeClass('d-none');
                    $('.elements').html(data);
                    $('.element-properties').addClass('d-none')
                }
            });
        };

        function selectElement(e) {
            e.preventDefault();
            let target_div = $('.target_section').val();
            let element = e.target;
            let element_id = $(element).closest('.elementor-element').attr('id');
            let html = "";
            if (element_id === 'categorySliderElement') {
                html =
                    '<div class="cat_slider_element" data-component="' + target_div +
                    '"><a href="#" onclick="removeElement(event)" class="text-danger btn-link float-right mt-1">x</a><div data-component="' +
                    target_div +
                    '" id="category_slider" onclick="elementProperites(event)"> <img src="{{ asset('/public/themes/tlcommerce/assets/img/category_slide.png') }}"></div></div>'
            } else if (element_id === 'adsElement') {
                html =
                    '<div class="ads_element" data-component="' + target_div +
                    '" ><a href="#" onclick="removeElement(event)" class="text-danger btn-link float-right mt-1">x</a><div data-component="' +
                    target_div +
                    '" id="ads" onclick="elementProperites(event)"><img src="{{ asset('/public/themes/tlcommerce/assets/img/ads.png') }}"></div></div>'
            } else if (element_id === 'flashDealElement') {
                html =
                    '<div class="flash_deal_element" data-component="' + target_div +
                    '" ><a href="#" onclick="removeElement(event)" class="text-danger btn-link float-right mt-1">x</a><div data-component="' +
                    target_div +
                    '" id="flashdeal" onclick="elementProperites(event)"><img src="{{ asset('/public/themes/tlcommerce/assets/img/deals.png') }}"></div></div>'
            } else if (element_id === 'collectionElement') {
                html =
                    '<div class="collection_element"><a href="#" onclick="removeElement(event)" class="text-danger btn-link float-right mt-1">x</a><div data-component="' +
                    target_div +
                    '" id="product_collection" onclick="elementProperites(event)"><img src="{{ asset('/public/themes/tlcommerce/assets/img/collections.png') }}"></div></div>'
            }

            $('#' + target_div).html(html);
        };



        function elementProperites(e) {
            let target = e.target;
            let layout = $(target).parent().attr('id');
            let section_component_id = $(target).parent().attr('data-component');

            let data = {
                'layout': layout
            }
            $('.single-element-properties').addClass('d-none')
            if ($('div.' + section_component_id).length > 0) {
                $('.elements').addClass('d-none')
                $('.element-properties').removeClass('d-none')
                $('.' + section_component_id).removeClass('d-none');
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: data,
                    url: '{{ route('theme.tlcommerce.home.page.sections.layout.options') }}',
                    success: function(data) {
                        $('.element-properties').removeClass('d-none');
                        $('.elements').addClass('d-none')
                        var txtNewInputBox = document.createElement('div');
                        txtNewInputBox.className = 'single-element-properties ' + section_component_id;
                        txtNewInputBox.innerHTML = data;
                        document.getElementById("elementProperties").appendChild(txtNewInputBox);
                    }
                });
            }

        }

        function removeElement(e) {
            let target = e.target;
            let parent_div = $(target).parent().attr('data-component');
            if ($('div.' + parent_div).length > 0) {
                $('.' + parent_div).remove()
            }
            let html =
                '<a href="#" data-item="2" class="btn font-30 layout-item radius-50" onclick="loadElement(event)">+</a>';
            let parent = $(target).closest('.single-section');
            $(target).parent().remove()
            parent.html(html)

        }

        function selectColor(e, color) {
            let target = e.target;
            $(target).closest('.addon').find('.color-input').val(color);
        }
    </script>
@endsection
