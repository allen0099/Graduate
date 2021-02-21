<template>
    <v-card flat>
        <v-row dense>
            <v-col
                cols="12"
                sm="4"
            >
                <v-card flat>
                    <v-card-title>經手人印鑑圖鑑上傳</v-card-title>
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
                        <input
                            type="file"
                            class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview"
                            accept="image/png, image/jpeg"
                        >

                        <span>※ 只能上傳 jpg、png 檔，大小不可超過 2 MB</span>
                        <div class="mt-3 mb-5">
                            <v-img
                                v-if="!photoPreview"
                                max-height="250"
                                max-width="250"
                                :src="stamp"
                            ></v-img>
                            <v-img
                                v-else
                                max-height="250"
                                max-width="250"
                                :src="photoPreview"
                            ></v-img>
                        </div>

                        <v-btn
                            outlined
                            class="mr-3"
                            @click.native.prevent="selectNewPhoto"
                        >選擇圖片</v-btn>

                        <v-btn
                            outlined
                            @click.native.prevent="deletePhoto"
                        >移除圖片</v-btn>

                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            dark
                            @click="submit"
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
        apiUpdateStamp
    } from '@/api/api'

    export default {
        name: "UploadStampImg",
        data() {
            return {
                pageLoading: false,
                snackbar: false,
                snackbar_true: false,
                msg: '',
                stamp: null,
                photoPreview: null
            }
        },

        methods: {
            init() {
                this.stamp = this.$page.configs.admin_stamp_url
            },
            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.photoPreview = null
                this.$refs.photo.files[0] = null
            },

            async submit() {
                this.pageLoading = true

                let target = this.$refs.photo.files[0]

                if (target && (
                        target.type === 'image/jpeg' ||
                        target.type === 'image/png' ||
                        target.type === 'image/bmp') && target.size < 2 * 1024 * 1024) {
                    let image = new FormData();
                    image.append('image', this.$refs.photo.files[0]);

                    await apiUpdateStamp(image).then(res => {
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
                } else {
                    this.msg = '檔案格式錯誤或檔案太大'
                    this.snackbar = true
                    this.snackbar_true = false
                    this.pageLoading = false
                }
            }
        },
        mounted() {
            this.init()
        }
    }

</script>
