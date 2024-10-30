import { defineStore } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'
import { useGlobalStore } from '../global'

export const useSedesStore = defineStore('sedes', () => {

    const global = useGlobalStore()

    const headers = [
        { title : 'id', key : 'id' },
        { title : 'sede', key : 'nombre' },
        { title : 'direccion', key : 'direccion' },
        { title : 'zona', key : 'zonas.numero' },
        { title : 'status', key : 'deleted_at', align : 'center' },
        { title : '', key : 'actions', width : '10px' },
    ]

    const sedes = ref([])
    const sede = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openModalNew = ref(false)
    const openModalEdit = ref(false)
    const openModalDelete = ref(false)
 
    const fetch = () => {
        loading.value = true

        axios.get('sedes/index')
        .then(response => sedes.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    const show = (sede_id,nivel_id,programa_id) => {
        axios.get(`sedes/show/${sede_id}/${nivel_id}/${programa_id}`)
        .then(response => sede.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    const store = () => {
        loading.value = true
        axios.post('sedes/store',sede.value)
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
        sede.value = item
        openModalEdit.value = true
    }

    const update = () => {
        loading.value = true
        axios.put(`sedes/update/${sede.value.id}`,sede.value)
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
        sede.value = item
        openModalDelete.value = true
    }

    const destroy = () => {
        loading.value = true
        axios.delete(`sedes/destroy/${sede.value.id}`)
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
        sede.value = {}
        errors.value = []
        openModalNew.value  = false
        openModalEdit.value  = false
        openModalDelete.value  = false
    }

    return {
        headers,
        sedes,
        sede,
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
