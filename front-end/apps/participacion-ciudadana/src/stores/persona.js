import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from './global'
import { usePortafolioStore } from './portafolio'

export const usePersonaStore = defineStore('persona', () => {
    
    const global = useGlobalStore()
    const portafolio = usePortafolioStore()

    const persona = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openModalNew = ref(false)

    function store () {
        persona.value.portafolio_id = portafolio.portafolio.id
        loading.value = true
        axios.post('pre-inscripcion',persona.value)
        .then(response => {
            
            if(response.data.status == 'ok') {
                global.setAlert(response.data.message,'success')
                resetData()
            } else {
                global.setAlert(response.data.message,'danger')
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

    function resetData() {
        openModalNew.value = false
        persona.value = {}
        errors.value = []
    }

    return {
        persona,
        loading,
        errors,
        openModalNew,

        store,
        resetData,
    }
})