<div style="margin-left:5px ;height: 99vh; float: left;width: 50%;min-width: 400px;max-width:800px;display: block">
    <div id="chat_load" class="chat_load"
         style="background-color: lightcyan; width: 100%;height: 90%;overflow-y:scroll;">
        <!--тут выводятся сообщения-->
        <?php
        //свои сообщения
//
//        if (!isset($pageData['array_messages'])) echo "В этом чате пока нет сообщений.";
//        else {
//            foreach ($pageData['array_messages'] as $array => $message) {
//                //проверяем, написал пользователь сообщение сам или другие
//                foreach ($pageData['array_party'] as $key => $name) {
//                    if ($message['person_id'] == $key) {
//                        $name_person = $name;
//                    }
//                }
//                if ($pageData['id_person'] == $message['person_id']) {//написал он
//                    echo "<div style='text-align: left; width: 90%'><p><span style='color: #cf00ff'>
//                            (" . $message['send_date'] . ") " .
//                        $name_person . ":</span> " .
//                        $message['text_m'] . "</p></div>";
//                } else {
//                    echo "<div style='text-align: left;width:90%'><p><span style='color: #41ff00'>
//                            (" . $message['send_date'] . ") " .
//                        $name_person . ":</span> " .
//                        $message['text_m'] . "</p></div>";
//                }
//            }
//        }
        ?>
    </div>
    <div id="type-chats" style=" width: 100%;height: 10%">
        <!--тут поле ввода сообщения-->
        <form method="post" id="chatForm">
            <textarea id="message" style="resize: inherit;width: 98%;height:70%"></textarea>
            <button onclick="return chat_validation()">Отправить</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        reload_message_list();
    })

    function reload_message_list() {
        setInterval(function () {
            $.ajax({
                url: "http://localhost/kchat/home/chat/reload",
                method: "POST",
                data: {
                    chat_id: <?php echo $pageData['chat_id']?>
                },
                success: function (data) {
                    $('.chat_load').html(data);
                }
            });
        }, 200);
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
    }
</script>