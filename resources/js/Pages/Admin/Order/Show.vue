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
                    v-for="(filter, index) in statusMsg.slice(1)"
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
            >
            </v-select>

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
                                    >總金額：{{ order.total_price }}</v-col>
                                    <v-col
                                        v-if="order.payment_id"
                                        cols="12"
                                    >付款單據編號：{{ windowSize.x >= 430 ? order.payment_id :'' }}</v-col>
                                    <v-col
                                        v-if="order.payment_id && windowSize.x < 430"
                                        cols="12"
                                    >{{order.payment_id }}</v-col>
                                    <v-col cols="12">{{ '訂單狀態：' }} {{ order.status_code }}</v-col>
                                    <v-col cols="12">
                                        <span :class="order.status_code === 4 ? 'green--text text--accent--3' :
                                            'red--text'">{{ statusMsg[order.status_code] }}</span>
                                        <!-- <span
                                            v-if="order.status_code === 5 || order.status_code === 6"
                                            :class="order.status_code === 4 ? 'green--text text--accent--3' :
                                            'red--text'"
                                        >{{'(品項或數量錯誤)'}}</span> -->
                                        <!-- <span v-if="order.logs.find(x => x.status ===
                                            3)">({{ order.logs[2].date }})</span> -->
                                    </v-col>
                                    <!-- <v-col
                                        v-for="log in order.logs.slice().reverse()"
                                        :key="`${order.document_id}-${log.status}`"
                                        cols="12"
                                        v-if="log.status <= order.status_code && log.status < 5"
                                    >
                                        <span class="green--text text--accent--3">{{ log.logName }}</span>
                                        <span>({{ log.date }})</span>
                                    </v-col> -->
                                </v-row>
                            </v-card-text>
                            <v-card-actions v-if="order.status_code === 5">
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
            v-model="edit_toggle"
            max-width="850px"
            persistent
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
                            >總金額：{{ order.total_price }}</v-col>
                            <v-col clos="12">
                                <v-text-field
                                    v-model="order.payment_id"
                                    label="付款單據編號"
                                    single-line
                                    hide-details
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                class="mt-3"
                            >
                                <v-select
                                    v-model="order.status_code"
                                    :value="order.status_code-1"
                                    :items="statusMsgObj2"
                                    item-text="text"
                                    item-value="value"
                                    label="訂單當前狀態"
                                    required
                                >
                                </v-select>
                                <!-- <span>{{ statusMsg[order.status_code] }}</span> -->
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            text
                            @click="edit_cancel"
                        >
                            取消
                        </v-btn>
                        <v-btn
                            color="primary"
                            text
                            @click="edit_save"
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
        <v-snackbar v-model="snackbar">
            {{ msg }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    color="primary"
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                    class="font-weight-bold"
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
    import apiRoomAirQualityValue from '@/api/api'

    export default {
        components: {
            VuetifyLayout,
        },
        name: "AdminOrder",
        data() {
            return {
                msg: '',
                snackbar: false,
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
                        bg: 'red lighten-5',
                        detail: 'red accent-2',
                    }
                ],
                statusMsg: ["已結單", "未付款", "已付款，未領取衣服", "未歸還衣服", "已歸還衣服", "已申請訂單取消", "已取消訂單"],
                // statusMsg2: ["未付款", "已付款", "已領取衣服", "已歸還衣服", "已申請訂單取消", "已取消訂單"]
                windowSize: {
                    x: 0,
                    y: 0,
                },
                form: this.$inertia.form({
                    '_method': 'PATCH',
                    'document_id': '',
                    'owner_username': '',
                    'payment_id': '',
                    'status_code': -1,
                }, {
                    bag: 'updateOrder',
                })
            }
        },
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
            edit_order(order) {
                this.edit_toggle = true
                this.order = Object.assign({}, order);
            },
            edit_cancel() {
                this.edit_toggle = false
                this.order = Object.assign({}, this.baseorder);
            },
            edit_save() {
                this.pageLoading = true
                this.form.status_code = this.order.status_code
                this.form.document_id = this.order.document_id
                this.form.payment_id = this.order.payment_id
                this.form.owner_username = this.order.owner.username
                this.form.patch('/order/' + this.order.id).then(() => {
                    this.edit_cancel()
                    this.msg = this.$page.errorBags.length > 0 ? '發生錯誤' : ''
                    this.snackbar = this.$page.errorBags.length > 0
                    this.search_submit()
                });
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
            },
            statusMsgObj2() {
                return this.statusMsg.slice(1).reduce((res, item, index) => {
                    var obj = {
                        'text': item,
                        'value': index + 1
                    }
                    res.push(obj)
                    return res
                }, [])
            }
        },
        async mounted() {
            await this.onResize()
            await this.init_show()
        },
    }

</script>
