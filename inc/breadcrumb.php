<?php
function the_breadcrumb() {
	echo '<div id="breadcrumb">';
	echo '<ul id="crumbs" class="flush">';
	if (!is_home()) {
		echo '<li>';
            echo '<a href="'. get_option('home'). '">'. 'Inicio' . "</a>";
        echo "</li>";
		//if (is_category() || is_single()) {
			//echo '<li>';
			//the_category(' </li><li> ');
		if (is_single()) {
            $tax      = 'operacion';
            $term     = get_the_terms($post->ID,$tax)[0];
            $termlink = get_term_link($term->term_id,$tax);
            //pr($term);
            //echo "</li>";
            if(isset($term)&& !empty($term)){
                echo "<li>";
                    echo '<a href="'.$termlink.'" title="'.$term->name.'">'.$term->name.'</a>';
                echo "</li>";
            }
            echo "<li>";
            echo '<span>';
			the_title();
            echo '</span>';
			echo '</li>';
		} elseif (is_page()) {
			echo '<li>';
			echo '<span>';
    			echo the_title();
			echo '</span>';
			echo '</li>';
		}
	}
    /*
	elseif (is_tag()) {
        single_tag_title();
    }
	elseif (is_day()) {
        echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';
    }
	elseif (is_month()) {
        echo"<li>Archive for "; the_time('F, Y'); echo'</li>';
    }
	elseif (is_year()) {
        echo"<li>Archive for "; the_time('Y'); echo'</li>';
    }
	elseif (is_author()) {
        echo"<li>Author Archive"; echo'</li>';
    }
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
        echo "<li>Blog Archives"; echo'</li>';
    }
    */
	if (is_search()) {
        echo"<li>";
        $search = get_search_query();
        if(isset($search) && !empty($search)){
            echo "<span>Búsqueda de ". get_search_query().'</span>';
        }else{
            echo "<span>Buscar</span>";
        }
        echo'</li>';
    }
	echo '</ul>';
	echo '</div>';
}
/*
function the_breadcrumb() {
    echo '<ul>';
        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'operacion' ) );
        // Create a list of all the term's parents
            $parent = $term->parent;
            while ($parent):
                $parents[] = $parent;
                $new_parent = get_term_by( 'id', $parent, get_query_var( 'operacion' ));
                $parent = $new_parent->parent;
            endwhile;
            if(!empty($parents)):
                $parents = array_reverse($parents);
                // For each parent, create a breadcrumb item
                foreach ($parents as $parent):
                    $item = get_term_by( 'id', $parent, get_query_var( 'operacion' ));
                    $url  = get_bloginfo('url').'/'.$item->taxonomy.'/'.$item->slug;
                    echo '<li><a href="'.$url.'">'.$item->name.'</a></li>';
            endforeach;
        endif;
        pr(get_the_terms($post->ID,'operacion')[0]);
        //pr($term);
        // Display the current term in the breadcrumb
    echo '<li>'.$term->name.'</li>';
    echo '</ul>';
}
*/
?>
