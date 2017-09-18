# OnlineKullaniciSorunu
OnlineKullaniciSorunu


Kodlar Buradan Başlıyor


<?php
ini_set("display_error",0);
error_reporting(0);
$Mysql_kullanici_adi = "root";
$Mysql_parola = "root";
$Mysql_veritabani = "pdo_firma";
$link = mysql_connect ('localhost' , ''.$Mysql_kullanici_adi.'' , ''.$Mysql_parola.'');
if (!$link){
    die ('BaGlantİ Gerceklestirilemedi' .mysql_error());
}
$db_sec = mysql_select_db(''.$Mysql_veritabani.'',$link);
if (!$db_sec){
    die ('Veri Tabanina Baglanilamadi' .mysql_error());
}

mysql_query("SET NAMES 'UTF8'");
mysql_query("SET character_set_connection = 'UTF8'");
mysql_query("SET character_set_client = 'UTF8'");
mysql_query("SET character_set_results = 'UTF8'");
ini_set('display_error',0);

#---Aktif Ziyaretçi Sayısı--------------------------------------------------------------------
$ip = $_SERVER['REMOTE_ADDR'];
$past = time()-150;
mysql_query("DELETE FROM online WHERE time < $past");
$result = mysql_query("SELECT time FROM online WHERE ip='$ip'");
$time = time();
if($row = mysql_fetch_array($result)){
    mysql_query("UPDATE online SET time='$time',ip='$ip' WHERE ip='$ip'");
}else{
    mysql_query("INSERT INTO online (ip,time) VALUES ('$ip','$time')") or die(mysql_error());
}
$result   = mysql_query("SELECT ip FROM online");
$aktifkac = mysql_num_rows($result);
#---Aktif Ziyaretçi Sayısı--------------------------------------------------------------------


#---Dün Tekil Toplam Kaç Kişi Girmiş----------------------------------------------------------
$baslat  =date(Y."-".m."-".d);
$year    =substr($baslat, 0,4);
$month   =substr($baslat, 5, 2);
$day     =substr($baslat, 8, 2);
$bitis   =date("Y-m-d", mktime(0, 0, 0, $month, $day-1, $year));
$sorgula = mysql_query("select tarih from ziyaret where tarih='$bitis'");
$dunku = mysql_num_rows($sorgula);
#---Dün Tekil Toplam Kaç Kişi Girmiş----------------------------------------------------------


#---Bugün Tekil Toplam Kaç Kişi Girmiş--------------------------------------------------------
$bugun = date("Y-m-d");
$sorgu = mysql_query("select tarih from ziyaret where tarih='$bugun'");
$bugunku = mysql_num_rows($sorgu);
#---Bugün Tekil Toplam Kaç Kişi Girmiş--------------------------------------------------------


#---Toplam Tekil Kaç Kişi Girmiş--------------------------------------------------------------
$ipsi  = $_SERVER['REMOTE_ADDR'];
$tarih = date("Y-m-d");

$ipkontrol = mysql_query("select * from ziyaret where ip='$ipsi' order by id desc");
$yaz   = mysql_fetch_assoc($ipkontrol);
$vip   = $yaz['ip'];
$vtarih= $yaz['tarih'];
$bak = mysql_num_rows($ipkontrol);
if($bak>0){  //if-
    if($vtarih<$tarih){
        $kayit_1 = mysql_query("insert into ziyaret (ip,tarih) values ('$ipsi','$tarih')");
    }
}//if-
else{
    $kayit_2 = mysql_query("insert into ziyaret (ip,tarih) values ('$ipsi','$tarih')");
}
$toplamne = mysql_query("select * from ziyaret");
$toplamziyaret  = mysql_num_rows($toplamne);
#---Toplam Tekil Kaç Kişi Girmiş--------------------------------------------------------------
?>
