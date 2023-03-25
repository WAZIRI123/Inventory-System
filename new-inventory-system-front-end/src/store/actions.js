import axiosClient from "../axios";



export function createemployee({ commit }, employee) {
    return axiosClient.post('/employees', employee)
}
export function updateemployee({ commit }, employee) {
    return axiosClient.put(`/employees/${employee.id}`, employee)
}
export function deleteemployee({ commit }, employee) {
    return axiosClient.delete(`/employees/${employee.id}`)
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
export function getemployee({ commit }, id) {
    return axiosClient.get(`/employees/${id}`)
}

export function createproduct({ commit }, product) {
    return axiosClient.post('/products', product)
}
export function getproduct({ commit }, id) {
    return axiosClient.get(`/products/${id}`)
}


export function updateproduct({ commit }, product) {
    return axiosClient.put(`/products/${product.id}`, product)
}


export function deleteproduct({ commit }, product) {
    return axiosClient.delete(`/products/${product.id}`)
}

export function createvendor({ commit }, vendor) {
    return axiosClient.post('/vendors', vendor)
}
export function updatevendor({ commit }, vendor) {
    return axiosClient.put(`/vendors/${vendor.id}`, vendor)
}
export function getvendors({ commit, state }, { url = null, search = '', per_page, sort_field, sort_direction } = {}) {
    commit('setvendors', [true])
    url = url || '/vendors'
    const params = {
        per_page: state.vendors.limit,
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
            commit('setvendors', [false, response.data])
            return response
        })
        .catch(() => {
            commit('setvendors', [false])
        })
}
export function getvendor({ commit }, id) {
    return axiosClient.get(`/vendors/${id}`)
}
export function deletevendor({ commit }, vendor) {
    return axiosClient.delete(`/vendors/${vendor.id}`)
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
export function createsale({ commit }, sale) {
    return axiosClient.post('/sales', sale)
}

export function updatesale({ commit }, sale) {
    return axiosClient.put(`/sales/${sale.id}`, sale)
}

export function getproductsForSale({ commit }, sale) {
    return axiosClient.get('/create-sale')
}

export function getsale({ commit }, id) {
    return axiosClient.get(`/sales/${id}`)
}

export function getReports({ commit, state }, { url = null, search = '', per_page, sort_field, sort_direction, dateFrom, dateTo }) {
    commit('setsales', [true])
    const params = {
        per_page: state.products.limit,
    }
    return axiosClient.get(`/sale-report`, {
            params: {
                ...params,
                search,
                per_page,
                sort_field,
                sort_direction,
                dateFrom,
                dateTo
            }

        })
        .then((response) => {

            commit('setsales', [false, response.data])

            return response

        })
        .catch(() => {
            commit('setsales', [false])
        })

}
export function deletesale({ commit }, sale) {
    return axiosClient.delete(`/sales/${sale.id}`)
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
            return response
        })
        .catch(() => {
            commit('setproducts', [false])
        })
}
export function getUser({ commit }, id) {
    return axiosClient.get(`/profile/${id}`)
        .then(res => {
            commit('setUser', res.data.user)
        })
}
//password-update
export function saveUser({ commit }, user) {
    return axiosClient.put('/update', user)
        .then(({ data }) => {
            commit('setUser', data.user);
            return data;
        })
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