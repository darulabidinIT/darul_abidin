<?php
$opt_item['']='-Item-';
//$lengkap=$this->db->query("SELECT a.*,b.tingkat tingkat,c.jenjang jenjang FROM sv_kelas_siswa a left join sv_master_kelas b on a.kelas=b.id left join sv_master_tingkat c on b.tingkat=c.id WHERE a.id='".$id_data."'")->row_array();
//lastq();
$q="SELECT * FROM sv_ref_item_custom";
$item=$this->db->query($q)->result_array();
//lastq();
foreach($item as $i){
    
$opt_item[$i['id']]=$i['title'];
    
}

?>

<div class="col-md-12">
<div class="input-produk form-group" id="input-produk-<?php echo $a ?>" style="border-bottom:1px #0044cc dashed;margin-bottom:20px;">
                   <div class="form-group">
			   
			   <?php $nm_f="custom[$id][item]";?>
			   <div class="col-sm-2">
                               <?php echo form_dropdown($nm_f,$opt_item,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="select2 form-control" onchange="" id="item-custom-'.$id.'"');
                //lastq();?>
				   </div><div class="col-sm-5">
                                <?php echo form_input('custom['.$id.'][price]','','class="hargasatuan currency" id="item-price-'.$id.'" onchange="hitungtotal()"')?>
			   </div>
		   </div>
		   
    <label style="cursor:pointer;float:right;" onclick="deletebaru_custom(<?php echo $id ?>,<?php echo $val['id'] ?>)">(Hapus)</label>
                </div>
</div>
<script>
                  $(document).ready(function(e){
                           $('#item-custom-<?php echo $id ?>').css('max-width','100%').select2({});
                           $('.date-picker').datepicker({
                               format:'yyyy-mm-dd'
                           });
                           
                            $('.currency').maskMoney({thousands:".",decimal:",",precision:0});
                 });
       
              </script> 