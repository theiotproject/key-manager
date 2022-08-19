<script setup></script>
<template>
    <widgetbot
        server="1007191478210138122"
        channel="1010108634258219018"
        width="800"
        height="600"
    ></widgetbot>
</template>
<script>
export default {
    components: {},
    mounted() {
        let discordScript = document.createElement("script");
        discordScript.setAttribute(
            "src",
            "https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"
        );
        document.head.appendChild(discordScript);
    },
};
</script>
