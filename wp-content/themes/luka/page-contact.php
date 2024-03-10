<?php
/*
Template Name: Contact
*/

echo wp_head();

echo do_blocks('<!-- wp:template-part {"slug":"header","area":"header","tagName":"header"} /-->');

?>

<h1>Contactez-nous !</h1>
<form class="contactForm" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
    <p>
        Votre Nom (obligatoire) <br>
        <input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="<?php echo (isset($_POST["cf-name"]) ? esc_attr($_POST["cf-name"]) : ''); ?>" size="40" />
    </p>
    <p>
        Votre Email (obligatoire) <br>
        <input type="email" name="cf-email" value="<?php echo (isset($_POST["cf-email"]) ? esc_attr($_POST["cf-email"]) : ''); ?>" size="40" />
    </p>
    <p>
        Votre Message <br>
        <textarea rows="10" cols="35" name="cf-message"><?php echo (isset($_POST["cf-message"]) ? esc_attr($_POST["cf-message"]) : ''); ?></textarea>
    </p>
    <p><input type="submit" name="cf-submitted" value="Envoyer"></p>
</form>


<?php

echo do_blocks('<!-- wp:template-part {"slug":"footer","area":"footer","tagName":"footer"} /-->');
