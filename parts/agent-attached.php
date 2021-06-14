<?php
//grab data
$data            = get_post_meta($agent->ID);
$thumb           = get_the_post_thumbnail($agent->ID, 'thumb');
$phone           = $data['_agent_phone'][0];
$whats           = $data['_agent_whatsapp'][0];
$email           = $data['_agent_email'][0];
$contact         = $data['_agent_contact'][0];
$type            = get_the_terms($agent->ID, 'agent_type')[0];
?>
<div <?php post_class('agent') ?> id="post-<?php the_ID(); ?>">
    <div class="media">
        <div class="media-left">
            <a class="image is-64x64" href="<?php the_permalink() ?>">
                <?php if($thumb): ?>
                    <?php echo $thumb ?>
                <?php else: ?>
                    <img src="<?php echo get_attachment_url_by_slug('default', 'thumb') ?>" />
                <?php endif; ?>
            </a>
        </div>
        <div class="media-content">
            <a href="<?php echo $agent->guid; ?>">
                <span class="title is-4">
                    <?php echo $agent->post_title; ?>
                </span>
            </a>
            <?php if($type): ?>
                <div class="subtitle is-5">
                    <?php echo $type->name; ?>
                </div>
            <?php endif; ?>
            <ul class="list-vertical">
                <?php
                if($email){
                    $email_link = sprintf('<a href="mailto:%s">%s</a>', $email, $email);
                }
                echo $phone ? sprintf('<li class="icon-text"><i class="icon material-icons">phone</i><span>%s</span></li>', $phone) : '';
                echo $whats ? sprintf('<li class="icon-text"><i class="icon material-icons">whatsapp</i><span>%s</span></li>', $whats) : '';
                echo $email ? sprintf('<li class="icon-text"><i class="icon material-icons">email</i><span>%s</span></li>', $email_link) : '';
                ?>
            </ul>
        </div>
    </div>
</div>
