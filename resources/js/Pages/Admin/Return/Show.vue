<template>
    <VuetifyLayout>
        <template #header>
            衣服歸還
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
                                v-model="stuid"
                                label="學號"
                                outlined
                                clearable
                                dense
                                class="mr-2"
                                type='tel'
                                :messages="show_msg ? msg : ''"
                                :success="!error && show_msg"
                                :error="error && show_msg"
                                @keyup.enter="return_submit"
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="3"
                            md="2"
                        >
                            <v-btn
                                color="primary"
                                @click="return_submit"
                                :loading="search_loading"
                            >歸還</v-btn>
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
            <v-card v-if="student">
                <v-card-title>
                    <span>衣服歸還確認-{{ student.username[0] > "5" ? '碩士服' : '學士服'}}</span>
                </v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row dense>
                        <v-col
                            cols="12"
                            md="4"
                        >系級：{{ student.school_class.class_name }}</v-col>
                        <v-col
                            cols="12"
                            md="4"
                        >學生：{{ student.name }}</v-col>
                        <v-col
                            cols="12"
                            md="4"
                        >學號：{{ student.username }}</v-col>
                        <v-col
                            cols="12"
                            md="4"
                        >尺寸：{{ student.set.cloth.spec }} 號</v-col>
                        <v-col
                            cols="12"
                            md="4"
                        >顏色：{{ student.set.accessory.spec }} 色</v-col>
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
                    >
                        歸還
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
        apiSearchStudent,
        apiReturnCloth
    } from '@/api/api'

    export default {
        components: {
            VuetifyLayout,
        },
        name: "AdminReturn",
        data: () => ({
            stuid: '',
            msg: '',
            show_msg: false,
            error: false,
            dialog: false,
            pageLoading: false,
            search_loading: false,
            student: null,
            choose_file: null,
        }),
        methods: {
            async return_submit() {
                if (/^([0-9]){9}$/.test(this.stuid) === false) {
                    this.stuid = ''
                    this.msg = '查無此學號'
                    this.error = true
                    this.show_msg = true
                } else {
                    this.search_loading = true
                    await apiSearchStudent(this.stuid).then((res) => {
                        if (res.status == 200) {
                            if (res.data.set) {
                                if (!res.data.set.returned) {
                                    this.dialog = true
                                    this.student = res.data
                                } else {
                                    this.stuid = ''
                                    this.msg = '不可重複歸還'
                                    this.error = true
                                    this.show_msg = true
                                }
                            } else {
                                this.stuid = ''
                                this.msg = '該學生沒有訂購衣服的紀錄'
                                this.error = true
                                this.show_msg = true
                            }
                        } else {
                            this.stuid = ''
                            this.msg = '查無此學號'
                            this.error = true
                            this.show_msg = true
                        }
                        this.search_loading = false
                    }).catch((err) => {
                        console.log(err)
                        this.stuid = ''
                        this.msg = '查無此學號'
                        this.error = true
                        this.show_msg = true
                        this.search_loading = false
                    })
                }
                setTimeout(() => {
                    this.show_msg = false
                }, 2000)
            },
            async save() {
                this.pageLoading = true
                await apiReturnCloth(this.student.username).then(res => {
                    if (res.status == 200) {
                        this.msg = '已歸還'
                        this.error = false
                        this.show_msg = true
                    } else {
                        this.msg = '發生不明錯誤，請確認訂單狀態'
                        this.error = true
                        this.show_msg = true
                    }
                }).catch((err) => {
                    console.log(err)
                    this.msg = '發生不明錯誤，請確認訂單狀態'
                    this.error = true
                    this.show_msg = true
                })
                await this.cancel()
            },
            cancel() {
                this.stuid = ''
                this.order = null
                this.dialog = false
            },
        },
    }

</script>
