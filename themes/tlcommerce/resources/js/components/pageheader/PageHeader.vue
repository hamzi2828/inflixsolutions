<template>
  <div
    class="page-header bg-light d-none d-lg-block"
    :class="{ 'white-box': whiteBg }"
  >
    <div class="custom-container2">
      <div class="row">
        <div class="col-12">
          <h2 v-if="title" class="page-title" :class="{ small: small }">
            {{ title }}
          </h2>
          <CBreadcrumb style="--cui-breadcrumb-divider: '>'">
            <CBreadcrumbItem
              :href="item.href"
              v-for="item in items"
              :class="{ active: item.active }"
              :key="item"
              >{{ item.text }}</CBreadcrumbItem
            >
          </CBreadcrumb>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { CBreadcrumb, CBreadcrumbItem } from "@coreui/vue";
export default {
  name: "PageHeader",
  components: {
    CBreadcrumb,
    CBreadcrumbItem,
  },
  props: {
    title: {
      type: String,
      default: "",
    },
    whiteBg: {
      type: Boolean,
      default: false,
    },
    items: {
      type: Array,
      default: () => {
        return [];
      },
    },
    small: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.page-header {
  padding: 16px 0;
}
</style>
