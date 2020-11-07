<!-- <template>
    <modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="px-6 py-4">
            <div class="text-lg">
                <slot name="title">
                </slot>
            </div>

            <div class="mt-4">
                <slot name="content">
                </slot>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-100 text-right">
            <slot name="footer">
            </slot>
        </div>
    </modal>
</template> -->

<!-- vuetify fixed -->
<template>
    <v-dialog
        v-model="show"
        :max-width="maxWidth"
        :persistent="closeable"
        @click:outside="close"
    >
        <v-card>
            <v-card-title class="headline grey lighten-2">
                <slot name="title"></slot>
            </v-card-title>

            <div class="px-6 py-4">
                <slot name="content"></slot>
            </div>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <slot name="footer"></slot>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script>
    export default {

        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: '42rem'
            },
            closeable: {
                default: false
            },
        },

        methods: {
            close() {
                this.$emit('close')
            },
        },
    }

</script>
