<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>
            更新密碼
        </template>

        <template #description>
            密碼至少 8 個字元
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label
                    for="current_password"
                    value="當前密碼"
                />
                <jet-input
                    id="current_password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.current_password"
                    ref="current_password"
                    autocomplete="current-password"
                />
                <jet-input-error
                    :message="form.errors.current_password"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label
                    for="password"
                    value="新密碼"
                />
                <jet-input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    autocomplete="new-password"
                />
                <jet-input-error
                    :message="form.errors.password"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label
                    for="password_confirmation"
                    value="再次輸入新密碼"
                />
                <jet-input
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                />
                <jet-input-error
                    :message="form.errors.password_confirmation"
                    class="mt-2"
                />
            </div>
        </template>

        <template #actions>
            <jet-action-message
                :on="form.recentlySuccessful"
                class="mr-3"
            >
                已儲存.
            </jet-action-message>

            <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                儲存
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },
        data() {
            return {
                username: 'meow',
                form: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }, {
                    bag: 'updatePassword',
                }),
            }
        },

        methods: {
            updatePassword() {
                this.form.put(route('user-password.update'), {
                    preserveScroll: true,
                    onFinish: () => {
                        this.$refs.current_password.focus()
                    }
                })
            },
        },
    }

</script>
