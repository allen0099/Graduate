<template>
    <VuetifyLayout>
        <template #header>
            首頁
        </template>
        <v-card
            class="mt-3 mb-10"
            flat
            v-show="cancel_order_list.length > 0"
        >
            <v-card-title>
                <v-badge
                    color="error"
                    :content="cancel_order_list.length"
                    offset-x="0"
                    offset-y="13"
                >
                    取消訂單申請
                </v-badge>
            </v-card-title>
            <v-card
                class="pa-3"
                outlined
            >
                <v-virtual-scroll
                    v-resize="onResize"
                    height="300"
                    min-height="300"
                    :item-height="item_height"
                    :items="cancel_order_list"
                    bench="5"
                >
                    <template v-slot:default="{ item }">
                        <v-list-item style="background-color: #FFCDD2">
                            <v-list-item-content>
                                <v-row dense>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >班級：{{ item.department }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >學生：{{ item.name }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >學號：{{ item.stu_id }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >訂單編號：{{ item.orderNumber }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >訂單日期：{{ item.orderDate }}</v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >取消日期：{{ item.cancelDate }}</v-col>
                                    <v-col cols="12">取消原因：{{ item.reason }}</v-col>
                                </v-row>
                                <v-col
                                    cols="12"
                                    class="d-flex justify-end pa-0 pt-1"
                                >
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
                                </v-col>
                            </v-list-item-content>

                            <!-- <v-list-item-action>
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
                                    class="mt-2"
                                >
                                    取消
                                    <v-icon
                                        right
                                        dark
                                    >
                                        mdi-close
                                    </v-icon>
                                </v-btn>
                                <v-spacer></v-spacer>
                            </v-list-item-action> -->
                        </v-list-item>
                    </template>
                </v-virtual-scroll>
            </v-card>
        </v-card>

        <v-divider></v-divider>

        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>學士服品項數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="item in [1, 2, 3, 4, 5, 6]"
                    :key="item"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card color="#FFF5EB">
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            style="color: #968C83"
                        >{{'S 號'}}</v-card-title>
                        <v-row
                            class="pb-1 ml-7"
                            no-gutters
                            justify="space-between"
                            align="center"
                        >
                            <v-col
                                class="text-h6 font-weight-bold"
                                cols="12"
                            >
                                <span style="color:#8FB69B">{{ '123' }}</span> /
                                <span>{{ '123' }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>

        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>學士服領巾數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="(ba_item, index) in bachelor_accessories"
                    :key="`bachelor_accessories-${index}`"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card :color="card_color[ba_item.color] ? card_color[ba_item.color].bg : '#ffffff'">
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            :style="{color: card_color[ba_item.color] ? card_color[ba_item.color].q : '#000000'}"
                        >{{ba_item.color }}</v-card-title>
                        <v-row
                            class="pb-1 ml-7"
                            no-gutters
                            justify="space-between"
                            align="center"
                        >
                            <v-col
                                class="text-h6 font-weight-bold"
                                cols="12"
                            >
                                <span :style="{color: card_color[ba_item.color] ? card_color[ba_item.color].q :
                                    '#000000'}">{{ ba_item.quantity }}</span>
                                <span :style="{color: card_color[ba_item.color] ? card_color[ba_item.color].r :
                                    '#000000'}"> / {{ ba_item.remaining }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
        <v-divider class="mt-6 mb-3"></v-divider>
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>學士服品項數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="item in [1, 2, 3, 4, 5, 6]"
                    :key="item"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card color="#FFF5EB">
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            style="color: #968C83"
                        >{{'S 號'}}</v-card-title>
                        <v-row
                            class="pb-1 ml-7"
                            no-gutters
                            justify="space-between"
                            align="center"
                        >
                            <v-col
                                class="text-h6 font-weight-bold"
                                cols="12"
                            >
                                <span style="color:#8FB69B">{{ '123' }}</span> /
                                <span>{{ '123' }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>

        <v-card
            class="my-3"
            flat
        >
            <v-card-title>學士服領巾數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="(ma_item, index) in master_accessories"
                    :key="`master_accessories-${index}`"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card :color="card_color[ma_item.color] ? card_color[ma_item.color].bg : '#ffffff'">
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            :style="{color: card_color[ma_item.color] ? card_color[ma_item.color].q : '#000000'}"
                        >{{ma_item.color }}</v-card-title>
                        <v-row
                            class="pb-1 ml-7"
                            no-gutters
                            justify="space-between"
                            align="center"
                        >
                            <v-col
                                class="text-h6 font-weight-bold"
                                cols="12"
                            >
                                <span :style="{color: card_color[ma_item.color] ? card_color[ma_item.color].q :
                                    '#000000'}">{{ ma_item.quantity }}</span>
                                <span :style="{color: card_color[ma_item.color] ? card_color[ma_item.color].r :
                                    '#000000'}"> / {{ ma_item.remaining }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>

    </VuetifyLayout>
</template>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import UploadStudentData from '@/Pages/Admin/Setting/UploadStudentData'
    import UploadStampImg from '@/Pages/Admin/Setting/UploadStampImg'
    import TimeSetting from '@/Pages/Admin/Setting/TimeSetting'

    export default {
        components: {
            VuetifyLayout,
            JetSectionBorder,
            UploadStudentData,
            UploadStampImg,
            TimeSetting
        },
        name: "AdminHome",
        data: () => ({
            bachelor_cloths: [],
            bachelor_accessories: [{
                color: '白色',
                quantity: 3000,
                remaining: 2000
            }, {
                color: '藍色',
                quantity: 3001,
                remaining: 2001
            }, ],
            master_cloths: [],
            master_accessories: [{
                color: '白色',
                quantity: 3000,
                remaining: 2000
            }, {
                color: '黃色',
                quantity: 3001,
                remaining: 2001
            }, {
                color: '橘色',
                quantity: 3002,
                remaining: 2002
            }, {
                color: '灰色',
                quantity: 3000,
                remaining: 2003
            }, {
                color: '藍色',
                quantity: 3004,
                remaining: 2004
            }, {
                color: '紫色',
                quantity: 3005,
                remaining: 2005
            }],
            card_color: {
                '白色': {
                    bg: '#FFFFFF',
                    q: '#000000',
                    r: '#000000',
                },
                '黃色': {
                    q: '#FFFDE7',
                    bg: '#F57F17',
                    r: '#FFFFFF'
                },
                '橘色': {
                    q: '#FFF3E0',
                    bg: '#E65100',
                    r: '#FFFFFF'
                },
                '灰色': {
                    q: '#F5F5F5',
                    bg: '#424242',
                    r: '#FFFFFF'
                },
                '藍色': {
                    q: '#BBDEFB',
                    bg: '#0D47A1',
                    r: '#FFFFFF'
                },
                '紫色': {
                    q: '#D1C4E9',
                    bg: '#311B92',
                    r: '#FFFFFF'
                }
            },
            cancel_order_list: [{
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "品項或數量錯誤"
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "品項或數量錯誤"
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "品項或數量錯誤"
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "品項或數量錯誤"
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "品項或數量錯誤"
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "品項或數量錯誤"
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "品項或數量錯誤"
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "品項或數量錯誤"
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "品項或數量錯誤"
            }, {
                name: '學生一',
                stu_id: '406410232',
                department: '電機喵喵喵喵組',
                orderNumber: "20201116990146",
                orderDate: "2020-11-28 14:29",
                cancelDate: "2020-11-28 18:29",
                order_content: "訂單內容",
                reason: "meow meow meow meow meow"
            }, ],
            item_height: 100,
            windowSize: {
                x: 0,
                y: 0,
            },
        }),
        mounted() {
            this.onResize()
        },

        methods: {
            onResize() {
                this.windowSize = {
                    x: window.innerWidth,
                    y: window.innerHeight
                }
                if (this.windowSize.x < 960) {
                    this.item_height = 280
                } else {
                    this.item_height = 160
                }
            },
        },
    }

</script>
