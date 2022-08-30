<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import MakeToast from "../../Services/MakeToast.vue";

const removeGateForm = useForm();

const gateBeingRemoved = ref(null);

const confirmGateRemoval = (gate) => {
  gateBeingRemoved.value = gate;
};

const removeGate = () => {
  removeGateForm.delete(route("gates.destroy", [gateBeingRemoved.value]), {
    errorBag: "removeGate",
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      gateBeingRemoved.value = null;
      MakeToast.create("Deleted Gate successfully", "info");
    },
    onError: () => {
      MakeToast.create("Cannot delete Gate", "error");
    },
  });
};
</script>
<template>
  <AppLayout title="Events">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Events</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="parent2 gap-x-5 gap-y-5">
          <div class="area-2-1">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="flex justify-between">
                <h2
                  class="
                    m-7
                    py-2
                    text-gray-900
                    font-bold
                    text-xl
                    mb-2
                    flex
                    items-center
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 ml-2"
                    viewBox="0 0 20 20"
                    fill="#FFA500"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <p class="ml-3">Events</p>
                </h2>
                <button
                  @click="getEvents"
                  class="
                    mr-10
                    mt-4
                    hover:text-black
                    text-gray-600
                    flex
                    items-center
                    gap-2
                  "
                >
                  <transition name="appear" @after-leave="isEventNew = true">
                    <span v-if="!isEventNew" class="text-sm mx-3 text-gray-600"
                      >New events not found</span
                    >
                    <span v-else class="absolute"></span>
                  </transition>
                  <transition name="rotation" @after-leave="showHello = true">
                    <svg
                      v-if="showHello"
                      @click="showHello = false"
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
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                      />
                    </svg>
                  </transition>
                </button>
              </div>
              <div class="pb-5">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                  <div class="bg-white overflow-hidden sm:rounded-lg">
                    <div class="relative pb-9 shadow-md sm:rounded-lg">
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
                            <th scope="col" class="px-3 py-3">Date</th>
                            <th scope="col" class="px-3 py-3">User</th>
                            <th scope="col" class="px-2 py-3">Gate</th>

                            <th
                              scope="col"
                              class="px-2 py-3 sm:rounded-r-lg rounded-none"
                            >
                              Message
                            </th>
                          </tr>
                        </thead>
                        <thead
                          class="text-xs text-white uppercase bg-blue-500"
                          v-if="isSafari()"
                        >
                          <tr>
                            <th scope="col" class="px-2 py-3">Date</th>
                            <th scope="col" class="px-3 py-3">User</th>
                            <th scope="col" class="px-2 py-3">Gate</th>

                            <th
                              scope="col"
                              class="px-2 py-3 sm:rounded-r-lg rounded-none"
                            >
                              Message
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="event in events"
                            :key="event.id"
                            v-bind:class="
                              event.status
                                ? 'text-green-800 bg-teal-50'
                                : 'text-red-700 bg-red-50'
                            "
                            class="border-b"
                          >
                            <td class="px-2 py-4 font-medium whitespace-nowrap">
                              {{ event.scan_time }}
                            </td>
                            <td class="px-3 py-4 font-medium whitespace-nowrap">
                              <div class="flex items-center">
                                <a
                                  :title="event.name"
                                  class="h-8 w-8 mr-2 cursor-pointer"
                                >
                                  <img
                                    class="rounded-full object-cover mr-1"
                                    :src="event.profile_photo_url"
                                  />
                                </a>
                              </div>
                            </td>
                            <td class="px-2 py-4 font-medium whitespace-nowrap">
                              <span v-if="event.gate_name.length < 8">{{
                                event.gate_name
                              }}</span>
                              <span v-else>{{
                                event.gate_name.substring(0, 20) + ".."
                              }}</span>
                            </td>
                            <td class="px-2 py-4 font-medium whitespace-nowrap">
                              {{ event.message }}
                            </td>

                            <!-- <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                            >
                                                {{ event.name }}
                                            </td> -->
                          </tr>
                        </tbody>
                      </table>
                      <div class="mt-4 w-full flex justify-center">
                        <p
                          class="
                            mt-2
                            flex
                            items-center
                            justify-left
                            absolute
                            left-10
                            cursor-pointer
                            text-xs text-gray-500
                            hover:text-black
                          "
                          v-if="eventPagination.page > 1"
                          @click="eventPagination.page--"
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
                            mt-2
                            flex
                            items-center
                            justify-right
                            absolute
                            right-10
                            cursor-pointer
                            text-xs text-gray-500
                            hover:text-black
                          "
                          v-if="eventPagination.nextPageAvailable"
                          @click="eventPagination.page++"
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
                </div>
              </div>
            </div>
          </div>
          <div class="area-2-2">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="flex justify-between">
                <h2
                  class="
                    m-7
                    py-2
                    text-gray-900
                    font-bold
                    text-xl
                    mb-2
                    flex
                    items-center
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 ml-2"
                    viewBox="0 0 20 20"
                    fill="#FFA500"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <p class="ml-3">Scan attempts</p>
                </h2>
                <button
                  @click="getScanAttempts"
                  class="
                    mr-10
                    mt-4
                    hover:text-black
                    text-gray-600
                    flex
                    items-center
                    gap-2
                  "
                >
                  <transition name="rotation" @after-leave="showHello2 = true">
                    <svg
                      v-if="showHello2"
                      @click="showHello2 = false"
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
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                      />
                    </svg>
                  </transition>
                </button>
              </div>
              <div class="pb-5">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                  <div class="bg-white overflow-hidden sm:rounded-lg">
                    <div
                      class="relative shadow-md sm:rounded-lg"
                      style="padding-bottom: 39px"
                    >
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
                              class="px-3 py-3 sm:rounded-l-lg rounded-none"
                            >
                              Date
                            </th>
                            <th scope="col" class="px-2 py-3">Gate</th>
                            <th
                              scope="col"
                              class="px-2 py-3 sm:rounded-r-lg rounded-none"
                            >
                              Message
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
                              Gate
                            </th>
                            <th
                              scope="col"
                              class="px-2 py-3 sm:rounded-r-lg rounded-none"
                            >
                              Message
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="scanAttempt in scanAttempts"
                            :key="scanAttempt.id"
                            class="border-b"
                          >
                            <td class="px-2 py-4 font-medium whitespace-nowrap">
                              {{ scanAttempt.scan_time }}
                            </td>
                            <td class="px-2 py-4 font-medium whitespace-nowrap">
                              <span v-if="scanAttempt[0].name.length < 8">{{
                                scanAttempt[0].name
                              }}</span>
                              <span v-else>{{
                                scanAttempt[0].name.substring(0, 20) + ".."
                              }}</span>
                            </td>
                            <td class="px-2 py-4 font-medium whitespace-nowrap">
                              {{ scanAttempt.message }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="mt-7 w-full flex justify-center">
                        <p
                          class="
                            mt-2
                            flex
                            items-center
                            justify-left
                            absolute
                            left-10
                            cursor-pointer
                            text-xs text-gray-500
                            hover:text-black
                          "
                          v-if="scanAttemptsPagination.page > 1"
                          @click="scanAttemptsPagination.page--"
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
                            mt-2
                            flex
                            items-center
                            justify-right
                            absolute
                            right-10
                            cursor-pointer
                            text-xs text-gray-500
                            hover:text-black
                          "
                          v-if="scanAttemptsPagination.nextPageAvailable"
                          @click="scanAttemptsPagination.page++"
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
      lastEventTime: null,
      isEventNew: true,
      showHello: true,
      showHello2: true,
      events: {},
      scanAttempts: {},
      permission: 0,
      eventPagination: { page: 1, nextPageAvailable: false },
      scanAttemptsPagination: { page: 1, nextPageAvailable: false },
      attrs: this.$attrs,
    };
  },
  watch: {
    eventPagination: {
      handler(page) {
        this.getEvents(this.eventPagination.page);
      },
      deep: true,
    },
    scanAttemptsPagination: {
      handler(page) {
        this.getScanAttempts(this.scanAttemptsPagination.page);
      },
      deep: true,
    },
  },
  methods: {
    getEvents(page) {
      axios
        .get(
          `/events/teamId/${this.attrs.user.current_team_id}/limit/10/pagination/1?page=${page}`
        )
        .then((response) => {
          this.events = response.data.data;

          this.eventPagination.page = response.data.current_page;
          if (response.data.next_page_url !== null) {
            this.eventPagination.nextPageAvailable = true;
          } else {
            this.eventPagination.nextPageAvailable = false;
          }

          if (this.lastEventTime === null && this.events.length > 0) {
            this.lastEventTime = this.events[0].scan_time;
            this.isEventNew = true;
            return;
          }
          if (this.lastEventTime !== this.events[0].scan_time) {
            this.isEventNew = true;
          } else {
            this.isEventNew = false;
          }
          console.log(this.isEventNew);
          this.lastEventTime = this.events[0].scan_time;
        })
        .catch((err) => {
          // MakeToast.create("Cannot load Events", "error");
        });
    },
    getScanAttempts(page) {
      axios
        .get(
          `/events/teamId/${this.attrs.user.current_team_id}/limit/12/rejected?page=${page}`
        )
        .then((response) => {
          this.scanAttempts = response.data.data;
          this.scanAttemptsPagination.page = response.data.current_page;
          if (response.data.next_page_url !== null) {
            this.scanAttemptsPagination.nextPageAvailable = true;
          } else {
            this.scanAttemptsPagination.nextPageAvailable = false;
          }
        })
        .catch((err) => {
          MakeToast.create("Cannot load Scan attempts", "error");
        });
    },
    isSafari() {
      return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    },
  },
  created() {
    this.isSafari();
    this.getEvents(1);
    this.getScanAttempts(1);
  },
};
</script>

<style>
.parent2 {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  grid-template-rows: 1fr;
}

.area-2-1 {
  grid-area: 1 / 1 / 2 / 4;
}
.area-2-2 {
  grid-area: 1 / 4 / 2 / 6;
}

.rotation-enter {
  transform: rotate(0);
}

.rotation-enter-active,
.rotation-leave-active {
  transition: all 0.5s ease-out;
}

.rotation-leave-to {
  transform: rotate(-360deg);
}

.appear-enter {
  opacity: 0;
}

.appear-enter-active,
.appear-leave-active {
  transition: all 3s cubic-bezier(0.68, 0.38, 0.68, 0.39);
}

.appear-leave-to {
  opacity: 0;
}
</style>
