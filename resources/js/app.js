import '../css/app.css';
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primeicons/primeicons.css'


import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import PrimeVue from "primevue/config";
import Ripple from 'primevue/ripple';
import StyleClass from 'primevue/styleclass';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                ripple: true,
                // unstyled: true,
            })
            .directive('ripple', Ripple)
            .directive('styleclass', StyleClass)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
