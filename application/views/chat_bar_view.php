<title><?php echo $pageData['title']; ?></title>
<head>
    <meta charset="UTF-8">
</head>
<div style="min-width: 163px; max-width:400px; width: 25%;float: left;">
    <h3><?php echo $pageData['name_chat']; ?></h3>
    Администратор: <?php echo $pageData['login_admin'] ?><br>
    Участники: <?php echo count($pageData['array_party']) ?><br>
    <?php
    if (!empty($pageData['form_for_admin'])) echo $pageData['form_for_admin']['button'];
    if (isset($_POST['add_person']) && !isset($_POST['cancel'])) {
        echo $pageData['form_for_admin']['form'];
    }
    ?>
    <select multiple size="auto" style="width: 100%">
        <?php
        foreach ($pageData['array_party'] as $row)
            echo '<option style="margin: 5px">' . $row . '</option><br>'
        ?>
    </select>
    <form method="post">
        <input type="submit" name="logout" value="Выйти"> <!-- кнопка -->
    </form>
    <?php if (isset($_POST['logout'])) {
        header("Location: http://localhost/kchat/home/");
    } ?>
</div>