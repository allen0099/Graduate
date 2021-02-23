<template>
    <v-card flat>
        <v-row dense>
            <v-col
                cols="12"
                sm="4"
            >
                <v-card flat>
                    <v-card-title>
                        {{ title }}
                    </v-card-title>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                sm="8"
            >
                <v-card
                    elevation="1"
                    class="pa-3"
                >
                    <v-card-text>
                        ※ 只能上傳 pdf 檔，大小不可超過 5 MB
                        <v-file-input
                            v-model="file"
                            accept=".pdf"
                            :label="file ? '' : title"
                            id="pdf_file"
                            type="file"
                            name="pdf_file"
                        ></v-file-input>
                        <v-text-field
                            v-if="pdf"
                            v-model="edit_name"
                            label="顯示名稱"
                            prepend-icon="mdi-file"
                        ></v-text-field>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            class="mr-3"
                            :href="`/pdf/${title}.pdf`"
                            target="_blank"
                            v-if="file"
                        >閱覽</v-btn>
                        <v-btn
                            :dark="!!edit_name"
                            @click="upload"
                            :disabled="!edit_name"
                        >上傳</v-btn>
                    </v-card-actions>

                </v-card>
            </v-col>
        </v-row>
        <v-dialog
            v-model="pageLoading"
            persistent
            width="300"
        >
            <v-card
                color="primary"
                dark
            >
                <v-card-text>
                    Loading...
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
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
    </v-card>
</template>

<script>
    import {
        apiUploadPdf,
        apiCheckExist,
        apiUpdatePdfName
    } from '@/api/api'
    export default {
        name: "UploadPdf",
        props: {
            title: String,
            pdf: {
                type: String,
                default: null
            },
        },
        data() {
            return {
                pageLoading: false,
                snackbar: false,
                snackbar_true: false,
                msg: '',
                file: null,
                name: null,
                edit_name: null,
            }
        },

        methods: {
            async init() {
                if (this.pdf) {
                    this.name = this.$page.configs['pdf_' + this.pdf]
                } else {
                    this.name = this.title
                }

                this.edit_name = this.name

                let filepath = '/pdf/' + this.title + ".pdf"
                await apiCheckExist(filepath).then(res => {
                    if (res.status == 200) {
                        this.file = new File([], this.title + ".pdf")
                    }
                })
            },
            async upload() {
                this.pageLoading = true


                if (!this.pdf) {
                    if (!this.file || this.file.size === 0) {
                        this.msg = '請先選擇檔案'
                        this.snackbar = true
                        this.snackbar_true = false
                        this.pageLoading = false
                        return
                    }
                }

                if (this.file && this.file.size !== 0) {
                    let form_data = new FormData()
                    form_data.append('pdf_file', this.file)
                    form_data.append('name', this.title)
                    await apiUploadPdf(form_data).then(res => {
                        if (res.status === 204) {
                            this.msg = '上傳成功'
                            this.snackbar = true
                            this.snackbar_true = true
                        } else {
                            this.msg = '上傳失敗'
                            this.snackbar = true
                            this.snackbar_true = false
                        }
                        this.pageLoading = false
                    }).catch((err) => {
                        console.log(err)
                        this.msg = '連線錯誤'
                        this.snackbar = true
                        this.snackbar_true = false
                        this.pageLoading = false
                    })
                }
                if (this.pdf) {
                    await apiUpdatePdfName(this.pdf, this.edit_name).then(res => {
                        if (res.status === 204) {
                            this.msg = '修改成功'
                            this.snackbar = true
                            this.snackbar_true = true
                        } else {
                            this.msg = '修改失敗'
                            this.snackbar = true
                            this.snackbar_true = false
                        }
                        this.pageLoading = false
                    }).catch((err) => {
                        console.log(err)
                        this.msg = '連線錯誤'
                        this.snackbar = true
                        this.snackbar_true = false
                        this.pageLoading = false
                    })
                }
            }
        },
        mounted() {
            this.init()
        }
    }

</script>
