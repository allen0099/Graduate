<!-- vuetify fixed -->
<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            使用者資訊
        </template>

        <!-- <template #description>
            更新你的使用者資訊
        </template> -->

        <!-- form grid-cols-6 -->
        <template #form>
            <!-- Profile Photo -->
            <div
                class="col-span-6 sm:col-span-4"
                v-if="$page.jetstream.managesProfilePhotos"
            >
                <!-- Profile Photo File Input -->
                <input
                    type="file"
                    class="hidden"
                    ref="photo"
                    @change="updatePhotoPreview"
                >

                <jet-label
                    for="photo"
                    value="Photo"
                />

                <!-- Current Profile Photo -->
                <div
                    class="mt-2"
                    v-show="! photoPreview"
                >
                    <img
                        :src="user.profile_photo_url"
                        alt="Current Profile Photo"
                        class="rounded-full h-20 w-20 object-cover"
                    >
                </div>

                <!-- New Profile Photo Preview -->
                <div
                    class="mt-2"
                    v-show="photoPreview"
                >
                    <span
                        class="block rounded-full w-20 h-20"
                        :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'"
                    >
                    </span>
                </div>

                <jet-secondary-button
                    class="mt-2 mr-2"
                    type="button"
                    @click.native.prevent="selectNewPhoto"
                >
                    Select A New Photo
                </jet-secondary-button>

                <jet-secondary-button
                    type="button"
                    class="mt-2"
                    @click.native.prevent="deletePhoto"
                    v-if="user.profile_photo_path"
                >
                    Remove Photo
                </jet-secondary-button>

                <jet-input-error
                    :message="form.error('photo')"
                    class="mt-2"
                />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label
                    for="name"
                    value="姓名"
                />
                <jet-input
                    id="name"
                    type="text"
                    class="mt-1 block w-full shadow-none"
                    v-model="form.name"
                    disabled
                />
                <!-- <jet-input-error
                    :message="form.error('name')"
                    class="mt-2"
                /> -->
            </div>

            <!-- Student ID -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label
                    for="sud_id"
                    value="學號"
                />
                <jet-input
                    id="sud_id"
                    type="text"
                    class="mt-1 block w-full shadow-none"
                    value="406410232"
                    disabled
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label
                    for="sud_id"
                    value="系級"
                />
                <jet-input
                    id="sud_id"
                    type="text"
                    class="mt-1 block w-full shadow-none"
                    value="資訊工程學系(日) 四年級 B 班"
                    disabled
                />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label
                    for="email"
                    value="Email"
                />
                <jet-input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                />
                <jet-input-error
                    :message="form.error('email')"
                    class="mt-2"
                />
            </div>
        </template>

        <template #actions>
            <jet-action-message
                :on="form.recentlySuccessful"
                class="mr-3"
            >
                已儲存
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
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    photo: null,
                }, {
                    bag: 'updateProfileInformation',
                    resetOnSuccess: false,
                }),

                photoPreview: null,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    preserveScroll: true,
                    meow: "123",
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
