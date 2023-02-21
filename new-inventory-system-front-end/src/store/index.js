import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },
        employees: {
            loading: false,
            data: [],
            links: [],
            from: null,
            to: null,
            page: 1,
            limit: null,
            total: null
        },

        toast: {
            show: false,
            message: '',
            delay: 5000
        },

        dashboard: {
            loading: false,
            data: {}
        },

    },
    getters: {},
    actions: {
        //password-update
        saveUser({ commit }, user) {
            return axiosClient.put('/update', user)
                .then(({ data }) => {
                    commit('setUser', data.user);
                    return data;
                })
        },
        createemployee({ commit }, employee) {
            return axiosClient.post('/employees', employee)
        },
        updateemployee({ commit }, employee) {
            return axiosClient.put(`/employees/${employee.id}`, employee)
        },
        deleteitem({ commit }, employee) {
            return axiosClient.delete(`/employees/${employee.id}`)
        },

        getitems({ commit, state }, { url = null, search = '', per_page, sort_field, sort_direction } = {}) {
            commit('setitems', [true])
            url = url || '/employees'
            const params = {
                per_page: state.employees.limit,
            }
            return axiosClient.get(url, {
                    params: {
                        ...params,
                        search,
                        per_page,
                        sort_field,
                        sort_direction
                    }
                })
                .then((response) => {
                    commit('setitems', [false, response.data])
                })
                .catch(() => {
                    commit('setitems', [false])
                })
        },
        getemployee({ commit }, id) {
            return axiosClient.get(`/employees/${id}`)
        },
        updatePassword({ commit }, user) {
            return axiosClient.put('/password-update', user)
                .then(({ data }) => {
                    commit('setUser', data.user);
                    return data;
                })
        },
        sendResetPasswordLinkAction({ commit }, user) {

            return axiosClient.post('/password-reset-link', user)

            .then(({ data }) => {
                return data;
            })
        },

        login({ commit }, user) {

            return axiosClient.post('/login', user)

            .then(({ data }) => {
                commit('setUser', data.user);
                commit('setToken', data.token);
                return data;
            })
        },
        logout({ commit }) {
            return axiosClient.post('/logout')
                .then(response => {
                    commit('logout')
                    return response;
                })
        },
        getUser({ commit }, id) {
            return axiosClient.get(`/profile/${id}`)
                .then(res => {
                    commit('setUser', res.data.user)

                })
        },
        getDashboardData({ commit }) {
            commit('dashboardLoading', true)
            return axiosClient.get(`/dashboard`)
                .then((res) => {
                    commit('dashboardLoading', false)
                    commit('setDashboardData', res.data)
                    return res;
                })
                .catch(error => {
                    commit('dashboardLoading', false)
                    return error;
                })

        },


    },
    mutations: {
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem("TOKEN");
        },
        setitems(state, [loading, data = null]) {

            if (data) {
                state.employees = {
                    ...state.employees,
                    data: data.data,
                    links: data.meta.links,
                    page: data.meta.current_page,
                    limit: data.meta.per_page,
                    from: data.meta.from,
                    to: data.meta.to,
                    total: data.meta.total,
                }
            }
            state.employees.loading = loading;
        },

        hideToast: (state) => {
            state.toast.show = false;
            state.toast.message = '';
        },
        showToast: (state, message) => {
            state.toast.show = true;
            state.toast.message = message;
        },

        setUser: (state, user) => {

            state.user.data = user;
        },

        setToken: (state, token) => {
            state.user.token = token;
            sessionStorage.setItem('TOKEN', token);
        },
        dashboardLoading: (state, loading) => {
            state.dashboard.loading = loading;
        },
        setDashboardData: (state, data) => {
            state.dashboard.data = data
        },

        notify: (state, { message, type }) => {
            state.notification.show = true;
            state.notification.type = type;
            state.notification.message = message;
            setTimeout(() => {
                state.notification.show = false;
            }, 3000)
        },
    },
    modules: {},
});

export default store;