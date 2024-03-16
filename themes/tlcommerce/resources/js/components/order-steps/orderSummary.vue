<template>
  <div class="order-details shadow-card">
    <h3 class="checkout-title">{{ $t("Summary") }}</h3>
    <div class="table-responsive">
      <table class="shop_table w-100">
        <tbody>
          <tr class="font-weight-bold">
            <td>{{ $t("Product") }}</td>
            <td>{{ $t("Total") }}</td>
          </tr>
          <tr class="products" v-for="tdata in tableData" :key="tdata.id">
            <td>
              <span class="product-name">{{ tdata.name }}</span
              ><span class="font-weight-bold"> x{{ tdata.quantity }}</span>
            </td>
            <td>
              <the-currency
                :amount="tdata.unitPrice * tdata.quantity"
              ></the-currency>
            </td>
          </tr>
          <tr class="font-weight-bold">
            <td>{{ $t("Subtotal") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount">
                <bdi>
                  <span class="woocommerce-Price-currencySymbol"></span>
                  <the-currency :amount="totalUnitPrice"></the-currency>
                </bdi>
              </span>
            </td>
          </tr>
          <tr
            class="shipping-cost font-weight-bold"
            v-if="config.enable_tax_in_checkout == enums.status.ACTIVE"
          >
            <td>{{ $t("Tax") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount">
                <bdi>
                  <span class="woocommerce-Price-currencySymbol">+</span>
                  <the-currency :amount="totalTax"></the-currency>
                </bdi>
              </span>
            </td>
          </tr>
          <tr class="shipping-cost font-weight-bold">
            <td>{{ $t("Shipping Cost") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount">
                <bdi>
                  <span class="woocommerce-Price-currencySymbol">+</span>
                  <the-currency :amount="shippingCost"></the-currency>
                </bdi>
              </span>
            </td>
          </tr>
          <template
            v-if="
              couponDiscounts.length > 0 &&
              config.enable_coupon_in_checkout == this.enums.status.ACTIVE
            "
          >
            <tr
              class="order-savings font-weight-bold"
              v-for="(discount, index) in couponDiscounts"
              :key="index"
            >
              <td class="d-flex">
                <span class="c1">{{ discount.coupon_code }}</span>
                <a
                  href="#"
                  class="material-icons c1 mt-1"
                  @click.prevent="removeCoupon(discount.coupon_code)"
                  >delete
                </a>
              </td>
              <td>
                <span class="woocommerce-Price-amount amount c1">
                  <bdi>
                    <span class="woocommerce-Price-currencySymbol">-</span>
                    <the-currency :amount="discount.discount"></the-currency>
                  </bdi>
                </span>
              </td>
            </tr>
          </template>
          <tr class="order-total">
            <td class="c1">{{ $t("Payable Total") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount c1">
                <bdi>
                  <span class="woocommerce-Price-currencySymbol"></span>
                  <the-currency :amount="totalPayable"></the-currency>
                </bdi>
              </span>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="enableApplyCoupon" class="coupon">
        <div class="form-group">
          <input
            class="form-control me-1"
            type="text"
            v-model="coupon_code"
            v-bind:placeholder="$t('Your Coupon')"
          />
          <button
            type="submit"
            class="btn coupon-btn btn_border"
            :disabled="couponApplying"
            @click.prevent="applyCoupon"
          >
            <span v-if="couponApplying">
              <CSpinner component="span" size="sm" aria-hidden="true" />
              {{ $t("Wait") }}
            </span>
            <span v-else>
              {{ $t("Apply") }}
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
import { CSpinner } from "@coreui/vue";
export default {
  name: "OrderSummary",
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
  },
  data() {
    return {
      tableData: this.$store.state.cart,
      totalPrice: 0,
      coupon_code: "",
      couponApplying: false,
    };
  },
  emits: ["get-total-payable"],
  computed: mapState({
    isCustomerLogin: (state) => state.isCustomerLogin,
    customer_id: (state) =>
      state.customerInfo != null ? state.customerInfo.id : null,
    shippingCost: (state) => (state.shippingCost ? state.shippingCost : 0),
    totalTax: (state) => (state.tax ? state.tax : 0),
    couponDiscounts: (state) =>
      state.couponDiscount ? state.couponDiscount : [],
    totalUnitPrice() {
      return this.tableData.reduce((accum, item) => {
        return parseFloat(accum) + parseFloat(item.unitPrice * item.quantity);
      }, 0.0);
    },
    totalPayable() {
      let sum = this.totalUnitPrice + this.shippingCost + this.totalTax;
      let sub = this.totalSaving;
      let payable = sum - sub;
      return payable;
    },
    totalSaving() {
      if (this.config.enable_coupon_in_checkout == this.enums.status.ACTIVE) {
        return this.couponDiscounts.reduce((accum, item) => {
          return parseFloat(accum) + parseFloat(item.discount);
        }, 0.0);
      } else {
        return 0;
      }
    },
    enableApplyCoupon() {
      if (
        this.config.is_active_coupon == this.enums.status.ACTIVE &&
        this.config.enable_coupon_in_checkout == this.enums.status.ACTIVE
      ) {
        if (
          this.couponDiscounts.length > 0 &&
          this.config.enable_multiple_coupon_in_checkout ==
            this.enums.status.IN_ACTIVE
        ) {
          return false;
        } else if (
          this.config.enable_coupon_in_checkout == this.enums.status.IN_ACTIVE
        ) {
          return false;
        } else {
          return true;
        }
      } else {
        return false;
      }
    },
  }),
  watch: {
    totalUnitPrice() {
      this.removeCoupon();
    },
    totalPayable() {
      this.changeOrderTotal();
    },
  },
  mounted() {
    this.changeOrderTotal();
  },
  methods: {
    /**
     * Will apply coupon code
     *
     */
    applyCoupon() {
      let checkCoupon = this.couponDiscounts.find(
        (coupon) => coupon.coupon_code == this.coupon_code
      );
      if (checkCoupon) {
        this.$toast.error(this.$t("This coupon is already used"));
        return 0;
      }
      this.couponApplying = true;
      axios
        .post("/api/v1/ecommerce-core/apply-coupon", {
          coupon_code: this.coupon_code,
          products: JSON.stringify(this.$store.state.cart),
          customer_id: this.isCustomerLogin ? this.customer_id : null,
        })
        .then((response) => {
          if (response.data.success) {
            if (response.data.discount > 0) {
              let coupon_details = {
                discount: response.data.discount,
                id: response.data.coupon_id,
                coupon_code: this.coupon_code,
              };

              this.$store
                .dispatch("storeCouponDiscount", coupon_details)
                .then(() => {
                  this.$toast.success("Coupon applied successfully");
                  this.coupon_code = "";
                });
            }

            if (response.data.discount < 1) {
              this.$toast.error("Coupon is not applied");
            }
          }

          if (!response.data.success) {
            this.$toast.error(response.data.message);
          }

          this.couponApplying = false;
        })
        .catch((error) => {
          this.couponApplying = false;
          this.$toast.error("Something wrong, Please try again");
        });
    },
    /**
     * Remove Applied coupon
     */
    removeCoupon(code) {
      this.$store.dispatch("removeCouponDiscount", code).then(() => {
        this.$toast.success("Coupon Remove Successfully");
      });
    },

    /**
     * Will change order total
     */
    changeOrderTotal() {
      this.$emit("get-total-payable", this.totalPayable);
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.coupon-btn {
  display: inline-flex;
  align-items: center;
  text-transform: capitalize;
  padding: 9px 20px 10px;
  font-size: 16px;
  font-weight: 700;
  background-color: $c1;
  color: #ffffff;
  border: none;
  cursor: pointer;
  border-radius: 0;
}
.product-name {
  display: block;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
