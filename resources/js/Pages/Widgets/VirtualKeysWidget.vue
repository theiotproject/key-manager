
    <script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetModal from "@/Jetstream/DialogModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
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
                    <th scope="col" class="lg:px-3 md:px-0 py-3 px-5">Label</th>
                    <th scope="col" class="lg:px-3 md:px-0 py-3 px-5 sm:rounded-r-lg rounded-none"></th>
                </tr>
              </thead>
                <thead class="text-xs text-white uppercase bg-blue-500" v-if="isSafari()">
                <tr>
                    <th scope="col" class="px-6 py-3 sm:rounded-l-lg rounded-none">User</th>
                    <th scope="col" class="lg:px-3 md:px-0 py-3">Label</th>
                    <th scope="col" class="lg:px-3 md:px-0 py-3 sm:rounded-r-lg rounded-none"></th>
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
                    <td v-if="index <=2" class="
                      lg:px-3
                      md:px-0
                      py-4
                      font-medium
                      text-gray-900
                      whitespace-nowrap">
                        <button class="ml-6 text-sm text-blue-500" @click="generateQrCode(virtualKey)">
                            Generate QR Code
                        </button>
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
      <JetModal
          :show="this.showQrCode"
          @close="this.showQrCode=null; this.timer = false"
      >
          <template #title> {{this.usedVirtualKey}} </template>

          <template #content>
              <p class="py-5">Time left to scan this code: {{this.countDown.toFixed(1)}}</p>
              <qrcode-vue :value="qrCode.value" :size="300" level="H" />
          </template>

          <template #footer>
              <JetSecondaryButton @click="this.showQrCode=null; this.timer = false">
                  Cancel
              </JetSecondaryButton>
          </template>
      </JetModal>
  </div>
</template>
<script>
import QrcodeVue from 'qrcode.vue'

export default {
  name: "VirtualKeyWidget",
  props: ["attrs"],
  data() {
    return {
        qrCode: {
            value: '',
            size: 250
        },
        timer: false,
        countDown: 60,
        usedVirtualKey: '',
        showQrCode: false,
        gates: {},
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
      },
      async generateQrCode(virtualKey) {
          await axios
              .get(`/api/gates/virtualKeyId/${virtualKey.id}`)
              .then((response) => {
                  this.gates = response.data;
              })
              .catch((err) => {
                  MakeToast.create("Cannot load gates", "error");
              });
          const currentDate = new Date();
          const validFrom = currentDate.toISOString().slice(0, 10) + " " + currentDate.getHours() + ":" + (currentDate.getMinutes() < 10 ? '0' : '') + currentDate.getMinutes() + ":" + currentDate.getSeconds();
          const validTo = currentDate.toISOString().slice(0, 10) + " " + currentDate.getHours() + ":" + (currentDate.getMinutes() < 9 ? '0' : '') + (currentDate.getMinutes() + 1) + ":" + currentDate.getSeconds();

          const gateSerialNumbers = Array.from(this.gates).map(gate => gate.serial_number).toString();

          this.qrCode.value = "OPEN:ID:" + this.generateGuid() + ";VF:" + validFrom + ";VT:" + validTo + ";L:" + gateSerialNumbers + ";;";
          this.usedVirtualKey = virtualKey.label;
          this.timer = true;
          this.countDown = 60;
          this.countDownTimer();
          this.showQrCode = true;
          },
      generateGuid() {
          return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, (c) =>
              (
                  c ^
                  (crypto.getRandomValues(new Uint8Array(1))[0] &
                      (15 >> (c / 4)))
              ).toString(16)
          );
      },
      countDownTimer () {
          if (this.countDown > 0 && this.timer === true) {
              setTimeout(() => {
                  this.countDown -= 0.1
                  this.countDownTimer()
              }, 100)
          }
      }
  },
  created() {
      this.isSafari();
    this.getVirtualKeys();
    this.getPermission();
  },
};
</script>
