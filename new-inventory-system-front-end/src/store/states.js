export default {
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

    products: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
    },

    vendors: {
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
        delay: 5000,
        type: 'success'
    },

    dashboard: {
        loading: false,
        data: {}
    },

}