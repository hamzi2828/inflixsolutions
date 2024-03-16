<template>
  <!-- Widget -->
  <div class="widget widget-style-1 widget_top_selling_product mb-4">
    <h5>
      <span>{{ $t("Top Selling Products") }}</span>
      <span
        @click="showTopSellingProductWidget = !showTopSellingProductWidget"
        class="widget-collapse-toggle"
        ><span class="material-icons"> expand_more </span>
      </span>
    </h5>
    <div
      class="top-selling-product light-bg"
      v-if="showTopSellingProductWidget"
    >
      <swiper
        v-if="products.length"
        :modules="modules"
        :loop="true"
        :pagination="{
          clickable: true,
        }"
        class="product-grid-slider theme-slider-dots"
      >
        <swiper-slide v-for="(item, index) in products" :key="`slide-${index}`">
          <single-product :item="item" styleEight />
        </swiper-slide>
      </swiper>
    </div>
  </div>
  <!-- Widget -->
</template>

<script>
import SingleProduct from "@/components/product/SingleProduct.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper";
export default {
  components: {
    SingleProduct,
    Swiper,
    SwiperSlide,
    Pagination,
  },
  props: {
    products: {
      type: Array,
      required: false,
    },
  },
  data() {
    return {
      showTopSellingProductWidget: true,
    };
  },
  setup() {
    return {
      modules: [Pagination],
    };
  },
};
</script>
