<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { Bar, Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement  } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement)

import { ref } from 'vue';

const props = defineProps({
    authors: { type: Object },
    books: { type: Number },
    countries: { type: Object }
})

const aut = ref([]);
const cou = ref([]);
const chartData1 = ref([]);
const chartOptions1 = ref([]);
const chartData2 = ref([]);
const chartOptions2 = ref([]);
const aut2 = ref([]);
const boo = ref([]);
const colors = ref([]);
const colors2 = ref([]);

const random = () => {
    return Math.floor(Math.random() * 256);
}

//Graphic Bar:
props.countries.map((row) => (
    cou.value.push(row.country),
    aut.value.push(row.authors.length),
    colors.value.push('rgb(' + random() + ',' + random() + ',' + random() + ')')
))

chartOptions1.value = { responsive: true };
chartData1.value = {
    labels: cou.value,
    datasets: [{
        label: 'Authors',
        data: aut.value,
        backgroundColor: colors
    }]
}

//Graphic Pie:
props.authors.map((row) => (
    boo.value.push(row.books.length),
    aut2.value.push(row.last_name + ' ' + row.name),
    colors2.value.push('rgb(' + random() + ',' + random() + ',' + random() + ')')
))

chartOptions2.value = { responsive: true, maintainAspectRatio: false };
chartData2.value = {
    labels: aut2.value,
    datasets: [{
        label: 'Books',
        data: boo.value,
        backgroundColor: colors2.value
    }]
}


console.log(chartData1.value);
console.log(chartData2.value);


</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                <!-- Card -->
                <div class="flex items-center p-4 bg-white border rounded-lg shadow-xs">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            Total authors
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ authors.length }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center border p-4 bg-white rounded-lg shadow-xs">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 ">
                            Total books
                        </p>
                        <p class="text-lg font-semibold text-gray-700 ">
                            {{ books }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 border bg-white rounded-lg shadow-xs">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            Total countries
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ countries.length }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center border p-4 bg-white rounded-lg shadow-xs">
                    <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full ">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            Pending contacts
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            35
                        </p>
                    </div>
                </div>
            </div>
            <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg p-2">
                <div class="min-w-0 rouded-lg shadow-xs p-2 border">
                    <span class="text-lg p-4">Authors by country</span>
                    <div class="flex items-center">
                        <Bar :data="chartData1" :options="chartOptions1" :style="{width:'500px', height:'500px'}"></Bar>
                    </div>
                </div>
                <div class="min-w-0 rouded-lg shadow-xs p-2 border">
                    <span class="text-lg p-4">Books by author</span>
                    <div class="flex items-center">
                        <Pie :data="chartData2" :options="chartOptions2" :style="{width:'500px', height:'500px'}"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
