
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
        <Link
            v-if="permission"
            :href="route('virtualKey.create')"
            class="mr-10 mt-4 hover:text-black text-gray-600 flex items-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Create New Virtual Key
        </Link>
    </div>
    <div class="pb-5">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:rounded-lg">
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
              <thead class="text-xs text-white uppercase bg-gradient-to-r from-blue-500 to-sky-400" v-if="!isSafari()">
                <tr>
                  <th scope="col" class="px-6 py-3 sm:rounded-l-lg rounded-none">User</th>
                    <th scope="col" class="lg:px-3 md:px-0 py-3 px-5 sm:rounded-r-lg rounded-none">Label</th>
                </tr>
              </thead>
                <thead class="text-xs text-white uppercase bg-blue-500" v-if="isSafari()">
                <tr>
                    <th scope="col" class="px-6 py-3 sm:rounded-l-lg rounded-none">User</th>
                    <th scope="col" class="lg:px-3 md:px-0 py-3 sm:rounded-r-lg rounded-none">Label</th>
                </tr>
                </thead>
              <tbody>
                <tr
                  class="bg-white border-b"
                  v-for="(virtualKey,index) in virtualKeys"
                  :key="virtualKey.id"
                >
                  <td
                      v-if="index <=2"
                    class="
                      lg:px-3
                      md:px-0
                      px-5
                      py-4
                      font-medium
                      text-gray-900
                      whitespace-nowrap
                    "
                  >
                      <div class="flex
                      items-center">
                          <img
                              class="h-8 w-8 rounded-full object-cover mr-3"
                              :src="virtualKey.user.profile_photo_url"
                              :alt="virtualKey.user.name"
                          />
                          <div>
                              {{ virtualKey.user.name }}
                              <p class="text-gray-400 text-xs">{{ virtualKey.user.email }}</p>
                          </div>
                      </div>
                  </td>
                    <td v-if="index <=2" class="
                      lg:px-3
                      md:px-0
                      py-4
                      font-medium
                      text-gray-900
                      whitespace-nowrap">

                        {{virtualKey.label}}
                    </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
          <div class="mt-5 w-full flex justify-center" v-if="virtualKeys.length > 3">
              <Link
                  :href="route('virtualKeys.index')"
                  class="
                        text-gray-600
                        hover:text-black
                        py-2
                        px-4
                        rounded">
                  Show more
              </Link>
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
      isSafari(){
          return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
      }
  },
  created() {
      this.isSafari();
    this.getVirtualKeys();
    this.getPermission();
  },
};
</script>
