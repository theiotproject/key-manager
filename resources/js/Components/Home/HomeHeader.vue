<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <Head title="Welcome" />
    <nav
        class="m-5 bg-white border-200 px-2 sm:px-4 py-2.5 rounded dark:bg-gray-800"
    >
        <div
            class="container flex flex-wrap justify-between items-center mx-auto"
        >
            <img
                src="../../../../public/images/qwarelogotransparent.png"
                class="ml-3 mr-3 h-6 sm:h-9"
                alt="Qware logo"
            />
            <div class="flex md:order-2">
                <div v-if="canLogin" class="hidden lg:px-6 py-4 sm:block">
                    <Link
                        v-if="$page.props.user"
                        :href="route('dashboard')"
                        class="mr-5 bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                    >
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                        >
                            Login
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="mr-5 ml-3 bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                        >
                            Register
                        </Link>
                    </template>
                </div>
                <!-- hamburger button -->
                <div class="-mr-2 flex items-center md:hidden">
                    <button
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                        @click="
                            showingNavigationDropdown =
                                !showingNavigationDropdown
                        "
                    >
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="justify-between items-center w-full md:flex md:w-auto md:order-1"
                id="mobile-menu"
            >
                <ul
                    class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium"
                >
                    <div v-if="canLogin" class="mt-5 mb-5 sm:hidden">
                        <Link
                            v-if="$page.props.user"
                            :href="route('dashboard')"
                            class="block bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-10 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="mb-2 block bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                            >
                                Login
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="block sm:ml-3 bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                            >
                                Register
                            </Link>
                        </template>
                    </div>
                    <li>
                        <a
                            :class="{ active: routeName === '*/' }"
                            href="#/"
                            class="block py-2 pr-4 pl-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0"
                            aria-current="page"
                            >Home</a
                        >
                    </li>
                    <li>
                        <a
                            :class="{
                                active: routeName === '#/about',
                            }"
                            href="#/about"
                            class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                            >About</a
                        >
                    </li>
                    <li>
                        <a
                            :class="{
                                active: routeName === '#/contact',
                            }"
                            href="#/contact"
                            class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                            >Contact Us</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
import { useRouter } from "vue-router";

export default {
    name: "HomeHeader",
    props: ["canLogin", "canRegister"],
};
</script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap");

.bg-white {
    background-color: #f7f7f7;
}

* {
    font-family: "Ubuntu", sans-serif;
}
.active {
    background-color: indianred;
    cursor: pointer;
}
a {
    font-size: 18px;
}
</style>
