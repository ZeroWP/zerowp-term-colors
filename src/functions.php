<?php
if (!function_exists('ztc_get_colored_labels')) {
    function ztc_get_colored_labels($taxonomy, $links = false, $limit = false, $post_id = false)
    {
        $open_tag  = $links ? '<a' : '<span';
        $close_tag = $links ? '</a>' : '</span>';
        $index     = 0;

        /* Get terms
        -----------------*/
        $terms = get_the_terms($post_id, $taxonomy);
        if (!$terms || is_wp_error($terms)) {
            $terms = [];
        }

        $terms = array_values($terms);
        $terms = apply_filters('ztc_colored_labels_the_terms', $terms, $post_id);

        $final_terms = [];

        /* Build the terms html list
        ---------------------------------*/
        if (!empty($terms)) {
            foreach ($terms as $term) {
                $href          = ($open_tag == '<a') ? ' href="' . get_category_link($term->term_id) . '"' : '';
                $class         = apply_filters('ztc_colored_labels_class', 'ztc-term-label-' . absint($term->term_id), $term);
                $final_terms[] = $open_tag . $href . ' class="' . $class . '">' . $term->name . $close_tag;

                $index++;
                if ($limit && $index === $limit) {
                    break;
                }
            }
        }

        /* Print the HTML
        ----------------------*/

        return join(
            apply_filters('ztc_colored_labels_join_delimiter', ''),
            apply_filters('ztc_colored_labels_final_terms', $final_terms)
        );
    }
}

if (!function_exists('ztc_colored_labels')) {
    function ztc_colored_labels($taxonomy, $links = false, $limit = false, $post_id = false)
    {
        echo ztc_get_colored_labels($taxonomy, $links, $limit, $post_id);
    }
}
