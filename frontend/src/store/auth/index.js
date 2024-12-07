import auth from './auth'

export default {
    namespaced: true,

    state() {
        return {
            user: [],
            token: [],
            lifetime: 0,
        };
    },
    actions: {
        async fetchUser({commit}) {
            if ($cookies.get("my_token")) {
                await auth.get("api/user").then(res => {
                    commit("setUser", res.data.data);
                }).catch(err => {
                    toast.error("Nastala chyba");
                });
            }
        },

        refresh(data) {
            return Vue.auth.refresh(data);
        },

        async login({commit},form) {
            await auth.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,
            });

            return await auth.post(`/api/my-login`, form, {
                withCredentials: true,
            }).then(res => {
                if (res.status === 200) {
                    commit('setUser', res.data.user);
                    commit('setToken', res.data.success.token);

                    return "success";
                }
                if (res.status === 401) {
                    return "unauthorize"
                }
                return "fuck";
            }).catch(err => {
                return err
            });
        },

        async getUser({commit, state}) {
            const token = state.token;
            const data = await auth.get('/api/user', {
                headers: {
                    "Content-Type": "application/json",
                    "Authentication": `Bearer${token}`
                }
            });
            console.log(data);
        },

        register(ctx, data) {
            data = data || {};

            return new Promise((resolve, reject) => {
                Vue.auth.register({
                    url: 'auth/register',
                    data: data.body,
                    autoLogin: false,
                })
                    .then((res) => {
                        if (data.autoLogin) {
                            ctx.dispatch('login', data).then(resolve, reject);
                        }
                    }, reject);
            });
        },

        impersonate(ctx, data) {
            var props = this.getters['properties/data'];

            Vue.auth.impersonate({
                url: 'auth/' + data.user._id + '/impersonate',
                redirect: 'user-account'
            });
        },

        unimpersonate(ctx) {
            Vue.auth.unimpersonate({
                redirect: 'admin-users'
            });
        },

        logout(ctx) {
            return Vue.auth.logout();
        },
    },

    getters: {
        getUser: state => {
            return state.user;
        },
        getToken: state => {
            return state.token;
        }
    },
    mutations: {
        setUser(state, val) {
            state.user = val;
        },
        setToken(state, val) {
            state.token = val;
        },
        setLifetime(state, val) {
            state.lifetime = val;
        }
    }
}