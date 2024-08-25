<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { ref } from 'vue';

const props = defineProps({
    authors: { type: Object },
    countries: { type: Object }
});


const form = useForm({ name: '', last_name: '', country_id: '' });
const v = ref({ id: '', name: '', last_name: '', books: [] });

const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);

const title = ref('');
const operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalView = (a) => {
    v.value.name = a.name + ' ' + a.last_name;
    v.value.country = a.country.country;
    v.value.books = a.books;
    showModalView.value = true
}
const openModalForm = (op, a) => {
    showModalForm.value = true;
    operation.value = op;
    if (op === 1) {
        title.value = 'Create Author';
    } else {
        title.value = 'Edit Author';
        form.name = a.name;
        form.last_name = a.last_name;
        form.country_id = a.country_id;
        v.value.id = a.id;

    }

}
const openModalDel = (a) => {
    showModalDel.value = true
    v.value.id = a.id;
    v.value.name = a.name + ' ' + a.last_name;
}
const closeModalView = () => {
    showModalView.value = false
}
const closeModalForm = () => {
    showModalForm.value = false;
    form.reset();
}
const closeModalDel = () => {
    showModalDel.value = false
}



const ok = (m) => {
    // if (operation.value == 2) {
    //     closeModalForm();
    // }
    closeModalForm();
    closeModalDel();
    form.reset();
    msj.value = m;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 3000);
}

const save = () => {
    if (operation.value == 1) {
        form.post(route('authors.store'), {
            onSuccess: () => { ok('Author Created') }
        })
    } else {
        form.put(route('authors.update', v.value.id), {
            onSuccess: () => { ok('Author Updated') }
        })
    }
}


const deleteAuthor = () => {
    form.delete(route('authors.destroy', v.value.id), {
        onSuccess: () => { ok('Author Deleted') }
    })
}
</script>

<template>

    <Head title="Authors" />

    <AuthenticatedLayout>
        <template #header>
            Authors
            <SuccessButton @click="openModalForm(1)" class=""><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </SuccessButton>
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


        <div class="w-full overflow-hidden rounded-lg border shadow-md">
            <div class="w-full overflow-x-auto bg-white">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Last Name</th>
                            <th class="px-4 py-3">Country</th>
                            <th class="px-4 py-3">Detail</th>
                            <th class="px-4 py-3">Edit</th>
                            <th class="px-4 py-3">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        <tr v-for="a, i in authors" :key="a.id" class="text-gray-700">
                            <td class="px-4 py-3 text-sm">
                                {{ (i + 1) }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ (a.name) }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ (a.last_name) }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ (a.country.country) }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <!-- Boton view -->
                                <SecondaryButton @click="openModalView(a)"><svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </SecondaryButton>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <PrimaryButton @click="openModalForm(2, a)"><svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </PrimaryButton>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <DangerButton @click="openModalDel(a)"><svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal de la vista -->
        <Modal :show="showModalView" @close="closeModalView">
            <div class="p-6">
                <p>Author: <span class="text-lg font-medium text-gray-900">{{ v.name }}</span></p>
                <p>Country: <span class="text-lg font-medium text-gray-900">{{ v.country }}</span></p>
                Books:
                <ol>
                    <li class="text-lg font-medium text-gray-900" v-for="b, i in v.books">
                        {{ (i + 1) + ') ' + b.title }}
                    </li>
                </ol>
            </div>
            <div class="m-6 flex justify-end" @click="closeModalView">
                <SecondaryButton>Cancel</SecondaryButton>
            </div>
        </Modal>


        <!-- Modal para crear o editar un registro -->
        <Modal maxWidth="sm" :show="showModalForm" @close="closeModalForm">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <div class="my-6 space-y-6">
                    <InputGroup :text="'Name'" :required="'required'" v-model="form.name" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </InputGroup>
                    <InputError class="mt-1" :message="form.errors.name ? 'El campo nombre es obligatorio' : form.errors.name"/>


                    <InputGroup :text="'Last Name'" :required="'required'" v-model="form.last_name" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </InputGroup>
                    <InputError class="mt-1" :message="form.errors.last_name ? 'Los apellidos son obligatorios': ''"></InputError>

                    <SelectInput :text="'Country'" :required="'required'" v-model="form.country_id"
                        :options="countries">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                        </svg>
                    </SelectInput>
                    <InputError class="mt-1" :message="form.errors.country_id ? 'La ciudad es obligatoria' : ''"></InputError>

                    <div class="flex justify-center">
                        <SuccessButton @click="save()">
                        Save
                    </SuccessButton>
                    <SecondaryButton class="ml-2" @click="closeModalForm">Cancel</SecondaryButton>
                    </div>

                </div>
            </div>
        </Modal>


        <!-- Modal para eliminar -->
        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <p class="text-2xl font-medium text-gray-500">Are you sure delete to <span
                        class="text-2xl font-medium text-gray-900">{{ v.name }}</span> ?</p>

            </div>
            <div class="m-6 flex justify-end">
                <div>
                    <DangerButton class="mr-2" @click="deleteAuthor">Yes, delete</DangerButton>
                </div>
                <div @click="closeModalDel">
                    <SecondaryButton>Cancel</SecondaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
