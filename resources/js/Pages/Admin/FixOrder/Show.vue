<template>
    <VuetifyLayout>
        <template #header>
            訂單修改
        </template>
        <!-- part1 strat  -->
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>
                尺寸與配件顏色修改
            </v-card-title>
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
                            v-model="part1.student_id"
                            label="學號"
                            outlined
                            clearable
                            dense
                            class="mr-2"
                            type='text'
                            @keyup.enter="part1_search"
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="3"
                        md="2"
                    >
                        <v-btn
                            color="primary"
                            @click="part1_search"
                            :loading="part1.search_loading"
                        >查詢</v-btn>
                    </v-col>
                </v-row>
            </v-toolbar>
        </v-card>
        <v-dialog
            v-model="part1.dialog"
            max-width="850px"
            persistent
            v-if="part1.student != null"
        >
            <v-card>
                <v-card-title>
                    <span>尺寸與配件顏色修改-{{ part1.student.username[0] > "5" ? '碩士服' : '學士服'}}</span>
                </v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row>
                        <v-col
                            cols="12"
                            md="4"
                        >學生：{{ part1.student.name }}</v-col>
                        <v-col
                            cols="12"
                            md="4"
                        >學號：{{ part1.student.username }}</v-col>
                        <v-col
                            cols="12"
                            md="4"
                        >系級：{{ part1.student.school_class.class_name }}</v-col>
                    </v-row>
                    <v-row class="mt-2">
                        <v-col
                            cols="12"
                            md="5"
                        >
                            <v-select
                                v-model="part1.cloth_id"
                                :items="part1.clothList"
                                item-text="spec"
                                item-value="id"
                                label="尺寸"
                                dense
                                outlined
                            ></v-select>
                        </v-col>
                        <v-col
                            cols="12"
                            md="5"
                        >
                            <v-select
                                v-model="part1.accessory_id"
                                :items="part1.accessoryList"
                                item-text="spec"
                                item-value="id"
                                label="顏色"
                                dense
                                outlined
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <code class="caption red--text text--lighten-1">* 數量不足不會顯示在選擇列表中</code>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        dark
                        @click="part1_cancel"
                    >
                        取消
                    </v-btn>
                    <v-btn
                        color="primary"
                        @click="part1_save"
                    >
                        確認
                    </v-btn>
                </v-card-actions>
            </v-card>
            <v-dialog
                v-model="part1.dialog_loading"
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
        <!-- part1 end  -->

        <!-- share  -->
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
    // hint: 5Lul5LiLIGNvZGUg5pyD5a+r5b6I6YacIOWboOeCuumAmemCiuaIkeaHtiDmspLntabpjKLllYpRUQ==

    import VuetifyLayout from '@/Layouts/VuetifyLayout'

    import {
        apiSearchStudent,
        apiEditSet
    } from '@/api/api'

    export default {
        components: {
            VuetifyLayout,
        },
        name: "AdminFixOrder",
        data: () => ({
            part1: {
                student_id: '',
                search_loading: false,
                dialog_loading: false,
                student: null,
                dialog: false,
                clothList: [],
                accessoryList: [],
                accessory_id: null,
                cloth_id: null,
                set_id: null,
            },
            msg: '',
            snackbar: false,
            snackbar_true: false,
        }),
        methods: {
            async part1_search() {
                if (/^([0-9]){9}$/.test(this.part1.student_id) === false) {
                    this.part1.student_id = ''
                    this.msg = '查無此學號'
                    this.snackbar_true = false
                    this.snackbar = true
                    return
                }
                this.part1.search_loading = true
                await apiSearchStudent(this.part1.student_id).then((res) => {
                    if (res.status == 200) {
                        if (res.data.set) {
                            this.part1.student = res.data
                            this.part1.student_id = ''
                            this.part1.dialog = true
                            this.part1.clothList = this.$page.props.inventory.filter(x =>
                                x.type == res.data.set.cloth.type &&
                                x.name == res.data.set.cloth.name &&
                                res.data.set.cloth.remain_quantity > 0
                            )
                            this.part1.accessoryList = this.$page.props.inventory.filter(x =>
                                x.type == res.data.set.accessory.type &&
                                x.name == res.data.set.accessory.name &&
                                res.data.set.accessory.remain_quantity > 0
                            )
                            this.part1.cloth_id = res.data.set.cloth.id
                            this.part1.accessory_id = res.data.set.accessory.id
                            this.part1.set_id = res.data.set.id
                        } else {
                            this.part1.student_id = ''
                            this.msg = '此學生尚未訂購'
                            this.snackbar_true = false
                            this.snackbar = true
                            this.part1.student = null
                        }
                    } else {
                        this.part1.student_id = ''
                        this.msg = '查無此學號'
                        this.snackbar_true = false
                        this.snackbar = true
                    }
                    this.part1.search_loading = false
                }).catch((err) => {
                    // console.log(err)
                    this.part1.student_id = ''
                    this.msg = '查無此學號'
                    this.part1.search_loading = false
                    this.snackbar_true = false
                    this.snackbar = true
                })
            },
            async part1_save() {
                this.part1.dialog_loading = true
                let set_id = this.part1.set_id
                let cloth_id = this.part1.cloth_id
                let accessory_id = this.part1.accessory_id
                await apiEditSet(set_id, cloth_id, accessory_id).then((res) => {
                    if (res.status == 204) {
                        this.msg = '已修改'
                        this.snackbar_true = true
                        this.snackbar = true
                    } else {
                        this.msg = '修改失敗'
                        this.snackbar_true = false
                        this.snackbar = true
                    }
                }).catch(() => {
                    this.msg = '修改失敗'
                    this.snackbar_true = false
                    this.snackbar = true
                })
                await this.part1_cancel()
            },
            part1_cancel() {
                this.part1 = {
                    student_id: '',
                    search_loading: false,
                    dialog_loading: false,
                    student: null,
                    dialog: false,
                    clothList: [],
                    accessoryList: [],
                    accessory_id: null,
                    cloth_id: null,
                    set_id: null,
                }
            }
        }
    }

</script>
