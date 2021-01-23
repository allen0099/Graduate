<template>
    <VuetifyLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                訂購流程
            </h2>
        </template>
        <v-container class="py-2 ma-0">
            <v-stepper
                v-model="e6"
                vertical
                v-show="e6 !== 4"
            >
                <v-stepper-step
                    :complete="e6 > 1"
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
                            @click="e6 = 2"
                        >
                            下一步
                        </v-btn>
                    </v-row>
                </v-stepper-content>

                <v-stepper-step
                    :complete="e6 > 2"
                    step="2"
                >
                    選擇品項與數量
                </v-stepper-step>

                <v-stepper-content
                    step="2"
                    class="px-0 mx-0 px-sm-5 mx-sm-8"
                >
                    <v-card
                        class="mb-6"
                        min-height="350px"
                        outlined
                    >
                        <v-card flat>
                            <v-card-title>每項最多只能訂購 10 件</v-card-title>
                            <v-card-text class="text--primary">
                                <v-row class="d-flex align-center body-1">
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <span>{{ choose.name }}</span>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                        sm="6"
                                    >
                                        <v-select
                                            :items="cloths.map(x=>x.spec)"
                                            label="規格"
                                            v-model="choose_cloths.spec"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                        sm="6"
                                        class="d-flex justify-end justify-sm-start"
                                    >
                                        <v-icon @click="decrement(choose_cloths)">
                                            mdi-minus
                                        </v-icon>
                                        <span class="subtitle mx-2">{{ choose_cloths.request_quantity }}</span>
                                        <v-icon @click="increment(choose_cloths, cloths)">
                                            mdi-plus
                                        </v-icon>
                                        <v-spacer class="hidden-sm-and-up"></v-spacer>
                                        <v-btn
                                            class="ml-3"
                                            small
                                            v-show="!(choose_cloths.spec && cloths.find(x=>x.spec ===
                                            choose_cloths.spec).remain_quantity === 0)"
                                            :disabled="!choose_cloths.spec 
                                                    || (!!cloths.find(x=>x.spec === choose_cloths.spec)
                                                        && cloths.find(x=>x.spec === choose_cloths.spec).remain_quantity === 0)
                                                    || choose_cloths.request_quantity === 0"
                                            @click="push_order(choose_cloths, choose.name)"
                                        >
                                            新增
                                        </v-btn>
                                        <v-btn
                                            class="ml-3"
                                            small
                                            disabled
                                            depressed
                                            v-show="choose_cloths.spec && cloths.find(x=>x.spec ===
                                            choose_cloths.spec).remain_quantity === 0"
                                        >
                                            已售完
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row class="d-flex align-center body-1">
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <span>{{ choose.accessory }}</span>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                        sm="6"
                                    >
                                        <v-select
                                            :items="accessories.map(x=>x.spec)"
                                            label="規格"
                                            v-model="choose_accessory.spec"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                        sm="6"
                                        class="d-flex justify-end justify-sm-start"
                                    >
                                        <v-icon @click="decrement(choose_accessory)">
                                            mdi-minus
                                        </v-icon>
                                        <span class="subtitle mx-2">{{ choose_accessory.request_quantity }}</span>
                                        <v-icon @click="increment(choose_accessory, accessories)">
                                            mdi-plus
                                        </v-icon>
                                        <v-spacer class="hidden-sm-and-up"></v-spacer>
                                        <v-btn
                                            class="ml-3"
                                            small
                                            v-show="!(choose_accessory.spec && accessories.find(x=>x.spec ===
                                            choose_accessory.spec).remain_quantity === 0)"
                                            :disabled="!choose_accessory.spec
                                                    || (!!accessories.find(x=>x.spec === choose_accessory.spec)
                                                        && accessories.find(x=>x.spec ===
                                                        choose_accessory.spec).remain_quantity
                                                        === 0)
                                                    || choose_accessory.request_quantity === 0"
                                            @click="push_order(choose_accessory, choose.accessory)"
                                        >
                                            新增
                                        </v-btn>
                                        <v-btn
                                            class="ml-3"
                                            small
                                            disabled
                                            depressed
                                            v-show="choose_accessory.spec && accessories.find(x=>x.spec ===
                                            choose_accessory.spec).remain_quantity === 0"
                                        >
                                            已售完
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-card outlined>
                                    <v-list
                                        dense
                                        class="px-1 mx-0 pa-sm-5"
                                    >
                                        <span class="subtitle">訂單內容：</span>
                                        <template v-for="(item, i) in order">
                                            <v-hover v-slot="{ hover }">
                                                <v-list-item
                                                    :key="`order-item-${i}`"
                                                    style="border-bottom: thin solid rgba(0,0,0,.12);"
                                                    :class="{ 'grey lighten-3': hover }"
                                                    class="px-sm-6 px-1"
                                                >
                                                    <v-list-item-action class="mr-1 mr-sm-3">
                                                        <v-icon
                                                            color="red"
                                                            small
                                                            @click="remove_order(i)"
                                                        >
                                                            mdi-close-circle-outline
                                                        </v-icon>
                                                    </v-list-item-action>
                                                    <v-list-item-content>
                                                        <v-list-item-title v-if="item.name === (choose.accessory)">
                                                            {{ i+1 }}.&nbsp;{{ item.name }}&nbsp;&nbsp;顏色：{{ item.spec }}&nbsp;&nbsp;數量：{{ item.request_quantity }}
                                                        </v-list-item-title>
                                                        <v-list-item-title v-else>
                                                            {{ i+1 }}.&nbsp;{{ item.name }}&nbsp;&nbsp;尺寸：{{ item.spec }}&nbsp;&nbsp;數量：{{ item.request_quantity }}
                                                        </v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </v-hover>
                                        </template>
                                    </v-list>
                                </v-card>
                            </v-card-text>
                        </v-card>
                    </v-card>
                    <v-row class="mx-1">
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            @click="e6 = 1"
                        >
                            上一步
                        </v-btn>
                        <v-btn
                            color="primary"
                            @click="e6 = 3"
                            :disabled="total <= 0"
                        >
                            下一步
                        </v-btn>
                    </v-row>
                </v-stepper-content>

                <v-stepper-step
                    :complete="e6 > 3"
                    step="3"
                >
                    確認訂單資訊
                </v-stepper-step>

                <v-stepper-content
                    step="3"
                    class="px-0 mx-0 px-sm-5 mx-sm-8"
                >
                    <v-card
                        class="mb-6"
                        min-height="350px"
                        outlined
                    >
                        <v-card flat>
                            <v-card-title>訂單明細</v-card-title>
                            <v-card-text class="text--primary">
                                <v-row
                                    class="body-1 pa-sm-5 pa-2"
                                    dense
                                >
                                    <v-col cols="12"><span>姓名：{{ $page.user.name }}</span></v-col>
                                    <v-col cols="12"><span>學號：{{ $page.user.username }}</span></v-col>
                                    <v-col cols="12"><span>科系：{{ '資訊工程學系(日)' }}</span></v-col>
                                    <v-col cols="12">
                                        <span>年級：{{ '四年級' }}&nbsp;&nbsp;&nbsp;&nbsp;班級：{{ 'B 班' }}</span>
                                    </v-col>
                                    <v-col cols="12"><span>訂單內容：</span></v-col>
                                    <v-col
                                        cols="12"
                                        offset="1"
                                        v-show="order.filter(x=>x.name === choose.name).length > 0"
                                    >
                                        <v-row dense>
                                            <v-col
                                                cols="12"
                                                class="body-1"
                                            >{{ choose.name }}&nbsp;&nbsp;&nbsp;&nbsp;共：{{ order.filter(x=>x.name === choose.name).reduce((acc, curr) => {return acc + curr.request_quantity}, 0) }}&nbsp;件&nbsp;&nbsp;({{ cloths[0].price }}/件)
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="2"
                                                sm="4"
                                                class="body-1"
                                                v-for="(choose_cloths, i) in order.filter(x=>x.name === choose.name)"
                                                :key="`order-choose_cloths-${i}`"
                                            >
                                                {{ choose_cloths.spec }}：{{ choose_cloths.request_quantity }} 件
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-divider></v-divider>
                                    <v-col
                                        cols="12"
                                        offset="1"
                                        v-show="order.filter(x=>x.name === choose.accessory).length > 0"
                                    >
                                        <v-row dense>
                                            <v-col
                                                cols="12"
                                                class="body-1"
                                            >{{ choose.accessory }}&nbsp;&nbsp;&nbsp;&nbsp;共：{{ order.filter(x=>x.name === (choose.accessory)).reduce((acc, curr) => {return acc + curr.request_quantity}, 0) }}&nbsp;件&nbsp;&nbsp;({{ accessories[0].price }}/件)
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="2"
                                                sm="4"
                                                class="body-1"
                                                v-for="(choose_accessory, i) in order.filter(x=>x.name ===
                                                choose.accessory)"
                                                :key="`order-choose_accessory-${i}`"
                                            >
                                                {{ choose_accessory.spec }}：{{ choose_accessory.request_quantity }} 件
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-divider></v-divider>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        class="d-flex justify-end"
                                    ><span>總金額：{{ total }} NT$</span></v-col>
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
                            </v-card-text>
                        </v-card>
                    </v-card>
                    <v-row class="mx-1">

                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            @click="e6 = 2"
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
                v-model="e6"
                vertical
                v-show="e6 === 4"
            >
                <v-stepper-step
                    step="4"
                    color="success"
                    complete
                    :rules="[()=>order_check()]"
                >
                    {{ order_check() ? '已完成訂單' : '訂單失敗' }}
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
                                <v-col cols="12">學生：{{ $page.flash.success.owner.name }}
                                </v-col>
                                <v-col cols="12">班級：{{ 'meow' }}</v-col>
                                <v-col cols="12">學號：{{ $page.flash.success.owner.username }}</v-col>
                                <v-col cols="12">訂單編號：{{ $page.flash.success.document_id }}</v-col>
                                <v-col cols="12">訂單日期：{{ $page.flash.success.created_at.slice(0, 16) }}</v-col>
                                <v-col cols="12">總金額：{{ $page.flash.success.total_price }}</v-col>
                                <v-col cols="12">
                                    <v-simple-table
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
                                    </v-simple-table>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                    <v-row class="mx-1">

                        <v-spacer></v-spacer>
                        <v-btn
                            :href="route(0)"
                            class="mb-3 mr-3"
                            v-show="!order_check()"
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
    </VuetifyLayout>
</template>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'

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
                cancelToken: null,
                e6: 1,
                loading: false,
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
                bachelor_cloths: [],
                bachelor_accessories: [],
                master_cloths: [],
                master_accessories: [],
                phd_cloths: [],
                cloths: [],
                accessories: [],
                choose_cloths: {
                    spec: '',
                    request_quantity: 0,
                    id: -1,
                    price: 0
                },
                choose_accessory: {
                    spec: '',
                    request_quantity: 0,
                    id: -1,
                    price: 0
                },
                order: [],
                form: this.$inertia.form({
                    '_method': 'POST',
                    'username': '',
                    'items': {}
                }, {
                    bag: 'submitOrder',
                })
            }
        },
        computed: {
            total() {
                let c_num = this.order.filter(x => x.name === this.choose.name).reduce((acc, curr) => {
                    return acc + curr.request_quantity
                }, 0)
                let a_num = this.order.filter(x => x.name === this.choose.accessory).reduce((acc, curr) => {
                    return acc + curr.request_quantity
                }, 0)
                console.log(c_num, a_num)
                return c_num * this.cloths[0].price + a_num * this.accessories[0].price
            }
        },
        watch: {
            "choose": function (val) {
                if (val.type === 1) {
                    this.cloths = this.bachelor_cloths
                    this.accessories = this.bachelor_accessories
                } else if (val.type === 2) {
                    this.cloths = this.master_cloths
                    this.accessories = this.master_accessories
                } else {
                    this.cloths = this.phd_cloths
                    this.accessories = this.master_accessories
                }
                this.order = []
            },
            "choose_cloths.spec": function (val) {
                this.choose_cloths.request_quantity = 0
                this.choose_cloths.id = val ? this.cloths.find(x => x.spec === val).id : -1
            },
            "choose_accessory.spec": function (val) {
                this.choose_accessory.request_quantity = 0
                this.choose_accessory.id = val ? this.accessories.find(x => x.spec === val).id : -1
            }
        },
        methods: {
            decrement(item) {
                if (item.spec && item.request_quantity > 0) item.request_quantity--
            },
            increment(item, list) {
                if (item.spec && item.request_quantity < 10 && item.request_quantity < list.find(x => x.spec === item
                        .spec)
                    .remain_quantity)
                    item.request_quantity++
            },
            push_order(item, name) {
                let i = this.order.findIndex(x => x.spec === item.spec)
                if (i >= 0) {
                    this.order[i].request_quantity = item.request_quantity
                    this.order[i].id = item.id
                } else {
                    this.order.push({
                        ...item,
                        name
                    })
                }
                item.spec = ''
                item.request_quantity = 0
                item.id = -1
            },
            remove_order(index) {
                this.order.splice(index, 1)
            },
            init_obj() {
                this.bachelor_accessories = this.$page.inventory.slice(0, 2)
                this.master_accessories = this.$page.inventory.slice(2, 8)
                this.bachelor_cloths = this.$page.inventory.slice(8, 12)
                this.master_cloths = this.$page.inventory.slice(12, 15)
                this.phd_cloths = this.$page.inventory.slice(15)
                this.cloths = this.bachelor_cloths
                this.accessories = this.bachelor_accessories
                this.choose = this.$page.user.username[0] < "5" ? this.choose_items[0] : this.choose_items[1]
            },
            order_check() {
                if (this.total <= 0) {
                    return false
                }
                return true
            },
            submit_order() {
                // this.form.post('/order', {
                //     preserveScroll: true
                // })
                if (this.order_check()) {
                    this.loading = true
                    // this.order.forEach(x => {
                    //     delete x.name, delete x.spec
                    // })
                    this.form.username = this.$page.user.username
                    this.form.items = this.order
                    this.form.post('/order', {
                        preserveState: true,
                        onFinish: () => {
                            this.e6 = 4
                            this.loading = false
                        },
                    })

                }
            }
        },
        created() {
            this.init_obj()
        },
    }

</script>
