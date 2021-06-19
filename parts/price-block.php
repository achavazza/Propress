<?php
//pr($args);
$prop_currency   = currency()[$args['_prop_currency'][0]];
$cur_symbol      = $prop_currency ? 'U$S' : '$';
$prop_sale       = ($args['_prop_price_sale'][0]!= 0) ? number_format($args['_prop_price_sale'][0], 0, ',', '.') : '';
$prop_rent       = ($args['_prop_price_rent'][0]!= 0) ? number_format($args['_prop_price_rent'][0], 0, ',', '.') : '';
?>

<span class="price-block level">
    <span class="level-left">
        <?php if(!$prop_sale && !$prop_rent):
            echo '<span class="level-item">';
            echo sprintf('<span>Precio: <strong>%s</strong></span>', __('Consultar'));
            echo '</span>';
        else:
            //if($prop_rent):
            if(has_term('alquiler','operacion')):
                $val = $prop_currency.' '.$prop_rent;
                echo '<span class="level-item">';
                echo sprintf('<span class="rent-price" title="Precio de alquiler">%s</span>', $val);
                //<strong>Alquiler: </strong>
                //<?php echo '$'.$prop_rent
                echo '</span>';
            endif;
            //if($prop_sale && $prop_rent):
            if(has_term('alquiler','operacion') && has_term('venta','operacion')):
                echo '<span class="level-item">';
                echo ' | ';
                echo '</span>';
            endif;
            //if($prop_sale):
            if(has_term('venta','operacion')):
                $val = $prop_currency.' '.$prop_sale;
                echo '<span class="level-item">';
                echo sprintf('<span class="sale-price" title="Precio de venta">%s</span>', $val);
                //<strong>Venta: </strong>
                //<?php echo $cur_symbol.' '.$prop_sale
                echo '</span>';
            endif;
        endif;
        ?>
    </span>
</span>
