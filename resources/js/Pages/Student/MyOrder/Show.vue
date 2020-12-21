<template>
    <VuetifyLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">
                我的訂單
            </h2>
        </template>
        <v-container>
            <v-card
                v-for="order in orderList"
                :key="order.orderNumber"
                tile
                hover
                :color="colorList[order.orderStatus].bg"
                class="mt-5"
                v-if="orderFilter(order) === true"
            >
                <v-row no-gutters>
                    <v-col>
                        <v-card
                            outlined
                            tile
                            :color="colorList[order.orderStatus].bg"
                        >
                            <v-card-text class="font-weight-bold">
                                <v-row dense>
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
                            <v-row></v-row>
                            {{ getOrderDetial() }}

                        </v-card-text>
                    </div>
                </v-expand-transition>
            </v-card>
        </v-container>
    </VuetifyLayout>
</template>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'

    export default {
        props: {
            name: String
        },
        components: {
            VuetifyLayout,
        },
        name: "helloworld",
        data: () => ({
            statusFilterSelected: null,
            orderList: [{
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
                orderNumber: "20201116990149",
                orderDate: "2020-11-28 14:29",
                total: 1111,
                orderStatus: 0,
                show: false,
                logs: []
            }, {
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
                if (this.statusFilterSelected !== null) {
                    return order.orderStatus === this.statusFilterSelected
                }
                return true
            }
        }
    }

</script>
