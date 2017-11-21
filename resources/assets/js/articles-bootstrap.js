// Register components
Vue.component('articles-example', require('./components/ArticlesExampleComponent.vue'));
Vue.component('users', require('./components/Users.vue'));

import { config } from './config/articles'

window.ergare_articles = {}
window.ergare_articles.config = config