<form action="<?php bloginfo('siteurl'); ?>" id="searchform" method="get" class="form">
    <?php /*
    <h2 class="title-main">Buscador de propiedades</h2>
    */
    ?>
    <div class="form search-form">
        <?php /*
        <?php if(!is_front_page()): ?>
            <div class="panel-head">
                <h2>Buscador de propiedades</h2>
            </div>
        <?php endif; ?>
        */ ?>
        <div>

            <ul class="search-fields-list">
                <?php
                //$inputLabel   = '<label for="s">Buscar</label>';
                $inputContent = '<input type="text" id="s" name="s" value="'. get_search_query() .'" placeholder="Buscar"/>';
                //$inputContent .= '<input type="hidden" name="post_type" value="propiedad" />';

                $inputContent .= '<input type="hidden" name="search" value="advanced">';

                //string de busqueda invisible
                echo '<li class="invisible"><div class="input">'.$inputLabel.$inputContent.'</div></li>';
                //echo '<li><div class="input">'.$inputLabel.$inputContent.'</div></li>';

                if($_GET['search'] == 'advanced'){
                    echo '<input class="invisible" type="hidden" name="search" value="advanced">';
                }

                $taxonomies = array('tipo','operacion','location','features');
                $args = array('order'=>'DESC','hide_empty'=>true);
                echo get_terms_dropdown($taxonomies, $args);

                function get_terms_dropdown($taxonomies, $args){
                    foreach($taxonomies as $taxonomy){
                        $label     = '';
                        $thisQuery = get_query_var($taxonomy);
                        $terms     = get_terms($taxonomy, $args);
                        switch($taxonomy){
                            case 'tipo';
                            $empty = 'Elija un Tipo';
                            $label = 'Propiedad';
                            $plural = 'propiedades';
                            //$label = 'Tipo de propiedad';
                            break;

                            case 'operacion';
                            $empty = 'Elija una Operación';
                            $label = 'Operación';
                            $plural = 'Operaciones';
                            //$label = 'Tipo de operación';
                            break;

                            case 'features';
                            $empty = 'Elija una PRestacion';
                            $label = 'Prestaciones';
                            $plural = 'Prestaciones';
                            //$label = 'Tipo de operación';
                            break;

                            case 'location';
                            $empty = 'Localidad';
                            //$empty = 'Elija una Localidad';
                            $label = 'Localidad';
                            $plural = 'Localidades';
                            break;
                        }

                        if($taxonomy == 'location'){
                            $terms = get_terms($taxonomy, array('orderby' => 'term_group', 'hierarchical' => true));
                            if ( !empty( $terms ) && !is_wp_error( $terms ) ){
                                //$inputLabel   = '<label for="'.$taxonomy.'">'.$label.'</label>';
                                $inputContent = '<div class="select-wrapper">';
                                $inputContent .= '<select id="'.$taxonomy.'" name="'.$taxonomy.'">';
                                $inputContent .= '<option value="" disabled selected>Localidad</option>';
                                $inputContent .= '<option value="">Todas las '.$plural.'</option>';
                                //foreach( get_terms( $taxonomy, array( 'hide_empty' => false) ) as $term ) {
                                //foreach( get_terms( $taxonomy, array( 'hide_empty' => false, 'parent' => 0 ) ) as $term ) {
                                $i = 0;
                                foreach($terms as $term){
                                    $selected = '';
                                    if($thisQuery == $term->slug){
                                        $selected = 'selected';
                                    }
                                    if ($term->parent == 0 ) {
                                        if ($i != 0) {
                                            $inputContent .= '</optgroup>';
                                        }
                                        $inputContent .=  '<optgroup label="Localidad '.$term->name.'">';
                                    }
                                    if ($term->parent == 0 ) {
                                        $inputContent .= '<option name="'.$term->slug.'" value="'.$term->slug.'" '.$selected.'>Ciudad de '.$term->name.'</option>';
                                    }else{
                                        $inputContent .=  '<option name="'.$term->slug.'" value="'.$term->slug.'" '.$selected.'>'.$term->name.'</option>';
                                    }

                                    if($i == count($terms)){
                                        $inputContent .= '</optgroup>';
                                    }
                                    $i++;
                                }
                                $inputContent .= '</select>';
                                $inputContent .= '</div>';

                                echo '<li><div class="input">'.$inputLabel.$inputContent.'</div></li>';
                            }
                        }else{
                            //$inputLabel = '<label for="'.$taxonomy.'">'.$label.'</label>';
                            $inputContent = '<div class="select-wrapper">';
                            $inputContent .= '<select id="'.$taxonomy.'" name="'.$taxonomy.'">';
                            $inputContent .= '<option value="" disabled selected>'.$label.'</option>';
                            $inputContent .= '<option value="">Todas las '.$plural.'</option>';
                            //<option value="">'.$empty.'</option>';
                            foreach($terms as $term){
                                $selected = '';
                                if($thisQuery == $term->slug){
                                    $selected = 'selected';
                                }
                                $inputContent .=  '<option name="'.$term->slug.'" value="'.$term->slug.'" '.$selected.'>'.$term->name.'</option>';
                            }
                            $inputContent .= '</select>';
                            $inputContent .= '</div>';
                            echo '<li><div class="input">'.$inputLabel.$inputContent.'</div></li>';

                        }
                    }
                }
                ?>
                <li>
                    <?php
                    function sel($v = null){
                        if(!empty($v)){
                            if($_GET['dormitorios'] == $v){
                                echo 'selected="selected"';
                            }
                        }
                    }
                    ?>
                    <select id="location" name="dormitorios" value="<?php echo $_GET['dormitorios'] ?>">
                        <option <?php sel() ?> value="">Dormitorios</option>
                        <option <?php sel(1) ?> value="1">Monoambiente</option>
                        <option <?php sel(1) ?> value="1">1 Dormitorio</option>
                        <option <?php sel(2) ?> value="2">2 Dormitorios</option>
                        <option <?php sel(3) ?> value="3">3 Dormitorios</option>
                        <option <?php sel(4) ?> value="4">4 Dormitorios</option>
                    </select>
                </li>
                <?php /*
                <li>
                    <div class="input"><label><?php echo __('Precio Mínimo') ?></label><input type="text" placeholder="Ej. 1100000" name="price_low"  value="<?php echo $_GET['price_low'] ?>"></div>
                </li>
                <li>
                    <div class="input"><label><?php echo __('Precio Máximo') ?></label><input type="text" placeholder="Ej. 2200000" name="price_high" value="<?php echo $_GET['price_high'] ?>"></div>
                </li>
                */ ?>

                <li>
                    <?php /*
                    <button type="reset" class="btn btn-secondary" onclick="document.getElementById('searchform').reset();return false;">
                    <button type="button" class="btn btn-secondary resetButton">
                        <?php echo __('Limpiar') ?>
                    </button>
                    */ ?>
                    <button type="submit" id="searchsubmit" class="btn btn-hollow btn-block">
                        <i class="qs-icon icon-search"></i>
                        <?php echo __('Buscar') ?>
                    </button>
                </li>
            </ul>
            <div class="clearfix">
                <div class="float-left">
                    <?php
                    /*wp_nav_menu( array(
        						'theme_location'  => 'search-menu',
        						'container'       => false,
        						'menu_class'      => 'flush',
        						'fallback_cb'     => false,
        			));*/
                    $i = 0;
                    $menuName = get_term(get_nav_menu_locations()['search-menu'], 'nav_menu')->name;
                    $items   = wp_get_nav_menu_items($menuName);
                    if($items):
                        $count   = count($items);
                        if($menuName):
                        ?>
                        <ul class="search-menu flush">
                        <?php foreach($items as $item): ?>
                            <?php $i++; ?>
                            <li>
                                <a href="<?php echo $item->url; ?>">
                                    <?php echo $item->title; ?>
                                </a>
                                <?php echo ($i < $count) ? '<span class="center">|</span>' : '' ; ?>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</form>
