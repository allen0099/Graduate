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
            <v-alert
                :color="green"
                text
                :type="error ? 'error' : 'success'"
                v-show="student.stuid"
            >{{ student.stuid }} {{ student.department }} {{ student.name }}</v-alert>
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

    </VuetifyLayout>
</template>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'

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
            student: {
                stuid: '',
                department: '',
                name: ''
            },
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
            return_submit() {
                if (/^([0-9]){9}$/.test(this.stuid) === false) {
                    this.stuid = ''
                    this.msg = '查無此學號'
                    this.error = true
                    this.show_msg = true
                } else {
                    this.stuid = ''
                    this.msg = '已歸還'
                    this.error = false
                    this.show_msg = true
                    this.student = {
                        stuid: '406410232',
                        department: '資工XXXXX組',
                        name: 'Rex Weng ABCDD'
                    }
                }
                setTimeout(() => {
                    this.show_msg = false
                }, 2000)
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
