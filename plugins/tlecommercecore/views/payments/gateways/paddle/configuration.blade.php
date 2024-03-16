 <div class="border-top2 p-3 payment-method-item-body">
     <div class="configuration">
         <form id="credential-form-{{ $method->id }}">
             <input type="hidden" name="payment_id" value="{{ $method->id }}">
             <div class="form-group mb-20">
                 <label class="black bold mb-2">{{ translate('Logo') }}</label>
                 <div class="input-option">
                     @include('core::base.includes.media.media_input', [
                         'input' => 'paddle_logo',
                         'data' => \Plugin\TlcommerceCore\Repositories\PaymentMethodRepository::configKeyValue(
                             $method->id,
                             'paddle_logo'),
                     ])
                     @if ($errors->has('paddle_logo'))
                         <div class="invalid-input">{{ $errors->first('paddle_logo') }}
                         </div>
                     @endif
                 </div>
             </div>
             <div class="form-group mb-20">
                 <label class="black bold mb-2">{{ translate('Paddle Vendor ID') }}</label>
                 <div class="input-option">
                     <input type="text" class="theme-input-style" name="paddle_vendor_id"
                         placeholder="Enter Paddle Vendor ID"
                         value="{{ \Plugin\TlcommerceCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'paddle_vendor_id') }}"
                         required />
                 </div>
             </div>
             <div class="form-group mb-20">
                 <label class="black bold mb-2">{{ translate('Paddle Public Key') }}</label>
                 <div class="input-option">
                     <input type="text" class="theme-input-style" name="paddle_public_key"
                         placeholder="Enter Paddle Public Key"
                         value="{{ \Plugin\TlcommerceCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'paddle_public_key') }}"
                         required />
                 </div>
             </div>
             <div class="form-group mb-20">
                 <label class="black bold mb-2">{{ translate('Vendor Auth Code') }}</label>
                 <div class="input-option">
                     <input type="text" class="theme-input-style" name="paddle_vendor_auth_code"
                         placeholder="Enter Vendor Auth Code"
                         value="{{ \Plugin\TlcommerceCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'paddle_vendor_auth_code') }}"
                         required />
                 </div>
             </div>

             <div class="form-group mb-20">
                 <div class="d-flex">
                     <label class="black bold">{{ translate('Sandbox mode') }}</label>
                     <label class="switch glow primary medium ml-2">
                         <input type="checkbox" name="sandbox" @if (
                             \Plugin\TlcommerceCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'sandbox') ==
                                 config('settings.general_status.active')) checked @endif />
                         <span class="control"></span>
                     </label>

                 </div>
             </div>
             <div class="form-group mb-20">
                 <label class="black bold mb-2">{{ translate('Instruction') }}</label>
                 <div class="input-option">
                     <textarea name="paddle_instruction" class="theme-input-style">{{ \Plugin\TlcommerceCore\Repositories\PaymentMethodRepository::configKeyValue($method->id, 'paddle_instruction') }}</textarea>
                 </div>
             </div>
             <div>
                 <button class="btn long payment-credental-update-btn"
                     data-payment-btn="{{ $method->id }}">{{ translate('Save Changes') }}</button>
             </div>
         </form>
     </div>
     <div class="instruction">
         <a href="https://www.paddle.com/" target="_blank">Paddle</a>
         <p>
             Customer can buy product and pay directly using
             Visa, Credit card via Paddle
         </p>
         <p class="semi-bold">
             Configuration instruction for Paddle
         </p>
         <p>To use Paddle, you need:</p>
         <ol>
             <li style="list-style-type: decimal">
                Register with Paddle
             </li>
             <li style="list-style-type: decimal">
                 <p>
                     After registration at Paddle, you will have
                     Vendor ID, Public Key, Auth Code
                 </p>
             </li>
             <li style="list-style-type: decimal">
                 <p>
                     Enter Vendor ID, Public Key, Auth Code into the box in left
                     hand
                 </p>
             </li>
         </ol>
     </div>
 </div>
