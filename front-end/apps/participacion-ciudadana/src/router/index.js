import { createRouter, createWebHistory } from 'vue-router'
import NotFound from '../views/404.vue'
import Layout from '@/layouts/Default.vue' 


const router = createRouter({
	history: createWebHistory(import.meta.env.VITE_MY_BASE),
	routes: [
		{
			path: '/',
			name: 'Participacion ciudadana',
			component: Layout,
			redirect : { name : 'Cursos libres'},
			children : [
				{
					path: 'cursos',
					name: 'Cursos libres',
					component: () => import('@/views/participacion/Cursos.vue'),
				},
				{
					path: 'eventos',
					name: 'Eventos',
					component: () => import('@/views/participacion/Eventos.vue'),
				},
				{
					path: 'servicios',
					name: 'Servicios',
					component: () => import('@/views/participacion/Servicios.vue'),
				},
				
			]
		},
		{
			//MANEJA TODAS LAS PAGINAS QUE NO EXISTEN Y LA REDIRIJE AL 404 NOT FOUND
			path: '/:catchAll(.*)',
			component: NotFound,
		}
	]
})

export default router
