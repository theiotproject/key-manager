<script setup>
import { onMounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {Link, usePage} from "@inertiajs/inertia-vue3";
import GatesWidget from "./Widgets/GatesWidget.vue";
import VirtualKeysWidget from "./Widgets/VirtualKeysWidget.vue";
import UsersWidget from "./Widgets/UsersWidget.vue";
import EventsWidget from "./Widgets/EventsWidget.vue";
import HomeHeader from "../Components/Home/HomeHeader.vue";
import introJs from "intro.js";

onMounted(() => {
    const user = usePage().props.value.user;
    if(user.tours?.dashboard === true){
        return;
    }

  let tour = introJs();
  tour.setOptions({
    steps: [
      {
        title: `Welcome to Key Manager!`,
        intro: `Let me show you around! I'll be quick, I promise!`,
      },
      {
        intro: `Here you can add your first gate by clicking this button`,
        element: document.querySelector("#firstStepTour"),
          onchange: function(){
            console.log("dziala");
          }
      },
      {
        intro: `Then you can give your teammates access to your gates by creating Virtual Keys`,
        element: document.querySelector("#secondStepTour"),
      },
    ],
  });

    createStepEvents: function( tourObject, eventList ){

        //underscore loop used here, foreach would work just as well
        _.each( eventList, function( event ){

            //for the guid object's <event> attribute...
            guideObject[event]( function(){

                //get its steps and current step value
                var steps       = this._options.steps,
                    currentStep = this._currentStep;

                //if it's a function, execute the specified <event> type
                if( _.isFunction(steps[currentStep][event]) ){
                    steps[currentStep][event]();
                }
            });

        }, this );
    }

//setup the events per step you care about for this guide
    createStepEvents( guide, ['onchange','onbeforechange']);

  tour.onexit(() => {
    axios.put(`/tours`, { tour: `dashboard` });
  });
  tour.start();
});
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
          <GatesWidget
            class="max-h-100 area1"
            v-bind:attrs="attrs"
            id="firstStepTour"
          />
          <UsersWidget class="max-h-100 area2" v-bind:attrs="attrs" />
          <VirtualKeysWidget
            id="secondStepTour"
            class="max-h-100 area3"
            v-bind:attrs="attrs"
          />
          <EventsWidget class="max-h-200 area4" v-bind:attrs="attrs" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import GateShow from "./Gates/Show.vue";
import CreateGateForm from "./Gates/Partials/CreateGateForm.vue";

export default {
  components: {
    GateShow,
    CreateGateForm,
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
