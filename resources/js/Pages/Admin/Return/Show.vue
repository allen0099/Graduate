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
                            >歸還</v-btn>
                        </v-col>
                    </v-row>
                </v-toolbar>
            </v-card-title>
            <v-spacer></v-spacer>
            <!-- <v-alert
                color="green"
                text
                :type="error ? 'error' : 'success'"
                v-if="student"
            >{{ student.username }} {{ student.school_class.class_name }} {{ student.name }}</v-alert> -->
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
                    ></v-select>
                    <v-btn
                        class="ml-3"
                        @click="download"
                    >下載</v-btn>
                </v-card-title>
            </v-card>
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
            student: null,
            choose_file: null,
            file_list: [{
                    filename: '預約歸還簽到表',
                    path: '123'
                },
                {
                    filename: '空白簽到表',
                    path: '123'
                }, {
                    filename: '未歸還清單',
                    path: '123'
                }, {
                    filename: '已歸還清單',
                    path: '123'
                }, {
                    filename: '當日歸還清單',
                    path: '123'
                }
            ],
        }),
        methods: {
            async return_submit() {
                if (/^([0-9]){9}$/.test(this.stuid) === false) {
                    this.stuid = ''
                    this.msg = '查無此學號'
                    this.error = true
                    this.show_msg = true
                } else {
                    await apiSearchStudent(this.stuid).then((res) => {
                        if (res.status == 200) {
                            this.dialog = true
                            if (res.data.set) {
                                if (!res.data.set.returned) {
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
                    }).catch((err) => {
                        console.log(err)
                        this.stuid = ''
                        this.msg = '查無此學號'
                        this.error = true
                        this.show_msg = true
                    })
                }
                setTimeout(() => {
                    this.show_msg = false
                }, 2000)
            },
            download() {
                alert(this.choose_file.filename)
                this.choose_file = null
            },
            async save() {
                this.pageLoading = true
                await apiReturnCloth(this.student.username).then(res => {
                    if (res.status == 200) {
                        this.msg = '已歸還'
                        this.error = false
                        this.show_msg = true
                    } else {
                        this.msg = '發生不明錯誤'
                        this.error = true
                        this.show_msg = true
                    }
                }).catch((err) => {
                    console.log(err)
                    this.msg = '發生不明錯誤'
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
