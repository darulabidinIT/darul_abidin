<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class invoice_log extends CI_Controller {
	
		var $utama ='invoice_log';
		var $title ='Invoice Log';
	function __construct()
	{
		parent::__construct();permissionBiasa();
		$this->load->library('flexigrid');
        $this->load->helper('flexigrid');
	error_reporting(0);
	}
	
	function index()
	{
		$this->main();
	}
	
	function main($id)
	{
		
		$group = $this->session->userdata('webmaster_grup');
			if(!$id){
				if($group=='4' || $group=='5' || $group=='6' || $group=='8' || $group=='9' || $group=='10' ) redirect('forbidden');
					}
		//Migrasi 1 Feb 14
		permissionBiasa();
		//Set Global
		//permission();
		//$data = GetHeaderFooter();
		//$data['job_order']=GetValue('number','sv_import_sea_job',array('id'=>'where/'.$id));
		//$q=$this->db->query("SELECT SUM(b_subtotal) as sales,SUM(c_subtotal) as cost FROM sv_import_ai WHERE job_order='".$data['job_order']."'")->row_array();
		
		//$data['sales']=$q['sales'];
		//$data['cost']=$q['cost'];
		//$data['profit']=$q['sales']-$q['cost'];	
		$data['content'] = 'contents/'.$this->utama.'/view';
		
		$data['js_grid']=$this->get_column($id);
		//$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function get_column($id){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
			//$colModel['service'] = array('Service',110,TRUE,'left',2);
			$colModel['div'] = array('Div',200,TRUE,'left',2);
			$colModel['ref'] = array('No. Invoice',200,TRUE,'left',2);
			$colModel['create_user_id'] = array('Created by',200,TRUE,'left',2);
			$colModel['create_date'] = array('Created Date',110,TRUE,'left',2);
			//if(!$id || $id=='trucking')$colModel['action'] = array('Aksi',110,TRUE,'left',2);
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        /* 
           $buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');
           // $buttons[] = array('add','add','btn');
            $buttons[] = array('separator'); */
            // $buttons[] = array('edit','edit','btn');
            //$buttons[] = array('delete','delete','btn');
		/* $buttons[] = array('separator');
		$buttons[] = array('detail','detail','btn');
		if(webmastergrup() ==7 || webmastergrup() == '2706')$buttons[] = array('pay','pay','btn');
		if($id== 'trucking')$buttons[] = array('edit kewill','pay','btn'); */
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record/".$id),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid($id)
        {

            //Build contents query
            $this->db->select("*")->from($this->utama);
			//$this->db->where(array('type'=>'AR'));
			//$this->db->where(array('latest'=>'1'));
			if($id) $this->db->where(array('div'=>$id));
			$this->db->order_by('create_date','DESC');
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->utama);
			//$this->db->where(array('type'=>'AR'));
			//$this->db->where(array('latest'=>'1'));
			if($id) $this->db->where(array('div'=>$id));
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record($id){
		
		$valid_fields = array('id','number','create_date');
            $this->flexigrid->validate_post('create_date','DESC',$valid_fields);
            $records = $this->get_flexigrid($id);

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {
				if($row->create_user_id!='270611'){
				$userid=GetValue('name','admin',array('id'=>'where/'.$row->create_user_id));}
				else{
					$userid='SUPERADMIN';
				}
				
                $record_items[] = array(
                $row->id,
                $row->id,
                $row->id,
                $row->div,
                $row->ref,
				$userid,
                $row->create_date
                        );
            }

            return $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));;
	}  

	function deletec()
	{		
		//return true;
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
			/*if (is_numeric($country_id) && $country_id > 0) {
				$this->delete($country_id);}*/
				$inv=GetValue('number','invoice',array('id'=>'where/'.$country_id));
			$this->db->delete($this->utama,array('id'=>$country_id));	

			$this->db->delete('invoice_detail',array('invoice'=>$inv));				
		}
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
	
	function form($id=null,$job){
		
		permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
		//echo $job;
		$data['job_order']=$job;
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		$data['opt_client']=GetOptAll('master_client','-Client-',array('status'=>'where/1'),'name');
		$data['opt_port']=GetOptAll('master_airport','-Airport-',array(),'name');
		$data['opt_airline']=GetOptAll('master_airline','-Airline-',array(),'name');
		$data['opt_metric']=GetOptAll('master_metric','-metric-',array(),'code');
		$data['opt_marketing']=GetOptAll('marketing_form_prospect','-prospect-',array(),'number');
		$data['opt_acc']=GetOptAll('setup_account_mapping','-Account-',array(),'code');
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	function detail($id=null,$job=NULL){
		
		permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
		//echo $job;
		$data['job_order']=$job;
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['content'] = 'contents/'.$this->utama.'/detail';
		$data['opt_client']=GetOptAll('master_client','-Client-',array('status'=>'where/1'),'name');
		$data['opt_port']=GetOptAll('master_airport','-Airport-',array(),'name');
		$data['opt_airline']=GetOptAll('master_airline','-Airline-',array(),'name');
		$data['opt_metric']=GetOptAll('master_metric','-metric-',array(),'code');
		$data['opt_marketing']=GetOptAll('marketing_form_prospect','-prospect-',array(),'number');
		$data['opt_acc']=GetOptAll('setup_account_mapping','-Account-',array(),'code');
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function submit(){
		$webmaster_id=$this->session->userdata('webmaster_id');
		$id = $this->input->post('id');
		$GetColumns = GetColumns('sv_'.$this->utama);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
			
			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		
		/* if(!$this->input->post('global')){$data['global']='N';}
		else{$data['global']='Y';}  */
		
		if($id != NULL && $id != '')
		{
				
			/* if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));} */
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
				//$data['job_order']=generatenumbering('import-'.$data['form'],'import','air',$data['form']);
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			//addnumbering('import-'.$data['form']);
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		$id=GetValue('id','sv_import_sea_job',array('number'=>'where/'.$this->input->post('job_order')));
		redirect($this->utama.'/main/'.$id);
		
	}
	function generateinvoice($jo,$tbl,$div,$mod){
		$webmaster_id=$this->session->userdata('webmaster_id');
			$job=GetAll($tbl,array('number'=>'where/'.$jo))->row_array();
			$ai=GetAll('sv_ai',array('job_order'=>'where/'.$jo))->result_array();
			
		$client=isset($job['shipper']) ? $job['shipper'] : $job['messers'];
		
		$cln=GetValue('code','master_client',array('id'=>'where/'.$client));
		$quo=str_replace('invoice_','',$mod);
		
			$data['jo']=$jo;
			$data['div']=$div;
			if($div=='trucking'){
					$parent=NULL;
					$div='TRC';}
			else{$parent=strtoupper(substr($div,0,3));
			$div=NULL;}
			$ceksblm=GetAll('sv_invoice',array('jo'=>'where/'.$jo));
			if($ceksblm->num_rows()==0){
				$data['number']=generatenumbering($mod,$parent,NULL,NULL,$div,$cln);
			}else{
				$datin=$ceksblm->row_array();
				$this->db->where('jo',$jo);
				$this->db->update('sv_invoice',array('latest'=>'0'));
				$data['number']=$datin['number'];
			}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_invoice',$data);
			$idnumb=$this->db->insert_id();
			addnumbering($mod);
			$numb=$data['number'];
			$lol=$this->db->query("SELECT * FROM sv_ai WHERE job_order = '$jo' AND b_subtotal>0 ")->result_array();
	//lastq();
			foreach($lol as $dota){
				$currency=strtolower($dota['b_currency']);
				//echo $currency;
					$detail['invoice']=$data['number'];
					$detail['desc']=$dota['b_desc'];
					$detail['qty']=$dota['b_item'];
					$detail["$currency"]=$dota['b_amount'];
				$detail['total']=$dota['b_subtotal'];
				$this->db->insert('sv_invoice_detail',$detail);
			}
			$total=$this->db->query("SELECT SUM(total) as total FROM sv_invoice_detail WHERE invoice='".$numb."' ")->row_array();
			$this->db->where('number',$numb);
			$this->db->update('sv_invoice',array('total'=>$total['total']));
			
			//notif
			$notif['message']=$data['div']." telah melakukan generate invoice dengan nomor ".$numb." ";
			$notif['from']= $webmaster_id;
			$notif['to']='Finance';
			$notif['status']='N';
			//$notif['prospek']=$numbering;
			$notif['link']='printing/invoice/'.$idnumb;
			$notif['create_user_id'] = $webmaster_id;
			$notif['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_notif',$notif);
			//--notif
			echo $numb;
			
		}
	function generate_trucking($id=null,$job=NULL){
		
		permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
		//echo $job;
		$data['job_order']=$job;
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['content'] = 'contents/'.$this->utama.'/generate_truck';
		$data['opt_client']=GetOptAll('master_client','-Client-',array('status'=>'where/1'),'name');
		$data['opt_port']=GetOptAll('master_airport','-Airport-',array(),'name');
		$data['opt_airline']=GetOptAll('master_airline','-Airline-',array(),'name');
		$data['opt_metric']=GetOptAll('master_metric','-metric-',array(),'code');
		$data['opt_marketing']=GetOptAll('marketing_form_prospect','-prospect-',array(),'number');
		$data['opt_acc']=GetOptAll('setup_account_mapping','-Account-',array(),'code');
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	function generate_truck($jo=NULL,$tbl='sv_trucking_order',$div='trucking',$mod='invoice_trucking'){
		$webmaster_id=$this->session->userdata('webmaster_id');
		$client=$this->input->post('client');
		$froms=$this->input->post('from');
		$tos=$this->input->post('to');
			$job=$this->db->query("SELECT * FROM sv_trucking_order a LEFT JOIN sv_marketing_form_prospect b ON a.prospek=b.id WHERE b.surat_jalan='Dikirim' AND a.messers='$client' AND a.request_date >='$froms' AND a.request_date<='$tos'")->result_array();
			//lastq();
			$ai=GetAll('sv_ai',array('job_order'=>'where/'.$jo))->result_array();
			
		
		$cln=GetValue('code','master_client',array('id'=>'where/'.$client));
		$quo=str_replace('invoice_','',$mod);
		
			$data['jo']=$jo;
			$data['div']=$div;
			$data['po']=$this->input->post('po');
			if($div=='trucking'){
					$parent=NULL;
					$div='TRC';}
			else{
					$parent=strtoupper(substr($div,0,3));
					$div=NULL;
				}
				
			//$data['number']=generatenumbering($mod,$parent,NULL,NULL,$div,$cln);
			$data['number']=$this->input->post('number');
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_invoice',$data);
			$idnya=$this->db->insert_id();
			addnumbering($mod);
			$numb=$data['number'];
			foreach($job as $jorder){
				$lol=$this->db->query("SELECT * FROM sv_ai WHERE job_order='".$jorder['number']."' AND b_subtotal>0")->result_array();

				foreach($lol as $dota){
				$currency=strtolower($dota['b_currency']);
					$detail['invoice']=$numb;
					$detail['jo']=$jorder['number'];
					$detail['desc']=$dota['b_desc'];
					$detail['qty']=$dota['b_item'];
					$detail["$currency"]=$dota['b_amount'];
					$detail['total']=$dota['b_subtotal'];
					$this->db->insert('sv_invoice_detail',$detail);
				}
			}
			
			$total=$this->db->query("SELECT SUM(total) as total FROM sv_invoice_detail WHERE invoice='".$numb."' ")->row_array();
			$this->db->where('number',$numb);
			$this->db->update('sv_invoice',array('total'=>$total['total']));
			
			//notif
			$notif['message']=$data['div']." telah melakukan generate invoice dengan nomor ".$numb." ";
			$notif['from']= $webmaster_id;
			$notif['to']='Finance';
			$notif['status']='N';
			//$notif['prospek']=$numbering;
			$notif['link']='printing/invoice/'.$idnya;
			$notif['create_user_id'] = $webmaster_id;
			$notif['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_notif',$notif);
			//--notif
		redirect($this->utama.'/kewill_form/'.$idnya);
			
	}
	
	function kewill_form($id){
		$num=GetValue('number','sv_invoice',array('id'=>'where/'.$id));
		//permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
			$data['isinya']=$this->db->query("SELECT * FROM sv_invoice_detail WHERE invoice='$num'")->result_array();
		}
		else{
			$data['type']='New';
		}
		$data['content'] = 'contents/'.$this->utama.'/edit_kewill';
		
		$this->load->view('layout/main',$data);
	}
	function kewill_submit(){
		//print_mz($this->input->post());
		$id=$this->input->post('id');
		$kw=$this->input->post('kewill');
		$a=0;
		foreach($id as $idny){
			//echo $idny.'<br/>'.$kw[$a];
			$this->db->where('id',$idny);
			$this->db->update('sv_invoice_detail',array('kewill'=>$kw[$a]));
			$a++;
		}
		
		redirect($this->utama.'/main/trucking');
	}
}
?>