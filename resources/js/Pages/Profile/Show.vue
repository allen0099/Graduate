<template>
    <VuetifyLayout>
        <template #header>
            個人資料
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                <update-profile-information-form :user="$page.props.user" />

                <jet-section-border />

                <update-password-form class="mt-10 sm:mt-0" />

                <!-- <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                    <jet-section-border />

                    <two-factor-authentication-form class="mt-10 sm:mt-0" />
                </div> -->

                <jet-section-border />

                <logout-other-browser-sessions-form
                    :sessions="sessions"
                    class="mt-10 sm:mt-0"
                />

                <!-- <jet-section-border /> -->

                <!-- <delete-user-form class="mt-10 sm:mt-0" /> -->
            </div>
        </div>
    </VuetifyLayout>
</template>

<script>
    // VuetifyLayout AppLayout
    import VuetifyLayout from '@/Layouts/VuetifyLayout'
    import DeleteUserForm from './DeleteUserForm'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
    import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
    import UpdatePasswordForm from './UpdatePasswordForm'
    import UpdateProfileInformationForm from './UpdateProfileInformationForm'

    export default {
        props: ['sessions'],

        components: {
            VuetifyLayout,
            DeleteUserForm,
            JetSectionBorder,
            LogoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm
        },
    }

</script>
