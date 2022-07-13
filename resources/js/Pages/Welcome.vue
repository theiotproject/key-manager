<script setup>
import HomeHeader from "../Components/Home/HomeHeader.vue";
import HomeMain from "../Components/Home/HomeMain.vue";
import About from "../Components/Home/About.vue";
import Contact from "../Components/Home/Contact.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <HomeHeader
        v-bind:canLogin="$props.canLogin"
        v-bind:canRegister="$props.canRegister"
    />
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <component :is="currentView" />
    </div>
</template>

<script>
export default {
    name: "About",
    created() {
        document.body.style.backgroundColor = "#f7f7f7";
    },
    data() {
        return {
            currentPath: window.location.hash,
        };
    },
    computed: {
        currentView() {
            return routes[this.currentPath.slice(1) || "/"] || NotFound;
        },
    },
    mounted() {
        window.addEventListener("hashchange", () => {
            this.currentPath = window.location.hash;
        });
    },
};

const routes = {
    "/": HomeMain,
    "/about": About,
    "/contact": Contact,
};
</script>
