<?php
global $wp;
$current_url = home_url($wp->request);
?>

<form class="formACF" action="" method="post">
    <div class="fieldsets">
        <fieldset>
            <label for="prix">Prix maximum</label>
            <input type="number" name="prix" id="prix" value="<?php echo $_POST['prix'] ?? ''; ?>">
        </fieldset>
        <fieldset>
            <label for="couchage">Nombre de couchage minimum</label>
            <input type="number" name="couchage" id="couchage" value="<?php echo $_POST['couchage'] ?? ''; ?>">
        </fieldset>
    </div>
    <input type="submit" value="Filtrer">
</form>