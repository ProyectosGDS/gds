import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from '../global'

export const useProgramasStore = defineStore('programas', () => {

    const global = useGlobalStore()

    const headers = [
        { title : 'id', key : 'id' },
        { title : 'nombre', key : 'nombre' },
        { title : 'escuela', key : 'escuela.nombre' },
        { title : 'status', key : 'deleted_at', align : 'center' },
        { title : '', key : 'actions', width : '10px' },
    ]

    const programas = ref([])
    const programa = ref({})
    const loading = ref(false)
    const errors = ref([])

    const openModalNew = ref(false)
    const openModalEdit = ref(false)
    const openModalView = ref(false)
    const openModalDelete = ref(false)

 
    const fetch = (escuela_id = '') => {

        loading.value = true

        const url = (escuela_id != '') ? `programas/index/${localStorage.getItem('direccion_id')}/${escuela_id}` : `programas/index/${localStorage.getItem('direccion_id')}`

        axios.get(url)
        .then(response => programas.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    const store = () => {
        loading.value = true
        programa.value.di_direccion_id = localStorage.getItem('direccion_id')
        axios.post('programas/store',programa.value)
        .then(response => {
            
            if(response.data.status == 'ok'){
                global.setAlert(response.data.message,'success')
                fetch()
                resetData()
            }else {
                global.setAlert(response.data.message,'danger')
            }

            fetch(escuela_id)
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

    const view = (item) => {
        programa.value = item
        openModalView.value = true
    }

    const edit = (item) => {
        programa.value = item
        openModalEdit.value = true
    }

    const update = () => {
        loading.value = true
        axios.put(`programas/update/${programa.value.id}`,programa.value)
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
        programa.value = item
        openModalDelete.value = true
    }


    const destroy = () => {
        loading.value = true
        axios.delete(`programas/destroy/${programa.value.id}`)
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
        programa.value = {}
        errors.value = []

        openModalNew.value = false
        openModalEdit.value = false
        openModalView.value = false
        openModalDelete.value = false
    }


    return {
        headers,
        programas,
        programa,
        loading,
        errors,
        openModalNew,
        openModalEdit,
        openModalView,
        openModalDelete,

        fetch,
        view,
        store,
        edit,
        update,
        deleteItem,
        destroy,
        resetData,

    }
})
