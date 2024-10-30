import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useCatalogosStore } from './catalogos'

export const useDatosPersonalesStore = defineStore('datos-personales', () => {
    
    const data = ref({})
    const loading = ref(false)
    const errors = ref([])

    const catalogos = useCatalogosStore()

    function store () {
        loading.value = true
        axios.post('personas',data.value)
        .then(response => console.log(response.data))
        .catch(error => {
            if(error.response.data.errors){
                errors.value = error.response.data.errors
            }else{
                errors.value = error.response.data.message
            }
        })
        .finally(() => loading.value = false)
    }

    const verifyCui = () => {
        
        let cui = data.value.cui

        if(cui.length == 13){

            if (!cui) {
                console.log("CUI vacío")
                return false
            }
        
            let cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/
        
            if (!cuiRegExp.test(cui)) {
                console.log("CUI con formato inválido");
                return false
            }
        
            cui = cui.replace(/\s/, '')
            let depto = parseInt(cui.substring(9, 11), 10)
            let muni = parseInt(cui.substring(11, 13))
            let numero = cui.substring(0, 8)
            let verificador = parseInt(cui.substring(8, 9))
            
            let munisPorDepto = [
                 
                {id: 1, departamento : 'Guatemala', cantidad : 17 },
                {id: 2, departamento : 'El Progreso', cantidad :8 },
                {id: 3, departamento : 'Sacatepéquez', cantidad : 16 },
                {id: 4, departamento : 'Chimaltenango', cantidad : 16 },
                {id: 5, departamento : 'Escuintla', cantidad : 13 },
                {id: 6, departamento : 'Santa Rosa', cantidad : 14 },
                {id: 7, departamento : 'Sololá', cantidad : 19 },
                {id: 8, departamento : 'Totonicapán', cantidad : 8 },
                {id: 9, departamento : 'Quetzaltenango', cantidad : 24 },
                {id: 10, departamento : 'Suchitepéquez', cantidad : 21},
                {id: 11, departamento : 'Retalhuleu', cantidad : 9},
                {id: 12, departamento : 'San Marcos', cantidad : 30},
                {id: 13, departamento : 'Huehuetenango', cantidad : 32},
                {id: 14, departamento : 'Quiché', cantidad : 21},
                {id: 15, departamento : 'Baja Verapaz', cantidad : 8},
                {id: 16, departamento : 'Alta Verapaz', cantidad : 17},
                {id: 17, departamento : 'Petén', cantidad : 14},
                {id: 18, departamento : 'Izabal', cantidad : 5},
                {id: 19, departamento : 'Zacapa', cantidad : 11},
                {id: 20, departamento : 'Chiquimula', cantidad : 11},
                {id: 21, departamento : 'Jalapa', cantidad : 7},
                {id: 22, departamento : 'Jutiapa', cantidad : 17},
            ]
            
            if (depto === 0 || muni === 0) {
                console.log("CUI con código de municipio o departamento inválido.")
                return false
            }
            
            if (depto > munisPorDepto.length) {
                console.log("CUI con código de departamento inválido.")
                return false
            }
            
            if (muni > munisPorDepto[depto -1].cantidad) {
                console.log("CUI con código de municipio inválido.")
                return false
            }
                
            let total = 0
            
            for (let i = 0; i < numero.length; i++) {
                total += numero[i] * (i + 2)
            }
            
            let modulo = (total % 11)
            
            console.log("CUI con módulo: " + modulo)
    
            console.log("CUI valido: " + (modulo === verificador)) 
        }

    }

    function changePais () {
        if(data.value.hasOwnProperty('pais_id')) {
            axios.get(`paises/${data.value.pais_id}`)
            .then(response => catalogos.departamentos = response.data.departamentos)
            .catch(error => console.error(error.response.data))
        }
    }

    function changeDepartamento () {
        if(data.value.hasOwnProperty('departamento_id')) {
            axios.get(`departamentos/${data.value.departamento_id}`)
            .then(response => catalogos.municipios = response.data.municipios)
            .catch(error => console.error(error.response.data))
        }
    }

    return {
        data,
        loading,
        errors,

        store,
        changePais,
        changeDepartamento,
        verifyCui,
    }
})
