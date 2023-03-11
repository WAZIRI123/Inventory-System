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

    sales: {
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
        type: 'success',
        messages: '',
        delay: 5000,
    },

    dashboard: {
        loading: false,
        data: {}
    },

}