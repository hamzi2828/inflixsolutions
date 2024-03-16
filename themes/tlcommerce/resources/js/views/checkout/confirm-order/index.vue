<template>
  <div class="">
    <page-header :items="bItems" />

    <div class="pt-60 pb-60 light-bg">
      <div class="custom-container2">
        <div class="row" v-if="!dataLoading">
          <div class="col-12" v-if="success">
            <div class="shadow-card py-5 text-center mb-30">
              <img
                src="/public/themes/tlcommerce/assets/img/complete-order.png"
                class="mb-4"
                alt="Order"
              />
              <h3>{{ $t("Thank You Your Order") }}!</h3>
              <h4>{{ $t("Order ID") }}: {{ orderDetails.order_code }}</h4>
            </div>

            <div class="shadow-card mb-30">
              <h3 class="order-summery-title">{{ $t("Order Summery") }}</h3>

              <div class="row mt-4">
                <div class="col-lg-6">
                  <ul
                    class="order-summery-list"
                    v-if="orderDetails.pickup_point == null"
                  >
                    <li>
                      <span>{{ $t("Order Code") }}:</span
                      >{{ orderDetails.order_code }}
                    </li>
                    <template v-if="orderDetails.shipping_details">
                      <li>
                        <span>{{ $t("Name") }}:</span
                        >{{ orderDetails.shipping_details.name }}
                      </li>
                      <li>
                        <span>{{ $t("Mobile") }}:</span
                        >{{ orderDetails.shipping_details.phone }}
                      </li>
                      <li>
                        <span>{{ $t("Address") }}:</span>
                        {{ orderDetails.shipping_details.address }},
                        {{ orderDetails.shipping_details.city }},
                        {{ orderDetails.shipping_details.state }},
                        {{ orderDetails.shipping_details.country }}.
                      </li>
                      <li>
                        <span>{{ $t("Postal Code") }}:</span
                        >{{ orderDetails.shipping_details.postal_code }}
                      </li>
                    </template>
                  </ul>
                  <ul class="order-summery-list" v-else>
                    <li>
                      <span>{{ $t("Order Code") }}:</span
                      >{{ orderDetails.order_code }}
                    </li>
                    <template v-if="orderDetails.pickup_point">
                      <li>
                        <span>{{ $t("Pickup Point") }}:</span
                        >{{ orderDetails.pickup_point.name }}
                      </li>
                      <li>
                        <span>{{ $t("Mobile") }}:</span
                        >{{ orderDetails.pickup_point.phone }}
                      </li>
                      <li>
                        <span>{{ $t("Address") }}:</span>
                        {{ orderDetails.pickup_point.location }}
                      </li>
                    </template>
                  </ul>
                </div>
                <div class="col-lg-6 mt-2 mt-lg-0">
                  <ul class="order-summery-list">
                    <li>
                      <span>{{ $t("Order Date") }}:</span
                      >{{ orderDetails.order_date }}
                    </li>
                    <li class="text-capitalize">
                      <span>{{ $t("Order Status") }}:</span
                      >{{ orderDetails.delivery_status_label }}
                    </li>
                    <li class="text-capitalize">
                      <span>{{ $t("Total Amount") }}:</span
                      ><the-currency
                        :amount="orderDetails.total_payable_amount"
                      ></the-currency>
                    </li>
                    <li class="text-capitalize">
                      <span>{{ $t("Payment Status") }}:</span
                      >{{ orderDetails.payment_status_label }}
                    </li>
                    <li class="text-capitalize">
                      <span>{{ $t("Payment method") }}:</span
                      >{{ orderDetails.payment_method }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="shadow-card">
              <h3 class="checkout-title">{{ $t("Order Details") }}:</h3>

              <div class="table-responsive mt-3">
                <CTable class="cart-table">
                  <CTableHead>
                    <CTableRow>
                      <CTableHeaderCell>{{
                        $t("Product Name")
                      }}</CTableHeaderCell>
                      <CTableHeaderCell>{{
                        $t("Price") + "/" + $t("Unit")
                      }}</CTableHeaderCell>
                      <CTableHeaderCell>{{ $t("Quantity") }}</CTableHeaderCell>
                      <CTableHeaderCell>{{ $t("Total") }}</CTableHeaderCell>
                    </CTableRow>
                  </CTableHead>
                  <CTableBody>
                    <CTableRow
                      v-for="product in orderDetails.products.data"
                      :key="product.id"
                    >
                      <CTableDataCell class="w-50">
                        <div class="d-flex align-items-center">
                          <span>
                            <img
                              :src="product.image"
                              :alt="product.name"
                              class="cart-image mr-10 rounded-circle"
                            />
                          </span>
                          <span class="product-name cart-product-name">{{
                            product.name
                          }}</span>
                        </div>
                      </CTableDataCell>
                      <CTableDataCell
                        ><the-currency
                          :amount="product.unit_price"
                        ></the-currency>
                      </CTableDataCell>
                      <CTableDataCell>{{ product.quantity }}</CTableDataCell>
                      <CTableDataCell class="fw-medium"
                        ><the-currency
                          :amount="product.unit_price * product.quantity"
                        ></the-currency
                      ></CTableDataCell>
                    </CTableRow>
                  </CTableBody>
                </CTable>
              </div>
              <div class="order-details">
                <div class="table-responsive">
                  <table class="shop_table w-100">
                    <tbody>
                      <tr class="cart-subtotal">
                        <td>{{ $t("Subtotal") }}</td>
                        <td>
                          <span class="woocommerce-Price-amount amount"
                            ><bdi
                              ><span
                                class="woocommerce-Price-currencySymbol"
                              ></span>
                              <the-currency
                                :amount="orderDetails.sub_total"
                              ></the-currency> </bdi
                          ></span>
                        </td>
                      </tr>
                      <tr class="shipping-cost">
                        <td>{{ $t("Shipping Cost") }}</td>
                        <td>
                          <span class="woocommerce-Price-amount amount"
                            ><bdi
                              ><span class="woocommerce-Price-currencySymbol"
                                >+</span
                              >
                              <the-currency
                                :amount="orderDetails.total_delivery_cost"
                              ></the-currency> </bdi
                          ></span>
                        </td>
                      </tr>
                      <tr class="order-tax" v-if="orderDetails.total_tax > 0">
                        <td>
                          {{ $t("Tax") }}
                        </td>
                        <td>
                          <span class="woocommerce-Price-amount amount">
                            <bdi
                              ><span class="woocommerce-Price-currencySymbol"
                                >+</span
                              >
                              <the-currency
                                :amount="orderDetails.total_tax"
                              ></the-currency>
                            </bdi>
                          </span>
                        </td>
                      </tr>
                      <tr
                        class="order-savings"
                        v-if="orderDetails.total_discount > 0"
                      >
                        <td>
                          {{ $t("Discount") }}
                        </td>
                        <td>
                          <span class="woocommerce-Price-amount amount">
                            <bdi
                              ><span class="woocommerce-Price-currencySymbol"
                                >-</span
                              >
                              <the-currency
                                :amount="orderDetails.total_discount"
                              ></the-currency>
                            </bdi>
                          </span>
                        </td>
                      </tr>

                      <tr class="order-total">
                        <td class="c1">{{ $t("Payable Total") }}</td>
                        <td>
                          <span class="woocommerce-Price-amount amount c1">
                            <bdi>
                              <span
                                class="woocommerce-Price-currencySymbol"
                              ></span>
                              <the-currency
                                :amount="orderDetails.total_payable_amount"
                              ></the-currency>
                            </bdi>
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="mt-3 d-flex flex-wrap justify-content-between">
                <router-link
                  to="/dashboard/purchase-history"
                  class="btn btn_fill mb-1"
                >
                  {{ $t("View Orders") }}
                </router-link>
                <router-link to="/products" class="btn btn_fill mb-1">
                  {{ $t("Shop More") }}
                </router-link>
              </div>
            </div>
          </div>
          <div class="col-12" v-else>
            <div class="shadow-card py-5 text-center mb-30">
              <the-not-found title="Order details not found"> </the-not-found>
            </div>
          </div>
        </div>
        <div v-if="dataLoading">
          <skeleton width="100%" height="300px" class="mb-30"> </skeleton>
          <skeleton width="100%" height="500px"> </skeleton>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import axios from "axios";
import { mapState } from "vuex";
import {
  CTable,
  CTableHead,
  CTableBody,
  CTableRow,
  CTableDataCell,
  CTableHeaderCell,
} from "@coreui/vue";
export default {
  name: "SuccessOrder",
  layout: "main",
  components: {
    PageHeader,
    CTable,
    CTableBody,
    CTableRow,
    CTableDataCell,
    CTableHeaderCell,
    CTableHead,
  },
  data() {
    return {
      pageTitle: this.$t("Confirm Order"),
      order_code: "",
      quantityValue: 1,
      subtotal: 990,
      deliveryCost: 50,
      couponDiscount: 100,
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Confirm Order"),
          active: true,
        },
      ],
      orderDetails: {},
      success: false,
      dataLoading: true,
    };
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    isCustomerLogin: (state) => state.isCustomerLogin,
  }),
  mounted() {
    document.title = this.$t("Success Order");
    this.order_code = this.$route.params.id;
    if (this.isCustomerLogin) {
      this.customerOrderDetails();
    } else {
      this.guestCustomerOrderDetails();
    }
  },
  methods: {
    /**
     * Get successful order details
     *
     */
    customerOrderDetails() {
      axios
        .post(
          "/api/v1/ecommerce-core/customer/order/details",
          {
            order_code: this.order_code,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.orderDetails = response.data.data;
            this.success = true;
          } else {
            this.$toast.error("Order not found");
          }
          this.dataLoading = false;
        })
        .catch((error) => {
          this.$toast.error("Order not found");
          this.dataLoading = false;
        });
    },
    /**
     * Get guest customer order details
     */
    guestCustomerOrderDetails() {
      axios
        .post("/api/v1/ecommerce-core/guest/order/details", {
          order_code: this.order_code,
        })
        .then((response) => {
          if (response.data.success) {
            this.orderDetails = response.data.data;
            this.success = true;
          } else {
            this.$toast.error("Order not found");
          }
          this.dataLoading = false;
        })
        .catch((error) => {
          this.dataLoading = false;
          this.$toast.error("Order not found");
        });
    },
  },
};
</script>
