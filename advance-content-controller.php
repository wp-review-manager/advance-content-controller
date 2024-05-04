<?php
if (!defined('ABSPATH')) {
    exit;
}
/*
Plugin Name: advance-content-controller
Plugin URI: #
Description: A WordPress boilerplate plugin with Vue js.
Version: 1.0.0
Author: #
Author URI: #
License: A "Slug" license name e.g. GPL2
Text Domain: textdomain
*/

if (!defined('ACC_VERSION')) {
    define('ACC_VERSION_LITE', true);
    define('ACC_VERSION', '1.1.0');
    define('ACC_MAIN_FILE', __FILE__);
    define('ACC_URL', plugin_dir_url(__FILE__));
    define('ACC_DIR', plugin_dir_path(__FILE__));
    define('ACC_UPLOAD_DIR', '/advance-content-controller');

    class advanceContentController
    {
        public function boot()
        {
            if (is_admin()) {
                $this->adminHooks();
            }
        }

        public function adminHooks()
        {
            require ACC_DIR . 'includes/autoload.php';

            //Register Admin menu
            $menu = new \advanceContentController\Classes\Menu();
            $menu->register();

            // Top Level Ajax Handlers
            $ajaxHandler = new \advanceContentController\Classes\AdminAjaxHandler();
            $ajaxHandler->registerEndpoints();

            add_action('advance-content-controller/render_admin_app', function () {
                $adminApp = new \advanceContentController\Classes\AdminApp();
                $adminApp->bootView();
            });
        }

        public function textDomain()
        {
            load_plugin_textdomain('advance-content-controller', false, basename(dirname(__FILE__)) . '/languages');
        }
    }

    add_action('plugins_loaded', function () {
        (new advanceContentController())->boot();
    });

    register_activation_hook(__FILE__, function ($newWorkWide) {
        require_once(ACC_DIR . 'includes/Classes/Activator.php');
        $activator = new \advanceContentController\Classes\Activator();
        $activator->migrateDatabases($newWorkWide);
    });

    // disabled admin-notice on dashboard
    add_action('admin_init', function () {
        $disablePages = [
            'advance-content-controller.php',
        ];
        if (isset($_GET['page']) && in_array($_GET['page'], $disablePages)) {
            remove_all_actions('admin_notices');
        }
    });
} else {
    add_action('admin_init', function () {
        deactivate_plugins(plugin_basename(__FILE__));
    });
}
