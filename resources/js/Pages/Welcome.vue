<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
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
                src="../../../public/images/qwarelogotransparent.png"
                class="ml-32 mr-3 h-6 sm:h-9"
                alt="Qware logo"
            />
            <div class="flex md:order-2">
                <div v-if="canLogin" class="hidden px-6 py-4 sm:block">
                    <Link
                        v-if="$page.props.user"
                        :href="route('dashboard')"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
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
                            class="ml-3 bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                        >
                            Register
                        </Link>
                    </template>
                </div>
                <button
                    data-collapse-toggle="mobile-menu-4"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="mobile-menu-4"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="w-6 h-6"
                        aria-hidden="true"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    <svg
                        class="hidden w-6 h-6"
                        aria-hidden="true"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </button>
            </div>
            <div
                class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1"
                id="mobile-menu-4"
            >
                <ul
                    class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium"
                >
                    <li>
                        <a
                            href="#"
                            class="block py-2 pr-4 pl-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white"
                            aria-current="page"
                            >Home</a
                        >
                    </li>
                    <li>
                        <a
                            href="#"
                            class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                            >About Us</a
                        >
                    </li>
                    <li>
                        <a
                            href="#"
                            class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                            >Services</a
                        >
                    </li>
                    <li>
                        <a
                            href="#"
                            class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                            >Contact Us</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="mt-24">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-8 bg-white sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="description">
                            <h2>Why use keys if you have a phone?</h2>
                            <p>
                                Dedicated website & mobile application, works
                                out of the box and is easy to manage. It’s the
                                most convenient tool you’ve been craving
                            </p>
                            <Link
                                :href="route('login')"
                                class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                            >
                                START
                            </Link>
                        </div>
                    </div>

                    <div class="p-6">
                        <img
                            src="../../../public/images/qrcodebusiness.jpg"
                            alt="QR Code business"
                        />
                    </div>
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
<script>
export default {
    name: "About",
    created() {
        document.body.style.backgroundColor = "#f7f7f7";
    },
};
</script>
