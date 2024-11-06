import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useInscripcionStore = defineStore('inscripcion', () => {
    
    const datos = ref({
        pais_id : 1,
        departamento_id : 7,
        municipio_id : 1,
    })

    const openModal = ref({
        form : false,
        alert : false
    })

    function resetData () {
        datos.value = {
            pais_id : 1,
            departamento_id : 7,
            municipio_id : 1,
        }

        openModal.value = {
            form : false,
            alert : false,
        }
    }

    return {
        datos,
        openModal,

        resetData,
    }
})
