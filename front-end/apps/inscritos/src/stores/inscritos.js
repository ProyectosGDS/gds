import { defineStore } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'

export const useInscritosStore = defineStore('inscritos', () => {
    
    const headers = [
        { title : 'cui', key : 'persona.cui' },
        { title : 'inscrito', key : 'persona.fullname', class : 'uppercase' },
        { title : 'programa', key : 'portafolio.programa.nombre' },
        { title : 'curso', key : 'portafolio.curso.nombre' },
        { title : 'fecha incripcion', key : 'created_at', type : 'date' },
        { title : 'estado', key : 'persona.status.nombre', class : 'uppercase' },
        { title : '', key : 'actions' },
    ]

    const inscritos = ref([])
    const inscrito = ref({})
    const loading = ref(false)
    const errors = ref([])

    function fetch () {
        loading.value = true
        axios.get('inscripciones/index')
        .then(response => inscritos.value = response.data)
        .catch(error => console.error(error.response.data))
        .finally(() => loading.value = false)
    }

    return {

        headers,
        inscritos,
        inscrito,
        loading,
        errors,
        
        fetch,
    }
})
