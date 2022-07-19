
    <script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>
<template>
  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <div class="flex justify-between">
      <h2 class="m-7 py-2 text-gray-900 font-bold text-xl mb-2">
        Team members
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
        Go to users page
      </Link> -->
    </div>
    <div class="py-5">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:rounded-lg">
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
              <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                  <th scope="col" class="px-6 py-3">Serial Number</th>
                  <th scope="col" class="px-6 py-3">Name</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="bg-white border-b"
                  v-for="user in users"
                  :key="user.id"
                >
                  <td
                    class="
                      px-6
                      py-4
                      font-medium
                      text-gray-900
                      whitespace-nowrap
                    "
                  >
                    {{ user.name }}
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
                    {{ user.email }}
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
  name: "UsersWidget",
  props: ["attrs"],
  data() {
    return {
      users: {},
      attrs: this.attrs,
    };
  },
  methods: {
    getUsers() {
      axios
        .get(`/auth/users/${this.attrs.user.current_team_id}`)
        .then((response) => {
          this.users = response.data;
        });
    },
  },
  created() {
    this.getUsers();
  },
};
</script>
