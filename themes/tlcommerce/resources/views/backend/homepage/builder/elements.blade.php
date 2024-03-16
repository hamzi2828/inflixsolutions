<ul class="nav nav-tabs mb-20" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="content-info-tab" data-toggle="tab" href="#content-info" role="tab"
            aria-controls="content-info" aria-selected="true">{{ translate('Elements') }}</a>
        <input type="hidden" class="target_section" value="{{ $target }}">
    </li>

</ul>
<div class="tab-content" id="myTabContent">
    <div class="row m-0">
        <div class="col-6 element mb-20">
            <div class="elementor-element" draggable="true" onclick="selectElement(event)" id="adsElement">
                <div class="icon">
                    <i class="icofont-spreadsheet"></i>
                </div>
                <div class="elementor-element-title-wrapper">
                    <div class="title">Ads</div>
                </div>
            </div>
        </div>
        <div class="col-6 element mb-20">
            <div class="elementor-element" draggable="true" onclick="selectElement(event)" id="flashDealElement">
                <div class="icon">
                    <i class="icofont-spreadsheet"></i>
                </div>
                <div class="elementor-element-title-wrapper">
                    <div class="title">Flash Deal</div>
                </div>
            </div>
        </div>
        <div class="col-6 element mb-20">
            <div class="elementor-element" draggable="true" onclick="selectElement(event)" id="collectionElement">
                <div class="icon">
                    <i class="icofont-spreadsheet"></i>
                </div>
                <div class="elementor-element-title-wrapper">
                    <div class="title">Collection</div>
                </div>
            </div>
        </div>
        <div class="col-6 element mb-20">
            <div class="elementor-element" draggable="true" onclick="selectElement(event)" id="categorySliderElement">
                <div class="icon">
                    <i class="icofont-spreadsheet"></i>
                </div>
                <div class="elementor-element-title-wrapper">
                    <div class="title">Category Slider</div>
                </div>
            </div>
        </div>
    </div>
</div>
