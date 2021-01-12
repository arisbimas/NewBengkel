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
            $ambil = substr($laskode, 2, 4) + 1;
            $newcode = "FK" . sprintf("%04s", $ambil).date("dmY");
            return $newcode;
        }else{
            return 'FK0001'.date("dmY");  
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