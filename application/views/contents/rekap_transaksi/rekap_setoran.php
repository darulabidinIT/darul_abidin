<div class="tg-wrap">
    <table>
        <tr>
            <th colspan="5" width="100%">Laporan Setoran Administrasi Siswa SIT Darul Abidin</th>
        </tr>
        <tr>
            <th colspan="5">(Dalam Rupiah)</th>
        </tr>
        <tr>
            <td width="50%">Hari / Tanggal:</td>
            <td width="50%"><?php echo hariindo() .' / '. tglindo(date('Y-m-d'));?></td>
        </tr>
    </table>
    <table border="1">
        <tr>
        <th colspan="5">I. SETORAN KE YAYASAN</th>
        </tr>
        <tr>
        <td colspan="5">A. TK IT</td>
        </tr>
        <tr>
        <td width="5%">No.</td>
        <td width="35%">Keterangan</td>
        <td width="20%">Tunai</td>
        <td width="20%">Transfer</td>
        <td width="20%">Total</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>SPP</td>
                <td><?php echo uang($tk_spp_tunai['total']) ?></td>
                <td><?php echo uang($tk_spp_transfer['total']) ?></td>
                <?php $tk_total_spp=$tk_spp_tunai['total']+$tk_spp_transfer['total'];?>
                <td><?php echo uang($tk_total_spp) ?></td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Daftar Ulang</td>
                <td><?php echo uang($tk_du_tunai['total']) ?></td>
                <td><?php echo uang($tk_du_transfer['total']) ?></td>
                <?php $tk_total_du=$tk_du_tunai['total']+$tk_du_transfer['total'];?>
                <td><?php echo uang($tk_total_du) ?></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>PMB</td>
                <td><?php echo uang($tk_pmb_tunai['total']) ?></td>
                <td><?php echo uang($tk_pmb_transfer['total']) ?></td>
                <?php $tk_total_pmb=$tk_pmb_tunai['total']+$tk_pmb_transfer['total'];?>
                <td><?php echo uang($tk_total_pmb) ?></td>
        </tr>
        <tr>
                <td colspan="2">Total TK IT</td>
                <?php $tk_total_tunai=$tk_spp_tunai['total']+$tk_du_tunai['total']+$tk_pmb_tunai['total'];
                      $tk_total_transfer=$tk_spp_transfer['total']+$tk_du_transfer['total']+$tk_pmb_transfer['total'];
                      $tk_total=$tk_total_tunai+$tk_total_transfer;
                ?>
                <td><?php echo uang($tk_total_tunai)?></td>
                <td><?php echo uang($tk_total_transfer)?></td>
                <td><?php echo uang($tk_total);?></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
            <td colspan="5">B. SD IT</td>
            </tr>
            <tr>
            <td width="5%">No.</td>
            <td width="35%">Keterangan</td>
            <td width="20%">Tunai</td>
            <td width="20%">Transfer</td>
            <td width="20%">Total</td>
            </tr>
            <tr>
                <td>1.</td>
                <td>SPP</td>
                <td><?php echo uang($sd_spp_tunai['total']) ?></td>
                <td><?php echo uang($sd_spp_transfer['total']) ?></td>
                        <?php $totalspp=$sd_spp_tunai['total']+$sd_spp_transfer['total'];?>
                        <td><?php echo uang($totalspp) ?></td>
            </tr>
            <tr>
                <td>2.</td>
                <td>PMB</td>
                        <td><?php echo uang($sd_pmb_tunai['total']) ?></td>
                        <td><?php echo uang($sd_pmb_transfer['total']) ?></td>
                        <?php $totalpmb=$sd_pmb_tunai['total']+$sd_pmb_transfer['total'];?>
                        <td><?php echo uang($totalpmb) ?></td>
            </tr>
            <tr>
                <td colspan="2">Total SD IT</td>
                        <?php 
                        $totalsd_tunai=$sd_spp_tunai['total']+$sd_pmb_tunai['total'];
                        $totalsd_transfer=$sd_spp_transfer['total']+$sd_pmb_transfer['total'];
                        $totalsd=$totalpmb+$totalspp;
                        
                        ?>
                        <td><?php echo uang($totalsd_tunai) ?></td>
                        <td><?php echo uang($totalsd_transfer) ?></td>
                        <td><?php echo uang($totalsd) ?></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                    <td colspan="5">C. SMP IT</td>
                    </tr>
                    <tr>
                    <td width="5%">No.</td>
                    <td width="35%">Keterangan</td>
                    <td width="20%">Tunai</td>
                    <td width="20%">Transfer</td>
                    <td width="20%">Total</td>
                    </tr>
                    <tr>
                        <td>1.</td>
                        <td>SPP</td>
                        <td><?php echo uang($smp_spp_tunai['total']) ?></td>
                        <td><?php echo uang($smp_spp_transfer['total']) ?></td>
                        <?php $totalspp=$smp_spp_tunai['total']+$smp_spp_transfer['total'];?>
                        <td><?php echo uang($totalspp) ?></td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>PMB</td>
                        <td><?php echo uang($smp_pmb_tunai['total']) ?></td>
                        <td><?php echo uang($smp_pmb_transfer['total']) ?></td>
                        <?php $totalpmb=$smp_pmb_tunai['total']+$smp_pmb_transfer['total'];?>
                        <td><?php echo uang($totalpmb) ?></td>
                    </tr>
                    <tr>
                        <?php 
                        
                        $totalsmp_tunai=$smp_spp_tunai['total']+$smp_pmb_tunai['total'];
                        $totalsmp_transfer=$smp_spp_transfer['total']+$smp_pmb_transfer['total'];
                        $totalsmp=$totalpmb+$totalspp;?>
                        <td colspan="2">Total SMP IT</td>
                        <td><?php echo uang($smp_spp_tunai['total']+$smp_pmb_tunai['total']) ?></td>
                        <td><?php echo uang($smp_spp_transfer['total']+$smp_pmb_transfer['total']) ?></td>
                        
                        <td><?php echo uang($totalsmp) ?></td>
                        <?php
                        $totalsetoran=$tk_total+$totalsd+$totalsmp;
                        ?>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
        </table>
</div>

<table border="1">
        <tr>
        <th colspan="5">II. SETORAN KE PJ SCHOOL SUPPORT</th>
        </tr>
        <tr>
        <td colspan="5">A. TK IT</td>
        </tr>
        <tr>
        <td width="5%">No.</td>
        <td width="35%">Keterangan</td>
        <td width="20%">Tunai</td>
        <td width="20%">Transfer</td>
        <td width="20%">Total</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>TK IT: School Support</td>
            <td><?php echo uang($tk_ss_tunai['total'])?></td>
            <td><?php echo uang($tk_ss_transfer['total'])?></td>
            <?php $totalss_tk=$tk_ss_tunai['total']+$tk_ss_transfer['total'];?>
            <td><?php echo uang($totalss_tk)?></td>
        </tr>
        <tr>
            <td>2.</td>
            <td>SD IT: School Support</td>
            <td><?php echo uang($sd_ss_tunai['total'])?></td>
            <td><?php echo uang($sd_ss_transfer['total'])?></td>
            <?php $totalss_sd=$sd_ss_tunai['total']+$sd_ss_transfer['total'];?>
            <td><?php echo uang($totalss_sd)?></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>SMP IT: School Support</td>
            <td><?php echo uang($smp_ss_tunai['total'])?></td>
            <td><?php echo uang($smp_ss_transfer['total'])?></td>
            <?php $totalss_smp=$smp_ss_tunai['total']+$smp_ss_transfer['total'];?>
            <td><?php echo uang($totalss_smp)?></td>
        </tr>
        <tr>
                <td colspan="2">Total SCHOOL SUPPORT</td>
                <?php $totalss_tunai=$sd_ss_tunai['total']+$tk_ss_tunai['total']+$smp_ss_tunai['total'];
                      $totalss_transfer=$sd_ss_transfer['total']+$tk_ss_transfer['total']+$smp_ss_transfer['total'];
                      $totalss=$totalss_tunai+$totalss_transfer;
                ?>
                <td><?php echo uang($totalss_tunai)?></td>
                <td><?php echo uang($totalss_transfer)?></td>
                <td><?php echo uang($totalss)?></td>
            </tr>
            <tr>
                <td colspan="4">Nb. School support terdiri dari pembayaran KS, catering, jemputan, buku, ekskul, seragam, baju renang, dll. </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>Total Transaksi:</td>
                <td><?php echo uang($totalss)?></td>
                <?php $totalsemua=$totalss+$totalsetoran; ?>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
        </table>

        <table border="1">
                <tr>
                <th colspan="5">III. PENCAIRAN TRANSFER SS/BON SEMENTARA</th>
                </tr>
                <tr>
                <td colspan="5">A. TK IT</td>
                </tr>
                <tr>
                <td width="5%">No.</td>
                <td width="55%">Transfer/Bon Sementara</td>
                <td width="20%">Unit</td>
                <td width="20%">Total</td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>Pencairan School Support</td>
                    <td>TK/SD/SMP</td>
                    <td><?php echo uang($totalss)?></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Pencairan Setoran ke Yayasan</td>
                    <td>TK/SD/SMP</td>
                    <td><?php echo uang($totalsetoran)?></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                    <tr>
                        <td colspan="3">Total Transaksi:</td>
                        <td><?php echo uang($totalsemua) ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                    </tr>
                </table>

                <table border="1">
                        <tr>
                            <th colspan="5">IV. REKAPITULASI SETORAN KE YAYASAN</th>
                        </tr>
                        <tr>
                            <td width="50%">TUNAI</td>
                            <td width="50%"><?php echo uang($totalsd_tunai+$tk_total_tunai+$totalsmp_tunai+$totalss_tunai)?></td>
                        </tr>
                        <tr>
                            <td>TRANSFER</td>
                            <td width="50%"><?php echo uang($totalsd_transfer+$tk_total_transfer+$totalsmp_transfer+$totalss_transfer)?></td>
                        </tr>
                        <tr>
                            <td>TOTAL PENDAPATAN</td>
                        <td><?php echo uang($totalsemua) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">-</td>
                        </tr>
                        <tr>
                            <td>PENCAIRAN TRANSFER SS/BON SEMENTARA</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>SISA SETORAN TUNAI</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Diterima sisa setoran (minus) oleh Rohman: Rp.   </td>
                            <td>Paraf</td>
                        </tr>
                    </table>
                    <table>
                            <tr>
                                    <th width="33%">Penerima,</th>
                                    <th width="34%"></th>
                                    <th width="33%">Penyetor,</th>
                                </tr>
                                <tr>
                                    <td>Ketua Yayasan   </td>
                                    <td></td>
                                    <td>Front Office</td>
                                </tr>
                                <tr>
                                    <td height="50"></td>
                                    <td height="50"></td>
                                    <td height="50"></td>
                                </tr>
                                <tr>
                                    <td height="50"></td>
                                    <td height="50"></td>
                                    <td height="50"></td>
                                </tr>
                                <tr>
                                    <td>H. Indra T. Abidin</td>
                                    <td></td>
                                    <td>Rohman</td>
                                </tr>
                    </table>
</div>