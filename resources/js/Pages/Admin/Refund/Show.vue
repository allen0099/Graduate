<template>
    <VuetifyLayout>
        <template #header>
            還款處理
        </template>
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                <v-btn-toggle
                    v-model="set_type"
                    color="deep-purple accent-3"
                    group
                    mandatory
                    dense
                    class="hidden-sm-and-down"
                >
                    <v-btn>
                        未處理
                    </v-btn>
                    <v-btn>
                        已建立批次
                    </v-btn>
                    <v-btn>
                        已送出
                    </v-btn>
                    <v-btn>
                        已完成
                    </v-btn>
                </v-btn-toggle>
            </v-card-title>
            <v-card-text class="font-weight-bold">
                <v-data-table
                    :headers="headers_sets"
                    :items="select_sets_list"
                    :search="set_search"
                    class="elevation-1"
                    multi-sort
                >
                    <template v-slot:top>
                        <v-row
                            dense
                            align="center"
                        >
                            <v-col cols=9>
                                <v-text-field
                                    v-model="set_search"
                                    label="搜尋"
                                    class="mx-4"
                                ></v-text-field>
                            </v-col>
                            <!-- <v-col cols=3>
                                <v-btn>名單下載</v-btn>
                            </v-col> -->
                        </v-row>
                    </template>
                    <template v-slot:item.set="{ item }">
                        {{ item.cloth.spec }}, {{ item.accessory.spec }}
                    </template>
                    <template v-slot:item.returned="{ item }">
                        {{ new Date(item.returned).Format("MM/dd") }}
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                待還款名單
                <v-spacer></v-spacer>
            </v-card-title>
            <v-card-text class="font-weight-bold">
                <v-row
                    dense
                    align="center"
                >
                    <v-col>
                        <v-select
                            v-model="start_date"
                            :items="dateList"
                            label="起始日期"
                        ></v-select>
                    </v-col>
                    <v-col>
                        <v-select
                            v-model="end_date"
                            :items="dateList.filter(x => x >= this.start_date)"
                            label="結束日期"
                        ></v-select>
                    </v-col>
                    <v-btn
                        @click="search_set"
                        class="ml-3"
                        :disabled="!start_date || !end_date"
                    >查詢</v-btn>
                </v-row>
            </v-card-text>
        </v-card>
        <v-divider class="mx-5 v-divider-bold" />
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                還款批次列表
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="headers.filter(x=>x.code==0 || x.code==1)"
                    :items="init_list"
                    :search="init_list_search"
                    class="elevation-1"
                    multi-sort
                >
                    <!-- <template v-slot:top>
                        <v-text-field
                            v-model="init_list_search"
                            label="搜尋"
                            class="mx-4"
                        ></v-text-field>
                    </template> -->
                    <template v-slot:item.type="{ item }">
                        {{ item.type === 0 ? '學士' : '碩士' }}
                    </template>
                    <template v-slot:item.created_at="{ item }">
                        {{ new Date(item.created_at).Format("MM/dd HH:mm") }}
                    </template>
                    <template v-slot:item.start="{ item }">
                        {{ item.start.slice(5).replace('-', '/') }}~{{ item.end.slice(5).replace('-', '/') }}
                    </template>
                    <template v-slot:item.download="{ item }">
                        <v-btn
                            :href="`/refund_pdf?id=${item.id}`"
                            target="_blank"
                        >下載</v-btn>
                    </template>
                    <template v-slot:item.delete="{ item }">
                        <v-btn @click="alert_open(item, '刪除', 0)">刪除</v-btn>
                    </template>
                    <template v-slot:item.send="{ item }">
                        <v-btn @click="alert_open(item, '送出', 2)">送出</v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
        <v-divider class="mx-5 v-divider-bold" />
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                已送至出納組
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="headers.filter(x=>x.code==0 || x.code==2)"
                    :items="progress_list"
                    :search="progress_list_search"
                    class="elevation-1"
                    multi-sort
                >
                    <!-- <template v-slot:top>
                        <v-text-field
                            v-model="progress_list_search"
                            label="搜尋"
                            class="mx-4"
                        ></v-text-field>
                    </template> -->
                    <template v-slot:item.type="{ item }">
                        {{ item.type === 0 ? '學士' : '碩士' }}
                    </template>
                    <template v-slot:item.updated_at="{ item }">
                        {{ new Date(item.updated_at).Format("MM/dd HH:mm") }}
                    </template>
                    <template v-slot:item.start="{ item }">
                        {{ item.start.slice(5).replace('-', '/') }}~{{ item.end.slice(5).replace('-', '/') }}
                    </template>
                    <template v-slot:item.download="{ item }">
                        <v-btn
                            :href="`/refund_pdf?id=${item.id}`"
                            target="_blank"
                        >列印(請款)</v-btn>
                    </template>
                    <template v-slot:item.back="{ item }">
                        <v-btn @click="alert_open(item, '退回', 1)">退回</v-btn>
                    </template>
                    <template v-slot:item.done="{ item }">
                        <v-btn @click="alert_open(item, '完成', 3)">完成</v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>

        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                已還款
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="headers.filter(x=>x.code==0 || x.code==3)"
                    :items="finished_list"
                    :search="finished_list_search"
                    class="elevation-1"
                    multi-sort
                >
                    <!-- <template v-slot:top>
                        <v-text-field
                            v-model="finished_list_search"
                            label="搜尋"
                            class="mx-4"
                        ></v-text-field>
                    </template> -->
                    <template v-slot:item.type="{ item }">
                        {{ item.type === 0 ? '學士' : '碩士' }}
                    </template>
                    <template v-slot:item.updated_at="{ item }">
                        {{ new Date(item.updated_at).Format("MM/dd HH:mm") }}
                    </template>
                    <template v-slot:item.start="{ item }">
                        {{ item.start.slice(5).replace('-', '/') }}~{{ item.end.slice(5).replace('-', '/') }}
                    </template>
                    <template v-slot:item.download="{ item }">
                        <v-btn
                            :href="`/refund_pdf?id=${item.id}`"
                            target="_blank"
                        >下載</v-btn>
                    </template>
                    <template v-slot:item.back="{ item }">
                        <v-btn
                            @click="alert_open(item, '退回', 2)"
                            :disabled="item.lock"
                        >退回</v-btn>
                    </template>
                    <template v-slot:item.lock="{ item }">
                        <v-btn
                            @click="alert_open(item, '鎖定', -1)"
                            :disabled="item.lock"
                        >
                            {{item.lock ? '已鎖定' : '鎖定'}}
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>

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

        <v-dialog
            v-model="dialog_search_set"
            persistent
            max-width="1200px"
        >
            <v-card>
                <v-card-title>建立還款批次名單 {{start_date}} ～ {{end_date}}
                    <v-spacer></v-spacer>
                    <v-btn-toggle
                        v-model="search_toggle_btn"
                        rounded
                        mandatory
                        color="primary"
                    >
                        <v-btn>
                            學士
                        </v-btn>
                        <v-btn>
                            碩士
                        </v-btn>
                    </v-btn-toggle>
                </v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-text-field
                        v-model="search_sets_search"
                        class="mb-3"
                        label="搜尋"
                        hide-details
                        clearable
                    ></v-text-field>
                    <v-data-table
                        v-model="selected_set"
                        :headers="headers_search_sets"
                        :items="search_sets"
                        item-key="id"
                        :search="search_sets_search"
                        show-select
                        class="elevation-1"
                    >
                        <template v-slot:item.set="{ item }">
                            {{ item.cloth.spec }}, {{ item.accessory.spec }}
                        </template>
                        <template v-slot:item.returned="{ item }">
                            {{ new Date(item.returned).Format("MM/dd") }}
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-spacer></v-spacer>
                <v-card-actions>
                    <span class="ml-3"> 已勾選 {{ selected_set.length }} 筆，共 {{search_sets.length}}
                        筆</span>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        dark
                        @click="list_cancel"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        :dark="selected_set.length != 0"
                        @click="list_build"
                        :disabled="selected_set.length == 0"
                    >
                        建立
                    </v-btn>
                </v-card-actions>
            </v-card>
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
        </v-dialog>


        <v-dialog
            v-model="dialog_alert"
            persistent
            max-width="400"
        >
            <v-card>
                <v-card-title>
                    {{ '還款批次列表' }} - {{ btn_name }}
                </v-card-title>
                <v-card-text class="font-weight-bold">
                    確定要{{ btn_name }}?
                </v-card-text>
                <v-spacer></v-spacer>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        dark
                        @click="alert_cancel"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        dark
                        @click="alert_confirm()"
                    >
                        確定
                    </v-btn>
                </v-card-actions>
            </v-card>
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
    </VuetifyLayout>
</template>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import {
        apiNoneListedSets,
        apiNewCashierList,
        apiGetListByStatus,
        apiUpdateListStatus,
        apiLockList
    } from '@/api/api'

    import {
        Status,
        StatusMsg,
        Refond_code
    } from '@/api/config'

    export default {
        components: {
            VuetifyLayout,
        },
        name: "AdminRefund",
        data: () => ({
            set_type: 0,
            btn_name: '',
            search_toggle_btn: '學士',
            dialog_search_set: false,
            dialog_alert: false,
            pageLoading: false,
            snackbar: false,
            snackbar_true: false,
            msg: '',
            dateList: [],
            start_date: null,
            end_date: null,
            search: '',
            init_list_search: '',
            progress_list_search: '',
            finished_list_search: '',
            search_sets_search: '',
            search_sets_B: [],
            search_sets_M: [],
            selected_set: [],
            sets_list_0: [],
            sets_list_1: [],
            sets_list_2: [],
            sets_list_3: [],
            set_search: '',
            headers_sets: [{
                text: '批次',
                align: 'start',
                sortable: true,
                value: 'list_id',
            }, {
                text: '學號',
                align: 'start',
                sortable: false,
                value: 'student.username',
            }, {
                text: '姓名',
                align: 'start',
                sortable: false,
                value: 'student.name',
            }, {
                text: '系級',
                align: 'start',
                sortable: true,
                value: 'student.school_class.class_name',
            }, {
                text: '衣服',
                align: 'start',
                sortable: false,
                value: 'cloth.name',
            }, {
                text: '規格',
                align: 'start',
                sortable: false,
                value: 'set',
            }, {
                text: '歸還日期',
                align: 'start',
                sortable: true,
                value: 'returned',
            }, ],
            headers_search_sets: [{
                text: '學號',
                align: 'start',
                sortable: false,
                value: 'student.username',
            }, {
                text: '姓名',
                align: 'start',
                value: 'student.name',
            }, {
                text: '系級',
                align: 'start',
                value: 'student.school_class.class_name',
            }, {
                text: '衣服',
                align: 'start',
                value: 'cloth.name',
            }, {
                text: '規格',
                align: 'start',
                value: 'set',
            }, {
                text: '歸還日期',
                align: 'start',
                value: 'returned',
            }, ],
            none_list: [],
            init_list: [],
            progress_list: [],
            finished_list: [],
            edit_list: null,
            edit_status_code: 0,
            headers: [{
                    text: '批次編號',
                    align: 'start',
                    sortable: true,
                    value: 'id',
                    code: 0
                },
                {
                    text: '學位',
                    align: 'center',
                    sortable: true,
                    value: 'type',
                    code: 0
                },
                {
                    text: '建立時間',
                    align: 'center',
                    sortable: true,
                    value: 'created_at',
                    code: 1
                },
                {
                    text: '送出時間',
                    align: 'center',
                    sortable: true,
                    value: 'updated_at',
                    code: 2
                },
                {
                    text: '完成時間',
                    align: 'center',
                    sortable: true,
                    value: 'updated_at',
                    code: 3
                },
                {
                    text: '範圍',
                    align: 'center',
                    sortable: true,
                    value: 'start',
                    code: 0
                },
                {
                    text: '名單下載',
                    align: 'center',
                    sortable: false,
                    value: 'download',
                    code: 0
                },
                {
                    text: '刪除',
                    align: 'center',
                    sortable: false,
                    value: 'delete',
                    code: 1
                },
                {
                    text: '送出',
                    align: 'center',
                    sortable: false,
                    value: 'send',
                    code: 1
                },
                {
                    text: '退回',
                    align: 'center',
                    sortable: false,
                    value: 'back',
                    code: 2
                },
                {
                    text: '退回',
                    align: 'center',
                    sortable: false,
                    value: 'back',
                    code: 3
                },
                {
                    text: '完成',
                    align: 'center',
                    sortable: false,
                    value: 'done',
                    code: 2
                },
                {
                    text: '鎖定',
                    align: 'center',
                    sortable: false,
                    value: 'lock',
                    code: 3
                },
            ],
        }),
        computed: {
            search_sets: function () {
                return this.search_toggle_btn === 0 ? this.search_sets_B : this.search_sets_M
            },
            select_sets_list: function () {
                if (this.set_type === 0) {
                    return this.none_list
                } else if (this.set_type === 1) {
                    return [].concat(...this.init_list.map(x => x.sets))
                } else if (this.set_type === 2) {
                    return [].concat(...this.progress_list.map(x => x.sets))
                } else if (this.set_type === 3) {
                    return [].concat(...this.finished_list.map(x => x.sets))
                } else {
                    return []
                }
            }
        },
        methods: {
            async init() {
                this.pageLoading = true
                Date.prototype.Format = function (fmt) {
                    var o = {
                        "M+": this.getMonth() + 1, //月份
                        "d+": this.getDate(), //日
                        "H+": this.getHours(), //小時
                        "m+": this.getMinutes(), //分
                        "s+": this.getSeconds(), //秒
                        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
                        "S": this.getMilliseconds() //毫秒
                    };
                    if (/(y+)/.test(fmt)) {
                        fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
                    }
                    for (var k in o) {
                        if (new RegExp("(" + k + ")").test(fmt)) {
                            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k])
                                .substr((
                                    "" +
                                    o[k]).length)));
                        }
                    }
                    return fmt;
                }

                let time_range = this.$page.configs.time_range[4]

                let today = new Date(new Date().Format("yyyy-MM-dd") + " 00:00:00")

                let start_time = new Date(time_range.start_time)
                let end_time = new Date(time_range.end_time)

                this.dateList = []

                for (let i = start_time; i <= end_time; i = new Date(i.getTime() + 24 * 60 * 60 * 1000)) {
                    if (i <= today) {
                        this.dateList.push(i.Format("yyyy-MM-dd"))
                    }
                }

                await apiGetListByStatus(Refond_code.init).then(res => {
                    if (res.status === 200) {
                        this.init_list = res.data
                    }
                })

                await apiGetListByStatus(Refond_code.progress).then(res => {
                    if (res.status === 200) {
                        this.progress_list = res.data
                    }
                })

                await apiGetListByStatus(Refond_code.finished).then(res => {
                    if (res.status === 200) {
                        this.finished_list = res.data
                    }
                })

                await apiNoneListedSets(this.dateList[0], this.dateList[this.dateList.length - 1]).then(res => {
                    if (res.status === 200) {
                        let sets_M = res.data.master
                        let sets_B = res.data.bachelor
                        this.none_list = sets_B.concat(sets_M)
                    }
                })
                await this.pageLoading_cancel();
            },
            pageLoading_cancel() {
                this.pageLoading = false
            },
            list_cancel() {
                this.pageLoading = false
                this.dialog_search_set = false
                this.start_date = null
                this.end_date = null
                this.search_sets_search = ''
                this.selected_set = []
                this.search_sets_B = []
                this.search_sets_M = []
            },
            async list_build() {
                this.pageLoading = true
                let id_list = this.selected_set.map(x => x.id)
                await apiNewCashierList(id_list, this.start_date, this.end_date).then(res => {
                    if (res.status === 200) {
                        this.init_list.push(res.data)
                        this.msg = '新增成功'
                        this.snackbar_true = true
                    } else {
                        this.msg = '連線錯誤'
                        this.snackbar_true = false
                    }
                }).catch((err) => {
                    console.log(err)
                    this.msg = '不明錯誤'
                    this.snackbar_true = false
                })

                await apiNoneListedSets(this.dateList[0], this.dateList[this.dateList.length -
                    1]).then(res => {
                    if (res.status === 200) {
                        let sets_M = res.data.master
                        let sets_B = res.data.bachelor
                        this.none_list = sets_B.concat(sets_M)
                    }
                })

                this.snackbar = true

                await this.list_cancel()
            },
            async search_set() {
                this.pageLoading = true
                this.search_sets_search = ''
                this.selected_set = []
                this.search_sets_B = []
                this.search_sets_M = []
                if (this.start_date > this.end_date) {
                    this.msg = '起始時間不可晚於結束時間'
                    this.snackbar = true
                    this.snackbar_true = false
                    this.pageLoading = false
                    return
                }
                await apiNoneListedSets(this.start_date, this.end_date).then(res => {
                    if (res.status === 200) {
                        this.search_sets_M = res.data.master
                        this.search_sets_B = res.data.bachelor
                    } else {
                        this.msg = '查詢失敗'
                        this.snackbar = true
                        this.snackbar_true = false
                    }
                    this.pageLoading = false
                    this.dialog_search_set = true
                }).catch((err) => {
                    console.log(err)
                    this.msg = '查詢失敗'
                    this.snackbar = true
                    this.snackbar_true = false
                })
                this.pageLoading = false
            },
            alert_open(item, btn_name, status_code) {
                this.dialog_alert = true
                this.btn_name = btn_name
                this.edit_list = Object.assign({}, item)
                if (status_code != -1) {
                    this.edit_status_code = status_code
                }
            },
            alert_cancel() {
                this.dialog_alert = false
                this.btn_name = ''
                this.edit_list = null
                this.edit_status_code = 0
                this.pageLoading = false
            },
            async alert_confirm() {
                this.pageLoading = true
                let id = this.edit_list.id
                if (this.btn_name === '鎖定') {
                    await apiLockList(id).then(res => {
                        if (res.status === 204) {
                            this.msg = this.btn_name + '成功'
                            this.snackbar_true = true
                            this.edit_list.lock = true
                            this.finished_list.find(x => x.id === id).lock = true
                        } else {
                            this.msg = this.btn_name + '失敗'
                            this.snackbar_true = false
                        }
                    }).catch((err) => {
                        console.log(err)
                        this.msg = '連線失敗'
                        this.snackbar_true = false
                    })
                } else {
                    await apiUpdateListStatus(id, this.edit_status_code).then(res => {
                        if (res.status === 200 || res.status === 204) {
                            if (this.edit_list.status === 1) {
                                this.init_list = this.init_list.filter(x => x.id != id)
                            } else if (this.edit_list.status === 2) {
                                this.progress_list = this.progress_list.filter(x => x.id != id)
                            } else if (this.edit_list.status === 3) {
                                this.finished_list = this.finished_list.filter(x => x.id != id)
                            }

                            this.edit_list.status = this.edit_status_code
                            if (this.edit_status_code === 1) {
                                this.init_list.push(res.data)
                            } else if (this.edit_status_code === 2) {
                                this.progress_list.push(res.data)
                            } else if (this.edit_status_code === 3) {
                                this.finished_list.push(res.data)
                            }

                            this.msg = this.btn_name + '成功'
                            this.snackbar_true = true

                        } else {
                            this.msg = '連線失敗'
                            this.snackbar_true = false
                        }
                    }).catch((err) => {
                        console.log(err)
                        this.msg = '連線失敗'
                        this.snackbar_true = false
                    })

                    if (this.edit_status_code === 0) {
                        await apiNoneListedSets(this.dateList[0], this.dateList[this.dateList.length -
                            1]).then(res => {
                            if (res.status === 200) {
                                let sets_M = res.data.master
                                let sets_B = res.data.bachelor
                                this.none_list = sets_B.concat(sets_M)
                            }
                        })
                    }
                }
                this.snackbar = true
                await this.alert_cancel()
            },
        },
        created() {
            this.init()
        },
    }

</script>
