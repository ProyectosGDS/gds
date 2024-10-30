<script setup>

import { onClickOutside } from '@vueuse/core'
import { ref, computed, onMounted } from 'vue'

import { useGlobalStore } from '../stores/global'

const global = useGlobalStore()

// -------------PROPERTIES--------------


const search = ref('')
const startIndex = ref(1)
const endIndex = ref(1)
const currentPage = ref(1)
const rowsPerPage = ref(12)
const sortColumn = ref('programa.escuela.nombre')
const sortDir = ref('desc')
const sortType = ref(false)
const openFilterOptions = ref(false)
const target = ref(null)

const props = defineProps({
    data: null,
    loading: {
        type: Boolean,
        default: false
    }
})


// -------------COMPUTATED--------------



const data = computed(() => props.data)


const filteredData = computed(() => {
    currentPage.value = 1;
    return sortedItems.value.filter(item => item.curso.nombre.toLowerCase().match(search.value.toLowerCase()))
}, { cache: true })

const getObjectValue  = (object, key) => {
    const keys = key.split('.')
    return keys.reduce((value, currentKey) => {
        return value && value[currentKey]
    }, object)
}

const paginatedData = computed(() => {
    startIndex.value = (currentPage.value - 1) * rowsPerPage.value
    endIndex.value = parseInt(startIndex.value) + parseInt(rowsPerPage.value)
    return filteredData.value.slice(startIndex.value, endIndex.value)
})

const totalPages = computed(() => Math.ceil(filteredData.value.length / rowsPerPage.value))

const setCurrentPage = (page) => {
    currentPage.value = page
}

const sortedItems = computed(() => {
    if (sortColumn.value) {
        return data.value.sort((a, b) => {

            if (sortType.value == 'numeric') {
                const valA = Number(getObjectValue(a, sortColumn.value))
                const valB = Number(getObjectValue(b, sortColumn.value))
                return sortDir.value === 'asc' ? valA - valB : valB - valA
            }

            const valA = String(getObjectValue(a, sortColumn.value))
            const valB = String(getObjectValue(b, sortColumn.value))
            return sortDir.value === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA)

        });
    }
    return data.value
})

const displayedPages = computed(() => {

    const totalDisplayedPages = 6
    const halfDisplayedPages = Math.floor(totalDisplayedPages / 2)
    let startPage = Math.max(currentPage.value - halfDisplayedPages, 1)
    let endPage = Math.min(startPage + totalDisplayedPages - 1, totalPages.value)

    if (endPage - startPage + 1 < totalDisplayedPages) {
        startPage = Math.max(endPage - totalDisplayedPages + 1, 1)
    }

    return Array(endPage - startPage + 1).fill().map((_, index) => startPage + index)
})


// -------------METHODS--------------


const sort = (column, type) => {

    sortType.value = type

    if (sortColumn.value === column) {
        sortDir.value = sortDir.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = column;
        sortDir.value = 'asc';
    }

}

const resetPage = () => {
    currentPage.value = 1
}



onClickOutside(target, (event) => openFilterOptions.value = false)

onMounted(() => {

    setTimeout(() => {
        if (data.value.length === 0 && props.loading === true) {
            props.loading = false
        }
    }, 2000)
});

</script>

<template>
    <section class="px-7">
        <div class="md:flex md:justify-end">
            <div class="border rounded-md flex items-center px-2 gap-2">
                <Icon icon="fas fa-search" class="text-gray-500" />
                <input type="search" class="h-10 w-full focus:outline-none" placeholder="Buscar curso ..." v-model="search">
            </div>
        </div>
        <br>
        <!-- CARDS -->
         <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
            <div v-for="item in paginatedData" class="rounded-xl flex flex-col border border-lime-muni overflow-hidden">
                <img src="/public/img/foto-card.jpg" :alt="item.curso.nombre" class=" object-cover h-48 object-center">
                <div class="flex-1 p-3">
                    <slot name="body" :item="item"></slot>    
                </div>
                <div class="p-3">
                    <slot name="footer" :item="item"></slot>
                </div>
            </div>
        </div>
        <!-- END CARDS -->
        <br>
        <!-- PAGINATION -->
        <div class="flex items-center justify-between pb-4">
            <!-- RESPONSIVE MOBILE BUTTONS -->
            <div class="flex flex-1 justify-between md:hidden">
                <a @click="(currentPage == 1) ? currentPage = 1 : currentPage--"
                    class="relative inline-flex items-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                    Anterior
                </a>
                <a @click="(currentPage == totalPages) ? currentPage = totalPages : currentPage++"
                    class="relative ml-3 inline-flex items-center rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                    Siguiente
                </a>
            </div>

            <div class="hidden md:flex md:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs text-gray-500">
                        Mostrando
                        <span class="font-medium">{{ startIndex + 1 }}</span>
                        a
                        <span class="font-medium">{{ (endIndex >= filteredData.length) ? filteredData.length : endIndex}}</span>
                        de
                        <span class="font-medium">{{ filteredData.length }}</span>
                        resultados
                    </p>
                </div>
                <div v-show="filteredData.length >= 11 && displayedPages.length > 1">
                    <nav class="flex gap-3">
                        <a v-if="currentPage > 4" @click="setCurrentPage(1)"
                            class="pagination">
                            <icon icon="fas fa-angles-left" class="text-xs" />
                        </a>
                        <a v-if="currentPage > 4" @click="(currentPage == 1) ? currentPage = 1 : currentPage--"
                            class="pagination">
                            <span class="sr-only">Previous</span>
                            <icon icon="fas fa-angle-left" class="text-xs" />

                        </a>
                        <a :class="page === currentPage ? ' scale-125 z-10 ' + props.color : ''"
                            v-for="page in displayedPages" :key="page" @click="setCurrentPage(page)"
                            class="pagination">
                            {{ page }}
                        </a>
                        <a v-if="currentPage < (totalPages - 1)"
                            @click="(currentPage == totalPages) ? currentPage = totalPages : currentPage++"
                            class="pagination">
                            <span class="sr-only">Next</span>
                            <icon icon="fas fa-angle-right" class="text-xs" />
                        </a>
                        <a v-if="currentPage < (totalPages - 3)" @click="setCurrentPage(totalPages)"
                            class="pagination">
                            <icon icon="fas fa-angles-right" class="text-xs" />
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END PAGINATION -->

    </section>
</template>

<style scoped>
td {
    @apply py-3 text-gray-800;
}

th {
    @apply font-semibold uppercase text-violet-300;
}

.pagination {
    @apply rounded-full bg-blue-muni text-white h-8 w-8 flex items-center justify-center cursor-pointer select-none;
}
</style>
