<?php 
class Billing extends CI_Controller {
		
		
		function __construct(){
				parent::__construct();
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
}