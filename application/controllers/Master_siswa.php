<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : December 2019
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.3.1.1
*************************************/	

class Master_siswa extends CI_Controller {
	
		var $utama ='master_siswa';
		var $title ='Master Siswa';
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
            if(izin('c'))$buttons[] = array('daftar siswa baru','add','btn');
            $buttons[] = array('separator');
            if(izin('u'))$buttons[] = array('edit','edit','btn');
            if(izin('d'))$buttons[] = array('delete','delete','btn');
            $buttons[] = array('separator');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'nama_siswa','asc',$gridParams,$buttons,600);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->order_by('nama_siswa','asc');
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
                $data['opt_ta']=GetOptAll('sv_master_tahun_ajaran','-Tahun Ajaran-',array());
                $data['opt_jenjang']=GetOptAll('sv_master_jenjang','-Jenjang-',array());
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
                        $date=date('Y');
                        $digit=1000000+GetValue('val','sv_counter',array('id'=>'where/1'))+1;
                        $sisda=$date.substr($digit,1);
                        $data['no_sisda']=$sisda;
                        $this->db->query("UPDATE sv_counter SET val=val+1 WHERE id=1");
			$data['created_by'] = $webmaster_id;
			$data['created_on'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
                        $lid=$this->db->insert_id();
			$kelas_tmp=kelas_pmb(post('jenjang'));
                        
                        $q="SELECT * FROM sv_setup_pendaftaran WHERE id='".post('item_spp')."'";
                        if($mid==null){
                            //$mid=date('m');
                            $mid = date('m', strtotime('+1 month'));
                            $yid = date('Y', strtotime('+1 month'));
                        }
                        //$periode=GetAll('bill_periode',array('real_month'=>'where/'.(int)$mid))->row_array();
                        //$cekspp=$this->db->query("");
                        
                        $bill=array(
                            'type'=>'pmb',
                            'ta'=>post('periode'),
                            'periode'=>post('periode'),
                            'siswa_id'=>$lid,
                            'no_bill'=>gen_num('pmb',$sisda),
                            'title'=>'PMB '.post('nama_siswa')." ".GetValue('title','sv_master_tahun_ajaran',array('id'=>'where/'.post('periode'))),
                            'generate_date'=>date('Y-m-d'),
                            'due_date'=>$yid.'-'.$mid.'-15',
                            'created_by'=>'systemgenerated',
                            'created_on'=>date("Y-m-d H:i:s")
                        );
            $this->db->insert('sv_bill',$bill);
            $iid=$this->db->insert_id();
            
                   //$query=$this->db->query($q)->row_array();
                   //lastq();
                   $itemspp=json_decode(post('item_spp'));  
                foreach($itemspp->item as $it) {
                    $itempay=GetAll('setup_itempay',array('id'=>'where/'.$it))->row_array();
                    $bill_detail=array(
                        'bill_id'=>$iid,
                        'type'=>$itempay['type'],
                        'item'=>$itempay['title'],
                        'nominal'=>$itempay['price'],
                    );
                    $this->db->insert('sv_bill_detail',$bill_detail);
                }
                foreach($itemspp->custom as $it) {
                    
                    $itempay=GetAll('ref_item_custom',array('id'=>'where/'.$it->item))->row_array();
                    //print_r($it);
                    //$data['item_']=$it->item;
                    //$data['item_price']=$it->price;
                    $bill_detail=array(
                        'bill_id'=>$iid,
                        'type'=>$it->item,
                        'item'=>$itempay['title'],
                        'nominal'=>$it->price,
                    );
                    $this->db->insert('sv_bill_detail',$bill_detail);
                }
                    $kelas_siswa=array(
                        'kelas'=>$kelas_tmp,
                        'siswa_id'=>$lid,
                        'ta'=>post('periode')
                    );
                    $this->db->insert('sv_kelas_siswa',$kelas_siswa);
                        
                        
			$this->session->set_flashdata("message", 'Sukses ditambahkan');}
			else{
				$this->session->set_flashdata("message", 'Anda Tidak Diizinkan Menambah Data');
			}
		}
		//divisi
		
		
		redirect($this->utama);
		
	} 
        function load_spp($tingkat,$ids=null){
            
            if($ids!=null)$ids=rand(111,9999);
            
$opt_item['']='-Item-';
//$lengkap=$this->db->query("SELECT * FROM sv_setup_monthly WHERE a.id='".$id_data."'")->row_array();
//lastq();
$q="SELECT * FROM sv_setup_pendaftaran WHERE jenjang='$tingkat'";
$item=$this->db->query($q)->result_array();
//lastq();
foreach($item as $i){
    
$opt_item[$i['id']]=$i['title'];
    
}
            echo form_dropdown('item_spp',$opt_item,(isset($val['kelas']) ? $val['kelas'] : ''),"class='select2' onchange='changespp(this.value)' id='spp$ids'");
            echo "<div id='sppitem'></div>";
                       echo "<script>
                            $(document).ready(function(e){ 
                                    $('#spp$ids').css('width','200px').select2({allowClear:true});
                                        $('#select2-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which === 2) $('.select2').addClass('tag-input-style');
					 else $('.select2').removeClass('tag-input-style');
				});
                            });
                            function changespp(val){
                                $('#sppitem').load('".base_url()."master_siswa/item_spp/'+val);
                            }
                        </script>";
        }
        function item_spp($v){
            $g=GetAll('sv_setup_pendaftaran',array('id'=>'where/'.$v))->row_array();
            echo form_hidden('item_spp',$g['item']);
            $item=json_decode($g['item']);
            $total=0;
            foreach($item->item as $it){
                $harga=GetValue('price','setup_itempay',array('id'=>'where/'.$it));
                echo "<br>";
                echo GetValue('title','setup_itempay',array('id'=>'where/'.$it)).'  <b>('.uang($harga).')</b>';
                echo "<br>";
                $total+=$harga;
            }
            
            foreach($item->custom as $it){
                $harga=$it->price;
                echo "<br>";
                echo GetValue('title','ref_item_custom',array('id'=>'where/'.$it->item)).'  <b>('.uang($harga).')</b>';
                echo "<br>";
                $total+=$harga;
            }
            echo "<hr>";
            echo "TOTAL : ".uang($total);
        }
	
}
?>