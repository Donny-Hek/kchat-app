<div style="min-width: 163px; max-width:400px; width: 25%;float: left;">
    <h3><?php echo $pageData['name_chat']; ?></h3>
    <?php if (!empty($pageData['form_for_admin']['error'])) echo $pageData['form_for_admin']['error']; ?><br>
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
        <input type="submit" name="logout" value="На главную"> <!-- кнопка -->
    </form>
    <?php if (isset($_POST['logout'])) {
        header("Location: http://localhost/kchat/home/");
    } ?>
</div>
<div style="position: relative; margin-left:5px ;height: 99vh; float: left;width: 50%;min-width: 400px;max-width:800px;display: block">
    <button style="position: absolute; right: 20px;" onclick="return scroll_top()">\/</button>
    <div id="chat_load" style=" background-color: lightcyan; width: 100%;height: 90%;overflow-y:scroll;overflow-wrap:break-word">
            <!--тут выводятся сообщения-->
    </div>
    <div id="type-chats" style=" width: 100%;height: 10%">
        <!--тут поле ввода сообщения-->
        <form method="post" id="chatForm">
            <textarea id="message" style="resize: inherit;width: 98%;height:70%"></textarea>
            <button onclick="return chat_validation()">Отправить</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        reload_message_list();
    })


    function scroll_top() {
        $("#chat_load").scrollTop($("#chat_load")[0].scrollHeight);
    }

    function reload_message_list() {
        setInterval(function () {
            $.ajax({
                url: "http://localhost/kchat/home/chat/reload",
                method: "POST",
                data: {
                    chat_id: <?php echo $pageData['chat_id']?>
                },
                success: function (data) {
                    $('#chat_load').html(data);
                    // $("#chat_load").scrollTop($("#chat_load")[0].scrollHeight);
                }
            });
        }, 200);
        // $("#chat_load").scrollTop($("#chat_load")[0].scrollHeight);
    }

    function chat_validation() {
        $.ajax({
            url: "http://localhost/kchat/home/chat/ins_message",
            method: "POST",
            data: {
                message: $('#message').val(),
                chat_id: <?php echo $pageData['chat_id']?>,
            },
            success: function (e) {
                $('#message').val("");
            }
        });
        // $("#chat_load").scrollTop($("#chat_load")[0].scrollHeight);
    }
</script>