import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useDomicilioResponbaleStore = defineStore('domicilio-responbale', () => {

    const data = ref({})
    const loading = ref(false)
    const errors = ref([])

    const paises = ref([])
    const departamentos = ref([])
    const municipios = ref([])

    function fetchPaises () {
        axios.get('paises')
        .then(response => paises.value = response.data)
        .catch(error => {
            errors.value = error.response.data
            console.error(error.response.data)
        })
    }

    function changePais () {
        axios.get(`paises/${data.value.pais_id}`)
        .then(response => departamentos.value = response.data.departamentos)
        .catch(error => console.error(error.response.data))
    }

    function changeDepartamento () {
        axios.get(`departamentos/${data.value.departamento_id}`)
        .then(response => municipios.value = response.data.municipios)
        .catch(error => console.error(error.response.data))
    }
    
    return {
        data,
        loading,
        errors,

        paises,
        departamentos,
        municipios,

        fetchPaises,
        changePais,
        changeDepartamento,
    }
})
