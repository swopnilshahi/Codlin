<?php
/**
 * Other function, features .. to
 * 
 * admin notices
 *  If whatsapp number not added. 
 * 
 * @since 2.7
 * @package ctc
 * @subpackage admin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_Others' ) ) :

class HT_CTC_Admin_Others {

    public function __construct() {
        $this->admin_hooks();
    }

    function admin_hooks() {

        // clear cache
        add_action( 'update_option_ht_ctc_chat_options', array( $this, 'clear_cache') );
        add_action( 'update_option_ht_ctc_group', array( $this, 'clear_cache') );
        add_action( 'update_option_ht_ctc_share', array( $this, 'clear_cache') );
        add_action( 'update_option_ht_ctc_s2', array( $this, 'clear_cache') );  //customize styles
        add_action( 'update_option_ht_ctc_s4', array( $this, 'clear_cache') );
        add_action( 'update_option_ht_ctc_s8', array( $this, 'clear_cache') );
        add_action( 'update_option_ht_ctc_s99', array( $this, 'clear_cache') );

        $ht_ctc_main_options = get_option('ht_ctc_main_options');

        // if number blank
        if ( isset( $ht_ctc_main_options['enable_chat'] ) ) {
            $ht_ctc_chat_options = get_option('ht_ctc_chat_options');

            if ( isset( $ht_ctc_chat_options['number'] ) ) {
                if ( '' == $ht_ctc_chat_options['number'] ) {
                    add_action('admin_notices', array( $this, 'ifnumberblank') );
                }
            }
        }

        // if group id blank
        if ( isset( $ht_ctc_main_options['enable_group'] ) ) {
            $ht_ctc_group = get_option('ht_ctc_group');

            if ( isset( $ht_ctc_group['group_id'] ) ) {
                if ( '' == $ht_ctc_group['group_id'] ) {
                    add_action('admin_notices', array( $this, 'ifgroupblank') );
                }
            }

        }

        // if share_text blank
        if ( isset( $ht_ctc_main_options['enable_share'] ) ) {
            $ht_ctc_share = get_option('ht_ctc_share');

            if ( isset( $ht_ctc_share['share_text'] ) ) {
                if ( '' == $ht_ctc_share['share_text'] ) {
                    add_action('admin_notices', array( $this, 'ifshareblank') );
                }
            }
        }


    }

    function ifnumberblank() {
        ?>
        <div class="notice notice-info is-dismissible">
            <p>Click to Chat is almost ready. <a href="<?php echo admin_url('admin.php?page=click-to-chat');?>">Add WhatsApp Number</a> and let visitors chat.</p>
            <!-- <p>Click to Chat is almost ready. <a href="<?php // echo admin_url('admin.php?page=click-to-chat');?>">Add WhatsApp Number</a> to display the chat options and let visitors chat.</p> -->
            <!-- <a href="?dismis">Dismiss</a> -->
        </div>
        <?php
    }

    function ifgroupblank() {
        ?>
        <div class="notice notice-info is-dismissible">
            <p>Click to Chat is almost ready. <a href="<?php echo admin_url('admin.php?page=click-to-chat-group-feature');?>">Add WhatsApp Group ID</a> to display the options to let visitors join in your WhatsApp Group.</p>
            <!-- <a href="?dismis">Dismiss</a> -->
        </div>
        <?php
    }

    function ifshareblank() {
        ?>
        <div class="notice notice-info is-dismissible">
            <p>Click to Chat is almost ready. <a href="<?php echo admin_url('admin.php?page=click-to-chat-share-feature');?>">Add Share Text</a> to let vistiors Share your Webpages.</p>
            <!-- <a href="?dismis">Dismiss</a> -->
        </div>
        <?php
    }

    // clear cache after save settings.
    function clear_cache() {
	
        // WP Super Cache
        if ( function_exists( 'wp_cache_clear_cache' ) ) {
            wp_cache_clear_cache();
        }
        // W3 Total Cache
        if ( function_exists( 'w3tc_pgcache_flush' ) ) {
            w3tc_pgcache_flush();
            // w3tc_flush_all();
        }
        // WP Fastest Cache
        if( function_exists('wpfc_clear_all_cache') ) {
            wpfc_clear_all_cache(true);
        }
        // Autoptimize
        if( class_exists('autoptimizeCache') && method_exists( 'autoptimizeCache', 'clearall') ) {
            autoptimizeCache::clearall();
        }
        // WP Rocket
        if ( function_exists( 'rocket_clean_domain' ) ) {
            rocket_clean_domain();
            // rocket_clean_minify();
        }
        // WPEngine
        if ( class_exists( 'WpeCommon' ) && method_exists( 'WpeCommon', 'purge_memcached' ) ) {
        WpeCommon::purge_memcached();
        WpeCommon::purge_varnish_cache();
        }
        // SG Optimizer by Siteground
        if ( function_exists( 'sg_cachepress_purge_cache' ) ) {
            sg_cachepress_purge_cache();
            // SG_CachePress_Supercacher::purge_cache(true);
        }
        // LiteSpeed
        if( class_exists('LiteSpeed_Cache_API') && method_exists('LiteSpeed_Cache_API', 'purge_all') ) {
        LiteSpeed_Cache_API::purge_all();
        }
        // Cache Enabler
        if( class_exists('Cache_Enabler') && method_exists('Cache_Enabler', 'clear_total_cache') ) {
            Cache_Enabler::clear_total_cache();
            // ce_clear_cache();
        }
        // Pagely
        if ( class_exists('PagelyCachePurge') && method_exists('PagelyCachePurge','purgeAll') ) {
            PagelyCachePurge::purgeAll();
        }
        // Comet cache
        if( class_exists('comet_cache') && method_exists('comet_cache', 'clear') ) {
        comet_cache::clear();
        }
        // Hummingbird Cache
        if( class_exists('\Hummingbird\WP_Hummingbird') && method_exists('\Hummingbird\WP_Hummingbird', 'flush_cache') ) {
            \Hummingbird\WP_Hummingbird::flush_cache();
        }

        // todo
        // clear cache
        // if ( function_exists('wp_cache_flush') ) {
        //     wp_cache_flush();
        // }

    }


}

new HT_CTC_Admin_Others();

endif; // END class_exists check