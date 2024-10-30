import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from '../global'
import axios from 'axios'

export const useCursosStore = defineStore('cursos', () => {
    
    const global = useGlobalStore()

    const headers = [
        { title : 'id', key : 'id' },
        { title : 'curso', key : 'nombre' },
        { title : 'status', key : 'deleted_at', align : 'center' },
        { title : '', key : 'actions', width : '10px' },
    ]

    const cursos = ref([])
    const detalleCursos = ref([])
    const curso = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openModalNew = ref(false)
    const openModalEdit = ref(false)
    const openModalDelete = ref(false)
 
    const fetch = () => {
        loading.value = true

        axios.get('cursos/index')
        .then(response => cursos.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    const fetchCursesDetails = (programa_id, nivel_id, seccion_id) => {
        loading.value = true

        axios.get(`cursos/curses-details/${programa_id}/${nivel_id}/${seccion_id}`)
        .then(response => detalleCursos.value = response.data)
        .catch(error => {
            console.error(error.response.data.error)
            errors.value = error.response.data.error
        })
        .finally(() => loading.value = false)
    }

    const store = () => {
        loading.value = true
        axios.post('cursos/store',curso.value)
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
        curso.value = item
        openModalEdit.value = true
    }

    const update = () => {
        loading.value = true
        axios.put(`cursos/update/${curso.value.id}`,curso.value)
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
        curso.value = item
        openModalDelete.value = true
    }

    const destroy = () => {
        loading.value = true
        axios.delete(`cursos/destroy/${curso.value.id}`)
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
        curso.value = {}
        errors.value = []
        openModalNew.value = false
        openModalEdit.value = false
        openModalDelete.value = false
    }

    return {
        headers,
        cursos,
        detalleCursos,
        curso,
        loading,
        errors,
        openModalNew,
        openModalEdit,
        openModalDelete,

        fetch,
        fetchCursesDetails,
        store,
        edit,
        update,
        deleteItem,
        destroy,
        resetData,

    }
});
