<!-- This Script is from www.phpfreecpde.com, Coded by: Kerixa Inc-->
<form method="post">
	<table align="center" style="width: 500px">
		<tr>
			<td style=" padding-left: 8px; width: 142px; background-color: #E8E8FF;">
			<span style="font-family: 'Times New Roman', Times, serif; font-size: 15pt">
			Domain Lists:</span><br style="font-family: 'Times New Roman', Times, serif; font-size: 15pt">
			<span style="font-family: 'Times New Roman', Times, serif; font-size: 12pt">
			(Separated by enter)</span></td>
			<td style=" padding: 8px; text-align: center; background-color: #E8E8FF">
	<textarea name="domains" style="width: 260px; height: 104px"></textarea><br>
			<br>
<input name="Submit1" type="submit" value="Find" style="width: 119px; height: 34px; font-size: 15pt; font-family: 'times New Roman', Times, serif;"><br></td>
		</tr>
<?php
$notice='';
if (isset($_POST['domains'])){
	$d=explode("\n",$_POST['domains']);
	foreach($d as $dm) {
		$info=whois($dm);
		echo("<tr><td style='padding-left: 8px;width: 142px; background-color: #FFFFD9'>$dm</td>
		<td style='padding-left: 8px;background-color: #FFFFD9'>$info</td></tr>");
	}
}

function whois($domain){
global $notice;
$whois = '';
$connection = @fsockopen('whois.verisign-grs.com', 43);
if ($connection) {
    @fputs($connection, $domain ."\r\n");
    while (!feof($connection)) {
        $whois .= @fgets($connection, 128);
    }
}
fclose($connection);
$l1=strpos($whois,"information.")+strlen("information.")+1;
$l2=strpos($whois,">>>",$l1)-1;
$siteinfo=substr($whois,$l1,$l2-$l1);
$siteinfo=str_replace("   ","",$siteinfo);
$notice=substr($whois,0,$l1-1);
$notice.=substr($whois,$l2+1);
return "<pre>$siteinfo<pre>";
}
?>		
</table>
</form>
<div style="text-align: center">
	<font face="Tahoma"><a target="_blank" href="http://www.phpfreecode.com/"><span style="font-size: 8pt; text-decoration: none">PHP Free Code</span></a></font></div>
<p style="font-size: 8pt; background-color: #E5FCD5">Terms of use and Notices:<br>
<?php echo "$notice";?></p>
