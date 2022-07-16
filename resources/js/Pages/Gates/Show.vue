<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gates</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="flex justify-between">
            <h2 class="m-7 py-2 text-gray-900 font-bold text-xl mb-2">
              Your gates
            </h2>
            <Link
              v-if="permission"
              :href="route('gates.create')"
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
              Create New Gate
            </Link>
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

                        <th scope="col" class="px-60 py-3">
                          <span class="sr-only">Edit</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        class="bg-white border-b"
                        v-for="gate in gates"
                        :key="gate.id"
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
                          {{ gate.serial_number }}
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
                          {{ gate.name }}
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
  name: "GateShow",
  data() {
    return {
      gates: {},
      permission: 0,
      attrs: this.$attrs,
    };
  },
  methods: {
    getGate() {
      axios
        .get(`/api/gates/teamId/${this.attrs.user.current_team_id}/resource`)
        .then((response) => {
          this.gates = response.data.data;
        });
    },
    getPermission() {
      axios
        .get(`/api/auth/permission/teamId/${this.attrs.user.current_team_id}`)
        .then((response) => {
          this.permission = response.data;
        });
    },
  },
  created() {
    this.getGate();
    this.getPermission();
  },
};
</script>
