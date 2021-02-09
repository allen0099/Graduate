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
                待還款名單 {{ dateList }}
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
                            :items="dateList"
                            label="結束日期"
                        ></v-select>
                    </v-col>
                    <v-btn
                        @click="search_set"
                        class="ml-3"
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
                    :items="list"
                    :search="search"
                    class="elevation-1"
                >
                    <template v-slot:top>
                        <v-text-field
                            v-model="search"
                            label="Search (UPPER CASE ONLY)"
                            class="mx-4"
                        ></v-text-field>
                    </template>

                    <template v-slot:item.date="{ item }">
                        {{ new Date(item.created_at).Format("yyyy-MM-dd HH:mm") }}
                    </template>
                    <template v-slot:item.download="{ item }">
                        <v-btn>下載名單</v-btn>
                    </template>
                    <template v-slot:item.delete="{ item }">
                        <v-btn>刪除</v-btn>
                    </template>
                    <template v-slot:item.send="{ item }">
                        <v-btn>送出</v-btn>
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
                    :items="list"
                    :search="search"
                    class="elevation-1"
                >
                    <template v-slot:top>
                        <v-text-field
                            v-model="search"
                            label="Search (UPPER CASE ONLY)"
                            class="mx-4"
                        ></v-text-field>
                    </template>

                    <template v-slot:item.date="{ item }">
                        {{ new Date(item.created_at).Format("yyyy-MM-dd HH:mm") }}
                    </template>
                    <template v-slot:item.download="{ item }">
                        <v-btn>下載名單</v-btn>
                    </template>
                    <template v-slot:item.back="{ item }">
                        <v-btn>退回</v-btn>
                    </template>
                    <template v-slot:item.done="{ item }">
                        <v-btn>完成</v-btn>
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
                    :items="list"
                    :search="search"
                    class="elevation-1"
                >
                    <template v-slot:top>
                        <v-text-field
                            v-model="search"
                            label="Search (UPPER CASE ONLY)"
                            class="mx-4"
                        ></v-text-field>
                    </template>

                    <template v-slot:item.date="{ item }">
                        {{ new Date(item.created_at).Format("yyyy-MM-dd HH:mm") }}
                    </template>
                    <template v-slot:item.download="{ item }">
                        <v-btn>下載名單</v-btn>
                    </template>
                    <template v-slot:item.delete="{ item }">
                        <v-btn>刪除</v-btn>
                    </template>
                    <template v-slot:item.back="{ item }">
                        <v-btn>退回</v-btn>
                    </template>
                    <template v-slot:item.send="{ item }">
                        <v-btn>送出</v-btn>
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
            max-width="600px"
        >
            <v-card>
                <v-card-title>生成還款名單</v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row dense>
                        <v-col cols="12">將該時間範圍的所有尚未處理還款的學生集合生成還款名單</v-col>
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
                                :items="dateList"
                                label="結束日期"
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-spacer></v-spacer>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="refund_cancel"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        text
                        @click="refund_save"
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
        apiNoneListedSets
    } from '@/api/api'

    import {
        Status,
        StatusMsg,
    } from '@/api/config'

    export default {
        components: {
            VuetifyLayout,
        },
        name: "AdminRefund",
        data: () => ({
            dialog_search_set: false,
            pageLoading: false,
            snackbar: false,
            snackbar_true: false,
            msg: '',
            dateList: [],
            start_date: null,
            end_date: null,
            search: '',
            search_sets: [],
            list: [{
                list_id: 'list_id-00000000001',
                created_at: '2021-02-04T15:59:59.000000Z',
                count: 100,
            }, {
                list_id: 'list_id-00000000002',
                created_at: '2021-02-04T15:59:59.000000Z',
                count: 100,
            }, {
                list_id: 'list_id-00000000003',
                created_at: '2021-02-04T15:59:59.000000Z',
                count: 100,
            }, {
                list_id: 'list_id-00000000004',
                created_at: '2021-02-04T15:59:59.000000Z',
                count: 100,
            }, {
                list_id: 'list_id-00000000005',
                created_at: '2021-02-04T15:59:59.000000Z',
                count: 100,
            }],
            headers: [{
                    text: '批次編號',
                    align: 'start',
                    sortable: true,
                    value: 'list_id',
                    code: 0
                }, {
                    text: '建立時間',
                    align: 'center',
                    sortable: false,
                    value: 'date',
                    code: 1
                },
                {
                    text: '送出時間',
                    align: 'center',
                    sortable: false,
                    value: 'date',
                    code: 2
                },
                {
                    text: '完成時間',
                    align: 'center',
                    sortable: false,
                    value: 'date',
                    code: 3
                },
                {
                    text: '數量',
                    align: 'center',
                    sortable: false,
                    value: 'count',
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
                }
            ],
        }),
        methods: {
            async init() {
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

            },
            refund_cancel() {
                this.dialog_search_set = false
                this.start_date = null
                this.end_date = null

            },
            refund_save() {
                this.dateList
                this.refund_cancel()
            },
            async search_set() {
                this.pageLoading = true
                await apiNoneListedSets(this.start_date, this.end_date).then(res => {
                    if (res.status === 200) {
                        this.search_sets = res.data
                        console.log(this.search_sets)
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
            }
        },
        created() {
            this.init()
        },
    }

</script>
