<template>
    <VuetifyLayout>
        <template #header>
            還款處理
        </template>
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                還款
                <v-spacer></v-spacer>
                <v-btn @click="dialog_refund = true">生成還款名單</v-btn>
            </v-card-title>
            <v-card-text class="font-weight-bold">
                <v-row
                    dense
                    v-for="(item, index) in NotReturnedTotal"
                    :key="`NotReturnedTotal-${index}`"
                    class="ml-3"
                    v-if="dateList.indexOf(new Date(item.date).Format('yyyy-MM-dd')) > -1"
                >
                    <v-col
                        cols="5"
                        md="2"
                        sm="3"
                        xs="4"
                    >
                        日期：{{ new Date(item.date).Format("yyyy-MM-dd") }}
                    </v-col>
                    <v-col> 尚未處理還款數量：{{ item.count }}</v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-divider class="mx-5 v-divider-bold" />
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                還款中
            </v-card-title>
        </v-card>
        <v-divider class="mx-5 v-divider-bold" />
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                已還款
            </v-card-title>
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
            v-model="dialog_refund"
            persistent
            max-width="600px"
        >
            <v-card>
                <v-card-title>生成還款名單</v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row dense>
                        <v-col cols="12">將該時間範圍的所有尚未處理還款的學生集合生成還款名單</v-col>
                        <v-col>
                            <v-select
                                v-model="start_date"
                                :items="dateList"
                                label="起始日期"
                            ></v-select>
                        </v-col>
                        <v-col>
                            <v-select
                                v-model="end_date"
                                :items="dateList"
                                label="結束日期"
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-spacer></v-spacer>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        text
                        @click="refund_cancel"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        text
                        @click="refund_save"
                    >
                        建立
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
    import {
        apiNotReturnedTotal
    } from '@/api/api'

    import {
        Status,
        StatusMsg,
    } from '@/api/config'

    export default {
        components: {
            VuetifyLayout,
        },
        name: "AdminRefund",
        data: () => ({
            dialog_refund: false,
            pageLoading: false,
            snackbar: false,
            snackbar_true: false,
            msg: '',
            NotReturnedTotal: [],
            dateList: [],
            start_date: null,
            end_date: null,
        }),
        methods: {
            async init() {
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

                let time_range = this.$page.configs.time_range[4]

                let today = new Date(new Date().Format("yyyy-MM-dd") + " 00:00:00")

                let start_time = new Date(time_range.start_time + " 00:00:00")
                let end_time = new Date(time_range.end_time + " 00:00:00")

                this.dateList = []

                for (let i = start_time; i <= end_time; i = new Date(i.getTime() + 24 * 60 * 60 * 1000)) {
                    if (i <= today) {
                        this.dateList.push(i.Format("yyyy-MM-dd"))
                    }
                }

                await apiNotReturnedTotal().then(res => {
                    if (res.status === 200) {
                        this.NotReturnedTotal = res.data
                    }
                })
            },
            refund_cancel() {
                this.dialog_refund = false
                this.start_date = null
                this.end_date = null

            },
            refund_save() {
                this.dateList
                this.refund_cancel()
            }
        },
        created() {
            this.init()
        },
    }

</script>
