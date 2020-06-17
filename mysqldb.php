<!-- This Script is from www.phpfreecpde.com, Coded by: Kerixa Inc-->
<?php
$sql=new MySQL;
			$sql->Initialize("localhost","root","");//// Enter Your Database connection information here.
$res=$sql->Connect(); if (!$res) die(mysql_error());
$res=$sql->SelectDB('info');
if (!$res){
	$res=$sql->CreateDB('info'); if (!$res) die(mysql_error());
	$fld['Name']='TEXT';
	$fld['Age']='INT';
	$fld['Number']='INT';
	$fld['Email']='TEXT';
	$res=$sql->SelectDB('info'); if (!$res) die(mysql_error());
	$res=$sql->CreateTable('students',$fld); if (!$res) die(mysql_error());
}
$val['Name']='John';
$val['Age']='20';
$val['Number']='98237498';
$val['Email']='John@mydomain.com';
$res=$sql->Insert('students',$val); if (!$res) die(mysql_error());
$val['Name']='Jack';
$val['Age']='22';
$val['Number']='88344598';
$val['Email']='Jack@mydomain.com';
$res=$sql->Insert('students',$val); if (!$res) die(mysql_error());
$wh['Name']='John';
$wh['Age']=20;
$res=$sql->Get('students',$wh); if (!$res) die(mysql_error());
var_dump($res);
$wh['Name']='Jack';
$wh['Age']=22;
$res=$sql->DeleteRecord('students',$wh); if (!$res) die(mysql_error());
$res=$sql->DeleteTable('students');if (!$res) die(mysql_error());
$res=$sql->DeleteDB('info');if (!$res) die(mysql_error());


//The class starts here
class MySQL{
	public $user, $pass, $host, $link;
	
	public function Initialize($HostName,$UserName,$Password){
		$this->host=$HostName;
		$this->user=$UserName;
		$this->pass=$Password;
		return true;}
	
	public function Connect(){
		$this->link=@mysql_connect($this->host, $this->user, $this->pass);
		if(!$this->link) return false; else	return true;}
	
	public function SelectDB($dbname){
		$result=mysql_select_db($dbname);
		if(!$result) return false;else return true;}
	
	public function CreateDB($dbname){
		$sql= "CREATE DATABASE $dbname";
		$result=mysql_query ($sql, $this->link);
		if(!$result) return false;else return true;}
	
	public function DeleteDB($dbname){
		$sql = "DROP DATABASE $dbname";
		$result=mysql_query ($sql, $this->link);
		if(!$result) return false;else return true;}
	
	public function CreateTable($name,$fields){ //$field[name]=type
		$str='';
		foreach ($fields as $fname=>$ftype)
			$str.="`$fname` $ftype NOT NULL ,";
		$str=substr($str,0,strlen($str)-1);		
		$sql = "CREATE TABLE `$name` ($str
			) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
		$result=mysql_query ($sql, $this->link);
		if(!$result) return false;else return true;}
		
	public function DeleteTable($name){
		$sql="DROP TABLE $name";
		$result=mysql_query ($sql, $this->link);
		if(!$result) return false;else return true;}	
	
	public function Insert($tblname,$values){ //$values[fieldname]=fieldvalue
		$str1='';$str2='';
		foreach ($values as $fname=>$fval){
			$str1.="$fname,";
			$str2.="'$fval',";}
		$str1=substr($str1,0,strlen($str1)-1);
		$str2=substr($str2,0,strlen($str2)-1);				
		$sql="INSERT INTO $tblname($str1)VALUES($str2)";
		$result=mysql_query ($sql, $this->link);
		if(!$result) return false;else return true;}
	
	public function Get($tblname,$where){ //$where[fieldname]=fieldvalue{
		$str='';
		if ($where!=''){
			foreach ($where as $fname=>$fval)
				$str.="$fname='$fval' AND ";
			$str=substr($str,0,strlen($str)-5);		
			$str="WHERE $str";}
		
		$sql="SELECT * FROM $tblname $str";
		$result=mysql_query($sql);
		$res='';
		if(!$result) return false;
		else{
			$cnt=0; 
		    while($row = mysql_fetch_array($result)){
		    	$cnt++;
				for ($i = 0; $i < mysql_num_fields($result); $i++) {
					$fln=mysql_field_name($result,$i);
					//echo $row['Name'];
			 		$res[$cnt]["$fln"]= $row["$fln"];
				}
			}
		return $res;
		}
	}
	
	public function DeleteRecord($tblname,$where){ //$where[fieldname]=fieldvalue
		$str='';
		if ($where!=''){
			foreach ($where as $fname=>$fval)
				$str.="`$tblname`.`$fname`='$fval' AND ";
			$str=substr($str,0,strlen($str)-5);		
			$str="WHERE $str";}else return false;
		$sql="DELETE FROM `$tblname` $str";
		$result=mysql_query($sql);
		if(!$result) return false;else return true;}
}
?>
<br><font face="Tahoma"><a target="_blank" href="http://www.phpfreecode.com/"><span style="font-size: 8pt; text-decoration: none">PHP Free Code</span></a></font></div>
