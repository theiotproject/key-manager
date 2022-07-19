<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Virtual Keys
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="flex justify-between">
            <h2 class="m-7 py-2 text-gray-900 font-bold text-xl mb-2">
              Your Virtual Keys
            </h2>
            <Link
              v-if="permission"
              :href="route('virtualKey.create')"
              :data="{ team_id: attrs }"
              class="
                m-7
                bg-blue-500
                hover:bg-blue-700
                text-white
                font-bold
                py-2
                px-4
                rounded
              "
            >
              Create New Virtual Key
            </Link>
          </div>
          <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                  <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                      <tr>
                        <th scope="col" class="px-6 py-3">User</th>
                        <th scope="col" class="px-6 py-3">E-mail</th>
                        <th scope="col" class="px-6 py-3">Active From</th>
                        <th scope="col" class="px-6 py-3">Active To</th>

                        <th scope="col" class="px-30 py-3">
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
                          class="
                            px-6
                            py-4
                            font-medium
                            text-gray-900
                            whitespace-nowrap
                            flex
                            items-center
                          "
                        >
                          <img
                            class="h-8 w-8 rounded-full object-cover mr-3"
                            :src="virtualKey.user.profile_photo_url"
                            :alt="virtualKey.user.name"
                          />
                          {{ virtualKey.user.name }}
                        </td>
                        <td
                          class="
                            px-6
                            py-4
                            font-medium
                            text-gray-900
                            whitespace-nowrap
                          "
                        >
                          {{ virtualKey.user.email }}
                        </td>
                        <td
                          class="
                            px-6
                            py-4
                            font-medium
                            text-gray-900
                            whitespace-nowrap
                          "
                        >
                          {{ virtualKey.active_from }}
                        </td>
                        <td
                          class="
                            px-6
                            py-4
                            font-medium
                            text-gray-900
                            whitespace-nowrap
                          "
                        >
                          {{ virtualKey.active_to }}
                        </td>
                        <td class="px-10 py-4 text-right">
                          <a
                            href="#"
                            class="font-medium text-blue-600 hover:underline"
                            >Show Gates</a
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
export default {
  name: "VirtualKeyShow",
  data() {
    return {
      virtualKeys: {},
      permission: 0,
      attrs: this.$attrs,
    };
  },
  methods: {
    getVirtualKeys() {
      axios
        .get(
          `/virtualKeys/teamId/${this.attrs.user.current_team_id}/users/gates`
        )
        .then((response) => {
          this.virtualKeys = response.data;
          console.log(this.virtualKeys);
        });
    },
    getPermission() {
      axios
        .get(`/auth/permission/teamId/${this.attrs.user.current_team_id}`)
        .then((response) => {
          this.permission = response.data;
        });
    },
  },
  created() {
    this.getVirtualKeys();
    this.getPermission();
  },
};
</script>
