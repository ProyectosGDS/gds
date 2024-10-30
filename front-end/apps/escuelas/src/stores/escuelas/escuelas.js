import { defineStore } from 'pinia';
import { ref } from 'vue'
import { useGlobalStore } from '../global'
import axios from 'axios'
import { useAuthStore } from '../auth'

export const useEscuelasStore = defineStore('escuelas', () => {

    const auth = useAuthStore()

    const headers = [
        { title : 'id', key: 'id' },
        { title : 'nombre', key: 'nombre' },
        { title : 'direccion', key: 'direccion' },
        { title : 'state', key: 'deleted_at', align : 'center' },
        { title : '', key: 'actions', width : '10px' },
    ]

    const global = useGlobalStore()

    const escuelas = ref([])
    const escuela = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openModalNew = ref(false)
    const openModalEdit = ref(false)
    const openModalDelete = ref(false)
 
    

    const fetch = () => {
        loading.value = true

        console.log();
        

        axios.get('escuelas/index')
        .then(response => escuelas.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    const fetchEscuela = (id) => {
        loading.value = true
        axios.get(`escuelas/show/${id}`)
        .then(response => {
            escuela.value = response.data
        })
        .catch(error => {
            if(error.response.data.errors) {
                errors.value = errors.response.data.errors
            }else {
                global.setAlert(error.response.data,'danger')
            }
        })
        .finally(() => loading.value = false)
    }

    const openNew = () => {
        resetData()
        openModalNew.value = true
    }

    const edit = (item) => {
        escuela.value = item
        openModalEdit.value = true
    }

    const store = () => {
        loading.value = true
        escuela.value.di_direccion_id = auth.userData.di_direccion_id
        axios.post('escuelas/store',escuela.value)
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

    const update = () => {
        loading.value = true
        axios.put(`escuelas/update/${escuela.value.id}`,escuela.value)
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
        escuela.value = item
        openModalDelete.value = true
    }

    const destroy = () => {
        loading.value = true
        axios.delete(`escuelas/destroy/${escuela.value.id}`)
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
        escuela.value = {}
        errors.value = []
        openModalNew.value = false
        openModalEdit.value = false
        openModalDelete.value = false
    }

    return {
        headers,
        escuelas,
        escuela,
        loading,
        errors,
        openModalNew,
        openModalEdit,
        openModalDelete,

        fetch,
        fetchEscuela,
        store,
        openNew,
        edit,
        update,
        deleteItem,
        destroy,
        resetData,

    }
});
