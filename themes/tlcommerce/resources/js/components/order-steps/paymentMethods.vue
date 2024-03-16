<template>
  <div class="shadow-card mb-30">
    <div class="row" v-if="!loading">
      <div class="col-12">
        <h3 class="checkout-title">{{ $t("Payment method") }}:</h3>
      </div>
      <!--Order Note-->
      <div
        class="col-lg-12"
        v-if="config.enable_order_note_in_checkout == enums.status.ACTIVE"
      >
        <div class="form-group mb-20">
          <label class="font-weight-bold fz-12 mb-2">
            {{ $t("Order Note") }}</label
          >
          <textarea class="theme-input-style" v-model="additional_order_note">
          </textarea>
        </div>
      </div>
      <!--End Order Note-->
      <!--Payment methods-->
      <div class="col-12">
        <label class="font-weight-bold fz-12 mb-2">{{
          $t("Payment method")
        }}</label>
        <ul class="list-unstyled form-selector-list mb-3">
          <li
            class="single-form-selector"
            v-for="(payment, index) in paymentMethods"
            :key="index"
          >
            <span class="custom-radio-btn">
              <label>
                <input
                  type="radio"
                  :value="payment"
                  class="shipping-method"
                  name="payment-method"
                  v-model="selected_payment_method"
                  @input="!pay_wallet"
                />
                <span class="label-title" v-if="payment.logo">
                  <img :src="payment.logo" :alt="payment.name" />
                </span>
                <span class="label-title" v-else>
                  {{ payment.name }}
                </span>
              </label>
            </span>
          </li>
        </ul>
      </div>
      <!--End Payment methods-->
      <!--Selected payment instruction-->
      <div class="col-12 mb-3" v-if="selected_payment_method != null">
        <p>{{ selected_payment_method.instruction }}</p>
      </div>
      <!--End Selected payment instruction-->
      <!--Wallet area-->
      <div
        class="col-12 mb-5 text-center"
        v-if="
          config.enable_wallet_in_checkout == enums.status.ACTIVE &&
          isCustomerLogin &&
          config.is_active_wallet == enums.status.ACTIVE &&
          wallet_available_balance >= totalPayableAmount
        "
      >
        <p>{{ $t("OR") }}</p>
        <p>
          {{ $t("Wallet Balance") }}
          <the-currency :amount="wallet_available_balance"></the-currency>
        </p>
        <button
          type="submit"
          class="btn btn_fill m-w-100 justify-content-center"
          @click.prevent="payWithWallet"
        >
          {{ $t("Pay with wallet") }}
        </button>
      </div>
      <!--End Wallet Area-->
      <!--Action Area-->
      <div class="col-12">
        <div class="d-flex flex-wrap justify-content-between">
          <button
            type="button"
            class="btn btn_border mb-20 m-w-100 justify-content-center"
            @click.prevent="goPreviousStep"
          >
            <span class="material-icons me-2"> arrow_back </span>
            {{ $t("Previous") }}
          </button>
          <button
            type="submit"
            class="btn btn_fill mb-20 m-w-100 justify-content-center"
            :disabled="orderCreating"
            @click.prevent="
              () => {
                pay_wallet = false;
                createOrder();
              }
            "
          >
            <span v-if="orderCreating">
              <CSpinner component="span" size="sm" aria-hidden="true" />
              {{ $t("Please wait") }}
            </span>
            <span v-else>
              {{ $t("Place Order") }}
            </span>
          </button>
        </div>
      </div>
      <!--End action area-->
    </div>
    <div v-if="loading">
      <skeleton
        class="col-12 mb-20 single-package border-bottom"
        height="70px"
      ></skeleton>
      <skeleton
        class="col-12 mb-20 mt-2 single-package border-bottom"
        height="150px"
      ></skeleton>
      <skeleton
        class="col-12 mb-2 mt-2 single-package border-bottom"
        height="80px"
      ></skeleton>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
import { CSpinner } from "@coreui/vue";
export default {
  name: "PaymentMethods",
  emits: ["previous-step"],
  components: {
    CSpinner,
  },
  props: {
    config: {
      type: Object,
      required: true,
    },
    enums: {
      type: Object,
      required: true,
    },
    productPackages: {
      type: Array,
      required: true,
    },
    isCustomerLogin: {
      type: Boolean,
      required: false,
      default: false,
    },
    totalPayableAmount: {
      type: Number,
      required: false,
      default: 0,
    },
  },
  data() {
    return {
      loading: true,
      paymentMethods: [],
      additional_order_note: "",
      selected_payment_method: null,
      wallet_available_balance: 0,
      pay_wallet: false,
      orderCreating: false,
    };
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    isActivePickupPoint: (state) => state.isActivePickupPoint,
    isActiveHomeDelivery: (state) => state.isActiveHomeDelivery,
    pickupPoint: (state) => state.pickupPoint,
  }),
  mounted() {
    this.getPaymentMethods();
    if (this.isCustomerLogin) {
      this.getCustomerWalletSummary();
    }
  },
  methods: {
    /**
     * Get active Payment methods
     *
     */
    getPaymentMethods() {
      axios
        .get("/api/v1/ecommerce-core/active-payment-methods")
        .then((response) => {
          if (response.data.success) {
            this.paymentMethods = response.data.data;
            this.loading = false;
          } else {
            this.paymentMethods = [];
            this.loading = false;
          }
        })
        .catch((error) => {
          this.this.paymentMethods = [];
          this.loading = false;
        });
    },
    /**
     * Get customer wallet transactions
     */
    getCustomerWalletSummary() {
      axios
        .post(
          "/api/wallet/v1/customer-wallet-summary",
          {
            perPage: null,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.wallet_available_balance =
              response.data.summary.total_available;
          } else {
            this.wallet_available_balance = 0;
          }
        })
        .catch((error) => {
          this.wallet_available_balance = 0;
        });
    },
    /**
     * Check out with wallet
     */
    payWithWallet() {
      this.pay_wallet = true;
      this.createOrder();
    },
    /**
     * Create new order
     */
    createOrder() {
      this.orderCreating = true;
      if (this.selected_payment_method == null && !this.pay_wallet) {
        this.$toast.error(this.$t("Please select a payment option"));
        this.orderCreating = false;
        return null;
      }
      if (this.isCustomerLogin) {
        this.customerCheckout();
      } else if (
        this.config.enable_guest_checkout == this.enums.status.ACTIVE
      ) {
        this.guestCheckout();
      } else {
        this.$router.push("/login");
      }
    },

    /**
     * Customer checkout
     */
    customerCheckout() {
      let formData = new FormData();
      formData.append(
        "coupon_discounts",
        JSON.stringify(this.$store.state.couponDiscount)
      );
      formData.append(
        "payment_id",
        this.selected_payment_method ? this.selected_payment_method.id : null
      );
      formData.append(
        "wallet_payment",
        this.pay_wallet ? this.enums.status.ACTIVE : this.enums.status.IN_ACTIVE
      );
      formData.append("note", this.additional_order_note);
      //pickup point delivery
      if (this.isActivePickupPoint && !this.isActiveHomeDelivery) {
        formData.append(
          "pickup_point",
          this.pickupPoint != null ? this.pickupPoint.id : null
        );
      }

      //Home Delivery
      if (!this.isActivePickupPoint && this.isActiveHomeDelivery) {
        //Shipping address
        formData.append(
          "shipping_address",
          this.$store.state.shippingDetails.id
        );
        //Billing address
        if (
          this.config.enable_billing_address == this.enums.status.ACTIVE &&
          this.config.use_shipping_address_as_billing_address ==
            this.enums.status.ACTIVE
        ) {
          formData.append(
            "billing_address",
            this.$store.state.shippingDetails.id
          );
        }

        if (
          this.config.enable_billing_address == this.enums.status.ACTIVE &&
          this.config.use_shipping_address_as_billing_address !=
            this.enums.status.ACTIVE
        ) {
          formData.append(
            "billing_address",
            this.$store.state.billingDetails != null
              ? this.$store.state.billingDetails.id
              : ""
          );
        }
      }

      formData.append("products", JSON.stringify(this.productPackages));
      axios
        .post("/api/v1/ecommerce-core/customer/order/create", formData, {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            if (response.data.response_url) {
              this.$store.dispatch("flushCartData").then(() => {
                window.location.href = response.data.response_url;
              });
            } else {
              this.orderCreating = false;
            }
          } else {
            this.orderCreating = false;
            this.$toast.error("Order create failed");
          }
        })
        .catch((error) => {
          this.orderCreating = false;
          if (error.response.status == 422) {
            var errors = error.response.data.errors;
            var errormessage = "";
            Object.keys(errors).forEach(function (key) {
              errormessage += errors[key];
            });
            this.$toast.error(errormessage);
          } else {
            this.$toast.error("Order create failed");
          }
        });
    },
    /**
     * Guest checkout
     */
    guestCheckout() {
      let formData = new FormData();
      formData.append(
        "coupon_discounts",
        JSON.stringify(this.$store.state.couponDiscount)
      );
      formData.append("name", this.$store.state.guestCustomerInfo.name);
      formData.append("email", this.$store.state.guestCustomerInfo.email);
      if (this.$store.state.isActiveCreateNewAccount) {
        formData.append(
          "password",
          this.$store.state.guestCustomerInfo.password
        );
        formData.append(
          "password_confirmation",
          this.$store.state.guestCustomerInfo.confirm_password
        );
        formData.append(
          "create_new_account",
          this.$store.state.isActiveCreateNewAccount
        );
      }
      formData.append("payment_id", this.selected_payment_method.id);
      formData.append("note", this.additional_order_note);
      //pickup point delivery
      if (this.isActivePickupPoint && !this.isActiveHomeDelivery) {
        formData.append(
          "pickup_point",
          this.pickupPoint != null ? this.pickupPoint.id : null
        );
      }
      //Home Delivery
      if (!this.isActivePickupPoint && this.isActiveHomeDelivery) {
        formData.append(
          "shipping_address",
          JSON.stringify(this.$store.state.shippingDetails)
        );
        //Billing address
        if (this.config.enable_billing_address == this.enums.status.ACTIVE) {
          if (
            this.config.use_shipping_address_as_billing_address ==
            this.enums.status.ACTIVE
          ) {
            formData.append(
              "billing_address",
              JSON.stringify(this.$store.state.shippingDetails)
            );
          } else {
            formData.append(
              "billing_address",
              JSON.stringify(this.$store.state.billingDetails)
            );
          }
        }
      }

      formData.append("products", JSON.stringify(this.productPackages));
      axios
        .post("/api/v1/ecommerce-core/guest/checkout", formData)
        .then((response) => {
          if (response.data.success) {
            if (response.data.response_url) {
              this.$store.dispatch("flushCartData").then(() => {
                window.location.href = response.data.response_url;
              });
            }
          } else {
            this.$toast.error("Order create failed");
          }
          this.orderCreating = false;
        })
        .catch((error) => {
          this.orderCreating = false;
          if (error.response.status == 422) {
            var errors = error.response.data.errors;
            var errormessage = "";
            Object.keys(errors).forEach(function (key) {
              errormessage += errors[key];
            });
            this.$toast.error(errormessage);
          } else {
            this.$toast.error("Order create failed");
          }
        });
    },
    /**
     * Go to previous step
     */
    goPreviousStep() {
      this.$emit("previous-step");
    },
  },
};
</script>
