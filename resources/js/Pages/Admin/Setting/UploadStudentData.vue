<template>
    <v-card flat>
        <v-row dense>
            <v-col
                cols="12"
                sm="4"
            >
                <v-card flat>
                    <v-card-title>學生資料上傳</v-card-title>
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
                        <v-file-input
                            v-model="file"
                            accept=".csv"
                            label="學生資料"
                            id="csv_file"
                            type="file"
                            name="csv_file"
                        ></v-file-input>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            dark
                            @click="upload"
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
        apiUploadStudent
    } from '@/api/api'
    export default {
        name: "UploadStudentData",
        data() {
            return {
                pageLoading: false,
                snackbar: false,
                snackbar_true: false,
                msg: '',
                file: null,
            }
        },

        methods: {
            async upload() {
                if (!this.file) {
                    this.msg = '請先選擇檔案'
                    this.snackbar = true
                    this.snackbar_true = false
                    this.pageLoading = false
                    return
                }
                this.pageLoading = true
                let form_data = new FormData()
                form_data.append('csv_file', this.file)
                console.log(this.file)
                await apiUploadStudent(form_data).then(res => {
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
        },
    }

</script>
