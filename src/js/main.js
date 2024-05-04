window.advanceContentControllerBus = new window.advanceContentController.Vue();

window.advanceContentController.Vue.mixin({
    methods: {
        applyFilters: window.advanceContentController.applyFilters,
        addFilter: window.advanceContentController.addFilter,
        addAction: window.advanceContentController.addFilter,
        doAction: window.advanceContentController.doAction,
        $get: window.advanceContentController.$get,
        $adminGet: window.advanceContentController.$adminGet,
        $adminPost: window.advanceContentController.$adminPost,
        $post: window.advanceContentController.$post,
        $publicAssets: window.advanceContentController.$publicAssets
    }
});

import {routes} from './routes';

const router = new window.advanceContentController.Router({
    routes: window.advanceContentController.applyFilters('advanceContentController_global_vue_routes', routes),
    linkActiveClass: 'active'
});

import App from './AdminApp';

new window.advanceContentController.Vue({
    el: '#advance-content-controller_app',
    render: h => h(App),
    router: router
});

