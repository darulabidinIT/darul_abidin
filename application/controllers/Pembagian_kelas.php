<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : Januari 2020
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.3.1.1
*************************************/	

class Pembagian_kelas extends CI_Controller {
	
		var $utama ='pembagian_kelas';
		var $title ='Pembagian Kelas';
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
		$data['opt_tingkat']=GetOptAll('sv_master_tingkat','-All-',array('id'=>'where/abaceafe'));
                $data['opt_kelas']=GetOptAll('sv_master_kelas','-Kelas-',array());
		
		//$data['opt']=GetOptAll('menu','-Parents-');
                $data['opt_ta']=GetOptAll('sv_master_tahun_ajaran','-Tahun Ajaran-',array());
                $data['opt_siswa']=GetOptAll('sv_master_siswa','-Siswa-',array('id'=>'where/abcdefghijklmn'));
                $data['opt_jenjang']=GetOptAll('sv_master_jenjang','-All-',array());
		$this->load->view('layout/main',$data);
	}
	function listcol(){
		
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['no_sisda'] = array('No Sisda',110,TRUE,'left',2);
            $colModel['nama_siswa'] = array('Nama Siswa',200,TRUE,'left',2);
            $colModel['tempat_lahir'] = array('Tempat',100,TRUE,'left',2);
            $colModel['tanggal_lahir'] = array('Tanggal Lahir',90,TRUE,'left',2);
            return $colModel;
	}
	
	function get_column(){
            $colModel=$this->listcol(); 
			
            $gridParams = array(
                'rp' => 22,
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
            $this->db->select("sv_a.*")->from("$this->utama sv_a");
            
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
                                        $record_items[$a][$b]="<a href='".base_url()."master_siswa/auth/$row->id'>Menu</a>";
                                        
                                        }elseif($key=='prospek'){
                                        $record_items[$a][$b]="<a href='".base_url()."master_siswa/prospek/$row->id'>Prospek Ref</a>";
                                        
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
		}
		else{
			
		permissionz('c');
			$data['type']='New';
		}
		//$data['opt']=GetOptAll('menu','-Parents-');
                $data['opt_leader']=GetOptAll('sv_master_siswa','-Leader-',array(),'nama_lengkap');
                $data['opt_leader'][0]='-Tidak Ada Leader';
                //array_push($data['opt_leader'],$def);
		$data['content'] = 'contents/'.$this->utama.'/edit';
                
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function submit(){
		$webmaster_id=$this->session->userdata('webmaster_id');
		$id = $this->input->post('id');
		$GetColumns = GetColumns('sv_kelas_siswa');
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
			
			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}
                
		
		if($id != NULL && $id != '')
		{
			/* if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));} */
			
			if(izin('u')){
			$data['modify_by'] = $webmaster_id;
			$data['modify_on']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_kelas_siswa', $data);
                        
                        
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
			$this->db->insert('sv_kelas_siswa', $data);
			
                        
                        
			$this->session->set_flashdata("message", 'Sukses ditambahkan');}
			else{
				$this->session->set_flashdata("message", 'Anda Tidak Diizinkan Menambah Data');
			}
		}
		//divisi
		
		
		redirect($this->utama);
		
	}
        function load_view(){
            $ta=$this->input->post('ta');
            $jenjang=$this->input->post('j');
            $tingkat=$this->input->post('t');
            $kelas=$this->input->post('k');
            
            if(empty($jenjang))$filterjenjang=array();
            else $filterjenjang=array('id'=>'where/'.$jenjang);
            $data['jenjang']=GetAll('master_jenjang',$filterjenjang)->result_array();
            
            if(empty($ta)){
                echo '<div class="alert alert-danger" role="alert">
                        Silakan Pilih Tahun Ajaran
                        </div>';
            }
            else{
                $this->load->view("contents/".$this->utama."/loadview",$data);
            }
        }
        function form_item($id=null){
		
		if($id!=NULL){
		permissionz('u');
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			
		permissionz('c');
			$data['type']='New';
		}
		//$data['opt']=GetOptAll('menu','-Parents-');
                $data['opt_tingkat']=GetOptAll('sv_master_tingkat','-All-',array());
                $data['opt_kelas']=GetOptAll('sv_master_kelas','-All-',array());
		
		//$data['opt']=GetOptAll('menu','-Parents-');
                $data['opt_ta']=GetOptAll('sv_master_tahun_ajaran','-Tahun Ajaran-',array());
                $data['opt_jenjang']=GetOptAll('sv_master_jenjang','-All-',array());
                $data['opt_leader']=GetOptAll('sv_master_siswa','-Leader-',array(),'nama_lengkap');
                $data['opt_leader'][0]='-Tidak Ada Leader';
                //array_push($data['opt_leader'],$def);
		$data['content'] = 'contents/'.$this->utama.'/edit_spp';
                
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
        function item($id){
            $data['id']=$id;
            $data['id_data']=$this->input->post('id');
            $this->load->view('contents/kelas_siswa/item',$data);
        }
	function ambil_item(){
            $v=$this->input->post('v');
            $resp['price']=uang(GetValue('price','sv_setup_itempay',array('id'=>'where/'.$v)));
            //lastq();
            echo json_encode($resp);
        }
        
        function item_custom($id){
            $data['id']=$id;
            $data['id_data']=$this->input->post('id');
            $this->load->view('contents/kelas_siswa/item_custom',$data);
        }
	function spp_submit(){
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
                if($this->input->post('item')){
                    $item['item']=$this->input->post('item');}
                else{
                    $item['item']=array();
                }
                if($this->input->post('custom')){
                    $item['custom']=$this->input->post('custom');
                
                }
                else{
                    $item['custom']=array();
                }
                if($this->input->post('custom') || $this->input->post('item')){
                    $data['item_spp']=json_encode($item);
                }
		if($id != NULL && $id != '')
		{
			/* if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));} */
			
			if(izin('u')){
			$data['modify_by'] = $webmaster_id;
			$data['modify_on']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
                        
                        $datanya=GetAll('kelas_siswa',array('id'=>'where/'.$id))->row_array();
                        
			$this->session->set_flashdata("message", 'Item SPP '.GetValue('nama_siswa','master_siswa',array('id'=>'where/'.$datanya['siswa_id'])).' dari kelas '. GetValue('title', 'master_kelas',array('id'=>'where/'.$datanya['kelas'])).' SUKSES diedit');}
			else{
				$this->session->set_flashdata("message", 'Anda Tidak Diizinkan Mengedit Data');
			}
		}
//		else
//		{
//			
//			
//			if(izin('c')){
//			$data['created_by'] = $webmaster_id;
//			$data['created_on'] = date("Y-m-d H:i:s");
//			$this->db->insert('sv_'.$this->utama, $data);
//			
//                        
//                        
//			$this->session->set_flashdata("message", 'Sukses ditambahkan');}
//			else{
//				$this->session->set_flashdata("message", 'Anda Tidak Diizinkan Menambah Data');
//			}
//		}
		//divisi
		
		
		redirect($this->utama);
		
	}
         function load_siswa(){
             $ta=post('ta');
            if($ids!=null)$ids=rand(111,9999);
            $siswa=$this->db->query("SELECT * FROM sv_master_siswa WHERE id NOT IN (SELECT siswa_id FROM sv_kelas_siswa WHERE ta='$ta') AND aktif='1' ORDER BY nama_siswa")->result_array();
            //lastq();
            $opt_all['']="-Siswa-";
            foreach($siswa as $ss){
                $opt_all[$ss['id']]=$ss['nama_siswa'].' ('.$ss['no_sisda'].')';
            }
            echo form_dropdown('siswa_id',$opt_all,(isset($val['siswa']) ? $val['siswa'] : ''),"class='select2 form-control' id='siswa$ids' ");
                       echo "<script>
                            $(document).ready(function(e){ 
                                    $('#siswa$ids').css('width','400px').select2({allowClear:true});
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