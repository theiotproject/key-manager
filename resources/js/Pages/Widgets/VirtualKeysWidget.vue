
    <script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>
<template>
  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <div class="flex justify-between">
      <h2
        class="m-7 py-2 text-gray-900 font-bold text-xl mb-2 flex items-center"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 ml-2"
          viewBox="0 0 20 20"
          fill="#FFA500"
        >
          <path
            fill-rule="evenodd"
            d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
            clip-rule="evenodd"
          />
        </svg>
        <p class="ml-3">Virtual Keys</p>
      </h2>
      <!-- <Link
        :href="route('gates.index')"
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
        Go to virtual keys page
      </Link> -->
    </div>
    <div class="pb-5">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:rounded-lg">
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
              <thead class="text-xs text-white uppercase bg-gradient-to-r from-blue-500 to-sky-400" >
                <tr>
                  <th scope="col" class="px-6 py-3 rounded-l-lg">User</th>
                  <th scope="col" class="px-6 py-3">E-mail</th>
                  <th scope="col" class="px-6 py-3">Active From</th>
                  <th scope="col" class="px-6 py-3">Active To</th>

                  <th scope="col" class="px-30 py-3 rounded-r-lg">
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
</template>
<script>
export default {
  name: "VirtualKeyWidget",
  props: ["attrs"],
  data() {
    return {
      virtualKeys: {},
      permission: 0,
      attrs: this.attrs,
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
