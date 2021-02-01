<template>
    <v-app>
        <v-main>
            <!-- navbar -->
            <v-app-bar
                app
                elevation="2"
                color="white"
                fixed
            >

                <!-- desktop navbar -->
                <div class="d-flex align-center">
                    <v-img
                        alt="Logo"
                        class="shrink mr-4"
                        contain
                        src="/asset/Tamkang_University_logo.svg.png"
                        transition="scale-transition"
                        width="50"
                    />
                    <v-toolbar-title
                        class="shrink"
                        transition="scale-transition"
                    >
                        <span class="title">淡江大學總務處</span>
                        <v-spacer />
                        <span class="title">學士服出租系統</span>
                    </v-toolbar-title>
                </div>
                <v-btn
                    v-for="(link) in leftLinks"
                    :key="`${link.label}-left-link`"
                    color="gray"
                    text
                    rounded
                    class="ml-2 bottom hidden-sm-and-down text-decoration-none"
                    :href="route(link.url)"
                    :class="{'v-btn--active': route().current(link.url)}"
                    v-if="link.role.indexOf($page.user.role) >= 0"
                >
                    <v-icon
                        left
                        v-show="link.icon"
                    >{{ link.icon }}</v-icon>
                    {{ link.label }}
                </v-btn>
                <v-spacer />

                <v-btn
                    v-for="link in rightLinks"
                    :key="`${link.label}-right-link`"
                    color="gray"
                    text
                    rounded
                    class="ml-2 hidden-sm-and-down text-decoration-none"
                    :href="route(link.url)"
                    :class="{'v-btn--active': route().current(link.url)}"
                    v-if="link.role.indexOf($page.user.role) >= 0"
                >
                    <v-icon left>{{ link.icon }}</v-icon>
                    {{ link.label }}
                </v-btn>
                <v-menu
                    offset-y
                    left
                    min-width="200"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-bind="attrs"
                            v-on="on"
                            color="gray"
                            text
                            class="ml-2 hidden-sm-and-down text-decoration-none"
                        >
                            {{$page.user.name}}<v-icon right>{{ 'mdi-menu-down' }}</v-icon>
                        </v-btn>
                    </template>
                    <v-list class="hidden-sm-and-down">
                        <v-subheader>帳號管理</v-subheader>
                        <v-list-item
                            v-for="(link, index) in menuLinks"
                            :key="`${link.label}-menu-link`"
                            :href="route(link.url)"
                            class="text-decoration-none"
                        >
                            <v-list-item-title>
                                <v-icon left>{{ link.icon }}</v-icon> {{ link.label }}
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item
                            class="text-decoration-none"
                            link
                            @click.prevent="logout"
                        >
                            <v-list-item-title>
                                <v-icon left>{{ 'mdi-logout' }}</v-icon> {{ '登出' }}
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <!-- mobile navbar -->
                <v-app-bar-nav-icon
                    class="hidden-md-and-up"
                    @click.stop="sidebar = !sidebar"
                >
                </v-app-bar-nav-icon>

                <v-navigation-drawer
                    class="hidden-lg-and-up"
                    v-model="sidebar"
                    clipped
                    hide-overlay
                    temporary
                    light
                    right
                    width="300"
                    app
                >

                    <v-list nav>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="title">
                                    {{$page.user.name? $page.user.name : "訪客"}}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ $page.user.username? $page.user.username : "Owooooooooo" }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-avatar>
                                <v-btn icon>
                                    <v-icon
                                        color="grey"
                                        @click.stop="sidebar = !sidebar"
                                    >mdi-close-thick</v-icon>
                                </v-btn>
                            </v-list-item-avatar>
                        </v-list-item>

                        <v-divider></v-divider>

                        <v-list-item
                            v-for="link in leftLinks"
                            :key="`${link.label}-drawer-left-link`"
                            :href="route(link.url)"
                            class="text-decoration-none"
                            color="primary"
                            :class="{'v-btn--active': route().current(link.url)}"
                            v-if="link.role.indexOf($page.user.role) >= 0"
                        >
                            <v-list-item-icon>
                                <v-icon v-text="link.icon" />
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title v-text="link.label" />
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider></v-divider>

                        <v-list-item
                            v-for="link in rightLinks"
                            :key="`${link.label}-drawer-right-link`"
                            :href="route(link.url)"
                            class="text-decoration-none"
                            color="primary"
                            :class="{'v-btn--active': route().current(link.url)}"
                            v-if="link.role.indexOf($page.user.role) >= 0"
                        >
                            <v-list-item-icon>
                                <v-icon v-text="link.icon" />
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title v-text="link.label" />
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider></v-divider>

                        <v-list-group
                            prepend-icon="mdi-account-circle"
                            no-action
                        >
                            <template v-slot:activator>
                                <v-list-item-title>帳號管理</v-list-item-title>
                            </template>
                            <v-list-item
                                v-for="(link, index) in menuLinks"
                                :key="`${link.label}-drawer-menu-link`"
                                :href="route(link.url)"
                                class="text-decoration-none"
                                :class="{'v-btn--active': route().current(link.url)}"
                            >
                                <v-list-item-title>
                                    <v-icon left>{{ link.icon }}</v-icon>{{ link.label }}
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                class="text-decoration-none"
                                link
                                @click.prevent="logout"
                            >
                                <v-list-item-title>
                                    <v-icon left>{{ 'mdi-logout' }}</v-icon> {{ '登出' }}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                    </v-list>
                </v-navigation-drawer>
            </v-app-bar>

            <!-- main page -->
            <v-container class="py-5">
                <v-card
                    min-height="87vh"
                    class="pb-10"
                >
                    <v-card-title class="title font-weight-bold mx-auto px-sm-6 px-lg-8">
                        <slot name="header"></slot>
                    </v-card-title>
                    <v-divider class="mx-5 v-divider-bold" />
                    <div class="md:px-5 sm:px-2">
                        <slot></slot>
                    </div>
                </v-card>
            </v-container>

            <!-- footer -->
            <v-footer
                id="footer"
                class="d-block py-0"
                color="grey darken-4"
                dark
            >
                <!-- hidden when xs -->
                <v-container class="text-center d-none d-sm-flex">
                    <v-row>
                        <v-col cols="12">
                            <div class="mb-2">
                                Copyright &copy; 2020-{{ (new Date()).getFullYear() }} 淡江大學版權所有
                            </div>
                            <div class="mb-2">
                                本網站建議使用 Chrome、FireFox 瀏覽器瀏覽
                            </div>
                            <a
                                class="grey--text text--lighten-1"
                                href="https://www.tku.edu.tw/privacy.asp"
                                rel="noopener"
                                target="_blank"
                            >
                                隱私政策
                            </a>

                            &nbsp;•&nbsp;

                            <a
                                class="grey--text text--lighten-1"
                                href="https://www.tku.edu.tw/pdp.asp"
                                rel="noopener"
                                target="_blank"
                            >
                                個資政策
                            </a>

                            &nbsp;•&nbsp;

                            <a
                                class="grey--text text--lighten-1"
                                href="http://www.ipc.tku.edu.tw/"
                                rel="noopener"
                                target="_blank"
                            >
                                個資保護聯絡窗口
                            </a>
                            <div class="mt-5">
                                地址：251301 新北市淡水區英專路151號 &nbsp;•&nbsp; 電話：+886-2-2621-5656
                            </div>
                        </v-col>
                    </v-row>
                </v-container>

                <!-- show when xs -->
                <v-container class="text-center d-flex d-sm-none">
                    <v-row>
                        <v-col cols="12">
                            <div class="mb-2">
                                Copyright &copy; 2020-{{ (new Date()).getFullYear() }} 淡江大學版權所有
                            </div>
                            <div class="mb-2">
                                建議使用 Chrome、FireFox 瀏覽器瀏覽
                            </div>
                            <a
                                class="grey--text text--lighten-1"
                                href="https://www.tku.edu.tw/privacy.asp"
                                rel="noopener"
                                target="_blank"
                            >
                                隱私政策
                            </a>

                            &nbsp;•&nbsp;

                            <a
                                class="grey--text text--lighten-1"
                                href="https://www.tku.edu.tw/pdp.asp"
                                rel="noopener"
                                target="_blank"
                            >
                                個資政策
                            </a>

                            &nbsp;•&nbsp;

                            <a
                                class="grey--text text--lighten-1"
                                href="http://www.ipc.tku.edu.tw/"
                                rel="noopener"
                                target="_blank"
                            >
                                個資保護聯絡窗口
                            </a>
                            <div class="mt-5">
                                地址：251301 新北市淡水區英專路151號
                            </div>
                            <div class="mt-2">
                                電話：+886-2-2621-5656
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </v-footer>
        </v-main>
        <v-dialog
            v-model="license_check"
            persistent
            max-width="500"
        >
            <v-card>
                <v-card-title>
                    <v-icon
                        color="red"
                        large
                    >mdi-alert-octagon-outline</v-icon><span class="ml-3">系統通知</span>
                </v-card-title>
                <v-card-text>
                    系統發現您尚未確認已填寫「出納付款查詢平台」之基本資料與金融帳戶，請填寫完畢並且在「使用者設定 > 使用者資訊」勾選確認。
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        :href="route('profile.show')"
                    >
                        前往設定
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                license_check: false,
                sidebar: false,
                helloworld: 'helloworld',
                showingNavigationDropdown: false,
                leftLinks: [{
                        label: '首頁',
                        url: 'admin.home',
                        icon: 'mdi-home',
                        role: ['admin'],
                    },
                    {
                        label: '訂單管理',
                        url: 'admin.order',
                        icon: 'mdi-format-list-bulleted-type',
                        role: ['admin'],
                    },
                    {
                        label: '付款',
                        url: 'admin.paying',
                        icon: '',
                        role: ['admin'],
                    },
                    {
                        label: '領取',
                        url: 'admin.receive',
                        icon: '',
                        role: ['admin'],
                    },
                    {
                        label: '歸還',
                        url: 'admin.return',
                        icon: '',
                        role: ['admin'],
                    },
                    {
                        label: '退款',
                        url: 'admin.refund',
                        icon: '',
                        role: ['admin'],
                    },
                    {
                        label: '我的訂單',
                        url: 'student.myorder',
                        icon: 'mdi-format-list-bulleted-type',
                        role: ['student'],
                    },
                    {
                        label: '新增訂單',
                        url: 'student.order',
                        icon: 'mdi-cart-plus ',
                        role: ['student'],
                    },
                ],
                rightLinks: [{
                    label: '系統設定',
                    url: 'admin.setting',
                    icon: 'mdi-cog',
                    role: ['admin'],
                }].reverse(),
                menuLinks: [{
                    label: '個人設定',
                    url: 'profile.show', // 在 vendor 裡面有 定義
                    icon: 'mdi-account-cog-outline',
                }, ],
                email: '',
                socials: [{
                        icon: 'mdi-reddit',
                        href: 'https://www.reddit.com/r/vuetifyjs',
                        title: 'Reddit',
                    },
                    {
                        icon: 'mdi-medium',
                        href: 'https://medium.com/vuetify',
                        title: 'Medium',
                    },
                    {
                        icon: 'mdi-github-circle',
                        href: 'https://github.com/vuetifyjs/vuetify',
                        title: 'Github',
                    },
                    {
                        icon: 'mdi-twitter',
                        href: 'https://twitter.com/vuetifyjs',
                        title: 'Twitter',
                    },
                    {
                        icon: 'mdi-discord',
                        href: 'https://community.vuetifyjs.com',
                        title: 'Discord Community',
                    },
                ],
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                axios.post(route('logout').url()).then(response => {
                    window.location = '/';
                })
            },
            cancel() {
                this.license_check = false
            },
            check() {
                if (this.$page.user.role === 'student') {
                    if (this.$inertia.page.url !== '/user/profile') {
                        this.license_check = !this.$page.user.filled_pay_form
                    }
                }
            },
        },
        mounted() {
            this.check()
        },
    }

</script>
<style src="vuetify/dist/vuetify.min.css" />
