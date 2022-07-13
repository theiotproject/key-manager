<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
</script>

<template>
    <div class="mt-20 bg-white sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                <img
                    src="../../../../public/images/aboutlogo.jpg"
                    alt="Key with Phone"
                />
            </div>
            <div class="p-6">
                <div class="description">
                    <h2>The Key Manager Project</h2>
                    <p>
                        Dedicated website & mobile application, works out of the
                        box and is easy to manage. It’s the most convenient tool
                        you’ve been craving
                    </p>
                    <Link
                        :href="route('login')"
                        class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                    >
                        VISIT BLOG
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap");

.bg-white {
    background-color: #f7f7f7;
}
.description h2 {
    font-size: 48px;
    font-weight: 700;
    color: #03045e;
    font-family: "Ubuntu", sans-serif;
}
.description p {
    opacity: 70%;
    color: #03045e;
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
}
</style>
