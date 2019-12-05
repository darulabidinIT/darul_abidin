<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class ai extends CI_Controller {
	
		var $utama ='ai';
		var $title ='Account Information';
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
	
	function main($type,$id)
	{
			if(!$id){redirect('forbidden');}
			if($type=='trucking'){$low='_order';}
			else{$low='_job';}
			$tbl=$type.$low;
		//Migrasi 1 Feb 14
		//permissionBiasa();
		//Set Global
		//permission();
		//$data = GetHeaderFooter();
		$data['job_order']=GetValue('number',$tbl,array('id'=>'where/'.$id));
		$data['id']=$id;
		$data['type']=$type;
		$q=$this->db->query("SELECT SUM(b_subtotal) as sales,SUM(c_subtotal) as cost FROM sv_ai WHERE job_order='".$data['job_order']."'")->row_array();
		
		$data['sales']=$q['sales'];
		$data['cost']=$q['cost'];
		$data['profit']=$q['sales']-$q['cost'];	
		$data['content'] = 'contents/'.$this->utama.'/view';
		
		$data['js_grid']=$this->get_column($id,$tbl);
		//$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function get_column($id,$tbl){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',7,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',7,TRUE);
			$colModel['code'] = array('Code',110,TRUE,'left',7,TRUE);
			$colModel['desc'] = array('Deskripsi',110,TRUE,'left',2);
            $colModel['b_acc'] = array('Sales Acc',110,TRUE,'left',7);
            $colModel['b_item'] = array('Item',110,TRUE,'left',7);
            $colModel['b_item_price'] = array('Price',110,TRUE,'left',7);
            $colModel['b_amount'] = array('Amount',110,TRUE,'left',7);
            $colModel['b_tax_amount'] = array('Tax Amount',110,TRUE,'left',7);
            $colModel['b_subtotal'] = array('Subtotal',110,TRUE,'left',7);
            $colModel['c_acc'] = array('Cost Acc',110,TRUE,'left',7);
            $colModel['c_item'] = array('Item',110,TRUE,'left',7);
            $colModel['c_item_price'] = array('Price',110,TRUE,'left',7);
            $colModel['c_amount'] = array('Amount',110,TRUE,'left',7);
            $colModel['c_tax_amount'] = array('Tax Amount',110,TRUE,'left',7);
            $colModel['c_subtotal'] = array('Subtotal',110,TRUE,'left',7);
        
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
            $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
             $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
            $buttons[] = array('separator');
            $buttons[] = array('print','print','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record/".$id.'/'.$tbl),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid($id,$tbl)
        {
			
			$jo=GetValue('number',$tbl,array('id'=>'where/'.$id));
            //Build contents query
            $this->db->select("*")->from($this->utama);
			$this->db->where(array('job_order'=>$jo));
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->utama);
			$this->db->where(array('job_order'=>$jo));
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record($id,$tbl){
		
		$valid_fields = array('id','number','create_date','desc');
            $this->flexigrid->validate_post('id','DESC',$valid_fields);
            $records = $this->get_flexigrid($id,$tbl);

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {/*
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/
				
                $code=(GetValue('code','setup_account_mapping',array('id'=>'where/'.$row->acc)) !=0 ? GetValue('code','setup_account_mapping',array('id'=>'where/'.$row->acc)) : $row->acc );
                $name=(GetValue('name','setup_account_mapping',array('id'=>'where/'.$row->acc)) !=0 ? GetValue('name','setup_account_mapping',array('id'=>'where/'.$row->acc)) : $row->b_desc) ;
				
				
                $record_items[] = array(
                $row->id,
                $row->id,
                $row->id,
				$code,
				$name,
                "<span style='color:green;'>".$row->b_acc."</span>",
                "<span style='color:green;'>".$row->b_item."</span>",
                "<span style='color:green;'>".uang($row->b_item_price)."</span>",
                "<span style='color:green;'>".uang($row->b_amount)."</span>",
                "<span style='color:green;'>".numbers($row->b_tax_amount)."%</span>",
                "<span style='color:green;'>".uang($row->b_subtotal)."</span>",
                "<span style='color:red;'>".$row->c_acc."</span>",
                "<span style='color:red;'>".$row->c_item."</span>",
                "<span style='color:red;'>".uang($row->c_item_price)."</span>",
                "<span style='color:red;'>".uang($row->c_amount)."</span>",
                "<span style='color:red;'>".numbers($row->c_tax_amount)."%</span>",
                "<span style='color:red;'>".uang($row->c_subtotal)."</span>",
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
	
	function form($id=null,$job,$type){
		
		permissionBiasa();
		
		
		if(!is_numeric($id)){redirect('forbidden');}
		if($type=='trucking'){$low='_order';}
		else{$low='_job';}
		$tbl=$type.$low;
		//Migrasi 1 Feb 14
		//permissionBiasa();
		//Set Global
		//permission();
		//$data = GetHeaderFooter();
		$data['url']=$type.'/'.$job;
		$data['job_order']=GetValue('number',$tbl,array('id'=>'where/'.$job));
		$fix='';
		if($type!='trucking'){
			$forms=GetValue('form',$tbl,array('id'=>'where/'.$job));
			if($forms!='CC'){$fix='';}
			else{$fix='_cc';}
		}
		$alias[0]=GetValue('id','ref_accmap',array('alias'=>'where/'.$type.$fix));
		$alias[1]=GetValue('id','ref_accmap',array('alias'=>'where/all'));
		
		
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
		//echo $job;
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		$data['opt_client']=GetOptAll('master_client','-Client-',array('status'=>'where/1'),'name');
		$data['opt_port']=GetOptAll('master_airport','-Airport-',array(),'name');
		$data['opt_airline']=GetOptAll('master_airline','-Airline-',array(),'name');
		$data['opt_metric']=GetOptAll('master_metric','-metric-',array(),'code');
		$data['opt_marketing']=GetOptAll('marketing_form_prospect','-prospect-',array(),'number');
		$data['opt_curr']=GetOptAll('master_currency','-Currency-',array(),'name');
		$data['opt_acc']=GetOptAll('setup_account_mapping','-Account-',array(),'code','id','name',array('type'=>$alias));
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
		$data['b_item_price']=str_replace(',','',$data['b_item_price']);
		$data['c_item_price']=str_replace(',','',$data['c_item_price']);
		
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
		//$id=GetValue('id','sv_import_sea_job',array('number'=>'where/'.$this->input->post('job_order')));
		redirect($this->utama.'/main/'.$this->input->post('url'));
		
	}
	
}
?>