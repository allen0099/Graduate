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
                            dark
                            color="primary"
                            @click="show = false"
                        >
                            取消
                        </v-btn>
                        <v-btn
                            dark
                            color="primary"
                            @click="$refs.menu.save(dates)"
                        >
                            確定
                        </v-btn>
                    </v-date-picker>
                </v-menu>
            </div>
        </template>
        <template #actions>
            <jet-action-message
                :on="form.recentlySuccessful"
                class="mr-3"
                :color="Object.values($page.props.errors).length > 0 ? 'red' : ''"
            >
                {{ Object.values($page.props.errors).length > 0 ? Object.values($page.props.errors)[0] : $page.props.flash.success }}

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
                let start_time = this.$moment(this.time.start_time).format("YYYY-MM-DD")
                let end_time = this.$moment(this.time.end_time).format("YYYY-MM-DD")
                this.dates = [start_time, end_time]
                this.content = this.time.content
                this.form.start_time = this.dates[0]
                this.form.end_time = this.dates[1]
            },
        },
        mounted() {
            this.initTime()
        },
    }

</script>
