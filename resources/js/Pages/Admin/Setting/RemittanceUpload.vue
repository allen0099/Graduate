<template>
    <div>
        <v-card flat class="mb-5">
            <!-- <v-card-title>
                帳戶資料上傳
            </v-card-title> -->
            <v-card-text class="font-weight-bold">
                <v-card flat class="py-10">
                    <v-row dense>
                        <v-col cols="12" sm="4">
                            <v-card flat>
                                <v-card-title>名單匯出</v-card-title>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="8">
                            <v-card class="pa-3">
                                <v-card-text class="font-weight-bold">
                                    當前共有
                                    {{ users.length }} 筆資料需要處理
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        href="/export_payment_check_status"
                                        class="ma-2"
                                        color="primary"
                                    >
                                        {{ "Excel匯出" }}
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card>
                <v-divider class="mx-5 v-divider-bold" />
                <v-card flat class="py-10">
                    <v-row dense>
                        <v-col cols="12" sm="4">
                            <v-card flat>
                                <v-card-title>帳戶資料上傳</v-card-title>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="8">
                            <v-card elevation="1" class="pa-3">
                                <v-card-text>
                                    <span>※ 只能上傳 csv 檔</span>
                                    <v-tooltip bottom>
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-icon
                                                v-bind="attrs"
                                                v-on="on"
                                                small
                                            >
                                                mdi-information-outline
                                            </v-icon>
                                        </template>
                                        <span
                                            >csv 檔案欄位名必須包含要有
                                            (受款人代號,受款人名稱,資料狀態)</span
                                        >
                                    </v-tooltip>
                                    <v-file-input
                                        v-model="file"
                                        accept=".csv"
                                        label="批次付款資料"
                                        id="csv_file"
                                        type="file"
                                        name="csv_file"
                                    ></v-file-input>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="primary" @click="upload"
                                        >上傳</v-btn
                                    >
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card>
            </v-card-text>
        </v-card>

        <v-dialog v-model="msg_dialog" max-width="850px">
            <v-card>
                <v-card-title>
                    <span>付款批次上傳結果</span>
                </v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row>
                        <v-col cols="12">
                            <span class="green--text text--accent--3">
                                上傳成功回應
                            </span>
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col
                            cols="12"
                            v-for="(msg, index) in upload_result.succeed"
                            :key="`msg-succeed-${index}`"
                        >
                            <span class="green--text text--accent--3">
                                {{ index + 1 }}
                            </span>
                            <span>{{ ": " + msg }}</span>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <span class="red--text">
                                上傳失敗回應
                            </span>
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col
                            cols="12"
                            v-for="(msg, index) in upload_result.fail"
                            :key="`msg-fail-${index}`"
                        >
                            <span class="red--text">
                                {{ index + 1 }}
                            </span>
                            <span>{{ ": " + msg }}</span>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" dark @click="closeMsgWindow">
                        關閉
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="uploadLoading" persistent width="300">
            <v-card color="primary" dark>
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
        <v-snackbar v-model="snackbar" :timeout="5000">
            <v-icon
                dark
                right
                class="mr-2"
                :color="snackbar_true ? 'success' : 'error'"
            >
                {{
                    snackbar_true ? "mdi-checkbox-marked-circle" : "mdi-alert "
                }}
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
    </div>
</template>

<script>
import { apiPaymentCheckStatus, apiUploadPaymentCheckStatus } from "@/api/api";

export default {
    name: "RemittanceUpload",
    data() {
        return {
            users: [],
            file: null,
            msg: "",
            snackbar: false,
            snackbar_true: false,
            uploadLoading: false,
            alert_dialog: false,
            msg_dialog: false,
            upload_result: {
                fail: [],
                succeed: []
            }
        };
    },

    methods: {
        async init() {
            await apiPaymentCheckStatus()
                .then(res => {
                    this.users = res.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },

        closeMsgWindow() {
            this.msg_dialog = false;
            this.upload_result = [];
        },

        async upload() {
            if (!this.file) {
                this.msg = "請先選擇檔案";
                this.snackbar = true;
                this.snackbar_true = false;
                this.uploadLoading = false;
                return;
            }
            this.alert_dialog = false;
            this.uploadLoading = true;
            let form_data = new FormData();
            form_data.append("csv_file", this.file);
            await apiUploadPaymentCheckStatus(form_data)
                .then(res => {
                    if (res.status === 200) {
                        this.msg = "上傳成功";
                        this.snackbar = true;
                        this.snackbar_true = true;
                        this.msg_dialog = true;
                        this.upload_result = res.data;
                    } else {
                        this.msg = "上傳失敗";
                        this.snackbar = true;
                        this.snackbar_true = false;
                    }
                    this.uploadLoading = false;
                })
                .catch(err => {
                    console.log(err);
                    this.msg = err.response.data.errors;
                    if (!!this.msg === false) {
                        this.msg = "上傳失敗";
                    }
                    this.snackbar = true;
                    this.snackbar_true = false;
                    this.uploadLoading = false;
                });
        }
    },
    created() {
        this.init();
    }
};
</script>
