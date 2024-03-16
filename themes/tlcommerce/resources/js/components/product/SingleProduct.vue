<template>
  <!--Product Page style-->
  <div
    v-if="styleEight"
    class="single-product-item d-inline-block mb-4 style--eight"
  >
    <div class="position-relative overflow-hidden">
      <!-- Thumb -->
      <router-link :to="`/products/${item.slug}`" class="d-block">
        <v-lazy-image
          class="w-100"
          :src="item.thumbnail_image"
          :alt="item.name"
        />
      </router-link>
      <!-- End Thumb -->

      <!-- Action buttons -->
      <div
        class="product-action-buttons position-absolute fixed-top w-100 h-100 d-flex align-items-center justify-content-center "
      >
        <!-- Add to Cart -->
        <button
          v-if="item.quantity > 0"
          class="btn-circle bg-black"
          v-bind:title="$t('Add To Cart')"
          v-on="
            item.has_variant == 2
              ? { click: () => addToCart() }
              : { click: () => productQuickView() }
          "
        >
          <base-icon-svg name="cart" :height="17.5" :width="17.5" />
        </button>
        <!-- End Add to Cart -->

        <!-- Add to Wishlist -->
        <button
          class="btn-circle bg-black"
          v-bind:title="$t('Add To Wishlist')"
          @click.prevent="addToWishlist"
        >
          <base-icon-svg name="wishlist" :height="16.5" :width="16.5" />
        </button>
        <!-- End Add to Wishlist -->

        <!-- Quick view -->
        <button
          class="btn-circle bg-black"
          v-bind:title="$t('Quick View')"
          @click.prevent="productQuickView()"
        >
          <base-icon-svg name="quickview" :height="17.688" :width="18.8" />
        </button>
        <!-- End Quick view -->
      </div>
      <!-- End Action buttons -->
    </div>

    <!-- Summary -->
    <div class="d-flex flex-column justify-content-between product-summary">
      <!-- Rating -->
      <div
        class="star-rating"
        v-if="
          site_config.enable_product_reviews == 1 &&
          site_config.enable_product_star_rating == 1
        "
      >
        <div class="product-rating-wrapper">
          <i :data-star="item.avg_rating" :title="item.avg_rating"></i>
        </div>
      </div>
      <!-- End Rating -->

      <!-- Title -->
      <h4 class="product-title">
        <router-link :to="`/products/${item.slug}`">
          {{ item.name }}
        </router-link>
      </h4>
      <!-- End Title -->

      <!-- Price -->
      <span class="product-price d-flex flex-wrap">
        <the-currency
          :amount="item.price"
          tag="span"
          v-if="item.base_price > item.price"
        ></the-currency>
        <the-currency
          :amount="item.base_price"
          tag="span"
          v-else
        ></the-currency>
        <the-currency
          :amount="item.base_price"
          tag="del"
          v-if="item.base_price > item.price"
        ></the-currency>
      </span>
      <!-- End Price -->
    </div>
    <!-- End Summary -->
    <!-- Quick View Modal -->
    <teleport to="body">
      <CModal
        scrollable
        :visible="visibleQuickView"
        size="lg"
        @close="
          () => {
            visibleQuickView = false;
          }
        "
      >
        <CModalHeader>
          <button class="btn-circle bg-black size-35" @click="close()">
            <base-icon-svg name="close" :width="10" :height="10" />
          </button>
        </CModalHeader>

        <CModalBody>
          <div class="row">
            <div class="col-lg-6 mb-30 mb-lg-0">
              <details-gallery
                :gallery-images="product.galleryImages"
                :voucher-list="product.voucher_list"
                :product-name="product.name"
                :url="product.url"
                :summary="product.summary"
                :networks="product.shareOptions"
              />
            </div>

            <div class="col-lg-6">
              <details-content
                :product="product"
                @color-variant-images="colorVariantImages"
                :key="product.id"
              />
            </div>
          </div>
        </CModalBody>
      </CModal>
    </teleport>
    <!-- End Quick View Modal -->
  </div>
  <!--End Product Page style-->
  <!--Product search style-->
  <div
    class="single-product-item style--eight d-flex flex-column m-0"
    v-else-if="small"
  >
    <div class="position-relative overflow-hidden d-flex">
      <!-- Thumb -->
      <router-link :to="`/products/${item.slug}`" class="d-block pr-10">
        <v-lazy-image
          :src="item.thumbnail_image"
          :alt="item.name"
          class="small-image"
        />
      </router-link>
      <!-- End Thumb -->
      <!-- Summary -->
      <div class="p-0">
        <!-- Title -->
        <h6 class="product-title m-0">
          <router-link :to="`/products/${item.slug}`">
            {{ item.name }}
          </router-link>
        </h6>
        <!-- End Title -->

        <!-- Price -->
        <span class="product-price">
          <the-currency
            :amount="item.price"
            tag="span"
            v-if="item.base_price > item.price"
          ></the-currency>
          <the-currency
            :amount="item.base_price"
            tag="span"
            v-else
          ></the-currency>
          <the-currency
            :amount="item.base_price"
            tag="del"
            v-if="item.base_price > item.price"
          ></the-currency>
        </span>
        <!-- End Price -->
      </div>
      <!-- End Summary -->
    </div>
  </div>
  <!--End Product search style-->
  <!-- Wishlist style-->
  <CTableRow v-else-if="wishlistStyle">
    <CTableDataCell>
      <div class="d-flex align-items-center">
        <div class="product-img">
          <router-link :to="`/products/${item.slug}`">
            <img
              :src="item.thumbnail_image"
              :alt="item.name"
              class="small-image"
            />
          </router-link>
        </div>
        <div>
          <router-link :to="`/products/${item.slug}`">
            <span class="product-name">{{ item.name }}</span>
          </router-link>
        </div>
      </div>
    </CTableDataCell>
    <CTableDataCell>
      <span class="product-price">
        <the-currency
          :amount="item.price"
          tag="span"
          v-if="item.base_price > item.price"
        ></the-currency>
        <the-currency
          v-else
          :amount="item.base_price"
          tag="span"
        ></the-currency>
        <the-currency
          v-if="item.base_price > item.price"
          :amount="item.base_price"
          tag="del"
          class="ml-10"
        ></the-currency>
      </span>
    </CTableDataCell>
    <CTableDataCell>
      <span
        class="cart-icon"
        v-bind:title="$t('Add To Cart')"
        v-if="item.quantity > 0"
        v-on="
          item.has_variant == 2
            ? { click: () => addToCart() }
            : { click: () => productQuickView() }
        "
      >
        <span class="material-icons"> shopping_cart </span>
      </span>
    </CTableDataCell>
    <CTableDataCell class="text-center">
      <span
        class="remove-icon"
        title="remove item"
        @click.prevent="removeItemFromWishlist(item.id)"
      >
        <span class="material-icons"> delete </span>
      </span>
    </CTableDataCell>
    <!-- Quick View Modal -->
    <teleport to="body">
      <CModal
        scrollable
        :visible="visibleQuickView"
        size="lg"
        @close="
          () => {
            visibleQuickView = false;
          }
        "
      >
        <CModalHeader>
          <button class="btn-circle bg-black size-35" @click="close()">
            <base-icon-svg name="close" :width="10" :height="10" />
          </button>
        </CModalHeader>

        <CModalBody>
          <div class="row">
            <div class="col-lg-6 mb-30 mb-lg-0">
              <details-gallery
                :gallery-images="product.galleryImages"
                :voucher-list="product.voucher_list"
                :product-name="product.name"
                :url="product.url"
                :summary="product.summary"
                :networks="product.shareOptions"
              />
            </div>

            <div class="col-lg-6">
              <details-content
                :product="product"
                @color-variant-images="colorVariantImages"
                :key="product.id"
              />
            </div>
          </div>
        </CModalBody>
      </CModal>
    </teleport>
    <!-- End Quick View Modal -->
  </CTableRow>
  <!-- End Wishlist style-->
  <!--Compare page style-->
  <div class="compare-style-product" v-else-if="compareStyle">
    <button
      class="btn btn_bordered"
      v-bind:title="$t('Add To Cart')"
      :disabled="item.quantity < 1"
      v-on="
        item.has_variant == 2
          ? { click: () => addToCart() }
          : { click: () => productQuickView() }
      "
    >
      {{ $t("Add To Cart") }}
    </button>
    <!-- Quick View Modal -->
    <teleport to="body">
      <CModal
        scrollable
        :visible="visibleQuickView"
        size="lg"
        @close="
          () => {
            visibleQuickView = false;
          }
        "
      >
        <CModalHeader>
          <button class="btn-circle bg-black size-35" @click="close()">
            <base-icon-svg name="close" :width="10" :height="10" />
          </button>
        </CModalHeader>

        <CModalBody>
          <div class="row">
            <div class="col-lg-6 mb-30 mb-lg-0">
              <details-gallery
                :gallery-images="product.galleryImages"
                :voucher-list="product.voucher_list"
                :product-name="product.name"
                :url="product.url"
                :summary="product.summary"
                :networks="product.shareOptions"
              />
            </div>

            <div class="col-lg-6">
              <details-content
                :product="product"
                @color-variant-images="colorVariantImages"
                :key="product.id"
              />
            </div>
          </div>
        </CModalBody>
      </CModal>
    </teleport>
    <!-- End Quick View Modal -->
  </div>
  <!--End compare page style-->
  <!--Home page style-->
  <div v-else class="single-product-item d-flex flex-column">
    <div class="position-relative overflow-hidden">
      <!-- Thumb -->
      <router-link :to="`/products/${item.slug}`" class="d-block">
        <v-lazy-image
          class="w-100"
          :src="item.thumbnail_image"
          :alt="item.name"
        />
      </router-link>
      <!-- End Thumb -->

      <!-- Action buttons -->
      <div
        class="product-action-buttons position-absolute fixed-top w-100 h-100 d-flex align-items-center justify-content-center "
      >
        <!-- Add to Cart -->
        <button
          v-if="item.quantity > 0"
          class="btn-circle bg-black"
          v-bind:title="$t('Add To Cart')"
          v-on="
            item.has_variant == 2
              ? { click: () => addToCart() }
              : { click: () => productQuickView() }
          "
        >
          <base-icon-svg name="cart" :height="17.5" :width="17.5" />
        </button>
        <!-- End Add to Cart -->

        <!-- Add to Wishlist -->
        <button
          class="btn-circle bg-black"
          v-bind:title="$t('Add To Wishlist')"
          @click.prevent="addToWishlist"
        >
          <base-icon-svg name="wishlist" :height="16.5" :width="16.5" />
        </button>
        <!-- End Add to Wishlist -->

        <!-- Quick view -->
        <button
          class="btn-circle bg-black"
          v-bind:title="$t('Quick View')"
          @click.prevent="productQuickView()"
        >
          <base-icon-svg name="quickview" :height="17.688" :width="18.8" />
        </button>
        <!-- End Quick view -->
      </div>
      <!-- End Action buttons -->

      <!-- Discount -->
      <div v-if="item.discount > 0" class="badge-container">
        <span class="product-badge">
          <span v-if="item.discount.discountType == 1">
            -{{ item.discount }}%
          </span>
          <span v-else>
            -{{ item.discount.discount_amount }}{{ this.currency.symbol }}</span
          >
        </span>
      </div>
      <!-- End Discount -->
    </div>

    <!-- Summary -->
    <div class="product-summary text-center">
      <!-- Rating -->
      <div
        class="star-rating mx-auto"
        v-if="
          site_config.enable_product_reviews == 1 &&
          site_config.enable_product_star_rating == 1
        "
      >
        <div class="product-rating-wrapper">
          <i :data-star="item.avg_rating" :title="item.avg_rating"></i>
        </div>
      </div>
      <!-- End Rating -->

      <!-- Title -->
      <h4 class="product-title">
        <router-link :to="`/products/${item.slug}`">
          {{ item.name }}
        </router-link>
      </h4>
      <!-- End Title -->

      <!-- Price -->
      <span class="product-price">
        <the-currency
          :amount="item.price"
          tag="span"
          v-if="item.base_price > item.price"
        ></the-currency>
        <the-currency
          :amount="item.base_price"
          tag="span"
          v-else
        ></the-currency>
        <the-currency
          :amount="item.base_price"
          tag="del"
          v-if="item.base_price > item.price"
        ></the-currency>
      </span>
      <!-- End Price -->
    </div>
    <!-- End Summary -->
    <!-- Quick View Modal -->
    <teleport to="body">
      <CModal
        scrollable
        :visible="visibleQuickView"
        size="lg"
        @close="
          () => {
            visibleQuickView = false;
          }
        "
      >
        <CModalHeader>
          <button class="btn-circle bg-black size-35" @click="close()">
            <base-icon-svg name="close" :width="10" :height="10" />
          </button>
        </CModalHeader>

        <CModalBody>
          <div class="row">
            <div class="col-lg-6 mb-30 mb-lg-0">
              <details-gallery
                :gallery-images="product.galleryImages"
                :voucher-list="product.voucher_list"
                :product-name="product.name"
                :url="product.url"
                :summary="product.summary"
                :networks="product.shareOptions"
              />
            </div>

            <div class="col-lg-6">
              <details-content
                :product="product"
                @color-variant-images="colorVariantImages"
                :key="product.id"
              />
            </div>
          </div>
        </CModalBody>
      </CModal>
    </teleport>
    <!-- End Quick View Modal -->
  </div>
  <!--End home page style-->
</template>

<script>
import DetailsGallery from "@/components/product/DetailsGallery.vue";
import DetailsContent from "@/components/product/DetailsContent.vue";
import VLazyImage from "v-lazy-image";
const axios = require("axios").default;
import { mapState } from "vuex";
import {
  CModal,
  CButton,
  CModalHeader,
  CModalTitle,
  CModalBody,
  CModalFooter,
  CTableDataCell,
  CTableHeaderCell,
  CTableHead,
  CTableRow,
} from "@coreui/vue";

export default {
  name: "SingleProduct",
  emits: ["remove-wishlist"],
  components: {
    "v-lazy-image": VLazyImage,
    DetailsGallery,
    DetailsContent,
    CModal,
    CButton,
    CModalHeader,
    CModalBody,
    CModalFooter,
    CModalTitle,
    CTableDataCell,
    CTableHeaderCell,
    CTableHead,
    CTableRow,
  },
  props: {
    item: {
      type: Object,
      required: true,
    },
    styleEight: {
      type: Boolean,
      default: false,
    },
    small: {
      type: Boolean,
      default: false,
    },
    wishlistStyle: {
      type: Boolean,
      default: false,
    },
    compareStyle: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      quantityValue:
        this.item.min_qty != null && this.item.min_qty > 0
          ? parseInt(this.item.min_qty)
          : 1,
      visibleQuickView: false,
      product: {},
      galleryKey: 0,
    };
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    isCustomerLogin: (state) => state.isCustomerLogin,
    site_config: (state) => state.siteSettings,
    currency: (state) => state.currency,
    min_qty() {
      return this.item.min_qty != null && parseInt(this.item.min_qty) > 0
        ? parseInt(this.item.min_qty)
        : 1;
    },
    max_qty() {
      return this.item.max_qty != null &&
        parseInt(this.item.max_qty) > 0 &&
        parseInt(this.item.max_qty) < parseInt(this.item.quantity)
        ? parseInt(this.item.max_qty)
        : this.item.quantity;
    },
  }),
  methods: {
    /**
     * Product quick view
     */
    productQuickView() {
      this.$store.dispatch("showPreloader", true);
      axios
        .post("/api/v1/ecommerce-core/product-details", {
          permalink: this.item.slug,
        })
        .then((response) => {
          if (response.data.success) {
            this.product = response.data.data;
            this.visibleQuickView = true;
            this.$store.dispatch("showPreloader", false);
          } else {
            this.$store.dispatch("showPreloader", false);
            this.$toast.error(this.$t("Product Loading Failed"));
          }
        })
        .catch((error) => {
          this.$store.dispatch("showPreloader", false);
          this.$toast.error(this.$t("Product Loading Failed"));
        });
    },
    /**
     * Color variant gallery images
     */
    colorVariantImages(color_id) {
      this.$store.dispatch("showPreloader", true);
      this.galleryKey = this.galleryKey + 1;
      axios
        .post("/api/v1/ecommerce-core/color-variant-images", {
          product_id: this.product.id,
          color_id: color_id,
        })
        .then((response) => {
          if (response.data.success) {
            this.product.galleryImages = response.data.images;
            this.$store.dispatch("showPreloader", false);
          } else {
            this.$store.dispatch("showPreloader", false);
          }
        })
        .catch((error) => {
          this.$store.dispatch("showPreloader", false);
        });
    },
    /**
     * Store items to cart
     */
    addToCart() {
      let cart_item = {
        uid: Date.now(),
        id: this.item.id,
        name: this.item.name,
        permalink: this.item.slug,
        image: this.item.thumbnail_image,
        variant: "",
        variant_code: "",
        unitPrice: this.item.price,
        oldPrice: this.item.base_price,
        attachment: null,
        quantity: this.quantityValue,
        max_item: this.max_qty,
        min_item: this.min_qty,
      };
      this.$store.dispatch("addToCart", cart_item);
    },
    /**
     * Add to wishlist
     */
    addToWishlist() {
      if (this.isCustomerLogin) {
        axios
          .post(
            "/api/v1/ecommerce-core/customer/store-product-to-wishlist",
            {
              product_id: this.item.id,
            },
            {
              headers: {
                Authorization: `Bearer ${this.customerToken}`,
              },
            }
          )
          .then((response) => {
            if (response.data.success) {
              this.$store.dispatch("refreshCustomerDashboardInfo");
              this.$toast.success("Product added to wishlist successfully");
            } else {
              this.$toast.error("Product add to wishlist failed");
            }
          })
          .catch((error) => {
            this.$toast.error("Product add to wishlist failed 1");
          });
      } else {
        this.$toast.error("Please login");
        this.$router.push("/login");
      }
    },
    /**
     *Remove product from wishlist
     */
    removeItemFromWishlist(product_id) {
      if (this.isCustomerLogin) {
        axios
          .post(
            "/api/v1/ecommerce-core/customer/product-remove-from-wishlist",
            {
              product_id: product_id,
            },
            {
              headers: {
                Authorization: `Bearer ${this.customerToken}`,
              },
            }
          )
          .then((response) => {
            if (response.data.success) {
              this.$emit("remove-wishlist");
              this.$store.dispatch("refreshCustomerDashboardInfo");
              this.$toast.success("Product remove from wishlist successfully");
            } else {
              this.$toast.error("Product remove from wishlist failed");
            }
          })
          .catch((error) => {
            this.$toast.error("Product remove from wishlist failed");
          });
      } else {
        this.$toast.error("Please login");
        this.$router.push("/login");
      }
    },
    close() {
      this.visibleQuickView = false;
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.single-product-item {
  background-color: #f7f8fa;
  margin-bottom: 30px;
  .badge-container {
    position: absolute;
    right: 0;
    top: 0;
    width: 90px;
    height: 90px;
    .product-badge {
      position: absolute;
      width: calc(100% * 2);
      left: -30%;
      transform: rotate(45deg);
      top: 5px;
      padding: 9px 10px;
      font-weight: 500;
      color: #fff;
      background-color: $c1;
      text-align: center;
      font-size: 13px;
    }
  }
  .product-action-buttons {
    transition: 0.2s ease-in;
    opacity: 0;
    visibility: hidden;
    > button {
      transform: scale(0.8);
      &:nth-child(2) {
        transition-delay: 0.05s;
      }
      &:nth-child(3) {
        transition-delay: 0.1s;
      }
      &:not(:last-child) {
        margin-right: 10px;
      }
    }
  }
  .product-price {
    font-size: 16px;
    font-weight: 700;
    color: $c1;
    del {
      font-weight: 700;
      font-size: 12px;
      margin-left: 12px;
      color: $text-color-light;
    }
    @media (min-width: 479px) {
      font-size: 18px;
      del {
        font-size: 14px;
      }
    }
  }
  .product-title {
    margin: 12px 0 6px;
    font-weight: 500;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    overflow: hidden;
    @media (max-width: 479px) {
      font-size: 14px;
    }
  }
  .product-summary {
    padding: 20px;
    padding-top: 24px;
    min-height: 134px;
    @media (max-width: 479px) {
      padding: 14px;
      padding-top: 18px;
    }
  }
  &:hover {
    .product-action-buttons {
      opacity: 1;
      visibility: visible;
      > button {
        transform: scale(1);
      }
      @media (max-width: 479px) {
        display: none !important;
      }
    }
  }
  &.style--eight {
    box-shadow: 3px 3px 30px rgba(0, 0, 0, 0.03);
    background-color: #fff;
    .product-title {
      font-weight: 500;
      margin: 8px 0 6px;
    }
    .product-price {
      font-size: 16px;
      font-weight: 900;
      color: #363232;
    }
    .text-rating {
      .rating {
        font-size: 12px;
      }
    }
    &:hover {
      box-shadow: 5px 5px 60px rgba(0, 0, 0, 0.05);
    }
  }
  &--two {
    .product-thumb {
      width: 160px;
      height: 160px;
      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }
    &.small {
      .product-thumb {
        width: 100px;
        height: 100px;
      }
      p {
        font-size: 14px;
      }
    }
    .old-price {
      position: relative;
      color: $title-color;
      font-size: 16px;
      font-weight: $medium;
      margin-right: 13px;
      &::after {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        height: 1px;
        background-color: $c1;
        content: "";
      }
    }

    .new-price {
      font-size: 13px;
      font-weight: $medium;
      background-color: $c1;
      color: $white;
      padding: 4px 6px;
      border-radius: 50px;
    }
  }
  &--three {
    padding: 20px;
    background-color: #f9f9f9;
    .product-thumb {
      max-width: 120px;
    }
    .product-category {
      font-size: 10px;
      line-height: 14px;
      margin-bottom: 3px;
    }
    .product-title {
      font-size: 21px;
      line-height: 31px;
      margin-bottom: 6px;
      a:hover {
        color: $c4;
      }
    }
    .product-price {
      font-size: 14px;
      font-weight: $medium;
    }
    .cart-btn {
      color: $c4;
      line-height: 17px;
      margin-top: 14px;
      &:hover {
        color: $title-color-four;
      }
    }
  }
  &--four {
    background-color: #f9f9f9;
    border-radius: 3px;
    overflow: hidden;
    .product-action-buttons {
      transition: 0.2s ease-in;
      opacity: 0;
      visibility: hidden;
      > button {
        transform: scale(0.8);
        border-radius: 3px;
        background-color: $white;
        color: $c4;
        &:nth-child(2) {
          transition-delay: 0.05s;
        }
        &:nth-child(3) {
          transition-delay: 0.1s;
        }
        &:not(:last-child) {
          margin-right: 10px;
        }
        &:hover {
          background-color: $c4;
          border-color: $c4;
          color: $white;
        }
      }
    }
    .product-summary {
      padding: 26px 30px 35px;
    }
    .product-category {
      font: 10px $title-font;
      font-weight: $medium;
      margin-bottom: 5px;
    }
    .product-title {
      margin-bottom: 5px;
      a:hover {
        color: $c4;
      }
    }
    .product-price {
      font-size: 14px;
      font-weight: $medium;
      line-height: 19px;
      color: $title-color-four;
    }
    .quantity-input {
      border: 1px solid #e5e5e5;
      border-radius: 3px;
      width: 104px;
      align-items: center;
      background-color: $white;
    }
    .quantity-input {
      margin-right: 7px;
      > * {
        width: 34px;
        height: 33px;
        min-width: 34px;
        background-color: transparent;
      }
      input {
        font-size: 12px;
        font-family: $base-font;
        font-weight: $regular;
      }
      button {
        &:first-of-type {
          border-right: 1px solid #e5e5e5 !important;
        }
        &:last-of-type {
          border-left: 1px solid #e5e5e5 !important;
        }
      }
    }
    .cart-btn {
      background-color: rgba($color: $c4, $alpha: 0.1);
      color: $c4;
      text-transform: uppercase;
      font-size: 12px;
      font-weight: $bold;
      padding: 7.5px 17px;
      display: flex;
      align-items: center;
      &:hover {
        background-color: $c4;
        color: $white;
      }
    }
    &:hover {
      .product-action-buttons {
        opacity: 1;
        visibility: visible;
        > button {
          transform: scale(1);
        }
      }
    }
  }
  &--five {
    .product-thumb {
      width: 100px;
      height: 100px;
      position: relative;
      img {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }
    .star-rating {
      margin-bottom: 7px;
    }
    .product-title {
      font-size: 21px;
      $lh: 1.476;
      line-height: $lh;
      margin-bottom: 6px;
    }
    .product-price {
      font-size: 14px;
      font-weight: $medium;
      > span {
        margin-right: 12px;
      }
    }
  }
  &--six {
    border: 1px solid #ebebeb;
    border-radius: 5px;
    .product-category {
      font-size: 10px;
      line-height: 14px;
      font-weight: $medium;
    }
    .product-title {
      font-size: 21px;
      $lh: 1.476;
      line-height: $lh;
      margin-bottom: 10px;
      a {
        color: $title-color-four;
        &:hover {
          color: $c6;
        }
      }
    }
    .product-price {
      color: $title-color-four;
      > span {
        font-size: 14px;
      }
      del {
        color: $black;
        opacity: 0.35;
        margin-left: 10px;
        font-size: 12px;
      }
    }
    .quantity-input {
      border: 1px solid #e5e5e5;
      width: 85px;
      align-items: center;
      background-color: $white;
      border-radius: 50px;
    }
    .quantity-input {
      margin-right: 7px;
      > * {
        width: 28px;
        height: 28px;
        min-width: 28px;
        background-color: transparent;
      }
      input {
        font-size: 12px;
        font-family: $base-font;
        font-weight: $regular;
      }
      button {
        &:first-of-type {
          border-right: 1px solid #e5e5e5 !important;
        }
        &:last-of-type {
          border-left: 1px solid #e5e5e5 !important;
        }
      }
    }
    .cart-btn {
      color: $c6;
      text-transform: uppercase;
      font-size: 10px;
      font-weight: $semibold;
      padding: 5.25px 14px;
      display: flex;
      align-items: center;

      border: 1px solid #e5e5e5;
      border-radius: 50px;
      background-color: #fff8ef;
      &:hover {
        border-color: $c6;
        background-color: $c6;
        color: $white;
      }
    }
    .product-badge {
      position: absolute;
      left: 25px;
      top: 25px;
      padding: 3px 8px;
      border-radius: 50px;
      background-color: $c6;
      font-family: $title-font;
      font-size: 12px;
      font-weight: $bold;
      text-transform: uppercase;
      color: $white;
    }
  }
  &--seven {
    box-shadow: 7px 7px 60px rgba($color: $black, $alpha: 0.05);
    border-radius: 5px;
    overflow: hidden;
    transition: 0.3s ease-in;
    .product-badge {
      position: absolute;
      left: 25px;
      top: 25px;
      padding: 3px 8px;
      height: 25px;
      min-width: 70px;
      border-radius: 50px;
      background-color: $c7;
      font-family: $title-font;
      font-size: 12px;
      font-weight: $bold;
      text-transform: uppercase;
      color: $title-color-four;
      &.hot {
        background-color: $c1;
        top: 55px;
        color: $white;
      }
    }

    .product-title {
      font-size: 21px;
      $lh: 1.476;
      line-height: $lh;
      margin-bottom: 7px;
      a {
        color: $title-color-four;
        &:hover {
          color: $c7;
        }
      }
    }

    .product-price {
      color: $title-color-four;
      > span {
        font-size: 14px;
      }
      del {
        color: rgba($color: $black, $alpha: 0.35);
        margin-left: 10px;
        font-size: 12px;
      }
    }

    .cart-btn,
    .btn-circle {
      border: 1px solid $c7;
      background-color: transparent;
      color: $c7;
      border-radius: 50px;

      &:hover {
        background-color: $c7;
        color: $white;
      }
    }

    .cart-btn {
      padding: 3.5px 15px;
      font-size: 16px;
      font-weight: 500;
      white-space: nowrap;
    }

    .btn-circle {
      width: 36px;
      height: 36px;
    }

    .action-buttons > *:not(:last-child) {
      margin-right: 5px;
    }

    &:hover {
      box-shadow: 10px 10px 90px rgba($color: $black, $alpha: 0.05);
    }
  }
}
.small-image {
  width: 50px;
}
</style>
