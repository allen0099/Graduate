<template>
    <div>
        <v-card flat>
            <v-card-title>
                <v-spacer></v-spacer>
                <v-btn-toggle
                    v-model="type"
                    rounded
                    mandatory
                    color="primary"
                >
                    <v-btn>
                        學士學位
                    </v-btn>
                    <v-btn>
                        碩士學位
                    </v-btn>
                </v-btn-toggle>
            </v-card-title>
            <v-card-text>
                <v-card
                    flat
                    outlined
                    class="mt-3 mb-5"
                    color="red lighten-5"
                >
                    <v-card-title>
                        尚未設定
                        <v-spacer></v-spacer>
                        <v-btn @click="color_setting(-1)">
                            設定
                        </v-btn>
                    </v-card-title>
                    <v-card-text class="font-weight-bold">
                        <v-row dense>
                            <v-col
                                cols="6"
                                sm="4"
                                lg="2"
                                md="3"
                                v-for="(item, idx) in departments"
                                :key="`departments-${idx}`"
                                v-if="!item.default_color"
                            >
                                <span>{{ item.class_name }}</span>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <v-card
                    flat
                    outlined
                    class="mb-5"
                    v-for="(color, index) in colorList"
                    :key="`color-${color}`"
                    :color="colorListBG[index]"
                >
                    <v-card-title>
                        {{ color }}色
                        <v-spacer></v-spacer>
                        <v-btn @click="color_setting(index)">
                            設定
                        </v-btn>
                    </v-card-title>
                    <v-card-text class="font-weight-bold">
                        <v-row dense>
                            <v-col
                                cols="6"
                                sm="4"
                                lg="2"
                                md="3"
                                v-for="(item, idx) in departments"
                                :key="`departments-${index}-${idx}`"
                                v-if="item.default_color === color"
                            >
                                <span>{{ item.class_name }}</span>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-card-text>

        </v-card>
        <v-dialog
            v-model="dialog"
            persistent
            max-width="1000px"
        >
            <v-card>
                <v-card-title>{{ color_edit }}</v-card-title>
                <v-card-text class="font-weight-bold">
                    <v-row dense>
                        <v-col cols="12">
                            <v-select
                                v-model="color_choose"
                                :items="[...colorList, '不設定']"
                                label="顏色選擇"
                            ></v-select>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                v-model="search"
                                label="搜尋"
                                hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="6"
                            sm="4"
                            lg="2"
                            md="3"
                            v-for="(item, index) in departments_edit"
                            :key="`departments_edit-${index}`"
                            v-show="item.class_name.indexOf(search) > -1"
                        >
                            <v-checkbox
                                v-model="selected"
                                :label="item.class_name"
                                :value="item.class_id"
                            ></v-checkbox>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-spacer></v-spacer>
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
                        dark
                        @click="save"
                        :disabled="!color_choose"
                    >
                        設定
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
    </div>
</template>

<script>
    import {
        apiDepartment,
        apiClassSetColor
    } from '@/api/api'

    export default {
        name: "DepartmentColorSettimg",
        data() {
            return {
                type: 0,
                search: '',
                dialog: false,
                pageLoading: false,
                snackbar: false,
                snackbar_true: false,
                color_choose: null,
                msg: '',
                departments: [],
                departments_B: [],
                departments_M: [],
                departments_edit: [],
                color_edit: '',
                selected: [],
                colorList: ['白', '藍'],
                colorListBG: [
                    "white",
                    "light-blue lighten-5",
                    "yellow lighten-5",
                    "orange lighten-5",
                    "grey lighten-5",
                    "deep-purple lighten-5",
                ]
            }
        },

        watch: {
            type(val) {
                this.departments = val ? this.departments_M : this.departments_B
                this.colorList = val ? ['白', '藍', '黃', '橘', '灰', '紫'] : ['白', '藍']
                this.selected = []
            }
        },

        methods: {
            async init() {
                await apiDepartment().then(res => {
                    if (res.status === 200) {
                        this.departments_M = res.data.filter(x =>
                            x.class_id[4] === "M" ||
                            x.class_id[4] === "J"
                        )
                        this.departments_B = res.data.filter(x =>
                            x.class_id[4] === "B" ||
                            x.class_id[4] === "E" ||
                            x.class_id[4] === "K"
                        )
                    }
                })
                this.departments = this.departments_B
            },
            color_setting(target) {
                this.dialog = true
                if (target == -1) {
                    this.color_edit = '尚未設定'
                    this.departments_edit = this.departments.filter(x => !x.default_color)
                } else {
                    this.color_edit = this.colorList[target]
                    this.departments_edit = this.departments.filter(x => x.default_color == this.color_edit)
                }
            },
            cancel() {
                this.dialog = false
                this.departments_edit = []
                this.selected = []
                this.search = ''
                this.color_choose = null
                this.pageLoading = false
            },
            async save() {
                this.pageLoading = true
                if (this.color_choose == '不設定') {
                    this.color_choose = null
                }
                await apiClassSetColor(this.selected, this.color_choose).then(res => {
                    if (res.status == 204) {
                        for (let i of this.selected) {
                            this.departments.find(x => x.class_id == i).default_color = this.color_choose
                        }
                        this.msg = '設定完成'
                        this.snackbar_true = true
                    } else {
                        this.msg = '設定失敗'
                        this.snackbar_true = false
                    }
                    this.snackbar = true
                }).catch((err) => {
                    this.msg = '設定失敗'
                    this.search_loading = false
                })

                await this.cancel()
            },
        },

        created() {
            this.init()
        },
    }

</script>
