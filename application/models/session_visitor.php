<?php 
class session_visitor extends CI_Model{
	function ceksesicookie(){
		
	$userinfo=getBrowserOS();
	//$sessioncookies=md5('SysvitTech'.$userinfo['browser'].''.$userinfo['os']);
	$sesi=$this->session->userdata('sysvit_visited');
	if(!$sesi){
		$this->db->insert('visitor',$userinfo);
		$id=$this->db->insert_id();
		$this->session->set_userdata('sysvit_visited',1);
		$this->session->set_userdata('user_type','visitor');
		$this->session->set_userdata('cookie_id',$id);
		$this->session->set_userdata('avatar','default.png');
		
		/*if(!array_key_exists('Sendyuu_Cookies',$_COOKIE)){
			$cookie = array(
    		'name'   => 'Sendyuu_Cookies',
    		'value'  => array(
							'identity'=>$sessioncookies,
							'isi_cart'=>array(
								'1'=>array(
								)
							)
						),
    		'expire' => time()+60*60*24*30,
    		'domain' => base_url(),
    		'path'   => '/',
			'prefix' => 'rebellion_',
    		'secure' => TRUE
			);
			setcookie($cookie['name'],serialize($cookie['value']),$cookie['expire']);
		}*/
	}
		
		}
	function cekLogin($username,$userpass)
	{
		$this->db->where("username",$username);
		$this->db->where("password",$userpass);
		$query=$this->db->get("users");
		return $query;
	}
	
}