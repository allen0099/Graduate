<template>
    <v-app>
        <v-main class="d-flex align-center">
            <v-card
                flat
                class="d-flex justify-center mb-5"
            >
                <span class="text-h4 grey--text text--darken-3">{{ code }}</span>
                <v-divider
                    class="mx-5 v-divider-black"
                    vertical
                ></v-divider>
                <span class="text-h4 grey--text text--darken-3">{{ message }}</span>
            </v-card>
            <v-card
                flat
                class="d-flex justify-center"
            >
                <v-btn
                    text
                    href="/"
                >
                    <i class="mr-2">
                        <svg
                            style="width:24px;height:24px"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill="currentColor"
                                d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"
                            />
                        </svg>
                    </i>
                    Go to Home
                </v-btn>
            </v-card>
        </v-main>
    </v-app>
</template>

<script>
    export default {
        metaInfo() {
            return {
                title: this.message
            }
        },
        props: {
            code: Number,
            message: String
        }
    }

</script>
<style src="vuetify/dist/vuetify.min.css" />
