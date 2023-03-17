import { createRouter, createWebHistory } from "vue-router";

import store from "../store";

const router = createRouter({
    history: createWebHistory(
        import.meta.env.VITE_API_BASE_URL),
    routes: [{
            path: "/",
            name: "home",
            meta: {
                requiresAuth: true
            },
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () =>
                import ("../components/AppLayout.vue"),

            children: [

                {
                    path: 'dashboard',
                    name: 'dashboard',
                    // route level code-splitting
                    // this generates a separate chunk (About.[hash].js) for this route
                    // which is lazy-loaded when the route is visited.
                    component: () =>
                        import ("../views/HomeView.vue"),
                },

                {
                    path: '/product',
                    name: 'product',
                    meta: {
                        requiresAuth: true
                    },
                    component: () =>
                        import ("../views/Product/TableView.vue"),
                },

                {
                    path: 'products/create',
                    name: 'products.create',
                    component: () =>
                        import ("../views/Product/ProductView.vue"),
                },

                {
                    path: 'products/:id',
                    name: 'products.view',
                    component: () =>
                        import ("../views/Product/ProductView.vue"),
                },

                {
                    path: '/sale',
                    name: 'sale',
                    meta: {
                        requiresAuth: true
                    },
                    component: () =>
                        import ("../views/Sale/TableView.vue"),
                },

                {
                    path: 'sales/:id',
                    name: 'sales.view',
                    component: () =>
                        import ("../views/Sale/SaleView.vue"),
                },

                {
                    path: 'sales/create',
                    name: 'sales.create',
                    component: () =>
                        import ("../views/sale/SaleView.vue"),
                },
                {
                    path: '/employee',
                    name: 'employee',
                    meta: {
                        requiresAuth: true
                    },
                    component: () =>
                        import ("../views/Employee/TableView.vue"),
                },
                {
                    path: 'employees/:id',
                    name: 'employees.view',
                    component: () =>
                        import ("../views/Employee/EmployeeView.vue"),
                },

                {
                    path: 'employees/create',
                    name: 'employees.create',
                    component: () =>
                        import ("../views/Employee/EmployeeView.vue"),
                },
                {
                    path: '/vendor',
                    name: 'vendor',
                    meta: {
                        requiresAuth: true
                    },
                    component: () =>
                        import ("../views/Vendor/TableView.vue"),
                },
                {
                    path: 'vendors/create',
                    name: 'vendors.create',
                    component: () =>
                        import ("../views/Vendor/VendorView.vue"),
                },


                {
                    path: 'vendors/:id',
                    name: 'vendors.view',
                    component: () =>
                        import ("../views/Vendor/VendorView.vue"),
                },


                {
                    path: 'profile:id',
                    name: 'profile',
                    // route level code-splitting
                    // this generates a separate chunk (About.[hash].js) for this route
                    // which is lazy-loaded when the route is visited.
                    component: () =>
                        import ("../views/ProfileView.vue"),
                },
            ]

        },

        {
            path: '/reset-link-view',
            name: 'ResetLinkView',
            component: () =>
                import ("../views/ResetLinkView.vue"),
        },


        {
            path: '/reset-password',
            name: 'NewPassword',
            component: () =>
                import ("../views/NewPasswordView.vue"),
        },

        {
            path: '/:pathMatch(.*)',
            name: 'NotFound',
            component: () =>
                import ("../views/NotFound.vue"),
        },

        {
            path: "/login",
            name: "login",
            meta: {
                requiresGuest: true
            },
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () =>
                import ("../views/LoginView.vue"),
        },
    ],
});


router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: "login" });
    } else if (store.state.user.token && to.meta.isGuest) {
        next({ name: "home" });
    } else {
        next();
    }
});
export default router;