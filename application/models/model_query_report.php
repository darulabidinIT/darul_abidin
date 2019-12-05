<?php

class Model_query_report extends CI_Model{
	
	
	function pricelist(){
		$q="SELECT kode_barang,nama FROM tb_inventory ";
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode("','",$kat);
			$q.="WHERE kode_group IN ('$kat')";
			} 
		return $this->db->query($q);	
	}
	function koreksi_stok(){
		
		$q="SELECT * FROM tb_inventory_koreksi WHERE (tgl>='".$this->input->post('start_date')."  00:00:00' AND tgl<='".$this->input->post('end_date')." 23:59:59') ";
		return $this->db->query($q);	
	}
	function pembelian(){
		$q="SELECT id_supplier,SUM(total) as total FROM tb_pembelian WHERE (tanggal>='".$this->input->post('start_date')." 00:00:00' AND tanggal<='".$this->input->post('end_date')." 23:59:59') ";
		$kat=$this->input->post('kasir');
		$sup=$this->input->post('supplier');
		if(!empty($kat)){
			$kat=implode("','",$kat);
			$q.="AND kasir IN ('$kat') ";
			}
		if(!empty($sup)){
			$sup=implode("','",$sup);
			$q.="AND id_supplier IN ('$sup') ";
			}  
			$q.="GROUP BY id_supplier";
		return $this->db->query($q);	
	}
	function pembelian_detail(){
		$q="SELECT tb_pembelian.tanggal as tanggal,
		tb_pembelian_detail.id_pembelian as id_beli,
		tb_pembelian_detail.kode_barang as kode_barang,
		tb_pembelian.id_supplier as supplier,
		tb_pembelian_detail.jumlah as jumlah,
		tb_pembelian_detail.satuan as satuan,
		tb_pembelian_detail.total as total FROM tb_pembelian_detail LEFT JOIN tb_pembelian ON tb_pembelian.id_pembelian=tb_pembelian_detail.id_pembelian WHERE (tanggal>='".$this->input->post('start_date')." 00:00:00' AND tanggal<='".$this->input->post('end_date')." 23:59:59') ";
		$kat=$this->input->post('kasir');
		$sup=$this->input->post('supplier');
		if(!empty($kat)){
			$kat=implode("','",$kat);
			$q.="AND tb_pembelian.kasir IN ('$kat') ";
			}
		if(!empty($sup)){
			$sup=implode("','",$sup);
			$q.="AND tb_pembelian.id_supplier IN ('$sup') ";
			}  
		return $this->db->query($q);	
	}
	function stok(){
		$q="SELECT kode_barang,nama,satuan,jumlah FROM tb_inventory ";
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode("','",$kat);
			$q.="WHERE kode_group IN ('$kat')";
			}  
		return $this->db->query($q);	
	}
	function barang_limit(){
		$q="SELECT kode_barang,nama,min_qty,jumlah,satuan FROM tb_inventory WHERE (jumlah<=min_qty OR jumlah BETWEEN min_qty AND min_qty+10) ";
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode("','",$kat);
			$q.="AND kode_group IN ('$kat') ";
			}$q.="ORDER BY jumlah ASC";
		return $this->db->query($q);	
	}
	function stok_opname(){
		$q="SELECT kode_barang,nama,jumlah FROM tb_inventory ";
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode("','",$kat);
			$q.="WHERE kode_group IN ('$kat')";
			} 
		return $this->db->query($q);	
	}
	function kas(){
		$q="SELECT * FROM tb_transaksi_kas WHERE (tgl>='".$this->input->post('start_date')." 00:00:00' AND tgl<='".$this->input->post('end_date')." 23:59:59') ";
		$kat=$this->input->post('kas');
		if(!empty($kat)){
			$kat=implode("','",$kat);
			$q.="AND kas IN ('$kat')";
			} 
		return $this->db->query($q);	
	}
	function penjualan(){
		$q="SELECT * FROM tb_penjualan WHERE (tanggal>='".$this->input->post('start_date')." 00:00:00' AND tanggal<='".$this->input->post('end_date')." 23:59:59') ";
		$karyawan=$this->input->post('karyawan');
		$kasir=$this->input->post('kasir');
		$jenis=$this->input->post('jenisbayar');
		if(!empty($kasir)){
			$kasir=implode("','",$kasir);
			$q.="AND kasir IN ('$kasir') ";
			}
		if(!empty($karyawan)){
			$i=0;
			foreach($karyawan as $isikas){
			$karyawan[$i]=GetValue('nik','tb_karyawan',array('id'=>'where/'.$isikas));
			$i++;	
			}
			
			$karyawan=implode("','",$karyawan);
			$q.="AND id_karyawan IN ('$karyawan') ";
			}
		if(!empty($jenis)){
			$jenis=implode("','",$jenis);
			$q.="AND tipe_pembayaran IN ('$jenis') ";
			}	
		return $this->db->query($q);	
	}
	function labarugi(){
		$q="SELECT * FROM tb_penjualan LEFT JOIN tb_penjualan_detail ON tb_penjualan.id_penjualan=tb_penjualan_detail.id_penjualan WHERE (tb_penjualan.tanggal>='".$this->input->post('start_date')." 00:00:00' AND tb_penjualan.tanggal<='".$this->input->post('end_date')." 23:59:59') ";
		$karyawan=$this->input->post('karyawan');
		$kasir=$this->input->post('kasir');
		$jenis=$this->input->post('jenisbayar');
		if(!empty($kasir)){
			$kasir=implode("','",$kasir);
			$q.="AND tb_penjualan.kasir IN ('$kasir') ";
			}
		if(!empty($karyawan)){
			$i=0;
			foreach($karyawan as $isikas){
			$karyawan[$i]=GetValue('nik','tb_karyawan',array('id'=>'where/'.$isikas));
			$i++;	
			}
			
			$karyawan=implode("','",$karyawan);
			$q.="AND tb_penjualan.id_karyawan IN ('$karyawan') ";
			}
		if(!empty($jenis)){
			$jenis=implode("','",$jenis);
			$q.="AND tb_penjualan.tipe_pembayaran IN ('$jenis') ";
			}	
		return $this->db->query($q);	
	}
	function penjualan_barang(){
		$q="SELECT kode_barang,nama,kode_group FROM tb_inventory ";
		$kat=$this->input->post('kategori');
		if(!empty($kat)){
			$kat=implode("','",$kat);
			$q.="WHERE kode_group IN ('$kat')";
			} 
		return $this->db->query($q);	
	}
}