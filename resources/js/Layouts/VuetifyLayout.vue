<template>
    <v-app>
        <v-main>
            <!-- navbar -->
            <v-app-bar app elevation="2" color="white" fixed>
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
                        <span class="title">學士服借用系統</span>
                    </v-toolbar-title>
                </div>
                <v-btn
                    v-for="link in leftLinks"
                    :key="`${link.label}-left-link`"
                    color="gray"
                    text
                    rounded
                    class="ml-2 bottom hidden-sm-and-down text-decoration-none"
                    :href="route(link.url)"
                    :class="{ 'v-btn--active': route().current(link.url) }"
                    v-if="link.role.indexOf($page.props.user.role) >= 0"
                >
                    <v-icon left v-show="link.icon">{{ link.icon }}</v-icon>
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
                    :class="{ 'v-btn--active': route().current(link.url) }"
                    v-if="link.role.indexOf($page.props.user.role) >= 0"
                >
                    <v-icon left>{{ link.icon }}</v-icon>
                    {{ link.label }}
                </v-btn>
                <v-menu offset-y left min-width="200">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-bind="attrs"
                            v-on="on"
                            color="gray"
                            text
                            class="ml-2 hidden-sm-and-down text-decoration-none"
                        >
                            {{ $page.props.user.name
                            }}<v-icon right>{{ "mdi-menu-down" }}</v-icon>
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
                                <v-icon left>{{ link.icon }}</v-icon>
                                {{ link.label }}
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item
                            class="text-decoration-none"
                            link
                            @click.prevent="logout"
                        >
                            <v-list-item-title>
                                <v-icon left>{{ "mdi-logout" }}</v-icon>
                                {{ "登出" }}
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
                                    {{
                                        $page.props.user.name
                                            ? $page.props.user.name
                                            : "訪客"
                                    }}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{
                                        $page.props.user.username
                                            ? $page.props.user.username
                                            : "Owooooooooo"
                                    }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-avatar>
                                <v-btn icon>
                                    <v-icon
                                        color="grey"
                                        @click.stop="sidebar = !sidebar"
                                        >mdi-close-thick</v-icon
                                    >
                                </v-btn>
                            </v-list-item-avatar>
                        </v-list-item>

                        <v-divider></v-divider>

                        <!-- 首頁 雖然只有一個item ㄏㄏ-->
                        <v-list-item
                            v-for="link in leftLinks.slice(0, 1)"
                            :key="`${link.label}-drawer-left-link`"
                            :href="route(link.url)"
                            class="text-decoration-none"
                            color="primary"
                            :class="{
                                'v-btn--active': route().current(link.url)
                            }"
                            v-if="link.role.indexOf($page.props.user.role) >= 0"
                        >
                            <v-list-item-icon>
                                <v-icon v-text="link.icon" />
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title v-text="link.label" />
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider></v-divider>

                        <!-- 訂單管理 -->
                        <v-list-group
                            prepend-icon="mdi-format-list-bulleted-type"
                            no-action
                        >
                            <template v-slot:activator>
                                <v-list-item-title>訂單管理</v-list-item-title>
                            </template>
                            <v-list-item
                                v-for="link in leftLinks.slice(1)"
                                :key="`${link.label}-drawer-left-link`"
                                :href="route(link.url)"
                                class="text-decoration-none"
                                color="primary"
                                :class="{
                                    'v-btn--active': route().current(link.url)
                                }"
                                v-if="
                                    link.role.indexOf($page.props.user.role) >=
                                        0
                                "
                            >
                                <v-list-item-content>
                                    <v-list-item-title v-text="link.label" />
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>

                        <v-divider></v-divider>

                        <!-- 系統設定 -->
                        <v-list-item
                            v-for="link in rightLinks"
                            :key="`${link.label}-drawer-right-link`"
                            :href="route(link.url)"
                            class="text-decoration-none"
                            color="primary"
                            :class="{
                                'v-btn--active': route().current(link.url)
                            }"
                            v-if="link.role.indexOf($page.props.user.role) >= 0"
                        >
                            <v-list-item-icon>
                                <v-icon v-text="link.icon" />
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title v-text="link.label" />
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider></v-divider>

                        <!-- 帳號管理 -->
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
                                :class="{
                                    'v-btn--active': route().current(link.url)
                                }"
                            >
                                <v-list-item-title>
                                    <v-icon left>{{ link.icon }}</v-icon
                                    >{{ link.label }}
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                class="text-decoration-none"
                                link
                                @click.prevent="logout"
                            >
                                <v-list-item-title>
                                    <v-icon left>{{ "mdi-logout" }}</v-icon>
                                    {{ "登出" }}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                    </v-list>
                </v-navigation-drawer>
            </v-app-bar>

            <!-- main page -->
            <v-container class="py-5">
                <v-card min-height="87vh" class="pb-10">
                    <v-card-title
                        class="title font-weight-bold mx-auto px-sm-6 px-lg-8"
                    >
                        <slot name="header"></slot>
                    </v-card-title>
                    <v-divider class="mx-5 v-divider-bold" />
                    <div class="md:px-5 sm:px-2">
                        <slot></slot>
                    </div>
                </v-card>
            </v-container>
            <v-footer
                dark
                padless
                class="w-full bg-gray-800 text-white mt-5 my-0"
            >
                <div
                    class="w-full px-10 px-xl-16 px-lg-12 px-md-8 px-sm-4 pb-5"
                >
                    <div
                        class="w-full pt-12 flex flex-col sm:flex-row space-y-2  justify-start"
                    >
                        <div
                            class="w-full sm:w-1/2 pr-6 flex flex-col space-y-4"
                        >
                            <div class="md:text-3xl sm:text-2xl text-xl">
                                總務處事務整備組：
                            </div>
                            <p class="opacity-60">
                                上班時間：星期一至星期五 上午8:00~12:00
                                下午1:00~5:00
                            </p>
                            <p class="opacity-60">
                                電話：(02)2621-5656 / 0919-585656 轉 2275
                            </p>
                            <p class="opacity-60">
                                地址：25137新北市淡水區英專路151號
                                守謙會議中心HC308室
                            </p>
                        </div>
                        <div
                            class="w-full sm:w-1/2 flex flex-col space-y-4 sm:pt-0"
                        >
                            <div class="md:text-3xl sm:text-2xl text-xl">
                                網頁維護及個資聯絡窗口：
                            </div>
                            <p class="opacity-60">
                                本網頁由事務整備組黃慶文先生負責維護，個資保護聯絡窗口為賴文經專員；若您有任何問題及意見，歡迎來信批評指教。
                            </p>
                            <p class="opacity-60">
                                聯絡信箱：<a
                                    href="mailto:agox@oa.tku.edu.tw"
                                    class="orange--text text--lighten-3"
                                    >agox@oa.tku.edu.tw</a
                                >
                            </p>
                        </div>
                    </div>
                    <hr class="mt-5" />
                    <div
                        class="w-full pt-5 flex flex-col sm:flex-row space-y-2  justify-start"
                    >
                        <div class="w-full pr-6 flex flex-col space-y-4">
                            <p class="opacity-60">
                                本網站著作權屬於淡江大學總務處，請詳見。
                                <a
                                    href="https://www.tku.edu.tw/privacy.asp"
                                    class="orange--text text--lighten-3"
                                    target="_blank"
                                    >隱私權政策</a
                                >
                                │
                                <a
                                    href="https://www.tku.edu.tw/pdp.asp"
                                    class="orange--text text--lighten-3"
                                    target="_blank"
                                    >個資政策</a
                                >
                                │
                                <a
                                    href="https://www.tku.edu.tw/notify.asp"
                                    class="orange--text text--lighten-3"
                                    target="_blank"
                                    >個人資料告知聲明</a
                                >
                            </p>
                            <p class="opacity-60">
                                建議最佳瀏覽 Google Chrome / Mozilla Firefox /
                                Edge 或相容 W3C 網頁標準之最新版瀏覽器。
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full bg-gray-600 xl:px-20 lg:px-10 md:px-5 sm:px-3 px-5"
                >
                    <div class="opacity-60 pt-5 text-center">
                        <p>
                            Copyright © 2020-{{ year }} ALL RIGHTS RESERVED BY
                            TAMKANG UNIVERSITY OFFICE OF INFORMATION SERVICES.
                        </p>
                    </div>
                </div>
            </v-footer>
        </v-main>
        <v-dialog v-model="license_check" persistent max-width="500">
            <v-card>
                <v-card-title>
                    <v-icon color="red" large>
                        mdi-alert-octagon-outline
                    </v-icon>
                    <span class="ml-3">系統通知</span>
                </v-card-title>
                <v-card-text
                    class="font-weight-bold"
                    v-if="!this.$page.props.user.filled_pay_form"
                >
                    系統發現您尚未確認已填寫「淡江智慧收付平台」之基本資料與金融帳戶，請填寫完畢並且在「使用者設定
                    > 使用者資訊」勾選確認。
                </v-card-text>

                <v-card-text class="font-weight-bold" v-else>
                    淡江智慧收付平台資料查核尚未通過，若還在查核中請耐心等候，若為未通過請確認淡江智慧收付平台是否資料有誤。
                    <br />
                    當前查核狀態：<span
                        :class="
                            payment_check_status_colors[
                                this.$page.props.user.payment_check_status
                            ]
                        "
                    >
                        {{
                            payment_check_status_contents[
                                this.$page.props.user.payment_check_status
                            ]
                        }}
                    </span>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" :href="route('profile.show')">
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
            helloworld: "helloworld",
            showingNavigationDropdown: false,
            leftLinks: [
                {
                    label: "首頁",
                    url: "admin.home",
                    icon: "mdi-home",
                    role: ["admin"]
                },
                {
                    label: "管理",
                    url: "admin.order",
                    icon: "mdi-format-list-bulleted-type",
                    role: ["admin"]
                },
                {
                    label: "付款",
                    url: "admin.paying",
                    icon: "",
                    role: ["admin"]
                },
                {
                    label: "領取",
                    url: "admin.receive",
                    icon: "",
                    role: ["admin"]
                },
                {
                    label: "歸還",
                    url: "admin.return",
                    icon: "",
                    role: ["admin"]
                },
                {
                    label: "還款",
                    url: "admin.refund",
                    icon: "",
                    role: ["admin"]
                },
                {
                    label: "修改",
                    url: "admin.fix_order",
                    icon: "",
                    role: ["admin"]
                },
                {
                    label: "我的訂單",
                    url: "student.myorder",
                    icon: "mdi-format-list-bulleted-type",
                    role: ["student"]
                },
                {
                    label: "新增訂單",
                    url: "student.order",
                    icon: "mdi-cart-plus ",
                    role: ["student"]
                }
            ],
            rightLinks: [
                {
                    label: "系統設定",
                    url: "admin.setting",
                    icon: "mdi-cog",
                    role: ["admin"]
                }
            ].reverse(),
            menuLinks: [
                {
                    label: "個人設定",
                    url: "profile.show", // 在 vendor 裡面有 定義
                    icon: "mdi-account-cog-outline"
                }
            ],
            payment_check_status_contents: ["查核中", "未通過", "通過"],
            payment_check_status_colors: [
                "orange--text",
                "red--text",
                "green--text text--accent--3"
            ]
        };
    },

    methods: {
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id
                },
                {
                    preserveState: false
                }
            );
        },

        logout() {
            axios.post(route("logout").url()).then(response => {
                window.location = "/";
            });
        },
        cancel() {
            this.license_check = false;
        },
        check() {
            if (this.$page.props.user.role === "student") {
                if (this.$inertia.page.url !== "/user/profile") {
                    if (
                        // 有勾且有通過
                        this.$page.props.user.filled_pay_form &&
                        this.$page.props.user.payment_check_status == 2
                    ) {
                        this.license_check = false;
                    } else {
                        this.license_check = true;
                    }
                }
            }
        }
    },
    mounted() {
        this.check();
    },
    computed: {
        year() {
            return this.$moment().year();
        }
    }
};
</script>
<style src="vuetify/dist/vuetify.min.css" />
