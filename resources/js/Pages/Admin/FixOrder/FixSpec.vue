<template>
    <div>
        <v-card
            class="mb-3"
            flat
        >
            <v-card-title class="title font-weight-bold mx-auto px-sm-6 px-lg-8">
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
                            v-model="student_id"
                            label="學號"
                            outlined
                            clearable
                            dense
                            class="mr-2"
                            type='text'
                            @keyup.enter="search"
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="3"
                        md="2"
                    >
                        <v-btn
                            color="primary"
                            @click="search"
                            :loading="search_loading"
                        >查詢</v-btn>
                    </v-col>
                </v-row>
            </v-toolbar>
        </v-card>
        <v-dialog
            v-model="dialog"
            max-width="850px"
            persistent
            v-if="student != null"
        >
            <v-card>
                <v-card-title>
                    <span>尺寸與配件顏色修改-{{ student.username[0] > "5" ? '碩士服' : '學士服'}}</span>
                </v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row>
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
                        >系級：{{ student.school_class.class_name }}</v-col>
                    </v-row>
                    <v-row class="mt-2">
                        <v-col
                            cols="12"
                            md="5"
                        >
                            <v-select
                                v-model="cloth_id"
                                :items="clothList.filter(x=>x.remain_quantity > 0)"
                                item-text="spec"
                                item-value="id"
                                label="尺寸"
                                dense
                                outlined
                            >
                                <template v-slot:item="{ item }">
                                    {{ item.spec + '，剩餘：' + item.remain_quantity + ' 件'}}
                                </template>
                            </v-select>
                        </v-col>
                        <v-col
                            cols="12"
                            md="5"
                        >
                            <v-select
                                v-model="accessory_id"
                                :items="accessoryList.filter(x=>x.remain_quantity > 0)"
                                item-text="spec"
                                item-value="id"
                                label="顏色"
                                dense
                                outlined
                            >
                                <template v-slot:item="{ item }">
                                    {{ item.spec + '，剩餘：' + item.remain_quantity + ' 件'}}
                                </template>
                            </v-select>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <code class="caption red--text text--lighten-1">* 數量不足不會顯示在選擇列表中</code>
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
                        @click="save"
                    >
                        確認
                    </v-btn>
                </v-card-actions>
            </v-card>
            <v-dialog
                v-model="dialog_loading"
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
    </div>
</template>

<script>
    // hint: 5Lul5LiLIGNvZGUg5pyD5a+r5b6I6YacIOWboOeCuumAmemCiuaIkeaHtiDmspLntabpjKLllYpRUQ==

    import {
        apiSearchStudent,
        apiEditSet
    } from '@/api/api'

    export default {
        name: "FixSpec",
        data: () => ({
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
        }),
        methods: {
            async search() {
                if (/^([0-9]){9}$/.test(this.student_id) === false) {
                    this.student_id = ''
                    this.msg = '查無此學號'
                    this.snackbar_true = false
                    this.$emit('changeMsg', this.msg, this.snackbar_true)
                    return
                }
                this.search_loading = true
                await apiSearchStudent(this.student_id).then((res) => {
                    if (res.status == 200) {
                        if (res.data.set) {
                            this.student = res.data
                            this.student_id = ''
                            this.dialog = true
                            this.clothList = this.$page.props.inventory.filter(x =>
                                x.type == res.data.set.cloth.type &&
                                x.name == res.data.set.cloth.name &&
                                res.data.set.cloth.remain_quantity > 0
                            )
                            this.accessoryList = this.$page.props.inventory.filter(x =>
                                x.type == res.data.set.accessory.type &&
                                x.name == res.data.set.accessory.name &&
                                res.data.set.accessory.remain_quantity > 0
                            )
                            this.cloth_id = res.data.set.cloth.id
                            this.accessory_id = res.data.set.accessory.id
                            this.set_id = res.data.set.id
                        } else {
                            this.student_id = ''
                            this.msg = '此學生尚未訂購'
                            this.snackbar_true = false
                            this.$emit('changeMsg', this.msg, this.snackbar_true)
                            this.student = null
                        }
                    } else {
                        this.student_id = ''
                        this.msg = '查無此學號'
                        this.snackbar_true = false
                        this.$emit('changeMsg', this.msg, this.snackbar_true)
                    }
                    this.search_loading = false
                }).catch((err) => {
                    // console.log(err)
                    this.student_id = ''
                    this.msg = '查無此學號'
                    this.search_loading = false
                    this.snackbar_true = false
                    this.$emit('changeMsg', this.msg, this.snackbar_true)
                })
            },
            async save() {
                this.dialog_loading = true
                let set_id = this.set_id
                let cloth_id = this.cloth_id
                let accessory_id = this.accessory_id
                await apiEditSet(set_id, cloth_id, accessory_id).then((res) => {
                    if (res.status == 204) {
                        this.msg = '已修改'
                        this.snackbar_true = true
                        this.$emit('changeMsg', this.msg, this.snackbar_true)
                    } else {
                        this.msg = '修改失敗'
                        this.snackbar_true = false
                        this.$emit('changeMsg', this.msg, this.snackbar_true)
                    }
                }).catch(() => {
                    this.msg = '修改失敗'
                    this.snackbar_true = false
                    this.$emit('changeMsg', this.msg, this.snackbar_true)
                })
                await this.cancel()
            },
            cancel() {

                this.student_id = ''
                this.search_loading = false
                this.dialog_loading = false
                this.student = null
                this.dialog = false
                this.clothList = []
                this.accessoryList = []
                this.accessory_id = null
                this.cloth_id = null
                this.set_id = null

            }
        }
    }

</script>
