<?php
extract( shortcode_atts( array(
	'css'   => '',
    'style' => 'style_1'
), $atts ) );

if(empty($style)) $style = 'style_1';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

stm_module_styles('searchbox', $style); ?>

<div class="stm_searchbox <?php echo esc_attr($css_class . ' ' . $style); ?>">

    <?php

    if (class_exists('STM_LMS_Course')):
    wp_enqueue_script('vue-resource.js');
    stm_module_styles('vue-autocomplete', 'vue2-autocomplete');
    stm_module_scripts('vue-autocomplete', 'vue2-autocomplete', array());
    stm_module_scripts('courses_search', 'courses_search');
    ?>

    <script>
        var stm_lms_search_value = '<?php echo (!empty($_GET['search'])) ? sanitize_text_field($_GET['search']) : ''; ?>';
    </script>

    <div class="stm_lms_courses_search vue_is_disabled" id="stm_lms_courses_search" v-bind:class="{'is_vue_loaded' : vue_loaded}">
        {{ search }}
        <a v-bind:href="'<?php echo esc_url(STM_LMS_Course::courses_page_url()) ?>?search=' + url"
           class="stm_lms_courses_search__button sbc">
            <?php if($style === 'style_1'): ?>
                <i class="lnricons-magnifier"></i>
            <?php else: ?>
                <span class="heading_font"><?php esc_html_e('Find Course', 'masterstudy'); ?></span>
            <?php endif; ?>
        </a>
        <autocomplete
                name="search"
                placeholder="<?php esc_attr_e('Search courses...', 'masterstudy'); ?>"
                url="<?php echo esc_url(rest_url('stm-lms/v1/courses', 'json')) ?>"
                param="search"
                anchor="value"
                label="label"
                :on-select="searchCourse"
                :on-input="searching"
                :on-ajax-loaded="loaded"
                :debounce="1000"
                model="search">
        </autocomplete>
    </div>

    <?php endif; ?>
<!--    <form action="--><?php //echo esc_url(STM_LMS_Course::courses_page_url()); ?><!--">-->
<!--        <input name="search" class="form-control" placeholder="--><?php //esc_attr_e('Search Courses...', 'masterstudy'); ?><!--" />-->
<!---->
<!--        <button type="submit">-->
<!--            --><?php //if($style === 'style_1'): ?>
<!--            <i class="lnricons-magnifier"></i>-->
<!--            --><?php //else: ?>
<!--            <span class="heading_font"><i class="lnricons-magnifier"></i>--><?php //esc_html_e('Find Course', 'masterstudy'); ?><!--</span>-->
<!--            --><?php //endif; ?>
<!--        </button>-->
<!---->
<!--    </form>-->
</div>
