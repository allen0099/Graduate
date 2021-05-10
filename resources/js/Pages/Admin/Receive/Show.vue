<template>
    <VuetifyLayout>
        <template #header>
            衣服領取
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
                                autofocus
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
            <v-spacer></v-spacer>
            <v-divider class="mx-5 v-divider-bold" />
            <v-card-title>清單下載列印</v-card-title>
            <v-card flat>
                <v-card-title class="mx-3">
                    <v-select
                        class="mr-2"
                        v-model="choose_file"
                        :items="file_list"
                        item-text="filename"
                        label="檔案"
                        return-object
                        :loading="file_list_loading"
                    ></v-select>
                    <v-btn
                        class="ml-3"
                        :href="choose_file.filepath"
                        download
                    >下載</v-btn>
                </v-card-title>
            </v-card>
        </v-card>

        <v-dialog
            v-model="dialog"
            max-width="850px"
            persistent
        >
            <v-card v-if="order">
                <v-card-title>
                    <span>衣服領取確認-{{ order.owner.username[0] > "5" ? '碩士服' : '學士服'}}</span>
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
                        >訂單日期：{{ $moment(order.created_at).format('YYYY-MM-DD HH:mm') }}</v-col>
                        <v-col
                            cols="12"
                            md="4"
                        >總金額：{{ order.total_price }}</v-col>
                        <v-col
                            cols="12"
                            v-if="order.payment_id"
                        >付款單據編號：{{ order.payment_id }}</v-col>
                        <v-col
                            cols="12"
                            md="4"
                        ><span>訂單當前狀態：</span>
                            <span
                                :class="order.status_code === Status.returned || order.status_code === Status.refunded ? 'green--text text--accent--3' :
                                            'red--text'">{{ statusMsg[order.status_code] === '未歸還衣服' ? '已領取衣服，未歸還' : statusMsg[order.status_code] }}</span>
                        </v-col>
                        <v-col
                            v-if="order.status_code === Status.paid"
                            cols="12"
                            md="4"
                        >
                            <span>{{ '預約領衣日期：' }}</span>
                            <span
                                :class=" !order.preserve ? 'red--text' : order.preserve === today ? 'green--text text--accent--3' : 'orange--text text--lighten--3'"
                            >
                                {{ order.preserve ? order.preserve : '未預約' }}
                            </span>
                        </v-col>
                        <v-col cols="12">訂單內容：</v-col>
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
                        dark
                        @click="cancel"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        :dark="order.status_code == Status.paid"
                        @click="open_alert"
                        :disabled="order.status_code != Status.paid"
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
            <v-dialog
                v-model="alert_dialog"
                persistent
                max-width="650"
            >
                <v-card>
                    <v-card-title>
                        <v-icon
                            color="red"
                            large
                        >mdi-alert-octagon-outline</v-icon><span class="ml-3">領取資料確認</span>
                    </v-card-title>
                    <v-card-text class="font-weight-bold">
                        <v-row
                            dense
                            v-if="order"
                        >
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
                            <v-col cols="12"></v-col>
                            <v-col cols="12">
                                確定進行領取?
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            dark
                            @click="cancel_alert"
                        >
                            取消
                        </v-btn>
                        <v-btn
                            color="primary"
                            dark
                            @click="save"
                        >
                            確定
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-dialog>
    </VuetifyLayout>
</template>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import {
        apiSearchOrder,
        apiOrderUpdate,
        apiGetAllPreservePdf
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
        name: "AdminReturn",
        data: () => ({
            order_id: '',
            order: null,
            msg: '',
            show_msg: false,
            dialog: false,
            alert_dialog: false,
            error: false,
            pageLoading: false,
            search_loading: false,
            file_list_loading: false,
            choose_file: {
                filepath: '',
                filename: ''
            },
            Status: Status,
            statusMsg: StatusMsg,
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
                    value: 'student.school_class.class_name',
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
            file_list: [],
            bachelor_cloths: [],
            bachelor_accessories: [],
            master_cloths: [],
            master_accessories: [],
            today: '',
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
            async init_obj() {
                this.bachelor_accessories = this.$page.props.inventory.slice(0, 2)
                this.master_accessories = this.$page.props.inventory.slice(2, 8)
                this.bachelor_cloths = this.$page.props.inventory.slice(8, 12)
                this.master_cloths = this.$page.props.inventory.slice(12, 15)

                this.today = this.$moment().format("YYYY-MM-DD")
                this.file_list_loading = true

                await apiGetAllPreservePdf().then(res => {
                    if (res.status == 200) {
                        this.file_list = res.data
                    }
                })

                this.file_list_loading = false
            },
            async receive_submit() {
                this.search_loading = true
                await apiSearchOrder(this.order_id).then((res) => {
                    if (res.status === 200 && res.data.length > 0) {
                        this.order = res.data[0]
                        this.order_id = ''
                        this.dialog = true
                    } else {
                        this.order_id = ''
                        this.msg = '查無此訂單編號'
                        this.error = true
                        this.show_msg = true
                    }
                    this.search_loading = false
                }).catch((err) => {
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
            open_alert() {
                this.alert_dialog = true
            },
            cancel_alert() {
                this.alert_dialog = false
            },
            async save() {
                this.alert_dialog = true
                this.pageLoading = true
                await this.$inertia.patch(`/order/${this.order.id}`, {
                    document_id: this.order.document_id,
                    owner_username: this.order.owner.username,
                    status_code: this.Status.received
                }, {
                    onSuccess: (page) => {
                        this.msg = '已領取'
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
                this.alert_dialog = false
            },
        },
        created() {
            this.init_obj()
        },
    }

</script>
