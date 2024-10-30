import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useCatalogosStore = defineStore('catalogos', () => {
    
    const etnias = ref([])
    const zonas = ref([])
    const gruposHabitacionales = ref([])
    const paises = ref([])
    const departamentos = ref([])
    const municipios = ref([])
    const escolaridades = ref([])
    const tipoSangre = ref([])
    const enfermedades = ref([])
    const parentescos = ref([])


    function fetchEtnias () {
        axios.get('etnias')
        .then(response => etnias.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    function fetchZonas () {
        axios.get('zonas')
        .then(response => zonas.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    function fetchGruposHabitacionales () {
        axios.get('grupos-habitacionales')
        .then(response => gruposHabitacionales.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    function fetchPaises () {
        axios.get('paises')
        .then(response => paises.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    function fetchEscolaridades () {
        axios.get('escolaridades')
        .then(response => escolaridades.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    function fetchTipoSangre () {
        axios.get('tipo-sangre')
        .then(response => tipoSangre.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    function fetchEnfermedades () {
        axios.get('enfermedades')
        .then(response => enfermedades.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    function fetchParentescos () {
        axios.get('parentescos')
        .then(response => parentescos.value = response.data)
        .catch(error => console.error(error.response.data))
    }


    return {
        etnias,
        zonas,
        gruposHabitacionales,
        paises,
        departamentos,
        municipios,
        escolaridades,
        tipoSangre,
        enfermedades,
        parentescos,

        fetchEtnias,
        fetchZonas,
        fetchGruposHabitacionales,
        fetchPaises,
        fetchEscolaridades,
        fetchTipoSangre,
        fetchEnfermedades,
        fetchParentescos,

    }
})
