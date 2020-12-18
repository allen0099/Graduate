<template>
    <div>
        <div class="text-center text-5xl font-thin px-4 border-r-2 border-current">
            Remove this page in production
        </div>
        <v-divider/>
        <div v-if="user" class="text-center text-5xl font-thin px-4 border-r-2 border-current">
            User: {{ user }}
        </div>
        <div v-else class="text-center text-5xl font-thin px-4 border-r-2 border-current">
            User: Null, please login
        </div>
        <h1 class="text-2xl mt-2">Hello {{ name }}</h1>
    </div>
</template>

<script>
export default {
    name: "HelloWorld",
    metaInfo: {
        title: 'About'
    },
    props: {
        name: String
    },
    computed: {
        user() {
            // WTF $page is
            return this.$page.auth?.user
        }
    },
}
</script>

<style scoped>

</style>
