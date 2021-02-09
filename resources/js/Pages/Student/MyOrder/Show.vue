<template>
    <VuetifyLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">
                我的訂單
            </h2>
        </template>
        <v-container v-resize="onResize">
            <v-btn-toggle
                v-model="statusFilterSelected"
                color="deep-purple accent-3"
                group
                mandatory
                dense
                class="hidden-sm-and-down"
            >
                <v-btn
                    :value="-1"
                    text
                >
                    {{ '全部' }}
                </v-btn>
                <v-btn
                    v-for="(filter, index) in statusMsg.slice(1)"
                    :value="index"
                    :key="`filter-${index}`"
                    text
                >
                    {{ filter }}
                </v-btn>
            </v-btn-toggle>
            <v-select
                v-model="statusFilterSelected"
                class="hidden-md-and-up"
                :items="statusMsgObj"
                items-text="text"
                items-value="value"
                label="Standard"
                hide-details
                solo
            ></v-select>

            <v-card
                v-for="(order, order_index) in orderList"
                :key="order.document_id"
                tile
                :color="colorList[order.status_code].bg"
                class="mt-5"
                v-if="orderFilter(order) === true"
            >
                <v-row no-gutters>
                    <v-col>
                        <!-- @click="order.show = !order.show" -->
                        <!-- class="click_init" -->
                        <v-card
                            outlined
                            tile
                            :color="colorList[order.status_code].bg"
                        >
                            <v-card-title class="font-weight-bold">
                                {{ order.owner.username[0] > "5" ? "碩士服" : "學士服" }}
                                <v-spacer></v-spacer>
                                <v-row dense>
                                    <v-col
                                        cols="12"
                                        class="d-flex justify-end"
                                        v-if="order.status_code === Status.created && order.owner.username == username"
                                    >
                                        <v-btn
                                            outlined
                                            color="indigo"
                                            class="mr-3"
                                            dense
                                            :href="`${route('order-pdf')}?document_id=${order.document_id}`"
                                            download
                                        >
                                            下載訂單
                                            <v-icon right>
                                                mdi-download
                                            </v-icon>
                                        </v-btn>
                                        <v-btn
                                            outlined
                                            color="error"
                                            @click="cancel_check(order)"
                                            dense
                                        >
                                            取消訂單
                                            <v-icon right>
                                                mdi-delete
                                            </v-icon>
                                        </v-btn>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        class="d-flex justify-end"
                                        v-if="order.status_code === Status.paid && order.owner.username == username"
                                    >
                                        <!-- <v-btn
                                            outlined
                                            color="indigo"
                                            class="mr-3"
                                            dense
                                            :href="`${route('order-pdf')}?document_id=${order.document_id}`"
                                            download
                                        >
                                            下載領據
                                            <v-icon right>
                                                mdi-download
                                            </v-icon>
                                        </v-btn> -->
                                        <v-btn
                                            outlined
                                            color="teal darken-2"
                                            dense
                                            @click="reservation(order)"
                                            :disabled="order.preserve"
                                        >
                                            預約領衣
                                            <v-icon right>
                                                mdi-hand-right
                                            </v-icon>
                                        </v-btn>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        class="d-flex justify-end"
                                        v-if="order.status_code === Status.received"
                                    >
                                        <v-btn
                                            outlined
                                            color="indigo"
                                            class="mr-3"
                                            dense
                                            :href="`${route('order-pdf')}?document_id=${order.document_id}`"
                                            download
                                        >
                                            下載歸還單
                                            <v-icon right>
                                                mdi-download
                                            </v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-title>
                            <v-card-text class="font-weight-bold">
                                <v-row dense>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >系級：{{ order.owner.school_class.class_name }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >學生：{{ order.owner.name }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >學號：{{ order.owner.username }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >訂單編號：{{ order.document_id }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >訂單日期：{{ new Date(order.created_at).Format("yyyy-MM-dd HH:mm") }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >總金額：{{ order.total_price }}</v-col>
                                    <v-col
                                        v-if="order.payment_id"
                                        cols="12"
                                    >付款編號：{{ order.payment_id }}
                                    </v-col>
                                    <!-- <v-col
                                        v-if="order.payment_id"
                                        cols="12"
                                    >付款單據編號：{{ windowSize.x >= 430 ? order.payment_id :'' }}
                                    </v-col>
                                    <v-col
                                        v-if="order.payment_id && windowSize.x < 430"
                                        cols="12"
                                    >{{order.payment_id }}</v-col> -->
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <span>{{ '訂單狀態：' }}</span>
                                        <span :class="order.status_code === Status.returned || order.status_code === Status.refunded ? 'green--text text--accent--3' :
                                            'red--text'">{{ statusMsg[order.status_code] }}</span>
                                    </v-col>
                                    <v-col
                                        v-if="order.status_code === Status.paid"
                                        cols="12"
                                        md="4"
                                    >
                                        <span>{{ '預約領衣日期：' }}</span>
                                        <span :class=" order.preserve ? 'green--text text--accent--3' :
                                            'red--text'">{{ order.preserve ? order.preserve : '未預約' }}</span>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>

                <v-card-actions>
                    <v-btn
                        :color="colorList[order.status_code].detail"
                        text
                        class="font-weight-bold"
                        @click="order.show = !order.show"
                    >
                        訂單詳細資訊
                    </v-btn>

                    <v-spacer></v-spacer>
                    <v-btn
                        icon
                        @click="order.show = !order.show"
                    >
                        <v-icon>{{ order.show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}
                        </v-icon>
                    </v-btn>
                </v-card-actions>
                <v-expand-transition>
                    <div v-show="order.show">
                        <v-divider></v-divider>

                        <v-card-text>
                            <v-simple-table
                                dense
                                fixed-header
                                max-height="300px"
                                :color="colorList[order.status_code].bg"
                            >
                                <template v-slot:default>
                                    <thead>
                                        <tr>
                                            <th class="text-left">
                                                學號
                                            </th>
                                            <th class="text-left">
                                                尺寸
                                            </th>
                                            <th class="text-left">
                                                顏色
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(item, index) in order.sets"
                                            :key="`${order.document_id}-detial-${index}`"
                                        >
                                            <td>{{ item.student.username }}</td>
                                            <td>{{ item.cloth.spec }}</td>
                                            <td>{{ item.accessory.spec }}</td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-card-text>
                    </div>
                </v-expand-transition>
            </v-card>
        </v-container>
        <v-dialog
            v-model="cancelDialog"
            max-width="400px"
            persistent
        >
            <v-card>
                <v-card-title>
                    警告
                </v-card-title>
                <v-card-text class="font-weight-bold">
                    <ol class="mt-1">
                        <li>
                            訂單尚未付款時可以取消訂單
                        </li>
                        <li class="mt-1">取消訂單後將無法復原，確定要取消訂單?
                        </li>
                    </ol>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="check_cancel"
                    >
                        返回
                    </v-btn>
                    <v-btn
                        color="primary"
                        text
                        @click="check_save"
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
            v-model="reservationDialog"
            max-width="650px"
        >
            <v-card>
                <v-card-title>
                    選擇領取衣服日期
                </v-card-title>
                <v-card-text>
                    <v-select
                        v-model="select_date"
                        :items="timeList"
                        :label="timeList.length == 0 ? '已過期' : '預約日期'"
                    ></v-select>
                    <ol
                        class="mt-2"
                        style="list-style: decimal;"
                    >
                        <li>開放領取{{ $page.user.username[0] < "5" ? '學士服' : '碩士服' }}時段：
                            <span style="color: #d48344;">{{ time_range.start_time }} ~
                                {{ time_range.end_time }}
                            </span>。
                        </li>
                        <li>最晚預約時間為欲預約之日期前 2 天，如欲預約 03/10 請在 03/08 23:59:59 前預約完畢。
                        </li>
                        <li>
                            <span>請注意，</span>
                            <span class="red--text">預約後即不允許修改。
                            </span>
                        </li>
                        <li>領取當天請攜帶領據，並且確認領據上的每一位同學都有簽名。
                        </li>
                    </ol>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="reservation_cancel"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        text
                        @click="pageLoading = true"
                        :disabled="!select_date"
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
                    v-if="reservationCheck"
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
                <v-card v-else>
                    <v-card-title>
                        再次確認
                    </v-card-title>
                    <v-card-text class="font-weight-bold">
                        確定預約 {{ select_date }} ?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            text
                            @click="pageLoading = false"
                        >
                            返回
                        </v-btn>
                        <v-btn
                            color="primary"
                            text
                            @click="reservation_save"
                        >
                            確定
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
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
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                    :color="snackbar_true ? 'success' : 'error'"
                >
                    關閉
                </v-btn>
            </template>
        </v-snackbar>
    </VuetifyLayout>
</template>

<style>
    .click_init:before {
        background: initial;
    }

</style>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import {
        Status,
        StatusMsg,
        colorList
    } from '@/api/config'

    import {
        apiPreserveDate,
        apiCancelOrder
    } from '@/api/api'

    export default {
        components: {
            VuetifyLayout,
        },
        name: "StudentMyorder",
        data: () => ({
            username: '',
            cancelDialog: false,
            reservationDialog: false,
            pageLoading: false,
            reservationCheck: false,
            snackbar: false,
            snackbar_true: false,
            statusFilterSelected: -1,
            order: null,
            msg: '',
            orderList: [],
            Status: Status,
            colorList: colorList,
            statusMsg: StatusMsg,
            time_range: {
                end_time: '2021-01-01',
                start_time: '2021-01-01'
            },
            timeList: [],
            select_date: null,
            windowSize: {
                x: 0,
                y: 0,
            },
        }),
        methods: {
            onResize() {
                this.windowSize = {
                    x: window.innerWidth,
                    y: window.innerHeight
                }
                if (this.windowSize.x <
                    960) {
                    this.item_height = 280
                } else {
                    this.item_height = 160
                }
            },
            orderFilter(order) {
                if (this.statusFilterSelected !== null && this.statusFilterSelected !== -1) {
                    return order.status_code === this.statusFilterSelected + 1
                }
                return true
            },
            init() {
                this.username = this.$page.user.username
                this.orderList = this.$page.orders.own.map(x => Object.assign({
                    show: false
                }, x))

                if (this.$page.orders.shared) {
                    this.orderList.push({
                        ...this.$page.orders.shared,
                        show: false
                    });
                }

                this.time_range = this.$page.configs.time_range[this.$page.user.username[0] < "5" ? 2 : 3]

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
                            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr((
                                "" +
                                o[k]).length)));
                        }
                    }
                    return fmt;
                }


                let today = new Date(new Date().Format("yyyy-MM-dd") + " 00:00:00")

                let start_time = new Date(this.time_range.start_time + " 00:00:00")
                let end_time = new Date(this.time_range.end_time + " 00:00:00")

                let x = new Date(today.getTime() + 2 * 24 * 60 * 60 * 1000)

                this.timeList = []

                for (let i = start_time; i <= end_time; i = new Date(i.getTime() + 24 * 60 * 60 * 1000)) {
                    if (x <= i) {
                        this.timeList.push(i.Format("yyyy-MM-dd"))
                    }
                }
            },
            cancel_check(order) {
                this.cancelDialog = true
                this.order = order
            },
            check_cancel() {
                this.cancelDialog = false
                // this.order = null
            },
            async check_save() {
                this.pageLoading = true
                await apiCancelOrder(this.order.document_id).then(res => {
                    if (res.status == 204) {
                        this.msg = '已取消訂單'
                        this.orderList.splice(this.orderList.findIndex(x => x.document_id == this.order
                            .document_id), 1)
                        this.snackbar_true = true
                    } else {
                        this.msg = '發生錯誤'
                        this.snackbar_true = false
                    }
                    this.pageLoading = false
                    this.check_cancel()
                    this.snackbar = true
                }).catch((err) => {
                    this.msg = '發生錯誤'
                    this.pageLoading = false
                    this.check_cancel()
                    this.snackbar_true = false
                    this.snackbar = true
                })
            },
            reservation(order) {
                this.order = order
                this.select_date = null
                this.reservationDialog = true
                this.reservationCheck = false
            },
            reservation_cancel() {
                this.order = null
                this.reservationDialog = false
            },
            async reservation_save() {
                this.reservationCheck = true
                await apiPreserveDate(this.order.document_id, this.select_date).then(res => {
                    if (res.status == 200) {
                        this.msg = '已預約'
                        this.order.preserve = this.select_date
                        this.snackbar_true = true
                    } else {
                        this.msg = '發生錯誤'
                        this.snackbar_true = false
                    }
                    this.snackbar = true
                    this.pageLoading = false
                }).catch((err) => {
                    this.msg = '發生錯誤'
                    this.snackbar_true = false
                    this.snackbar = true
                    this.pageLoading = false
                })
                await this.reservation_cancel()
            }
        },
        computed: {
            statusMsgObj() {
                return this.statusMsg.slice(1).reduce((res, item, index) => {
                    var obj = {
                        'text': item,
                        'value': index
                    }
                    res.push(obj)
                    return res
                }, [{
                    'text': '全部',
                    'value': -1
                }])
            }
        },
        async mounted() {
            await this.onResize()
        },
        created() {
            this.init()
        }
    }

</script>
