<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : December 2019
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.3.1.11
*************************************/	

class payment extends CI_Controller {
	
		var $utama ='payment';
		var $title ='Payment';
	function __construct()
	{
		parent::__construct();
                permissionBiasa();
		$this->load->library('flexigrid');
                $this->load->helper('flexigrid');
                error_reporting(0);
	}
	
	function index()
	{
		$this->form();
	}
	
	function main()
	{
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
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['code'] = array('code',110,TRUE,'left',2);
            $colModel['name'] = array('name',110,TRUE,'left',2);
        
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
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->select("*")->from($this->utama);
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->utama);
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record(){
		
		$valid_fields = array('id','code','name');

            $this->flexigrid->validate_post('id','DESC',$valid_fields);
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
                $row->code,
				$row->name
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
			$data['list']=GetAll('sv_invoice',$filter);
		}
		else{
			$data['type']='New';
		}
		$data['opt']=GetOptAll('menu','-Parents-');
                
		$data['opt_coa']=GetOptAll('setup_coa','-Account-',array('level >'=>'where/1'),'code','code','name');
		//End Global
		$data['history']=GetAll('sv_payment',array('invoice'=>'where/'.$id))->result_array();
		//Attendance
		$data['opt_tingkat']=GetOptAll('sv_master_tingkat','-All-',array('id'=>'where/abaceafe'));
                $data['opt_kelas']=GetOptAll('sv_master_kelas','-All-',array('id'=>'where/abaceafe'));
		
		//$data['opt']=GetOptAll('menu','-Parents-');
                $data['opt_ta']=GetOptAll('sv_master_tahun_ajaran','-Tahun Ajaran-',array());
                $data['opt_jenjang']=GetOptAll('sv_master_jenjang','-All-',array());
                $ta=$this->db->query("SELECT * FROM sv_master_tahun_ajaran WHERE (start<=CURDATE() AND end >=CURDATE())")->row_array();
                $siswa=$this->db->query("SELECT sv_a.*,b.nama_siswa,c.title kelas_name FROM sv_kelas_siswa sv_a LEFT JOIN sv_master_siswa b ON sv_a.siswa_id=b.id LEFT JOIN sv_master_kelas c ON sv_a.kelas=c.id WHERE sv_a.ta='".$ta['id']."' ORDER BY b.nama_siswa")->result_array();
                $opt_all['']="-Siswa-";
                foreach($siswa as $ss){
                    $opt_all[$ss['siswa_id']]=$ss['nama_siswa']." <b>(".$ss['kelas_name'].")</b>";
                }
                $data['opt_siswa']=$opt_all;
                
		$data['content'] = 'contents/'.$this->utama.'/view';
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
		$data['amount']=str_replace(',','',$data['amount']);
		//print_mz($data);
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
			$data['number']=generatenumbering('payment');
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			addnumbering('payment');
			
			$this->db->where('id',$data['invoice']);
			$this->db->update('sv_invoice',array('last_pay'=>date("Y-m-d H:i:s")));
			
			$total=GetValue('total','sv_invoice',array('id'=>'where/'.$data['invoice']));
	
			$paid=$this->db->query("SELECT SUM(amount) AS total FROM sv_payment WHERE invoice='".$data['invoice']."'")->row_array();
			
			$pembayaran=$paid['total']+$data['amount'];
			
			if($pembayaran==$total || $pembayaran>$total){
				$this->db->where('id',$data['invoice']);
				$this->db->update('sv_invoice',array('status'=>'L'));
			}
			
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect('cash_ledger/form/'.$data['invoice'].'/payment/'.$id);
		
	}
    function loadbill($siswa){
        $billing=$this->db->query("SELECT * FROM sv_bill WHERE siswa_id='$siswa' AND status='unpaid' ORDER BY id ASC ");
        $data['qbill']=$billing->result_array();
        if($billing->num_rows()>0){
            $this->load->view('contents/payment/bill_list',$data);
        }else
        {
         echo "Siswa Tidak Memiliki Tagihan";   
        }
    }
    function item_bill($s){
        
        $data['qbill']=$this->db->query("SELECT * FROM sv_bill WHERE id='$s' ")->row_array();
        $data['qbilld']=$this->db->query("SELECT * FROM sv_bill_detail WHERE bill_id='$s' ")->result_array();
        $data['billprice']=$this->db->query("SELECT SUM(nominal) as price FROM sv_bill_detail WHERE bill_id='$s' ")->row_array();
        $this->load->view('contents/payment/bill_item',$data);
        
    }
    function submit_pay(){
        //print_mz($this->input->post());
        $bill=$this->input->post('id_bill');
        $data['no_payment']=strtotime(date('Y-m-d')).rand(111,999);
        $data['total']=str_replace('.','',$this->input->post('total'));
        $data['bayar']=str_replace('.','',$this->input->post('bayar'));
        $data['kembali']=str_replace('.','',$this->input->post('kembali'));
        $data['metode']=$this->input->post('metode');
        $data['bank']=$this->input->post('bank');
        $data['siswa_id']=$this->input->post('siswa');
        $data['ta']=$this->input->post('ta');
        $data['created_on']=date("Y-m-d H:i:s");
        $data['created_by']='sysadmin';
        
        $data['bill_id']=json_encode($bill);
        
        $this->db->insert('sv_bill_payment',$data);
        $iid=$this->db->insert_id();
        $bill=implode(',',$bill);
        $this->db->query("UPDATE sv_bill SET status='paid' WHERE id IN ($bill)");
        redirect("payment/sumpayment/".$iid);
    }
    function sumpayment($id){
                $data['datapay']=GetAll('bill_payment',array('id'=>'where/'.$id))->row_array();
                $data['content'] = 'contents/'.$this->utama.'/view_sum';
		$this->load->view('layout/main',$data);
    }
    function cetak_kwtiansi($id){
                $data['datapay']=GetAll('bill_payment',array('id'=>'where/'.$id))->row_array();
                $data['content'] = 'contents/'.$this->utama.'/kwitansi';
		$this->load->view( 'contents/'.$this->utama.'/kwitansi',$data);
    }
    function getsiswa(){
        
        $sis=$this->db->query("SELECT * FROM sv_master_siswa WHERE nama_siswa LIKE '".$this->input->get('term')."%'");
        foreach ($sis->result_array() as $siswa){
            $sw[]=$siswa['nama_siswa'];
        }
        echo json_encode($sw);
    }
    function loadsiswa($tingkat,$ta,$ids=null){
            if($ids!=null)$ids=rand(111,9999);
            $siswa=$this->db->query("SELECT sv_a.*,b.nama_siswa FROM sv_kelas_siswa sv_a LEFT JOIN sv_master_siswa b ON sv_a.siswa_id=b.id WHERE sv_a.ta='".$ta."' AND sv_a.kelas='".$tingkat."' ORDER BY b.nama_siswa")->result_array();
            $opt_all['']="-Siswa-";
            foreach($siswa as $ss){
                $opt_all[$ss['siswa_id']]=GetValue('nama_siswa','master_siswa',array('id'=>'where/'.$ss['siswa_id']));
            }
            echo form_dropdown('siswa',$opt_all,(isset($val['siswa']) ? $val['siswa'] : ''),"class='select2' id='siswa$ids' onchange='gantisiswa(this.value)'");
                       echo "<script>
                            $(document).ready(function(e){ 
                                    $('#siswa$ids').css('width','200px').select2({allowClear:true});
                                        $('#select2-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which === 2) $('.select2').addClass('tag-input-style');
					 else $('.select2').removeClass('tag-input-style');
				});
                            });
                            function gantisiswa(vs){
                                $('.inv_item').empty();
                                
                                hitungtotal();
                                $('#billdiv').load('".base_url()."payment/loadbill/'+vs+'/$ids',{},function(e){
                         
                                });
                            }
                        </script>";
        }
	
}
?>