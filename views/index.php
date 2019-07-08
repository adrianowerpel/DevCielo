<?php

require_once 'template.php';

$template = new template();

?>

<div class="container" style="margin-top: 5%;margin-left: 40%">
    <form method="post" action="../controllers/LoginController.php">

        <div style="width: 10%">
        <h1>Login</h1>

        <hr>
        </div>

        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" class="form-control col-4" id="usuario" name="usuario" required>
        </div>

        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control col-4" id="senha" name="senha" required>
        </div>

        <input type="submit" value="Logar" class="btn btn-primary">

    </form>
</div>
<?php
$template->footer();