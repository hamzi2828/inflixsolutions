<template>
  <div class="home__two">
    <!-- Banner -->
    <section class="product-banner product-banner-overflow-auto mt-30 mb-30">
      <div v-if="sliderLoading">
        <div class="desktop">
          <div class="d-flex">
            <skeleton height="450px" class="w-25"></skeleton>
            <skeleton
              height="450px"
              class="custom-container2 mx-4 skeleton"
            ></skeleton>
            <skeleton height="450px" class="w-25"></skeleton>
          </div>
        </div>
        <div class="mobile">
          <skeleton height="120px" class="w-100"></skeleton>
        </div>
      </div>
      <div class="custom-container2" v-else>
        <swiper
          v-if="banners && banners.length > 0"
          :slidesPerView="'auto'"
          :loop="true"
          :spaceBetween="20"
          :centeredSlides="true"
          :modules="modules"
          :autoplay="{
            delay: 4000,
          }"
          :pagination="{
            clickable: true,
          }"
          class="mySwiper theme-slider-dots dots-bottom-30"
        >
          <swiper-slide
            v-for="(slide, index) in banners"
            :key="`slide-${index}`"
          >
            <product-banner :content="slide" />
          </swiper-slide>
        </swiper>
      </div>
    </section>
    <!-- End Banner -->
    <!--Dynamic Sections-->
    <div v-for="(section, index) in sections" :key="index">
      <deal-section
        v-if="section.layout === 'flashdeal'"
        :content="section.content"
        :properties="section.properties"
      ></deal-section>
      <collection-section
        v-if="section.layout === 'product_collection'"
        :content="section.content"
        :properties="section.properties"
      >
      </collection-section>
      <custom-product-section
        v-if="section.layout === 'custom_product_section'"
        :content="section.content"
        :properties="section.properties"
      >
      </custom-product-section>
      <category-section
        v-if="section.layout === 'category_slider'"
        :content="section.content"
        :properties="section.properties"
      ></category-section>
      <ads-section
        v-if="section.layout === 'ads'"
        :content="section.content"
        :properties="section.properties"
      ></ads-section>
      <cta-section
        v-if="section.layout === 'featured_product'"
        :content="section.content"
        :properties="section.properties"
      ></cta-section>
      <blog-section
        v-if="section.layout === 'blogs'"
        :content="section.content"
        :properties="section.properties"
      ></blog-section>
    </div>
    <!--End Dynamic Sections-->
  </div>
</template>

<script>
import { defineAsyncComponent } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination } from "swiper";

const ProductBanner = defineAsyncComponent(() =>
  import("@/components/ui/ProductBanner.vue")
);

const DealSection = defineAsyncComponent(() =>
  import("@/components/home-page-sections/dealSection.vue")
);

const collectionSection = defineAsyncComponent(() =>
  import("@/components/home-page-sections/collectionSection.vue")
);
const CategorySection = defineAsyncComponent(() =>
  import("@/components/home-page-sections/categorySection.vue")
);
const adsSection = defineAsyncComponent(() =>
  import("@/components/home-page-sections/adsSection.vue")
);

const ctaSection = defineAsyncComponent(() =>
  import("@/components/home-page-sections/ctaSection.vue")
);

const blogSection = defineAsyncComponent(() =>
  import("@/components/home-page-sections/blogSection.vue")
);

const CustomProductSection = defineAsyncComponent(() =>
  import("@/components/home-page-sections/CustomProductSection.vue")
);
const axios = require("axios").default;
export default {
  components: {
    Swiper,
    SwiperSlide,
    ProductBanner,
    DealSection,
    collectionSection,
    CategorySection,
    adsSection,
    ctaSection,
    blogSection,
    CustomProductSection,
  },
  setup() {
    return {
      modules: [Autoplay, Pagination],
    };
  },
  name: "HomeView",
  data() {
    return {
      banners: [],
      sections: [],
      sliderLoading: true,
    };
  },
  mounted() {
    document.title = localStorage.getItem("site_title");
    this.getSections();
  },
  async created() {
    try {
      const response = await axios.get(
        "/api/theme/tlcommerce/v1/active-sliders"
      );
      if (response.status === 200) {
        this.banners = response.data.data;
        this.sliderLoading = false;
      }
    } catch (error) {
      this.sliderLoading = false;
    }
  },
  methods: {
    /**
     * Get active sections
     */
    getSections() {
      axios
        .get("/api/theme/tlcommerce/v1/active-home-page-sections")
        .then((response) => {
          if (response.data.success) {
            this.sections = response.data.data;
          }
        })
        .catch((error) => {
          this.sections = [];
        });
    },
  },
};
</script>
<style lang="scss">
.product-banner-overflow-auto {
  overflow: hidden;
  .swiper {
    overflow: initial;
  }
}
</style>
