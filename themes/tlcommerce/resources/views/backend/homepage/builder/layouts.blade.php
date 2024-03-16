@php
$options = explode('_', $layout);
@endphp
<div class="row m-0">
    @foreach ($options as $key => $option)
        @php
            $id = 'lay' . $key . '' . $option;
        @endphp
        <div class="col-{{ $option }} single-section d-flex align-items-center justify-content-center"
            style="border:1px dotted;min-height:100px" id="{{ $id }}">
            <a href="#" data-item="{{ $option }}" class="btn font-30 layout-item radius-50"
                onclick="loadElement(event)">+</a>
        </div>
    @endforeach
</div>
