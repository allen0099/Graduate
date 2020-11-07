<!-- vuetify fixed -->
<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            上傳經手人印鑑圖鑑
        </template>

        <!-- form grid-cols-6 -->
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input
                    type="file"
                    class="hidden"
                    ref="photo"
                    @change="updatePhotoPreview"
                    accept="image/png, image/jpeg, image/bmp"
                >

                <jet-label
                    for="photo"
                    value="當前圖片"
                />

                <!-- Current Profile Photo -->
                <div
                    class="mt-2"
                    v-show="! photoPreview"
                >
                    <img
                        src="https://jetstream.laravel.com/assets/img/logo.svg"
                        alt="Current Profile Photo"
                        class="h-30 w-100 object-cover"
                    >
                </div>

                <div
                    class="mt-2"
                    v-show="photoPreview"
                >
                    <img
                        :src="photoPreview"
                        alt="Current Profile Photo"
                        class="h-30 w-100 object-cover"
                    >
                </div>

                <jet-secondary-button
                    class="mt-5 mr-2"
                    type="button"
                    @click.native.prevent="selectNewPhoto"
                >
                    選擇圖片
                </jet-secondary-button>

                <jet-secondary-button
                    type="button"
                    class="mt-5"
                    @click.native.prevent="deletePhoto"
                >
                    移除圖片
                </jet-secondary-button>

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
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetLabel,
            JetSecondaryButton,
            JetInput,
            JetInputError
        },

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    photo: null,
                }, {
                    bag: 'uploadStudentData',
                }),
                photoPreview: null
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                }).then(() => {
                    this.photoPreview = null
                });
            },
        },
    }

</script>
