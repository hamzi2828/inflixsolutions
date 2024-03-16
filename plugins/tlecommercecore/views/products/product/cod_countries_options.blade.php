 @if (count($countries) > 0)
     <div class="form-row mb-20">
         <label class="font-14 bold black col-sm-3">{{ translate('Countries') }} </label>
         <div class="col-sm-9">
             <select class="form-control cod-countries-select" name="cod_selected_countries[]" multiple
                 onchange="codStateOptions()">
                 @foreach ($countries as $country)
                     <option value="{{ $country->id }}">
                         {{ $country->name }}
                     </option>
                 @endforeach
             </select>
             @if ($errors->has('colors'))
                 <div class="invalid-input">{{ $errors->first('colors') }}</div>
             @endif
         </div>
     </div>
 @else
     <div class="form-row mb-20">
         <p class="alert alert-danger m-2 col-12">{{ translate('No Location Found') }}</p>
         <a href="{{ route('plugin.tlcommercecore.shipping.locations.country.list') }}" target="_blank"
             class="m-2">{{ translate('Set location from here') }}</a>
     </div>
 @endif
 <script>
     (function($) {
         "use strict";
         /**
          * select product cod countries
          * 
          */
         $('.cod-countries-select').select2({
             theme: "classic",
             placeholder: '{{ translate('Select Countries') }}',
             closeOnSelect: false
         });
     })(jQuery);
 </script>
