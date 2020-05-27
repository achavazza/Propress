<ul class="float-right flush toggle-search">
    <?php
        $cur     = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $mapLink = $cur.'&search=advanced';
    ?>
    <li><a href="<?php echo $cur     ?>" class="btn"><i class="icon-search"></i></a></li>
    <li><a href="<?php echo $mapLink ?>" class="btn"><i class="icon-marker"></i></a></li>
</ul>
