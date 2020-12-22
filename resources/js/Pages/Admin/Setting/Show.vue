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
                <!-- <v-tab-item>
                    <v-card flat>
                        <v-card-text>
                            <UploadStudentData></UploadStudentData>
                            <jet-section-border />
                            <UploadStampImg></UploadStampImg>
                        </v-card-text>
                    </v-card>
                </v-tab-item> -->
                <!-- tab 3 -->
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
            </v-tabs>
        </div>
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
        name: "AdminSetting",
        data: () => ({

        }),
    }

</script>
