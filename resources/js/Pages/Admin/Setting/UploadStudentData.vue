<!-- vuetify fixed -->
<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            上傳學生資料
        </template>

        <!-- form grid-cols-6 -->
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label
                    for="std_data"
                    value="限 csv 檔案"
                />
                <v-file-input
                    accept=".csv"
                    label="學生資料"
                    ref="std_data"
                    id="std_data"
                ></v-file-input>

                <!-- <jet-input-error
                    :message="form.error('photo')"
                    class="mt-2"
                /> -->
            </div>
        </template>

        <template #actions>
            <jet-action-message
                :on="form.recentlySuccessful"
                class="mr-3"
            >
                已上傳
            </jet-action-message>

            <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                上傳
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
                })
            }
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
