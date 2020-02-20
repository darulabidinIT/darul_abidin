<?php 
class Billing extends CI_Controller {
		
		
		var $utama ='billing';
		var $title ='Billing';
		function __construct(){
				parent::__construct();
                                $this->load->library('flexigrid');
                                $this->load->helper('flexigrid');
		}
                
                
	function index()
	{
		$this->main();
	}
	
	function main()
	{
		//Set Global
		//$data = GetHeaderFooter();
		$data['content'] = 'contents/'.$this->utama.'/view';
                
                $siswa=(!get('siswa')?0:get('siswa'));
                $ta=(!get('ta')?0:get('ta'));
                $kelas=(!get('kelas')?0:get('kelas'));
                $tipe=(!get('tipe')?0:get('tipe'));
		
		$data['js_grid']=$this->get_column($siswa,$ta,$kelas,$tipe);
		//$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
        function listcol(){
		
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['title'] = array('Bill',300,TRUE,'left',2);
            $colModel['ta_'] = array('Tahun Ajaran',100,TRUE,'left',2);
            $colModel['siswa_'] = array('Siswa',150,TRUE,'left',2);
            $colModel['kelas_'] = array('Kelas',150,TRUE,'left',2);
            $colModel['status'] = array('Status',150,TRUE,'left',2);
			return $colModel;
	}
        
	function get_column($siswa,$ta,$kelas,$tipe){
	
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
            $buttons[] = array('buat spp manual','add','btn');
            $buttons[] = array('buat tagihan custom','add','btn');
            $buttons[] = array('separator');
            $buttons[] = array('cetak tagihan','edit','btn');
            $buttons[] = array('separator');
            $buttons[] = array('rekap tagihan pg','edit','btn');
            $buttons[] = array('rekap tagihan tk','edit','btn');
            $buttons[] = array('rekap tagihan sd','edit','btn');
            $buttons[] = array('rekap tagihan smp','edit','btn');
            //$buttons[] = array('separator');
             //$buttons[] = array('edit','edit','btn');
            //$buttons[] = array('delete','delete','btn');
            //$buttons[] = array('separator');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record/$siswa/$ta/$kelas/$tipe"),$colModel,'sv_a.id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid($siswa,$ta,$kelas,$tipe)
        {

            //Build contents query
            $this->db->select("sv_a.*,b.nama_siswa siswa_,d.title kelas_,e.title ta_")->from('sv_bill sv_a');
            $this->db->join('sv_master_siswa b', "sv_a.siswa_id=b.id", 'left');
            $this->db->join('sv_kelas_siswa c', "sv_a.siswa_id=c.siswa_id and sv_a.ta=c.ta", 'left');
            $this->db->join('sv_master_kelas d', "c.kelas = d.id", 'left');
            $this->db->join('sv_master_tahun_ajaran e', "sv_a.ta = e.id", 'left');
            $this->db->order_by('c.kelas', "asc");
            $this->db->order_by('b.nama_siswa', "asc");
            
            if($siswa!=0)$this->db->where('sv_a.siswa',$siswa);
            if($ta!=0)$this->db->where('sv_a.ta',$ta);
            if($kelas!=0)$this->db->where('c.kelas',$kelas);
            if($tipe!=0)$this->db->where('sv_a.tipe',$tipe);
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            //$this->db->select("count(id) as record_count")->from('sv_bill');
            $this->db->select("count(sv_a.id) as record_count")->from('sv_bill sv_a');
            $this->db->join('sv_master_siswa b', "sv_a.siswa_id=b.id", 'left');
            $this->db->join('sv_kelas_siswa c', "sv_a.siswa_id=c.siswa_id and sv_a.ta=c.ta", 'left');
            $this->db->join('sv_master_kelas d', "c.kelas = d.id", 'left');
            $this->db->join('sv_master_tahun_ajaran e', "sv_a.ta = e.id", 'left');
            $this->db->order_by('c.kelas', "asc");
            $this->db->order_by('b.nama_siswa', "asc");
            
            if($siswa!=0)$this->db->where('sv_a.siswa',$siswa);
            if($ta!=0)$this->db->where('sv_a.ta',$ta);
            if($kelas!=0)$this->db->where('c.kelas',$kelas);
            if($tipe!=0)$this->db->where('sv_a.tipe',$tipe);
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record($siswa,$ta,$kelas,$tipe){
		
            $colModel=$this->listcol(); 
		$valid_fields = array('id','code','name');

            $this->flexigrid->validate_post('sv_a.id','DESC',$valid_fields);
            $records = $this->get_flexigrid($siswa,$ta,$kelas,$tipe);

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
        function cetak_tagihan($id){
                $data['datapay']=GetAll('sv_bill',array('id'=>'where/'.$id))->row_array();
                $data['content'] = 'contents/'.$this->utama.'/tagihan';
		$this->load->view( 'contents/'.$this->utama.'/tagihan',$data);
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
                'no_bill'=>gen_num('spp',GetValue('no_sisda','master_siswa',array('id'=>'where/'.$query['siswa_id']))).'/'.$periode['id'],
                'title'=>'SPP '.GetValue('nama_siswa','master_siswa',array('id'=>'where/'.$query['siswa_id'])).' '.$periode['title']." ".$yid,
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
            set_time_limit(0);
            ini_set("memory_limit",-1);
            //print_mz($this->input->post());
            $mess="";
            $q="SELECT * FROM sv_kelas_siswa WHERE item_spp IS NOT NULL ";
            
            if(post('ta') && post('siswa_id')){ $q.="AND ta='".post('ta')."' AND siswa_id='".post('siswa_id')."'";}
            else{$q.="AND ta='".ambilta()."'";}
            $ta=(post('ta')?post('ta'):ambilta());
            
            $queries=$this->db->query($q)->result_array();
            //lastq();
            if($mid==null){
                //$mid=date('m');
                $mid = date('m', strtotime('+1 month'));
                $yid = date('Y', strtotime('+1 month'));
            }
            foreach($queries as $query){
                $p="SELECT * FROM sv_bill_periode ";
                if(post('periode')){
                    $pselect=implode(',',post('periode'));
                }
                else{
                    $pselect=GetValue('id','sv_bill_periode',array('real_month'=>'where/'.$mid));
                }
                //$pselect="1,2,3,4,5,6,7";
                $p.="WHERE id IN ($pselect) ";
            
            $periodes=$this->db->query($p)->result_array();
            //lastq();
            foreach($periodes as $periode){
            //$periode=GetAll('bill_periode',array('real_month'=>'where/'.(int)$mid))->row_array();
            //
            //$cekspp=$this->db->query("");
                
                $sis_detail=GetAll('master_siswa',array('id'=>'where/'.$query['siswa_id']))->row_array();
                $mid=$periode['real_month'];
                if($periode['id']>=1 && $periode['id']<=6){
                    $yid=substr(GetValue('start','master_tahun_ajaran',array('id'=>'where/'.$ta)),0,4);
                
                }else{
                    
                    $yid=substr(GetValue('end','master_tahun_ajaran',array('id'=>'where/'.$ta)),0,4);
                }
            $es=$this->db->query("SELECT * FROM sv_bill WHERE ta='".$query['ta']."' AND periode='".$periode['id']."' AND siswa_id='".$query['siswa_id']."' AND (status='unpaid' OR status='paid')");
            if($es->num_rows()==0){
            $bill=array(
                'type'=>'spp',
                'ta'=>$query['ta'],
                'periode'=>$periode['id'],
                'siswa_id'=>$query['siswa_id'],
                'no_bill'=>gen_num('spp',$sis_detail['no_sisda']).'/'.$periode['id'],
                'title'=>'SPP '.$sis_detail['nama_siswa'].' '.$periode['title']." ".$yid,
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
                $mess.="SPP ".$sis_detail['nama_siswa']." ".$periode['title']."-".$yid." Sukses Dibuat <br>";
                
        }
            else{
                $mess.="SPP ".$sis_detail['nama_siswa']." ".$periode['title']."-".$yid." Sudah Ada Dibuat <br>";       
            }
        }
        }
            $this->session->set_flashdata('message',$mess);
            redirect('billing');
        }
        function rekap_bulan($jenjang){
                header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Rekap-Tagihan-SPP".date('YmdHis').".xls");
            $getsmp=GetAll('master_tingkat',array('jenjang'=>'where/'.$jenjang))->result_array();
            foreach($getsmp as $smp){
                $tingkat[]=$smp['id'];
            }
            $imp_tingkat=implode(',',$tingkat);
            $data['getkelas']=$this->db->query("SELECT * FROM sv_master_kelas WHERE tingkat IN($imp_tingkat)")->result_array();
            
            
            $this->load->view('contents/billing/rekap',$data);
        }
        function form_manual($id=null){
		
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
                $data['opt_periode']=GetOptAll('sv_bill_periode','',array());
                //array_push($data['opt_leader'],$def);
		$data['content'] = 'contents/'.$this->utama.'/edit_manual';
                
                $siswa=$this->db->query("SELECT sv_a.*,b.nama_siswa,c.title kelas_name FROM sv_kelas_siswa sv_a LEFT JOIN sv_master_siswa b ON sv_a.siswa_id=b.id LEFT JOIN sv_master_kelas c ON sv_a.kelas=c.id WHERE sv_a.ta='".ambilta()."' ORDER BY b.nama_siswa")->result_array();
                $opt_all['']="-Siswa-";
                foreach($siswa as $ss){
                    $opt_all[$ss['siswa_id']]=$ss['nama_siswa']." <b>(".$ss['kelas_name'].")</b>";
                }
                $data['opt_siswa']=$opt_all;
                
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
        function form_custom($id=null){
		
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
                
                $siswa=$this->db->query("SELECT sv_a.*,b.nama_siswa,c.title kelas_name FROM sv_kelas_siswa sv_a LEFT JOIN sv_master_siswa b ON sv_a.siswa_id=b.id LEFT JOIN sv_master_kelas c ON sv_a.kelas=c.id WHERE sv_a.ta='".ambilta()."' ORDER BY b.nama_siswa")->result_array();
                $opt_all['']="-Siswa-";
                foreach($siswa as $ss){
                    $opt_all[$ss['siswa_id']]=$ss['nama_siswa']." <b>(".$ss['kelas_name'].")</b>";
                }
                $data['opt_siswa']=$opt_all;
                
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
        function custom_submit(){
            $kelas_tmp=kelas_pmb(post('jenjang'));
                        
                        $q="SELECT * FROM sv_setup_pendaftaran WHERE id='".post('item_spp')."'";
                        if($mid==null){
                            //$mid=date('m');
                            $mid = date('m', strtotime('+1 month'));
                            $yid = date('Y', strtotime('+1 month'));
                        }
                        //$periode=GetAll('bill_periode',array('real_month'=>'where/'.(int)$mid))->row_array();
                        //$cekspp=$this->db->query("");
                        $siswa=GetAll('master_siswa',array('id'=>'where/'.post('siswa_id')))->row_array();
                        $bill=array(
                            'type'=>post('type'),
                            'ta'=>post('ta'),
                            'periode'=>post('ta'),
                            'siswa_id'=>post('siswa_id'),
                            'no_bill'=>gen_num('cst',$siswa['no_sisda']),
                            'title'=>post('title'),
                            'generate_date'=>post('generate_date'),
                            'due_date'=>post('due_date'),
                            'created_by'=>$this->session->userdata('webmaster_id'),
                            'created_on'=>date("Y-m-d H:i:s")
                        );
            $this->db->insert('sv_bill',$bill);
            $iid=$this->db->insert_id();
            
                   //$query=$this->db->query($q)->row_array();
                   //lastq();
            if($this->input->post('item')){
                    $item['item']=$this->input->post('item');}
                else{
                    $item['item']=array();
                }
                if($this->input->post('custom')){ 
                    $cs=post('custom');
                    $a=1;
                    foreach($cs as $ct ){
                        $custom[$a]['item']=$ct['item'];
                        $custom[$a]['price']=str_replace('.','',$ct['price']);
                        $a++;
                    }
                    $item['custom']=$custom;
                
                }
                else{
                    $item['custom']=array();
                }
                $items=json_encode($item);
                   $itemspp=json_decode($items);  
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
                $this->session->set_flashdata('message','Billing Custom Sukses Dibuat');
                redirect('billing');
        }
        function item($id){
            $data['id']=$id;
            $data['id_data']=$this->input->post('id');
            $this->load->view('contents/billing/item',$data);
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
            $this->load->view('contents/billing/item_custom',$data);
        }
        function load_siswa(){
            
            
                 $siswa=$this->db->query("SELECT sv_a.*,b.nama_siswa,c.title kelas_name FROM sv_kelas_siswa sv_a LEFT JOIN sv_master_siswa b ON sv_a.siswa_id=b.id LEFT JOIN sv_master_kelas c ON sv_a.kelas=c.id WHERE sv_a.ta='".post('t')."' ORDER BY b.nama_siswa")->result_array();
                $opt_all['']="-Siswa-";
                foreach($siswa as $ss){
                    $opt_all[$ss['siswa_id']]=$ss['nama_siswa']." <b>(".$ss['kelas_name'].")</b>";
                }
                $opt_siswa=$opt_all;
                echo form_dropdown('siswa_id',$opt_siswa,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select3' id='siswa_id'");
                
                echo "<script>$(document).ready(function(e){
                        $('.select3').css('width','400px').select2({});
                      })</script>";
        }
}