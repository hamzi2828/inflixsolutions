<div class="form-row mb-20">
    <label class="font-14 bold black col-sm-3">{{ translate('Cities') }} </label>
    <div class="col-sm-9">
        <select class="form-control cod-city-select" name='cod_selected_cities[]' multiple>
            @foreach ($cities_options as $city)
                <option value="{{ $city->id }}">
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('cod_selected_cities'))
            <div class="invalid-input">{{ $errors->first('cod_selected_cities') }}</div>
        @endif
    </div>
</div>
<script>
    (function($) {
        "use strict";
        /**
         * select product cod cities 
         *
         */
        $('.cod-city-select').select2({
            theme: "classic",
            placeholder: '{{ translate('Select Cities') }}',
            closeOnSelect: false
        });
    })(jQuery);
</script>
