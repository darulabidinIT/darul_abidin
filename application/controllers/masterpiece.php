<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : Dec 2014
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.2
*************************************/	

class Masterpiece extends CI_Controller {
	
		var $utama ='masterpiece';
		var $title ='Masterpiece';
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{permissionBiasa();
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
	function form($id=null){
		
		
		permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
		$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
			$data['opt']=GetOptAll('product');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	function submit(){
		permissionBiasa();
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
function getpic($id){
		permissionBiasa();
	if($id!=NULL){
		
			
		$data['list']=GetAll('pic_mas',array('id_mas'=>'where/'.$id));
		
		$this->load->view('contents/masterpiece/pic',$data);
			
	}
}
public function upload($id){ 
//if($_FILES['file_upload']['tmp_name']!=NULL){
if (!empty($_FILES)) {
	$time=date('YmdHis');
		$config['upload_path'] = './assets/masterpiece/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '10000';
		$config['max_width']  = '1900';
		$config['max_height']  = '1200';
		$config['file_name']=md5('product_'.$time);

		$this->load->library('upload', $config);

		
		
		 if (!$this->upload->do_upload('Filedata')) {
            $upload_error = $this->upload->display_errors();
            echo json_encode($upload_error);
        } else {
            $file_info = $this->upload->data();
			$file =  $file_info['full_path'];
			$data['pic']=$config['file_name'].substr($file,-4);
			$data['id_mas']=$id;
			$data['is_active']='Active';
			$data['create_user_id']='Active';
			$data['create_date']=$time;
			$this->db->insert('pic_mas',$data);
            echo json_encode($file_info);
        }
}
}
	
	function deletepic($idmas,$id){
		unlink('./assets/masterpiece/'.GetValue('pic','pic_mas',array('id'=>'where/'.$id)));
	$this->db->where('id',$id);
	$this->db->delete('sv_pic_mas');	
			$this->session->set_flashdata("message", 'Sukses dihapus');
		redirect($this->utama.'/form/'.$idmas);
		
	}
	function setcover($idmas,$id){
		
		$data['cover']=0;
	$this->db->where('id_mas',$idmas);
	$this->db->update('sv_pic_mas',$data);
	
		$dataa['cover']=1;
	$this->db->where('id',$id);
	$this->db->update('sv_pic_mas',$dataa);
	
			
	$this->session->set_flashdata("message", 'Sukses Dijadikan Cover');
	redirect($this->utama.'/form/'.$idmas);
		
	}
	
}
?>