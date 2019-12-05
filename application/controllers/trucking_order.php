<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class trucking_order extends CI_Controller {
	
		var $utama ='trucking_order';
		var $title ='Truck Order';
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
	
	function main()
	{
		//Migrasi 1 Feb 14
		//permissionBiasa();
		//Set Global
		//permission();
		//$data = GetHeaderFooter();
		$data['content'] = 'contents/'.$this->utama.'/view';
		
		$data['js_grid']=$this->get_column();
		//$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function get_column(){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',7,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',7,TRUE);
            $colModel['number'] = array('Number',110,TRUE,'left',2);
            $colModel['create_date'] = array('Date',110,TRUE,'left',2);
            $colModel['t2.name'] = array('Messers',110,TRUE,'left',2);
            $colModel['t3.name'] = array('Service',110,TRUE,'left',2);
            $colModel['t4.code'] = array('Vehicle No',110,TRUE,'left',2);
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
           $buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');/* 
            $buttons[] = array('add','add','btn');
            $buttons[] = array('separator'); */
             $buttons[] = array('edit','edit','btn');
		$buttons[] = array('delete','delete','btn');
		$buttons[] = array('separator');
		$buttons[] = array('Account Information','ai','btn');
		$buttons[] = array('separator');/* 
		$buttons[] = array('Input Progress','truck','btn');
		$buttons[] = array('View Progress','truck','btn'); */
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'','',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {
            //Build contents query
            $this->db->select("t1.id id, t1.number number, t1.create_date create_date, t2.name messers, t3.name service, t4.code vehicle_no")->from($this->utama.' t1');
			$this->db->join('sv_master_client t2', "t2.id = t1.messers", 'left');
			$this->db->join('sv_master_trucking t3', "t3.id = t1.service", 'left');
			$this->db->join('sv_master_truck t4', "t4.id = t1.vehicle_no", 'left');
			$this->db->order_by('t1.create_date','DESC');
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();
			//lastq();
            //Build count query
            $this->db->select("count(t1.id) as record_count")->from($this->utama.' t1');
			$this->db->join('sv_master_client t2', "t2.id = t1.messers", 'left');
			$this->db->join('sv_master_trucking t3', "t3.id = t1.service", 'left');
			$this->db->join('sv_master_truck t4', "t4.id = t1.vehicle_no", 'left');
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record(){
		
		$valid_fields = array('id','number','create_date','t2.name','t3.name','t4.code');

            $this->flexigrid->validate_post('t1.create_date','DESC',$valid_fields);
            $records = $this->get_flexigrid();

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {/*
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/
				
                $record_items[] = array(
                $row->id,
                $row->id,
				$row->id,
                $row->number,
                $row->create_date,
                $row->messers,
				$row->service,
				$row->vehicle_no
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
			$this->db->delete($this->utama,array('id'=>$country_id));				
		}
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
	
	function form($id=null){
		
		permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
			if(isset($_GET['prospek'])){
				$pros=$this->db->query("SELECT * FROM sv_marketing_form_prospect WHERE number='".$_GET['prospek']."'")->row_array();
				$data['val']['prospek']=$pros['id'];
				$data['val']['messers']=$pros['client'];
				$data['val']['loading']=$pros['from'];
				$data['val']['unloading']=$pros['to'];
				$data['val']['service']=$pros['service_truck'];
				$data['val']['vehicle_no']=$pros['vehicle_no'];
				$data['val']['vendor']=GetValue('name','master_vendor',array('id'=>'where/'.GetValue('vendor','master_truck',array('id'=>'where/'.$pros['vehicle_no']))));
			}
		}
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['opt_client']=GetOptAll('master_client','-Client-',array('status'=>'where/1'),'name');
		$data['opt_trucking']=GetOptAll('master_trucking','-Service-',array(),'code','id','name');
		$data['opt_truck']=GetOptAll('master_truck','-Truck-',array(),'code');
		$data['opt_marketing']=GetOptAll('marketing_form_prospect','-prospect-',array(),'number');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function submit(){
		$webmaster_id=$this->session->userdata('webmaster_id');
		$id = $this->input->post('id');
		$vendor=$this->input->post('vendor');
		$GetColumns = GetColumns('sv_'.$this->utama);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
			
			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		
		
		$idprospek=$data['prospek'];
				$this->db->query("DELETE FROM sv_quotation_trucking_custom WHERE prospek='$idprospek'");
			$GetColumns = GetColumns('sv_quotation_trucking_custom');
			foreach($GetColumns as $r)
			{
				$quo[$r['Field']] = str_replace(',','',$this->input->post($r['Field']));
				$quo[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
				
				if(!$quo[$r['Field']] && !$quo[$r['Field']."_temp"]) unset($quo[$r['Field']]);
				unset($quo[$r['Field']."_temp"]);
			}	
			unset($quo['id']);
			$quo['create_user_id'] = $webmaster_id;
			$quo['create_date'] = date("Y-m-d H:i:s");
			$quo['prospek']=$idprospek;
			$this->db->insert('sv_quotation_trucking_custom',$quo);
		
		
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
			//$data['number']=generatenumbering('trucking');
			$data['number']=GetValue('number','marketing_form_prospect',array('id'=>'where/'.$data['prospek']));
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			$data['vendor']=$vendor;
			$this->generateinvoice_payable($data);
			//addnumbering('trucking');
			generateaitrucking($data);
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		$cl['npwp']=$data['npwp'];
		$cl['due_date']=$data['due_date'];
		$cl['bank_acc']=$data['bank_acc'];
		$this->db->where('id',$data['messers']);
		$this->db->update('sv_master_client',$cl);
			
			//ubah status prospek
			$numpros=GetValue('number','marketing_form_prospect',array('id'=>"where/".$data['prospek']));
			$this->db->where('prospek',$numpros);
			$this->db->update('sv_notif',array('status'=>'Y'));
		
		
		redirect($this->utama);
		
	}
	//function generateinvoice($jo,$tbl,$div,$mod){
	function generateinvoice_payable($devta){
		$mod='invoice_payable';
		//$allow=1;
		$webmaster_id=$this->session->userdata('webmaster_id');
			$job=GetAll('trucking_order',array('number'=>'where/'.$devta['number']))->row_array();
			//$ai=GetAll('sv_ai',array('job_order'=>'where/'.$data['number']))->result_array();
			
		$client=$devta['vendor'];
		
		$cln=GetValue('id','master_vendor',array('name'=>'where/'.$client));
		$data['vendor']=$cln;
		$quo=str_replace('invoice_','',$mod);
		
			//$data['jo']=$data['number'];
			$data['div']='account_payable';
			$parent=NULL;
			$div='TRC';
			
			$ceksblm=$this->db->query("SELECT * FROM sv_invoice WHERE vendor = '$cln' ");
			/* if($ceksblm->num_rows()==0){
			}else{
				$datin=$ceksblm->row_array();
				$allow=($datin['generate']=='Accept' ? 1 : 0 );
				if($allow==1){
				$this->db->where('jo',$data['number']);
				$this->db->update('sv_invoice',array('latest'=>'0'));
				$data['number']=$datin['number'];
				}
			} */
		if($ceksblm->num_rows()==0){
			$data['number']=generatenumbering($mod,$parent,NULL,NULL,$div,GetValue('code','master_vendor',array('name'=>'where/'.$client)));
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date'] = date("Y-m-d H:i:s");
			$data['type']='AP';
			$this->db->insert('sv_invoice',$data);
			$idnumb=$this->db->insert_id();
			$numb=$data['number'];
			//$lol=$this->db->query("SELECT * FROM sv_ai WHERE job_order = '$jo' AND b_subtotal>0 ")->result_array();
			if($idnumb){
				addnumbering($mod);
				$log['div']=$data['div'];
				$log['ref']=$data['number'];
				$log['ref_id']=$idnumb;
				$log['create_user_id'] = $data['create_user_id'];
				$log['create_date'] = $data['create_date'] ;
				$this->db->insert('invoice_log',$log);
			}
		
		}else{
				$datin=$ceksblm->row_array();
				/* $allow=($datin['generate']=='Accept' ? 1 : 0 );
				if($allow==1){
				$this->db->where('jo',$data['number']);
				$this->db->update('sv_invoice',array('latest'=>'0'));
				$data['number']=$datin['number'];
				} */
				$data['number']=$datin['number'];
				$numb=$data['number'];
				$idnumb=$datin['id'];
			}
	//lastq();
			//foreach($lol as $dota){
			//	$currency=strtolower($dota['b_currency']);
				//echo $currency;
					$detail['jo']=$devta['number'];
					$detail['invoice']=$data['number'];
					$detail['id_invoice']=$idnumb;
					$detail['desc']='Penggunaan Truck '.GetValue('code','master_truck',array('id'=>'where/'.$devta['vehicle_no'])).' dari '.$devta['vendor'].' dengan Job Number '.$devta['number'];
					$detail['qty']=1;
					//$detail["$currency"]=$dota['b_amount'];
				//$detail['total']=$dota['b_subtotal'];
				$this->db->insert('sv_invoice_detail',$detail);
			//}
		/* 	$total=$this->db->query("SELECT SUM(total) as total FROM sv_invoice_detail WHERE id_invoice='".$idnumb."' ")->row_array();*/
			
			
			$ubah['modify_user_id'] = $webmaster_id;
			$ubah['modify_date'] = date("Y-m-d H:i:s");
			
			$this->db->where('number',$numb);
			$this->db->update('sv_invoice',$ubah); 
			
			//notif
			/* $notif['message']=$data['div']." telah melakukan generate invoice dengan nomor ".$numb." ";
			$notif['from']= $webmaster_id;
			$notif['to']='Finance';
			$notif['status']='N';
			//$notif['prospek']=$numbering;
			$notif['link']='printing/invoice/'.$idnumb;
			$notif['create_user_id'] = $webmaster_id;
			$notif['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_notif',$notif); */
			//--notif
			//echo 'Sukses ! No. Invoice '.$numb;
			
		}
	
}
?>