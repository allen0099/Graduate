<template>
    <VuetifyLayout>
        <template #header>
            系統設定
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <v-tabs
                centered
                grow
            >
                <v-tab>
                    <v-icon left>mdi-account</v-icon>
                    資料上傳
                </v-tab>
                <v-divider vertical></v-divider>
                <v-tab>
                    <v-icon left>mdi-lock</v-icon>
                    時間與地點
                </v-tab>
                <v-divider vertical></v-divider>
                <v-tab>
                    <v-icon left>mdi-access-point</v-icon>
                    衣服相關設定
                </v-tab>
                <!-- tab 1 -->
                <v-tab-item>
                    <v-card flat>
                        <v-card-text>
                            <UploadStudentData></UploadStudentData>
                            <jet-section-border />
                            <UploadStampImg></UploadStampImg>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
                <!-- tab 2 -->
                <v-tab-item>
                    <v-card flat>
                        <v-card-text>
                            <div
                                v-for="(time, index) in $page.configs.time_range"
                                :key="`time-${index}`"
                            >
                                <TimeSetting :time="time"></TimeSetting>
                                <jet-section-border />

                            </div>
                        </v-card-text>
                    </v-card>
                </v-tab-item>

                <!-- tab 3 -->
                <v-tab-item>
                    <v-card flat>
                        <v-card-title>
                            <v-spacer></v-spacer>
                            <v-btn-toggle
                                v-model="toggle_btn"
                                rounded
                                mandatory
                                color="primary"
                            >
                                <v-btn>
                                    學士服
                                </v-btn>
                                <v-btn>
                                    碩士服
                                </v-btn>
                            </v-btn-toggle>
                        </v-card-title>

                        <!-- 學士服 -->
                        <v-card
                            flat
                            v-if="toggle_btn === 0"
                        >
                            <v-card-title>價格設定</v-card-title>
                            <v-row
                                class="mx-5"
                                dense
                            >
                                <v-col
                                    cols="2"
                                    class="mt-2"
                                >
                                    價格
                                </v-col>
                                <v-col
                                    md="4"
                                    cols="6"
                                >
                                    <v-text-field
                                        v-model="price"
                                        value="10.00"
                                        prefix="$"
                                        outlined
                                        dense
                                        :rules="numberRules"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    md="3"
                                    cols="3"
                                    class="ml-3"
                                >
                                    <v-btn>儲存</v-btn>
                                </v-col>
                            </v-row>
                            <v-divider class="mx-5 v-divider-bold" />
                            <v-card-title>尺寸數量設定</v-card-title>
                            <v-row
                                v-for="(item, index) in bachelor_cloths"
                                :key="`bachelor_cloths-${index}`"
                                class="mx-5"
                                dense
                            >
                                <v-col
                                    cols="2"
                                    class="mt-2"
                                >
                                    {{ item.spec }}
                                </v-col>
                                <v-col
                                    md="4"
                                    cols="6"
                                >
                                    <v-text-field
                                        v-model="item.quantity"
                                        outlined
                                        dense
                                        :rules="numberRules"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    md="3"
                                    cols="3"
                                    class="ml-3"
                                >
                                    <v-btn @click="save_inventory(item)">儲存</v-btn>
                                </v-col>
                            </v-row>
                            <v-card-title>領巾數量設定</v-card-title>
                            <v-row
                                v-for="(item, index) in bachelor_accessories"
                                :key="`bachelor_accessories-${index}`"
                                class="mx-5"
                                dense
                            >
                                <v-col
                                    cols="2"
                                    class="mt-2"
                                >
                                    {{ item.spec }}
                                </v-col>
                                <v-col
                                    md="4"
                                    cols="6"
                                >
                                    <v-text-field
                                        v-model="item.quantity"
                                        outlined
                                        dense
                                        :rules="numberRules"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    md="3"
                                    cols="3"
                                    class="ml-3"
                                >
                                    <v-btn @click="save_inventory(item)">儲存</v-btn>
                                </v-col>
                            </v-row>
                        </v-card>

                        <!-- 碩士服 -->
                        <v-card
                            flat
                            v-else
                        >
                            <v-card-title>價格設定</v-card-title>
                            <v-card-title>尺寸數量設定</v-card-title>
                            <v-card-title>帽穗、披肩數量設定</v-card-title>
                        </v-card>
                    </v-card>
                </v-tab-item>
            </v-tabs>
        </div>

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
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import UploadStudentData from '@/Pages/Admin/Setting/UploadStudentData'
    import UploadStampImg from '@/Pages/Admin/Setting/UploadStampImg'
    import TimeSetting from '@/Pages/Admin/Setting/TimeSetting'
    // import LocationSetting from '@/Pages/Admin/Setting/LocationSetting'

    export default {
        components: {
            VuetifyLayout,
            JetSectionBorder,
            UploadStudentData,
            UploadStampImg,
            TimeSetting,
            // LocationSetting
        },
        name: "AdminSetting",
        data: () => ({
            snackbar: false,
            snackbar_true: false,
            msg: '',
            toggle_btn: 0,
            price: 1000,
            bachelor_cloths: [],
            bachelor_accessories: [],
            master_cloths: [],
            master_accessories: [],
            numberRules: [
                v => !!v || '不可為空',
                v => /^[0-9]*$/.test(v) || '只能輸入數字'
            ]
        }),
        methods: {
            init_obj() {
                this.bachelor_accessories = this.$page.inventory.slice(0, 2)
                this.master_accessories = this.$page.inventory.slice(2, 8)
                this.bachelor_cloths = this.$page.inventory.slice(8, 12)
                this.master_cloths = this.$page.inventory.slice(12, 15)
            },
            save_inventory(item) {
                this.snackbar = false
                if (!!item.quantity && /^[0-9]*$/.test(item.quantity)) {
                    this.snackbar_true = true
                    this.msg = '修改成功'
                } else {
                    this.snackbar_true = false
                    this.msg = '修改失敗'
                }
                this.snackbar = true
            },
            save_price(item) {
                this.snackbar = false
                if (!!item.quantity && /^[0-9]*$/.test(item.quantity)) {
                    this.snackbar_true = true
                    this.msg = '修改成功'
                } else {
                    this.snackbar_true = false
                    this.msg = '修改失敗'
                }
                this.snackbar = true
            }
        },
        created() {
            this.init_obj()
        },
    }

</script>
