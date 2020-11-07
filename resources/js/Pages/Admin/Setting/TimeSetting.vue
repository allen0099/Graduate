<!-- vuetify fixed -->
<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            借用時間設定
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
            >
                已設定
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

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    std_data: null,
                }, {
                    bag: 'uploadStudentData',
                }),
                dates: [], // new Date().toISOString().substr(0, 10)
                show: false,
            }
        },
        computed: {
            dateRangeText() {
                return this.dates.join(' ~ ')
            },
        },
        methods: {
            uploadStudentData() {
                if (this.$refs.std_data) {
                    this.form.std_data = this.$refs.std_data.files[0]
                }

                this.form.post(route('user-profile-information.update'));
            },
        },
    }

</script>
