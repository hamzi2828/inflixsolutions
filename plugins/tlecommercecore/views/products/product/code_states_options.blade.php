<div class="form-row mb-20">
    <label class="font-14 bold black col-sm-3">{{ translate('States') }} </label>
    <div class="col-sm-9">
        <select class="form-control cod-state-select" name='cod_selected_states[]' multiple onchange="codCitiesOptions()">
            @foreach ($states_options as $state)
                <option value="{{ $state->id }}">{{ $state->name }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('cod_selected_states'))
            <div class="invalid-input">{{ $errors->first('cod_selected_states') }}</div>
        @endif
    </div>
</div>
<script>
    (function($) {
        "use strict";
        /**
         * select product shipping state
         *
         */
        $('.cod-state-select').select2({
            theme: "classic",
            placeholder: '{{ translate('Select States') }}',
            closeOnSelect: false
        });
    })(jQuery);
</script>
