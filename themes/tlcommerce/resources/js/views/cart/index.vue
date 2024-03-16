<template>
  <div class="">
    <page-header :items="bItems" />

    <div class="pt-60 pb-60 light-bg">
      <div class="custom-container2">
        <div class="row">
          <div class="col-12" v-if="!dataLoading">
            <div class="shadow-card" v-if="tableData.length">
              <h3 class="checkout-title">{{ $t("Your Cart") }}:</h3>
              <div class="table-responsive mt-3">
                <CTable class="cart-table">
                  <CTableHead>
                    <CTableRow>
                      <CTableHeaderCell>{{
                        $t("Product Name")
                      }}</CTableHeaderCell>
                      <CTableHeaderCell>{{
                        $t("Unit Price")
                      }}</CTableHeaderCell>
                      <CTableHeaderCell>{{ $t("Quantity") }}</CTableHeaderCell>
                      <CTableHeaderCell>{{ $t("Total") }}</CTableHeaderCell>
                      <CTableHeaderCell>{{ $t("Remove") }}</CTableHeaderCell>
                    </CTableRow>
                  </CTableHead>
                  <CTableBody>
                    <CTableRow v-for="tdata in tableData" :key="tdata.id">
                      <CTableDataCell class="w-50">
                        <div class="d-flex align-items-center">
                          <router-link :to="`/products/${tdata.permalink}`">
                            <img
                              :src="tdata.image"
                              :alt="tdata.name"
                              class="cart-image mr-10 rounded-circle"
                            />
                          </router-link>
                          <span>
                            <router-link
                              :title="`${tdata.name}`"
                              :to="`/products/${tdata.permalink}`"
                              class="product-name cart-product-name"
                              >{{ tdata.name }}</router-link
                            >
                            <div class="extra-addons-wrap d-flex flex-wrap">
                              <span
                                class="product-variant"
                                v-if="tdata.variant"
                              >
                                <product-variant
                                  class="font-weight-medium fz-14"
                                  :variant="tdata.variant"
                                ></product-variant>
                              </span>
                            </div>
                            <div
                              class="extra-addons-wrap d-flex flex-wrap mt-1"
                              v-if="tdata.attachment != null"
                            >
                              <div class="product-document">
                                <p class="font-weight-medium fz-14">
                                  {{ $t("Attachment") }}:
                                  {{ tdata.attachment.file_name }}
                                </p>
                              </div>
                            </div>
                          </span>
                        </div>
                      </CTableDataCell>
                      <CTableDataCell>
                        <the-currency :amount="tdata.unitPrice"></the-currency>
                        <the-currency
                          :amount="tdata.oldPrice"
                          tag="del"
                          class="ml-10"
                          v-if="tdata.oldPrice > tdata.unitPrice"
                        ></the-currency>
                      </CTableDataCell>
                      <CTableDataCell>
                        <div class="mx-auto quantity-input text-center d-flex">
                          <button
                            class="
                              d-flex
                              align-items-center
                              justify-content-center
                              p-0
                              bg-transparent
                              border-0
                            "
                            @click.prevent="decrease(tdata.uid)"
                          >
                            <span class="material-icons"> remove </span>
                          </button>
                          <input
                            v-model="tdata.quantity"
                            type="number"
                            class="border-0 text-center font-weight-bold w-100"
                            @change="
                              () => {
                                if (tdata.quantity > tdata.max_item) {
                                  tdata.quantity = tdata.max_item;
                                } else if (tdata.quantity < tdata.min_item) {
                                  tdata.quantity = tdata.min_item;
                                } else {
                                  tdata.quantity = parseInt(tdata.quantity);
                                }
                                updateCartInDatabase(tdata);
                              }
                            "
                          />
                          <button
                            class="
                              d-flex
                              align-items-center
                              justify-content-center
                              p-0
                              bg-transparent
                              border-0
                            "
                            @click.prevent="increase(tdata.uid)"
                          >
                            <span class="material-icons"> add </span>
                          </button>
                        </div>
                      </CTableDataCell>
                      <CTableDataCell class="fw-medium">
                        <the-currency
                          :amount="tdata.unitPrice * tdata.quantity"
                        ></the-currency>
                      </CTableDataCell>
                      <CTableDataCell>
                        <span
                          class="close-btn icon-wrap"
                          @click.prevent="removeItem(tdata.uid)"
                        >
                          <span class="material-icons"> close </span>
                        </span>
                      </CTableDataCell>
                    </CTableRow>
                  </CTableBody>
                </CTable>
                <div class="order-details">
                  <div class="table-responsive">
                    <table class="shop_table w-100">
                      <tbody>
                        <tr class="font-weight-bold">
                          <td>{{ $t("Subtotal") }}</td>
                          <td>
                            <span class="woocommerce-Price-amount amount">
                              <bdi>
                                <span
                                  class="woocommerce-Price-currencySymbol"
                                ></span>
                                <the-currency
                                  :amount="totalUnitPrice"
                                ></the-currency>
                                <p
                                  class="text text-danger"
                                  v-if="!proceedToCheckout"
                                >
                                  {{ $t("Minimum Order Amount") }}
                                  <the-currency
                                    :amount="config.min_order_amount"
                                    tag="span"
                                  ></the-currency>
                                </p>
                              </bdi>
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="mt-3 col-12 d-flex flex-wrap justify-content-between">
                <router-link
                  to="/products"
                  class="btn btn_border justify-content-center m-w-100 mb-20"
                >
                  <span class="material-icons me-2"> arrow_back </span>
                  {{ $t("Continue Shopping") }}
                </router-link>

                <button
                  type="button"
                  class="btn btn_fill mb-20 justify-content-center m-w-100"
                  @click.prevent="createOrder"
                  :disabled="!proceedToCheckout"
                >
                  {{ $t("Checkout") }}
                  <span class="material-icons ms-2"> arrow_forward </span>
                </button>
              </div>
            </div>
            <div v-else class="alert alert-danger">
              <p class="d-flex align-items-center justify-content-between">
                {{ $t("The Cart is Empty") }}
                <router-link
                  to="/products"
                  class="ml-4 font-weight-medium btn_underline"
                >
                  {{ $t("Back to Products") }}
                </router-link>
              </p>
            </div>
          </div>
          <div class="col-12" v-if="dataLoading">
            <skeleton class="w-100 mb-20" height="300px"></skeleton>
            <div class="mt-3 col-12 d-flex flex-wrap justify-content-between">
              <skeleton
                class="justify-content-center m-w-100 mb-20"
                tag="a"
                height="40px"
                width="150px"
              ></skeleton>
              <skeleton
                class="justify-content-center m-w-100 mb-20"
                tag="a"
                height="40px"
                width="150px"
              ></skeleton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import OrderTotal from "@/components/product/OrderTotal.vue";
import enums from "../../enums/enums";
import ProductVariant from "@/components/ui/ProductVariant.vue";
import { mapState } from "vuex";
import axios from "axios";
import {
  CTable,
  CTableHead,
  CTableBody,
  CTableRow,
  CTableDataCell,
  CTableHeaderCell,
} from "@coreui/vue";
export default {
  name: "Cart",
  layout: "main",
  components: {
    ProductVariant,
    PageHeader,
    CTable,
    CTableBody,
    CTableRow,
    CTableDataCell,
    CTableHeaderCell,
    CTableHead,
    OrderTotal,
  },
  data() {
    return {
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Cart"),
          active: true,
        },
      ],
      proceedToCheckout: false,
      dataLoading: true,
      config: "",
      enums: enums,
      errors: [],
    };
  },
  computed: mapState({
    tableData: (state) => state.cart,
    customerToken: (state) => state.customerToken,
    isCustomerLogin: (state) => state.isCustomerLogin,
    totalUnitPrice() {
      return this.tableData.reduce((accum, item) => {
        return parseFloat(accum) + parseFloat(item.unitPrice * item.quantity);
      }, 0.0);
    },
  }),
  mounted() {
    document.title = this.$t("Cart");
    this.getCheckoutConfig();
  },
  watch: {
    totalUnitPrice() {
      this.checkMinimumOrderAmount();
    },
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
            this.config = response.data.config;
            this.checkMinimumOrderAmount();
          }
          this.dataLoading = false;
        })
        .catch((error) => {
          this.dataLoading = false;
        });
    },
    /**
     *
     */
    checkMinimumOrderAmount() {
      if (this.config.enable_minumun_order_amount == this.enums.status.ACTIVE) {
        if (this.totalUnitPrice < this.config.min_order_amount) {
          this.proceedToCheckout = false;
        } else {
          this.proceedToCheckout = true;
        }
      } else {
        this.proceedToCheckout = true;
      }
    },
    nextStep() {
      this.$emit("go-next-step");
    },
    /**
     * Decrease item number from cart
     *
     * @param {*} id
     */
    decrease(id) {
      const data = this.tableData;
      for (let i = 0; i < data.length; i++) {
        const item = data[i];
        if (item.uid === id) {
          if (item.quantity > 1 && item.quantity > item.min_item) {
            item.quantity--;
            this.updateCartInDatabase(item);
          } else {
            return;
          }
        }
      }
    },
    /**
     * Increase item number from cart
     *
     * @param {*} id
     */
    increase(id) {
      const data = this.tableData;
      for (let i = 0; i < data.length; i++) {
        const item = data[i];
        if (item.uid === id) {
          if (item.quantity > 0 && item.quantity < item.max_item) {
            item.quantity++;
            this.updateCartInDatabase(item);
          } else {
            return;
          }
        }
      }
    },
    /**
     * This method will update cart
     */
    updateCartInDatabase(item) {
      if (this.isCustomerLogin) {
        this.$store.dispatch("showPreloader", true);
        axios
          .post(
            "/api/v1/ecommerce-core/customer/cart/update-cart-item",
            {
              item: JSON.stringify(item),
            },
            {
              headers: {
                Authorization: `Bearer ${this.customerToken}`,
              },
            }
          )
          .then((response) => {
            this.$store.dispatch("showPreloader", false);
            if (response.data.success) {
              this.$store.dispatch("updateCart", this.tableData);
            } else {
              this.$store.dispatch("updateCart", []);
            }
          })
          .catch((error) => {
            this.$store.dispatch("showPreloader", false);
            this.$store.dispatch("updateCart", []);
          });
      } else {
        this.$store.dispatch("updateCart", this.tableData);
      }
    },

    /**
     * Remove item from cart
     *
     * @param {*} index
     */
    removeItem(index) {
      this.updatedTableData = this.tableData.filter(
        (item) => item.uid !== index
      );
      if (this.isCustomerLogin) {
        this.$store.dispatch("showPreloader", true);
        axios
          .post(
            "/api/v1/ecommerce-core/customer/cart/remove-item",
            {
              uid: index,
            },
            {
              headers: {
                Authorization: `Bearer ${this.customerToken}`,
              },
            }
          )
          .then((response) => {
            this.$store.dispatch("showPreloader", false);
            if (response.data.success) {
              this.$store
                .dispatch("updateCart", this.updatedTableData)
                .then(() => {
                  this.$toast.success("Product remove from cart successfully");
                });
            }
          })
          .catch((error) => {
            this.$store.dispatch("showPreloader", false);
          });
      } else {
        this.$store.dispatch("updateCart", this.updatedTableData).then(() => {
          this.$toast.success("Product remove from cart successfully");
        });
      }
    },
    /**
     * Go to checkout page
     *
     */
    createOrder() {
      this.$router.push("/checkout");
    },
  },
};
</script>
