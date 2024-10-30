import { defineStore } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'
import { useGlobalStore } from '../global'

export const useSeccionesStore = defineStore('secciones', () => {

    const global = useGlobalStore()

    const headers = [
        { title : 'id', key : 'id' },
        { title : 'seccion', key : 'nombre' },
        { title : 'status', key : 'deleted_at', align : 'center' },
        { title : '', key : 'actions', width : '10px' },
    ]

    const secciones = ref([])
    const seccion = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openModalNew = ref(false)
    const openModalEdit = ref(false)
    const openModalDelete = ref(false)
 
    const fetch = () => {
        loading.value = true

        axios.get('secciones/index')
        .then(response => secciones.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    const show = (seccion_id,nivel_id,programa_id) => {
        axios.get(`secciones/show/${seccion_id}/${nivel_id}/${programa_id}`)
        .then(response => seccion.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    const store = () => {
        loading.value = true
        axios.post('secciones/store',seccion.value)
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
        seccion.value = item
        openModalEdit.value = true
    }

    const update = () => {
        loading.value = true
        axios.put(`secciones/update/${seccion.value.id}`,seccion.value)
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
        seccion.value = item
        openModalDelete.value = true
    }

    const destroy = () => {
        loading.value = true
        axios.delete(`secciones/destroy/${seccion.value.id}`)
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
        seccion.value = {}
        errors.value = []
        openModalNew.value  = false
        openModalEdit.value  = false
        openModalDelete.value  = false
    }

    return {
        headers,
        secciones,
        seccion,
        loading,
        errors,
        openModalNew,
        openModalEdit,
        openModalDelete,

        fetch,
        show,
        store,
        edit,
        update,
        deleteItem,
        destroy,
        resetData,

    }
});
