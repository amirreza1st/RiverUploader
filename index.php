<?php
ob_start();
$telegram_ip_ranges = [
['lower' => '149.154.160.0', 'upper' => '149.154.175.255'], 
['lower' => '91.108.4.0',    'upper' => '91.108.7.255'],    
];
$ip_dec = (float) sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
$ok=false;
foreach ($telegram_ip_ranges as $telegram_ip_range) if (!$ok) {
$lower_dec = (float) sprintf("%u", ip2long($telegram_ip_range['lower']));
$upper_dec = (float) sprintf("%u", ip2long($telegram_ip_range['upper']));
if($ip_dec >= $lower_dec and $ip_dec <= $upper_dec) $ok=true;
}
if(!$ok) die("@ Sourrce_Kade ");
//
error_reporting(0);
//=====
$channel = file_get_contents("channel.txt");
$channel2 = file_get_contents("channel2.txt");
$channel3 = file_get_contents("channel3.txt");
// خط پایین ای دی عددی ادمین فقط ادیت بشه
$config = ['admin' => [1898761680,**ADMIN**],'channel' => "$channel",'channel2' => "$channel2",'channel3' => "$channel3"]; //ادیت کنید
//=====
define('API_KEY',"**TOKEN**"); //توکن فقط ادیت بشه
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function RandomString() {
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$randstring = null;
for ($i = 0; $i < 9; $i++) {
$randstring .= $characters[
rand(0, strlen($characters))
];
}
return $randstring;
}
//====
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$message_id = $message->message_id;
$text = $message->text;
$chat_id = $message->chat->id;
$from_id = $message->from->id;
$txt_vip = file_get_contents("../../eliya/txt_vip.txt");
	$txt_link = file_get_contents("../../eliya/link.txt");
    $txt_cr = file_get_contents("../../eliya/txt_cr.txt");
	 $typerse  = file_get_contents("data/type.txt");
//====
$user = file_get_contents("member.txt");
//====
$power = file_get_contents("settings/power.txt");
if(!file_exists('settings/power.txt')){
file_put_contents('settings/power.txt', 'on');
}
//====
$step = file_get_contents("settings/step.txt");
if(!file_exists('settings/step.txt')){
file_put_contents('settings/step.txt', 'none');
}
//====
$scan = file_get_contents("settings/countuploadfile.txt");
if(!file_exists('settings/countuploadfile.txt')){
file_put_contents('settings/countuploadfile.txt', '0');
}
//====
$data = file_get_contents("settings/data.txt");
if(!file_exists('settings/data.txt')){
file_put_contents('settings/data.txt', 'none');
}
//====
$roko = file_get_contents("settings/roko.txt");
if(!file_exists('settings/roko.txt')){
file_put_contents('settings/roko.txt', 'none');
}
//====
if(!is_dir("member")){
mkdir("member");
}
if(!is_dir("member/$from_id")){
mkdir("member/$from_id");
}
if(!is_dir("settings")){
mkdir("settings");
}
if(!is_dir("uploader")){
mkdir("uploader");
}
//====
file_put_contents("member/$from_id/index.php","");
file_put_contents("member/index.php","");
file_put_contents("settings/index.php","");
file_put_contents("uploader/index.php","");
//====
$join_r = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@{$config['channel']}&user_id=$from_id"));
$join_e = $join_r->result->status;
$join_b = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@{$config['channel2']}&user_id=$from_id"));
$join_m = $join_b->result->status;
$join_c = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@{$config['channel3']}&user_id=$from_id"));
$join_t = $join_c->result->status;
$usernamebot = json_decode(file_get_contents('https://api.telegram.org/bot'.API_KEY.'/getMe'))->result->username;
//====
$menu_remove = json_encode(['KeyboardRemove'=>[
],'remove_keyboard'=>true]);
//====
if (in_array($from_id, $config['admin'])) {
$menu = json_encode(['keyboard'=>[
[['text' => "🎥 | آپلود فیلم"],['text' => "🎥 | حذف فیلم"]],
[['text' => "💫 | ارسال فیلم در کانال"]],
[['text' => "📊 | آمار"]],
[['text' => "🤖 | خاموش"],['text' => "🤖 | روشن"]],
[['text' => "🌟 | پیام همهگانی"]],
[['text' => "🔐 | جوین اجباری یک"]],[['text' => "🔐 | جوین اجباری دو"]],
[['text' => "🔐 | جوین اجباری سه"]],
], 'resize_keyboard' => true
]);
$admin_back = json_encode(['keyboard'=>[
[['text' => "🔙"]],
], 'resize_keyboard' => true
]);
}else{
$menu = json_encode(['keyboard'=>[
[['text' => ""]],
], 'resize_keyboard' => true
]);
}
//====
if($power == "off" && !in_array($from_id,$config['admin'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
ربات بنابه دلایلی 🤖 | خاموش میباشد لطفا صبور باشید!
",
'parse_mode'=>'html',
'reply_markup'=>$menu_remove
]);
exit();
}
//====
if(isset($message)){
$txt = file_get_contents('member.txt');
$membersid= explode("\n",$txt);
if (!in_array($from_id,$membersid)){
$file2 = fopen("member.txt", "a") or die("Unable to open file!");
fwrite($file2, "$from_id\n");
fclose($file2);
}
}
//====
if($text == "🔙"){
file_put_contents("settings/step.txt", "none");
file_put_contents("settings/data.txt", "none");
file_put_contents("settings/roko.txt", "none");
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' =>"
با موفقیت برگشتی (:
",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $menu
]);
}
//====
if(file_exists("channel.txt") and file_exists("channel2.txt") and file_exists("channel3.txt")){
if($join_e != 'member'  &&  $join_e != 'creator' && $join_e != 'administrator' && $join_m != 'member'  &&  $join_m != 'creator' && $join_m != 'administrator' && $join_t != 'member'  &&  $join_t != 'creator' && $join_t != 'administrator'){
 bot('sendmessage',[
'chat_id'=>$from_id,
'text'=>" 
سلام خدمت کاربر عزیز به ربات آپلودر فوق العاده پیشرفته خوش آمدید :)
جهت حمایت از ما لطفاً در کانال های زیر عضو شوید
و سپس [ /start ] را بزنید
",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 • | عضویت در کانال | • 🔐",'url'=>"t.me/{$config['channel']}"]],
[['text'=>"🔐 • | عضویت در کانال | • 🔐",'url'=>"t.me/{$config['channel2']}"]],
[['text'=>"🔐 • | عضویت در کانال | • 🔐",'url'=>"t.me/{$config['channel3']}"]],
],
])
]);
exit();
}}
if(file_exists("channel.txt") and file_exists("channel2.txt")){
if($join_e != 'member'  &&  $join_e != 'creator' && $join_e != 'administrator' && $join_m != 'member'  &&  $join_m != 'creator' && $join_m != 'administrator' && $join_t != 'member'  &&  $join_t != 'creator' && $join_t != 'administrator'){
 bot('sendmessage',[
'chat_id'=>$from_id,
'text'=>" 
سلام خدمت کاربر عزیز به ربات آپلودر فوق العاده پیشرفته خوش آمدید :)
جهت حمایت از ما لطفاً در کانال های زیر عضو شوید
و سپس [ /start ] را بزنید
",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 • | عضویت در کانال | • 🔐",'url'=>"t.me/{$config['channel']}"]],
[['text'=>"🔐 • | عضویت در کانال | • 🔐",'url'=>"t.me/{$config['channel2']}"]],
],
])
]);
exit();
}}
if(file_exists("channel.txt")){
if($join_e != 'member'  &&  $join_e != 'creator' && $join_e != 'administrator' && $join_m != 'member'  &&  $join_m != 'creator' && $join_m != 'administrator' && $join_t != 'member'  &&  $join_t != 'creator' && $join_t != 'administrator'){
 bot('sendmessage',[
'chat_id'=>$from_id,
'text'=>" 
سلام خدمت کاربر عزیز به ربات آپلودر فوق العاده پیشرفته خوش آمدید :)
جهت حمایت از ما لطفاً در کانال های زیر عضو شوید
و سپس [ /start ] را بزنید
",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 • | عضویت در کانال | • 🔐",'url'=>"t.me/{$config['channel']}"]],
],
])
]);
exit();
}}
//====
if($text == "/start" or $text == "/START"){
if ($typerse != "vip" ){
		bot('sendmessage', [
'chat_id' => $chat_id,
	   'text'=>$txt_vip,

		]);
	}
if (in_array($from_id, $config['admin'])){
bot('sendmessage', [
'chat_id' => $chat_id,
'text' => "
خوش اومدی ادمین
",
'reply_to_message_id' => $message_id,
'parse_mode' => "html",
'reply_markup' => $menu
]);
}else{
bot('sendmessage', [
'chat_id' => $chat_id,
'text' => "
سلام به ربات خوش آمدید🥳
",
'reply_to_message_id' => $message_id,
'parse_mode' => "html",
'reply_markup' => $menu
]);
}
}
//====
if(strpos($text, "/start _") !== false) {
$idfile = str_replace("/start _", null, $text);
$abc = json_decode(file_get_contents("uploader/$idfile.json"));
$method = $abc->file;
bot('send'.$abc->file, [
'chat_id' => $chat_id,
"$method" => $abc->file_id,
'caption' => "
🆔 @{$config['channel']}
🤖 @$usernamebot
",
'reply_to_message_id' => $message_id,
'parse_mode' => "html",
]);
}
//====
if (in_array($from_id, $config['admin'])){
//==
//====
if($text == "🎥 | آپلود فیلم"){
file_put_contents("settings/step.txt", 'uploadvideo');
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' =>"
لطفا فیلم را بفرستید
",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $admin_back
]);
}
//==
elseif ($step == "uploadvideo"){
file_put_contents("settings/step.txt", 'none');
if(isset($message->video)){
$adirmon = $scan+1;
file_put_contents('settings/countuploadfile.txt', $adirmon);
$file = $bebe->file_id;
$file_id = $message->video->file_id;
$code = RandomString();
bot('sendvideo', [
'chat_id' => $chat_id,
'video' => $file_id,
'caption' => "
فایل شما با موفقیت داخل دیتابیس ذخیره شده
شناسه فایل شما : `$code`
لینک اشتراک گذاری فایل :
https://t.me/{$usernamebot}?start=_$code
",
'reply_to_message_id' => $message_id,
'parse_mode' => "html",
'reply_markup' => $menu
]);
file_put_contents("uploader/$code.json","{'code':'$code','file_id':'$file_id','file':'video'}");
$file = "uploader/$code.json";
file_put_contents($file,str_replace("'",'"',file_get_contents($file)));
}else{
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "خطا این فایل ویدیو نیست!",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $menu
]);
}
}
//====
if($text == "🎥 | حذف فیلم"){
file_put_contents("settings/step.txt", 'delvideo');
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "لطفا شناسه فایل را بفرستید",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}
elseif ($step == "delvideo"){
file_put_contents("settings/step.txt", "none");
if(file_exists("uploader/$text.json")){
unlink("uploader/$text.json");
$adirmon = $scan-1;
file_put_contents('settings/countuploadfile.txt', $adirmon);
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "با موفقیت فایل $text حذف شد!",
'reply_to_message_id' => $message_id,
'parse_mode' => "html",
'reply_markup' => $menu
]);
}else{
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "خطا شناسه فایل معتبر نمیباشد.",
'reply_to_message_id' => $message_id,
'parse_mode' => "html",
'reply_markup' => $menu
]);
}
}
//====
if($text == "🔐 | جوین اجباری یک"){
file_put_contents("settings/step.txt", 'setchannel1');
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "لطفا ای دی کانال بدون @ ارسال کنید",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}
elseif ($step == "setchannel1"){
file_put_contents("settings/step.txt", 'none');
file_put_contents("channel.txt", "$text");
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "کانال @$text تنظیم شد",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $menu
]);
}
if($text == "🔐 | جوین اجباری دو"){
file_put_contents("settings/step.txt", 'setchannel2');
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "لطفا ای دی کانال بدون @ ارسال کنید",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}
elseif ($step == "setchannel2"){
file_put_contents("settings/step.txt", 'none');
file_put_contents("channel2.txt", "$text");
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "کانال @$text تنظیم شد",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $menu
]);
}
if($text == "🔐 | جوین اجباری سه"){
file_put_contents("settings/step.txt", 'setchannel3');
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "لطفا ای دی کانال بدون @ ارسال کنید",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}
elseif ($step == "setchannel3"){
file_put_contents("settings/step.txt", 'none');
file_put_contents("channel3.txt", "$text");
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "کانال @$text تنظیم شد",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $menu
]);
}
if($text == "💫 | ارسال فیلم در کانال"){
file_put_contents("settings/step.txt", 'sendmecode');
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "لطفا کپشن پست را بفرستید",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}
if($step == "sendmecode"){
if(isset($message->text)){
file_put_contents("settings/step.txt", 'sendpostchannel');  
file_put_contents("settings/data.txt", $text);
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "لطفا کد پست را بفرستید",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}else{
file_put_contents("settings/step.txt", 'none');
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "خطا این متن نیست!!",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $menu
]);
}
}
elseif($step == "sendpostchannel"){
file_put_contents("settings/step.txt", 'sendpicch');
file_put_contents("settings/roko.txt", $text);
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "لطفا عکس را بفرستید",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}
elseif($step == "sendpicch"){
file_put_contents("settings/step.txt", 'none');
file_put_contents("settings/roko.txt", 'none');
file_put_contents("settings/data.txt", 'none');
if(isset($message->photo)){
$photo = $message->photo;
$file_id = $photo[count($photo)-1]->file_id;
bot('sendphoto', [
'chat_id' =>"@".$config['channel'],
'photo' => $file_id,
'caption' => "
{$data}
∵∴∵∴∵∴∵∴∵
⁉️ | راهنما دریافت فیلم : با زدن روی دکمه شیشه ای زیر میتونید فیلم را دریافت کنید .
",
'parse_mode' => "html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>' 🔞 | دریافت فیلم ', 'url'=>"https://t.me/{$usernamebot}?start=_{$roko}"]],
],
'resize_keyboard'=>true,
])
]);
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "با موفقیت ارسال شد (:!",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $menu
]); 
}else{
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' => "خطا این عکس نیست!",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $menu
]);  
}
}
//====
if($text == "🤖 | روشن"){
if($power != "on"){
file_put_contents("settings/power.txt","on");
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' =>"ربات 🤖 | روشن شد :(",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}else{
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' =>"ربات از قبل 🤖 | روشن بود!️",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}
}
if($text == "🤖 | خاموش"){
if($power != "off"){
file_put_contents("settings/power.txt", "off");
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' =>"ربات 🤖 | خاموش شد :) ",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}else{
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' =>"ربات از قبل 🤖 | خاموش بود!️",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
]);
}
}
//====
if ($text == "📊 | آمار") {
$member_id = explode("\n",$user);
$member_count = count($member_id)-1;
bot('sendmessage', [
'chat_id' => $chat_id,
'text' => "
📊 | آمار ربات : $member_count
📊 | آمار فایل های اپلود شده : $scan
",
'reply_to_message_id' => $message_id,
'parse_mode' => "html",
]);
}
//====
if($text == "🌟 | پیام همهگانی"){
file_put_contents("settings/step.txt", "sendall");
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' =>"
لطفا پیام خود را ارسال کنید:
",
'reply_to_message_id' => $message_id,
'parse_mode'=>'html',
'reply_markup' => $admin_back
]);
}
elseif ($step == "sendall"){
file_put_contents("settings/step.txt", "none");
$all_member = fopen( "member.txt", 'r');
while( !feof( $all_member)) {
$user = fgets( $all_member);
$id = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChat?chat_id=".$user));
$user2 = $id->result->id;
if($user2 != null){
if($text != null){
bot('sendMessage', [
'chat_id' =>$user,
'text' =>$text,
'parse_mode' =>"html",
'disable_web_page_preview' =>"true"
]);
}
//
if($photo_id != null){
bot('sendphoto',[
'chat_id'=>$user,
'photo'=>$photo_id,
'caption'=>$caption
]);
}
//
}
}
}
//====
}
if($text == "/creator"){
bot('sendmessage', [
'chat_id' =>$chat_id,
'text' =>"
@Sourrce_Kade
",
]);
}
unlink('error_log');




?>