<script setup>
import HomeHeader from "../Components/Home/HomeHeader.vue";
import HomeMain from "../Components/Home/HomeMain.vue";
import About from "../Components/Home/About.vue";
import Contact from "../Components/Home/Contact.vue";
import Footer from "../Components/Footer.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <header class="sticky top-0 z-50 shadow-lg">
        <HomeHeader
            class="bg-white"
            v-bind:canLogin="$props.canLogin"
            v-bind:canRegister="$props.canRegister"
        />
    </header>
    <span id="home"></span>
    <main class="relative">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <section class="vh-100">
                <HomeMain />
            </section>
            <span id="about"></span>
            <section class="vh-100 bg-white">
                <About />
            </section>
            <span id="contact"></span>
            <section class="vh-100" id="contact">
                <Contact />
            </section>
        </div>
    </main>
    <Footer />
</template>

<script>
export default {
    name: "About",
    created() {
        document.body.style.backgroundColor = "#f7f7f7";
    },
};
</script>
<style>
.bg-white {
    background-color: #f7f7f7;
}
</style>
