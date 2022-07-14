<script setup>
import ContactForm from "./ContactForm.vue";
</script>

<template>
    <div class="mt-20 sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6 pb-0">
                <div class="description text-center">
                    <h2>Contact Us!</h2>
                </div>
                <ContactForm />
            </div>
            <div class="p-6 pt-0 text-center m-auto">
                <img
                    src="../../../../public/images/peoplecontact.jpg"
                    alt="Key with Phone"
                />
            </div>
        </div>
    </div>
</template>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap");

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
