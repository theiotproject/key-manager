<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import JetModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import MakeToast from "../../Services/MakeToast.vue";
</script>
<template>
  <div class="overflow-hidden shadow-xl sm:rounded-lg">
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
        <button
          @click="switchList"
          class="ml-2 text-gray-500 text-xs hover:text-gray-700"
        >
          / Virtual Tickets
        </button>
      </h2>
    </div>
    <div class="pb-5 min-h-full relative">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:rounded-lg">
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
              <thead
                class="
                  text-xs text-white
                  uppercase
                  bg-gradient-to-r
                  from-blue-500
                  to-sky-400
                "
                v-if="!isSafari()"
              >
                <tr>
                  <th
                    scope="col"
                    class="px-6 py-3 sm:rounded-l-lg rounded-none"
                  >
                    User
                  </th>
                  <th
                    scope="col"
                    class="
                      lg:px-3
                      md:px-0
                      py-3
                      px-5
                      sm:rounded-r-lg
                      rounded-none
                    "
                  >
                    Label
                  </th>
                </tr>
              </thead>
              <thead
                class="text-xs text-white uppercase bg-blue-500"
                v-if="isSafari()"
              >
                <tr>
                  <th
                    scope="col"
                    class="px-6 py-3 sm:rounded-l-lg rounded-none"
                  >
                    User
                  </th>
                  <th
                    scope="col"
                    class="lg:px-3 md:px-0 py-3 sm:rounded-r-lg rounded-none"
                  >
                    Label
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="bg-white border-b whiteBackground"
                  v-for="(virtualKey, index) in usersVirtualkeys"
                  :key="virtualKey.id"
                >
                  <td
                    v-if="index <= 3"
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
                    <div class="flex items-center">
                      <img
                        class="h-8 w-8 rounded-full object-cover mr-3"
                        :src="virtualKey.user.profile_photo_url"
                        :alt="virtualKey.user.name"
                      />
                      <div>
                        {{ virtualKey.user.name }}
                        <p class="text-gray-400 text-xs">
                          {{ virtualKey.user.email }}
                        </p>
                      </div>
                    </div>
                  </td>
                  <td
                    v-if="index <= 3"
                    class="
                      lg:px-3
                      md:px-0
                      py-4
                      font-medium
                      text-gray-900
                      whitespace-nowrap
                    "
                  >
                    {{ virtualKey.label }}
                  </td>
                </tr>
                <tr
                  class="bg-white border-b whiteBackground"
                  v-for="(virtualKey, index) in notUsersVirtualKeys"
                  :key="virtualKey.id"
                >
                  <td
                    v-if="usersVirtualkeys.length + index < 4"
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
                    <div class="flex items-center">
                      <img
                        class="h-8 w-8 rounded-full object-cover mr-3"
                        :src="virtualKey.user.profile_photo_url"
                        :alt="virtualKey.user.name"
                      />
                      <div>
                        {{ virtualKey.user.name }}
                        <p class="text-gray-400 text-xs">
                          {{ virtualKey.user.email }}
                        </p>
                      </div>
                    </div>
                  </td>
                  <td
                    v-if="usersVirtualkeys.length + index < 4"
                    class="
                      lg:px-3
                      md:px-0
                      py-4
                      font-medium
                      text-gray-900
                      whitespace-nowrap
                    "
                  >
                    {{ virtualKey.label }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        class="
          flex
          content-between
          h-full
          w-full
          items-end
          bottom-12
          p-12
          absolute
        "
      >
        <p
          class="
            flex
            items-center
            justify-left
            absolute
            left-10
            cursor-pointer
            text-xs text-gray-500
            hover:text-black
          "
          v-if="currentPage > 1"
          @click="getVirtualKeys(currentPage - 1)"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15 19l-7-7 7-7"
            />
          </svg>
          Previous Page
        </p>
        <p
          class="
            flex
            items-center
            justify-right
            absolute
            right-10
            cursor-pointer
            text-xs text-gray-500
            hover:text-black
          "
          v-if="nextPageAvailable"
          @click="getVirtualKeys(currentPage + 1)"
        >
          Next Page
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M9 5l7 7-7 7"
            />
          </svg>
        </p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "VirtualKeyWidget",
  props: ["attrs", "gate"],
  data() {
    return {
      gate: this.gate,
      virtualKeys: {},
      permission: 0,
      localAttrs: this.attrs,
      showAllVK: false,
      nextPageAvailable: false,
      currentPage: 1,
    };
  },
  methods: {
    switchList() {
      this.$emit("switch", false);
    },
    getVirtualKeys(page) {
      console.log(page);
      axios
        .get(`/virtualKeys/gate/${this.gate.id}/limit/4?page=${page}`)
        .then((response) => {
          this.virtualKeys = response.data.data;
          this.currentPage = response.data.current_page;
          if (response.data.next_page_url !== null) {
            this.nextPageAvailable = true;
          } else {
            this.nextPageAvailable = false;
          }
        });
    },
    getPermission() {
      axios
        .get(`/auth/permission/teamId/${this.localAttrs.user.current_team_id}`)
        .then((response) => {
          this.permission = response.data;
        });
    },
    isSafari() {
      return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    },
  },
  computed: {
    usersVirtualkeys: function () {
      return Array.from(this.virtualKeys).filter((virtualKey) => {
        return virtualKey.user_id === this.localAttrs.user.id;
      });
    },
    notUsersVirtualKeys: function () {
      return Array.from(this.virtualKeys).filter((virtualKey) => {
        return virtualKey.user_id !== this.localAttrs.user.id;
      });
    },
  },
  created() {
    this.isSafari();
    this.getPermission();
    this.getVirtualKeys(1);
  },
};
</script>

<style scoped>
.whiteBackground {
  background-color: white;
}
</style>
