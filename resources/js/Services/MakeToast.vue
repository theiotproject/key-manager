<script>
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
// import 'vue-toast-notification/dist/theme-default.css';
const $toast = useToast();

export default {
    create(message, type) {
        let instance = $toast.default(message, {
            position: "bottom-right",
            type: type,
            duration: 4000,
        });
    },
    // error(message) {
    //     let instance = $toast.error(message);
    // },
    // warning(message) {
    //     let instance = $toast.warning(message);
    // },
    // info(message) {
    //     let instance = $toast.info(message);
    // },
    // default(message) {
    //     let instance = $toast.default(message);
    // },
};
</script>
