<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class invoice_payable extends CI_Controller {
	
		var $utama ='invoice';
		var $title ='Invoice';
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
		$data['content'] = 'contents/'.$this->utama.'_payable/view';
		
		$data['js_grid']=$this->get_column($id);
		//$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function get_column($id){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
			$colModel['name'] = array('Vendor',200,TRUE,'left',2);
			//$colModel['consignee'] = array('Consignee',200,TRUE,'left',2);
			$colModel['number'] = array('Invoice',200,TRUE,'left',2);
			$colModel['modify_date'] = array('Last Updated',200,TRUE,'left',2);
			//if(!$id || $id=='trucking')$colModel['action'] = array('Aksi',110,TRUE,'left',2);
        
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
            $buttons[] = array('separator');
           // $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
            // $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
		$buttons[] = array('separator');
		$buttons[] = array('detail','detail','btn');
		if(webmastergrup() ==7 || webmastergrup() == '2706')$buttons[] = array('pay','pay','btn');
		if($id== 'trucking')$buttons[] = array('edit kewill','pay','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."_payable/get_record/".$id),$colModel,'sv_invoice.modify_date','desc',$gridParams,$buttons);
	}
	
	function get_flexigrid($id)
        {

            //Build contents query
            $this->db->select("sv_invoice.id id, sv_invoice.number number, sv_master_vendor.name name,sv_invoice.modify_date modify_date")->from($this->utama);
			$this->db->join('master_vendor', "$this->utama.vendor=sv_master_vendor.id", 'left');
			$this->db->where(array('type'=>'AP'));
			//$this->db->where(array('latest'=>'1'));
			if($id) $this->db->where(array('div'=>$id));
			$this->db->order_by('sv_invoice.modify_date','DESC');
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();
			//lastq();

            //Build count query
            $this->db->select("count(sv_invoice.id) as record_count")->from($this->utama);
			$this->db->join('master_vendor', "$this->utama.vendor=sv_master_vendor.id", 'left');
			$this->db->where(array('type'=>'AP'));
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
		
		$valid_fields = array('id','number','name');
            $this->flexigrid->validate_post('sv_invoice.modify_date','DESC',$valid_fields);
            $records = $this->get_flexigrid($id);

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {
				$shipper=$consignee='';
				
		$div=$row->div;
		$jo=$row->jo;
		$num=explode('/',$row->number);
		
				
				/*if($div!='trucking'){
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
			$detail=$joborder->row_array();
						$shipper=GetValue('name','master_client',array('id'=>'where/'.$detail['shipper']));
						//lastq();
						$consignee=GetValue('name','master_client',array('id'=>'where/'.$detail['consignee']));
			
		}
		else{
						$joborder=$this->db->query(" SELECT * FROM sv_trucking_order WHERE number='$jo'");
						$inv_detail=$this->db->query(" SELECT * FROM sv_invoice_detail WHERE invoice='$num'")->row_array();
						$jo=$inv_detail['jo'];
						$potong=explode('/',$num);
						$shipper=GetValue('name','master_client',array('code'=>'where/'.$potong[2]));
						$consignee='-';
		}
				
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/
			
				
                $record_items[] = array(
                $row->id,
                $row->id,
                $row->id,
                $row->name,
                $row->number,
                $row->modify_date
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
	/* function detail($id=null,$job=NULL){
		
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
	} */
	
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
		$allow=1;
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
			$ceksblm=$this->db->query("SELECT * FROM sv_invoice WHERE jo='$jo' AND latest='1'");
			if($ceksblm->num_rows()==0){
				$data['number']=generatenumbering($mod,$parent,NULL,NULL,$div,$cln);
				addnumbering($mod);
			}else{
				$datin=$ceksblm->row_array();
				$allow=($datin['generate']=='Accept' ? 1 : 0 );
				if($allow==1){
				$this->db->where('jo',$jo);
				$this->db->update('sv_invoice',array('latest'=>'0'));
				$data['number']=$datin['number'];
				}
			}
		if($allow==1){
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_invoice',$data);
			$idnumb=$this->db->insert_id();
			$numb=$data['number'];
			$lol=$this->db->query("SELECT * FROM sv_ai WHERE job_order = '$jo' AND b_subtotal>0 ")->result_array();
			if($idnumb){
				$log['div']=$data['div'];
				$log['ref']=$data['number'];
				$log['ref_id']=$idnumb;
				$log['create_user_id'] = $data['create_user_id'];
				$log['create_date'] = $data['create_date'] ;
				$this->db->insert('invoice_log',$log);
			}
	//lastq();
			foreach($lol as $dota){
				$currency=strtolower($dota['b_currency']);
				//echo $currency;
					$detail['invoice']=$data['number'];
					$detail['id_invoice']=$idnumb;
					$detail['desc']=$dota['b_desc'];
					$detail['qty']=$dota['b_item'];
					$detail["$currency"]=$dota['b_amount'];
				$detail['total']=$dota['b_subtotal'];
				$this->db->insert('sv_invoice_detail',$detail);
			}
			$total=$this->db->query("SELECT SUM(total) as total FROM sv_invoice_detail WHERE id_invoice='".$idnumb."' ")->row_array();
			
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
			echo 'Sukses ! No. Invoice '.$numb;
		}
		else{
			
			echo 'Gagal ! Tidak diizinkan untuk generate Invoice job order ini lagi ';
		}
			
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
			if($idnya){
				$log['div']=$data['div'];
				$log['ref']=$data['number'];
				$log['ref_id']=$idnya;
				$log['create_user_id'] = $data['create_user_id'];
				$log['create_date'] = $data['create_date'] ;
				$this->db->insert('invoice_log',$log);
			}
			foreach($job as $jorder){
				$lol=$this->db->query("SELECT * FROM sv_ai WHERE job_order='".$jorder['number']."' AND b_subtotal>0")->result_array();

				foreach($lol as $dota){
				$currency=strtolower($dota['b_currency']);
					$detail['invoice']=$numb;
					$detail['id_invoice']=$idnya;
					$detail['jo']=$jorder['number'];
					$detail['desc']=$dota['b_desc'];
					$detail['qty']=$dota['b_item'];
					$detail["$currency"]=$dota['b_amount'];
					$detail['total']=$dota['b_subtotal'];
					$this->db->insert('sv_invoice_detail',$detail);
				}
			}
			
			$total=$this->db->query("SELECT SUM(total) as total FROM sv_invoice_detail WHERE id_invoice='".$idnya."' ")->row_array();
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
	
	function detail($id)
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
		$data['content'] = 'contents/'.$this->utama.'_payable/view_detail';
		
		$data['js_grid']=$this->get_columns($id);
		//$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function get_columns($id){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
			$colModel['jo'] = array('Job Order / PO',110,TRUE,'left',2);
			$colModel['status'] = array('Lunas?',200,TRUE,'left',2);
			/* $colModel['consignee'] = array('Consignee',200,TRUE,'left',2);
			$colModel['number'] = array('Invoice',200,TRUE,'left',2);
			$colModel['type'] = array('Type',200,TRUE,'left',2);
			$colModel['total'] = array('Total',110,TRUE,'left',2);
			$colModel['status'] = array('Status',110,TRUE,'left',2);
			$colModel['last_pay'] = array('Last Pay',110,TRUE,'left',2); */
			//if(!$id || $id=='trucking')$colModel['action'] = array('Aksi',110,TRUE,'left',2);
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
           /* $buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');
           // $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
            // $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
		$buttons[] = array('separator');
		$buttons[] = array('detail','detail','btn');
		if(webmastergrup() ==7 || webmastergrup() == '2706')$buttons[] = array('pay','pay','btn');
		if($id== 'trucking')$buttons[] = array('edit kewill','pay','btn');
		 */
            return $grid_js = build_grid_js('flex1',site_url($this->utama."_payable/get_records/".$id),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrids($id)
        {

            //Build contents query
            $this->db->select("*")->from('sv_invoice_detail');
			//$this->db->where(array('type'=>'AR'));
			//$this->db->where(array('latest'=>'1'));
			if($id) $this->db->where(array('id_invoice'=>$id));
			$this->db->order_by('create_date','DESC');
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from('sv_invoice_detail');
			/* $this->db->where(array('type'=>'AR'));
			$this->db->where(array('latest'=>'1')); */
			if($id) $this->db->where(array('id_invoice'=>$id));
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_records($id){
		
		$valid_fields = array('id','jo','create_date');
            $this->flexigrid->validate_post('create_date','DESC',$valid_fields);
            $records = $this->get_flexigrids($id);

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {
			$statuschek=($row->status=='Y' ? 'checked' : '');
			$check="<input type='checkbox' name='cek' id='cek' $statuschek onClick='gantistatus($row->id)' >";
				//$shipper=$consignee='';
				
		/*$div=$row->div;
		$jo=$row->jo;
		$num=$row->number;
				
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
			$detail=$joborder->row_array();
						$shipper=GetValue('name','master_client',array('id'=>'where/'.$detail['shipper']));
						//lastq();
						$consignee=GetValue('name','master_client',array('id'=>'where/'.$detail['consignee']));
			
		}
		else{
						$joborder=$this->db->query(" SELECT * FROM sv_trucking_order WHERE number='$jo'");
						$inv_detail=$this->db->query(" SELECT * FROM sv_invoice_detail WHERE invoice='$num'")->row_array();
						$jo=$inv_detail['jo'];
						$potong=explode('/',$num);
						$shipper=GetValue('name','master_client',array('code'=>'where/'.$potong[2]));
						$consignee='-';
		}
				
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}
			if($row->div=='trucking'){
				$po=$row->po;
			}else{
				$po=$row->jo;
			}*/
				
                $record_items[] = array(
                $row->id,
                $row->id,
                $row->id,
                $row->jo,
                $check
                        );
            }

            return $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));;
	}  
	function changestatus(){
		$id=$_REQUEST['v'];
		$kini=GetValue('status','sv_invoice_detail',array('id'=>'where/'.$id));
		$ganti=($kini=='Y' ? 'N' : 'Y');
		$this->db->where('id',$id);
		$this->db->update('sv_invoice_detail',array('status'=>$ganti));
		
	}

}
?>