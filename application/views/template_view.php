<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?php echo $pageData['title']; ?></title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>

<body style="margin: 3px;margin-left: 8px">
<?php include 'application/views/' . $content_view; ?>
</body>
<?php //include "";?>
</html>