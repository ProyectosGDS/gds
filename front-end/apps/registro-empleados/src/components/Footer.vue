<script setup>
    const images = [
        { alt : 'Municipalidad de Guatemala', nameFile : 'website.png', route: 'https://www.muniguate.com' },
        { alt : 'Municipalidad de Guatemala', nameFile : 'facebook.png', route: '#' },
        { alt : 'Municipalidad de Guatemala', nameFile : 'tiktok.png', route: '#' },
        { alt : 'Municipalidad de Guatemala', nameFile : 'x.png', route: '#' },
        { alt : 'Municipalidad de Guatemala', nameFile : 'instagram.png', route: '#' },
        { alt : 'Municipalidad de Guatemala', nameFile : 'youtube.png', route: '#' },
    ]
</script>
<template>
    <footer class="flex flex-col gap-y-8 justify-center items-center bg-lime-muni h-64">
        <div class="flex gap-x-5 lg:gap-x-16">
            <a v-for="img in images" :href="img.route">
                <img :src="'/img/'+ img.nameFile" :alt="img.alt" class="md:h-16 h-10">
            </a>
        </div>
        <div>
            <h3 class="text-white text-center font-light">
                21 Calle 6-77 Zona 1, Centro Cívico, Palacio Municipal. Ciudad de Guatemala, Guatemala, Centroamérica.<br>
                PBX 2285 8000 | Términos de Uso
            </h3>
        </div>
    </footer>
</template>
