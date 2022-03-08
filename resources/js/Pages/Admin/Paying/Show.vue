<template>
    <VuetifyLayout>
        <template #header>
            付款處理
        </template>
        <v-card class="mt-3" flat>
            <v-card-title>
                <v-toolbar flat>
                    <v-row class="mt-3" justify="center" no-gutters>
                        <v-col cols="8" sm="7" md="6">
                            <v-text-field
                                v-model="order_id"
                                label="訂單編號或購買人學號"
                                outlined
                                clearable
                                dense
                                class="mr-2"
                                type="tel"
                                :messages="show_msg ? msg : ''"
                                :success="!error && show_msg"
                                :error="error && show_msg"
                                @keyup.enter="receive_submit"
                                autofocus
                                ref="barcode_input"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="3" md="2">
                            <v-btn
                                color="primary"
                                @click="receive_submit"
                                :loading="search_loading"
                                >查詢</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-toolbar>
            </v-card-title>
            <v-spacer></v-spacer>
            <v-divider class="mx-5 v-divider-bold" />
            <v-card flat class="py-10">
                <v-row dense>
                    <v-col cols="12" sm="4">
                        <v-card flat>
                            <v-card-title>批次付款資料上傳</v-card-title>
                        </v-card>
                    </v-col>
                    <v-col cols="12" sm="8">
                        <v-card elevation="1" class="pa-3">
                            <v-card-text>
                                <span>※ 只能上傳 csv 檔</span>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon v-bind="attrs" v-on="on" small>
                                            mdi-information-outline
                                        </v-icon>
                                    </template>
                                    <span
                                        >csv 檔案欄位名必須包含要有
                                        (繳費單編號,收費金額,繳款人)</span
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
        </v-card>

        <v-dialog v-model="dialog" max-width="850px" persistent>
            <v-card v-if="order">
                <v-card-title>
                    <span
                        >衣服付款確認-{{
                            order.owner.username[0] > "5" ? "碩士服" : "學士服"
                        }}</span
                    >
                </v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row dense>
                        <v-col cols="12" md="4"
                            >訂單編號：{{ order.document_id }}</v-col
                        >
                        <v-col cols="12" md="4"
                            >系級：{{
                                order.owner.school_class.class_name
                            }}</v-col
                        >
                        <v-col cols="12" md="4"
                            >學生：{{ order.owner.name }}</v-col
                        >
                        <v-col cols="12" md="4"
                            >學號：{{ order.owner.username }}</v-col
                        >
                        <v-col cols="12" md="4"
                            >訂單日期：{{
                                $moment(order.created_at).format(
                                    "YYYY-MM-DD HH:mm"
                                )
                            }}</v-col
                        >
                        <v-col cols="12" md="4"
                            >總金額：{{ order.total_price }}</v-col
                        >
                        <v-col cols="12"
                            ><span>訂單當前狀態：</span>
                            <span
                                :class="
                                    order.status_code === Status.returned ||
                                    order.status_code === Status.refunded
                                        ? 'green--text text--accent--3'
                                        : 'red--text'
                                "
                                >{{ statusMsg[order.status_code] }}</span
                            >
                        </v-col>
                        <v-col clos="12">
                            <v-text-field
                                v-model="order.payment_id"
                                label="付款單據編號"
                                autofocus
                                :rules="[
                                    value =>
                                        /^[0-9]{8}$/.test(value) ||
                                        '必為 8 個數字'
                                ]"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="mt-5">訂單內容：</v-col>
                        <v-col cols="12">
                            <v-data-table
                                :headers="headers"
                                :items="order.sets"
                                class="elevation-1 mt-2"
                                mobile-breakpoint="770"
                                hide-default-footer
                            >
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="error" dark @click="cancel">
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        :dark="
                            order.status_code == Status.created &&
                                !!order.payment_id
                        "
                        @click="save"
                        :disabled="
                            order.status_code != Status.created ||
                                !order.payment_id
                        "
                    >
                        確認
                    </v-btn>
                </v-card-actions>
            </v-card>
            <v-dialog v-model="pageLoading" persistent width="300">
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
        </v-dialog>

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
    </VuetifyLayout>
</template>

<script>
import VuetifyLayout from "@/Layouts/VuetifyLayout";
import { apiSearchOrder, apiPaidOrder, apiUploadPayments } from "@/api/api";

import { Status, StatusMsg } from "@/api/config";

export default {
    components: {
        VuetifyLayout
    },
    name: "AdminReturn",
    data: () => ({
        order_id: "",
        order: null,
        file: null,
        msg: "",
        show_msg: false,
        dialog: false,
        error: false,
        pageLoading: false,
        search_loading: false,
        uploadLoading: false,
        choose_file: null,
        Status: Status,
        statusMsg: StatusMsg,
        snackbar: false,
        snackbar_true: false,
        msg_dialog: false,
        upload_result: {
            fail: [],
            succeed: []
        },
        headers: [
            {
                text: "學號",
                align: "start",
                value: "student.username",
                width: 100,
                sortable: false
            },
            {
                text: "姓名",
                value: "student.name",
                width: 100,
                sortable: false
            },
            {
                text: "班級",
                value: "student.school_class.class_name",
                sortable: false,
                width: 100
            },
            {
                text: "顏色",
                value: "accessory.spec",
                align: "center",
                width: 20
            },
            {
                text: "尺寸",
                value: "cloth.spec",
                align: "center",
                width: 20
            }
        ],
        file_list: [
            {
                filename: "今日預約領取簽到表-學士",
                path: "123"
            },
            {
                filename: "今日預約領取簽到表-碩士",
                path: "123"
            },
            {
                filename: "空白簽到表-學士",
                path: "123"
            },
            {
                filename: "空白簽到表-碩士",
                path: "123"
            }
        ],
        bachelor_cloths: [],
        bachelor_accessories: [],
        master_cloths: [],
        master_accessories: [],
        card_color: {
            白: {
                bg: "#FFFFFF",
                q: "#000000",
                r: "#000000"
            },
            黃: {
                q: "#FFFDE7",
                bg: "#F57F17",
                r: "#FFFFFF"
            },
            橘: {
                q: "#FFF3E0",
                bg: "#E65100",
                r: "#FFFFFF"
            },
            灰: {
                q: "#F5F5F5",
                bg: "#424242",
                r: "#FFFFFF"
            },
            藍: {
                q: "#BBDEFB",
                bg: "#0D47A1",
                r: "#FFFFFF"
            },
            紫: {
                q: "#D1C4E9",
                bg: "#311B92",
                r: "#FFFFFF"
            }
        }
    }),
    methods: {
        init_obj() {
            this.bachelor_accessories = this.$page.props.inventory.slice(0, 2);
            this.master_accessories = this.$page.props.inventory.slice(2, 8);
            this.bachelor_cloths = this.$page.props.inventory.slice(8, 12);
            this.master_cloths = this.$page.props.inventory.slice(12, 15);
        },
        async receive_submit() {
            this.search_loading = true;
            await apiSearchOrder(this.order_id)
                .then(res => {
                    if (res.status === 200 && res.data.length > 0) {
                        if (res.data[0].payment_id) {
                            this.msg = "此訂單已有付款編號";
                            this.error = true;
                            this.show_msg = true;
                        } else {
                            this.order = res.data[0];
                            this.order_id = "";
                            this.dialog = true;
                        }
                        this.order_id = "";
                    } else {
                        this.order_id = "";
                        this.msg = "查無此訂單編號";
                        this.error = true;
                        this.show_msg = true;
                    }
                    this.search_loading = false;
                })
                .catch(err => {
                    console.log(err);
                    this.order_id = "";
                    this.msg = "查無此訂單編號";
                    this.error = true;
                    this.show_msg = true;
                    this.search_loading = false;
                });

            setTimeout(() => {
                this.show_msg = false;
            }, 2000);
        },
        async save() {
            if (!!this.order.payment_id === false) {
                return;
            }
            this.pageLoading = true;

            await apiPaidOrder(this.order.document_id, this.order.payment_id)
                .then(res => {
                    if (res.status == 200) {
                        this.msg = "已儲存";
                        this.error = false;
                        this.show_msg = true;
                    } else {
                        this.msg = "發生不明錯誤，請確認訂單狀態";
                        this.error = true;
                        this.show_msg = true;
                    }
                })
                .catch(err => {
                    console.log(err);
                    this.msg = err.response.data.message;
                    this.error = true;
                    this.show_msg = true;
                });

            await this.cancel();
        },
        closeMsgWindow() {
            this.msg_dialog = false;
            this.upload_result = [];
        },
        cancel() {
            this.pageLoading = false;
            this.order_id = "";
            this.order = null;
            this.dialog = false;
            this.$refs.barcode_input.focus();
        },
        download() {
            alert(this.choose_file.filename);
            this.choose_file = null;
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
            await apiUploadPayments(form_data)
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
        this.init_obj();
    }
};
</script>
