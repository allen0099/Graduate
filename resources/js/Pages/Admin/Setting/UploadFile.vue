<template>
    <VuetifyLayout>
        <template #header>
            檔案上傳
        </template>


        <v-file-input
            v-model="file"
            label="click me"
        ></v-file-input>

        <v-btn @click="upload">上傳</v-btn>

        <v-card v-if="res">{{ res }}</v-card>

    </VuetifyLayout>
</template>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import {
        apiUploadFile
    } from '@/api/api'
    export default {
        components: {
            VuetifyLayout,
        },
        name: "UploadFile",
        data: () => ({
            file: null,
            res: null
        }),
        methods: {
            async upload() {
                await apiUploadFile(this.file).then(res => {
                    this.res = res
                })
            }
        }
    }

</script>
