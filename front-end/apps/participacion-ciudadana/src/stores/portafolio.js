import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from './global'

export const usePortafolioStore = defineStore('portafolio', () => {

    const global = useGlobalStore()

    const direcciones = ref([])
    const portafolios = ref([])
    const portafolio = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openDetails = ref(true)
    const openModalView = ref(false)
 
    function fetch () { 
        loading.value = true

        axios.get('portafolio/index')
        .then(response => portafolios.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    function fetchDirecciones () {
        loading.value = true
        axios.get('direcciones/index')
        .then(response => direcciones.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    const store = () => {
        loading.value = true
        axios.post('portafolio/store',portafolio.value)
        .then(response => {
            
            if(response.data.status == 'ok'){
                global.setAlert(response.data.message,'success')
                resetData()
            }else {
                global.setAlert(response.data.message,'danger')
            }

            fetch()
        })
        .catch(error => {
            if(error.response.data.errors){
                errors.value = error.response.data.errors
            }else{
                global.setAlert(error.response.data,'danger')
            }
        })
        .finally(() => loading.value = false)
    }

    const edit = (item) => {
        portafolio.value = item
        openDetails.value = false
    }
    const destroy = () => {
        loading.value = true
        axios.post(`portafolio/destroy`,portafolio.value)
        .then(response => {
            fetch()
            global.setAlert(response.data,'success')
            resetData()
        })
        .catch(error => {
            global.setAlert(error.response.data,'danger')
        })
        .finally(() => loading.value = false)
    }

    const resetData = () => {
        portafolio.value = {}
        errors.value = []
        openDetails.value = false
        openModalView.value = false
    }

    return {
        direcciones,
        portafolios,
        portafolio,
        loading,
        errors,
        openDetails,
        openModalView,


        fetch,
        fetchDirecciones,
        store,
        edit,
        destroy,
        resetData,

    }
});
