<?php
header("Content-Type: text/html; charset=utf-8");

$server = "mail.krasnodar.ru";
$port = "110";
$protocol = "pop3";
$secur = "notls";
$log = "cb_eisk@msrsp.krasnodar.ru";
$pas = "Bd9QMq2l";

$my_box = imap_open("{".$server.":".$port."/".$protocol."/".$secur."}", $log, $pas); 
$n = imap_num_msg($my_box);
$m = 0;
$add_text = "

Спасибо за подтверждение вашей подписки ";
$add_sbj = "You added!";
$del_text = "

Вы были удалены из списка рассылки. ";
$del_sbj = "Delete from list";
$err_text = "

Извините но этот почтовый ящик используется
только для администрирования рассылки";
$err_sbj = "Error";
$headers = "From: Subscribe Robot <You@mail.box>

X-mailer: PHP4

Content-type: text/plain; charset=windows-1251
";
if($n != 0) {
  while($m++ < $n) {
    $h = imap_header($my_box, $m);
    $s = imap_fetch_overview($my_box, $m);
    $h = $h->from;
    foreach ($h as $k =>$v) {
      $mailbox = $v->mailbox;
      $host = $v->host;
      $personal = $v->personal;
      $email = $mailbox . "@" . $host;
      $my_email = mysql_escape_string($email);
    }
    foreach ($s as $k =>$v) {
      $subj = $v->subject;
    }
    if ($subj == "SUBSCRIBE") {
      mysql_query("UPDATE table SET stat=1 WHERE email=".$my_email);
      $del = imap_delete($my_box, $m);
      mail($email, $add_sbj, $add_text, $headers);
    }
    elseif ($subj == "UNSUBSCRIBE") {
      mysql_query("DELETE FROM table WHERE email=".$my_email);
      $del = imap_delete($my_box, $m);
      mail($email, $del_sbj, $del_text, $headers);
    }
    else {
      $del = imap_delete($open_box, $m);
      mail($email, $err_sbj, $err_text, $headers);
    }
  }
  $clear = imap_expunge($my_box);
}
?>