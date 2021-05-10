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
                        v-model="$page.props.search"
                        label="訂單搜尋 (學號、訂單編號或付款單據)"
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

            <v-container v-show="statusFilterSelected < -1">
                <v-btn class="ml-3">清除未付款</v-btn>
                <v-btn class="ml-3">清除未付款</v-btn>
                <v-btn class="ml-3">清除未付款</v-btn>
            </v-container>
            <!-- <v-row
                v-show="statusFilterSelected > -1"
                class="ml-2"
                justify="start"
                align="center"
            >
                <v-col cols="12">
                    <v-btn class="ml-3">清除未付款</v-btn>
                </v-col>
            </v-row> -->


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
                                <v-btn
                                    outlined
                                    color="indigo"
                                    @click="edit_order(order)"
                                    v-if="order.status_code !== Status.canceled"
                                >
                                    編輯
                                    <v-icon right>
                                        mdi-pencil
                                    </v-icon>
                                </v-btn>
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
                                    >訂單日期：{{ $moment(order.created_at).format('YYYY-MM-DD HH:mm') }}
                                    </v-col>
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
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <span>{{ '訂單狀態：' }}</span>
                                        <span :class="order.status_code === Status.returned || order.status_code === Status.refunded ? 'green--text text--accent--3' :
                                            'red--text'">{{ statusMsg[order.status_code] }}
                                            {{ !!order.deleted_at ? '(' + $moment(order.deleted_at).format('YYYY-MM-DD HH:mm') +')' : '' }}</span>
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
                                                姓名
                                            </th>
                                            <th class="text-left">
                                                系級
                                            </th>
                                            <th class="text-left">
                                                尺寸
                                            </th>
                                            <th class="text-left">
                                                顏色
                                            </th>
                                            <th
                                                class="text-left"
                                                v-if="order.status_code === Status.received"
                                            >
                                                歸還
                                            </th>
                                            <th
                                                class="text-left"
                                                v-if="order.status_code === Status.returned"
                                            >
                                                還款
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(item, index) in order.sets"
                                            :key="`${order.document_id}-detial-${index}`"
                                        >
                                            <td>{{ item.student.username }}</td>
                                            <td>{{ item.student.name }}</td>
                                            <td>{{ item.student.school_class.class_name }}</td>
                                            <td>{{ item.cloth.spec }}</td>
                                            <td>{{ item.accessory.spec }}</td>
                                            <td v-if="order.status_code === Status.received">
                                                {{ item.returned ? '已歸還' : '未歸還' }}
                                            </td>
                                            <td v-if="order.status_code === Status.returned">
                                                {{ item.refund ? '已還款' : '未還款' }}
                                            </td>
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
                            >訂單日期：{{ $moment(order.created_at).format('YYYY-MM-DD HH:mm')  }}</v-col>
                            <v-col
                                cols="12"
                                md="4"
                            >總金額：{{ order.total_price }}</v-col>
                            <v-col clos="12">
                                <v-text-field
                                    v-model="order.payment_id"
                                    label="付款單據編號"
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
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            dark
                            @click="edit_cancel"
                        >
                            取消
                        </v-btn>
                        <v-btn
                            color="primary"
                            :dark="(!order.payment_id && order.status_code > 1) == false"
                            @click="edit_save"
                            :disabled="!order.payment_id 
                            && (order.status_code > 1 && order.status_code !== Status.canceled)"
                        >
                            儲存
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
            <v-dialog
                v-model="checkCancel"
                persistent
                max-width="400px"
            >
                <v-card>
                    <v-card-title>
                        警告
                    </v-card-title>
                    <v-card-text class="font-weight-bold">
                        取消訂單後將無法復原，確定要取消訂單?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            dark
                            @click="check_cancel"
                        >
                            返回
                        </v-btn>
                        <v-btn
                            color="primary"
                            dark
                            @click="check_save"
                        >
                            確定
                        </v-btn>
                    </v-card-actions>
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
    import {
        apiCancelOrder,
        apiTrashedOrders
    } from '@/api/api'

    import {
        Status,
        StatusMsg,
        colorList
    } from '@/api/config'

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
                checkCancel: false,
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
                    owner: {
                        school_class: {
                            class_name: ''
                        }
                    }
                },
                order: {
                    document_id: "",
                    payment_id: '',
                    created_at: "",
                    total: 0,
                    status_code: 0,
                    logs: [],
                    owner: {
                        school_class: {
                            class_name: ''
                        }
                    }
                },
                orderList: [],
                Status: Status,
                colorList: colorList,
                statusMsg: StatusMsg,
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
                if (this.order.status_code === this.Status.canceled) {
                    this.checkCancel = true
                } else {
                    this.pageLoading = true
                    this.form.status_code = this.order.status_code
                    this.form.document_id = this.order.document_id
                    this.form.payment_id = this.order.payment_id
                    this.form.owner_username = this.order.owner.username
                    this.form.patch('/order/' + this.order.id, {
                        onFinish: () => {
                            this.edit_cancel()
                            this.msg = this.$page.props.errorBags.length > 0 ? '發生錯誤' : ''
                            this.snackbar = this.$page.props.errorBags.length > 0
                            this.search_submit()
                        }
                    });
                    // this.form.patch('/order/' + this.order.id).then(() => {
                    //     this.edit_cancel()
                    //     this.msg = this.$page.props.errorBags.length > 0 ? '發生錯誤' : ''
                    //     this.snackbar = this.$page.props.errorBags.length > 0
                    //     this.search_submit()
                    // });
                }
            },
            check_cancel() {
                this.checkCancel = false
                this.pageLoading = false
                this.edit_cancel()
            },
            async check_save() {
                if (this.order.status_code === this.Status.canceled) {
                    this.pageLoading = true

                    await apiCancelOrder(this.order.document_id).then(res => {
                        if (res.status == 204) {
                            this.msg = '已取消訂單'
                            let target = this.orderList.find(x => x.document_id == this.order.document_id)

                            target.status_code = this.Status.canceled
                            target.deleted_at = this.$moment().toISOString();
                        } else {
                            this.msg = '發生錯誤'
                        }
                        this.pageLoading = false
                        this.check_cancel()
                        this.snackbar = true
                    }).catch((err) => {
                        this.msg = '發生錯誤'
                        this.pageLoading = false
                        this.check_cancel()
                        this.snackbar = true
                    })
                }
                // await this.search_submit()
            },
            search_submit() {
                this.pageLoading = true

                if (this.$page.props.search) {
                    this.$inertia.get('/admin/order', {
                        search: this.$page.props.search
                    })
                } else {
                    this.$inertia.get('/admin/order')
                }
            },
            init_show() {
                this.orderList = this.$page.props.orders.map(x => Object.assign({
                    show: false
                }, x))
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
                let x = this.statusMsg.slice(1).reduce((res, item, index) => {
                    var obj = {
                        'text': item,
                        'value': index + 1
                    }
                    res.push(obj)
                    return res
                }, [])

                x.push({
                    'text': '取消訂單',
                    'value': this.Status.canceled
                })

                return x
            }
        },
        async mounted() {
            this.pageLoading = true
            await this.onResize()
            await this.init_show()
            await apiTrashedOrders().then(res => { // 我也不知道為啥要寫在這ㄏㄏ
                if (res.status == 200) {
                    let trashed_orders = res.data.map(x => Object.assign({
                        show: false
                    }, x))
                    let temp = []
                    for (let order of trashed_orders) {
                        if (!this.$page.props.search) {
                            temp = trashed_orders
                            break
                        }
                        if (this.$page.props.search == order.document_id ||
                            this.$page.props.search == order.payment_id ||
                            order.sets.findIndex(x => this.$page.props.search == x.student.username) > -1) {
                            temp.push(order)
                        }
                    }

                    this.orderList = this.orderList.concat(temp)
                }
            })
            this.pageLoading = false
        },
    }

</script>
