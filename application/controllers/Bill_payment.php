<?php 
class Bill_payment extends CI_Controller {
		
		
		var $utama ='bill_payment';
		var $title ='Daftar Pembayaran';
		function __construct(){
                parent::__construct();
                                
                permissionz();
                $this->load->library('flexigrid');
                $this->load->helper('flexigrid');
		}
                
                
	function index()
	{
		$this->main();
	}
	
	function main()
	{
		//Migrasi 1 Feb 14
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
        function listcol(){
		
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['created_on'] = array('Waktu Transaksi',150,TRUE,'left',2);
            $colModel['ta_'] = array('Tahun Ajaran',150,TRUE,'left',2);
            $colModel['kelas_'] = array('Kelas',150,TRUE,'left',2);
            $colModel['siswa_'] = array('Nama Siswa',150,TRUE,'left',2);
            $colModel['created_by'] = array('Kasir',150,TRUE,'left',2);
            $colModel['total'] = array('Nominal',150,TRUE,'left',2);
			return $colModel;
	}
        
	function get_column(){
	
            $colModel=$this->listcol(); 
        
            $gridParams = array(
                'rp' => 29,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
            $buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');
            $buttons[] = array('cetak invoice','edit','btn');
            //$buttons[] = array('separator');
             $buttons[] = array('rekap pemasukan','edit','btn');
            //$buttons[] = array('delete','delete','btn');
            //$buttons[] = array('separator');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->select("sv_a.*,b.nama_siswa siswa_,d.title kelas_,e.title ta_")->from('sv_bill_payment sv_a');
            $this->db->join('sv_master_siswa b', "sv_a.siswa_id=b.id", 'left');
            $this->db->join('sv_kelas_siswa c', "sv_a.siswa_id=c.siswa_id and sv_a.ta=c.ta", 'left');
            $this->db->join('sv_master_kelas d', "c.kelas = d.id", 'left');
            $this->db->join('sv_master_tahun_ajaran e', "sv_a.ta=e.id", 'left');
            //$this->db->order_by('c.kelas', "asc");
            //$this->db->order_by('b.nama_siswa', "asc");
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from('sv_bill_payment');
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
		$valid_fields = array('id','code','name');

            $this->flexigrid->validate_post('id','DESC',$valid_fields);
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
                                        $record_items[$a][$b]="<a href='".base_url()."master_bank/auth/$row->id'>Menu</a>";
                                        
                                        }elseif($key=='prospek'){
                                        $record_items[$a][$b]="<a href='".base_url()."master_bank/prospek/$row->id'>Prospek Ref</a>";
                                        
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
		function renderdropdown($id=NULL){
				$side=GetAll('sv_menu',array('id_parents'=>'where/'.(int)$id,'sort'=>'order/ASC','is_active'=>"where/Active"));
				$data['menu']=$side->result();
				$this->load->view('layout/listside',$data);
		}
		function rendermessage(){
			error_reporting(0);
				$filter=array();
				$idwebmaster=$this->session->userdata('webmaster_grup');
				if($idwebmaster==4 || $idwebmaster==5 || $idwebmaster==6 ||  $idwebmaster==7 || webmastergrup()==8 || webmastergrup()==10){
				if($idwebmaster==4){$filter['to']='where/Export';}
				if($idwebmaster==5){$filter['to']='where/Import';}
				if($idwebmaster==7){$filter['to']='where/Finance';}
				if($idwebmaster==6 || webmastergrup()==8 || webmastergrup()==10){$filter['to']='where/Trucking';}
				
				}
				$filter['status']='where/N';
				$filter['create_date']='order/DESC';
				
				$data['badge']=GetAll('notif',$filter)->num_rows();
				
				//unset($filter['status']);
				$data['isi']=GetAll('notif',$filter)->result_array();
				
				$this->load->view('layout/message',$data);
		}
		function error404(){
				$this->load->view('layout/notfound');
		}
		function ambilakun(){
				$akun=GetAll('setup_account_mapping',array('id'=>'where/'.$_REQUEST['a']))->row_array();
				echo $akun['acno'].'/'.$akun['acno2'].'/'.$akun['name'].'/'.$akun['name'];
		}
		function marketingclient(){
				$id=$_REQUEST['v'];
				echo GetValue('client','marketing_form_prospect',array('id'=>'where/'.$id));
		}
		function marketingtrucking(){
				$id=$_REQUEST['v'];
				echo GetValue('client','marketing_form_prospect',array('id'=>'where/'.$id)).'/'.GetValue('from','marketing_form_prospect',array('id'=>'where/'.$id)).'/'.GetValue('to','marketing_form_prospect',array('id'=>'where/'.$id)).'/'.GetValue('service_truck','marketing_form_prospect',array('id'=>'where/'.$id)).'/'.GetValue('vehicle_no','marketing_form_prospect',array('id'=>'where/'.$id));
		}
		function vendortruck(){
				$id=$_REQUEST['v'];
				$truck=GetValue('name','master_vendor',array('id'=>'where/'.GetValue('vendor','master_truck',array('id'=>'where/'.$id))));
				echo ($truck=='0' ? 'Punya Sendiri' : $truck);
		}
		function generatequotation(){
				$c=$_REQUEST['c'];
				$s=$_REQUEST['s'];
				$f=$_REQUEST['f'];
				$to=$_REQUEST['to'];
				$ids=$_REQUEST['v'];
				
				
						if($s==1 || $s==2){
							$t=$_REQUEST['t'];
							$lempar=array();
							$item=$this->db->query("SELECT * FROM sv_master_exim")->result_array();
							$i=0;
							//print_mz($item);
							
							foreach($item as $hasil){
								$lempar[$i]['item']=$hasil['id'];
								$lempar[$i]['name']=$hasil['name'];
								$lempar[$i]['client']=$c;
								$lempar[$i]['service']=$t;
								
							if($ids==NULL){
								$q="SELECT * FROM sv_quotation_exim_custom WHERE client='$c' AND item='".$hasil['id']."' AND service='$t' ORDER BY create_date DESC LIMIT 1";
								$cari=$this->db->query($q);
								if($cari->num_rows()==0){
									$q="SELECT * FROM sv_quotation_exim_custom WHERE item='".$hasil['id']."' AND service='$t' ORDER BY create_date DESC LIMIT 1";
									$cari=$this->db->query($q);
									if($cari->num_rows()==0){
										$q="SELECT * FROM sv_quotation_exim_default WHERE client='$c' AND item='".$hasil['id']."' AND service='$t' ORDER BY create_date DESC LIMIT 1";
										$cari=$this->db->query($q);
										if($cari->num_rows()==0){
											$q="SELECT * FROM sv_quotation_exim_default WHERE item='".$hasil['id']."' AND service='$t' ORDER BY create_date DESC LIMIT 1";
											$cari=$this->db->query($q);
										}
									}
								}
							}
								else{
									$q="SELECT * FROM sv_quotation_exim_custom WHERE item='".$hasil['id']."' AND service='$t' AND prospek='$ids' ORDER BY create_date DESC LIMIT 1";
									$cari=$this->db->query($q);
								}
								
								if($cari->num_rows()==0){
									$lempar[$i]['charge_lcl']=0;
									$lempar[$i]['charge_20']=0;
									$lempar[$i]['charge_40']=0;
									$lempar[$i]['charge_45']=0;
									$lempar[$i]['remarks']='';
									$lempar[$i]['message']="Quotation Not Found";
								}
								else{
									$isi=$cari->row_array();
									$lempar[$i]['charge_lcl']=$isi['charge_lcl'];
									$lempar[$i]['charge_20']=$isi['charge_20'];
									$lempar[$i]['charge_40']=$isi['charge_40'];
									$lempar[$i]['charge_45']=$isi['charge_45'];
									$lempar[$i]['remarks']=$isi['remarks'];
									$lempar[$i]['message']="Quotation created on ".$isi['create_date'];
								}
								
							$i++;} 
							$data['val']=$lempar;
							$data['tables']="sv_quotation_exim_custom";
							$this->load->view('contents/quotation/quotation_exim.php',$data);
						}
						
						
						
						else{
							
							if($ids==NULL){
							$q="SELECT * FROM sv_quotation_trucking_custom WHERE client='$c' AND ( location='$f' OR location='$to' ) ORDER BY create_date DESC LIMIT 1";
							$cari=$this->db->query($q);
								if($cari->num_rows()==0){
								$q="SELECT * FROM sv_quotation_trucking_custom WHERE ( location='$f' OR location='$to' ) ORDER BY create_date DESC LIMIT 1";
									$cari=$this->db->query($q);
									if($cari->num_rows()==0){
										$q="SELECT * FROM sv_quotation_trucking_default WHERE client='$c' AND ( location='$f' OR location='$to' ) ORDER BY create_date DESC LIMIT 1";
										$cari=$this->db->query($q);
										if($cari->num_rows()==0){
											$q="SELECT * FROM sv_quotation_trucking_default WHERE ( location='$f' OR location='$to' ) ORDER BY create_date DESC LIMIT 1";
											$cari=$this->db->query($q);
										}
									}
								}
								
							}
							else{
								$q="SELECT * FROM sv_quotation_trucking_custom WHERE prospek='$ids' ORDER BY create_date DESC LIMIT 1";
								$cari=$this->db->query($q);
							}
								
							if($cari->num_rows()==0){
										$data['val']=array();
										$data['message']="Quotation Not Found";
								}
								else{
										$isi=$cari->row_array();
										$data['message']="Quotation created on ".$isi['create_date'];
										$data['val']=$isi;
								}
							
							$data['tables']="sv_quotation_trucking_custom";
							$this->load->view('contents/quotation/quotation_trucking.php',$data);
								
						}
				
		}
        function loadjenjang($ids=null){
            if($ids!=null)$ids=rand(111,9999);
            echo form_dropdown('jenjang',GetOptAll('master_jenjang','-Jenjang-',array()),(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changejenjang(this.value)' id='jenjang$ids'");
            echo"<script>
                    $(document).ready(function(e){ 
                        $('#jenjang$ids').css('width','200px').select2({allowClear:true});
				$('#select2-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which === 2) $('.select2').addClass('tag-input-style');
					 else $('.select2').removeClass('tag-input-style');
				});});
                    function changejenjang(val){
                     $('#tingkatdiv').load('".base_url()."load/loadtingkat/'+val+'/$ids',{},function(e){
                         
                        });
                    }
                    </script>";
        }
        function loadtingkat($jenjang,$ids=null){
            if($ids!=null)$ids=rand(111,9999);
            echo form_dropdown('tingkat',GetOptAll('master_tingkat','-Tingkat-',array('jenjang'=>'where/'.$jenjang)),(isset($val['jenjang']) ? $val['jenjang'] : ''),"class='select2' onchange='changetingkat(this.value)' id='tingkat$ids'");
                       echo "<script>
                            $(document).ready(function(e){ 
                                    $('#tingkat$ids').css('width','200px').select2({allowClear:true});
                                        $('#select2-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which === 2) $('.select2').addClass('tag-input-style');
					 else $('.select2').removeClass('tag-input-style');
				});});
                    function changetingkat(val){
                     $('#kelasdiv').load('".base_url()."load/loadkelas/'+val+'/$ids',{},function(e){
                         
                        });
                    }
                     
                              </script>";
        }
        function loadkelas($tingkat,$ids=null){
            if($ids!=null)$ids=rand(111,9999);
            
            echo form_dropdown('kelas',GetOptAll('master_kelas','-Kelas-',array('tingkat'=>'where/'.$tingkat)),(isset($val['kelas']) ? $val['kelas'] : ''),"class='select2' id='kelas$ids'");
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
        function generate_billing_bulanan($id,$month=true,$mid=null,$yid=null){
            $q="SELECT * FROM sv_kelas_siswa WHERE id='$id'";
            if($mid==null){
                //$mid=date('m');
                $mid = date('m', strtotime('+1 month'));
                $yid = date('Y', strtotime('+1 month'));
            }
            $query=$this->db->query($q)->row_array();
            $periode=GetAll('bill_periode',array('real_month'=>'where/'.(int)$mid))->row_array();
            //$cekspp=$this->db->query("");
            $es=$this->db->query("SELECT * FROM sv_bill WHERE ta='".$query['ta']."' AND periode='".$periode['id']."' AND status='unpaid'");
            if($es->num_rows()==0){
            $bill=array(
                'type'=>'spp',
                'ta'=>$query['ta'],
                'periode'=>$periode['id'],
                'siswa_id'=>$query['siswa_id'],
                'no_bill'=>$periode['id'].$query['siswa_id'],
                'title'=>'SPP '.$periode['title']." ".$yid,
                'generate_date'=>date('Y-m-d'),
                'due_date'=>$yid.'-'.$mid.'-15',
                'created_by'=>'systemgenerated',
                'created_on'=>date("Y-m-d H:i:s")
            );
            $this->db->insert('sv_bill',$bill);
            $iid=$this->db->insert_id();
            
                   $itemspp=json_decode($query['item_spp']);  
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
        }
        else{
            echo "Billing sudah ada";
        }
        }
        function generate_billing($id=null,$month=true,$mid=null,$yid=null){
            $q="SELECT * FROM sv_kelas_siswa WHERE item_spp IS NOT NULL";
            
            $queries=$this->db->query($q)->result_array();
            foreach($queries as $query){
                
            if($mid==null){
                //$mid=date('m');
                $mid = date('m', strtotime('+1 month'));
                $yid = date('Y', strtotime('+1 month'));
            }
            $periodes=$this->db->query("SELECT * FROM sv_bill_periode WHERE id<=6")->result_array();
            foreach($periodes as $periode){
            //$periode=GetAll('bill_periode',array('real_month'=>'where/'.(int)$mid))->row_array();
            //
            //$cekspp=$this->db->query("");
                $mid=$periode['real_month'];
                $yid=2019;
            $es=$this->db->query("SELECT * FROM sv_bill WHERE ta='".$query['ta']."' AND periode='".$periode['id']."' AND siswa_id='".$query['siswa_id']."' AND status='unpaid'");
            if($es->num_rows()==0){
            $bill=array(
                'type'=>'spp',
                'ta'=>$query['ta'],
                'periode'=>$periode['id'],
                'siswa_id'=>$query['siswa_id'],
                'no_bill'=>$periode['id'].$query['siswa_id'],
                'title'=>'SPP '.$periode['title']." ".$yid,
                'generate_date'=>date('Y-m-d'),
                'due_date'=>$yid.'-'.$mid.'-15',
                'created_by'=>'systemgenerated',
                'created_on'=>date("Y-m-d H:i:s")
            );
            $this->db->insert('sv_bill',$bill);
            $iid=$this->db->insert_id();
            
                   $itemspp=json_decode($query['item_spp']);  
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
        }
        else{
            echo "Billing sudah ada";
            }
            }
            
            
        }
        }
        
        function rekap_pemasukan(){
            header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Rekap-Tagihan-SPP".date('YmdHis').".xls");
            $this->load->view('contents/bill_payment/rekap_pemasukan');
        }
}