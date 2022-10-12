<?php
class Laporanbarang extends MY_Controller
{
    public function index()
    {
        cekPergroup();
        $data['gbarang'] = $this->General->fetch_records('tbl_gbarang', ['is_active' => 1]);
        $data['uker'] = $this->General->fetch_records('tbl_unit_kerja');
        $this->header('Laporan Pengeluaran Barang');
        $this->load->view('Laporan/Laporanpengbarang', $data);
        $this->footer();
    }

    public function Cetaklaporan()
    {
        if (input('tglstart')) {
            $this->db->where(['tgl_kirim_barang >=' => input('tglstart')]);
        }

        if (input('tglend')) {
            $this->db->where(['tgl_kirim_barang <=' => input('tglend')]);
        }

        if (input('kon_barang') != 'All') {
            $this->db->where(['kon_barang' => input('kon_barang')]);
        }

        if (input('asal_uker')) {
            $this->db->where(['tbl_unit_kerja.id_uker' => input('asal_uker')]);
        }

        if (input('tujuan_uker')) {
            $this->db->where(['dari_uker' => input('tujuan_uker')]);
        }

        if (input('id_gbarang') != '') {
            $this->db->where(['tbl_gbarang.id_gbarang' => input('id_gbarang')]);
        }

        if (input('id_sgbarang') != '') {
            $this->db->where(['tbl_sgbarang.id_sgbarang' => input('id_sgbarang')]);
        }

        if (input('id_merek') != '') {
            $this->db->where(['tbl_merek.id_merek' => input('id_merek')]);
        }

        if (input('id_tipe_barang') != '') {
            $this->db->where(['tbl_tipe_barang.id_tipe_barang' => input('id_tipe_barang')]);
        }

        if (input('no_urut') != '') {
            $this->db->where(['tbl_gbarang.no_urut' => input('no_urut')]);
        }

        $this->db->where(['id_jtran' => 1]);
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_uker = tbl_transaksi.id_uker', 'left');
        $this->db->join('tbl_barang', 'tbl_barang.no_urut = tbl_transaksi.no_urut', 'left');
        $this->db->join('tbl_tipe_barang', 'tbl_tipe_barang.id_tipe_barang = tbl_barang.id_tipe_barang', 'left');
        $this->db->join('tbl_merek', 'tbl_merek.id_merek = tbl_tipe_barang.id_merek', 'left');
        $this->db->join('tbl_sgbarang', 'tbl_sgbarang.id_sgbarang = tbl_merek.id_sgbarang', 'left');
        $this->db->join('tbl_gbarang', 'tbl_gbarang.id_gbarang = tbl_sgbarang.id_gbarang', 'left');
        $query = $this->db->get('tbl_transaksi')->result_array();

        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $excel = new PHPExcel();
        $excel->getProperties()->setCreator($this->session->userdata('user_login')['nama_pegawai'])
            ->setLastModifiedBy($this->session->userdata('user_login')['nama_pegawai'])
            ->setTitle("Laporan Data Barang")
            ->setSubject("Laporan Data Barang")
            ->setDescription("Laporan Data Barang")
            ->setKeywords("Laporan Data Barang");

        $style_col = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_row = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN DATA PENGELUARAN BARANG");
        $excel->getActiveSheet()->mergeCells('A1:L1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "TANGGAL KIRIM BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "TANGGAL TERIMA BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "ASAL UNIT KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "TUJUAN UNIT KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "NO SN");
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "KONDISI BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "QTY");
        $excel->setActiveSheetIndex(0)->setCellValue('J3', "HARGA BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('K3', "REMARK");
        $excel->setActiveSheetIndex(0)->setCellValue('L3', "STATUS PENGELUARAN");

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);

        $no     = 1;
        $numrow = 4;
        foreach ($query as $data) {
            $dariUker = $this->General->getRow('tbl_unit_kerja', ['id_uker' => $data['dari_uker']]);

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['tgl_terima_barang']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['tgl_kirim_barang']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['nama_uker']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $dariUker->nama_uker);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['nama_barang']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['no_sn']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['kon_barang']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['qty']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['harga_barang']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['remark']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['is_have'] == 1 ? "Sudah diterima!" : "Belum diterima!");

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $excel->getActiveSheet(0)->setTitle("Laporan Data Pengeluaran Barang");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan data Pengeluaran Barang.xlsx"');
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function Penbarven()
    {
        cekPergroup();
        $data['gbarang'] = $this->General->fetch_records('tbl_gbarang', ['is_active' => 1]);
        $data['vendor'] = $this->General->fetch_records('tbl_vendor');
        $this->header('Laporan Penerimaan Barang Vendor');
        $this->load->view('Laporan/Laporanpenbarven', $data);
        $this->footer();
    }

    public function Cetaklaporanpenbarven()
    {
        if (input('tglstart')) {
            $this->db->where(['tgl_terima_barang >=' => input('tglstart')]);
        }

        if (input('tglend')) {
            $this->db->where(['tgl_terima_barang <=' => input('tglend')]);
        }

        if (input('kon_barang') != 'All') {
            $this->db->where(['kon_barang' => input('kon_barang')]);
        }

        if (input('no_referensi')) {
            $this->db->where(['no_referensi' => input('no_referensi')]);
        }

        if (input('id_vendor') != 'All') {
            $this->db->where(['tbl_vendor.id_vendor' => input('id_vendor')]);
        }

        if (input('id_gbarang') != '') {
            $this->db->where(['tbl_gbarang.id_gbarang' => input('id_gbarang')]);
        }

        if (input('id_sgbarang') != '') {
            $this->db->where(['tbl_sgbarang.id_sgbarang' => input('id_sgbarang')]);
        }

        if (input('id_merek') != '') {
            $this->db->where(['tbl_merek.id_merek' => input('id_merek')]);
        }

        if (input('id_tipe_barang') != '') {
            $this->db->where(['tbl_tipe_barang.id_tipe_barang' => input('id_tipe_barang')]);
        }

        if (input('no_urut') != '') {
            $this->db->where(['tbl_gbarang.no_urut' => input('no_urut')]);
        }

        $this->db->where('id_jtran', 2);
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_uker = tbl_transaksi.id_uker', 'left');
        $this->db->join('tbl_vendor', 'tbl_vendor.id_vendor = tbl_transaksi.id_vendor', 'left');
        $this->db->join('tbl_barang', 'tbl_barang.no_urut = tbl_transaksi.no_urut', 'left');
        $this->db->join('tbl_tipe_barang', 'tbl_tipe_barang.id_tipe_barang = tbl_barang.id_tipe_barang', 'left');
        $this->db->join('tbl_merek', 'tbl_merek.id_merek = tbl_tipe_barang.id_merek', 'left');
        $this->db->join('tbl_sgbarang', 'tbl_sgbarang.id_sgbarang = tbl_merek.id_sgbarang', 'left');
        $this->db->join('tbl_gbarang', 'tbl_gbarang.id_gbarang = tbl_sgbarang.id_gbarang', 'left');
        $query = $this->db->get('tbl_transaksi')->result_array();

        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $excel = new PHPExcel();
        $excel->getProperties()->setCreator($this->session->userdata('user_login')['nama_pegawai'])
            ->setLastModifiedBy($this->session->userdata('user_login')['nama_pegawai'])
            ->setTitle("Laporan Data Barang")
            ->setSubject("Laporan Data Barang")
            ->setDescription("Laporan Data Barang")
            ->setKeywords("Laporan Data Barang");

        $style_col = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_row = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN DATA PENERIMAAN BARANG VENDOR");
        $excel->getActiveSheet()->mergeCells('A1:J1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "UNIT KERJA PENERIMA");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "NO REFERENSI");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA VENDOR");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "NO SN");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "KONDISI BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "QTY");
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "HARGA BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('J3', "REMARK");

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);

        $no     = 1;
        $numrow = 4;
        foreach ($query as $data) {
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['nama_uker']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['no_referensi']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['nama_vendor']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['nama_barang']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['no_sn']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['kon_barang']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['qty']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['harga_barang']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['remark']);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $excel->getActiveSheet(0)->setTitle("Penerimaan Barang Vendor");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Penerimaan Barang Vendor.xlsx"');
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}
