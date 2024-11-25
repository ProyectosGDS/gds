import { createRouter, createWebHistory } from 'vue-router'
import Layout from '../layouts/Default.vue'
import UnAuthorize from '../views/401.vue'
import NotFound from '../views/404.vue'
import { useAuthStore } from '../stores/auth'



const router = createRouter({
	history: createWebHistory(import.meta.env.VITE_MY_BASE),
	routes: [
		{
			path: '/',
			name: '',
			component: Layout,
			children: [
				{
					path: 'escuelas',
					name: 'Escuelas',
					component: () => import('@/views/escuelas/Escuelas.vue'),
					meta: {
						auth : true
					}
				},
				{
					path :'editar/:escuela_id?',
					name : 'Edit',
					component : () => import('@/views/escuelas/Edit.vue'),
					meta: {
						auth : false
					},
					props : true
				},
				{
					path :'inscripciones',
					name : 'Inscripciones',
					component : () => import('@/views/inscripciones/Inscripciones.vue'),
					meta : {
						auth : false
					}
				},
				{
					path :'catalogos',
					name : 'Catalogos',
					component : () => import('@/views/catalogos/Catalogos.vue'),
					redirect : { name : 'Programas'} ,
					children : [
						{
							path :'programas',
							name : 'Programas',
							component : () => import('@/views/catalogos/Programas.vue'),
							meta: {
								auth : false
							}
						},
						{
							path :'niveles',
							name : 'Niveles',
							component : () => import('@/views/catalogos/Niveles.vue'),
							meta: {
								auth : false
							}
						},
						{
							path :'secciones',
							name : 'Secciones',
							component : () => import('@/views/catalogos/Secciones.vue'),
							meta: {
								auth : false
							}
						},
						{
							path :'cursos',
							name : 'Cursos',
							component : () => import('@/views/catalogos/Cursos.vue'),
							meta: {
								auth : false
							}
						},
						{
							path :'instructores',
							name : 'Instructores',
							component : () => import('@/views/catalogos/Instructores.vue'),
							meta: {
								auth : false
							}
						},
						{
							path :'horarios',
							name : 'Horarios',
							component : () => import('@/views/catalogos/Horarios.vue'),
							meta: {
								auth : false
							}
						},
						{
							path :'sedes',
							name : 'Sedes',
							component : () => import('@/views/catalogos/Sedes.vue'),
							meta: {
								auth : false
							}
						},
						{
							path :'portafolio',
							name : 'Portafolio',
							component : () => import('@/views/catalogos/Portafolio.vue'),
							meta: {
								auth : false
							}
						},
					]
				},
				
			]
		},
		{
			path: '/login',
			name: 'Login',
			component : () => import('@/views/Login.vue') 
		},
		{
			path: '/401',
			name: '401',
			component: UnAuthorize,
		},
		{
			//MANEJA TODAS LAS PAGINAS QUE NO EXISTEN Y LA REDIRIJE AL 404 NOT FOUND
			path: '/:catchAll(.*)',
			component: NotFound,
		}
	]
})

router.beforeEach((to, from) => {

	const auth = useAuthStore()	
		
	if(!(document.cookie.split('=')[0] === 'access_token') && to.name != 'Login') {
		return { name : 'Login' }
	}

	if(to.meta.auth) {
		const hasPermission = auth.permisos.includes(to.name);
		console.log(auth.permisos)
		if (!hasPermission) {

			return { name : 'Login'};
		}
	}

	return true
	  
})

export default router
