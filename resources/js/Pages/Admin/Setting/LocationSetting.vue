<!-- vuetify fixed -->
<template>
    <jet-form-section
        @submitted="updateLocation"
        class="mt-5"
    >
        <template #title>
            {{ title + '地點設定' }}
        </template>

        <!-- form grid-cols-6 -->
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-6 sm:col-span-4">
                    <jet-label
                        :for="type"
                        value="地點"
                    />
                    <jet-input
                        :id="type"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="location"
                        ref="location"
                    />
                    <jet-input-error
                        :message="form.errors.location"
                        class="mt-2"
                    />
                </div>
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
            JetInputError,
            JetInput,
        },
        props: ['title', 'type'],
        data() {
            return {
                dates: [], // new Date().toISOString().substr(0, 10)
                show: false,
                location: '',
                form: this.$inertia.form({
                    '_method': 'POST',
                    location: '',
                    type: this.type,
                }, {
                    bag: 'updateLocation',
                }),
            }
        },
        methods: {
            updateLocation() {
                this.form.location = this.location
                this.form.post('/location');
            },
            init() {
                this.location = this.$page.props.configs[this.type + '_location']
            }
        },
        mounted() {
            this.init()
        },
    }

</script>
