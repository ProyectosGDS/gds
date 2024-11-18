<script setup>
    import BackTop from '../components/BackTop.vue'
    import NavBar from '../components/NavBar.vue'
    import Footer from '../components/Footer.vue'
    import Calendar from '@/components/Calendar.vue'
    import Carousel from '../components/Carousel.vue'
    import { ref } from 'vue';

    const date = ref(new Date());

    const events = [
            {
                title : 'Evento 1', 
                description : 'Esta es la descripcion del evento 1',
                date : {
                    start : '2024-11-01',
                    end : '2024-11-01'
                },
                time : {
                    start : '09:30',
                    end : '10:30'
                }
            },
            {
                title : 'Evento 2', 
                description : 'Esta es la descripcion del evento 1',
                date : {
                    start : '2024-11-01',
                    end : '2024-11-01'
                },
                time : {
                    start : '09:30',
                    end : '10:30'
                }
            },
            {
                title : 'Evento 3', 
                description : 'Esta es la descripcion del evento 1',
                date : {
                    start : '2024-11-01',
                    end : '2024-11-01'
                },
                time : {
                    start : '09:30',
                    end : '10:30'
                }
            },
            {
                title : 'Evento 4', 
                description : 'Esta es la descripcion del evento 1',
                date : {
                    start : '2024-11-01',
                    end : '2024-11-01'
                },
                time : {
                    start : '09:30',
                    end : '10:30'
                }
            },
            {
                title : 'Evento 2', 
                description : 'Esta es la descripcion del evento 1',
                date : {
                    start : '2024-11-16',
                    end : '2024-11-16'
                },
                time : {
                    start : '09:30',
                    end : '10:30'
                }
            },
            {
                title : 'Evento 3', 
                description : 'Esta es la descripcion del evento 1',
                date : {
                    start : '2024-11-16',
                    end : '2024-11-16'
                },
                time : {
                    start : '09:30',
                    end : '10:30'
                }
            },
            {
                title : 'Evento 4', 
                description : 'Esta es la descripcion del evento 1',
                date : {
                    start : '2024-11-16',
                    end : '2024-11-16'
                },
                time : {
                    start : '09:30',
                    end : '10:30'
                }
            },
    ]

    const images = [
        '/public/img/carousel/1.png',
        '/public/img/carousel/2.jpg',
    ]
    
</script>

<template>
    <main class="pt-8">
        <NavBar :index="0" />
        <div class="h-screen flex flex-col">
            <section class="flex-1 container mx-auto py-8">
                <div class="lg:flex gap-5">
                    <Card class="bg-white p-4">
                        <RouterView />
                    </Card>
                    <Card class="bg-white p-4">
                        <h1 class="text-xl font-semibold text-gray-500">Proximas actividades</h1>
                        <br>
                        <div class="grid gap-3 w-full">
                            
                            <Carousel :images="images" />
                            
                            <div>
                                <Calendar :events="events" :min="true" />
                            </div>
                            <div>
                                <ul>
                                    <li class="font-medium cursor-pointer flex gap-2">
                                        <input type="checkbox">
                                        <span>Lorem ipsum dolor sit amet </span>
                                    </li>
                                    <li class="font-medium cursor-pointer flex gap-2">
                                        <input type="checkbox">
                                        <span>voluptatum amet, quaerat a doloribus</span>
                                    </li>
                                    <li class="font-medium cursor-pointer flex gap-2">
                                        <input type="checkbox">
                                        <span>Numquam necessitatibus aliquid ! </span>
                                    </li>
                                    <li class="font-medium cursor-pointer flex gap-2">
                                        <input type="checkbox">
                                        <span>fugiat id aliquid accusamus odio!</span>
                                    </li>
                                    <li class="font-medium cursor-pointer flex gap-2">
                                        <input type="checkbox">
                                        <span>laboriosam odio! Accusantium</span>
                                    </li>
                                    <li class="font-medium cursor-pointer flex gap-2">
                                        <input type="checkbox">
                                        <span>voluptatum amet, quaerat a doloribus</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </Card>
                </div>
                <BackTop />
            </section>
            <div class="flex-none bg-white text-blue-muni flex items-center justify-center h-16 md:h-36">
                <span class="text-lg md:text-4xl text-nowrap ">
                    Juntos 
                    <span class="font-semibold">
                        construimos
                    </span> 
                    la ciudad para 
                    <span class="font-semibold italic">
                        vivir mejor.
                    </span>
                </span>
            </div>
            <Footer class="flex-none" />
        </div>
    </main>
</template>
