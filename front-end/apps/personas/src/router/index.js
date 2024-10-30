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
	
	if (to.meta.auth) {

		const hasPermission = auth.permisos.includes(to.name);

		if (!hasPermission) {

			return { name : 'Login'};
		}
	}
	return true
  
})

export default router
