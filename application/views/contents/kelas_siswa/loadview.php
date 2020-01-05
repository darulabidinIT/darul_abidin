<?php foreach($jenjang as $j){?>
<div class="row" style="margin-bottom:2%;">
<div class="col-md-12"><button data-toggle="collapse" data-target="#jenjang-<?php echo $j['id']?>" class="btn-info btn"><?php echo $j['title']?></button>

<fieldset style="border:1px solid #D4011B; padding-bottom:10px; border-radius:5px;" class="col-md-12 collapse <?php if(isset($_GET['search'])) echo "in"?>" id="jenjang-<?php echo $j['id']?>">
	
    <?php
    
            if(empty($this->input->post('t')))$filtertingkat=array('jenjang'=>'where/'.$j['id']);
            else $filtertingkat=array('jenjang'=>'where/'.$j['id'],'id'=>'where/'.$this->input->post('t'));
            $tingkat=GetAll('master_tingkat',$filtertingkat)->result_array();
            //lastq();
    
    foreach($tingkat as $t){
        ?>
    <div class="row" style="margin-bottom:1%; margin-top:1%;">
    <div class="col-md-12"><button data-toggle="collapse" data-target="#tingkat-<?php echo $t['id']?>" class="btn-info btn">Tingkat <?php echo $t['title']?></button>
        <fieldset style="border:1px solid #D4011B; padding-bottom:10px; border-radius:5px;" class="col-md-12 collapse <?php if(isset($_GET['search'])) echo "in"?>" id="tingkat-<?php echo $t['id']?>">
        
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                
      <?php
      if(empty($this->input->post('k')))$filterkelas=array('tingkat'=>'where/'.$t['id']);
            else $filterkelas=array('tingkat'=>'where/'.$t['id'],'id'=>'where/'.$this->input->post('k'));
            $kelas=GetAll('master_kelas',$filterkelas)->result_array();
    
    foreach($kelas as $k){
      ?>
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#<?php echo $k['id']?>" role="tab" aria-controls="home" aria-selected="true"><?php echo $k['title']?></a>
  </li>
    <?php }?>
  
</ul>
<div class="tab-content" id="myTabContent">
   <?php foreach($kelas as $k){
       $data_kelas=$this->db->query("SELECT sv_a.*,b.nama_siswa FROM sv_kelas_siswa sv_a LEFT JOIN sv_master_siswa b ON sv_a.siswa_id=b.id WHERE sv_a.ta='".$this->input->post('ta')."' AND sv_a.kelas='".$k['id']."' ORDER BY b.nama_siswa");
       ?> 
  <div class="tab-pane fade" id="<?php echo $k['id']?>" role="tabpanel" aria-labelledby="home-tab">
      <table class="datatable">
          <thead>
              <tr>             
                <th>No.</th>  
                <th>No Sisda</th>
                <th>Nama</th>  
                <th>Nama Bunda</th>
                <th>Item SPP</th>
              </tr>
          </thead>
          <tbody>
              <?php
              $no=1;
              foreach($data_kelas->result_array() as $dk){
                  $siswa=GetAll('master_siswa',array('id'=>'where/'.$dk['siswa_id']))->row_array();
                  ?>
              <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $siswa['no_sisda'];?></td>
                <td><?php echo $siswa['nama_siswa'];?></td>
                <td><?php echo $siswa['nama_bunda'];?></td>
                <td><a class="btn btn-info" href="<?php echo base_url()?>kelas_siswa/form_item/<?php echo $dk['id']?>">Set SPP Item</a> <a class="btn btn-info" href="<?php echo base_url()?>kelas_siswa/form_move/<?php echo $dk['id']?>">Pindah Kelas</a></td>
              </tr>
              <?php $no++; }?>
          </tbody>
      </table>
  </div>
   <?php }?>
</div>
        </fieldset>
    </div>
    </div>
        <?php 
    }?>
    
    
  

</fieldset>
</div>
</div>
<?php }?>
<script>
    $(document).ready(function(e){
        
				$('.datatable').DataTable({"pageLength": 50});
    })
    </script>