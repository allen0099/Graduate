<template>
    <VuetifyLayout>
        <template #header>
            訂單修改
        </template>
        <!-- part1 strat  -->
        <v-card
            class="mt-3"
            flat
        >
            <FixSpec
                @changeMsg="changeMsg"
                class="mb-10"
            ></FixSpec>
        </v-card>
        <v-snackbar
            v-model="snackbar"
            :timeout="2000"
        >
            <v-icon
                dark
                right
                class="mr-2"
                :color="snackbar_true ? 'success' : 'error'"
            >
                {{ snackbar_true ? 'mdi-checkbox-marked-circle' : 'mdi-alert ' }}
            </v-icon>
            {{ msg }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    :color="snackbar_true ? 'success' : 'error'"
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                >
                    關閉
                </v-btn>
            </template>
        </v-snackbar>
    </VuetifyLayout>
</template>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import FixSpec from './FixSpec.vue'

    export default {
        components: {
            VuetifyLayout,
            FixSpec,
        },
        name: "AdminFixOrder",
        data: () => ({
            snackbar: false,
            snackbar_true: false,
            msg: false,
        }),
        methods: {
            changeMsg(msg, snackbar_true) {
                this.msg = msg
                this.snackbar_true = snackbar_true
                this.snackbar = true
            }
        }
    }

</script>
