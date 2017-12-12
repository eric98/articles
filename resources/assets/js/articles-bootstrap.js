// Register components
Vue.component('articles-example', require('./components/ArticlesExampleComponent.vue'));
Vue.component('users', require('./components/Users.vue'));
Vue.component('articles', require('./components/ArticlesComponent.vue'));
Vue.component('widget', require('./components/WidgetComponent.vue'));
Vue.component('message', require('./components/MessageComponent.vue'));

import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)

import { config } from './config/articles'

window.ergare_articles = {}
window.ergare_articles.config = config