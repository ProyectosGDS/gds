import { defineStore } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'
import { useGlobalStore } from './global'

export const useRegisterStore = defineStore('register', () => {


    const global = useGlobalStore()

    const etnias = ref([])
    const direcciones = ref([])

    const empleado = ref({})
    const loading = ref(false)
    const errors = ref([])

    function store () {
        loading.value = true
        axios.post('register',empleado.value)
        .then(response => {
            if(response.status === 'ok'){
                global.setAlert(response.data.message,'success')
            }else {
                global.setAlert(response.data.message,'danger')
            }
        })
        .catch(error => {
            // errors.value = error.response.data.errors
            console.error(error.response.data)
        })
        .finally(() => loading.value = false)
    }

    function fetchEtnias () {
        axios.get('etnias')
        .then(response =>  etnias.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    function fetchDirecciones () {
        axios.get('direcciones/index')
        .then(response =>  direcciones.value = response.data)
        .catch(error => console.error(error.response.data))
    }
    
    return {
        
        direcciones,
        etnias,

        empleado,
        loading,
        errors,

        store,
        fetchDirecciones,
        fetchEtnias
    }
})
