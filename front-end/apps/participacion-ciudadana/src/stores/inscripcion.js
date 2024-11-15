import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useInscripcionStore = defineStore('inscripcion', () => {
    
    const datos = ref({
        pais_id : 1,
        departamento_id : 7,
        municipio_id : 1,
        sexo : 'F',
        lugar_nacimiento : 'Ciudad Guatemala',
        etnia_id : 4,
        grupo_habitacional_id : 7,
        responsable : {
            sexo : 'F',
        },
        emergencia : {
            sexo : 'F',
        },
    })

    const cui = ref('')
    const success = ref(false)

    const catalogos = ref([])
    const camposRegistro = ref([])

    const openModal = ref({
        form : false,
        alert : false
    })

    const loading = ref({
        searchBeneficiario : false
    })

    const errors = ref([])

    function resetData () {
        datos.value = {
            pais_id : 1,
            departamento_id : 7,
            municipio_id : 1,
            sexo : 'F',
            lugar_nacimiento : 'Ciudad Guatemala',
            etnia_id : 4,
            grupo_habitacional_id : 7,
            responsable : {
                sexo : 'F',
            },
            emergencia : {
                sexo : 'F',
            },
        }

        openModal.value = {
            form : false,
            alert : false,
        }
        cui.value = ''
        errors.value = []
        success.value = false
    }

    function fetchCatalogos () {
        axios.get('catalogos')
        .then(response => sessionStorage.setItem('catalogos',JSON.stringify(response.data)))
        .catch(error => console.error(error))
    }

    function changePais () {
        if(datos.value.hasOwnProperty('pais_id')) {
            axios.get(`paises/${datos.value.pais_id}`)
            .then(response => catalogos.value.departamentos = response.data.departamentos)
            .catch(error => console.error(error.response.data))
        }
    }

    function changeDepartamento () {
        if(datos.value.hasOwnProperty('departamento_id')) {
            axios.get(`departamentos/${datos.value.departamento_id}`)
            .then(response => catalogos.value.municipios = response.data.municipios)
            .catch(error => console.error(error.response.data))
        }
    }

    async function fetchBeneficiarioUnico (cui) {
        try {
            
            loading.value.searchBeneficiario = true
            const response = await axios.post('consulta-beneficiario-unico',{cui : cui})
            updatePropertyDatos(response.data)
            errors.value = []
        } catch (error) {
            console.error(error)
        }finally{
            loading.value.searchBeneficiario = false
        }
    }

    function updatePropertyDatos (newData){
        Object.assign(datos.value,newData)
    }

    function modal (item) {
        datos.value.di_direccion_id = item.programa.di_direccion_id
        openModal.value.form = true 
    }

    async function store () {
        try {
            const response = await axios.post('inscripcion',datos.value)
            console.log(response.data)

        } catch (error) {
            if(error.response.data.hasOwnProperty('errors')){
                errors.value = error.response.data.errors
            }
        }
    }

    

    return {
        datos,
        cui,
        openModal,
        errors,
        catalogos,
        camposRegistro,
        loading,
        success,

        resetData,
        modal,
        fetchCatalogos,
        changePais,
        changeDepartamento,
        fetchBeneficiarioUnico,
        store,
    }
})
