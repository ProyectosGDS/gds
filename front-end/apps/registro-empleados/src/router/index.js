import { createRouter, createWebHistory } from 'vue-router'
import NotFound from '../views/404.vue'


const router = createRouter({
	history: createWebHistory(import.meta.env.VITE_MY_BASE),
	routes: [
		{
			path : '/',
			name : 'Register',
			component : () => import('@/views/Register.vue'),
		},
		{
			//MANEJA TODAS LAS PAGINAS QUE NO EXISTEN Y LA REDIRIJE AL 404 NOT FOUND
			path: '/:catchAll(.*)',
			component: NotFound,
		}
	]
})

export default router
