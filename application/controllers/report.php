<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  - Programmed : Mei 2015
  - Programmer : Fauzan Rabbani
  - Email      : fauzanrabbani@jhanojan.com
  - Webpage    : http://www.jhanojan.com
  - CMS ver    : CI ver.2.2
*/

class report extends CI_Controller {
	
	var $title = "Report";
	var $filename = "report";
	var $fonthead= "14px";
	var $fontcont= "14px";
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('model_getdata');
		$this->load->model('model_query_report');
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
		permissionBiasa();
		$q=$this->model_getdata->get_judul();
		$data['content'] = 'report/menu/menu';
		
		$data['title'] = $this->title;
		$data['filename'] = $this->filename;
		$data['tipedokumen']= $q->result();
		$filter['statusisasi']='where/1';
			if($this->session->userdata('webmaster_grup')==10){
				$filter['id']='where/2';
			}
		$data['opt_dok']=GetOptAll('report','-Document-',$filter,'title_document');
		$this->load->view('layout/main',$data);
		
		
	}
	function karyawannya($dep){
		
		$qkar=$this->model_getdata->get_karyawannya($dep);
		$data['listkar']=$qkar->result();
		$this->load->view('report/category/karyawan',$data);
	}
	function response_cat($id=null){
		//error_reporting(0);
		$id=htmlentities(mysql_real_escape_string($id));
		if($id!=''){
		
		/* $qsup=$this->model_getdata->get_supplier();
		$data['listsup']=$qsup->result();
		$qkasir=$this->model_getdata->get_kasir();
		$data['listkasir']=$qkasir->result();
		$qkaryawan=$this->model_getdata->get_karyawan();
		$data['listkaryawan']=$qkaryawan->result();
		$qgrup_inventory=$this->model_getdata->get_grup_inventory();
		$data['listgrup_inventory']=$qgrup_inventory->result();
		
		$qkas=$this->model_getdata->get_kas(); 
		$data['listkas']=$qkas->result();*/
		
		$data['opt_jotruck']=GetOptAll('trucking_order','-All-',array(),'number');
		$data['opt_coa']=GetOptAll('setup_coa','-All-',array('level >'=>'where/1'),'code','code','name');
		$data['opt_vendor']=GetOptAll('master_vendor','-All-',array(),'name');
		$data['opt_client']=GetOptAll('master_client','-All-',array(),'name');
		$data['opt_petty']=GetOptAll('ref_petty','-All-',array(),'name','name');
		$data['opt_user']=GetOptAll('admin','-All-',array(),'name','id','username');
		$data['bulan']=$this->model_getdata->namabulan();
		$data['opt_account'] = array(
		"-"=>'---All---',
		"'11.10.000','11.10.001'"=>'Kas',
		"'11.20.001','11.20.002'"=>'Mandiri',
		"'11.20.003','11.20.004'"=>'BCA'
		);$data['opt_div'] = array(
		''=>'---All---',
		'TRC'=>'Trucking',
		'EXP'=>'Export',
		'IMP'=>'Import'
		);
		$q=GetAll('sv_report',array('id'=>'where/'.$id));
		$data['document']=$q->row_array();
		
		if($q->num_rows()>0){
		$this->load->view('report/category/main',$data);
		}
		else{
			echo "Dokumen Tidak Ditemukan";
		}
		}
	}
	function periodterpilih($val){
		$data['bulan']=$this->model_getdata->namabulan();
	$this->load->view('report/category/'.$val,$data);
	}
	function print_prev($cat,$dep,$period){
		$query=$this->model_getdata->get;
		$data['cat']=$cat;
		$data['dep']=$dep;
		$data['period']=$period;
		$data['result']=$query->result();
		$this->load->view('report/layout/template.php',$data);
		
		}
		
	function pricelist(){
		$query=$this->model_query_report->pricelist();
		$data['content']='pricelist';
		$data['result']=$query->result();
		$data['period']=$this->input->post('start_date');
		$this->load->view('report/layout/template.php',$data);
	}	
	function koreksi_stok(){
		$query=$this->model_query_report->koreksi_stok();
		$data['content']='koreksi_stok';
		$data['result']=$query->result();
		$data['period']=$this->input->post('start_date').' s/d '.$this->input->post('end_date');
		$this->load->view('report/layout/template.php',$data);
	}
	function pembelian(){
		$query=$this->model_query_report->pembelian();
		$data['content']='pembelian';
		$data['result']=$query->result();
		$data['period']=$this->input->post('start_date').' s/d '.$this->input->post('end_date');
		$this->load->view('report/layout/template.php',$data);
	}
	function pembelian_detail(){
		
		$query=$this->model_query_report->pembelian_detail();
		$data['content']='pembelian_detail';
		$data['result']=$query->result();
		$data['period']=$this->input->post('start_date').' s/d '.$this->input->post('end_date');
		$this->load->view('report/layout/template.php',$data);
		
	}
	function barang_limit(){
		
		$query=$this->model_query_report->barang_limit();
		$data['content']='barang_limit';
		$data['result']=$query->result();
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode(",",$kat);
			$data['kat']=$kat;
			} 
		else{$data['kat']='-';}
		$data['period']=date("Y-m-d");
		$this->load->view('report/layout/template.php',$data);
		
	}
	function stok(){
		
		$query=$this->model_query_report->stok();
		$data['content']='stok';
		$data['result']=$query->result();
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode(",",$kat);
			$data['kat']=$kat;
			} 
		else{$data['kat']='-';}
		$data['period']=date("Y-m-d");
		$this->load->view('report/layout/template.php',$data);
		
	}
	function stok_opname(){
		
		$query=$this->model_query_report->stok_opname();
		$data['content']='stok_opname';
		$data['result']=$query->result();
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode(",",$kat);
			$data['kat']=$kat;
			} 
		else{$data['kat']='-';}
		$data['period']=date("Y-m-d");
		$this->load->view('report/layout/template.php',$data);
		
	}
	function kas(){
		
		$query=$this->model_query_report->kas();
		$data['content']='kas';
		$data['result']=$query->result();
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode(",",$kat);
			$data['kat']=$kat;
			} 
		else{$data['kat']='-';}
		$kas=$this->input->post('kas');
		if(!empty($kas)){
			$i=0;
			foreach($kas as $isikas){
			$kas[$i]=GetValue('nama','tb_kas',array('id'=>'where/'.$isikas));
			$i++;	
			}
			
			$kas=implode(",",$kas);
			$data['kas']=$kas;
			} 
		else{$data['kas']='-';}
		$data['period']=date("Y-m-d");
		$this->load->view('report/layout/template.php',$data);
		
	}
	
	function penjualan(){
		
		$query=$this->model_query_report->penjualan();
		
		//lastq();
		$data['content']='penjualan';
		$data['result']=$query->result();
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode(",",$kat);
			$data['kat']=$kat;
			} 
		else{$data['kat']='-';}
		$kas=$this->input->post('kas');
		if(!empty($kas)){
			$i=0;
			foreach($kas as $isikas){
			$kas[$i]=GetValue('nama','tb_kas',array('id'=>'where/'.$isikas));
			$i++;	
			}
			
			$kas=implode(",",$kas);
			$data['kas']=$kas;
			} 
		else{$data['kas']='-';}
		$data['period']=date("Y-m-d");
		$this->load->view('report/layout/template.php',$data);
		
	}
	function penjualan_detail(){
		$query=$this->model_query_report->penjualan_barang();
		$data['content']='penjualan_barang';
		$data['result']=$query->result();
		$data['period']=$this->input->post('start_date');
		$this->load->view('report/layout/template.php',$data);
	}	
	
	function labarugi(){
		
		$query=$this->model_query_report->labarugi();
		
		//lastq();
		$data['content']='labarugi';
		$data['result']=$query->result();
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode(",",$kat);
			$data['kat']=$kat;
			} 
		else{$data['kat']='-';}
		$kas=$this->input->post('kas');
		if(!empty($kas)){
			$i=0;
			foreach($kas as $isikas){
			$kas[$i]=GetValue('nama','tb_kas',array('id'=>'where/'.$isikas));
			$i++;	
			}
			
			$kas=implode(",",$kas);
			$data['kas']=$kas;
			} 
		else{$data['kas']='-';}
		$data['period']=date("Y-m-d");
		$this->load->view('report/layout/template.php',$data);
		
	}
}
?>