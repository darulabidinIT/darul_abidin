<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>

    
<div class="row">
	<ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="<?php echo base_url($this->utama)?>"><?php echo ucfirst($this->utama)?></a>
        </li>
        <li>
            <a href="#"><?php echo $type?></a>
        </li>
    </ul>
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="<?php echo GetValue('icon','sv_menu',array('filez'=>'where/'.$this->utama))?>"></i> <?php echo $this->title;?></h2>

        
    </div>
    	<div class="box-content">
       <form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit" class="form-horizontal formular" role="form">
		   
		   <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
				
				<?php echo form_hidden('redirect',isset($_GET['redirect']) ? $_GET['redirect'] : '')?>
				<?php echo form_hidden('formid',isset($_GET['formid']) ? $_GET['formid'] : '')?>
			
		   <fieldset class="col-md-6">
                       
                   <div class="form-group">
			   
			   <?php $nm_f="tanggal_daftar";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tanggal Daftar</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : date('Y-m-d')) ?>" class="col-sm-2 date-picker">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="nama_siswa";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama Siswa</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 validate[required]">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="nama_panggilan";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama Panggilan</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="jenis_kelamin";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Jenis Kelamin</label>
				   </div><div class="col-sm-9">
                                       <input type="radio" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="L" class=""> <label>Laki Laki</label>&nbsp;&nbsp;
                                       <input type="radio" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="P" class=""> <label>Perempuan</label>
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="tempat_lahir";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tempat Lahir</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="tanggal_lahir";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tanggal Lahir</label>
				   </div><div class="col-sm-6">
				   <div class="input-group">
                                       <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control date-picker">
                                       <span class="input-group-addon">
					<i class="fa fa-calendar bigger-110"></i>
                                       </span>
                                   </div>
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="agama";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Agama</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f, GetOptAgama(),(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2'");?>
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="suku";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Suku</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="kewarganegaraan";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Kewarganegaraan</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="tinggi_badan";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tinggi Badan</label>
				   </div><div class="col-sm-9">
				   <input type="number" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-3">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="berat_badan";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Berat Badan</label>
				   </div><div class="col-sm-9">
				   <input type="number" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-3">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="golongan_darah";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Golongan Darah</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-2">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="asal_sekolah";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Sekolah Asal</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-5">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="stat_sekolah_asal";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Status Sekolah Asal</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-2">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="periode";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tahun Ajaran</label>
				   </div><div class="col-sm-9">
				   
				   <?php echo form_dropdown($nm_f,$opt_ta,(isset($val[$nm_f]) ? $val[$nm_f] : ambilta()),"class='select2'")?>
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="jenjang";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Jenjang</label>
				   </div><div class="col-sm-9">
				    <?php echo form_dropdown($nm_f,$opt_jenjang,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changejenjang(this.value)'")?>
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="biaya_masuk";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Biaya Masuk</label>
				   </div><div class="col-sm-9" id="divspp">
				   
			   </div>
		   </div>
                   </fieldset>
           <fieldset class="col-md-6">
                    <div class="form-group">
			   
			   <?php $nm_f="nama_ayah";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama Ayah</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12">
			   </div>
		   </div>
                    <div class="form-group">
			   
			   <?php $nm_f="kerja_ayah";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Pekerjaan</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8">
			   </div>
		   </div>
                   <div class="form-group">
			   
			   <?php $nm_f="telp_ayah";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">No. Tlp</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
		   </div>
                   <div class="form-group">
			   
			   <?php $nm_f="nama_bunda";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama Ibu</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12">
			   </div>
		   </div>
                   
                   <div class="form-group">
			   
			   <?php $nm_f="kerja_bunda";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Pekerjaan</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8">
			   </div>
		   </div>
               <div class="form-group">
			   
			   <?php $nm_f="telp_bunda";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">No. Tlp</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
		   </div>
                    <div class="form-group">
			   
			   <?php $nm_f="email_ortu";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Email Orangtua</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
		   </div>
               
                    <div class="form-group">
			   
			   <?php $nm_f="anak_ke";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Anak Ke</label>
				   </div><div class="col-sm-9">
				   <input type="number" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
		   </div>
               
                    <div class="form-group">
			   
			   <?php $nm_f="jumlah_saudara";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Jumlah Saudara</label>
				   </div><div class="col-sm-9">
				   <input type="number" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
		   </div>
               
                    <div class="form-group">
			   
			   <?php $nm_f="nama_saudara";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama Saudara</label>
				   </div><div class="col-sm-9">
                                       <textarea name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" class="col-sm-4" ><?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?></textarea>
			   </div>
		   </div>
                   <div class="form-group">
			   
			   <?php $nm_f="alamat";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Alamat</label>
				   </div><div class="col-sm-9">
                                       <textarea name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" ><?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?></textarea>
			   </div>
		   </div>
                    <div class="form-group">
			   
			   <?php $nm_f="kota";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Kota</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
		   </div>
                    <div class="form-group">
			   
			   <?php $nm_f="kodepos";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Kode Pos</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
		   </div>
                   <div class="form-group">
			   
			   <?php $nm_f="provinsi";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Provinsi</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6">
			   </div>
		   </div>
                   <div class="form-group">
			   
			   <?php $nm_f="negara";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Negara</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
		   </div>
                   <div class="form-group">
			   
			   <?php $nm_f="jarak_rumah_sekolah";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Jarak Rumah ke Sekolah</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-2">
			   </div>
		   </div>
               
                   <div class="form-group">
			   <?php $nm_f="catatan";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Catatan</label>
				   </div><div class="col-sm-9">
                                       <textarea name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>"><?php echo (isset($val[$nm_f]) ? $val[$nm_f] : '') ?></textarea>
			   </div>
		   </div>
           </fieldset>
           <div class="col-md-12">
             <div class="form-group">
                <button type="submit" class="btn pull-right">Submit</button>
             </div>
            </div>
			 </form>
    	</div>
    </div>
    </div>
</div>
<script>
	$('#target').mask('9.99');
	$('#comission').mask('9.99');
        
                    function changejenjang(val){
                     $('#divspp').load('<?php echo base_url()?>master_siswa/load_spp/'+val,{},function(e){
                         
                        });
                    }
</script>