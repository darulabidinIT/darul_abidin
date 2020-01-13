<?php 

$opt_spp['']='-SPP-';
$lengkap=$this->db->query("SELECT a.id id,a.title nama_kelas,a.tingkat tingkat,b.jenjang jenjang FROM sv_master_kelas a  LEFT JOIN sv_master_tingkat b ON a.tingkat=b.id WHERE a.id='".post('k')."'")->row_array();
$q="SELECT * FROM sv_setup_itempay WHERE ta='".post('t')."' AND (tingkat='all' OR tingkat='".$lengkap['tingkat']."') AND (jenjang='all' OR jenjang='".$lengkap['jenjang']."') AND type=1";
$item=$this->db->query($q)->result_array();
//lastq();
foreach($item as $i){
    
$opt_spp[$i['id']]=$i['title'].' <br> ('.$i['price'].')';
    
}

$opt_ks['']='-KS-';
$q="SELECT * FROM sv_setup_itempay WHERE ta='".post('t')."' AND (tingkat='all' OR tingkat='".$lengkap['tingkat']."') AND (jenjang='all' OR jenjang='".$lengkap['jenjang']."') AND type=2";
$item=$this->db->query($q)->result_array();
//lastq();
foreach($item as $i){
    
$opt_ks[$i['id']]=$i['title'].' <br> ('.$i['price'].')';
    
}

?>

<style>
    table th,td{
        padding:5px;
    }
</style>
<form method="post" action="<?php echo base_url()?>setup_spp_kelas/submit_spp">
    <?php echo form_hidden('nama_kelas',$lengkap['nama_kelas']);?>
    <button type="submit" class="btn btn-danger">Simpan</button>
<table class="" border="1" style='width:100%;'>
          <thead>
              <tr>             
                <th>No.</th>  
                <th>Nama</th>  
                <th>SPP</th>
                <th>KS</th>
                <th>Catering</th>
                <th>Antar Jemput</th>
                <th>Ekskul</th>
                <th>Custom Item 1</th>
                <th>Custom Item 2</th>
                <th>Custom Item 3</th>
                <th>Custom Item 4</th>
                <th>Custom Item 5</th>
              </tr>
          </thead>
          <tbody>
              <?php
              $no=1;
              
              foreach($kelas as $dk){
                  //$siswa=GetAll('master_siswa',array('id'=>'where/'.$dk['siswa_id']))->row_array();
                  $sel_spp='';
                  $sel_ks='';
                  $catering='';
                  $aj='';
                  $ekskul='';
                  $custom1_item='';
                  $custom1_price='';
                  $custom2_item='';
                  $custom2_price='';
                  $custom3_item='';
                  $custom3_price='';
                  $custom4_item='';
                  $custom4_price='';
                  $custom5_item='';
                  $custom5_price='';
                  $item=json_decode($dk['item_spp']);
                  //print_r($item);
                  if(isset($item->item)){
                  foreach($item->item as $it){
                      $type=GetValue('type','sv_setup_itempay',array('id'=>'where/'.$it));
                      if($type==1){
                          $sel_spp=$it;
                      }
                      if($type==2){
                          $sel_ks=$it;
                      }
                  }
                  foreach($item->custom as $cs){
                      if($cs->item==3){
                          $ekskul=uang($cs->price);
                      }
                      if($cs->item==28){
                          $catering=uang($cs->price);
                      }
                      if($cs->item==29){
                          $aj=uang($cs->price);
                      }
                      if($cs->item!=3 && $cs->item!=28 && $cs->item!=29){
                          if($custom1_item==''){
                            $custom1_item=$cs->item;
                            $custom1_price=uang($cs->price);
                          }
                          elseif($custom1_item!='' && $custom2_item==''){
                            $custom2_item=$cs->item;
                            $custom2_price=uang($cs->price);
                          }
                          elseif($custom2_item!='' && $custom3_item==''){
                            $custom3_item=$cs->item;
                            $custom3_price=uang($cs->price);
                          }
                          elseif($custom3_item!='' && $custom4_item==''){
                            $custom4_item=$cs->item;
                            $custom4_price=uang($cs->price);
                          }
                          elseif($custom4_item!='' && $custom5_item==''){
                            $custom5_item=$cs->item;
                            $custom5_price=uang($cs->price);
                          }
                      }
                  }
                  
                  }
                  ?>
              <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $dk['nama_siswa'];?></td>
                <td><?php echo form_dropdown('spp['.$dk['id'].']',$opt_spp,$sel_spp,'class="select2"')?></td>
                <td><?php echo form_dropdown('ks['.$dk['id'].']',$opt_ks,$sel_ks,'class="select2"')?></td>
                <td><?php echo form_input('catering['.$dk['id'].']',$catering,'class="currency form-control"')?></td>
                <td><?php echo form_input('antar_jemput['.$dk['id'].']',$aj,'class="currency form-control"')?></td>
                <td><?php echo form_input('ekskul['.$dk['id'].']',$ekskul,'class="currency form-control"')?></td>
                <td><?php echo form_dropdown('customf1['.$dk['id'].']',GetOptAll('sv_ref_item_custom','-Custom 1-',array(),null,null,null,null,array('id'=>array(1,2,3,28,29))),$custom1_item,'class="select2"'); //lastq();?>
                    <?php echo form_input('custom1['.$dk['id'].']',$custom1_price,'class="currency form-control"')?></td>
                <td><?php echo form_dropdown('customf2['.$dk['id'].']',GetOptAll('sv_ref_item_custom','-Custom 2-',array(),null,null,null,null,array('id'=>array(1,2,3,28,29))),$custom2_item,'class="select2"')?>
                    <?php echo form_input('custom2['.$dk['id'].']',$custom2_price,'class="currency form-control"')?></td>
                <td><?php echo form_dropdown('customf3['.$dk['id'].']',GetOptAll('sv_ref_item_custom','-Custom 3-',array(),null,null,null,null,array('id'=>array(1,2,3,28,29))),$custom3_item,'class="select2"')?>
                    <?php echo form_input('custom3['.$dk['id'].']',$custom3_price,'class="currency form-control"')?></td>
                <td><?php echo form_dropdown('customf4['.$dk['id'].']',GetOptAll('sv_ref_item_custom','-Custom 4-',array(),null,null,null,null,array('id'=>array(1,2,3,28,29))),$custom4_item,'class="select2"')?>
                    <?php echo form_input('custom4['.$dk['id'].']',$custom4_price,'class="currency form-control"')?></td>
                <td><?php echo form_dropdown('customf5['.$dk['id'].']',GetOptAll('sv_ref_item_custom','-Custom 5-',array(),null,null,null,null,array('id'=>array(1,2,3,28,29))),$custom5_item,'class="select2"')?>
                    <?php echo form_input('custom5['.$dk['id'].']',$custom5_price,'class="currency form-control"')?></td>
              </tr>
              <?php $no++; }?>
          </tbody>
      </table>

<script>
    $(document).ready(function(e){
        $('.datatable').DataTable({"pageLength": 50});
        $('.select2').css('width','100%').select2({});
        $('.currency').maskMoney({thousands:".",decimal:",",precision:0});
    })
    </script>
    
</form>