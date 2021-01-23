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
                                購買品項：{{ choose.name }}
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
                                        md="2"
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
                                            class="mt-3"
                                            justify="end"
                                            no-gutters
                                        >
                                            <v-col
                                                cols="7"
                                                sm="6"
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
                                    <v-select
                                        v-model="item.color"
                                        :items="accessories.filter(x=> x.remain_quantity > 0)"
                                        item-text="spec"
                                        item-value="spec"
                                        :rules="[v => !!v || '不能為空']"
                                        required
                                    ></v-select>
                                </template>
                                <template v-slot:item.size="{ item }">
                                    <v-select
                                        v-model="item.size"
                                        :items="cloths.filter(x=> x.remain_quantity > 0)"
                                        item-text="spec"
                                        item-value="spec"
                                        :rules="[v => !!v || '不能為空']"
                                        required
                                    ></v-select>
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-icon
                                        small
                                        @click="delete_item(item)"
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

                        <v-row
                            class="body-1 pa-sm-5 pa-2"
                            dense
                        >
                            <v-col cols="12"><span>訂購人：{{ $page.user.name }}</span></v-col>
                            <v-col cols="12"><span>學號：{{ $page.user.username }}</span></v-col>
                            <v-col cols="12"><span>科系：{{ '資訊工程學系(日)' }}</span></v-col>
                            <v-col cols="12">
                                <span>年級：{{ '四年級' }}&nbsp;&nbsp;&nbsp;&nbsp;班級：{{ 'B 班' }}</span>
                            </v-col>
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
                            ><span>共{{ order.length }}套，總金額： {{ order.length * 1000 }} NT$</span></v-col>
                            <v-col
                                cols="12"
                                class="d-flex justify-end"
                            ><code class="caption">* 價格均含保證金與清潔費用</code></v-col>
                            <v-col
                                cols="12"
                                class="d-flex justify-end"
                            ><code class="caption">* 實際金額依照繳費機器為主</code></v-col>
                            <v-col
                                cols="12"
                                class="d-flex justify-end"
                            ><code class="caption">* 請注意 送出訂單後無法自行取消訂單</code></v-col>
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
                            v-if="$page.flash.success"
                        >
                            <v-row dense>
                                <!-- <v-col cols="12">學生：{{ $page.flash.success.owner.name }}
                                </v-col>
                                <v-col cols="12">班級：{{ 'meow' }}</v-col>
                                <v-col cols="12">學號：{{ $page.flash.success.owner.username }}</v-col>
                                <v-col cols="12">訂單編號：{{ $page.flash.success.document_id }}</v-col>
                                <v-col cols="12">訂單日期：{{ $page.flash.success.created_at.slice(0, 16) }}</v-col>
                                <v-col cols="12">總金額：{{ $page.flash.success.total_price }}</v-col> -->
                                <v-col cols="12">學生：{{ '一二三' }}
                                </v-col>
                                <v-col cols="12">班級：{{ '資工XXXXXXX' }}</v-col>
                                <v-col cols="12">
                                    學號：{{ '123456789' }}</v-col>
                                <v-col cols="12">
                                    訂單編號：{{ '123456789123aaa' }}</v-col>
                                <v-col cols="12">
                                    訂單日期：{{ '20210101T12:55' }}
                                </v-col>
                                <v-col cols="12">
                                    總金額：{{ '99999' }}</v-col>
                                <v-col cols="12">
                                    <!-- <v-simple-table
                                        dense
                                        fixed-header
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
                                                        單價
                                                    </th>
                                                    <th class="text-left">
                                                        數量/件
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(item, index) in $page.flash.success.items"
                                                    :key="`detial-${index}`"
                                                >
                                                    <td>{{ item.name }}</td>
                                                    <td>{{ item.spec }}</td>
                                                    <td>{{ item.price }}</td>
                                                    <td>{{ item.request_quantity }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                    </v-simple-table> -->
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                    <v-row class="mx-1">

                        <v-spacer></v-spacer>
                        <v-btn
                            :href="route(0)"
                            class="mb-3 mr-3"
                            v-show="!order_check"
                        >
                            重新訂購
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
            v-model="form.processing"
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

    import * as easings from 'vuetify/es5/services/goto/easing-patterns'

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
                choose: {
                    type: 1,
                    name: '學士服',
                    accessory: '領巾'
                },
                choose_items: [{
                        type: 1,
                        name: '學士服',
                        accessory: '領巾'
                    },
                    {
                        type: 2,
                        name: '碩士服',
                        accessory: '帽穗、披肩'
                    },
                ],
                cloths: [],
                accessories: [],
                student_id: '',
                headers: [{
                        text: '學號',
                        align: 'start',
                        value: 'stu_id',
                        width: 100,
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
                        align: 'center',
                        width: 20,
                        sortable: false
                    },
                    {
                        text: '尺寸',
                        value: 'size',
                        align: 'center',
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
                    size: ''
                },
                form: this.$inertia.form({
                    '_method': 'POST',
                    'username': '',
                    'items': {}
                }, {
                    bag: 'submitOrder',
                })
            }
        },

        methods: {
            init_obj() {
                if (this.$page.user.username[0] < "5") {
                    this.choose = this.choose_items[0]
                    this.cloths = this.$page.inventory.slice(8, 12)
                    this.accessories = this.$page.inventory.slice(0, 2)
                } else {
                    this.choose = this.choose_items[1]
                    this.cloths = this.$page.inventory.slice(12, 15)
                    this.accessories = this.$page.inventory.slice(2, 8)
                }
                let order_item = Object.assign({}, this.edited_item)
                order_item.stu_id = this.$page.user.username
                order_item.name = this.$page.user.name
                order_item.department = '電機一二三四組'
                order_item.color = '白'
                this.order.push(order_item)
            },
            add_stdudent() {
                let order_item = Object.assign({}, this.edited_item)
                if (/^([0-9]){9}$/.test(this.student_id) === false) {
                    this.student_id = ''
                    this.msg = '查無此學號'
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

                order_item.stu_id = this.student_id
                order_item.name = this.$page.user.name
                order_item.department = '電機一二三四組'
                this.student_id = ''
                this.order.push(order_item)
                this.msg = '新增成功'
                this.snackbar_true = true
                this.snackbar = true
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
            submit_order() {
                this.step = 4
                this.order_check = true
                this.$vuetify.goTo(0, {
                    duration: 300,
                    offset: 0,
                    easing: 'easeInOutCubic',
                })
            }
        },
        created() {
            this.init_obj()
        },
    }

</script>
