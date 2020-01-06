<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : Januari 2020
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.3.11
*************************************/	

class Admin_Grup extends CI_Controller {
	
		var $utama ='admin_grup';
		var $title ='Grup Admin';
	function __construct()
	{
		parent::__construct();
                permissionz();
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
		//Migrasi 1 Feb 14
		//Set Global
		//$data = GetHeaderFooter();
		$data['content'] = 'contents/'.$this->utama.'/view';
		$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	function form($id=null){
		
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
		$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
			$data['opt']=GetOptAll('admin_grup');
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
		if(!$this->input->post('is_active')){$data['is_active']='InActive';}
		else{$data['is_active']='Active';}
		
		if($id != NULL && $id != '')
		{
                        permissionz('u');
			if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
                        permissionz('c');
			if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect($this->utama);
		
	}

	function delete($id){
	$this->db->where('id',$id);
	$this->db->delete('sv_'.$this->utama);	
			$this->session->set_flashdata("message", 'Sukses dihapus');
		redirect($this->utama);
		
	}
        
	function auth($id=null){
		
		error_reporting(0);
		/* permissionz();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
		$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		} */
		
		$data['modul']=GetAll('menu',array('id_parents'=>'where/0','is_active'=>'where/Active'));
		//lastq();
		$data['id_user']=$id;
		//$this->data['id_grup']=GetValue('id','admin_grup',array('user_id'=>'where/'.$id));
		$data['opt']=GetOptAll('admin_grup');
		$data['content'] = 'contents/'.$this->utama.'/auth';
		//End Global
		
		
		$this->load->view('layout/main',$data);
	}
	function auth_submit(){
            error_reporting(0);
		$menu=$this->input->post('menu');
		
		$m_c=$this->input->post('m_c');
		$m_v=$this->input->post('m_v');
		$m_u=$this->input->post('m_u');
		$m_d=$this->input->post('m_d');
		
		$submenu=$this->input->post('submenu');
		$s_c=$this->input->post('s_c');
		$s_v=$this->input->post('s_v');
		$s_u=$this->input->post('s_u');
		$s_d=$this->input->post('s_d');
		
		$user=GetValue('id','admin_grup',array('title'=>'where/'.$this->input->post('user_group')));
		foreach($menu as $m){
				$cek=GetAll('users_permission_sf',array('user_group'=>'where/'.$user,'menu_id'=>'where/'.$m))->num_rows();
				$data['menu_id']=$m;
				$data['create']=($m_c[$m] ? '1':'0');
				$data['view']=($m_v[$m] ? '1':'0');
				$data['update']=($m_u[$m] ? '1':'0');
				$data['delete']=($m_d[$m] ? '1':'0');
				//$data['user_id']=$user;
				//$data['user_id']=GetValue('group_id','users_groups',array('user_id'=>'where/'.$user));
				$data['user_group']=$user;
				if($cek==0){
						$this->db->insert('users_permission_sf',$data);
				}
				else{
						$this->db->where(array('user_group'=>$user,'menu_id'=>$m));
						$this->db->update('users_permission_sf',$data);
				}
                }
		foreach($submenu as $sm){
				$cek=GetAll('users_permission_sf',array('user_group'=>'where/'.$user,'menu_id'=>'where/'.$sm))->num_rows();
				$data['menu_id']=$sm;
				$data['create']=($s_c[$sm] ? '1':'0');
				$data['view']=($s_v[$sm] ? '1':'0');
				$data['update']=($s_u[$sm] ? '1':'0');
				$data['delete']=($s_d[$sm] ? '1':'0');
				//$data['user_id']=$user;
				//$data['user_id']=GetValue('group_id','users_groups',array('user_id'=>'where/'.$user));
				
				$data['user_group']=$user;
				if($cek==0){
						$this->db->insert('users_permission_sf',$data);
				}
				else{
						$this->db->where(array('user_group'=>$user,'menu_id'=>$sm));
						$this->db->update('users_permission_sf',$data);
				}
                }
                redirect($this->utama);
        }
	
}
?>