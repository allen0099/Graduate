<template>
    <VuetifyLayout>
        <template #header>
            首頁
        </template>
        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>取消訂單申請</v-card-title>
        </v-card>

        <v-divider class="v-divider-bold" />

        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>學士服品項數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="item in [1, 2, 3, 4, 5, 6]"
                    :key="item"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card color="#FFF5EB">
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            style="color: #968C83"
                        >{{'S 號'}}</v-card-title>
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
                                <span style="color:#8FB69B">{{ '123' }}</span> /
                                <span>{{ '123' }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>

        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>學士服領巾數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="(ba_item, index) in bachelor_accessories"
                    :key="`bachelor_accessories-${index}`"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card :color="card_color[ba_item.color] ? card_color[ba_item.color].bg : '#ffffff'">
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            :style="{color: card_color[ba_item.color] ? card_color[ba_item.color].q : '#000000'}"
                        >{{ba_item.color }}</v-card-title>
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
                                <span :style="{color: card_color[ba_item.color] ? card_color[ba_item.color].q :
                                    '#000000'}">{{ ba_item.quantity }}</span>
                                <span :style="{color: card_color[ba_item.color] ? card_color[ba_item.color].r :
                                    '#000000'}"> / {{ ba_item.remaining }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>

        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>學士服品項數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="item in [1, 2, 3, 4, 5, 6]"
                    :key="item"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card color="#FFF5EB">
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            style="color: #968C83"
                        >{{'S 號'}}</v-card-title>
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
                                <span style="color:#8FB69B">{{ '123' }}</span> /
                                <span>{{ '123' }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>

        <v-card
            class="mt-3"
            flat
        >
            <v-card-title>學士服領巾數量 (剩餘/總數)</v-card-title>
            <v-row dense>
                <v-col
                    v-for="(ma_item, index) in master_accessories"
                    :key="`master_accessories-${index}`"
                    cols="6"
                    lg="2"
                    sm="4"
                >
                    <v-card :color="card_color[ma_item.color] ? card_color[ma_item.color].bg : '#ffffff'">
                        <v-card-title
                            class="body2 pb-1 font-weight-bold"
                            :style="{color: card_color[ma_item.color] ? card_color[ma_item.color].q : '#000000'}"
                        >{{ma_item.color }}</v-card-title>
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
                                <span :style="{color: card_color[ma_item.color] ? card_color[ma_item.color].q :
                                    '#000000'}">{{ ma_item.quantity }}</span>
                                <span :style="{color: card_color[ma_item.color] ? card_color[ma_item.color].r :
                                    '#000000'}"> / {{ ma_item.remaining }}</span>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>

    </VuetifyLayout>
</template>

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
            bachelor_cloths: [],
            bachelor_accessories: [{
                color: '白色',
                quantity: 3000,
                remaining: 2000
            }, {
                color: '藍色',
                quantity: 3001,
                remaining: 2001
            }, ],
            master_cloths: [],
            master_accessories: [{
                color: '白色',
                quantity: 3000,
                remaining: 2000
            }, {
                color: '黃色',
                quantity: 3001,
                remaining: 2001
            }, {
                color: '橘色',
                quantity: 3002,
                remaining: 2002
            }, {
                color: '灰色',
                quantity: 3000,
                remaining: 2003
            }, {
                color: '藍色',
                quantity: 3004,
                remaining: 2004
            }, {
                color: '紫色',
                quantity: 3005,
                remaining: 2005
            }],
            card_color: {
                '白色': {
                    bg: '#FFFFFF',
                    q: '#000000',
                    r: '#000000',
                },
                '黃色': {
                    q: '#FFFDE7',
                    bg: '#F57F17',
                    r: '#FFFFFF'
                },
                '橘色': {
                    q: '#FFF3E0',
                    bg: '#E65100',
                    r: '#FFFFFF'
                },
                '灰色': {
                    q: '#F5F5F5',
                    bg: '#424242',
                    r: '#FFFFFF'
                },
                '藍色': {
                    q: '#BBDEFB',
                    bg: '#0D47A1',
                    r: '#FFFFFF'
                },
                '紫色': {
                    q: '#D1C4E9',
                    bg: '#311B92',
                    r: '#FFFFFF'
                }
            },
        }),
    }

</script>
