import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from '../global'

export const useNivelesStore = defineStore('niveles', () => {

    const global = useGlobalStore()

    const headers = [
        { title : 'id', key : 'id' },
        { title : 'nivel', key : 'nombre' },
        { title : 'status', key : 'deleted_at', align : 'center' },
        { title : '', key : 'actions', width : '10px' },
    ]

    const niveles = ref([])
    const nivel = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openModalView = ref(false)
    const openModalNew = ref(false)
    const openModalEdit = ref(false)
    const openModalDelete = ref(false)
 
    const fetch = () => {
        loading.value = true

        axios.get('niveles/index')
        .then(response => niveles.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    const store = () => {
        loading.value = true
        axios.post('niveles/store',nivel.value)
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

    const view = (nivel_id,programa_id) => {
        show(nivel_id,programa_id)
        openModalView.value = true
    }

    const show = (nivel_id, programa_id) => {
        loading.value = true
        axios.get(`niveles/show/${nivel_id}/${programa_id}`)
        .then(response => nivel.value = response.data)
        .catch(error => console.error(error.resposen.data))
    }

    const edit = (item) => {
        nivel.value = item
        openModalEdit.value = true
    }

    const update = () => {
        loading.value = true
        axios.put(`niveles/update/${nivel.value.id}`,nivel.value)
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
        nivel.value = item
        openModalDelete.value = true
    }

    const destroy = () => {
        loading.value = true
        axios.delete(`niveles/destroy/${nivel.value.id}`)
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
        nivel.value = {}
        errors.value = []
        openModalView.value = false
        openModalNew.value = false
        openModalEdit.value = false
        openModalDelete.value = false
    }

    return {
        headers,
        niveles,
        nivel,
        loading,
        errors,
        openModalNew,
        openModalEdit,
        openModalDelete,
        openModalView,

        fetch,
        view,
        show,
        store,
        edit,
        update,
        deleteItem,
        destroy,
        resetData,

    }
});
