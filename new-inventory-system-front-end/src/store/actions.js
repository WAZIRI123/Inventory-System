import axiosClient from "../axios";

//password-update
export function saveUser({ commit }, user) {
    return axiosClient.put('/update', user)
        .then(({ data }) => {
            commit('setUser', data.user);
            return data;
        })
}

export function createemployee({ commit }, employee) {
    return axiosClient.post('/employees', employee)
}

export function createproduct({ commit }, product) {
    return axiosClient.post('/products', product)
}

export function updateemployee({ commit }, employee) {
    return axiosClient.put(`/employees/${employee.id}`, employee)
}
export function updateproduct({ commit }, product) {
    return axiosClient.put(`/products/${product.id}`, product)
}
export function deleteemployee({ commit }, employee) {
    return axiosClient.delete(`/employees/${employee.id}`)
}

export function deleteproduct({ commit }, product) {
    return axiosClient.delete(`/products/${product.id}`)
}

export function getemployees({ commit, state }, { url = null, search = '', per_page, sort_field, sort_direction } = {}) {
    commit('setemployees', [true])
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
            commit('setemployees', [false, response.data])
        })
        .catch(() => {
            commit('setemployees', [false])
        })
}

export function getsales({ commit, state }, { url = null, search = '', per_page, sort_field, sort_direction } = {}) {
    commit('setsales', [true])
    url = url || '/sales'
    const params = {
        per_page: state.sales.limit,
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
            commit('setsales', [false, response.data])
        })
        .catch(() => {
            commit('setsales', [false])
        })
}

export function getproducts({ commit, state }, { url = null, search = '', per_page, sort_field, sort_direction } = {}) {
    commit('setproducts', [true])
    url = url || '/products'
    const params = {
        per_page: state.products.limit,
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
            commit('setproducts', [false, response.data])
        })
        .catch(() => {
            commit('setproducts', [false])
        })
}

export function getemployee({ commit }, id) {
    return axiosClient.get(`/employees/${id}`)
}

export function getvendors({ commit }) {
    return axiosClient.get(`/create-product`)
}

export function getproduct({ commit }, id) {
    return axiosClient.get(`/products/${id}`)
}

export function updatePassword({ commit }, user) {
    return axiosClient.put('/password-update', user)
        .then(({ data }) => {
            commit('setUser', data.user);
            return data;
        })
}
export function sendResetPasswordLinkAction({ commit }, user) {

    return axiosClient.post('/password-reset-link', user)

    .then(({ data }) => {
        return data;
    })
}

export function login({ commit }, user) {

    return axiosClient.post('/login', user)

    .then(({ data }) => {
        commit('setUser', data.user);
        commit('setToken', data.token);
        return data;
    })
}

export function logout({ commit }) {
    return axiosClient.post('/logout')
        .then(response => {
            commit('logout')
            return response;
        })
}
export function getUser({ commit }, id) {
    return axiosClient.get(`/profile/${id}`)
        .then(res => {
            commit('setUser', res.data.user)
        })
}
export function getDashboardData({ commit }) {
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

}