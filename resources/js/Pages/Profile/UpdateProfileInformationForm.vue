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
            <!-- <div
                class="col-span-6 sm:col-span-4"
                v-if="$page.props.jetstream.managesProfilePhotos"
            >

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
                    :message="form.errors.photo"
                    class="mt-2"
                />
            </div> -->

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="姓名" />
                <jet-input
                    id="name"
                    type="text"
                    class="mt-1 block w-full shadow-none"
                    v-model="form.name"
                    :disabled="user.role !== 'admin'"
                />
            </div>

            <!-- Student ID -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label
                    for="username"
                    :value="user.role === 'admin' ? '帳號' : '學號'"
                />
                <jet-input
                    id="username"
                    type="text"
                    class="mt-1 block w-full shadow-none"
                    v-model="form.username"
                    disabled
                />
            </div>

            <div class="col-span-6 sm:col-span-4" v-if="user.role !== 'admin'">
                <jet-label for="sud_id" value="系級" />
                <jet-input
                    id="sud_id"
                    type="text"
                    class="mt-1 block w-full shadow-none"
                    :value="user.school_class.class_name"
                    disabled
                />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>

            <!-- License Confirm -->
            <div
                class="col-span-6 sm:col-span-4"
                v-if="user.role === 'student'"
            >
                <jet-label for="license"
                    >淡江智慧收付平台資料填寫確認
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                icon
                                x-small
                                elevation="1"
                                class="mb-1"
                                v-bind="attrs"
                                v-on="on"
                                @click="help = true"
                            >
                                <v-icon>mdi-help-circle-outline</v-icon>
                            </v-btn>
                        </template>
                        <span>點擊顯示幫助。</span>
                    </v-tooltip>
                </jet-label>
                <v-checkbox
                    v-model="form.filled_pay_form"
                    persistent-hint
                    hint="(請登入「淡江智慧收付平台」，至「您的資料」進行填寫。)"
                    :readonly="form.filled_pay_form"
                >
                    <template v-slot:label>
                        <div>
                            本人已填寫
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <a
                                        target="_blank"
                                        href="https://finfo.ais.tku.edu.tw/pmt/"
                                        @click.stop
                                        v-on="on"
                                    >
                                        淡江智慧收付平台
                                    </a>
                                </template>
                                請登入後，至「您的資料」進行填寫。
                            </v-tooltip>
                            之基本資料與金融帳戶。
                        </div>
                    </template>
                </v-checkbox>
                <!-- payment_check_status -->
                <jet-label
                    for="payment_check_status"
                    v-show="form.filled_pay_form"
                >
                    淡江智慧收付平台資料查核狀態：
                    <span
                        :class="
                            payment_check_status_colors[
                                user.payment_check_status
                            ]
                        "
                    >
                        {{
                            payment_check_status_contents[
                                user.payment_check_status
                            ]
                        }}
                    </span>
                </jet-label>
            </div>
            <v-dialog v-model="help" max-width="820">
                <v-card>
                    <v-card-title>
                        <v-icon large>mdi-help-circle-outline</v-icon
                        ><span class="ml-3">幫助</span>
                    </v-card-title>
                    <v-card-text class="font-weight-bold">
                        <ol
                            class="mt-2 body-1 font-weight-bold"
                            style="list-style: decimal;"
                        >
                            <li>
                                請確實填寫「出納組付款查詢平台」之基本資料與金融帳戶，以利於本服務日後進行保證金還款作業。
                            </li>
                            <li>
                                金融帳號資料建議填寫個人之郵局金融帳戶。
                            </li>
                        </ol>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="help = false">
                            關閉
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
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
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton
    },

    props: ["user"],

    data() {
        return {
            help: false,
            form: this.$inertia.form(
                {
                    _method: "PUT",
                    name: this.user.name,
                    email: this.user.email,
                    username: this.user.username,
                    filled_pay_form: this.user.filled_pay_form,
                    photo: null
                },
                {
                    bag: "updateProfileInformation",
                    resetOnSuccess: false
                }
            ),
            payment_check_status_contents: ["查核中", "未通過", "通過"],
            payment_check_status_colors: [
                "orange--text",
                "red--text",
                "green--text text--accent--3"
            ],

            photoPreview: null
        };
    },

    methods: {
        updateProfileInformation() {
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0];
            }

            this.form.post(route("user-profile-information.update"), {
                preserveScroll: true
            });
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },

        updatePhotoPreview() {
            const reader = new FileReader();

            reader.onload = e => {
                this.photoPreview = e.target.result;
            };

            reader.readAsDataURL(this.$refs.photo.files[0]);
        },

        deletePhoto() {
            this.$inertia
                .delete(route("current-user-photo.destroy"), {
                    preserveScroll: true
                })
                .then(() => {
                    this.photoPreview = null;
                });
        },
        help_cancel() {
            this.help = false;
        }
    }
};
</script>
