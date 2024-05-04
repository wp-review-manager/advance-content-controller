import Vue from './elements';
import Router from 'vue-router';
Vue.use(Router);

import { applyFilters, addFilter, addAction, doAction } from '@wordpress/hooks';

export default class advanceContentController {
    constructor() {
        this.applyFilters = applyFilters;
        this.addFilter = addFilter;
        this.addAction = addAction;
        this.doAction = doAction;
        this.Vue = Vue;
        this.Router = Router;
    }

    $publicAssets(path){
        return (window.advanceContentControllerAdmin.assets_url + path);
    }

    $get(options) {
        return window.jQuery.get(window.advanceContentControllerAdmin.ajaxurl, options);
    }

    $adminGet(options) {
        options.action = 'advance-content-controller_admin_ajax';
        return window.jQuery.get(window.advanceContentControllerAdmin.ajaxurl, options);
    }

    $post(options) {
        return window.jQuery.post(window.advanceContentControllerAdmin.ajaxurl, options);
    }

    $adminPost(options) {
        options.action = 'advance-content-controller_admin_ajax';
        return window.jQuery.post(window.advanceContentControllerAdmin.ajaxurl, options);
    }

    $getJSON(options) {
        return window.jQuery.getJSON(window.advanceContentControllerAdmin.ajaxurl, options);
    }
}
