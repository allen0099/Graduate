<!-- vuetify fixed -->
<template>
    <jet-form-section
        @submitted="updateTimeRange"
        class="mt-5"
    >
        <template #title>
            {{ time.content + '設定' }}
        </template>

        <!-- form grid-cols-6 -->
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <v-menu
                    ref="menu"
                    v-model="show"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="dateRangeText"
                            label="選擇日期"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        v-model="dates"
                        no-title
                        scrollable
                        range
                        locale="zh-cn"
                    >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                            @click="show = false"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$refs.menu.save(dates)"
                        >
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-menu>
            </div>
        </template>
        <template #actions>
            <jet-action-message
                :on="form.recentlySuccessful"
                class="mr-3"
                :color="Object.values($page.errors).length > 0 ? 'red' : ''"
            >
                {{ Object.values($page.errors).length > 0 ? Object.values($page.errors)[0] : $page.flash.success }}

            </jet-action-message>

            <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                設定
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetLabel,
        },
        props: ['time'],
        data() {
            return {
                dates: [], // new Date().toISOString().substr(0, 10)
                show: false,
                form: this.$inertia.form({
                    '_method': 'PATCH',
                    start_time: '',
                    end_time: '',
                }, {
                    bag: 'updateTimeRange',
                }),
            }
        },
        computed: {
            dateRangeText() {
                return this.dates.join(' ~ ')
            },
        },
        methods: {
            updateTimeRange() {
                this.form.start_time = this.dates[0]
                this.form.end_time = this.dates[1]
                // this.form.content = this.time.content
                this.form.patch('/time/' + this.time.id);
            },
            initTime() {
                let start_time = new Date(this.time.start_time).Format("yyyy-MM-dd")
                let end_time = new Date(this.time.end_time).Format("yyyy-MM-dd")
                this.dates = [start_time, end_time]
                this.content = this.time.content
                this.form.start_time = this.dates[0]
                this.form.end_time = this.dates[1]
            },
            init() {
                Date.prototype.Format = function (fmt) {
                    var o = {
                        "M+": this.getMonth() + 1, //月份
                        "d+": this.getDate(), //日
                        "H+": this.getHours(), //小時
                        "m+": this.getMinutes(), //分
                        "s+": this.getSeconds(), //秒
                        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
                        "S": this.getMilliseconds() //毫秒
                    };
                    if (/(y+)/.test(fmt)) {
                        fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
                    }
                    for (var k in o) {
                        if (new RegExp("(" + k + ")").test(fmt)) {
                            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k])
                                .substr((
                                    "" +
                                    o[k]).length)));
                        }
                    }
                    return fmt;
                }
            }
        },
        mounted() {
            this.initTime()
        },
        created() {
            this.init()
        }
    }

</script>
