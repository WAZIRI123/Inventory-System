export function logout(state) {
    state.user.token = null;
    state.user.data = {};
    sessionStorage.removeItem("TOKEN");
}
export function setproducts(state, [loading, data = null]) {

    if (data) {
        state.products = {
            ...state.products,
            data: data.data,
            links: data.meta.links,
            page: data.meta.current_page,
            limit: data.meta.per_page,
            from: data.meta.from,
            to: data.meta.to,
            total: data.meta.total,
        }
    }
    state.products.loading = loading;
}

export function setemployees(state, [loading, data = null]) {

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
}

export function setvendors(state, [loading, data = null]) {

    if (data) {
        state.vendors = {
            ...state.vendors,
            data: data.data,
            links: data.meta.links,
            page: data.meta.current_page,
            limit: data.meta.per_page,
            from: data.meta.from,
            to: data.meta.to,
            total: data.meta.total,
        }
    }
    state.vendors.loading = loading;
}

export function setsales(state, [loading, data = null]) {

    if (data) {
        state.sales = {
            ...state.sales,
            data: data.data,
            links: data.meta.links,
            page: data.meta.current_page,
            limit: data.meta.per_page,
            from: data.meta.from,
            to: data.meta.to,
            total: data.meta.total,
        }
    }
    state.sales.loading = loading;
}



export function hideToast(state) {
    state.toast.show = false;
    state.toast.message = '';
}

export function showToast(state, {
    message,
    type = 'success'
}) {
    state.toast.show = true;
    state.toast.messages = message;
    state.toast.type = type;
    setTimeout(() => {
        state.toast.show = false;
    }, 3000)
}

export function setUser(state, user) {

    state.user.data = user;
}

export function setToken(state, token) {
    state.user.token = token;
    sessionStorage.setItem('TOKEN', token);
}
export function dashboardLoading(state, loading) {
    state.dashboard.loading = loading;
}
export function setDashboardData(state, data) {
    state.dashboard.data = data
}

export function notify(state, { message, type }) {
    state.notification.show = true;
    state.notification.type = type;
    state.notification.message = message;
    setTimeout(() => {
        state.notification.show = false;
    }, 3000)
}