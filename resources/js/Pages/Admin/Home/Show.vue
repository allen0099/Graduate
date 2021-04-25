<template>
    <VuetifyLayout>
        <template #header>
            首頁
        </template>
        <!-- 學士服 -->
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>學士服品項數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="(bc_item, index) in bachelor_cloths"
                    :key="`bachelor_cloths-${index}`"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card
                        color="#FFF5EB"
                        :class="{'breathe-div' : bc_item.remain_quantity<=5 || bc_item.remain_quantity < bc_item.quantity * 0.1}"
                    >
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            style="color: #968C83"
                        >{{ bc_item.spec }} {{ !bc_item.remain_quantity ? ' (售完)' : '' }}</v-card-title>
                        <v-row
                            class="pb-1 ml-7"
                            no-gutters
                            justify="space-between"
                            align="center"
                        >
                            <v-col
                                class="text-h6 font-weight-bold"
                                cols="12"
                            >
                                <span
                                    :style="{color: bc_item.remain_quantity<=5 || bc_item.remain_quantity < bc_item.quantity * 0.1 ? '#D19999' : '#8FB69B'}"
                                >
                                    {{ bc_item.remain_quantity }}</span>
                                /
                                <span>{{ bc_item.quantity }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
        <!-- 學士服配件 -->
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>學士服領巾、帽子數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="(ba_item, index) in bachelor_accessories"
                    :key="`bachelor_accessories-${index}`"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card
                        :color="card_color[ba_item.spec] ? card_color[ba_item.spec].bg : '#ffffff'"
                        :class="{'breathe-div' : ba_item.remain_quantity<=5 || ba_item.remain_quantity < ba_item.quantity * 0.1}"
                    >
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            :style="{color: card_color[ba_item.spec] ? card_color[ba_item.spec].q : '#000000'}"
                        >{{ ba_item.spec }} {{ !ba_item.remain_quantity ? ' (售完)' : '' }}</v-card-title>
                        <v-row
                            class="pb-1 ml-7"
                            no-gutters
                            justify="space-between"
                            align="center"
                        >
                            <v-col
                                class="text-h6 font-weight-bold"
                                cols="12"
                            >
                                <span :style="{color: card_color[ba_item.spec] ? card_color[ba_item.spec].q :
                                    '#000000'}">{{ ba_item.remain_quantity }}</span>
                                <span :style="{color: card_color[ba_item.spec] ? card_color[ba_item.spec].r :
                                    '#000000'}"> / {{ ba_item.quantity }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
        <v-divider class="mt-6 mb-3"></v-divider>
        <!-- 碩士服 -->
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>碩士服品項數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="(mc_item, index) in master_cloths"
                    :key="`master_cloths-${index}`"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card
                        color="#FFF5EB"
                        :class="{'breathe-div' : mc_item.remain_quantity<=5 || mc_item.remain_quantity < mc_item.quantity * 0.1}"
                    >
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            style="color: #968C83"
                        >{{ mc_item.spec }} {{ !mc_item.remain_quantity ? ' (售完)' : '' }}</v-card-title>
                        <v-row
                            class="pb-1 ml-7"
                            no-gutters
                            justify="space-between"
                            align="center"
                        >
                            <v-col
                                class="text-h6 font-weight-bold"
                                cols="12"
                            >
                                <span
                                    :style="{color: mc_item.remain_quantity<=5 || mc_item.remain_quantity < mc_item.quantity * 0.1 ? '#D19999' : '#8FB69B'}"
                                >
                                    {{ mc_item.remain_quantity }}
                                </span> /
                                <span>{{ mc_item.quantity }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
        <!-- 碩士服配件 -->
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>披肩、帽穗數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="(ma_item, index) in master_accessories"
                    :key="`master_accessories-${index}`"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card
                        :color="card_color[ma_item.spec] ? card_color[ma_item.spec].bg : '#ffffff'"
                        :class="{'breathe-div' : ma_item.remain_quantity<=5 || ma_item.remain_quantity <
                            ma_item.quantity
                            *
                            0.1}"
                    >
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            :style="{color: card_color[ma_item.spec] ? card_color[ma_item.spec].q : '#000000'}"
                        >{{ ma_item.spec }} {{ !ma_item.remain_quantity ? ' (售完)' : '' }}</v-card-title>
                        <v-row
                            class="pb-1 ml-7"
                            no-gutters
                            justify="space-between"
                            align="center"
                        >
                            <v-col
                                class="text-h6 font-weight-bold"
                                cols="12"
                            >
                                <span :style="{color: card_color[ma_item.spec] ? card_color[ma_item.spec].q :
                                    '#000000'}">{{ ma_item.remain_quantity }}</span>
                                <span :style="{color: card_color[ma_item.spec] ? card_color[ma_item.spec].r :
                                    '#000000'}"> / {{ ma_item.quantity }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>

    </VuetifyLayout>
</template>

<style>
    .breathe-div {
        border: 1px solid #D19999;
        border-radius: 50%;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        animation-timing-function: ease-in-out;
        animation-name: breathe;
        animation-duration: 1500ms;
        animation-iteration-count: infinite;
        animation-direction: alternate;
    }

    @keyframes breathe {
        0% {
            opacity: .8;
            box-shadow: 0 1px 2px rgba(173, 25, 25, 0.4), 0 1px 1px rgba(173, 25, 25, 0.1) inset;
        }

        100% {
            opacity: 1;
            border: 1px solid rgba(209, 153, 153, 0.7);
            box-shadow: 0 1px 5px #D19999, 0 1px 10px #D19999 inset;
        }
    }

</style>

<script>
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import UploadStudentData from '@/Pages/Admin/Setting/UploadStudentData'
    import UploadStampImg from '@/Pages/Admin/Setting/UploadStampImg'
    import TimeSetting from '@/Pages/Admin/Setting/TimeSetting'

    export default {
        components: {
            VuetifyLayout,
            JetSectionBorder,
            UploadStudentData,
            UploadStampImg,
            TimeSetting
        },
        name: "AdminHome",
        data: () => ({
            cancel_choose: null,
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
            item_height: 100,
            windowSize: {
                x: 0,
                y: 0,
            },
        }),
        methods: {
            onResize() {
                this.windowSize = {
                    x: window.innerWidth,
                    y: window.innerHeight
                }
                if (this.windowSize.x < 960) {
                    this.item_height = 280
                } else {
                    this.item_height = 160
                }
            },
            init_obj() {
                this.bachelor_accessories = this.$page.props.inventory.slice(0, 2)
                this.master_accessories = this.$page.props.inventory.slice(2, 8)
                this.bachelor_cloths = this.$page.props.inventory.slice(8, 12)
                this.master_cloths = this.$page.props.inventory.slice(12, 15)
            },
        },
        created() {
            this.init_obj()
        },
        mounted() {
            this.onResize()
        },
    }

</script>
