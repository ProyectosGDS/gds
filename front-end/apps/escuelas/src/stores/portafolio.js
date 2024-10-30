import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from './global'

export const usePortafolioStore = defineStore('portafolio', () => {

    const global = useGlobalStore()

    const headers = [
        { title : 'curso', key : 'curso.nombre'},
        { title : 'sede', key : 'programa.escuela.nombre' },
        { title : 'ubicación', key : 'programa.escuela.direccion', class : 'truncate' },
        { title : 'modalidad', key : 'modalidad' },
        { title : 'horario', key : 'horario' },
        { title : 'nivel', key : 'nivel.nombre' },
        { title : '', key : 'actions', width : '10px' },
    ]

    const portafolios = ref([])
    const portafolio = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openModalView = ref(false)
    const openModalNew = ref(false)
    const openModalEdit = ref(true)
    const openModalDelete = ref(false)
 
    const fetch = () => {
        loading.value = true

        axios.get('portafolio/index')
        .then(response => portafolios.value = response.data)
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
        openModalEdit.value = false
    }

    const update = () => {
        loading.value = true
        axios.put(`portafolio/update`,{
            llave : portafolio.value,
            data : portafolioEdit.value
        })
        .then(response => {
            fetch()
            global.setAlert(response.data,'success')
            resetData()
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

    const deleteItem = (item) => {
        portafolio.value = item
        openModalDelete.value = true
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
        openModalView.value = false
        openModalNew.value = false
        openModalEdit.value = false
        openModalDelete.value = false
    }

    return {
        headers,
        portafolios,
        portafolio,
        loading,
        errors,
        openModalNew,
        openModalEdit,
        openModalDelete,
        openModalView,

        fetch,
        store,
        edit,
        update,
        deleteItem,
        destroy,
        resetData,

    }
});
