<template>
    <VuetifyLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">
                訂單管理
            </h2>
        </template>
        <v-container v-resize="onResize">
            <v-row class="mb-5">
                <v-col
                    class="d-flex justify-end"
                    cols="12"
                >
                    <v-text-field
                        v-model="$page.search"
                        label="訂單搜尋 (學號或訂單編號)"
                        single-line
                        hide-details
                        clearable
                        @keyup.enter="search_submit"
                    ></v-text-field>
                    <v-btn
                        class="ml-3 mt-3"
                        @click="search_submit"
                    >搜尋</v-btn>
                </v-col>
            </v-row>
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
                    v-for="(filter, index) in statusMsg"
                    :value="index"
                    :key="`filter-${index}`"
                    text
                >
                    {{ filter }}
                </v-btn>
            </v-btn-toggle>
            <!-- {{ statusFilterSelected }} -->
            <!-- <v-overflow-btn
                v-model="statusFilterSelected"
                :items="statusMsg"
                label="Select size"
                hide-details
                class="hidden-md-and-up"
                disable-lookup
            ></v-overflow-btn> -->
            <!-- {{ statusMsgObj }} -->
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
                            <v-card-text class="font-weight-bold">
                                <v-row dense>
                                    <v-col
                                        cols="12"
                                        class="d-flex justify-end"
                                    >
                                        <v-btn
                                            outlined
                                            color="indigo"
                                            @click="edit_order(order)"
                                        >
                                            編輯
                                            <v-icon right>
                                                mdi-pencil
                                            </v-icon>
                                        </v-btn>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >班級：{{ 'meow' }}</v-col>
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
                                    >訂單日期：{{ order.created_at.slice(0, 16) }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >總金額：{{ '10000' }}</v-col>
                                    <!-- <v-col
                                        v-if="order.payment_id"
                                        cols="12"
                                    >付款單據編號：{{ windowSize.x >= 430 ? order.payment_id :'' }}</v-col>
                                    <v-col
                                        v-if="order.payment_id && windowSize.x < 430"
                                        cols="12"
                                    >{{order.payment_id }}</v-col> -->
                                    <v-col cols="12">{{ '訂單狀態：' }}</v-col>
                                    <v-col cols="12">
                                        <span :class="order.status_code === 3 ? 'green--text text--accent--3' :
                                            'red--text'">{{ statusMsg[order.status_code] }}</span>
                                        <span
                                            v-if="order.status_code === 4 || order.status_code === 5"
                                            :class="order.status_code === 3 ? 'green--text text--accent--3' :
                                            'red--text'"
                                        >{{'(品項或數量錯誤)'}}</span>
                                        <span v-if="order.logs.find(x => x.status ===
                                            3)">({{ order.logs[2].date }})</span>
                                    </v-col>
                                    <v-col
                                        v-for="log in order.logs.slice().reverse()"
                                        :key="`${order.document_id}-${log.status}`"
                                        cols="12"
                                        v-if="log.status <= order.status_code && log.status < 3"
                                    >
                                        <span class="green--text text--accent--3">{{ log.logName }}</span>
                                        <span>({{ log.date }})</span>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                            <v-card-actions v-if="order.status_code === 4">
                                <v-spacer></v-spacer>
                                <v-btn
                                    depressed
                                    small
                                    color="success"
                                >
                                    批准
                                    <v-icon
                                        right
                                        dark
                                    >
                                        mdi-check
                                    </v-icon>
                                </v-btn>
                                <v-btn
                                    depressed
                                    small
                                    color="error"
                                >
                                    取消
                                    <v-icon
                                        right
                                        dark
                                    >
                                        mdi-close
                                    </v-icon>
                                </v-btn>
                            </v-card-actions>
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
                            <!-- <v-row no-gutters>
                                <v-col
                                    cols="12"
                                    v-for="(item, index) in getOrderDetial()"
                                    :key="`${order.document_id}-detial-${index}`"
                                >{{ item.name +' '+ item.label +' '+ item.num + '件'}}</v-col>
                            </v-row> -->
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
                                                品項
                                            </th>
                                            <th class="text-left">
                                                規格
                                            </th>
                                            <th class="text-left">
                                                數量/件
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(item, index) in order.items"
                                            :key="`${order.document_id}-detial-${index}`"
                                        >
                                            <td>{{ item.name }}</td>
                                            <td>{{ item.spec }}</td>
                                            <td>{{ item.request_quantity }}</td>
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
            v-model="edit_toggle"
            max-width="850px"
        >
            <v-form
                ref="form"
                v-model="valid"
            >
                <v-card>
                    <v-card-title>
                        <span>訂單編輯</span>
                    </v-card-title>
                    <v-card-text class="font-weight-bold">
                        <v-row dense>
                            <v-col
                                cols="12"
                                md="4"
                            >班級：{{ order.owner.grade }}</v-col>
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
                            >訂單日期：{{ order.created_at.slice(0, 16) }}</v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >總金額：{{ '100000' }}</v-col>
                            <!-- <v-col clos="12">
                                <v-text-field
                                    v-model="order.payment_id"
                                    label="付款單據編號"
                                    single-line
                                    hide-details
                                ></v-text-field>
                            </v-col> -->
                            <v-col cols="12">
                                <v-select
                                    v-model="order.status_code"
                                    :items="statusMsgObj.slice(1)"
                                    item-text="text"
                                    item-value="value"
                                    label="訂單當前狀態"
                                    required
                                ></v-select>
                                <!-- <span>{{ statusMsg[order.status_code] }}</span> -->
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            text
                            @click="dialog3 = false"
                        >
                            取消
                        </v-btn>
                        <v-btn
                            color="primary"
                            text
                            @click="dialog3 = false"
                        >
                            儲存
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
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
    </VuetifyLayout>
</template>

<style>
    .click_init:before {
        background: initial;
    }

</style>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'

    export default {
        components: {
            VuetifyLayout,
        },
        name: "AdminOrder",
        data: () => ({
            pageLoading: false,
            show: [],
            statusFilterSelected: -1,
            edit_toggle: false,
            valid: false,
            baseorder: {
                document_id: "",
                payment_id: '',
                created_at: "",
                total: 0,
                status_code: 0,
                logs: [],
                owner: {}
            },
            order: {
                document_id: "",
                payment_id: '',
                created_at: "",
                total: 0,
                status_code: 0,
                logs: [],
                owner: {}
            },
            orderList: [{
                owner: {
                    name: '學生一',
                    username: '406410232',
                    department: '電機喵喵喵喵組',
                },
                document_id: "20201116990146",
                created_at: "2020-11-28 14:29",
                total: 1111,
                status_code: 3,
                payment_id: '2020-1000-4658-444',
                logs: [{
                        status: 1,
                        logName: '已付款',
                        date: '2020-11-29 14:29'
                    },
                    {
                        status: 2,
                        logName: '已領取衣服',
                        date: '2020-11-30 14:29'
                    },
                    {
                        status: 3,
                        logName: '已歸還衣服',
                        date: '2020-12-01 14:29'
                    }
                ]
            }, {
                owner: {
                    name: '學生一',
                    username: '406410232',
                    department: '電機喵喵喵喵組',
                },
                document_id: "20201116990147",
                created_at: "2020-11-28 14:29",
                total: 1111,
                status_code: 2,
                payment_id: 'payment-2020-1000-4658-444',
                logs: [{
                        status: 1,
                        logName: '已付款',
                        date: '2020-11-29 14:29'
                    },
                    {
                        status: 2,
                        logName: '已領取衣服',
                        date: '2020-11-30 14:29'
                    },
                ]
            }, {
                owner: {
                    name: '學生一',
                    username: '406410232',
                    department: '電機喵喵喵喵組',
                },
                document_id: "20201116990148",
                created_at: "2020-11-28 14:29",
                payment_id: 'payment-2020-1000-4658-444',
                total: 1111,
                status_code: 1,
                logs: [{
                    status: 1,
                    logName: '已付款',
                    date: '2020-11-29 14:29'
                }]
            }, {
                owner: {
                    name: '學生一',
                    username: '406410232',
                    department: '電機喵喵喵喵組',
                },
                document_id: "20201116990149",
                created_at: "2020-11-28 14:29",
                payment_id: '',
                total: 1111,
                status_code: 0,
                logs: []
            }, {
                owner: {
                    name: '學生一',
                    username: '406410232',
                    department: '電機喵喵喵喵組',
                },
                document_id: "20201116990150",
                created_at: "2020-11-28 14:29",
                payment_id: null,
                total: 1111,
                status_code: 4,
                logs: [{
                    status: 4,
                    logName: '已申請訂單取消',
                    date: '2020-11-29 14:29'
                }]
            }, {
                owner: {
                    name: '學生一',
                    username: '406410232',
                    department: '電機喵喵喵喵組',
                },
                document_id: "20201116990151",
                created_at: "2020-11-28 14:29",
                payment_id: null,
                total: 1111,
                status_code: 5,
                logs: [{
                        status: 4,
                        logName: '已申請訂單取消',
                        date: '2020-11-29 14:29'
                    },
                    {
                        status: 5,
                        logName: '已取消訂單',
                        date: '2020-11-29 14:29'
                    }
                ]
            }, ],
            colorList: [{
                    bg: '#fef9ef',
                    detail: '#d48344',
                },
                {
                    bg: '#fef9ef',
                    detail: '#d48344',
                },
                {
                    bg: '#fef9ef',
                    detail: '#d48344',
                },
                {
                    bg: 'green lighten-5',
                    detail: 'green darken-2',
                },
                {
                    bg: 'red lighten-5',
                    detail: 'red accent-2',
                },
                {
                    bg: 'red lighten-5',
                    detail: 'red accent-2',
                }
            ],
            statusMsg: ["未付款", "已付款，未領取衣服", "未歸還衣服", "已歸還衣服", "已申請訂單取消", "已取消訂單"],
            // statusMsg2: ["未付款", "已付款", "已領取衣服", "已歸還衣服", "已申請訂單取消", "已取消訂單"]
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
            getOrderDetial() {
                let item = [{
                    "spec": "L",
                    "num": 10,
                    "name": "學士服",
                    "price": 100
                }, {
                    "spec": "M",
                    "num": 10,
                    "name": "學士服",
                    "price": 100
                }, {
                    "spec": "XL",
                    "num": 10,
                    "name": "學士服",
                    "price": 100
                }, {
                    "spec": "白",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "spec": "黃",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "spec": "橘",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "spec": "灰",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "spec": "藍",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "spec": "紫",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }]
                return item
            },
            orderFilter(order) {
                if (this.statusFilterSelected !== null && this.statusFilterSelected !== -1) {
                    return order.status_code === this.statusFilterSelected
                }
                return true
            },
            edit_order(order) {
                this.edit_toggle = true
                this.order = Object.assign({}, order);
            },
            search_submit() {
                this.pageLoading = true

                if (this.$page.search) {
                    this.$inertia.get('/admin/order', {
                        search: this.$page.search
                    })
                } else {
                    this.$inertia.get('/admin/order')
                }
            },
            init_show() {
                // this.orderList = JSON.parse(JSON.stringify())
                // this.orderList = this.orderList.map(x => Object.assign({}, x).show = false)
                this.orderList = this.$page.orders.map(x => Object.assign({
                    show: false
                }, x))

                // this.orderList = this.$page.orders
                // console.log(this.orderList)
                // this.show = [...Array(this.$page.orders.length).keys()].map(() => false)
                // console.log(this.show)

            },
            show_handle(order_index) {
                this.show[order_index] = true
            }
        },
        computed: {
            statusMsgObj() {
                return this.statusMsg.reduce((res, item, index) => {
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
        created() {
            console.log(this.$page)
        },
        async mounted() {
            await this.onResize()
            await this.init_show()
        },
    }

</script>
