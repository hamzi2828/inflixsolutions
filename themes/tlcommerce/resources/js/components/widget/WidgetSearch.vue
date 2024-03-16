<template>
    <div class="widget widget_search">
        <div class="search-form">
            <div class="theme-input-group">
                <input
                    type="search"
                    class="theme-input-style"
                    v-bind:placeholder="$t('Search Here')"
                    v-model="searchKey"
                />

                <a :href="'/blog/search-result?searchKey='+searchKey" class="submit-btn btn btn-sm">
                    <span class="material-icons"> search </span>
                </a>
            </div>
          </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            searchKey: "",
        };
    },
    methods: {
        searchBlogs() {
            alert(this.searchKey)
            this.$router.push({ path: '/blog/search-result?searchKey='+this.searchKey })
        },
    },
};
</script>
