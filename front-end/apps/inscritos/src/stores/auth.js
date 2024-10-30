import { defineStore } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export const useAuthStore = defineStore('auth', () => {

	const router = useRouter()

	const user = ref({})
	const userData = ref({})
	const permisos = ref([])
	const roles = ref([])
	const loading = ref(false)
	const errors = ref([])

	const login = () => {
		
		loading.value = true
		
		axios.post('login',user.value)
		.then(response => {
			user.value = JSON.parse(atob(response.data))
			userData.value = user.value.empleado
			roles.value = user.value.roles
			
			permisos.value = roles.value.map(role => role.permisos.map(permiso => permiso.nombre)).flat(Infinity)
			permisos.value = Array.from(new Set(permisos.value))
			
			localStorage.setItem('direccion_id',userData.value.di_direccion_id)
			localStorage.setItem('escuelas',user.value.escuelas)
			
			if(user.value.escuelas) {
				router.push({ name: 'Escuelas' })
			}else{
				router.push({ name: 'Edit' })
			}
		})
		.catch(error => {
			if(error.response.data.errors) {
				errors.value = error.response.data.errors
			}else {
				errors.value = error.response.data.message
			}
		})
		.finally(() => loading.value = false)
		

	}
	
	const validateAuth = () => {
		axios.post('me')
		.then(response =>{
			user.value = JSON.parse(atob(response.data))
			userData.value = user.value.empleado
			localStorage.setItem('direccion_id',userData.value.di_direccion_id)
			roles.value = user.value.roles
			permisos.value = roles.value.map(role => role.permisos.map(permiso => permiso.nombre)).flat(Infinity)
			permisos.value = Array.from(new Set(permisos.value))
		}) 		
		.catch(error => {
			resetData()
			router.push({name:'Login'})
		})
	}

	const resetData = () => {
		user.value = {}
		userData.value = {}
		roles.value = []
		permisos.value = []
		errors.value = []
	}

	const logout = () => {
		axios.post('logout')
		localStorage.removeItem('direccion_id')
		localStorage.removeItem('escuelas')
		resetData()
		router.push({name:'Login'})
	}

	const checkPermission = (el) => {
		for (var key in permisos.value) {
			if (permisos.value.hasOwnProperty(key)) {
				var value = permisos.value[key];

				if (value === el) {
					return true;
				}

				if (typeof value === 'object' && checkPermission(el)) {
					return true;
				}
			}
		}

		return false;
	}

	return {
		user,
		userData,
		permisos, 
		errors,
		loading,

		login,
		logout,
		validateAuth,
		checkPermission,
	}
})
