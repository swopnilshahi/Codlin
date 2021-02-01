<?php
/**
*  Admin Show/Hide
*
* @package ctc
* @subpackage Administration
* @since 2.8
*/

if ( ! defined( 'ABSPATH' ) ) exit;

$show_or_hide = ( '' == $options ) ? '' : esc_attr( $options['show_or_hide'] );

$list_hideon_pages = ( '' == $options ) ? '' : esc_attr( $options['list_hideon_pages'] );
$list_hideon_cat = ( '' == $options ) ? '' : esc_attr( $options['list_hideon_cat'] );
$list_showon_pages = ( '' == $options ) ? '' : esc_attr( $options['list_showon_pages'] );
$list_showon_cat = ( '' == $options ) ? '' : esc_attr( $options['list_showon_cat'] );


?>

<ul class="collapsible">
<li class="active">
<div class="collapsible-header">Show/Hide on Selected pages</div>
<div class="collapsible-body">

<?php


// Hide on Mobile Devices
if ( isset( $options['hideon_mobile'] ) ) {
    ?>
    <p>
        <label>
            <input name="<?php echo $dbrow ?>[hideon_mobile]" type="checkbox" value="1" <?php checked( $options['hideon_mobile'], 1 ); ?> class="hidebasedondevice" id="hideon_mobile" />
            <span>Hide on - Mobile Devices</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p>
        <label>
            <input name="<?php echo $dbrow ?>[hideon_mobile]" type="checkbox" value="1" class="hidebasedondevice" id="hideon_mobile" />
            <span>Hide on - Mobile Devices</span>
        </label>
    </p>
    <?php
}

// Hide on Desktop Devices
if ( isset( $options['hideon_desktop'] ) ) {
    ?>
    <p>
        <label>
            <input name="<?php echo $dbrow ?>[hideon_desktop]" type="checkbox" value="1" <?php checked( $options['hideon_desktop'], 1 ); ?> class="hidebasedondevice" id="hideon_desktop" />
            <span>Hide on - Desktop Devices</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p>
        <label>
            <input name="<?php echo $dbrow ?>[hideon_desktop]" type="checkbox" value="1" class="hidebasedondevice" id="hideon_desktop" />
            <span>Hide on - Desktop Devices</span>
        </label>
    </p>
    <?php
}
?>
<!-- <p class="description">plugin detects device based on HTTP User agent </p> -->
<p class="description">If working in reverse it might be the cache plugin not detecting the devices - <a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/hide-based-on-device/">more info</a> </p>
<br><hr><br>

<span class="description"><b>Select Show/Hide:</b></span>

<div class="row" style="margin-bottom: 0px;">
    <div class="input-field col s8">
        <select name="<?php echo $dbrow ?>[show_or_hide]" class="select_show_or_hide">
            <option value="hide" <?php echo $show_or_hide == "hide" ? 'SELECTED' : ''; ?> >Hide on selected pages</option>
            <option value="show" <?php echo $show_or_hide == "show" ? 'SELECTED' : ''; ?> >Show on selected pages</option>
        </select>
        <!-- <label><?php _e( 'enable' , 'click-to-chat-for-whatsapp' ) ?></label> -->
    </div>
</div>



<!-- ######### Hide ######### -->



<p class="description ctc_show_hide_display show-hide_display-none hidebased" style="margin-bottom: 15px">
    <?php echo 'Select pages to Hide styles <span style="color: green;"> ( Default Shows on all pages ) ' ?> 
</p>
<!-- <br><br> -->
<?php

// checkboxes - Hide based on Type of posts

// Single Posts
if ( isset( $options['hideon_posts'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_posts]" type="checkbox" value="1" <?php checked( $options['hideon_posts'], 1 ); ?> id="filled-in-box1" />
            <span>Hide on - Posts</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_posts]" type="checkbox" value="1" id="filled-in-box1" />
            <span>Hide on - Posts</span>
        </label>
    </p>
    <?php
}


// Page
if ( isset( $options['hideon_page'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_page]" type="checkbox" value="1" <?php checked( $options['hideon_page'], 1 ); ?> id="filled-in-box2" />
            <span>Hide on - Pages</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_page]" type="checkbox" value="1" id="filled-in-box2" />
            <span>Hide on - Pages</span>
        </label>
    </p>
    <?php
}




// Home Page
// is_home and is_front_page - combined. calling as home/front page
if ( isset( $options['hideon_homepage'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_homepage]" type="checkbox" value="1" <?php checked( $options['hideon_homepage'], 1 ); ?> id="filled-in-box3" />
            <span>Hide on - Home/Front Page</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_homepage]" type="checkbox" value="1" id="filled-in-box3" />
            <span>Hide on - Home/Front Page</span>
        </label>
    </p>
    <?php
}


// Category
if ( isset( $options['hideon_category'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_category]" type="checkbox" value="1" <?php checked( $options['hideon_category'], 1 ); ?> id="filled-in-box5" />
            <span>Hide on - Category</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_category]" type="checkbox" value="1" id="filled-in-box5" />
            <span>Hide on - Category</span>
        </label>
    </p>
    <?php
}



// Archive
if ( isset( $options['hideon_archive'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_archive]" type="checkbox" value="1" <?php checked( $options['hideon_archive'], 1 ); ?> id="filled-in-box6" />
            <span>Hide on - Archive</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
    <label>
            <input name="<?php echo $dbrow ?>[hideon_archive]" type="checkbox" value="1" id="filled-in-box6" />
            <span>Hide on - Archive</span>
        </label>
    </p>
    <?php
}


// 404 Page
if ( isset( $options['hideon_404'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
    <label>
            <input name="<?php echo $dbrow ?>[hideon_404]" type="checkbox" value="1" <?php checked( $options['hideon_404'], 1 ); ?> id="hideon_404" />
            <span>Hide on - 404 Page</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_404]" type="checkbox" value="1" id="hideon_404" />
            <span>Hide on - 404 Page</span>
        </label>
    </p>
    <?php
}


// WooCommerce single product pages
if ( isset( $options['hideon_wooproduct'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
    <label>
            <input name="<?php echo $dbrow ?>[hideon_wooproduct]" type="checkbox" value="1" <?php checked( $options['hideon_wooproduct'], 1 ); ?> id="hideon_wooproduct" />
            <span>Hide on - WooCommerce single product pages</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none hidebased">
        <label>
            <input name="<?php echo $dbrow ?>[hideon_wooproduct]" type="checkbox" value="1" id="hideon_wooproduct" />
            <span>Hide on - WooCommerce single product pages</span>
        </label>
    </p>
    <?php
}


?>
<p class="description ctc_show_hide_display show-hide_display-none hidebased">Check to hide Styles based on the type of pages</p>
<br>

<!-- ID's list to hide styles  -->
<div class="row ctc_show_hide_display show-hide_display-none hidebased">
    <div class="input-field col s7">
        <input name="<?php echo $dbrow ?>[list_hideon_pages]" value="<?php echo $list_hideon_pages ?>" id="ccw_list_id_tohide" type="text" class="input-margin">
        <label for="ccw_list_id_tohide">Id's list to Hide - add ',' after each id </label>
        <p class="description"> Add Post, Page, Media - ID's to hide, can add multiple id's by separating with a comma ( , ) </p>
    </div>
</div>

<!-- Categorys list - to hide -->
<div class="row ctc_show_hide_display show-hide_display-none hidebased">
    <div class="input-field col s7">
        <input name="<?php echo $dbrow ?>[list_hideon_cat]" value="<?php echo $list_hideon_cat ?>" id="ccw_list_cat_tohide" type="text" class="input-margin">
        <label for="ccw_list_cat_tohide"><?php _e( 'Category name\'s to Hide - add \',\' after each category name' , 'click-to-chat-for-whatsapp' ) ?> </label>
        <p class="description">Add Categories name to hide, can add multiple Categories by separating with a comma ( , ) </p>
    </div>
</div>



<!-- ######### Show ######### -->



<p class="description ctc_show_hide_display show-hide_display-none showbased" style="margin-bottom: 15px">
    <?php echo 'Select pages to display styles <span style="background-color: #dddddd; color: red;"> ( Default hides on all pages ) ' ?> 
</p>
<?php

// checkboxes - Show based on Type of posts

// Single Posts
if ( isset( $options['showon_posts'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_posts]" type="checkbox" value="1" <?php checked( $options['showon_posts'], 1 ); ?> id="show_filled-in-box1" />
            <span>Show on - Posts</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_posts]" type="checkbox" value="1" id="show_filled-in-box1" />
            <span>Show on - Posts</span>
        </label>
    </p>
    <?php
}


// Page
if ( isset( $options['showon_page'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_page]" type="checkbox" value="1" <?php checked( $options['showon_page'], 1 ); ?> id="show_filled-in-box2" />
            <span>Show on - Pages</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_page]" type="checkbox" value="1" id="show_filled-in-box2" />
            <span>Show on - Pages</span>
        </label>
    </p>
    <?php
}


// Home Page
// is_home and is_front_page - combined. calling as home/front page
if ( isset( $options['showon_homepage'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_homepage]" type="checkbox" value="1" <?php checked( $options['showon_homepage'], 1 ); ?> id="show_filled-in-box3" />
            <span>Show on - Home/Front Page</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_homepage]" type="checkbox" value="1" id="show_filled-in-box3" />
            <span>Show on - Home/Front Page</span>
        </label>
    </p>
    <?php
}


// Category
if ( isset( $options['showon_category'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_category]" type="checkbox" value="1" <?php checked( $options['showon_category'], 1 ); ?> id="show_filled-in-box5" />
            <span>Show on - Category</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_category]" type="checkbox" value="1" id="show_filled-in-box5" />
            <span>Show on - Category</span>
        </label>
    </p>
    <?php
}

// Archive
if ( isset( $options['showon_archive'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_archive]" type="checkbox" value="1" <?php checked( $options['showon_archive'], 1 ); ?> id="show_filled-in-box6" />
            <span>Show on - Archive</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_archive]" type="checkbox" value="1" id="show_filled-in-box6" />
            <span>Show on - Archive</span>
        </label>
    </p>
    <?php
}


// 404 Page
if ( isset( $options['showon_404'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_404]" type="checkbox" value="1" <?php checked( $options['showon_404'], 1 ); ?> id="showon_404" />
            <span>Show on - 404 Page</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_404]" type="checkbox" value="1" id="showon_404" />
            <span>Show on - 404 Page</span>
        </label>
    </p>
    <?php
}


// WooCommerce single product pages
if ( isset( $options['showon_wooproduct'] ) ) {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_wooproduct]" type="checkbox" value="1" <?php checked( $options['showon_wooproduct'], 1 ); ?> id="showon_wooproduct" />
            <span>Show on - WooCommerce Single product pages</span>
        </label>
    </p>
    <?php
} else {
    ?>
    <p class="ctc_show_hide_display show-hide_display-none showbased">
        <label>
            <input name="<?php echo $dbrow ?>[showon_wooproduct]" type="checkbox" value="1" id="showon_wooproduct" />
            <span>Show on - WooCommerce Single product pages</span>
        </label>
    </p>
    <?php
}


?>
<p class="description ctc_show_hide_display show-hide_display-none showbased">Check to display Styles based on type of the page</p>
<br>

<!-- ID's list to show styles -->
<div class="row ctc_show_hide_display show-hide_display-none showbased">
    <div class="input-field col s7">
        <input name="<?php echo $dbrow ?>[list_showon_pages]" value="<?php echo $list_showon_pages ?>" id="ccw_list_id_toshow" type="text" class="input-margin">
        <label for="ccw_list_id_toshow">Id's list to show - add ',' after each id </label>
        <p class="description"> Add Post, Page, Media - ID's to show styles, can add multiple id's by separating with a comma ( , ) </p>
    </div>
</div>


<!-- Categorys list - to show -->
<div class="row ctc_show_hide_display show-hide_display-none showbased">
    <div class="input-field col s7">
        <input name="<?php echo $dbrow ?>[list_showon_cat]" value="<?php echo $list_showon_cat ?>" id="ccw_list_cat_toshow" type="text" class="input-margin">
        <label for="ccw_list_cat_toshow"><?php _e( 'Category name\'s to Show - add \',\' after each category name' , 'click-to-chat-for-whatsapp' ) ?> </label>
        <p class="description">Add Categories name to show styles, can add multiple Categories by separating with a comma ( , ) </p>
    </div>
</div>

<p class="description"><a target="_blank" href="https://www.holithemes.com/plugins/click-to-chat/show-hide-styles/">more info</a> </p>
<br>
<p class="description">Usescases:</p>
<p class="description">> <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/show-only-on-selected-pages/">Show only on selected pages</a></p>
<p class="description">> <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/hide-only-on-selected-pages/">Hide only on selected pages</a> </p>
<p class="description">> <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/show-hide-on-mobile-desktop/">Show/Hide on Mobile/Desktop</a></p>


</div>
</li>
<ul>