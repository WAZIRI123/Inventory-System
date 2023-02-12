import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },
        employees: {
            data: [],
            meta: {}
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
        surveys: {
            loading: false,
            links: [],
            data: []
        },
        currentSurvey: {
            data: {},
            loading: false,
        },
        questionTypes: ["text", "select", "radio", "checkbox", "textarea"],
        notification: {
            show: false,
            type: 'success',
            message: ''
        }
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
        fetchEmployees({ commit }, page = 1) {
            return axiosClient.get(`employees?page=${page}`)
                .then(({ data }) => {

                    commit('setEmployees', data);

                    return data;
                })

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

        getSurveys({ commit }, { url = null } = {}) {
            commit('setSurveysLoading', true)
            url = url || "/survey";
            return axiosClient.get(url).then((res) => {
                commit('setSurveysLoading', false)
                commit("setSurveys", res.data);
                return res;
            });
        },
        getSurvey({ commit }, id) {
            commit("setCurrentSurveyLoading", true);
            return axiosClient
                .get(`/survey/${id}`)
                .then((res) => {
                    commit("setCurrentSurvey", res.data);
                    commit("setCurrentSurveyLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSurveyLoading", false);
                    throw err;
                });
        },
        getSurveyBySlug({ commit }, slug) {
            commit("setCurrentSurveyLoading", true);
            return axiosClient
                .get(`/survey-by-slug/${slug}`)
                .then((res) => {
                    commit("setCurrentSurvey", res.data);
                    commit("setCurrentSurveyLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSurveyLoading", false);
                    throw err;
                });
        },
        saveSurvey({ commit, dispatch }, survey) {
            delete survey.image_url;

            let response;
            if (survey.id) {
                response = axiosClient
                    .put(`/survey/${survey.id}`, survey)
                    .then((res) => {
                        commit('setCurrentSurvey', res.data)
                        return res;
                    });
            } else {
                response = axiosClient.post("/survey", survey).then((res) => {
                    commit('setCurrentSurvey', res.data)
                    return res;
                });
            }

            return response;
        },
        deleteSurvey({ dispatch }, id) {
            return axiosClient.delete(`/survey/${id}`).then((res) => {
                dispatch('getSurveys')
                return res;
            });
        },
        saveSurveyAnswer({ commit }, { surveyId, answers }) {
            return axiosClient.post(`/survey/${surveyId}/answer`, { answers });
        },
    },
    mutations: {
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem("TOKEN");
        },
        setEmployees: (state, data) => {
            state.employees.data = data.data;
            state.employees.meta = data.meta;
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
        setSurveysLoading: (state, loading) => {
            state.surveys.loading = loading;
        },
        setSurveys: (state, surveys) => {
            state.surveys.links = surveys.meta.links;
            state.surveys.data = surveys.data;
        },
        setCurrentSurveyLoading: (state, loading) => {
            state.currentSurvey.loading = loading;
        },
        setCurrentSurvey: (state, survey) => {
            state.currentSurvey.data = survey.data;
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