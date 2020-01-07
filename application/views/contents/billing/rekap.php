<?php ?>


<center><p>TAGIHAN BULAN <?php echo strtoupper(GetBulanIndo(date('F')))." ".date('Y') ?> </p></center>
<center><p>SMPIT DARUL ABIDIN</p></center>
<div class="tg-wrap">
    <?php foreach($getkelas as $gk){
        $getsiswa=$this->db->query("SELECT a.*,b.nama_siswa nama_siswa,b.nisn nisn FROM sv_kelas_siswa a LEFT JOIN sv_master_siswa b ON a.siswa_id=b.id WHERE a.ta='".ambilta()."' AND a.kelas='".$gk['id']."' ORDER BY nama_siswa ASC LIMIT 1;")->result_array();
        ?>
    <b>Kelas : <?php echo $gk['title'] ?></b>
    <table border="1" >
    <tr>
      <th rowspan="2">No<br></th>
      <th rowspan="2">NIS</th>
      <th rowspan="2">Nama Siswa</th>
      <th rowspan="2">Kelas</th>
      <th>Bulan</th>
      <th>Periode </th>
      <th>Bulan</th>
      <th>Jumlah</th>
      <th rowspan="2">SPP</th>
      <th rowspan="2">KS</th>
      <th rowspan="2">Catering</th>
      <th>Antar</th>
      <th rowspan="2">Lain*</th>
      <th rowspan="2">PMB</th>
      <th rowspan="2">Total</th>
    </tr>
    <tr>
      <td align="center">Terakhir</td>
      <td align="center">Tagihan</td>
      <td align="center">Tagihan</td>
      <td align="center">Tagihan</td>
      <td align="center">Jemput</td>
    </tr>
    <?php
    $a=1;
    foreach($getsiswa as $gs){
        $bln_terakhir=$this->db->query("SELECT periode,ta FROM sv_bill WHERE status='paid' AND ta=".ambilta()." AND siswa_id=".$gs['siswa_id']." ORDER BY periode DESC LIMIT 1")->row_array();
        $bln_t=ambil_bulan_tahun_ajaran($bln_terakhir['periode'],$bln_terakhir['ta']);
        if($bln_t=="Januari"){
            $bln_t="";
        }
        //lastq();
        //$bln_tagihan=$this->db->query("SELECT periode,ta FROM sv_bill WHERE status='unpaid' AND ta=".ambilta()." AND siswa_id=".$gs['siswa_id']." ORDER BY periode DESC LIMIT 1")->row_array();
        
        $all_tagihan=$this->db->query("SELECT periode,ta FROM sv_bill WHERE status='unpaid' AND ta=".ambilta()." AND siswa_id=".$gs['siswa_id']." ORDER BY periode ASC")->result_array();
        $jml_tagihan=count($all_tagihan);
        
        //$all_tagihan=$this->db->query("SELECT SUM(tota FROM sv_bill WHERE status='unpaid' AND ta=".ambilta()." AND siswa_id=".$gs['siswa_id']." ORDER BY periode ASC")->result_array();
        
        if($jml_tagihan>1){
            $bln_tagihans=ambil_bulan_tahun_ajaran($all_tagihan[0]['periode'],$all_tagihan[0]['ta'])." - ".ambil_bulan_tahun_ajaran($all_tagihan[$jml_tagihan-1]['periode'],$all_tagihan[$jml_tagihan-1]['ta']);
        }
        else{
            $bln_tagihans=ambil_bulan_tahun_ajaran($all_tagihan[0]['periode'],$all_tagihan[0]['ta']);
        }
        $jml_tagihan=$this->db->query("SELECT count(id) as jml FROM sv_bill WHERE status='unpaid' AND ta=".ambilta()." AND siswa_id=".$gs['siswa_id']."")->row_array();
        //lastq();
        foreach($all_tagihan as $at){
            $in[]=$at['periode'];
        }
        $imp=implode(',',$in);
        $qq="SELECT SUM(nominal) as total,type FROM sv_bill_detail WHERE bill_id IN($imp) GROUP BY type";
        $qspp=$this->db->query($qq)->result_array();
        foreach($qspp as $sp){
            $spp_[$sp['type']]=$sp['total'];
        }
        
        
        $qql="SELECT SUM(nominal) as total,type FROM sv_bill_detail WHERE bill_id IN($imp) AND `type` NOT IN(1,2,28,29,8)";
        $qspp=$this->db->query($qql)->row_array();
        
        $qtotal=$this->db->query("SELECT SUM(nominal) as total FROM sv_bill_detail WHERE bill_id IN($imp)")->row_array();
        ?>
    <tr>
        <td width="5%" align="center"><?php echo $a?></td>
        <td width="5%"><?php echo $gs['nisn']?></td>
        <td width="15%"><?php echo $gs['nama_siswa']?></td>
        <td width="15%" align="center"><?php echo $gk['title'] ?></td>
        <td width="7%" align="center"><?php echo $bln_t?></td>
        <td width="7%" align="center"><?php echo GetValue('title','master_tahun_ajaran',array('id'=>'where/'.$gs['ta']))?></td>
        <td width="7%" align="center"><?php echo $bln_tagihans?></td>
        <td width="7%" align="center"><?php echo $jml_tagihan['jml'] ?></td>
        <td width="7%" align="center"><?php echo uang($spp_[1])?></td>
        <td width="6%" align="center"><?php echo uang($spp_[2])?></td>
        <td width="6%" align="center"><?php echo uang($spp_[28])?></td>
        <td width="6%" align="center"><?php echo uang($spp_[29])?></td>
        <td width="6%" align="center"><?php echo uang($qspp['total'])?></td>
        <td width="6%" align="center"><?php echo uang($spp_[8])?></td>
        <td width="7%" align="center"><?php echo uang($qtotal['total'])?></td>
    </tr>
    <?php $a++; }?>
  </table>
    <br>
    <?php }?>
</div>