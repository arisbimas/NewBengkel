<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        if($this->input->is_ajax_request()){

        }else{
            is_logged_in();
        }   

        $this->load->model("Penjualan_model", 'penjualan');
        $this->load->model("Barang_model", 'barang');
        $this->load->model("Merk_model", 'merk');
        $this->load->model("User_model", 'users');
        $this->load->library('form_validation');
    }

    public function cetak_struk($listData=[], $totalHarga=null, $noFak=null, $returnVal=false)
    {
        // me-load library escpos
        $this->load->library('escpos');
 
        try {
            
            // membuat connector printer ke shared printer bernama "printer_58mm" (yang telah disetting sebelumnya)
            $connector = new Escpos\PrintConnectors\WindowsPrintConnector("printer_5mm");
    
            // membuat objek $printer agar dapat di lakukan fungsinya
            $printer = new Escpos\Printer($connector);
    
    
            // membuat fungsi untuk membuat 1 baris tabel, agar dapat dipanggil berkali-kali dgn mudah
            function buatBaris4Kolom($kolom1, $kolom2, $kolom3, $kolom4) {
                // Mengatur lebar setiap kolom (dalam satuan karakter)
                $lebar_kolom_1 = 11;
                $lebar_kolom_2 = 3;
                $lebar_kolom_3 = 6;
                $lebar_kolom_4 = 9;
    
                // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
                $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
                $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
                $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
                $kolom4 = wordwrap($kolom4, $lebar_kolom_4, "\n", true);
    
                // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
                $kolom1Array = explode("\n", $kolom1);
                $kolom2Array = explode("\n", $kolom2);
                $kolom3Array = explode("\n", $kolom3);
                $kolom4Array = explode("\n", $kolom4);
    
                // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
                $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array), count($kolom4Array));
    
                // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
                $hasilBaris = array();
    
                // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
                for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
    
                    // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                    $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                    $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");
    
                    // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
                    $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
                    $hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);
    
                    // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                    $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3 . " " . $hasilKolom4;
                }
    
                // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
                return implode($hasilBaris, "\n") . "\n";
            }   
            
            $listData = json_decode(stripslashes($this->input->post('listCart')));
            $totalHarga = $this->input->post('totalHarga');
            if ($this->input->post('NomorFaktur')) {
                $noFak = json_decode($this->input->post('NomorFaktur'));
            }
            if($this->input->post('WithReturn')){
                $returnVal = true;
            }   

            $dataArr = array();
            foreach($listData as $d){
                    array_push($dataArr, array(
                        'kode_barang' => $d->{'kode_barang'},
                        'nama_barang' => $d->{'nama_barang'},
                        'harga_jual' => $d->{'harga_jual'},
                        'jumlah_beli' => $d->{'jumlah_beli'},
                        'sub_total' => $d->{'sub_total'}             
                    ));                
                }

            // Membuat judul
            $printer->initialize();
            $printer->selectPrintMode(Escpos\Printer::MODE_DOUBLE_HEIGHT); // Setting teks menjadi lebih besar
            $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
            $printer->text(MYBRAND."\n");        
            $printer->text($noFak."\n");
            $printer->text("\n");
    
            // Data transaksi        
            $printer->initialize();
            $printer->text("Aktor : ".$this->session->userdata('user_login')."\n");
            $day = hariIni(date ("D"));
            $printer->text("Waktu : ".$day.", ".date("d-m-y h:i:s")."\n");
    
            // Membuat tabel
            $printer->initialize(); // Reset bentuk/jenis teks
            $printer->text("--------------------------------\n");
            $printer->text(buatBaris4Kolom("Barang", "Qty", "Harga", "Subtotal"));
            $printer->text("--------------------------------\n");
                    
            foreach ($dataArr as $list ) {
                $printer->text(buatBaris4Kolom($list["nama_barang"], $list["jumlah_beli"], number_format($list["harga_jual"]), number_format($list["sub_total"])));
            }

            $printer->text("--------------------------------\n");
            $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
            $printer-> setTextSize(2, 1);
            if(strpos($totalHarga, "Rp") === false){
                $totalHarga = "Rp ".number_format($totalHarga,0,'','.');
            }
            $printer->text("Total ".$totalHarga."\n");
            $printer->text("\n");
    
            // Pesan penutup
            $printer->initialize();
            $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
            $printer->text("Terima kasih telah berbelanja\n");
            $printer->text("http://bengkelku.com\n");
    
            $printer->feed(5); // mencetak 5 baris kosong agar terangkat (pemotong kertas saya memiliki jarak 5 baris dari toner)
            if($returnVal){
                echo json_encode(array("response" => "success"));
            }            
            $printer->close();         
            
        } catch (Exception $e) {
            echo json_encode("TIDAK TERKONEKSI DENGAN PRINTER: " . $e -> getMessage() . "\n");    
        }
    }

    public function index()
    {
        $data["judul"] = "Halaman Penjualan";
        $data['user'] = $this->users->getUserByUserLogin($this->session->userdata('user_login'));
        
        $this->load->view("templates/header", $data);
        $this->load->view("penjualan/index");
        $this->load->view("templates/footer");
    }

    function generateFaktur() {
        $ci = &get_instance();
        $chek = $ci->db->query("select nomor_faktur from tbl_penjualan order by nomor_faktur DESC");
        if ($chek->num_rows() > 0) {
            $chek=$chek->row_array();
            $laskode = $chek['nomor_faktur'];        
            $ambil = substr($laskode, 13, 4)+1;
            $newcode = "INV/" . date("dmY")."/".sprintf("%04s", $ambil);
            return $newcode;
        }else{
            return 'INV/'.date("dmY/")."0001";  
        }
    }

    public function AddPenjualan()
    {        
        if($this->input->is_ajax_request()){
            $dataArr = array();
            $listCart = json_decode(stripslashes($this->input->post('listCart')));
            $total_harga = json_decode(stripslashes($this->input->post('totalHarga')));
            $no_faktur = $this->generateFaktur();
            $penjualan = array(
                'nomor_faktur' => $no_faktur,
                'total_harga' => $total_harga,
                // 'tgl_transaksi'=> date('Y-m-d'),
                'created_on' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_login') 
            );            

            // Starting Transaction
            $this->db->trans_start(); # Starting Transaction
            $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

            foreach($listCart as $d){
                array_push($dataArr, array(
                    'nomor_faktur' => $no_faktur,
                    'kode_barang' => $d->{'kode_barang'},
                    'nama_barang' => $d->{'nama_barang'},
                    'harga_jual' => $d->{'harga_jual'},
                    'jumlah_beli' => $d->{'jumlah_beli'},
                    'sub_total' => $d->{'sub_total'},
                    // 'tgl_transaksi' => date('Y-m-d'),
                    'created_on' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('user_login')              
                ));

                $jmlBeli = $d->{'jumlah_beli'};
                $kdBrg = $d->{'kode_barang'};
                $date = date('Y-m-d H:i:s');
                //update stok
                $this->db->query("UPDATE tbl_barang set stok=stok-$jmlBeli, modified_on='$date' where kode_barang='$kdBrg'");
            }
            $this->penjualan->insert_new_penjualan($penjualan);
            $this->penjualan->insert_new_detail_penjualan($dataArr);            

            $this->db->trans_complete(); # Completing transaction

            /*Optional*/

            if ($this->db->trans_status() === FALSE) {
                # Something went wrong.
                $this->db->trans_rollback();
                $data = array("response" => "error", "message" => "Transaksi Gagal Disimpan.");
            } 
            else {                
                # Everything is Perfect. 
                # Committing data to the database.
                $this->db->trans_commit();
                $data = array("response" => "success", "message" => "Transaksi Berhasil Disimpan.");
            }
        }else{
            echo("No direct script access allowed");
        }                
        echo json_encode($data);        
        if($data["response"] == "success"){
            $this->cetak_struk($dataArr, $total_harga, $no_faktur,false);
        }
        
    }

    public function ListPenjualan()
    {
        $data["judul"] = "Halaman List Penjualan";
        $data['user'] = $this->users->getUserByUserLogin($this->session->userdata('user_login'));
        
        $this->load->view("templates/header", $data);
        $this->load->view("penjualan/list-penjualan.php");
        $this->load->view("templates/footer");
    }

    public function ListDataPenjualan()
    {
        $list = $this->penjualan->get_datatables();
 
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->penjualan->count_all(),
                    "recordsFiltered" => $this->penjualan->count_filtered(),
                    "data" => $list,
                );
        //output to json format
        echo json_encode($output);
    }

    public function GetDetailPenjualanByFaktur() {
        if($this->input->is_ajax_request()){
            $noFaktur = $this->input->post('nomor_faktur');
            if($post = $this->penjualan->get_detail_penjualan_by_faktur($noFaktur)){
                
                $data = array("response" => "success", "message" => "Data Berhasil Didapat.", 'ListData'=>$post);
            }else{
                $data = array("response" => "error", "message" => "Data Gagal Didapat.");
            }
        }else{
            echo("No direct script access allowed");
        }
        echo json_encode($data);
    }

    public function laporan_hari_ini(){

        $data["penjualan"] = $this->penjualan->getDataPenjualanByDay();
        $data["tanggal"] = date("d-m-Y");

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-penjualan-harian-".date('d-m-Y')."pdf";
        $this->pdf->load_view('penjualan/laporan_hari_ini', $data);

    }

    public function laporan_mingguan(){

        $data["penjualan"] = $this->penjualan->getDataPenjualanByWeek();
        $data["hariIni"] = date("d-m-Y");
        $date =  mktime(0, 0, 0, date("m"), date("d")-7, date("Y"));        
        $data["mingguLalu"] = date("d-m-Y", $date);

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-penjualan-mingguan.pdf";
        $this->pdf->load_view('penjualan/laporan_mingguan', $data);

    }

    public function laporan_bulanan(){

        $data["penjualan"] = $this->penjualan->getDataPenjualanByMonth();
        $bulan = ["Januari","Februari","Maret","April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November","Desember"];
        $data["bulanIni"] = $bulan[date("m")-1];

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-penjualan-bulanan.pdf";
        $this->pdf->load_view('penjualan/laporan_bulanan', $data);

    }

}