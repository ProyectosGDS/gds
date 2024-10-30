import axios from 'axios'
import { defineStore } from 'pinia'
import { ref, reactive } from 'vue'
import { useGlobalStore } from '../global'

export const usePortafolioStore = defineStore('portafolio', () => {

    const global = useGlobalStore()

    const headers = [
        { title : 'escuela', key : 'programa.escuela.nombre' },
        { title : 'programa', key : 'programa.nombre' },
        { title : 'nivel', key : 'nivel.nombre' },
        { title : 'seccion', key : 'seccion.nombre' },
        { title : 'curso', key : 'curso.nombre' },
        { title : 'horario', key : 'horario.dia' },
        { title : 'modalidad', key : 'modalidad' },
        { title : 'instructor', key : 'instructor.nombre' },
        { title : 'status', key : 'deleted_at', align : 'center' },
        { title : '', key : 'actions', width : '10px' },
    ]

    const portafolios = ref([])
    const portafolio = ref({})
    const portafolioEdit = ref({})
    const loading = ref(false)
    const errors = ref([])
    const openModalView = ref(false)
    const openModalNew = ref(false)
    const openModalEdit = ref(false)
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
        portafolioEdit.value = {...item}
        openModalEdit.value = true
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
        portafolioEdit.value = {}
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
        portafolioEdit,
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
