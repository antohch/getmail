<?php
header("Content-Type: text/html; charset=utf-8");


$my_box = imap_open("{mail.krasnodar.ru:110/pop3/notls}", "cb_eisk@msrsp.krasnodar.ru", "Bd9QMq2l"); 
if ($my_box){
  $n = imap_num_recent($my_box);
  echo $n;
  for($i=1; $i <= $n; $i++){
    $time = date("H-i-s");
    $h = imap_headerinfo($my_box, $i);
    $emailFrom = $h->from[0]->mailbox."@".$h->from[0]->host;
    $dir = "D:\emailin\\".$emailFrom."_".$time."_".$i;
    $bodyNameFile = $dir."\\"."body".$i.".txt";
    
    echo "<br>".$emailFrom;
    mkdir($dir);
    $body = imap_fetchbody($my_box, $i, '1');
    $struc = imap_fetchstructure($my_box, $i);
    //$inputNameFile = $dir."\\".;
    $body = imap_qprint($body);
    if (!empty($struc->parts[0]->parameters[0]->value)){
      $body = iconv($struc->parts[0]->parameters[0]->value,'UTF-8',$body);
    }
    //echo "<br>".$body;
    print_r(imap_fetchbody($my_box, $i, '3'));
    file_put_contents($bodyNameFile, $body);
  } 
}
imap_close($my_box);