<template>
    <div>
        <v-card
            flat
            class="mb-5"
        >
            <v-card-title>
                使用者查詢與重設密碼
            </v-card-title>
            <v-card-text class="font-weight-bold">
                <v-row>
                    <v-col
                        class="d-flex justify-end"
                        cols="12"
                    >
                        <v-text-field
                            v-model="username"
                            label="人員搜尋(帳號)"
                            hide-details
                            clearable
                            @keyup.enter="search_user"
                        ></v-text-field>
                        <v-btn
                            class="ml-3 mt-3"
                            @click="search_user"
                            dark
                        >搜尋</v-btn>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-divider class="mx-5 v-divider-bold" />
        <v-card flat>
            <v-card-title>
                <span class="mr-3">管理員列表</span>
                <v-spacer></v-spacer>
                <v-btn
                    dark
                    @click="dialog_add_admin = true"
                >
                    新增管理員
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="admin_list"
                    disable-sort
                    class="elevation-1"
                ></v-data-table>
            </v-card-text>
        </v-card>
        <v-dialog
            v-model="dialog_add_admin"
            persistent
            max-width="700"
        >
            <v-card>
                <v-card-title>新增管理員</v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row>
                        <v-col>
                            <v-text-field
                                v-model="admin.username"
                                label="帳號"
                            ></v-text-field>
                        </v-col>
                        <v-col>
                            <v-text-field
                                v-model="admin.name"
                                label="姓名"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        @click="add_admin_cancel"
                        dark
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        @click="add_admin_submit"
                        dark
                    >
                        新增
                    </v-btn>
                </v-card-actions>
            </v-card>
            <v-dialog
                v-model="add_admin_pageLoading"
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
        </v-dialog>
        <v-dialog
            v-model="dialog_search_user"
            persistent
            max-width="700"
        >
            <v-card>
                <v-card-title>
                    <span>使用者查詢</span>
                    <v-spacer></v-spacer>
                    <v-switch
                        v-model="edit_toggle"
                        :label="`編輯: ${edit_toggle.toString()}`"
                    ></v-switch>
                </v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row
                        dense
                        v-show="!edit_toggle"
                    >
                        <v-col cols="12">
                            身分：{{ user.role === 'admin' ? '管理員' : '學生'}}
                        </v-col>
                        <v-col cols="12">
                            帳號：{{ user.username }}
                        </v-col>
                        <v-col cols="12">
                            姓名：{{ user.name }}
                        </v-col>
                        <v-col
                            cols="12"
                            v-if="user.role === 'student'"
                        >
                            系級：{{ user.school_class.class_name }}
                        </v-col>
                        <v-col cols="12">
                            信箱：<a :href="`mailto:${user.email}`">{{ user.email }}</a>
                        </v-col>
                        <v-col
                            cols="12"
                            v-show="user.role === 'student'"
                        >
                            是否有填寫出納付款平台資料：{{ user.filled_pay_form ? '是' : '否' }}</a>
                        </v-col>
                    </v-row>
                    <v-row
                        dense
                        v-show="edit_toggle"
                    >
                        <v-col cols="12">
                            身分：{{ user.role === 'admin' ? '管理員' : '學生'}}
                        </v-col>
                        <v-col cols="12">
                            帳號：{{ user.username }}
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="姓名"
                                v-model="user.name"
                                hide-details
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            v-if="user.role === 'student'"
                        >
                            <v-autocomplete
                                v-model="user.school_class.class_id"
                                :items="departments"
                                label="系級"
                                item-value="class_id"
                                item-text="class_name"
                            ></v-autocomplete>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        color="error"
                        @click="reset_password_alert = true"
                        dark
                    >
                        重設密碼
                    </v-btn>
                    <v-btn
                        color="error"
                        @click="edit_user_alert = true"
                        dark
                        v-show="edit_toggle"
                    >
                        修改資料
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        @click="user_search_cancel"
                        dark
                    >
                        關閉
                    </v-btn>
                </v-card-actions>
            </v-card>
            <v-dialog
                v-model="edit_user_alert"
                persistent
                max-width="300"
            >
                <v-card>
                    <v-card-title>修改使用者資料</v-card-title>
                    <v-card-text class="font-weight-bold">
                        <v-row>
                            <v-col cols="12">確定要修改?</v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            class="mr-3"
                            color="error"
                            @click="edit_user_alert = false"
                            dark
                        >
                            取消
                        </v-btn>
                        <v-btn
                            color="primary"
                            @click="edit_user_submit"
                            dark
                        >
                            確定
                        </v-btn>
                    </v-card-actions>
                </v-card>
                <v-dialog
                    v-model="edit_user_pageLoading"
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
            </v-dialog>

            <v-dialog
                v-model="reset_password_alert"
                persistent
                max-width="500"
            >
                <v-card>
                    <v-card-title>重設密碼</v-card-title>
                    <v-card-text class="font-weight-bold">
                        <v-row dense>
                            <v-col cols="12">
                                學生帳號之密碼會重設為學號後六碼。
                            </v-col>
                            <v-col cols="12">
                                管理員帳號之密碼會重設為<code class="caption">password</code>。
                            </v-col>
                            <v-col cols="12">
                                重設完請通知該帳號擁有者盡速修改密碼，特別是管理員帳號。
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">確定要修改密碼?</v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            class="mr-3"
                            color="error"
                            @click="reset_password_alert = false"
                            dark
                        >
                            取消
                        </v-btn>
                        <v-btn
                            color="primary"
                            @click="reset_password"
                            dark
                        >
                            確定
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog
                v-model="reset_pageLoading"
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
        </v-dialog>
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
    </div>
</template>

<script>
    import {
        apiSearchStudent,
        apiResetPassword,
        apiNewAdmin,
        apiAdminList,
        apiDepartment,
        apiUpdateUser
    } from '@/api/api'

    export default {
        name: "UserSetting",
        data() {
            return {
                edit_toggle: false,
                dialog_search_user: false,
                dialog_add_admin: false,
                reset_password_alert: false,
                edit_user_alert: false,
                pageLoading: false,
                reset_pageLoading: false,
                edit_user_pageLoading: false,
                add_admin_pageLoading: false,
                dialog_edit_user: false,
                msg: '',
                snackbar: false,
                snackbar_true: false,
                username: '',
                user: {
                    username: '',
                    email: '',
                    role: '',
                    name: '',
                    filled_pay_form: '',
                    school_class: null,
                },
                admin: {
                    username: '',
                    name: '',
                },
                headers: [{
                    text: '姓名',
                    align: 'start',
                    value: 'name',
                }, {
                    text: '帳號',
                    align: 'start',
                    value: 'username',
                }, {
                    text: '信箱',
                    align: 'start',
                    value: 'email',
                }],
                admin_list: [],
                departments: []
            }
        },

        methods: {
            async init() {
                await apiAdminList().then(res => {
                    if (res.status === 200) {
                        this.admin_list = res.data
                    }
                }).catch((err) => {
                    console.log(err)
                })
                await apiDepartment().then(res => {
                    this.departments = res.data
                })
            },
            async search_user() {
                this.pageLoading = true
                await apiSearchStudent(this.username).then(res => {
                    if (res.status === 200) {
                        this.user = res.data
                        this.msg = '查詢成功'
                        this.snackbar = true
                        this.snackbar_true = true
                        this.dialog_search_user = true
                    } else {
                        this.snackbar = true
                        this.snackbar_true = false
                    }
                }).catch((err) => {
                    console.log(err)
                    this.msg = '查詢失敗'
                    this.snackbar = true
                    this.snackbar_true = false
                }).then(() => {
                    this.pageLoading = false
                })
            },
            async reset_password() {
                this.reset_pageLoading = true
                await apiResetPassword(this.user.id).then(res => {
                    if (res.status === 204) {
                        this.msg = '重設密碼成功'
                        this.snackbar = true
                        this.snackbar_true = true
                    } else {
                        this.msg = '重設密碼失敗'
                        this.snackbar = true
                        this.snackbar_true = false
                    }
                }).catch((err) => {
                    this.msg = '重設密碼失敗'
                    this.snackbar = true
                    this.snackbar_true = false
                })
                await this.user_search_cancel()
            },
            user_search_cancel() {
                this.user = {
                    username: '',
                    email: '',
                    role: '',
                    name: '',
                    filled_pay_form: '',
                    school_class: null,
                }
                this.dialog_search_user = false
                this.reset_password_alert = false
                this.edit_user_alert = false
                this.reset_pageLoading = false
                this.edit_user_pageLoading = false
            },
            async add_admin_submit() {
                this.add_admin_pageLoading = true
                await apiNewAdmin(this.admin).then(res => {
                    if (res.status === 201) {
                        let user = {
                            name: res.data.name,
                            username: res.data.username,
                            email: res.data.email
                        }
                        this.msg = '新增成功'
                        this.snackbar = true
                        this.snackbar_true = true
                        this.admin_list.push(user)
                    } else {
                        this.msg = '新增失敗'
                        this.snackbar = true
                        this.snackbar_true = false
                    }
                }).catch((err) => {
                    this.msg = '新增失敗'
                    this.snackbar = true
                    this.snackbar_true = false
                })
                await this.add_admin_cancel()
            },
            add_admin_cancel() {
                this.admin = {
                    username: '',
                    name: '',
                }
                this.dialog_add_admin = false
                this.add_admin_pageLoading = false
            },
            async edit_user_submit() {
                this.edit_user_pageLoading = true
                let id = this.user.id
                let name = this.user.name
                let class_id = this.user.role === 'admin' ? -1 : this.user.school_class.class_id
                await apiUpdateUser(id, name, class_id).then(res => {
                    if (res.status === 204) {
                        this.msg = '修改成功'
                        this.snackbar = true
                        this.snackbar_true = true

                        if (this.user.role === 'admin') {
                            this.admin_list.find(x => x.id == id).name = name
                        }
                    } else {
                        this.msg = '修改失敗'
                        this.snackbar = true
                        this.snackbar_true = false
                    }
                }).catch((err) => {
                    this.msg = '修改失敗'
                    this.snackbar = true
                    this.snackbar_true = false
                })
                await this.user_search_cancel()
            }
        },

        created() {
            this.init()
        },
    }

</script>
