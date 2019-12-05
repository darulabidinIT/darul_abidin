<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class Printing extends CI_Controller {
	
		var $utama ='printing';
		var $title ='Printing';
		var $fonts = 'calibri';
		var $fontsize='11px';
	function __construct()
	{
		parent::__construct(); 
		error_reporting(0);
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
			permissionBiasa();
		//Migrasi 1 Feb 14
		//permissionBiasa();
		//Set Global
		//permission();
		//$data = GetHeaderFooter();
		$data['content'] = 'contents/'.$this->utama.'/view';
		$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	function export_shipping($id){
			$data['autoprint']=TRUE;
			$data['content']='content/export/shipping_instruction';
			$data['shipping']=GetAll('export_sea_job',array('id'=>'where/'.$id))->row_array();
			
			$data['shipper']=GetAll('master_client',array('id'=>'where/'.$data['shipping']['shipper']))->row_array();
			
			$data['consignee']=GetAll('master_client',array('id'=>'where/'.$data['shipping']['consignee']))->row_array();
			
			$this->load->view('report/layout/main',$data);
	}
	function jurnal_umum($id){
		$coa=$this->input->post('coa');
		$period=$this->input->post('period');
		$per=explode('-',$period);
			$data['autoprint']=FALSE;
			$data['content']='content/jurnal/jurnal';
			$q="SELECT * FROM sv_jurnal_detail LEFT JOIN sv_jurnal ON sv_jurnal_detail.id_jur=sv_jurnal.id WHERE MONTH(sv_jurnal.post_tgl)='".$per[1]."' AND  YEAR(sv_jurnal.post_tgl)='".$per[0]."' ";
		if($coa!=NULL){ 
			$q.="AND akun='$coa' ";
		}
		$data['periode']=$period;
			$data['isi']=$this->db->query($q)->result_array();
			
			//lastq();
			$this->load->view('report/layout/main',$data);
	}
	function lossprofit($id){
		/* $coa=$this->input->post('coa');
		
		$per=explode('-',$period);
			$data['autoprint']=FALSE;
			$q="SELECT * FROM sv_jurnal_detail LEFT JOIN sv_jurnal ON sv_jurnal_detail.id_jur=sv_jurnal.id WHERE MONTH(sv_jurnal.post_tgl)='".$per[1]."' AND  YEAR(sv_jurnal.post_tgl)='".$per[0]."' ";
		if($coa!=NULL){
			$q.="AND akun='$coa' ";
		} */
		$period=$this->input->post('period');
		$data['divisi']=$this->input->post('div');
			$data['content']='content/finance/profitloss';
		$data['periode']=explode('-',$period);
			$data['profit']=$this->db->query("SELECT * FROM sv_setup_profit_loss WHERE type='profit'")->result_array();
			$data['loss']=$this->db->query("SELECT * FROM sv_setup_profit_loss WHERE type='loss'")->result_array();
			
			//lastq();
			$this->load->view('report/layout/main',$data);
	}
	function trucksum($id){
		//error_reporting(E_ALL);
		 $ven=$this->input->post('vendor');
			$period=$this->input->post('period');
			$data['periode']=explode('-',$period);
			$data['ven']=$ven;
		
		/*$per=explode('-',$period);
			$data['autoprint']=FALSE;
			$q="SELECT * FROM sv_jurnal_detail LEFT JOIN sv_jurnal ON sv_jurnal_detail.id_jur=sv_jurnal.id WHERE MONTH(sv_jurnal.post_tgl)='".$per[1]."' AND  YEAR(sv_jurnal.post_tgl)='".$per[0]."' ";
		if($coa!=NULL){
			$q.="AND akun='$coa' ";
		} */
		if($ven!='1'){
	$ex1=$this->db->query("SELECT * FROM sv_master_truck WHERE vendor ='$ven' ")->result_array();
		}else{
			
	$ex1=$this->db->query("SELECT * FROM sv_master_truck WHERE milik='sendiri' ")->result_array();
		}
	foreach($ex1 as $x1){
		$truck[]="'".$x1['id']."'";
	}
	$truck=implode(',',$truck);
	$tro=$this->db->query("SELECT * FROM sv_trucking_order WHERE vehicle_no IN ($truck) AND MONTH(create_date)='".$data['periode'][1]."' AND  YEAR(create_date)='".$data['periode'][0]."' ");
	
	
		
		
			$data['content']='content/trucking/summary';
			$data['jo']=$tro->result_array();
			$data['alls']=$tro->num_rows();
			$data['vendor']=GetValue('name','master_vendor',array('id'=>'where/'.$ven));
			//lastq();
			$this->load->view('report/layout/main',$data);
	}
	function marketing($id){
		/* $coa=$this->input->post('coa');
		
		$per=explode('-',$period);
			$data['autoprint']=FALSE;
			$q="SELECT * FROM sv_jurnal_detail LEFT JOIN sv_jurnal ON sv_jurnal_detail.id_jur=sv_jurnal.id WHERE MONTH(sv_jurnal.post_tgl)='".$per[1]."' AND  YEAR(sv_jurnal.post_tgl)='".$per[0]."' ";
		if($coa!=NULL){
			$q.="AND akun='$coa' ";
		} */
		$period=$this->input->post('period');
			$data['content']='content/finance/marketingfee';
		$data['periode']=explode('-',$period);
			$data['marketing']=$this->db->query("SELECT * FROM sv_master_sales")->result_array();
			
			//lastq();
			$this->load->view('report/layout/main',$data);
	}
	function receivable($id=NULL){
		/* $coa=$this->input->post('coa');
		
		$per=explode('-',$period);
			$data['autoprint']=FALSE;
			$q="SELECT * FROM sv_jurnal_detail LEFT JOIN sv_jurnal ON sv_jurnal_detail.id_jur=sv_jurnal.id WHERE MONTH(sv_jurnal.post_tgl)='".$per[1]."' AND  YEAR(sv_jurnal.post_tgl)='".$per[0]."' ";
		if($coa!=NULL){
			$q.="AND akun='$coa' ";
		} */
		$period=$this->input->post('period');
		$client=$this->input->post('client');
		$codeclient=GetValue('code','master_client',array('id'=>'where/'.$client));
		$per=explode('-',$period);
			$data['content']='content/finance/receivable';
		$data['periode']=explode('-',$period);
			$data['inv']=$this->db->query("SELECT * FROM sv_invoice WHERE type='AR' AND latest=1 AND MONTH(create_date)='".$per[1]."' AND  YEAR(create_date)='".$per[0]."' AND number LIKE '%$codeclient%' ")->result_array();
			
			//lastq();
			$this->load->view('report/layout/main',$data);
	}
	function payable($id=NULL){
		/* $coa=$this->input->post('coa');
		
		$per=explode('-',$period);
			$data['autoprint']=FALSE;
			$q="SELECT * FROM sv_jurnal_detail LEFT JOIN sv_jurnal ON sv_jurnal_detail.id_jur=sv_jurnal.id WHERE MONTH(sv_jurnal.post_tgl)='".$per[1]."' AND  YEAR(sv_jurnal.post_tgl)='".$per[0]."' ";
		if($coa!=NULL){
			$q.="AND akun='$coa' ";
		} */
		$period=$this->input->post('period');
		$client=$this->input->post('client');
		if($client!=NULL){$lanjutan="AND messers='$client'";}else{$lanjutan='';}
		$codeclient=GetValue('code','master_client',array('id'=>'where/'.$client));
		$per=explode('-',$period);
			$data['content']='content/finance/payable';
		$data['periode']=explode('-',$period);
			$data['inv']=$this->db->query("SELECT * FROM sv_invoice_detail a LEFT JOIN sv_trucking_order b ON a.jo=b.number WHERE a.invoice LIKE 'AP%' AND a.invoice LIKE '%/".romawimonth($per[1])."/".$per[0]."' ".$lanjutan." ORDER BY a.id_invoice,a.modify_date ASC ")->result_array();
			
			//lastq();
			$this->load->view('report/layout/main',$data);
	}
	function neraca($id){
		/* $coa=$this->input->post('coa');
		
		$per=explode('-',$period);
			$data['autoprint']=FALSE;
			$q="SELECT * FROM sv_jurnal_detail LEFT JOIN sv_jurnal ON sv_jurnal_detail.id_jur=sv_jurnal.id WHERE MONTH(sv_jurnal.post_tgl)='".$per[1]."' AND  YEAR(sv_jurnal.post_tgl)='".$per[0]."' ";
		if($coa!=NULL){
			$q.="AND akun='$coa' ";
		} */
		$period=$this->input->post('period');
			$data['content']='content/finance/neraca';
		$data['periode']=explode('-',$period);
			$data['profit1']=$this->db->query("SELECT * FROM sv_setup_neraca WHERE type='1'")->result_array();
			$data['profit2']=$this->db->query("SELECT * FROM sv_setup_neraca WHERE type='2'")->result_array();
			$data['loss1']=$this->db->query("SELECT * FROM sv_setup_neraca WHERE type='3'")->result_array();
			$data['loss2']=$this->db->query("SELECT * FROM sv_setup_neraca WHERE type='4'")->result_array();
			
			//lastq();
			$this->load->view('report/layout/main',$data);
	}
	function petty($id){
		//error_reporting(E_ALL);
		$jo=$this->input->post('jo');
		$remark=$this->input->post('remark');
		$period=$this->input->post('period');
		$from = $this->input->post('from');
		$typeAccount = $this->input->post('coa');
		$entry = $this->input->post('entry_by');
		$per=explode('-',$period);
			$data['autoprint']=FALSE;
			$data['content']='content/finance/petty';
			$q="SELECT *,(amount * kurs) as amount_usd FROM sv_cash_petty WHERE MONTH(dates)='".$per[1]."' AND  YEAR(dates)='".$per[0]."' ";
			if($typeAccount!=NULL){
				//$q.=" AND (coa in ($typeAccount)) ";
				$q.=" AND coa = '$typeAccount' ";
			}
		if($jo!=NULL){
			$q.="AND job_number LIKE '%$jo%' ";
		}if($remark!=NULL){
			$q.="AND remark LIKE '%$remark%' ";
		}if($from!=NULL){
			$q.="AND `from` = '$from' ";
		}if($entry!=NULL){
			$q.="AND `create_user_id` = '$entry' ";
		}
			$data['periode']=$period;
			$data['isi_idr']=$this->db->query($q."AND rc='1' ORDER BY ref ASC")->result_array();
			$data['isi_usd']=$this->db->query($q."AND rc='2' ORDER BY ref ASC")->result_array();
		
		
		$t='';
		if($from!=NULL){
			$t="AND `from` = '$from' ";
		}
			
			$all_isi_idr=$this->db->query("SELECT SUM(amount) as val FROM sv_cash_petty WHERE dates < '$period-01' AND rc='1' AND save_type='in' ".$t)->row_array();
			$all_out_idr=$this->db->query("SELECT SUM(amount) as val FROM sv_cash_petty WHERE dates < '$period-01' AND rc='1' AND save_type='out' ".$t)->row_array();
			$data['sebelum_idr']=$all_isi_idr['val'] - $all_out_idr['val'];
			
			//lastq();
			
			
			$all_isi_usd=$this->db->query("SELECT SUM(amount) as val FROM sv_cash_petty WHERE dates < '$period-01' AND rc='2' AND save_type='in' ".$t)->row_array();
			$all_out_usd=$this->db->query("SELECT SUM(amount) as val FROM sv_cash_petty WHERE dates < '$period-01' AND rc='2' AND save_type='out' ".$t)->row_array();
			
			$data['sebelum_usd']=$all_isi_usd['val'] - $all_out_usd['val'];
			
			//print_mz($all_isi_idr);
			$this->load->view('report/layout/main',$data);
	}
	function progress_trucking(){ 
		error_reporting(E_ALL);
		$this->load->library('export_xls');
		$coa=$this->input->post('client');
		$from=$this->input->post('from');
		$to=$this->input->post('to');
		$per=explode('-',$period);
			$data['autoprint']=FALSE;
			$data['content']='content/trucking/progress';
			$q="SELECT a.id id,
			b.number number,
			a.jo jo,
			a.create_date create_date,
			a.location location,
			a.ttm ttm,
			a.ktm ktm,
			a.ss ss,
			a.fs fs,
			a.bongkar bongkar,
			a.ktb ktb,
			a.ttb ttb,
			a.supir supir,
			a.tlp_supir tlp_supir,
			a.keterangan keterangan,
			a.picture1 picture1,
			a.picture2 picture2,
			a.picture3 picture3,
			a.picture4 picture4,
			a.picture5 picture5,
			a.label1 label1,
			a.label2 label2,
			a.label3 label3,
			a.val1 val1,
			a.val2 val2,
			a.val3 val3,
			b.client client
			FROM sv_trucking_progress a LEFT JOIN sv_marketing_form_prospect b ON a.jo=b.id WHERE a.create_date >= '$from 00:00:00' AND a.create_date <= '$to 23:59:59' ";
		if($coa!=NULL){
			$q.="AND b.client='$coa' ";
		}
		$data['periode']=$period;
			$data['isi']=$this->db->query($q)->result_array();
			
			//lastq();
			//echo "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
		$filename = "website_data_" . date('Ymd') . ".xls";/* 
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");  */
			
			$tbl = $this->load->view('report/layout/main',$data,true);
			
			
			$this->export_xls->generate($tbl);
	}
	function invoice($id,$type=NULL){
		$div=GetValue('div','invoice',array('id'=>'where/'.$id));
		$jo=GetValue('jo','invoice',array('id'=>'where/'.$id));
		$num=GetValue('number','invoice',array('id'=>'where/'.$id));
	//	echo $num;
		if($div=='export' || $div=='import'){$div='exim';}
		
		if($div!='trucking'){
			$joborder=$this->db->query(" SELECT * FROM sv_export_air_job WHERE number='$jo'");
			if($joborder->num_rows()==0){
				
				$joborder=$this->db->query(" SELECT * FROM sv_export_sea_job WHERE number='$jo'");
				if($joborder->num_rows()==0){
					
					$joborder=$this->db->query(" SELECT * FROM sv_import_air_job WHERE number='$jo'");
					if($joborder->num_rows()==0){
				
						$joborder=$this->db->query(" SELECT * FROM sv_import_sea_job WHERE number='$jo'");
						
					}
				}
			}
		}
		else{
						$joborder=$this->db->query(" SELECT * FROM sv_trucking_order WHERE number='$jo'");
						$inv_detail=$this->db->query(" SELECT * FROM sv_invoice_detail WHERE invoice='$num'")->row_array();
						$jo=$inv_detail['jo'];
						$pic=$this->db->query(" SELECT * FROM sv_trucking_order WHERE number='$jo'")->row_array();
						$potong=explode('/',$num);
						$data['messers']=GetValue('name','master_client',array('code'=>'where/'.$potong[2]));
						$data['address']=GetValue('address','master_client',array('code'=>'where/'.$potong[2]));
						$data['pic']=$pic['pic'];
		}
//lastq();	

		$data['joborder']=$joborder->row_array();
		
		if($div=='exim'){
			$data['bl']=(isset($data['joborder']['mbl']) ? $data['joborder']['mbl'] : $data['joborder']['mawb'] );
			$data['transport']=(isset($data['joborder']['vsl']) ? 'Vessel' : 'Airline' );
			$data['transports']=(isset($data['joborder']['vsl']) ? GetValue('name','master_vessel',array('id'=>'where/'.$data['joborder']['vsl'])) : GetValue('name','master_airline',array('id'=>'where/'.$data['joborder']['airline']))  );
			$data['from']=(isset($data['joborder']['vsl']) ? GetValue('name','master_seaport',array('id'=>'where/'.$data['joborder']['pol'])) : GetValue('name','master_airport',array('id'=>'where/'.$data['joborder']['airport_dept']))  );
			$data['to']=(isset($data['joborder']['vsl']) ? GetValue('name','master_seaport',array('id'=>'where/'.$data['joborder']['pod'])) : GetValue('name','master_airport',array('id'=>'where/'.$data['joborder']['airport_dest']))  );
		}
		
			$data['autoprint']=FALSE;
			if($div=='trucking'){
			$data['lembarkedua']=TRUE;
			$data['lembarkeduaid']=$id;
			}
			if($type!=NULL && $type==2){
					$ext=2;
			$data['lembarkedua']=FALSE;
			} 
			else{$ext=NULL;}
			$data['content']='content/invoice/'.$div.$ext;
			$data['sum']=GetAll('invoice',array('id'=>'where/'.$id))->row_array();
			
			$data['detail']=$this->db->query("SELECT * FROM sv_invoice_detail WHERE id_invoice='$id'")->result_array();
			//print_mz($data['detail']);
			
			
			
			$this->load->view('report/layout/main',$data);
	}
	function lembarkeduatrucking($id){
		$div=GetValue('div','invoice',array('id'=>'where/'.$id));
		$jo=GetValue('jo','invoice',array('id'=>'where/'.$id));
		$num=GetValue('number','invoice',array('id'=>'where/'.$id));
	//	echo $num;
		
						$joborder=$this->db->query(" SELECT * FROM sv_trucking_order WHERE number='$jo'");
						$inv_detail=$this->db->query(" SELECT * FROM sv_invoice_detail WHERE invoice='$num'")->row_array();
						$jo=$inv_detail['jo'];
						$pic=$this->db->query(" SELECT * FROM sv_trucking_order WHERE number='$jo'")->row_array();
						$potong=explode('/',$num);
						$data['messers']=GetValue('name','master_client',array('code'=>'where/'.$potong[2]));
						$data['address']=GetValue('address','master_client',array('code'=>'where/'.$potong[2]));
						$data['pic']=$pic['pic'];
		
//lastq();	

		$data['joborder']=$joborder->row_array();
		
		
		
			$data['autoprint']=FALSE;
			
			$data['content']='content/invoice/lembarkedua';
			$data['sum']=GetAll('invoice',array('id'=>'where/'.$id))->row_array();
			
			$data['detail']=$this->db->query("SELECT * FROM sv_invoice_detail WHERE invoice='$num'")->result_array();
			//print_mz($data['detail']);
			
			
			
			$this->load->view('report/layout/main',$data);
	}
	function ai($id,$type){
		
		error_reporting(0);
		
			$data['autoprint']=FALSE;
			$data['title']=strtoupper($type);
			$data['content']='content/ai/ai';
			$ty=explode('_',$type);
		if($type!='trucking'){	
			if($ty[1]=='air'){
				$data['mb']='mawb';
				$data['hb']='hawb';
			}elseif($ty[1]=='sea'){
				$data['mb']='mbl';
				$data['hb']='hbl';
			}
		}
			
			if($type=='trucking'){$low='_order';}
			else{$low='_job';}
			$tbl=$type.$low;
			
		$data['job_order']=GetValue('number',$tbl,array('id'=>'where/'.$id));
		$data['id']=$id;
		$data['type']=$type;
			
			$data['detail']=GetAll($tbl,array('id'=>'where/'.$id))->row_array();
			
			$data['income_idr']=$this->db->query("SELECT * FROM sv_ai WHERE job_order='".$data['job_order']."' AND b_subtotal>0 AND b_currency='IDR' ")->result_array();
			$data['income_usd']=$this->db->query("SELECT * FROM sv_ai WHERE job_order='".$data['job_order']."' AND b_subtotal>0 AND b_currency='USD' ")->result_array();
			
			$data['c_idr']=$this->db->query("SELECT * FROM sv_ai WHERE job_order='".$data['job_order']."' AND c_subtotal>0 AND c_currency='IDR' ")->result_array();
			//lastq();
			//print_mz($data);
			$data['c_usd']=$this->db->query("SELECT * FROM sv_ai WHERE job_order='".$data['job_order']."' AND c_subtotal>0 AND c_currency='USD' ")->result_array();
			
			
			$this->load->view('report/layout/main',$data);
	}
	
}
?>