<template>
    <VuetifyLayout>
        <template #header>
            付款處理
        </template>
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                <v-toolbar flat>
                    <v-row
                        class="mt-3"
                        justify="center"
                        no-gutters
                    >
                        <v-col
                            cols="8"
                            sm="7"
                            md="6"
                        >
                            <v-text-field
                                v-model="order_id"
                                label="訂單編號或購買人學號"
                                outlined
                                clearable
                                dense
                                class="mr-2"
                                type='tel'
                                :messages="show_msg ? msg : ''"
                                :success="!error && show_msg"
                                :error="error && show_msg"
                                @keyup.enter="receive_submit"
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="3"
                            md="2"
                        >
                            <v-btn
                                color="primary"
                                @click="receive_submit"
                                :loading="search_loading"
                            >查詢</v-btn>
                        </v-col>
                    </v-row>
                </v-toolbar>
            </v-card-title>
        </v-card>

        <v-dialog
            v-model="dialog"
            max-width="850px"
            persistent
        >
            <v-card v-if="order">
                <v-card-title>
                    <span>衣服付款確認-{{ order.owner.username[0] > "5" ? '碩士服' : '學士服'}}</span>
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
                        >訂單日期：{{ order.created_at.slice(0, 16) }}</v-col>
                        <v-col
                            cols="12"
                            md="4"
                        >總金額：{{ order.total_price }}</v-col>
                        <v-col cols="12"><span>訂單當前狀態：</span>
                            <span :class="order.status_code === 4 ? 'green--text text--accent--3' :
                                            'red--text'">{{ statusMsg[order.status_code] }}</span>
                        </v-col>
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
                            class="mt-5"
                        >訂單內容：</v-col>
                        <v-col cols="12">
                            <v-data-table
                                :headers="headers"
                                :items="order.sets"
                                class="elevation-1 mt-2"
                                mobile-breakpoint="770"
                                hide-default-footer
                            >
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="cancel"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        text
                        @click="save"
                        :disabled="order.status_code != 1 || !order.payment_id"
                    >
                        領取
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
    </VuetifyLayout>
</template>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import {
        apiSearchOrder,
        apiOrderUpdate
    } from '@/api/api'

    export default {
        components: {
            VuetifyLayout,
        },
        name: "AdminReturn",
        data: () => ({
            order_id: '',
            order: null,
            msg: '',
            show_msg: false,
            dialog: false,
            error: false,
            pageLoading: false,
            search_loading: false,
            choose_file: null,
            statusMsg: ["已結單", "未付款", "已付款，未領取衣服", "未歸還衣服", "已歸還衣服", "已取消訂單", "退款中", "已退款"],
            headers: [{
                    text: '學號',
                    align: 'start',
                    value: 'student.username',
                    width: 100,
                    sortable: false,
                },
                {
                    text: '姓名',
                    value: 'student.name',
                    width: 100,
                    sortable: false,
                },
                {
                    text: '班級',
                    value: 'student.class_id',
                    sortable: false,
                    width: 100,
                },
                {
                    text: '顏色',
                    value: 'accessory.spec',
                    align: 'center',
                    width: 20,
                },
                {
                    text: '尺寸',
                    value: 'cloth.spec',
                    align: 'center',
                    width: 20,
                }
            ],
            file_list: [{
                    filename: '今日預約領取簽到表-學士',
                    path: '123'
                },
                {
                    filename: '今日預約領取簽到表-碩士',
                    path: '123'
                },
                {
                    filename: '空白簽到表-學士',
                    path: '123'
                },
                {
                    filename: '空白簽到表-碩士',
                    path: '123'
                },
            ],
            bachelor_cloths: [],
            bachelor_accessories: [],
            master_cloths: [],
            master_accessories: [],
            card_color: {
                '白': {
                    bg: '#FFFFFF',
                    q: '#000000',
                    r: '#000000',
                },
                '黃': {
                    q: '#FFFDE7',
                    bg: '#F57F17',
                    r: '#FFFFFF'
                },
                '橘': {
                    q: '#FFF3E0',
                    bg: '#E65100',
                    r: '#FFFFFF'
                },
                '灰': {
                    q: '#F5F5F5',
                    bg: '#424242',
                    r: '#FFFFFF'
                },
                '藍': {
                    q: '#BBDEFB',
                    bg: '#0D47A1',
                    r: '#FFFFFF'
                },
                '紫': {
                    q: '#D1C4E9',
                    bg: '#311B92',
                    r: '#FFFFFF'
                }
            },
        }),
        methods: {
            init_obj() {
                this.bachelor_accessories = this.$page.inventory.slice(0, 2)
                this.master_accessories = this.$page.inventory.slice(2, 8)
                this.bachelor_cloths = this.$page.inventory.slice(8, 12)
                this.master_cloths = this.$page.inventory.slice(12, 15)
            },
            async receive_submit() {
                this.search_loading = true
                await apiSearchOrder(this.order_id).then((res) => {
                    if (res.status === 200 && res.data.length > 0) {
                        if (res.data[0].payment_id) {
                            this.msg = '此訂單已有付款編號'
                            this.error = true
                            this.show_msg = true
                        } else {
                            this.order = res.data[0]
                            this.order_id = ''
                            this.dialog = true
                        }
                        this.order_id = ''
                    } else {
                        this.order_id = ''
                        this.msg = '查無此訂單編號'
                        this.error = true
                        this.show_msg = true
                    }
                    this.search_loading = false
                }).catch((err) => {
                    console.log(err)
                    this.order_id = ''
                    this.msg = '查無此訂單編號'
                    this.error = true
                    this.show_msg = true
                    this.search_loading = false
                })

                setTimeout(() => {
                    this.show_msg = false
                }, 2000)
            },
            async save() {
                this.pageLoading = true
                await this.$inertia.patch(`/order/${this.order.id}`, {
                    document_id: this.order.document_id,
                    owner_username: this.order.owner.username,
                    status_code: 2
                }, {
                    onSuccess: (page) => {
                        console.log(page)
                        this.msg = '已儲存'
                        this.error = false
                        this.show_msg = true
                    },
                    onError: (errors) => {
                        this.msg = '發生錯誤'
                        this.error = true
                        this.show_msg = true
                    },
                    onFinish: () => {
                        this.pageLoading = false
                        this.show_msg = true
                    },
                })
                await this.cancel()
            },
            cancel() {
                this.order_id = ''
                this.order = null
                this.dialog = false
            },
            download() {
                alert(this.choose_file.filename)
                this.choose_file = null
            }
        },
        created() {
            this.init_obj()
        },
    }

</script>
