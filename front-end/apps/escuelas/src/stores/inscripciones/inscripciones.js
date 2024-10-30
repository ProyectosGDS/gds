import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useInscripcionesStore = defineStore('inscripciones', () => {
    
    const datos = ref({
            sexo : 'h',
            departamento_id : 7,
            municipio_id : 1
    })

    const catalogos = ref({
        etnias : [],
        departamentos : [],
        municipios : [],
        zonas : [],
        gruposHabitacionales : [],
    })

    const errors = ref([])
    const loading = ref({
        etnias : false, 
        departamentos : false, 
        munipios : false, 
        zonas : false, 
        gruposHabitacionales : false, 
    })

    function fetchDepartamentos () {
        loading.value.departamentos = true
        axios.get('departamentos')
        .then(response => catalogos.value.departamentos = response.data)
        .catch(error => console.error(error.response.data))
        .finally(() => loading.value.departamentos = false)
    }

    function fetchMunicipios () {
        loading.value.municipios = true
        axios.get('municipios')
        .then(response => catalogos.value.municipios = response.data)
        .catch(error => console.error(error.response.data))
        .finally(() => loading.value.municipios = false)
    }

    function fetchZonas () {
        loading.value.zonas = true
        axios.get('zonas')
        .then(response => catalogos.value.zonas = response.data)
        .catch(error => console.error(error.response.data))
        .finally(() => loading.value.zonas = false)
    }

    function fetchGruposHabitacionales () {
        loading.value.gruposHabitacionales = true
        axios.get('grupos-habitacionales')
        .then(response => catalogos.value.gruposHabitacionales = response.data)
        .catch(error => console.error(error.response.data))
        .finally(() => loading.value.gruposHabitacionales = false)
    }

    function fetchEtnias () {
        loading.value.etnias = true
        axios.get('etnias')
        .then(response => catalogos.value.etnias = response.data)
        .catch(error => console.error(error.response.data))
        .finally(() => loading.value.etnias = false)
    }

    return {
        datos,
        catalogos,
        errors,
        loading,

        fetchDepartamentos,
        fetchMunicipios,
        fetchZonas,
        fetchGruposHabitacionales,
        fetchEtnias,
    }
})
