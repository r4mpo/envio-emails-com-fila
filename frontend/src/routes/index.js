import { createRouter, createWebHistory } from 'vue-router';
import HomeTemplate from '../pages/HomeTemplate.vue';

const routes = [
    {
        path: '/home',
        name: 'Home',
        component: HomeTemplate
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;