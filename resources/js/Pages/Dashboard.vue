<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import GatesWidget from "./Widgets/GatesWidget.vue";
import VirtualKeysWidget from "./Widgets/VirtualKeysWidget.vue";
import UsersWidget from "./Widgets/UsersWidget.vue";
import EventsWidget from "./Widgets/EventsWidget.vue";
import HomeHeader from "../Components/Home/HomeHeader.vue";

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="parent gap-x-5 gap-y-5">
                    <GatesWidget class="max-h-100 area1" v-bind:attrs="attrs" id="gates"/>
                    <UsersWidget class="max-h-100 area2" v-bind:attrs="attrs" />
                    <VirtualKeysWidget
                        class="max-h-100 area3"
                        v-bind:attrs="attrs"
                        id="virtualKeys"
                    />
                    <EventsWidget
                        class="max-h-200 area4"
                        v-bind:attrs="attrs"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import GateShow from "./Gates/Show.vue";
import CreateGateForm from "./Gates/Partials/CreateGateForm.vue";
import introJs from "intro.js";

export default {
    components: {
        GateShow,
        CreateGateForm,
    },
    setup(){
        let tour = introJs();
        tour.setOption({
            steps: [{
                title: 'Welcome',
                intro: 'Hello World! 👋'
            },
                {
                    element: document.querySelector('#gates'),
                    intro: 'This step focuses on an image'
                },
                {
                    title: 'Farewell!',
                    element: document.querySelector('#virtualKeys'),
                    intro: 'And this is our final step!'
                }]
        }).start();
    },
    data() {
        return {
            component: "GateShow",
            attrs: this.$attrs,
        };
    },
    methods: {
        toggle() {
            if (this.component === "GateShow") {
                this.component = "CreateGateForm";
            } else {
                this.component = "GateShow";
            }
        },
    },
};
</script>

<style>
@media only screen and (min-width: 100px) {
    .parent {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: repeat(4, 1fr);
    }

    .area1 {
        grid-area: 1 / 1 / 2 / 2;
    }
    .area2 {
        grid-area: 2 / 1 / 3 / 2;
    }
    .area3 {
        grid-area: 3 / 1 / 4 / 2;
    }
    .area4 {
        grid-area: 4 / 1 / 5 / 2;
    }
}

@media only screen and (min-width: 650px) {
    .parent {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(2, 1fr);
    }

    .area1 {
        grid-area: 1 / 1 / 2 / 2;
    }
    .area2 {
        grid-area: 2 / 1 / 3 / 2;
    }
    .area3 {
        grid-area: 1 / 2 / 2 / 3;
    }
    .area4 {
        grid-area: 2 / 2 / 3 / 3;
    }
}

@media only screen and (min-width: 1250px) {
    .parent {
        display: grid;
        grid-template-columns: 0.8fr 1fr 1.1fr;
        grid-template-rows: repeat(2, 1fr);
    }

    .area1 {
        grid-area: 1 / 1 / 2 / 2;
    }
    .area2 {
        grid-area: 1 / 2 / 2 / 3;
    }
    .area3 {
        grid-area: 2 / 1 / 3 / 3;
    }
    .area4 {
        grid-area: 1 / 3 / 3 / 4;
    }
}

/*.area1  gates*/
/*.area2  users*/
/*.area3  virtual keys*/
/*.area4  events*/
</style>
