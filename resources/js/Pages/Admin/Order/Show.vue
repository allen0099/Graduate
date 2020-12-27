<template>
    <VuetifyLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">
                訂單管理
            </h2>
        </template>
        <v-container>
            <v-row class="mb-5">
                <v-col
                    class="d-flex justify-end"
                    cols="12"
                >
                    <v-text-field
                        v-model="search"
                        label="訂單搜尋"
                        single-line
                        hide-details
                        clearable
                    ></v-text-field>
                    <v-btn class="ml-3 mt-3">搜尋</v-btn>
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
                v-for="order in orderList"
                :key="order.orderNumber"
                tile
                :color="colorList[order.orderStatus].bg"
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
                            :color="colorList[order.orderStatus].bg"
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
                                    >班級：{{ order.department }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >學生：{{ order.name }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >學號：{{ order.stu_id }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >訂單編號：{{ order.orderNumber }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >訂單日期：{{ order.orderDate }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >總金額：{{ order.total }}</v-col>
                                    <v-col cols="12">
                                        <span>訂單狀態：</span>
                                        <span :class="order.orderStatus === 3 ? 'green--text text--accent--3' :
                                            'red--text'">{{ statusMsg[order.orderStatus] }}</span>
                                        <span
                                            v-if="order.orderStatus === 4 || order.orderStatus === 5"
                                            :class="order.orderStatus === 3 ? 'green--text text--accent--3' :
                                            'red--text'"
                                        >{{'(品項或數量錯誤)'}}</span>
                                        <span v-if="order.logs.find(x => x.status ===
                                            3)">({{ order.logs[2].date }})</span>
                                    </v-col>
                                    <v-col
                                        v-for="log in order.logs.slice().reverse()"
                                        :key="`${order.orderNumber}-${log.status}`"
                                        cols="12"
                                        v-if="log.status <= order.orderStatus && log.status < 3"
                                    >
                                        <span>
                                            &emsp;&emsp;&emsp;&emsp;&emsp;</span>
                                        <span class="green--text text--accent--3">{{ log.logName }}</span>
                                        <span>({{ log.date }})</span>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                            <v-card-actions v-if="order.orderStatus === 4">
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
                        :color="colorList[order.orderStatus].detail"
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
                        <v-icon>{{ order.show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
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
                                    :key="`${order.orderNumber}-detial-${index}`"
                                >{{ item.name +' '+ item.label +' '+ item.num + '件'}}</v-col>
                            </v-row> -->
                            <v-simple-table
                                dense
                                fixed-header
                                max-height="300px"
                                :color="colorList[order.orderStatus].bg"
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
                                            v-for="(item, index) in getOrderDetial()"
                                            :key="`${order.orderNumber}-detial-${index}`"
                                        >
                                            <td>{{ item.name }}</td>
                                            <td>{{ item.label }}</td>
                                            <td>{{ item.num }}</td>
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
                                class="d-flex justify-end"
                            >
                            </v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >班級：{{ order.department }}</v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >學生：{{ order.name }}</v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >學號：{{ order.stu_id }}</v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >訂單編號：{{ order.orderNumber }}</v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >訂單日期：{{ order.orderDate }}</v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >總金額：{{ order.total }}</v-col>
                            <v-col cols="12">
                                <v-select
                                    v-model="order.orderStatus"
                                    :items="statusMsgObj.slice(1)"
                                    item-text="text"
                                    item-value="value"
                                    label="訂單當前狀態"
                                    required
                                ></v-select>
                                <!-- <span>{{ statusMsg[order.orderStatus] }}</span> -->
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
        props: {
            name: String,
            search: String,
            order_meow: Object
        },
        components: {
            VuetifyLayout,
        },
        name: "AdminOrder",
        data: () => ({
            statusFilterSelected: -1,
            edit_toggle: false,
            valid: false,
            search: '',
            baseorder: {
                name: '',
                stu_id: '',
                department: '',
                orderNumber: "",
                orderDate: "",
                total: 0,
                orderStatus: 0,
                show: false,
                logs: []
            },
            order: {
                name: '',
                stu_id: '',
                department: '',
                orderNumber: "",
                orderDate: "",
                total: 0,
                orderStatus: 0,
                show: false,
                logs: []
            },
            orderList: [{
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                total: 1111,
                orderStatus: 3,
                show: false,
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
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990147",
                orderDate: "2020-11-28 14:29",
                total: 1111,
                orderStatus: 2,
                show: false,
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
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990148",
                orderDate: "2020-11-28 14:29",
                total: 1111,
                orderStatus: 1,
                show: false,
                logs: [{
                    status: 1,
                    logName: '已付款',
                    date: '2020-11-29 14:29'
                }]
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990149",
                orderDate: "2020-11-28 14:29",
                total: 1111,
                orderStatus: 0,
                show: false,
                logs: []
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990150",
                orderDate: "2020-11-28 14:29",
                total: 1111,
                orderStatus: 4,
                show: false,
                logs: [{
                    status: 4,
                    logName: '已申請訂單取消',
                    date: '2020-11-29 14:29'
                }]
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990151",
                orderDate: "2020-11-28 14:29",
                total: 1111,
                orderStatus: 5,
                show: false,
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
            statusMsg: ["未付款", "未領取衣服", "未歸還衣服", "已歸還衣服", "已申請訂單取消", "已取消訂單"],
            // statusMsg2: ["未付款", "已付款", "已領取衣服", "已歸還衣服", "已申請訂單取消", "已取消訂單"]
        }),
        methods: {
            getOrderDetial() {
                let item = [{
                    "label": "L",
                    "num": 10,
                    "name": "學士服",
                    "price": 100
                }, {
                    "label": "M",
                    "num": 10,
                    "name": "學士服",
                    "price": 100
                }, {
                    "label": "XL",
                    "num": 10,
                    "name": "學士服",
                    "price": 100
                }, {
                    "label": "白",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "label": "黃",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "label": "橘",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "label": "灰",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "label": "藍",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }, {
                    "label": "紫",
                    "num": 10,
                    "name": "帽穗、披肩",
                    "price": 100
                }]
                return item
            },
            orderFilter(order) {
                if (this.statusFilterSelected !== null && this.statusFilterSelected !== -1) {
                    return order.orderStatus === this.statusFilterSelected
                }
                return true
            },
            edit_order(order) {
                this.edit_toggle = true
                this.order = Object.assign({}, order);
            },
            init_search() {
                if (this.$route.params.search) this.search = this.$route.params.search
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
            // this.init_search()
        }
    }

</script>
