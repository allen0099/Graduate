<template>
    <VuetifyLayout>
        <template #header>
            檔案上傳
        </template>


        <v-file-input
            v-model="file"
            label="click me"
            name="file"
            type="file"
        ></v-file-input>

        <v-btn @click="upload">上傳</v-btn>

        <v-card>{{ file }}</v-card>

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
                let form_data = new FormData()
                form_data.append('file', this.file)
                console.log(form_data)
                await apiUploadFile(form_data).then(res => {
                    this.res = res.data
                })
            }
        }
    }

</script>
