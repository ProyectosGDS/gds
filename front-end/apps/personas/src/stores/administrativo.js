import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAdministrativoStore = defineStore('administrativo', () => {
    
    const data = ref({})
    const loading = ref(false)
    const errors = ref([])

    return {
        data,
        loading,
        errors,
    }
})
