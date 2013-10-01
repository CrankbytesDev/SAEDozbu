<div class="loginbox">
    <h2>Login Dozbu</h2>

    <form action="<?php echo BASE_URL . '?p=login' ?>" method="post">
        <p>
            <input type="text" name="username" placeholder="Benutzername" autofocus="true"/>
        </p>

        <p>
            <input type="password" name="password" placeholder="Passwort"/>
        </p>

        <p>
            <input type="submit" name="loginSubmit" value="Login"/>
        </p>
    </form>

</div>

<?php
// TODO Beispiel für das Aufrufen von Daten innerhalb der Templates
//echo $this->data['siteContent']->data['validuser'];
?>
