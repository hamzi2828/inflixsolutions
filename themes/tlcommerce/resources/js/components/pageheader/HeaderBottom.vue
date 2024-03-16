<template>
    <!-- Header Bottom -->
    <div
        :class="
            this.headerStyle.custom_header == 1
                ? 'custom-header-bottom header-bottom'
                : 'header-bottom'
        "
    >
        <div class="custom-container2">
            <div
                class="row position-relative align-items-center justify-content-between"
            >
                <div
                    class="col-lg-auto position-static d-flex align-items-center"
                >
                    <!-- MegaMenu -->
                    <mega-menu
                        v-if="!dataLoading"
                        :mega-categories="megaCategories"
                    />
                    <div v-if="dataLoading" class="megamenu-wrapper">
                        <skeleton
                            height="15px"
                            border-radius="10px"
                            width="100px"
                        >
                        </skeleton>
                    </div>
                    <!-- End MegaMenu -->

                    <!-- Menu -->
                    <div v-if="dataLoading">
                        <ul class="nav-horizontal desktop">
                            <li
                                v-for="(item, index) in menuSkeletons"
                                :key="index"
                            >
                                <skeleton
                                    height="12px"
                                    border-radius="10px"
                                    :width="item"
                                >
                                </skeleton>
                            </li>
                        </ul>
                    </div>
                    <HorizontalMenu
                        v-else
                        :menu-items="menuItems"
                        :header-menu-style="headerMenuStyle"
                    />
                    <!-- End Menu -->
                </div>

                <div class="col-lg-auto text-right">
                    <template v-if="this.headerStyle.custom_header != 1">
                        <a
                            v-if="!dataLoading &&
                                this.headerStyle.header_bot_email_text != null"
                            class="text-nowrap fz-14 email-text"
                            href="mailto:"
                            ><span class="d-none d-xl-inline"></span>
                            <base-icon-svg
                                class="ms-1"
                                name="inbox"
                                :height="10"
                                :weight="11.25"
                            />
                        </a>
                        <a v-if="dataLoading">
                            <skeleton
                                height="12px"
                                border-radius="10px"
                                width="110px"
                            >
                            </skeleton>
                        </a>
                    </template>
                    <template v-else>
                        <a
                            v-if="
                                !dataLoading &&
                                this.headerStyle.header_bot_email_text != null
                            "
                            class="text-nowrap fz-14 email-text"
                            :href="
                                'mailto:' +
                                this.headerStyle.header_bot_email_text
                            "
                        >
                            <span class="d-none d-xl-inline">
                                {{ this.headerStyle.header_bot_email_text }}
                            </span>
                            <base-icon-svg
                                class="ms-1"
                                name="inbox"
                                :height="10"
                                :weight="11.25"
                            />
                        </a>
                        <a v-if="dataLoading">
                            <skeleton
                                height="12px"
                                border-radius="10px"
                                width="110px"
                            >
                            </skeleton>
                        </a>
                    </template>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Bottom -->
</template>
<script>
import MegaMenu from "@/components/menu/MegaMenu.vue";
import HorizontalMenu from "@/components/menu/HorizontalMenu.vue";
export default {
    name: "HeaderBottom",
    components: {
        MegaMenu,
        HorizontalMenu,
    },
    props: {
        megaCategories: {
            type: Array,
            required: false,
            default: () => {
                return [];
            },
        },
        menuItems: {
            type: Array,
            required: false,
            default: () => {
                return [];
            },
        },
        headerStyle: {
            type: Object,
            required: false,
            default: () => {
                return {};
            },
        },
        headerMenuStyle: {
            type: Object,
            required: false,
            default: () => {
                return {};
            },
        },
        dataLoading: {
            type: Boolean,
            required: true,
            default: false,
        },
    },
    data() {
        return {
            menuSkeletons: ["100px", "70px", "130px", "90px", "100px"],
        };
    },
};
</script>
<style scoped></style>
