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