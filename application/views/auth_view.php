<form method="POST">
    <h3>Регистрация</h3>
    Логин: <br> <input type="text" name="register_login" required>
    <br>
    Пароль: <br> <input type="password" name="register_password" required>
    <br>
    <?php if(!empty($pageData['error1'])) :?>
        <p><?php echo $pageData['error1']; ?></p>
    <?php endif; ?>
    <input type="submit" value="Зарегистрироваться">
</form>
<form method="POST">
    <h3>Вход</h3>
    Логин: <br> <input type="text" name="auth_login" required>
    <br>
    Пароль: <br> <input type="password" name="auth_password" required>
    <br>
    <?php if(!empty($pageData['error2'])) :?>
        <p><?php echo $pageData['error2']; ?></p>
    <?php endif; ?>
    <input type="submit" value="Войти">
</form>