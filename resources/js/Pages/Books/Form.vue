<script setup>


import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

import NavLink from '@/Components/NavLink.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';

import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import SuccessButton from '@/Components/SuccessButton.vue';

//Comando para importar Select2
import Select2 from 'vue3-select2-component';


const props = defineProps({
    authors: { type: Object },
    book: { type: Object },
    authorsOfBook: { type: Object }
});


const form = useForm({
    id: '', isbn: '', description: '', title: '',
    publisher: '', release_date: '', pages: '',
    image: '', authors: []
});

// Condicion para titulo del formulario
const title_form = ref(
    (props.book == null) ? 'Create book' : 'Edit Book'
);

//Constante que hace referencia a requerido
const req = ref('required');
//Ruta de las imagenes en el almacenamiento
const srcImg = ref('../../storage/img/example.png');
// Mensaje
const msj = ref('');
// Clase del mensaje
const classMsj = ref('hidden');

//Valores para el campo opciones del select2
const options = ref([]);
props.authors.map((row) => {
    options.value.push({ 'id': row.id, 'text': row.last_name + ' ' + row.name })
})

//Si no esta definido un libro, osea si es en la funcion editar vamos a llenar el formulario para que este prelleno con la informacion de libro:
if (props.book != null) {
    form.id = props.book.id;
    form.isbn = props.book.isbn;
    form.title = props.book.title;
    form.description = props.book.description;
    form.release_date = props.book.release_date;
    form.publisher = props.book.publisher;
    form.pages = props.book.pages;
    form.image = props.book.image;
    srcImg.value = '../../storage' + props.book.image;

    //Se agrega para el select2
    props.authorsOfBook.map((row)=> {
        form.authors.push(row.id)
    })
}

const save = () => {
    if (props.book == null) {
        form.post(route('books.store'), {
            onSuccess: () => { ok('Book created') }
        })
    } else {
        form.post(route('updatebook'))
    }
}

const ok = (m) => {
    form.reset();
    msj.value = m;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 3000);
}

//Metodo para previsualizar imagen antes de crear o editar registro:
const showImg = (e) => {
    form.image = e.target.files[0];
    srcImg.value = URL.createObjectURL(e.target.files[0]);
}

</script>

<template>

    <Head title="Book" />

    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex justify-between overflow-hidden mb-4 w-full p-2">
                {{ title_form }}
                <NavLink :href="route('books.index')">
                    <PrimaryButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </PrimaryButton>
                </NavLink>
            </div>
        </template>

        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
            <div class="flex justify-center items-center w-12 bg-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500">Success</span>
                    <p class="text-sm text-gray-600">{{ msj }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 rouded-lg shadow-xs p-2">
                <form class="my-6 space-y6 max-w-xl" @submit.prevent="save">
                    <InputGroup :text="'ISBN'" :required="'required'" v-model="form.isbn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.isbn" />

                    <InputGroup :text="'Description'" :required="'required'" v-model="form.description">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.description" />

                    <InputGroup :text="'Title'" :required="'required'" v-model="form.title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.title" />

                    <InputGroup :text="'Editorial'" :required="'required'" v-model="form.publisher">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.publisher" />

                    <InputGroup :text="'Release Day'" :required="'required'" v-model="form.release_date" :type="'date'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.release_date" />

                    <InputGroup :text="'Pages'" :required="'required'" v-model="form.pages" :type="'number'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.pages" />

                    <!-- Se le agrega un change para llamar al metodo showImg que contenga el evento -->
                    <InputGroup v-if="props.book == null" @change="showImg($event)" :text="'Image'"
                        :required="'required'" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </InputGroup>

                    <!-- Se le agrega un change para llamar al metodo showImg que contenga el evento -->
                    <InputGroup v-else :text="'Image'" @change="showImg($event)" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.image" />

                    <!-- Panel para agregar autores -->
                    <span class="mt-2">Add Authors:</span>
                    <Select2 v-model="form.authors" :options="options" :settings="{multiple:true , width:'100%'}" @change="form.authors = $event.target.value"/>
                    <InputError :message="form.errors.image" />

                    <!-- Boton para guardar registro -->
                    <SuccessButton class="mt-2">Save</SuccessButton>
                </form>
            </div>
            <div class="min-w-0 rounded-lg shadow-xs p-2 flex items-center justify-center">
                <img width="400" :src="srcImg">
            </div>
        </div>
    </AuthenticatedLayout>
</template>
