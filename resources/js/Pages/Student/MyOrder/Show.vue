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
                            <v-card-text class="font-weight-bold">
                                <v-row dense>
                                    <v-col
                                        cols="12"
                                        class="d-flex justify-end"
                                        v-if="order.status_code === 1"
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
                                                mdi-delete
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
                                    >訂單日期：{{ order.created_at.slice(0, 16) }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >總金額：{{ order.total_price }}</v-col>
                                    <v-col
                                        v-if="order.payment_id"
                                        cols="12"
                                    >付款單據編號：{{ windowSize.x >= 430 ? order.payment_id :'' }}
                                    </v-col>
                                    <v-col
                                        v-if="order.payment_id && windowSize.x < 430"
                                        cols="12"
                                    >{{order.payment_id }}</v-col>
                                    <!-- <v-col cols="12">{{ '訂單狀態：' }}</v-col> -->
                                    <v-col cols="12">
                                        <span>{{ '訂單狀態：' }}</span>
                                        <span :class="order.status_code === 4 ? 'green--text text--accent--3' :
                                            'red--text'">{{ statusMsg[order.status_code] }}</span>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>

                <v-card-actions v-show="order.status_code != 5">
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
                <v-expand-transition v-show="order.status_code != 5">
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
            v-model="dialog"
            max-width="400px"
            persistent
        >
            <v-card>
                <v-card-title>
                    警告
                </v-card-title>
                <v-card-text>
                    取消訂單後將無法復原，確定要取消訂單?
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
        <v-snackbar
            v-model="snackbar"
            :timeout="2000"
        >
            {{ msg }}
            <template v-slot:action="{ attrs }">
                <v-btn
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                    color="red"
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

    export default {
        components: {
            VuetifyLayout,
        },
        name: "StudentMyorder",
        data: () => ({
            dialog: false,
            pageLoading: false,
            snackbar: false,
            statusFilterSelected: -1,
            order: null,
            msg: '',
            orderList: [],
            colorList: [{
                    bg: '#fef9ef',
                    detail: '#d48344',
                }, {
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
                    bg: '#fef9ef',
                    detail: '#d48344',
                },
                {
                    bg: '#fef9ef',
                    detail: '#d48344',
                },
            ],
            statusMsg: ["已結單", "未付款", "已付款，未領取衣服", "未歸還衣服", "已歸還衣服", "已取消訂單", "退款中", "已退款"],
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
            orderFilter(order) {
                if (this.statusFilterSelected !== null && this.statusFilterSelected !== -1) {
                    return order.status_code === this.statusFilterSelected + 1
                }
                return true
            },
            init_show() {
                // this.orderList = JSON.parse(JSON.stringify())
                // this.orderList = this.orderList.map(x => Object.assign({}, x).show = false)
                this.orderList = this.$page.orders.own.map(x => Object.assign({
                    show: false
                }, x))

                // this.orderList = this.$page.orders
                // console.log(this.orderList)
                // this.show = [...Array(this.$page.orders.length).keys()].map(() => false)
                // console.log(this.show)

            },
            cancel_check(order) {
                this.dialog = true
                this.order = order
            },
            check_cancel() {
                this.dialog = false
                this.order = null
            },
            async check_save() {
                this.pageLoading = true

                await this.$inertia.patch(`/order/${this.order.id}`, {
                    document_id: this.order.document_id,
                    owner_username: this.order.owner.username,
                    status_code: 5
                }, {
                    onSuccess: (page) => {
                        this.msg = '已取消'
                        this.order.status_code = 5
                        this.order.sets = []
                    },
                    onError: (errors) => {
                        this.msg = '發生錯誤'
                    },
                    onFinish: () => {
                        this.pageLoading = false
                        this.check_cancel()
                        this.snackbar = true
                    },
                })
            },
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
            await this.init_show()
        },
    }

</script>
