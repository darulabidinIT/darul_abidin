<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : December 2019
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.3.1.11
*************************************/	

class Setup_daftar_ulang extends CI_Controller {
	
		var $utama ='setup_daftar_ulang';
		var $title ='Setup Harga Daftar Ulang';
	function __construct()
	{
		parent::__construct();permissionz();
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
		
		//permission();
		//$data = GetHeaderFooter();
		$data['content'] = 'contents/'.$this->utama.'/view';
		
		$data['js_grid']=$this->get_column();
		//$data['list']=GetAll($this->utama);
		
		$this->load->view('layout/main',$data);
	}
	function listcol(){
		
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['ta_'] = array('Tahun Ajaran',110,TRUE,'left',2);
            $colModel['jenjang_'] = array('Jenjang',110,TRUE,'left',2);
            $colModel['tingkat_'] = array('Tingkat',110,TRUE,'left',2);
            //$colModel['type_'] = array('Tipe Tagihan',110,TRUE,'left',2);
            //$colModel['title'] = array('Nama Item',110,TRUE,'left',2);
            $colModel['nominal_'] = array('Nominal',110,TRUE,'left',2);
            return $colModel;
	}
	
	function get_column(){
            $colModel=$this->listcol(); 
			
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
            if(izin('c'))$buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
            if(izin('u'))$buttons[] = array('edit','edit','btn');
            if(izin('d'))$buttons[] = array('delete','delete','btn');
            $buttons[] = array('separator');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'nama_lengkap','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->select("sv_a.*,sv_b.title ta_,IF(sv_a.jenjang='all', sv_a.jenjang, sv_c.title) as jenjang_,IF(sv_a.tingkat='all', sv_a.tingkat, sv_d.title) as tingkat_,CONCAT('Rp ', FORMAT(sv_a.price, 0)) as nominal_")->from("$this->utama sv_a");
            $this->db->join("master_tahun_ajaran sv_b","sv_a.ta=sv_b.id","left");
            $this->db->join("master_jenjang sv_c","sv_a.jenjang=sv_c.id","left");
            $this->db->join("master_tingkat sv_d","sv_a.tingkat=sv_d.id","left");
            
            $this->flexigrid->build_query();
		//lastq();

            //Get contents
            $return['records'] = $this->db->get();
	    //lastq();
            //Build count query
            $this->db->select("count(id) as record_count");
            $this->db->from($this->utama);
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record(){
		
			$colModel=$this->listcol();
		
			$z=0;
				foreach($colModel as $key=>$cm){
				$valid_fields[$z]=$key;
				$z++;
				}

            $this->flexigrid->validate_post('id','ASC',$valid_fields);
            $records = $this->get_flexigrid();

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();
			$a=0;
            foreach ($records['records']->result() as $row)
            {/*
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/ 
			
				$record_items[$a][]=$row->id;
				$record_items[$a][]=$row->id;
				$record_items[$a][]=$row->id;
				$b=2;
				foreach($colModel as $key=>$cm){
					if($key=='auth'){
                                        $record_items[$a][$b]="<a href='".base_url()."master_tingkat/auth/$row->id'>Menu</a>";
                                        
                                        }elseif($key=='prospek'){
                                        $record_items[$a][$b]="<a href='".base_url()."master_tingkat/prospek/$row->id'>Prospek Ref</a>";
                                        
                                        }
					elseif($key=='username'){
                                        $record_items[$a][$b]=GetValue('username','sv_admin',array('marketing'=>'where/'.$row->id));
                                        
                                        }
					elseif($key!='idnya' && $key!='id' && $key!='username'){
                                        $record_items[$a][$b]=$row->$key;}
				$b++;
				}
						$a++;
            }

            return $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));;
	}  
	function ok(){
		print_r($GLOBALS['colModel']);
	}

	function deletec()
	{		
		//return true;
		if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
			/*if (is_numeric($country_id) && $country_id > 0) {
				$this->delete($country_id);}*/
				$data['status']='InAktif';
				$this->db->where('id',$country_id);
				//$this->db->update($this->utama,$data);
			$this->db->delete($this->utama,array('id'=>$country_id));				
		}
			echo 'ok';
		}
		else{
			echo 'error';
		}
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
	
	function form($id=null){
		
		if($id!=NULL){
		permissionz('u');
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
                        $v=$data['list']->row_array();
                        $data['opt_tingkat']=GetOptAll('sv_master_tingkat','-All-',array('jenjang'=>'where/'.$v['jenjang']));
                        $data['opt_kelas']=GetOptAll('sv_master_kelas','-All-',array('tingkat'=>'where/'.$v['tingkat']));
		}
		else{
			
                        permissionz('c');
			$data['type']='New';
                        $data['opt_tingkat']=GetOptAll('sv_master_tingkat','-All-',array('id'=>'where/abaceafe'));
                        $data['opt_kelas']=GetOptAll('sv_master_kelas','-All-',array('id'=>'where/abaceafe'));
		}
		//$data['opt']=GetOptAll('menu','-Parents-');
                $data['opt_ta']=GetOptAll('sv_master_tahun_ajaran','-Tahun Ajaran-',array());
                $data['opt_jenjang']=GetOptAll('sv_master_jenjang','-All-',array());
                //array_push($data['opt_leader'],$def);
		$data['content'] = 'contents/'.$this->utama.'/edit';
                
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
                if(!$this->input->post('jenjang'))$data['jenjang']='all';
                if(!$this->input->post('tingkat'))$data['tingkat']='all';
                $data['price']=str_replace(',','.',str_replace('.','',str_replace('Rp ','',$data['price'])));
		
		if($id != NULL && $id != '')
		{
			/* if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));} */
			
			if(izin('u')){
			$data['modify_by'] = $webmaster_id;
			$data['modify_on']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
                        
                        
			$this->session->set_flashdata("message", 'Sukses diedit');}
			else{
				$this->session->set_flashdata("message", 'Anda Tidak Diizinkan Mengedit Data');
			}
		}
		else
		{
			
			
			if(izin('c')){
			$data['created_by'] = $webmaster_id;
			$data['created_on'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			
                        
                        
			$this->session->set_flashdata("message", 'Sukses ditambahkan');}
			else{
				$this->session->set_flashdata("message", 'Anda Tidak Diizinkan Menambah Data');
			}
		}
		//divisi
		
		
		redirect($this->utama);
		
	}
        function loadjenjang(){
            $ids=rand(111,9999);
            echo form_dropdown('jenjang',GetOptAll('master_jenjang','-All-',array()),(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changejenjang(this.value)' id='jenjang$ids'");
            echo"<script>
                    $(document).ready(function(e){ 
                        $('#jenjang$ids').css('width','200px').select2({allowClear:true});
				$('#select2-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which === 2) $('.select2').addClass('tag-input-style');
					 else $('.select2').removeClass('tag-input-style');
				});});
                    
                    </script>";
        }
	function loadtingkat($jenjang){
            $ids=rand(111,9999);
            echo form_dropdown('tingkat',GetOptAll('master_tingkat','-All-',array('jenjang'=>'where/'.$jenjang)),(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='gantitingkat(this.value)' id='tingkat$ids'");
                       echo "<script>
                            $(document).ready(function(e){ 
                                    $('#tingkat$ids').css('width','200px').select2({allowClear:true});
                                        $('#select2-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which === 2) $('.select2').addClass('tag-input-style');
					 else $('.select2').removeClass('tag-input-style');
				});});
                    
                     
                              </script>";
        }
        function loadkelas($tingkat){
            $ids=rand(111,9999);
            echo form_dropdown('kelas',GetOptAll('master_kelas','-All-',array('tingkat'=>'where/'.$tingkat)),(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' id='kelas$ids'");
                       echo "<script>
                            $(document).ready(function(e){ 
                                    $('#kelas$ids').css('width','200px').select2({allowClear:true});
                                        $('#select2-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which === 2) $('.select2').addClass('tag-input-style');
					 else $('.select2').removeClass('tag-input-style');
				});
                            });
                        </script>";
        }
}
?>