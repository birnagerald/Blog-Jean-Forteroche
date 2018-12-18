<h2>Inscription</h2>
<hr>
<?php if ($user->hasFlash()) {
    echo '<p style="text-align: center;">', $user->getFlash(), '</p>';
}
?>

<form method="post" action="">
    <div class="form-group">
		<input class="form-control" minlength="3" maxlength="10" name="name" placeholder="Name..."><br>
		<input class="form-control" minlength="4" maxlength="15" type="password" name="password" placeholder="Password..."><br>
		<input class="btn btn-primary" name="submit" type="submit" value="Envoyer"><br>
    </div>
</form>
