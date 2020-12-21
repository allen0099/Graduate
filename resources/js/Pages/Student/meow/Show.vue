<template>
    <VuetifyLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                訂購流程
            </h2>
        </template>
        <v-container>
            <v-stepper
                v-model="e6"
                vertical
            >
                <v-stepper-step
                    :complete="e6 > 1"
                    step="1"
                >
                    檢視當前剩餘數量
                </v-stepper-step>

                <v-stepper-content step="1">
                    <v-card
                        min-height="350px"
                        flat
                    >
                        <v-card outlined>
                            <v-card-title>
                                <span>{{ !switch1 ? '學士服' : '碩士服' }}</span>
                                <v-spacer></v-spacer>
                                <v-switch
                                    v-model="switch1"
                                    label="切換成碩士服"
                                ></v-switch>
                            </v-card-title>
                            <v-card-text
                                class="text--primary"
                                v-if="!switch1"
                            >
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
                                        v-for="size in sizeList"
                                        :key="`size-${size.label}`"
                                    >
                                        {{ size.label }}：{{ size.num }} 件
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        class="body-1"
                                    >帽穗、披肩 剩餘件數</v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                        sm="4"
                                        class="body-1"
                                        v-for="accessory in accessoriesList"
                                        :key="`accessory-${accessory.label}`"
                                    >
                                        {{ accessory.label }}：{{ accessory.num }} 件
                                    </v-col>
                                </v-row>
                            </v-card-text>
                            <v-card-text
                                class="text--primary"
                                v-else
                            >
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
                                        v-for="size in sizeList1"
                                        :key="`size1-${size.label}`"
                                    >
                                        {{ size.label }}：{{ size.num }} 件
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        class="body-1"
                                    >帽穗、披肩 剩餘件數</v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                        sm="4"
                                        class="body-1"
                                        v-for="accessory in accessoriesList1"
                                        :key="`accessory1-${accessory.label}`"
                                    >
                                        {{ accessory.label }}：{{ accessory.num }} 件
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

                <v-stepper-content step="2">
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
                                        <span>學士服</span>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                        sm="6"
                                    >
                                        <v-select
                                            :items="sizeList.map(x=>x.label)"
                                            label="規格"
                                            v-model="bachelor_gown.label"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                        sm="6"
                                        class="d-flex justify-end justify-sm-start"
                                    >
                                        <v-icon @click="decrement(bachelor_gown)">
                                            mdi-minus
                                        </v-icon>
                                        <span class="subtitle mx-2">{{ bachelor_gown.num }}</span>
                                        <v-icon @click="increment(bachelor_gown, sizeList)">
                                            mdi-plus
                                        </v-icon>
                                        <v-btn
                                            class="ml-3"
                                            small
                                            v-show="bachelor_gown.label && sizeList.find(x=>x.label ===
                                            bachelor_gown.label).num > 0 && bachelor_gown.num > 0"
                                            @click="push_order(bachelor_gown, '學士服')"
                                        >
                                            新增
                                        </v-btn>
                                        <v-btn
                                            class="ml-3"
                                            small
                                            disabled
                                            depressed
                                            v-show="bachelor_gown.label && sizeList.find(x=>x.label ===
                                            bachelor_gown.label).num === 0"
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
                                        <span>帽穗、披肩</span>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                        sm="6"
                                    >
                                        <v-select
                                            :items="accessoriesList.map(x=>x.label)"
                                            label="規格"
                                            v-model="bachelor_accessory.label"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                        sm="6"
                                        class="d-flex justify-end justify-sm-start"
                                    >
                                        <v-icon @click="decrement(bachelor_accessory)">
                                            mdi-minus
                                        </v-icon>
                                        <span class="subtitle mx-2">{{ bachelor_accessory.num }}</span>
                                        <v-icon @click="increment(bachelor_accessory, accessoriesList)">
                                            mdi-plus
                                        </v-icon>
                                        <v-btn
                                            class="ml-3"
                                            small
                                            v-show="bachelor_accessory.label && accessoriesList.find(x=>x.label ===
                                            bachelor_accessory.label).num > 0 && bachelor_accessory.num > 0"
                                            @click="push_order(bachelor_accessory, '帽穗、披肩')"
                                        >
                                            新增
                                        </v-btn>
                                        <v-btn
                                            class="ml-3"
                                            small
                                            disabled
                                            depressed
                                            v-show="bachelor_accessory.label && accessoriesList.find(x=>x.label ===
                                            bachelor_accessory.label).num === 0"
                                        >
                                            已售完
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-card outlined>
                                    <v-list
                                        dense
                                        class="pa-5"
                                    >
                                        <span class="subtitle">訂單內容：</span>
                                        <template v-for="(item, i) in order">
                                            <v-hover v-slot="{ hover }">
                                                <v-list-item
                                                    :key="`order-item-${i}`"
                                                    style="border-bottom: thin solid rgba(0,0,0,.12);"
                                                    :class="{ 'grey lighten-3': hover }"
                                                >
                                                    <v-list-item-action>
                                                        <v-icon
                                                            color="red"
                                                            small
                                                            @click="remove_order(i)"
                                                        >
                                                            mdi-close-circle-outline
                                                        </v-icon>
                                                    </v-list-item-action>
                                                    <v-list-item-content>
                                                        <v-list-item-title v-if="item.name === '帽穗、披肩'">
                                                            {{ i+1 }}.&nbsp;{{ item.name }}&nbsp;&nbsp;顏色：{{ item.label }}&nbsp;&nbsp;數量：{{ item.num }}
                                                        </v-list-item-title>
                                                        <v-list-item-title v-else>
                                                            {{ i+1 }}.&nbsp;{{ item.name }}&nbsp;&nbsp;尺寸：{{ item.label }}&nbsp;&nbsp;數量：{{ item.num }}
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

                <v-stepper-content step="3">
                    <v-card
                        class="mb-6"
                        min-height="350px"
                        outlined
                    >
                        <v-card flat>
                            <v-card-title>訂單明細</v-card-title>
                            <v-card-text class="text--primary">
                                <v-row
                                    class="body-1 pa-5"
                                    dense
                                >
                                    <v-col cols="12"><span>姓名：{{ $page.user.name }}</span></v-col>
                                    <v-col cols="12"><span>學號：{{ '406410232' }}</span></v-col>
                                    <v-col cols="12"><span>科系：{{ '資訊工程學系(日)' }}</span></v-col>
                                    <v-col cols="12"><span>年級：{{ '四年級' }}&nbsp;&nbsp;&nbsp;&nbsp;班級：{{ 'B 班' }}</span>
                                    </v-col>
                                    <v-col cols="12"><span>訂單內容：</span></v-col>
                                    <v-col
                                        cols="12"
                                        offset="1"
                                        v-show="order.filter(x=>x.name === '學士服').length > 0"
                                    >
                                        <v-row dense>
                                            <v-col
                                                cols="12"
                                                class="body-1"
                                            >學士服&nbsp;&nbsp;&nbsp;&nbsp;共：{{ order.filter(x=>x.name === '學士服').reduce((acc, curr) => {return acc + curr.num}, 0) }}&nbsp;件
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="2"
                                                sm="4"
                                                class="body-1"
                                                v-for="(bachelor_gown, i) in order.filter(x=>x.name === '學士服')"
                                                :key="`order-bachelor-gown-${i}`"
                                            >
                                                {{ bachelor_gown.label }}：{{ bachelor_gown.num }} 件
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-divider></v-divider>
                                    <v-col
                                        cols="12"
                                        offset="1"
                                        v-show="order.filter(x=>x.name === '帽穗、披肩').length > 0"
                                    >
                                        <v-row dense>
                                            <v-col
                                                cols="12"
                                                class="body-1"
                                            >帽穗、披肩&nbsp;&nbsp;&nbsp;&nbsp;共：{{ order.filter(x=>x.name === '帽穗、披肩').reduce((acc, curr) => {return acc + curr.num}, 0) }}&nbsp;件
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="2"
                                                sm="4"
                                                class="body-1"
                                                v-for="(bachelor_accessory, i) in order.filter(x=>x.name === '帽穗、披肩')"
                                                :key="`order-bachelor-accessory-${i}`"
                                            >
                                                {{ bachelor_accessory.label }}：{{ bachelor_accessory.num }} 件
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-divider></v-divider>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        class="d-flex justify-end"
                                    ><span>總金額：17777 NT$</span></v-col>
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
                            @click="e6 = 4"
                        >
                            完成訂單
                        </v-btn>
                    </v-row>
                </v-stepper-content>

                <v-stepper-step step="4">
                    完成訂單
                </v-stepper-step>
                <v-stepper-content step="4">
                    <v-card
                        class="mb-6"
                        min-height="350px"
                        outlined
                    >
                        {{ order }}
                    </v-card>
                    <v-row class="mx-1">

                        <v-spacer></v-spacer>
                        <v-btn @click="e6 = 4">
                            前往我的訂單
                        </v-btn>
                    </v-row>
                </v-stepper-content>
            </v-stepper>
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
            e6: 3,
            switch1: false,
            sizeList: [{
                    label: 'M',
                    num: 100
                },
                {
                    label: 'L',
                    num: 100
                }, {
                    label: 'XL',
                    num: 100
                }
            ],
            accessoriesList: [{
                label: '白',
                num: 100
            }, {
                label: '黃',
                num: 100
            }, {
                label: '橘',
                num: 100
            }, {
                label: '灰',
                num: 100
            }, {
                label: '藍',
                num: 100
            }, {
                label: '紫',
                num: 100
            }, ],
            sizeList1: [{
                    label: 'M',
                    num: 101
                },
                {
                    label: 'L',
                    num: 101
                }, {
                    label: 'XL',
                    num: 101
                }
            ],
            accessoriesList1: [{
                label: '白',
                num: 101
            }, {
                label: '黃',
                num: 101
            }, {
                label: '橘',
                num: 101
            }, {
                label: '灰',
                num: 101
            }, {
                label: '藍',
                num: 101
            }, {
                label: '紫',
                num: 101
            }, ],
            bachelor_gown: {
                label: '',
                num: 0
            },
            bachelor_accessory: {
                label: '',
                num: 0
            },
            master_gown: {
                label: '',
                num: 0
            },
            master_accessory: {
                label: '',
                num: 0
            },
            order: [{
                "label": "L",
                "num": 10,
                "name": "學士服"
            }, {
                "label": "M",
                "num": 10,
                "name": "學士服"
            }, {
                "label": "XL",
                "num": 10,
                "name": "學士服"
            }, {
                "label": "白",
                "num": 10,
                "name": "帽穗、披肩"
            }, {
                "label": "黃",
                "num": 10,
                "name": "帽穗、披肩"
            }, {
                "label": "橘",
                "num": 10,
                "name": "帽穗、披肩"
            }, {
                "label": "灰",
                "num": 10,
                "name": "帽穗、披肩"
            }, {
                "label": "藍",
                "num": 10,
                "name": "帽穗、披肩"
            }, {
                "label": "紫",
                "num": 10,
                "name": "帽穗、披肩"
            }],
        }),
        methods: {
            decrement(item) {
                if (item.label && item.num > 0) item.num--
            },
            increment(item, list) {
                if (item.label && item.num < 10 && item.num < list.find(x => x.label === item.label).num)
                    item.num++
            },
            push_order(item, name) {
                let i = this.order.findIndex(x => x.label === item.label)
                if (i >= 0) {
                    this.order[i].num = item.num
                } else {
                    this.order.push({
                        ...item,
                        name
                    })
                }
                item.label = ''
                item.num = 0
            },
            remove_order(index) {
                this.order.splice(index, 1)
            }
        }
    }

</script>
