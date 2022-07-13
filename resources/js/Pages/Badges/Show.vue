<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your badges
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 relative">
            <div class="py-5">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Serial Number
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>

                                    <th scope="col" class="px-60 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="bg-white border-b" >
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        dd
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        dd
                                    </td>
                                    <td class="px-10 py-4 text-right">
                                        <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

