<template>
    <v-app>
        <v-main>
            <v-app-bar
                app
                elevation="2"
                color="white"
                fixed
            >

                <!-- desktop navbar -->
                <div class="d-flex align-center">
                    <v-img
                        alt="Vuetify Logo"
                        class="shrink mr-4"
                        contain
                        src="@/assets/logo.jpg"
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
                    v-for="(link) in links"
                    :key="`${link.label}-link`"
                    color="gray"
                    text
                    rounded
                    class=" my-2 ml-5 bottom hidden-sm-and-down text-decoration-none"
                    :href="route(link.url)"
                    :class="{'v-btn--active': route().current(link.url)}"
                >
                    <v-icon
                        left
                        v-show="link.icon"
                    >{{ link.icon }}</v-icon>
                    {{ link.label }}
                </v-btn>
                <v-spacer />

                <v-btn
                    v-for="link in login"
                    :key="`${link.label}-link`"
                    color="gray"
                    text
                    rounded
                    class="my-2 ml-5 hidden-sm-and-down text-decoration-none"
                    :href="route(link.url)"
                    :class="{'v-btn--active': route().current(link.url)}"
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
                            class="my-2 ml-5 hidden-sm-and-down text-decoration-none"
                        >
                            {{$page.user.name}}<v-icon right>{{ 'mdi-menu-down' }}</v-icon>
                        </v-btn>
                    </template>
                    <v-list class="hidden-sm-and-down">
                        <v-subheader>Manage Account</v-subheader>
                        <v-list-item
                            v-for="(link, index) in userlinks"
                            :key="index"
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
                                    {{ '406410232@s06.tku.edu.tw' }}
                                    <!-- {{$page.user.email? $page.user.email : "406410232@s06.tku.edu.tw"}} -->
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
                            v-for="link in links"
                            :key="`${link.label}-drawer-link`"
                            :href="route(link.url)"
                            class="text-decoration-none"
                            color="primary"
                            :class="{'v-btn--active': route().current(link.url)}"
                        >
                            <v-list-item-icon>
                                <v-icon v-text="link.icon" />
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title v-text="link.label" />
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider></v-divider>

                        <!-- <v-list-item
                            v-for="link in login"
                            :key="`${link.label}-drawer-link`"
                            :to="link.url"
                            class="text-decoration-none"
                            color="primary"
                            v-show="link.isLogin.indexOf(isLogin) >= 0"
                        >
                            <v-list-item-icon>
                                <v-icon>{{ link.icon }}</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ link.label }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item> -->
                        <v-list-group
                            prepend-icon="mdi-account-circle"
                            no-action
                        >
                            <template v-slot:activator>
                                <v-list-item-title>Users</v-list-item-title>
                            </template>
                            <v-list-item
                                v-for="(link, index) in userlinks"
                                :key="index"
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

            <v-container class="py-5">
                <v-card>
                    <v-card-title class="title font-weight-bold mx-auto px-sm-6 px-lg-8">
                        <slot name="header"></slot>
                    </v-card-title>
                    <v-divider class="mx-5 v-divider-bold" />
                    <slot></slot>
                </v-card>
            </v-container>
        </v-main>
    </v-app>

</template>

<script>
    export default {
        data() {
            return {
                sidebar: false,
                helloworld: 'helloworld',
                showingNavigationDropdown: false,
                outside_links: [{
                    label: '排班查詢系統',
                    url: 'http://agox.tku.edu.tw',
                    icon: 'mdi-launch ',
                }, ],
                links: [{
                        label: '月出勤',
                        url: 'meow',
                        icon: 'mdi-view-dashboard',
                        isLogin: ['user', 'admin'],
                    },
                    {
                        label: '編輯出勤資料',
                        url: 'dashboard',
                        icon: 'mdi-pencil-outline',
                        isLogin: ['admin'],
                    },
                    {
                        label: 'stu',
                        url: 'student.meow',
                        icon: 'mdi-pencil-outline',
                        isLogin: ['admin'],
                    }
                ],
                login: [{
                        label: '設定1',
                        url: 'meow',
                        icon: 'mdi-cog',
                        isLogin: ['admin'],
                    },
                    {
                        label: '設定',
                        url: 'admin.setting',
                        icon: 'mdi-cog',
                        isLogin: ['admin'],
                    }
                ].reverse(),
                userlinks: [{
                    label: '個人設定',
                    url: 'profile.show', // 在 vendor 裡面有 定義
                    icon: 'mdi-account-cog-outline',
                }, ]
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
        }
    }

</script>
<style src="vuetify/dist/vuetify.min.css" />
