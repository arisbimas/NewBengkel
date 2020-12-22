<?php 


class Mahasiswa_model extends CI_Model
{
    public function getAllMhs()
    {
        return $this->db->get("mahasiswa")->result_array();
    }

    public function tambahDataMhs()
    {
        $data = [
            'nama'=> $this->input->post('nama', true),
            'npm'=> $this->input->post('npm', true),
            'email'=> $this->input->post('email', true),
            'jurusan'=> $this->input->post('jurusan', true),
        ];
        $this->db->insert('mahasiswa', $data);
    }

    public function hapusDataMhs($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mahasiswa');
    }

    public function getMhsById($id)
    {
        return $this->db->get_where("mahasiswa", ['id' => $id])->row_array();
    }

    public function editDataMhs()
    {
        $data = [
            'nama'=> $this->input->post('nama', true),
            'npm'=> $this->input->post('npm', true),
            'email'=> $this->input->post('email', true),
            'jurusan'=> $this->input->post('jurusan', true),
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('mahasiswa', $data);
    }

    public function cariDataMhs()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('email', $keyword);
        return  $this->db->get('mahasiswa')->result_array();
    }
}
