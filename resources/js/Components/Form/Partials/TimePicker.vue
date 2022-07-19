<template>
    <div class="box xs:flex mt-3">
        <div class="xs:mr-5">
            <JetLabel for="select_time_from" value="From" />
            <VueTimepicker
                class=""
                hide-clear-button
                :minute-interval="5"
                advanced-keyboard
            />
        </div>
        <div>
            <JetLabel for="select_time_to" value="To" />
            <VueTimepicker
                advanced-keyboard
                hide-clear-button
                :minute-interval="5"
            />
        </div>
    </div>
</template>
