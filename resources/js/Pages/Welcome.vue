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
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 xl:px-0">
            <!-- <section class="h-screen">
                <HomeMain />
            </section>
            <span id="about"></span>
            <section class="h-screen bg-white">
                <About />
            </section>
            <span id="contact"></span>
            <section class="md:h-screen" id="contact">
                <Contact />
            </section> -->

            <section class="">
                <HomeMain />
            </section>
            <span id="about"></span>
            <section class="bg-white">
                <About />
            </section>
            <span id="contact"></span>
            <section class="" id="contact">
                <Contact />
            </section>
        </div>
    </main>
    <Footer />
</template>

<script>
export default {
    name: "About",
    metaInfo() {
        return {
            // title: 'Key Manager - Why use the keys if you have a Phone?',
            title: "Key Manager",
            meta: [
                {
                    name: "description",
                    content:
                        "Our goal is to replace a regular key by a system which will open a lock by reading a QR code out of our smartphone. System is based on raspberry, literally pulled out of the company trash.",
                },
                {
                    property: "og:title",
                    content:
                        "Key Manager - Why use the keys if you have a Phone?",
                },
                { property: "og:site_name", content: "Key Manager" },
                { property: "og:type", content: "website" },
                { name: "robots", content: "index,follow" },
            ],
        };
    },
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
