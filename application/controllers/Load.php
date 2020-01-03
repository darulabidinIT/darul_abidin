<?php 
class Load extends CI_Controller {
		
		
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
            
            echo form_dropdown('kelas',GetOptAll('master_kelas','-Kelas-',array('tingkat'=>'where/'.$tingkat)),(isset($val['kelas']) ? $val['kelas'] : ''),"class='select2' onchange='changekelas(this.value)' id='kelas$ids'");
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
                             function changekelas(vs){
                                var ta=$('#tahun_ajaran').val();
                                $('#siswadiv').load('".base_url()."load/loadsiswa/'+vs+'/'+ta+'/$ids',{},function(e){
                         
                                });
                            }
                        </script>";
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
        function loadspp($tingkat,$ids=null){
            
            if($ids!=null)$ids=rand(111,9999);
            
$opt_item['']='-Item-';
//$lengkap=$this->db->query("SELECT * FROM sv_setup_monthly WHERE a.id='".$id_data."'")->row_array();
//lastq();
$q="SELECT * FROM sv_setup_monthly WHERE tingkat='".GetValue('tingkat','master_kelas',array('id'=>'where/'.$tingkat))."'";
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
                                $('#sppitem').load('".base_url()."load/item_spp/'+val);
                            }
                        </script>";
        }
        function item_spp($v){
            $g=GetAll('sv_setup_monthly',array('id'=>'where/'.$v))->row_array();
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
            echo "<hr>";
            echo "TOTAL : ".uang($total);
        }
}