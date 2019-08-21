require('./bootstrap');

import YTAPILoader from "./Video/YTAPI";
import VideoController from "./Video/VideoController";
import LyricsDisplayController from "./Lyrics/LyricsDisplayController";
import LyricsSyncController from "./Lyrics/LyricsSyncController";

window.app = {
    YTAPILoader: YTAPILoader,
    controllers: {
        VideoController: VideoController,
        LyricsDisplayController: LyricsDisplayController,
        LyricsSyncController: LyricsSyncController
    }
};

/*LyricsSyncController: LyricsSyncController*/
/*window.Vue = require('vue');*/

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

/*const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));*/

/*Vue.component('example-component', require('./components/ExampleComponent.vue').default);*/

/*const app = new Vue({
    el: '#app',
});*/