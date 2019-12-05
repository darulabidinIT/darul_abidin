<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_getdata extends CI_Model{
	
	function get_judul(){
	$tbl='sv_report';
	$this->db->select('*')->from($tbl)->where('statusisasi','1');
	$q=$this->db->get();
	return $q;
	}
	function get_karyawannya($dep){
		$tbl='kg_employee';
	$this->db->select('*')->from($tbl);
	//$this->db->order_by('name', 'asc');
	if($dep!=''){
	$this->db->where('id_department',$dep);
	}
	$q=$this->db->get();
	return $q;
	}
	function get_supplier(){
	$tbl='tb_supplier';
	$this->db->select('*')->from($tbl);
	//$this->db->order_by('title', 'asc');
	$q=$this->db->get();
	return $q;
	}
	function get_kasir(){
	$tbl='tb_user';
	$sq="SELECT * FROM $tbl WHERE jabatan IN('1','3')";
	$q=$this->db->query($sq);
	//lastq();
	return $q;
	}
	function get_karyawan(){
	$tbl='tb_karyawan';
	$sq="SELECT * FROM $tbl ";
	$q=$this->db->query($sq);
	//lastq();
	return $q;
	}
	function get_kas(){
	$tbl='tb_kas';
	$sq="SELECT * FROM $tbl";
	$q=$this->db->query($sq);
	//lastq();
	return $q;
	}
	function get_grup_inventory(){
	$tbl='tb_group_inventory';
	$this->db->select('*')->from($tbl)->where('status','y');
	//$this->db->order_by('title', 'asc');
	$q=$this->db->get();
	return $q;
	}
	function get_department_name($id){
	$tbl='kg_department';
	$this->db->select('title')->from($tbl)->where('id',$id);
	$q=$this->db->get();
	return $q->row_array();
	}
	function namabulan(){
		$bulan=array(
		'01'=>'January',
		'02'=>'February',
		'03'=>'March',
		'04'=>'April',
		'05'=>'May',
		'06'=>'June',
		'07'=>'July',
		'08'=>'August',
		'09'=>'September',
		'10'=>'October',
		'11'=>'November',
		'12'=>'December',
		);
		return $bulan;
	}
	function getdoc($id){
		$this->db->select('*')->from('tb_report')->where('id',$id);
		$q=$this->db->get();
		return $q->row_array();
	}
}