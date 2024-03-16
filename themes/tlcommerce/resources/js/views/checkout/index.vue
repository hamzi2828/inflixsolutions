<template>
  <div class="">
    <page-header class="pt-3 pb-3" :items="bItems" />
    <div class="shipping-info light-bg pt-60 pb-60">
      <div class="custom-container2" v-if="!dataLoading">
        <form action="#">
          <div class="row">
            <div class="col-lg-2 d-none d-lg-block">
              <div class="wizard-navigation">
                <ul class="wizard-nav wizard-nav-pills">
                  <li
                    :class="{ active: showContactInfo }"
                    class="bg-white mb-2"
                  >
                    <div class="wizard-icon-circle">
                      <span class="material-icons"> description </span>
                    </div>
                    <span class="stepTitle"> {{ $t("Shipping") }}: </span>
                  </li>
                  <li
                    :class="{ active: showReviewOrder }"
                    class="bg-white mb-2"
                  >
                    <div class="wizard-icon-circle">
                      <span class="material-icons"> description </span>
                    </div>
                    <span class="stepTitle"> {{ $t("Review") }}: </span>
                  </li>
                  <li
                    :class="{ active: showPaymentMethod }"
                    class="bg-white mb-2"
                  >
                    <div class="wizard-icon-circle">
                      <span class="material-icons"> payments </span>
                    </div>
                    <span class="stepTitle"> {{ $t("Payments") }}: </span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-6">
              <delivery-shipping
                v-if="showContactInfo"
                :enums="enums"
                :config="configuration"
                :customer-address="customerAddress"
                :is-customer-login="isCustomerLogin"
                :pickup-points="pickupPoints"
                @next-step="
                  () => {
                    showContactInfo = false;
                    showReviewOrder = true;
                  }
                "
              ></delivery-shipping>
              <review-order
                v-if="showReviewOrder"
                :enums="enums"
                :config="configuration"
                :is-customer-login="isCustomerLogin"
                @next-step="completedOrderReview"
                @previous-step="
                  () => {
                    showReviewOrder = false;
                    showContactInfo = true;
                  }
                "
              ></review-order>

              <payment-methods
                v-if="showPaymentMethod"
                :enums="enums"
                :config="configuration"
                :product-packages="product_packages"
                :is-customer-login="isCustomerLogin"
                :total-payable-amount="totalPayableAmount"
                @previous-step="
                  () => {
                    showPaymentMethod = false;
                    showReviewOrder = true;
                  }
                "
              ></payment-methods>
            </div>
            <div class="col-lg-4">
              <order-summary
                :enums="enums"
                :config="configuration"
                @get-total-payable="calculateTotalPayable"
              ></order-summary>
            </div>
          </div>
        </form>
      </div>
      <div class="custom-container2" v-else>
        <div class="row">
          <div class="col-lg-2 d-none d-lg-block">
            <skeleton class="w-100" height="180px"></skeleton>
          </div>
          <div class="col-lg-6">
            <skeleton class="w-100 mb-20" height="80px"></skeleton>
            <skeleton class="w-100" height="320px"></skeleton>
          </div>
          <div class="col-lg-4">
            <skeleton class="w-100" height="400px"></skeleton>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import deliveryShipping from "../../components/order-steps/deliveryShipping";
import PaymentMethods from "../../components/order-steps/paymentMethods";
import ReviewOrder from "../../components/order-steps/reviewOrder";
import orderSummary from "../../components/order-steps/orderSummary";
import enums from "../../enums/enums";
import axios from "axios";
import { mapState } from "vuex";
export default {
  name: "Checkout",
  components: {
    PageHeader,
    deliveryShipping,
    PaymentMethods,
    ReviewOrder,
    orderSummary,
  },
  data() {
    return {
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Checkout"),
          active: true,
        },
      ],
      enums: enums,
      tableData: this.$store.state.cart,
      totalPayableAmount: 0,
      customerAddress: [],
      pickupPoints: [],
      showContactInfo: true,
      showPaymentMethod: false,
      showReviewOrder: false,
      configuration: "",
      dataLoading: true,
      product_packages: [],
    };
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    isCustomerLogin: (state) => state.isCustomerLogin,
    cartItem: (state) =>
      state.cart.length ? state.cart.reduce((a, b) => a + b.quantity, 0) : 0,
  }),
  mounted() {
    document.title = this.$t("Checkout");
    if (this.tableData.length < 1) {
      this.$router.push("/cart");
    }
    this.getCheckoutConfig();
  },
  methods: {
    /**
     * Will get checkout configuration
     */
    getCheckoutConfig() {
      axios
        .get("/api/v1/ecommerce-core/checkout/configuration")
        .then((response) => {
          if (response.data.success) {
            this.configuration = response.data.config;
            //Check guest checkout
            if (
              response.data.config.enable_guest_checkout ==
              this.enums.status.IN_ACTIVE
            ) {
              if (!this.isCustomerLogin) {
                this.$toast.error(this.$t("Please login to complete checkout"));
                this.$router.push("/login");
              }
            }
            //Get customer address
            if (this.isCustomerLogin) {
              this.getCustomerAddress();
            } else {
              this.dataLoading = false;
            }
            //Get pickup point
            if (
              response.data.config.enable_pickuppoint_in_checkout ==
              this.enums.status.ACTIVE
            ) {
              this.getPickupPoints();
            }
          } else {
            this.$toast.error(
              this.$t("Something went wrong. Please try again")
            );
            this.$router.push("/");
          }
        })
        .catch((error) => {
          this.dataLoading = false;
          this.$toast.error(this.$t("Something went wrong. Please try again"));
          this.$router.push("/");
        });
    },
    /**
     * Will get customer address
     */
    getCustomerAddress() {
      axios
        .get("/api/v1/ecommerce-core/customer/get-customer-all-address", {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.customerAddress = response.data.data;
          } else {
            this.customerAddress = [];
          }
          this.dataLoading = false;
        })
        .catch((error) => {
          this.dataLoading = false;
          this.customerAddress = [];
        });
    },
    /**
     * Will get active pickup points
     */
    getPickupPoints() {
      axios
        .post("/api/v1/pickup-points/active-list")
        .then((response) => {
          if (response.data.success) {
            this.pickupPoints = response.data.data;
          } else {
            this.pickupPoints = [];
          }
        })
        .catch((error) => {
          this.this.pickupPoints = [];
        });
    },
    /**
     * Go  to next step from order review step
     *
     * @param {*} e
     */
    completedOrderReview(e) {
      this.product_packages = e;
      this.showReviewOrder = false;
      this.showPaymentMethod = true;
    },
    /**
     * Will calculate total payable order amount
     */
    calculateTotalPayable(amount) {
      this.totalPayableAmount = amount;
    },
  },
};
</script>
