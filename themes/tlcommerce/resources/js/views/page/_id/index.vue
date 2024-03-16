<template>
    <div class="">
        <page-header :items="bItems" />

        <div class="pt-30 pt-lg-60 pb-60 light-bg">
            <div class="custom-container2">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Page Details -->
                        <article class="post-details">
                            <!-- Page Header -->
                            <header class="entry-header">
                                <div class="entry-thumbnail" v-if="page.page_image!=null">
                                    <img :src="page.page_image" alt="" />
                                </div>

                                <h1 class="entry-title">
                                    {{ page.title }}
                                </h1>
                            </header>
                            <!-- End Page Header -->

                            <!-- Page Content -->
                            <div
                                class="entry-content mb-40"
                                v-html="page.content"
                            ></div>
                            <!-- End Page Content -->
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";

const axios = require("axios").default;
export default {
    name: "Products",
    components: {
        PageHeader,
    },

    data() {
        return {
            pageTitle: "Page Details",
            bItems: [
                {
                    text: "Home",
                    href: "/",
                }
            ],
            page: {},
        };
    },
    mounted() {
        this.getPageDetails();
    },
    methods: {
        /**
         * Get page details
         */
        getPageDetails() {
            let fullUrl = this.$route.params.id;
            let slug = fullUrl
            let splittedFullUrl = fullUrl.split('/')
            if(splittedFullUrl.length>0){
                slug = splittedFullUrl[splittedFullUrl.length-1];
            }

            if (this.$route.params.child != undefined) {
                slug = this.$route.params.child;
            }

            const headers = {
                "Content-Type": "application/json",
                "Accept-Language": localStorage.getItem("locale") || "en",
            };
            axios
                .get("/api/theme/tlcommerce/v1/page/" + slug, {
                    headers: headers,
                })
                .then((response) => {
                    if (response.data.success) {
                        this.page = response.data.page;
                        this.bItems = response.data.breadCrumbs;
                        if(this.page == null){
                            this.$router.push({path: '/404'})
                        }
                    }
                    else{
                        this.$router.push({path: '/404'})
                    }
                })
                .catch((error) => {});
        },
    },
};
</script>
