<p>Добро пожаловать, <b><?php echo $pageData['login']; ?></b></p>
<form method="post">
    <input type="submit" name="logout" value="Выйти"> <!-- кнопка -->
</form>
<form method="post">
    <input type="submit" name="add" value="Создать чат"> <!-- кнопка -->
</form>
<?php
if (isset($_POST['add']) && !isset($_POST['cancel'])): ?>
    <div style="padding: 5px; border: 3px solid #f1f1f1;">
        <form method="post">
            Название чата<br>
            <input type="text" name="name_chat"><br><!-- поле ввода -->
            <input type="submit" name="add_chat" value="Создать"> <!-- кнопка -->
            <input type="submit" name="cancel" value="Отменить"> <!-- кнопка -->
        </form>
    </div>
<?php endif; ?>
<p>Ваши чаты:<br>
    <?php
    //вывод нет чатов
    if (!empty($pageData['error'])) {
        echo "<p>" . $pageData['error'] . "</p>";
    }
    //вывод списка чатов
    if (!empty($pageData ['chats'])) {
        foreach ($pageData ['chats'] as $item => $item_count) {
            echo "<a href=" . $item_count . ">" . $item . "</a><br>";
        }
    }
    ?>
</p>
