<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : December 2019
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.3.1.11
*************************************/	

class Admin extends CI_Controller {
	
		var $utama ='admin';
		var $title ='Akun Admin';
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
		
		
		permissionFormUser($id);
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
	if($id!=$this->session->userdata('webmaster_id')){	
		if(!$this->input->post('is_active')){$data['is_active']='InActive';}
		else{$data['is_active']='Active';}
	}
		
		##image nih
		if (!empty($_FILES['avatar']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/ace/avatars/';
			$config['allowed_types'] = 'gif|jpg|png|ico';
			$config['max_size']	= '10000';
			$config['max_width']  = '1900';
			$config['max_height']  = '1200';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if($id != NULL && $id != ''){
			unlink('./assets/ace/avatars/'.GetValue('avatar','admin',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('avatar')) {
				$upload_error = $this->upload->display_errors();
				//echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				$data['avatar']=$config['file_name'].substr($file,-4);
				//echo json_encode($file_info);
       		}
		}
		##image nih
		
		
		if($id != NULL && $id != '')
		{
			if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			if (empty($_FILES['avatar']['name'])) {unset($data['avatar']);}
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
			if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			if (empty($_FILES['avatar']['name'])) {$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			$profil['useradmin']=$id;
			$profil['name']=$data['name'];
			$profil['avatar']=$data['avatar'];
			$profil['create_user_id'] = $webmaster_id;
			$profil['create_date'] = $data['create_date'];
			$this->db->insert('sv_admin_profile',$profil);
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect($this->utama);
		
	}
	function profile($id=null){
		
		
		permissionFormUser($id);
		if($id!=NULL){
			$filter=array('useradmin'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll('sv_admin_profile',$filter);
		}
		else{
			$data['type']='New';
		}
		$data['opt']=GetOptAll('admin_grup');
		$data['content'] = 'contents/'.$this->utama.'/profile';
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	function submit_profile(){
		$webmaster_id=$this->session->userdata('webmaster_id');
		$id = $this->input->post('id');
		$GetColumns = GetColumns('sv_admin_profile');
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
			
			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		/* if(!$this->input->post('is_active')){$data['is_active']='InActive';}
		else{$data['is_active']='Active';} */
		
		##image nih
		if (!empty($_FILES['avatar']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/ace/avatars/';
			$config['allowed_types'] = 'gif|jpg|png|ico';
			$config['max_size']	= '10000';
			$config['max_width']  = '1900';
			$config['max_height']  = '1200';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if($id != NULL && $id != ''){
					$foto=GetValue('avatar','admin_profile',array('useradmin'=>'where/'.$id));
					if($foto!='default.png'){
						unlink('./assets/ace/avatars/'.GetValue('avatar','admin_profile',array('id'=>'where/'.$id)));
					}
			}
			
			if (!$this->upload->do_upload('avatar')) {
				$upload_error = $this->upload->display_errors();
				//echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				$data['avatar']=$config['file_name'].substr($file,-4);
				//echo json_encode($file_info);
       		}
		}
		##image nih
		
		
		if($id != NULL && $id != '')
		{
			if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){unset($data['avatar']);}
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_admin_profile', $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
			if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_admin_profile', $data);
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
	
}
?>