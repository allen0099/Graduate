<template>
    <div>
        <v-card flat>
            <v-row dense>
                <v-col cols="12" sm="4">
                    <v-card flat>
                        <v-card-title>學生資料上傳</v-card-title>
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
                                    >csv 檔案欄位名必須是 (名稱, 學號,
                                    系年班代碼, 系年班簡稱)</span
                                >
                            </v-tooltip>
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
                            <v-btn dark @click="add_student">單筆新增</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn dark @click="alert">上傳</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
            <v-dialog v-model="alert_dialog" persistent width="450">
                <v-card>
                    <v-card-title>
                        <v-icon color="red" large>
                            mdi-alert-octagon-outline
                        </v-icon>
                        <span class="ml-3">上傳學生資料</span>
                    </v-card-title>
                    <v-card-text class="font-weight-bold">
                        請注意，進行上傳會將舊有的學生資料與訂單資料進行刪除。
                        上傳資料請耐心等候，切勿離開網站。 確定要上傳?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="error" dark @click="alert_dialog = false">
                            取消
                        </v-btn>
                        <v-btn color="primary" dark @click="upload">
                            確定
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
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
            <v-snackbar v-model="snackbar" :timeout="-1">
                <v-icon
                    dark
                    right
                    class="mr-2"
                    :color="snackbar_true ? 'success' : 'error'"
                >
                    {{
                        snackbar_true
                            ? "mdi-checkbox-marked-circle"
                            : "mdi-alert "
                    }}
                </v-icon>
                {{ msg }}

                <template v-slot:action="{ attrs }">
                    <v-btn
                        :color="snackbar_true ? 'success' : 'error'"
                        text
                        v-bind="attrs"
                        @click="snackbar_close"
                    >
                        關閉
                    </v-btn>
                </template>
            </v-snackbar>
        </v-card>
        <v-dialog v-model="edit_dialog" max-width="600px" persistent>
            <v-card>
                <v-card-title>單筆新增學生</v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row>
                        <v-col cols="4">
                            <v-text-field
                                v-model="edit_student.username"
                                label="學號"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-autocomplete
                                v-model="edit_student.class_id"
                                :items="departments"
                                label="系級"
                                item-value="class_id"
                                item-text="class_name"
                            ></v-autocomplete>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field
                                v-model="edit_student.name"
                                label="姓名"
                            ></v-text-field>
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
                            (!edit_student.username ||
                                !edit_student.name ||
                                !edit_student.class_id) == false
                        "
                        @click="save"
                        :disabled="
                            !edit_student.username ||
                                !edit_student.name ||
                                !edit_student.class_id
                        "
                    >
                        新增
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { apiUploadStudent, apiNewStudent, apiDepartment } from "@/api/api";
export default {
    name: "UploadStudentData",
    data() {
        return {
            alert_dialog: false,
            pageLoading: false,
            snackbar: false,
            snackbar_true: false,
            msg: "",
            file: null,
            edit_dialog: false,
            refresh: false,
            student: {
                name: null,
                class_id: null,
                username: null
            },
            edit_student: {
                name: null,
                class_id: null,
                username: null
            },
            departments: []
        };
    },

    methods: {
        async init() {
            await apiDepartment().then(res => {
                this.departments = res.data;
            });
        },

        alert() {
            if (!this.file) {
                this.msg = "請先選擇檔案";
                this.snackbar = true;
                this.snackbar_true = false;
                this.pageLoading = false;
                return;
            }
            this.alert_dialog = true;
        },

        async upload() {
            this.alert_dialog = false;
            this.pageLoading = true;
            this.snackbar = false;
            let form_data = new FormData();
            form_data.append("csv_file", this.file);
            await apiUploadStudent(form_data)
                .then(res => {
                    if (res.status === 204) {
                        this.msg = "學生資料上傳成功";
                        this.snackbar = true;
                        this.snackbar_true = true;
                        this.refresh = true;
                    } else {
                        this.msg = "學生資料上傳失敗";
                        this.snackbar = true;
                        this.snackbar_true = false;
                    }
                    this.pageLoading = false;
                })
                .catch(err => {
                    console.log(err);
                    this.msg = err.response.data.errors;
                    if (!!this.msg === false) {
                        this.msg = "學生資料上傳失敗";
                    }
                    this.snackbar = true;
                    this.snackbar_true = false;
                    this.pageLoading = false;
                });
        },
        add_student() {
            this.edit_dialog = true;
            this.edit_student = Object.assign({}, this.student);
        },
        cancel() {
            this.edit_student = Object.assign({}, this.student);
            this.edit_dialog = false;
            this.pageLoading = false;
        },
        snackbar_close() {
            this.snackbar = false;
            if (this.refresh) {
                window.location.reload();
                console.log("refresh");
            }
        },
        async save() {
            if (!/^[0-9]{9}$/.test(this.edit_student.username)) {
                this.msg = "學號錯誤";
                this.snackbar = true;
                this.snackbar_true = false;
                this.cancel();
                return;
            }
            await apiNewStudent(this.edit_student)
                .then(res => {
                    if (res.status === 201) {
                        this.msg = "新增成功";
                        this.snackbar = true;
                        this.snackbar_true = true;
                    } else {
                        this.msg = "新增失敗";
                        this.snackbar = true;
                        this.snackbar_true = false;
                    }
                    this.pageLoading = false;
                    console.log(res);
                })
                .catch(err => {
                    this.msg = err.response.data.errors;
                    if (!!this.msg === false) {
                        this.msg = "上傳失敗";
                    }
                    this.snackbar = true;
                    this.snackbar_true = false;
                    this.pageLoading = false;
                });
            await this.cancel();
        }
    },
    created() {
        this.init();
    }
};
</script>
