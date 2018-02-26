<?php
ob_start();
session_start();
require_once("config.php");

class Functions{

	public function __construct(){

		$connect=new Config();

		$this->db=$connect->connection();

				date_default_timezone_set("Asia/Kolkata");

	}

	public function add_record($title, $category, $amount)
	{	$date = date('d-m-Y');
		$res=$this->db->query("insert into expanse(title, category, amount,date) values('$title', '$category', '$amount','$date')");
		if(@$res)
		{
			return true;
		}
	}

	public function display_expanse(){
		$res=$this->db->query("select * from expanse order by id desc");
	
		$rows = array();
		while($r = mysqli_fetch_array($res)){
			$rows[] = $r;
		}
		$res = json_encode($rows);
		return $res;
	}
	
}