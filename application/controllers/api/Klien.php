<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Klien extends RestController {

    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");        
        $this->load->library('form_validation');
    }

    public function index_get(){        
        $clients = $this->db->get('klien')->result();

        if($clients != null){
            $this->response(['status' => true, 'message' => 'Data berhasil ditemukan', 'data' => $clients], 200);
        }else{
            $this->response(['status' => false, 'message' => 'Data klien tidak ditemukan'], 200);
        }        
    }

    public function filter_get(){
        $param = $this->get();  
        
        if($param['status'] == 0){
            $query = "SELECT * FROM klien WHERE NAMA_KLIEN LIKE '%".$param['nama']."%'";
            $clients = $this->db->query($query)->result();

            if($clients != null){
                $this->response(['status' => true, 'message' => 'Data berhasil ditemukan', 'data' => $clients], 200);
            }else{
                $this->response(['status' => false, 'message' => 'Data klien tidak ditemukan'], 200);
            };
        }else if($param['status'] == 1){
            $query = "SELECT * FROM klien WHERE NAMA_KLIEN LIKE '%".$param['nama']."%' AND deleted_at IS NULL";
            $clients = $this->db->query($query)->result();

            if($clients != null){
                $this->response(['status' => true, 'message' => 'Data berhasil ditemukan', 'data' => $clients], 200);
            }else{
                $this->response(['status' => false, 'message' => 'Data klien tidak ditemukan'], 200);
            };
        }else if($param['status'] == 2){
            $query = "SELECT * FROM klien WHERE NAMA_KLIEN LIKE '%".$param['nama']."%' AND deleted_at IS NOT NULL";
            $clients = $this->db->query($query)->result();

            if($clients != null){
                $this->response(['status' => true, 'message' => 'Data berhasil ditemukan', 'data' => $clients], 200);
            }else{
                $this->response(['status' => false, 'message' => 'Data klien tidak ditemukan'], 200);
            };
        }                 
    }

    public function tambah_post(){
        $param = $this->post();        
        if(!empty('nama') && !empty('telepon') && !empty('email') && !empty('alamat')){
            $this->form_validation->set_rules('email', 'EMAIL_KLIEN','is_unique[klien.EMAIL_KLIEN]');
            if($this->form_validation->run()==TRUE){
                
                $storeKlien['NAMA_KLIEN']      = $param['nama'];
                $storeKlien['TELP_KLIEN']      = $param['telepon'];
                $storeKlien['EMAIL_KLIEN']     = $param['email'];
                $storeKlien['ALAMAT_KLIEN']    = $param['alamat'];

                $this->db->insert('klien', $storeKlien);
                $this->response(['status' => true, 'message' => 'Data berhasil ditambahkan'], 200);
            }else{
                $this->response(['status' => false, 'message' => 'Email telah digunakan'], 200);
            }
        }else{
            $this->response(['status' => false, 'message' => 'Parameter tidak cocok'], 200);
        }
    }

    public function detail_get($idKlien){
        $klien = $this->db->get_where('klien', ['ID_KLIEN' => $idKlien])->row();
        if($klien != null){
            $this->response(['status' => true, 'message' => 'Data berhasil ditemukan', 'data' => $klien], 200);
        }else{
            $this->response(['status' => false, 'message' => 'Data tidak ditemukan', 'data' => $klien], 404);
        }
    }
    
    public function edit_put(){
        $param = $this->put();
        if(!empty('nama') && !empty('telepon') && !empty('email') && !empty('alamat')){                
            $this->db->where(['ID_KLIEN' => $param['idKlien']])->update('klien', 
                [
                    'NAMA_KLIEN'  => $param['nama'], 
                    'TELP_KLIEN'  => $param['telepon'], 
                    'EMAIL_KLIEN' => $param['email'],
                    'ALAMAT_KLIEN'=> $param['alamat'],
                    'updated_at'  => date('Y-m-d H:i:s')
                ]);
                            
            $this->response(['status' => true, 'message' => 'Data berhasil diubah'], 200);            
        }else{
            $this->response(['status' => false, 'message' => 'Parameter tidak cocok'], 200);
        }
    }
    public function changeStatus_put(){
        $param = $this->put();
        if($param['status'] == 1){
            $this->db->where('ID_KLIEN', $param['idKlien'])->update('klien', ['deleted_at' => null]);
        }else if($param['status'] == 2){
            $this->db->where('ID_KLIEN', $param['idKlien'])->update('klien', ['deleted_at' => date('Y-m-d H:i:s')]);
        }
    }
}