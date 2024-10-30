import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from '../global'
import axios from 'axios'

export const useInstructoresStore = defineStore('instructores', () => {
    
    const global = useGlobalStore()

    const headers = [
        { title : 'id', key : 'id' },
        { title : 'nivel', key : 'nombre' },
        { title : 'status', key : 'deleted_at', align : 'center' },
        { title : '', key : 'actions', width : '10px' },
    ]

    const instructores = ref([])
    const instructor = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openModalNew = ref(false)
    const openModalEdit = ref(false)
    const openModalDelete = ref(false)
 
    const fetch = () => {
        loading.value = true

        axios.get('instructores/index')
        .then(response => instructores.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    const store = () => {
        loading.value = true
        axios.post('instructores/store',instructor.value)
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
        instructor.value = item
        openModalEdit.value = true
    }

    const update = () => {
        loading.value = true
        axios.put(`instructores/update/${instructor.value.id}`,instructor.value)
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
        instructor.value = item
        openModalDelete.value = true
    }

    const destroy = () => {
        loading.value = true
        axios.delete(`instructores/destroy/${instructor.value.id}`)
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
        instructor.value = {}
        errors.value = []
        openModalNew.value = false
        openModalEdit.value = false
        openModalDelete.value = false
    }

    return {
        headers,
        instructores,
        instructor,
        loading,
        errors,
        openModalNew,
        openModalEdit,
        openModalDelete,

        fetch,
        store,
        edit,
        update,
        deleteItem,
        destroy,
        resetData,
    }
});
