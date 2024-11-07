import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export const useCursosStore = defineStore('cursos', () => {

    const router = useRouter()
    const cursos = ref([])
    const curso = ref({})
    const loading = ref(false)
    const errors = ref([])

    async function fetch () {
        try {
            loading.value = true
            const response = await axios.get('portafolio/index')
            cursos.value = response.data

        } catch (error) {
            console.error(error)
            errors.value = error
        } finally {
            loading.value = false
        }
    }

    async function show(curso_id) {
        try {
            loading.value = true
            const response = await axios.get('portafolio/show/' + curso_id )
            curso.value = response.data
        } catch (error) {
            console.error(error)
            errors.value = error
        } finally {
            loading.value = false
        }
    }

    function detalleCurso (item) {
        router.push({name:'Detalle del curso',params:{ curso_id : item.id }})
    }

    async function fieldFormByDirection () {
        axios.get('campos-registro')
        .then(response => localStorage.setItem('campos-registro',JSON.stringify(response.data)))
        .catch(error => console.error(error))
    }

    return {
        router,
        cursos,
        curso,
        loading,
        errors,

        fetch,
        detalleCurso,
        show,
        fieldFormByDirection,
    }
})
