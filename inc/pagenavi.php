<?php

function pagenavi( $p = 2 ) { // pages will be show before and after current page
    $labelFirst = __('Primera');
    $labelLast  = __('Última');
    $labelPage  = __('Página');
    $class      = 'page-numbers btn btn-secondary';
    $current    = 'current btn btn-disabled';

    if ( is_singular() ){
        return; // don't show in single page
    }

    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;

    if ( $max_page == 1 ){
        return; // don't show when only one page
    }

    if ( empty( $paged ) ){
        $paged = 1;
    }

    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; // pages
    if ( $paged > $p + 1 ){
        p_link( 1, $labelFirst );
    }
    if ( $paged > $p + 2 ){
        echo '<span class="btn btn-disabled">'.'&hellip;'.'</span> ';
    }
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { // Middle pages
        if ( $i > 0 && $i <= $max_page ){
            if($i == $paged){
                echo '<span class="'.$class.' '.$current.'">'.$i.'</span> ';
            } else {
                p_link( $i );
            }

        }
    }
    if ( $paged < $max_page - $p - 1 ) {
        echo '<span class="btn btn-disabled">'.'&hellip;'.'</span> ';
    }
    if ( $paged < $max_page - $p ){
        p_link( $max_page, $labelLast );
    }
}
function p_link( $i, $title = '' ) {
    $labelFirst = __('Primera');
    $labelLast  = __('Última');
    $labelPage  = __('Página');
    $class      = 'page-numbers btn btn-secondary';
    $current    = 'current btn btn-disabled';

    if ( $title == '' ){
        $title = "Page {$i}";
    }
    echo '<a class="'.$class.'" href="'.esc_html( get_pagenum_link( $i ) ).'" title="'.$title.'">'.$i.'</a> ';
}
?>
