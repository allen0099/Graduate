<template>
    <div>
        <div class="text-center text-5xl font-thin px-4 border-r-2 border-current">
            Remove this page in production
        </div>
        <v-divider/>
        <h1 class="text-2xl mt-2">Hello {{ name }}</h1>
        <v-divider/>
        <form @submit.prevent="logout">
            <button class="text-5xl font-thin px-4 border-r-2 border-current">
                Logout
            </button>
        </form>
    </div>
</template>

<script>
import Button from "../Jetstream/Button";
export default {
    name: "OrderTest",
    components: {Button},
    props: {
        name: String
    },
    computed: {
        orders() {
            // WTF $page is
            // return this.$inertia
            return this.$page.orders
        }
    },
    methods: {
        logout() {
            axios.post(route('logout').url()).then(response => {
                window.location = '/login';
            })
        },
    },
}
</script>

<style scoped>

</style>
