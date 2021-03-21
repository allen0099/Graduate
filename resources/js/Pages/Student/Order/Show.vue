<template>
    <VuetifyLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                訂購流程
            </h2>
        </template>
        <v-container class="py-2 ma-0">
            <v-stepper
                v-model="step"
                vertical
                v-show="step !== 4"
            >
                <v-stepper-step
                    :complete="step > 1"
                    step="1"
                >
                    檢視當前剩餘數量
                </v-stepper-step>

                <v-stepper-content
                    step="1"
                    class="px-0 mx-0 px-sm-5 mx-sm-8"
                >
                    <v-card
                        min-height="350px"
                        flat
                    >
                        <v-card outlined>
                            <v-card-title>
                                <span>購買品項：{{ choose.name }}</span>
                                <v-spacer></v-spacer>
                                <span class="subtitle-2">
                                    <v-btn
                                        small
                                        color="blue-grey"
                                        class="ma-2 white--text"
                                        :href="`${route('find_pdf')}?name=學位服樣式`"
                                        download
                                    >
                                        <v-icon small>mdi-cloud-download-outline</v-icon>
                                        <span class="ml-xs-2">下載學位服樣式</span>
                                    </v-btn>
                                </span>
                            </v-card-title>
                            <v-card-text class="text--primary">
                                <v-row>
                                    <v-col
                                        cols="12"
                                        class="body-1"
                                    >服飾 剩餘件數</v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                        sm="4"
                                        class="body-1"
                                        v-for="c in cloths"
                                        :key="`cloths-${c.spec}`"
                                    >
                                        {{ c.spec }}：{{ c.remain_quantity }} 件
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        class="body-1"
                                    >{{ choose.accessory }} 剩餘件數</v-col>
                                    <v-col
                                        cols="12"
                                        lg="2"
                                        md="3"
                                        sm="4"
                                        class="body-1"
                                        v-for="a in accessories"
                                        :key="`accessories-${a.spec}`"
                                    >
                                        {{ a.spec }}：{{ a.remain_quantity }} 件
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-card>
                    <v-row class="mx-1">
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            @click="step = 2"
                        >
                            下一步
                        </v-btn>
                    </v-row>
                </v-stepper-content>

                <v-stepper-step
                    :complete="step > 2"
                    step="2"
                >
                    選擇品項與數量
                </v-stepper-step>
                <v-stepper-content
                    step="2"
                    class="px-0 mx-0 px-sm-5 mx-sm-8"
                >
                    <v-card
                        class="mb-5"
                        flat
                    >
                        <v-form
                            ref="form"
                            v-model="valid"
                            lazy-validation
                        >
                            <v-data-table
                                :headers="headers"
                                :items="order"
                                class="elevation-1 mt-2"
                                mobile-breakpoint="770"
                                hide-default-footer
                            >
                                <template v-slot:top>
                                    <v-toolbar flat>
                                        <v-row
                                            class="mt-3 mr-xs-2"
                                            justify="end"
                                            no-gutters
                                        >
                                            <v-col
                                                cols="10"
                                                sm="7"
                                                md="5"
                                            >
                                                <v-text-field
                                                    v-model="student_id"
                                                    label="學號"
                                                    outlined
                                                    clearable
                                                    dense
                                                    @keyup.enter="add_stdudent"
                                                    class="mr-2"
                                                    :messages="snackbar ? msg : ''"
                                                    :success="snackbar && snackbar_true === true"
                                                    :error="snackbar && snackbar_true === false"
                                                    type='tel'
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="2"
                                                md="1"
                                            >
                                                <v-btn
                                                    color="primary"
                                                    @click="add_stdudent"
                                                >新增</v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-toolbar>
                                </template>
                                <template v-slot:item.color="{ item }">
                                    <v-row dense>
                                        <v-col cols="auto">
                                            <v-select
                                                v-model="item.color"
                                                :items="accessories.filter(x=> x.remain_quantity > 0)"
                                                item-text="spec"
                                                item-value="spec"
                                                :rules="[v => !!v || '不能為空']"
                                                required
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                </template>
                                <template v-slot:item.size="{ item }">
                                    <v-row dense>
                                        <v-col cols="auto">
                                            <v-select
                                                v-model="item.size"
                                                :items="cloths.filter(x=> x.remain_quantity > 0)"
                                                item-text="spec"
                                                item-value="spec"
                                                :rules="[v => !!v || '不能為空']"
                                                required
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-icon
                                        small
                                        @click="delete_item(item)"
                                        v-if="item.stu_id != $page.user.username"
                                    >
                                        mdi-delete
                                    </v-icon>
                                </template>
                                <!-- <template v-slot:no-data>
                                <v-btn color="primary">
                                    Reset
                                </v-btn>
                            </template> -->
                            </v-data-table>
                        </v-form>
                    </v-card>
                    <v-row class="mx-1">
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            @click="step = 1"
                        >
                            上一步
                        </v-btn>
                        <v-btn
                            color="primary"
                            @click="filled_check()"
                            :disabled="order.length === 0"
                        >
                            下一步
                        </v-btn>
                    </v-row>
                </v-stepper-content>

                <v-stepper-step
                    :complete="step > 3"
                    step="3"
                >
                    確認訂單資訊
                </v-stepper-step>

                <v-stepper-content
                    step="3"
                    class="px-0 mx-0 px-sm-5 mx-sm-8"
                >
                    <v-card
                        flat
                        class="mb-5"
                    >
                        <v-card-title>{{ choose.name }}訂購</v-card-title>

                        <v-row
                            class="body-1 pa-sm-5 pa-2"
                            dense
                        >
                            <v-col cols="12"><span>訂購人：{{ $page.user.name }}</span></v-col>
                            <v-col cols="12"><span>學號：{{ $page.user.username }}</span></v-col>
                            <v-col cols="12"><span>系級：{{ $page.user.school_class.class_name }}</span></v-col>
                            <v-col cols="12"><span>訂單內容：</span></v-col>
                            <v-col cols="12">
                                <v-data-table
                                    :headers="[...headers].splice(0, 5)"
                                    :items="order"
                                    class="elevation-1 mt-2"
                                    mobile-breakpoint="770"
                                    id="table2"
                                    hide-default-footer
                                >
                                </v-data-table>
                            </v-col>
                            <v-col cols="12">
                                <v-divider></v-divider>
                            </v-col>
                            <v-col
                                cols="12"
                                class="d-flex justify-end"
                            ><span>共 {{ order.length }} 套，總金額： {{ order.length * (price + margin) }} NT$</span></v-col>
                            <v-col
                                cols="12"
                                class="d-flex justify-end"
                            ><code class="caption">* 單套價格均含保證金({{ margin }})與清潔費({{ price }})</code></v-col>
                            <v-col
                                cols="12"
                                class="d-flex justify-end"
                            ><code class="caption">* 實際金額依照繳費機器為主</code></v-col>
                        </v-row>

                    </v-card>
                    <v-row class="mx-1">

                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            @click="step = 2"
                        >
                            上一步
                        </v-btn>
                        <v-btn
                            color="primary"
                            @click="submit_order"
                        >
                            完成訂單
                        </v-btn>
                    </v-row>
                </v-stepper-content>

            </v-stepper>

            <v-stepper
                v-model="step"
                vertical
                v-show="step === 4"
            >
                <v-stepper-step
                    step="4"
                    color="success"
                    complete
                    :rules="[()=>order_check]"
                >
                    {{ order_check ? '已完成訂單' : '訂單失敗' }}
                </v-stepper-step>
                <v-stepper-content
                    step="4"
                    class="px-0 mx-0 px-sm-5 mx-sm-8"
                >
                    <v-card
                        class="mb-6"
                        min-height="350px"
                        outlined
                        color="#fef9ef"
                    >
                        <v-card-text
                            class="font-weight-bold body-1"
                            v-if="order_check"
                            v-show="result"
                        >
                            <v-row dense>
                                <v-col cols="12">訂購人：{{ result.owner.name }}
                                </v-col>
                                <v-col cols="12">系級：{{ result.owner.school_class.class_name }}</v-col>
                                <v-col cols="12">
                                    學號：{{ result.owner.username }}</v-col>
                                <v-col cols="12">
                                    訂單編號：{{ result.document_id }}</v-col>
                                <v-col cols="12">
                                    訂單日期：{{ new Date(result.created_at).Format("yyyy-MM-dd HH:mm") }}
                                </v-col>
                                <v-col cols="12">
                                    總金額：{{ result.total_price }}</v-col>
                            </v-row>
                            <v-row
                                dense
                                class="mt-5"
                            >
                                <v-col cols="12">
                                    備註
                                </v-col>
                            </v-row>
                            <ol
                                class="mt-2"
                                style="list-style: decimal;"
                            >
                                <li>
                                    <p>請在繳費期限{{ payment_time_range.start_time }}至{{ payment_time_range.end_time }}止，至校園繳費機進行繳費，繳費完成後請持繳費單據與本訂單至{{ $page.configs.payment_location }}完成繳費登記。
                                    </p>
                                </li>
                                <li>
                                    <p>請於{{ receive_time_range.start_time }}至{{ receive_time_range.end_time }}，下午2~4點持本單學生存根聯至{{ $page.configs.receive_location }}領取{{ choose.name }}。
                                    </p>
                                </li>
                            </ol>
                        </v-card-text>
                        <v-card-text
                            class="font-weight-bold body-1"
                            v-else
                        >
                            <v-row
                                dense
                                class="mb-3"
                            >
                                <v-col cols="12">{{ error_msg }}
                                </v-col>
                            </v-row>
                            <v-row
                                dense
                                v-if="owner"
                            >
                                <v-col cols="12">訂購人：{{ owner.name }}
                                </v-col>
                                <v-col cols="12">系級：{{ owner.school_class.class_name }}
                                </v-col>
                                <v-col cols="12">
                                    學號：{{ owner.username }}
                                </v-col>
                                <v-col cols="12">
                                    信箱：<a :href="`mailto:${owner.email}`">{{ owner.email }}</a>
                                </v-col>
                                <v-col
                                    cols="12"
                                    class="mt-3"
                                >
                                    您的{{ $page.orders.set.cloth.name }}規格
                                </v-col>
                                <v-col cols="12">
                                    {{ $page.orders.set.cloth.name }}尺寸：{{ $page.orders.set.cloth.spec }}
                                </v-col>
                                <v-col cols="12">
                                    {{ $page.orders.set.accessory.name }}顏色：{{ $page.orders.set.accessory.spec }}
                                </v-col>
                            </v-row>
                            <v-row
                                dense
                                class="mt-5"
                            >
                                <v-col cols="12">
                                    備註
                                </v-col>
                            </v-row>
                            <ol
                                class="mt-2"
                                style="list-style: decimal;"
                            >
                                <li>
                                    <p>請在繳費期限{{ payment_time_range.start_time }}至{{ payment_time_range.end_time }}止，至校園繳費機進行繳費，繳費完成後請持繳費單據與本訂單至{{ $page.configs.payment_location }}完成繳費登記。
                                    </p>
                                </li>
                                <li>
                                    <p>請於{{ receive_time_range.start_time }}至{{ receive_time_range.end_time }}，下午2~4點持本單學生存根聯至{{ $page.configs.receive_location }}領取{{ choose.name }}。
                                    </p>
                                </li>
                            </ol>
                        </v-card-text>
                    </v-card>

                    <v-row class="mx-1">
                        <v-spacer></v-spacer>
                        <v-btn
                            v-show="!order_check"
                            :href="route(0)"
                            class="mb-3 mr-3"
                        >
                            重新訂購
                        </v-btn>
                        <v-btn
                            v-if="result"
                            v-show="order_check"
                            :href="`${route('order-pdf')}?document_id=${result.document_id}`"
                            class="mb-3 mr-3"
                            download
                        >
                            列印訂單
                        </v-btn>
                        <v-btn
                            color="primary"
                            class="mb-3"
                            :href="route('student.myorder')"
                        >
                            前往我的訂單
                        </v-btn>
                    </v-row>
                </v-stepper-content>
            </v-stepper>
        </v-container>
        <v-dialog
            v-model="loading"
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


<style>
    .v-select__selections input {
        max-width: 80px;
    }

</style>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import * as easings from 'vuetify/es5/services/goto/easing-patterns'
    import {
        apiSearchStudent,
        apiCreateOrder,
        apiSearchOwner
    } from '@/api/api'

    export default {
        props: {
            name: String,
            re_order: {
                type: Object,
                default () {
                    return {}
                }
            },
            finish: {
                type: Boolean,
                default: false
            }
        },
        components: {
            VuetifyLayout,
        },
        name: "StudentOrder",
        data() {
            return {
                step: 1,
                loading: false,
                valid: true,
                dialog_delete: false,
                snackbar: false,
                snackbar_true: false,
                order_check: false,
                msg: '',
                owner: null,
                payment_time_range: {
                    start_time: '',
                    end_time: ''
                },
                receive_time_range: {
                    start_time: '',
                    end_time: ''
                },
                choose: {
                    type: 1,
                    name: '學士服',
                    accessory: '領巾、帽子'
                },
                choose_items: [{
                        type: 1,
                        name: '學士服',
                        accessory: '領巾、帽子'
                    },
                    {
                        type: 2,
                        name: '碩士服',
                        accessory: '帽穗、披肩'
                    },
                ],
                cloths: [],
                accessories: [],
                price: 0,
                margin: 0,
                student_id: '',
                headers: [{
                        text: '學號',
                        align: 'start',
                        value: 'stu_id',
                        width: 80,
                        sortable: false,
                    },
                    {
                        text: '姓名',
                        value: 'name',
                        width: 100,
                        sortable: false,
                    },
                    {
                        text: '班級',
                        value: 'department',
                        sortable: false,
                        width: 100,
                    },
                    {
                        text: '配件顏色',
                        value: 'color',
                        width: 50,
                        sortable: false
                    },
                    {
                        text: '尺寸',
                        value: 'size',
                        width: 20,
                        sortable: false
                    },
                    {
                        text: '操作',
                        value: 'actions',
                        width: 20,
                        sortable: false
                    },
                ],
                order: [],
                edited_item: {
                    stu_id: '',
                    name: '',
                    department: '',
                    color: '',
                    size: '',
                },
                form: this.$inertia.form({
                    '_method': 'POST',
                    'username': '',
                    'items': {}
                }, {
                    bag: 'submitOrder',
                }),
                result: null,
                error_msg: ''
            }
        },

        methods: {
            async init_obj() {

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

                if (this.$page.user.username[0] < "5") {
                    this.choose = this.choose_items[0]
                    this.cloths = this.$page.inventory.slice(8, 12)
                    this.accessories = this.$page.inventory.slice(0, 2)
                    this.price = parseInt(this.$page.configs.bachelor_price, 10)
                    this.margin = parseInt(this.$page.configs.bachelor_margin_price, 10)
                } else {
                    this.choose = this.choose_items[1]
                    this.cloths = this.$page.inventory.slice(12, 15)
                    this.accessories = this.$page.inventory.slice(2, 8)
                    this.price = parseInt(this.$page.configs.master_price, 10);
                    this.margin = parseInt(this.$page.configs.master_margin_price, 10);
                }

                let x = this.$page.configs.time_range[1]
                let y = this.$page.configs.time_range[this.$page.user.username[0] < "5" ? 2 : 3]
                this.payment_time_range.start_time = new Date(x.start_time).Format('yyyy/MM/dd')
                this.payment_time_range.end_time = new Date(x.end_time).Format('yyyy/MM/dd')
                this.receive_time_range.start_time = new Date(y.start_time).Format('yyyy/MM/dd')
                this.receive_time_range.end_time = new Date(y.end_time).Format('yyyy/MM/dd')

                let order_item = Object.assign({}, this.edited_item)
                order_item.stu_id = this.$page.user.username
                order_item.name = this.$page.user.name
                order_item.department = this.$page.user.school_class.class_name
                order_item.color = this.$page.user.school_class.default_color
                this.order.push(order_item)

                let open_time = this.$page.configs.time_range.find(x => x.id == 1)
                let start_time = new Date(open_time.start_time)
                let end_time = new Date(open_time.end_time)
                let a = new Date()
                if (!(a >= start_time && a <= end_time)) {
                    this.step = 4
                    this.order_check = false
                    this.error_msg = '非開放訂購時段，開放時間為 ' + start_time.Format("yyyy-MM-dd HH:mm:ss") + ' ~ ' +
                        end_time.Format("yyyy-MM-dd HH:mm:ss") + '。'
                    return
                }

                if (this.$page.orders.set) {
                    this.step = 4
                    this.order_check = false
                    this.error_msg = '您已有訂購紀錄，不可重複訂購，請確認是否自己或是它人已幫您訂購。'
                    await apiSearchOwner().then(res => {
                        if (res.status === 200) {
                            this.owner = res.data
                        }
                    })
                    return
                }
            },

            async add_stdudent() {
                let order_item = Object.assign({}, this.edited_item)

                if (/^([0-9]){9}$/.test(this.student_id) === false) {
                    this.student_id = ''
                    this.msg = '查無此學號'
                    this.snackbar_true = false
                    this.snackbar = true
                    return
                }

                if (this.order.length >= 10) {
                    this.student_id = ''
                    this.msg = '最多只能訂 10 件'
                    this.snackbar_true = false
                    this.snackbar = true
                    return
                }

                if (this.order.find(x => x.stu_id == this.student_id)) {
                    this.student_id = ''
                    this.msg = '此學號已在訂單中'
                    this.snackbar_true = false
                    this.snackbar = true
                    return
                }
                if (this.$page.user.username[0] != this.student_id[0]) {
                    this.student_id = ''
                    this.msg = '不可以跨學位購買'
                    this.snackbar_true = false
                    this.snackbar = true
                    return
                }

                await apiSearchStudent(this.student_id).then((res) => {
                    if (res.status == 200) {
                        if (res.data.set) {
                            this.student_id = ''
                            this.msg = '此學生已有訂購'
                            this.snackbar_true = false
                            this.snackbar = true
                        } else {
                            if (res.data.filled_pay_form === false) {
                                this.student_id = ''
                                this.msg = '此生尚未填寫「出納付款查詢平台」之基本資料與金融帳戶。'
                                this.snackbar_true = false
                                this.snackbar = true
                            } else {
                                order_item.stu_id = res.data.username
                                order_item.name = res.data.name
                                order_item.department = res.data.school_class.class_name
                                order_item.color = res.data.school_class.default_color
                                this.order.push(order_item)
                                this.student_id = ''
                                this.msg = '新增成功'
                                this.snackbar_true = true
                                this.snackbar = true
                            }
                        }
                    } else {
                        this.student_id = ''
                        this.msg = '查無此學號'
                        this.snackbar_true = false
                        this.snackbar = true
                    }
                }).catch((err) => {
                    console.log(err)
                    this.student_id = ''
                    this.msg = '查無此學號'
                    this.snackbar_true = false
                    this.snackbar = true
                })

            },
            delete_item(item) {
                let index = this.order.indexOf(item)
                this.order.splice(index, 1)
            },
            filled_check() {
                if (this.$refs.form.validate()) {
                    this.step = 3
                }
            },
            async submit_order() {
                this.loading = true
                let new_order = {}
                new_order['username'] = this.$page.user.username
                let sets = []
                for (let i of this.order) {
                    let item = {}
                    item['accessory'] = this.accessories.find(x => x.spec === i.color).id
                    item['cloth'] = this.cloths.find(x => x.spec === i.size).id
                    item['set_owner'] = i.stu_id
                    sets.push(item)
                }
                new_order['sets'] = sets
                await apiCreateOrder(new_order).then((res) => {
                    if (res.status == 200) {
                        this.order_check = true
                        this.result = res.data
                    } else {
                        this.order_check = false
                        this.error_msg = '發生不明錯誤，請重新再試一次。'
                    }
                }).catch((err) => {
                    this.order_check = false
                    this.error_msg = '發生不明錯誤，請重新再試一次。'
                })
                this.step = 4
                await this.$vuetify.goTo(0, {
                    duration: 300,
                    offset: 0,
                    easing: 'easeInOutCubic',
                })
                this.loading = false
            }
        },
        created() {
            this.init_obj()
        },
    }

</script>
