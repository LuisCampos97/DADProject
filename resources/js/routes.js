/*jshint esversion: 6 */

import ItemList from './components/ItemList.vue';
import Login from './components/auth/Login.vue';
import Logout from './components/auth/Logout.vue';
import Dashboard from './components/Dashboard.vue';
import Profile from './components/Profile.vue';

const routes = [{
        path: '/',
        component: ItemList,
        name: 'home'
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/logout',
        component: Logout,
        name: 'logout',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/dashboard',
        component: Dashboard,
        name: 'dashboard',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/profile',
        component: Profile,
        name: 'profile',
        meta: {
            requiresAuth: true
        }
    }
];

export default routes;
