import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import '../css/app.css'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    library.add(fas)

    createApp({ render: () => h(App, props) })
      .component('fa', FontAwesomeIcon)
      .use(plugin)
      .mount(el)
  },
})