<table class="datatable">
          <thead>
              <tr>             
                <th>No.</th>  
                <th>Nama</th>  
                <th>Item SPP</th>
              </tr>
          </thead>
          <tbody>
              <?php
              $no=1;
              foreach($kelas as $dk){
                  $siswa=GetAll('master_siswa',array('id'=>'where/'.$dk['siswa_id']))->row_array();
                  ?>
              <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $siswa['nama_siswa'];?></td>
                <td><a class="btn btn-info" href="<?php echo base_url()?>kelas_siswa/form_item/<?php echo $dk['id']?>">Set SPP Item</a> <a class="btn btn-info" href="<?php echo base_url()?>kelas_siswa/form_move/<?php echo $dk['id']?>">Pindah Kelas</a></td>
              </tr>
              <?php $no++; }?>
          </tbody>
      </table>