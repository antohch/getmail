<?php
header("Content-Type: text/html; charset=utf-8");

$server = "mail.krasnodar.ru";
$port = "110";
$protocol = "pop3";
$secur = "notls";
$log = "cb_eisk@msrsp.krasnodar.ru";
$pas = "Bd9QMq2l";
$direction = "D:\emailin\\";
$mail_filetypes = array(
	"MSWORD",
  "BINARY",
  "PDF"
);


function structure_encoding($encoding, $msg_body){

	switch((int) $encoding){

		case 4:
			$body = imap_qprint($msg_body);
			break;

		case 3:
			$body = imap_base64($msg_body);
			break;

		case 2:
			$body = imap_binary($msg_body);
			break;

		case 1:
			$body = imap_8bit($msg_body);
			break;

		case 0:
			$body = $msg_body;
			break;
		
		default:
			$body = "";
			break;
	}

	return $body;
}

function check_utf8($charset){

	if(strtolower($charset) != "utf-8"){

		return false;
	}

	return true;
}
function convert_to_utf8($in_charset, $str){

	return iconv(strtolower($in_charset), "utf-8", $str);
}

function get_imap_title($str){

	$mime = imap_mime_header_decode($str);

	$title = "";

	foreach($mime as $key => $m){

		if(!check_utf8($m->charset)){

			$title .= convert_to_utf8($m->charset, $m->text);
		}else{

			$title .= $m->text;
		}
	}

	return $title;
}


function getInfile($msg_structure, $dir, $mail_filetypes, $connection, $i, $coder){
  if(isset($msg_structure->parts)){

    for($j = 1, $f = 2; $j < count($msg_structure->parts); $j++, $f++){
      if(in_array($msg_structure->parts[$j]->subtype, $mail_filetypes )){

        $mails_data[$i]["attachs"][$j]["type"] = $msg_structure->parts[$j]->subtype;
        $mails_data[$i]["attachs"][$j]["size"] = $msg_structure->parts[$j]->bytes;
        $mails_data[$i]["attachs"][$j]["name"] = get_imap_title($msg_structure->parts[$j]->parameters[0]->value);
        $mails_data[$i]["attachs"][$j]["file"] = structure_encoding(
          $msg_structure->parts[$j]->encoding,
          imap_fetchbody($connection, $i, $f)
        );
        if(empty($mails_data[$i]["attachs"][$j]["name"])){
          $mails_data[$i]["attachs"][$j]["name"] = $msg_structure->parts[$j]->parameters[0]->value;
        }
        echo "<br><br><br>".$mails_data[$i]["attachs"][$j]["name"]."<br>".imap_qprint($coder)."<br><br>";
        file_put_contents($dir.imap_qprint($mails_data[$i]["attachs"][$j]["name"]), $mails_data[$i]["attachs"][$j]["file"]);
      }
    }
  }
}


$my_box = imap_open("{".$server.":".$port."/".$protocol."/".$secur."}", $log, $pas); 
if ($my_box){
  $n = imap_num_recent($my_box);
  echo $n;
  for($i=1; $i <= $n; $i++){
    $time = date("H-i-s");
    $h = imap_headerinfo($my_box, $i);
    $emailFrom = $h->from[0]->mailbox."@".$h->from[0]->host;
    $dir = $direction.$emailFrom."_".$time."_".$i."\\";
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
    $s = imap_fetch_overview($my_box, $i); 
    //print_r(imap_fetchbody($my_box, $i, '3'));
    print_r($struc);
   // print_r($s);
    getInfile($struc, $dir, $mail_filetypes, $my_box, $i, $struc->parts[0]->parts[0]->parameters[0]->value);
    file_put_contents($bodyNameFile, $body);
  } 
}
imap_close($my_box);