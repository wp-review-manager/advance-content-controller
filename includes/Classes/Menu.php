<?php

namespace advanceContentController\Classes;

class Menu
{
    public function register()
    {
        add_action('admin_menu', array($this, 'addMenus'));
    }

    public function addMenus()
    {
        $menuPermission = AccessControl::hasTopLevelMenuPermission();
        if (!$menuPermission) {
            return;
        }

        $title = __('Advance Content Controller', 'textdomain');
        global $submenu;
        add_menu_page(
            $title,
            $title,
            $menuPermission,
            'advance-content-controller.php',
            array($this, 'enqueueAssets'),
            'dashicons-admin-site',
            25
        );

        $submenu['advance-content-controller.php']['my_profile'] = array(
            __('Plugin Dashboard', 'textdomain'),
            $menuPermission,
            'admin.php?page=advance-content-controller.php#/',
        );
        $submenu['advance-content-controller.php']['settings'] = array(
            __('Settings', 'textdomain'),
            $menuPermission,
            'admin.php?page=advance-content-controller.php#/settings',
        );
        $submenu['advance-content-controller.php']['supports'] = array(
            __('Supports', 'textdomain'),
            $menuPermission,
            'admin.php?page=advance-content-controller.php#/supports',
        );
    }

    public function enqueueAssets()
    {
        do_action('advance-content-controller/render_admin_app');
        wp_enqueue_script(
            'advance-content-controller_boot',
            ACC_URL . 'assets/js/boot.js',
            array('jquery'),
            ACC_VERSION,
            true
        );

        // 3rd party developers can now add their scripts here
        do_action('advance-content-controller/booting_admin_app');
        wp_enqueue_script(
            'advance-content-controller_js',
            ACC_URL . 'assets/js/plugin-main-js-file.js',
            array('advance-content-controller_boot'),
            ACC_VERSION,
            true
        );

        //enque css file
        wp_enqueue_style('advance-content-controller_admin_css', ACC_URL . 'assets/css/element.css');

        $advanceContentControllerAdminVars = apply_filters('advance-content-controller/admin_app_vars', array(
            //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
            'assets_url' => ACC_URL . 'assets/',
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

        wp_localize_script('advance-content-controller_boot', 'advanceContentControllerAdmin', $advanceContentControllerAdminVars);
    }
}
