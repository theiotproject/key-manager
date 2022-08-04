<script setup>
import axios from "axios";
</script>

<template>
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">Active From</th>
                <th scope="col" class="px-6 py-3">Active To</th>
                <th scope="col" class="px-6 py-3">User</th>

                <th scope="col" class="px-60 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                class="bg-white border-b"
                v-for="virtualKey in virtualKeys"
                :key="virtualKey.id"
            >
                <td
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                >
                    {{ virtualKey.activeFrom }}
                </td>
                <td
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                >
                    {{ virtualKey.activeTo }}
                </td>
                <td
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                >
                    {{ virtualKey.userId }}
                </td>
                <td class="px-10 py-4 text-right">
                    <a
                        href="#"
                        class="font-medium text-blue-600 hover:underline"
                        >Edit</a
                    >
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    name: "VirtualTable",
    props: {
        virtualKeys: {},
    },
    data() {
        return {
            virtualKeys: {},
        };
    },
    methods: {
        getVirtualKeys() {
            axios
                .get(
                    `/virtualKeys/teamId/${this.attrs.user.current_team_id}/resource`
                )
                .then((response) => {
                    this.virtualKeys = response.data.data;
                });
        },
    },
    created() {
        this.getVirtualKeys();
        // this.getUsers();
    },
};
</script>
