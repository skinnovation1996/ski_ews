<?php
require_once("assets/php/password.php");
defined('BASEPATH') OR exit('No direct script access allowed!');

class SPPUK_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    //Login function DONE
    function loginRead($where, $length, $start, $password){
        $this->db->limit($length, $start);

        $query = $this->db->get_where('user', $where);

        if($query->num_rows() > 0){
            $row = $query->row();

            if(password_verify($password, $row->password)){
                if($row->status == "Active"){
                    return "OK";
                }else{
                    return "INACTIVE_USER";
                }
                
            }else{
                return "INVALID_USER_ID";
            }
            
        }else{
            return "INVALID_USER_ID";
        }
    }

    function checkOldPassword($where, $password){
        $this->db->limit(null, $null);

        $query = $this->db->get_where('user', $where);

        if($query->num_rows() > 0){
            $row = $query->row();

            if(password_verify($password, $row->password)){
                return TRUE;
            }else{
                return FALSE;
            }
            
        }else{
            return FALSE;
        }
    }

     /*                                  USER REGISTER                                     */

    //Generate User ID
    function generatePekerjaId(){
        $this->db->limit(null, null);
        $where = array('role' => "pekerja");
        $query = $this->db->get_where('user', $where);
        $countPekerja = $query->num_rows() + 1;
        if($countPekerja){
            if($countPekerja < 10){
                $pekerja_id = "1000".$countPekerja; 
            }else if($countPekerja < 100){
                $pekerja_id = "100".$countPekerja; 
            }else if($countPekerja < 1000){
                $pekerja_id = "10".$countPekerja; 
            }else if($countPekerja < 10000){
                $pekerja_id = "1".$countPekerja; 
            }else if($countPekerja < 50000){
                $pekerja_id = $countPekerja; 
            }
        }else{
            $pekerja_id = "10001";
        }

        //Check existing ID
        $this->db->limit(null, null);
        $where = array('id' => $pekerja_id, 'role' => "pekerja");
        $query = $this->db->get_where('user', $where);
        $existingId = $query->num_rows();
        if($existingId){
            $this->db->limit(null, null);
            $where = array('role' => "pekerja");
            $query = $this->db->get_where('user', $where);
            $countPekerja = $query->num_rows() + 2;
            if($countPekerja){
                if($countPekerja < 10){
                    $pekerja_id = "1000".$countPekerja; 
                }else if($countPekerja < 100){
                    $pekerja_id = "100".$countPekerja; 
                }else if($countPekerja < 1000){
                    $pekerja_id = "10".$countPekerja; 
                }else if($countPekerja < 10000){
                    $pekerja_id = "1".$countPekerja; 
                }else if($countPekerja < 50000){
                    $pekerja_id = $countPekerja; 
                }
            }else{
                $pekerja_id = "10001";
            }
        }

        return $pekerja_id;
    }
    
    //Daftar Pekerja
    function daftarPekerja($data1, $data2){
        $this->db->insert('user',$data1);
        $this->db->insert('pekerja',$data2);
        return "OK";
    }

    /*                                  COMMON                                     */

    //Get User Name
    function getLogInName($uid, $role){
        $this->db->limit(null, null);
        if($role == "pekerja"){
            $target = "pekerja";
        }else{
            $target = "majikan";
        }
        $where = array('id' => $uid);
        $query = $this->db->get_where($target, $where);
        return $query->result();
    }

    /*                                  SYS ADMIN                                     */

    //List Of Pending Soalan Ujian
    function listPendingSoalan(){
        $this->db->limit(null, null);
        $where = array('status' => "Pending");
        $query = $this->db->get_where('soalan', $where);
        return $query->result();
    }

    //Read Soalan By ID
    function getPendingSoalanById($where, $length, $start){
        $this->db->limit($length, $start);
        $this->db->where('status',"Pending");
        $query = $this->db->get_where('soalan', $where);
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    //Verify Ujian Soalan
    function verifySoalan($soalan_id, $data){
        $this->db->where('id',$soalan_id);
        $this->db->update('soalan',$data);
        return "OK";
    }

    //List Of Majikan
    function listMajikan($where, $length, $start){
        $this->db->limit($length, $start);
        $query = $this->db->get_where('majikan', $where);
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    //List Of Majikan
    function listMajikanSimple(){
        $query = $this->db->get('majikan');
        return $query->result();
    }

    //Count Number Of Pekerja
    function countPekerjaTotal(){
        $this->db->limit(null, null);
        $query = $this->db->get('pekerja');
        return $query->num_rows();
    }

    //Count Number Of Pekerja in Majikan
    function countPekerjaInMajikan($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id);
        $query = $this->db->get_where('pekerja', $where);
        return $query->num_rows();
    }

    //Count Number Of Soalan
    function countSoalanTotal(){
        $this->db->limit(null, null);
        $query = $this->db->get('soalan');
        return $query->num_rows();
    }

    //Count Number Of Soalan in Majikan
    function countSoalanInMajikan($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id);
        $query = $this->db->get_where('soalan', $where);
        return $query->num_rows();
    }

    //Count Number Of Ujan
    function countUjianTotal(){
        $this->db->limit(null, null);
        $query = $this->db->get('ujian');
        return $query->num_rows();
    }

    //Count Number Of Ujian in Majikan
    function countUjianInMajikan($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id);
        $query = $this->db->get_where('ujian', $where);
        return $query->num_rows();
    }

    //Generate Majikan ID
    function generateMajikanId(){
        $this->db->limit(null, null);
        $where = array('role' => "majikan");
        $query = $this->db->get_where('user', $where);
        $countMajikan = $query->num_rows() + 1;
        if($countMajikan){
            if($countMajikan < 10){
                $majikan_id = "5000".$countMajikan; 
            }else if($countMajikan < 100){
                $majikan_id = "500".$countMajikan; 
            }else if($countMajikan < 1000){
                $majikan_id = "50".$countMajikan; 
            }else if($countMajikan < 10000){
                $majikan_id = "5".$countMajikan; 
            }
        }else{
            $majikan_id = "50001";
        }

        //Check existing ID
        $this->db->limit(null, null);
        $where = array('id' => $majikan_id, 'role' => "majikan");
        $query = $this->db->get_where('user', $where);
        $existingId = $query->num_rows();
        if($existingId){
            $this->db->limit(null, null);
            $where = array('role' => "pekerja");
            $query = $this->db->get_where('user', $where);
            $countMajikan = $query->num_rows() + 2;
            if($countMajikan){
                if($countMajikan < 10){
                    $majikan_id = "5000".$countMajikan; 
                }else if($countMajikan < 100){
                    $majikan_id = "500".$countMajikan; 
                }else if($countMajikan < 1000){
                    $majikan_id = "50".$countMajikan; 
                }else if($countMajikan < 10000){
                    $majikan_id = "5".$countMajikan; 
                }
            }else{
                $majikan_id = "50001";
            }
        }

        return $majikan_id;
    }

    //Tambah Majikan (oleh Admin)
    function createMajikan($data1, $data2){
        $this->db->insert('user',$data1);
        $this->db->insert('majikan',$data2);
        return "OK";
    }

    //Read Majikan By ID
    function getMajikanById($where, $length, $start){
        $this->db->limit($length, $start);
        $query = $this->db->get_where('majikan', $where);
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    //Kemaskini Majikan (oleh Admin)
    function updateMajikan($majikan_id, $data){
        $this->db->where('id',$majikan_id);
        $this->db->update('majikan',$data);
        return "OK";
    }

    //Buang Personality Info
    function deletePersonalityInfo($ujian_id){
        $this->db->where('id_ujian',$ujian_id);
        $this->db->delete('personalitypekerja');
        if($this->db->affected_rows() == 1){
            return TRUE;
        }
        return FALSE;
    }

    //Buang Soalan Ujian
    function deleteSoalanUjian($ujian_id){
        $this->db->where('id_ujian',$ujian_id);
        $this->db->delete('soalanujian');
        if($this->db->affected_rows() == 1){
            return TRUE;
        }
        return FALSE;
    }

    //Buang Ujian By Ujian ID & Pekerja ID
    function deleteUjian($ujian_id, $pekerja_id){
        $this->db->where('id',$ujian_id);
        $this->db->where('id_pekerja',$pekerja_id);
        $this->db->delete('ujian');
        if($this->db->affected_rows() == 1){
            return TRUE;
        }
        return FALSE;
    }


    //Buang Semua Pekerja Dalam Majikan
    function deleteAllPekerjaInMajikan($majikan_id){
        $this->db->where('id',$majikan_id);
        $this->db->delete('pekerja');
        if($this->db->affected_rows() == 1){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }

    //Buang Semua Soalan Dalam Majikan
    function deleteAllSoalanInMajikan($majikan_id){
        $this->db->where('id',$majikan_id);
        $this->db->delete('soalan');
        if($this->db->affected_rows() == 1){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }

    //Buang Majikan
    function deleteMajikan($majikan_id){
        $this->db->where('id',$majikan_id);
        $this->db->delete('majikan');
        if($this->db->affected_rows() == 1){
            $where = array('id' => $majikan_id, 'role' => 'majikan');
            $this->db->delete('user');
            return TRUE;
        }
        return FALSE;
    }

    /*                                  MAJIKAN                                     */

    //List Of Soalan Ujian
    function listSoalan($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id);
        $query = $this->db->get_where('soalan', $where);
        return $query->result();
    }

    //Tambah Soalan Ujian
    function createSoalan($data){
        $this->db->insert('soalan',$data);
        return TRUE;
    }

    //Read Soalan By ID
    function getSoalanByIdNoMajikan($where, $length, $start){
        $this->db->limit($length, $start);
        $query = $this->db->get_where('soalan', $where);
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    //Read Soalan By ID
    function getSoalanById($where, $majikan_id, $length, $start){
        $this->db->limit($length, $start);
        $this->db->where('id_majikan',$majikan_id);
        $query = $this->db->get_where('soalan', $where);
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    //Kemaskini Soalan Ujian
    function updateSoalan($soalan_id, $data){
        $this->db->where('id',$soalan_id);
        $this->db->update('soalan',$data);
        return TRUE;
    }

    //Buang Soalan Ujian
    function deleteSoalan($soalan_id){
        $this->db->where('id',$soalan_id);
        $this->db->delete('soalan');
        if($this->db->affected_rows() == 1){
            return TRUE;
        }
        return FALSE;
    }

    //List Of Pekerja (New Registered)
    function listPekerjaNewRegister($majikan_id){
        $this->db->limit(null, null);
        $query = $this->db->join('user b', 'b.id=a.id')->get_where('pekerja a', array("a.id_majikan" => $majikan_id, "b.status" => "Pending"));
        return $query->result();
    }


    //Read Pekerja By ID (NEw Registered)
    function getPekerjaRegById($pekerja_id, $majikan_id, $length, $start){
        $this->db->limit($length, $start);
        $query = $this->db->join('user b', 'b.id=a.id')->get_where('pekerja a', array("a.id" => $pekerja_id, "a.id_majikan" => $majikan_id, "b.status" => "Pending"));
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    //Verify Pekerja(New Registered)
    function verifyPekerja($pekerja_id, $data){
        $this->db->where('id',$pekerja_id);
        $this->db->update('user',$data);
        return "OK";
    }

    //List Of Pekerja (Active User)
    function listPekerjaByMajikan($majikan_id){
        $this->db->limit(null, null);
        $query = $this->db->join('user b', 'b.id=a.id')->get_where('pekerja a', array("a.id_majikan" => $majikan_id, "b.status" => "Active"));
        return $query->result();
    }
    
    //Read Pekerja By ID (Active Registered)
    function getPekerjaById($pekerja_id, $majikan_id, $length, $start){
        $this->db->limit($length, $start);
        $query = $this->db->join('user b', 'b.id=a.id')->get_where('pekerja a', array("a.id" => $pekerja_id, "a.id_majikan" => $majikan_id, "b.status" => "Active"));
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    //Kemaskini Profil Pekerja (oleh Majikan)
    function updateProfilPekerjaFromMajikan($pekerja_id, $majikan_id, $data){
        $this->db->where('id',$pekerja_id);
        $this->db->where('id_majikan',$majikan_id);
        $this->db->update('pekerja',$data);
        return TRUE;
    }

    //Buang Pekerja
    function deletePekerja($pekerja_id){
        $this->db->where('id',$pekerja_id);
        $this->db->delete('pekerja');
        if($this->db->affected_rows() == 1){
            return TRUE;
        }
        return FALSE;
    }

    //Get Ujian By Ujian ID 
    function getUjianById($ujian_id){
        $this->db->limit(null, null);
        $where = array('id' => $ujian_id);
        $query = $this->db->get_where('ujian', $where);
        return $query->result();
    }

    //Get Ujian By Ujian ID 
    function commentUjian($ujian_id, $pekerja_id, $data){
        $this->db->where('id',$ujian_id);
        $this->db->where('id_pekerja',$pekerja_id);
        $this->db->update('ujian',$data);
        return TRUE;
    }

    //Compare Personality Target
    function listPekerjaByMajikanExclude($pekerja_id, $majikan_id){
        $this->db->limit(null, null);
        $query = $this->db->join('user b', 'b.id=a.id')->get_where('pekerja a', array("a.id_majikan" => $majikan_id, "a.id !=" => $pekerja_id, "b.status" => "Active"));
        return $query->result();
    }

    /*                                  PEKERJA                                     */

    //Profil Saya
    function myProfile($pekerja_id){
        $this->db->limit(null, null);
        $where = array('id' => $pekerja_id);
        $query = $this->db->get_where('pekerja', $where);
        return $query->result();
    }

    //Kemaskini Profil Pekerja (oleh Pekerja)
    function updateProfilPekerja($pekerja_id, $data){
        $this->db->where('id',$pekerja_id);
        $this->db->update('pekerja',$data);
        return TRUE;
    }

    //Kemaskini Kata Laluan
    function updatePassword($pekerja_id, $data){
        $this->db->where('id',$pekerja_id);
        $this->db->update('user',$data);
        return TRUE;
    }

    //List Of Ujian History
    function listUjian($pekerja_id){
        $this->db->limit(null, null);
        $where = array('id_pekerja' => $pekerja_id);
        $query = $this->db->get_where('ujian', $where);
        return $query->result();
    }

    //Count Ujian History
    function countUjian($pekerja_id){
        $this->db->limit(null, null);
        $where = array('id_pekerja' => $pekerja_id);
        $query = $this->db->get_where('ujian', $where);
        return $query->num_rows();
    }

    //Get Ujian By Ujian ID by Pekerja ID
    function getUjianByIdPekerja($ujian_id, $pekerja_id){
        $this->db->limit(null, null);
        $where = array('id' => $ujian_id, 'id_pekerja' => $pekerja_id);
        $query = $this->db->get_where('ujian', $where);
        return $query->result();
    }

    //Get Personality By Ujian ID
    function getPersonalityById($ujian_id){
        $this->db->limit(null, null);
        $where = array('id_ujian' => $ujian_id);
        $query = $this->db->get_where('personalitipekerja', $where);
        return $query->result();
    }

    //Get Latest Ujian Info By Ujian ID
    function getLatestUjianInfo($pekerja_id){
        $this->db->limit(1, 0);
        $where = array('id_pekerja' => $pekerja_id);
        $query = $this->db->order_by('tarikh_jawab','DESC')->get_where('ujian', $where);
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return FALSE;
        }
    }

    //Get Latest Personality By Ujian ID
    function getLatestPersonalityInfo($ujian_id){
        $this->db->limit(1, 0);
        $where = array('id_ujian' => $ujian_id);
        $query = $this->db->get_where('personalitipekerja', $where);
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    
    //Soalan Personaliti
    function listAllPersonalityQuestions($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id,'status' => "Approved");
        $query = $this->db->order_by('rand()')->get_where('soalan', $where);
        return $query->result();
    }

    //Add New Ujian Entry
    function createUjian($data){
        $this->db->insert('ujian',$data);
        $ujian_id = $this->db->insert_id();
        return $ujian_id;
    }

    //Add New Soalan in Ujian Entry
    function createSoalanUjian($data){
        $this->db->insert('soalanujian',$data);
        return TRUE;
    }

    //Count Number Of Soalan with Jiwa Type
    function countSoalanJiwa($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id, 'algorithm' => "Jiwa");
        $query = $this->db->get_where('soalan', $where);
        return $query->num_rows();
    }

    //Count Number Of Soalan with Tenaga Type
    function countSoalanTenaga($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id, 'algorithm' => "Tenaga");
        $query = $this->db->get_where('soalan', $where);
        return $query->num_rows();
    }

    //Count Number Of Soalan with Sifat Type
    function countSoalanSifat($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id, 'algorithm' => "Sifat");
        $query = $this->db->get_where('soalan', $where);
        return $query->num_rows();
    }

    //Count Number Of Soalan with Taktik Type
    function countSoalanTaktik($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id, 'algorithm' => "Taktik");
        $query = $this->db->get_where('soalan', $where);
        return $query->num_rows();
    }

    //Count Number Of Soalan with Identiti Type
    function countSoalanIdentiti($majikan_id){
        $this->db->limit(null, null);
        $where = array('id_majikan' => $majikan_id, 'algorithm' => "Identiti");
        $query = $this->db->get_where('soalan', $where);
        return $query->num_rows();
    }

    //Generate User Personality
    function createPersonalityInfo($data){
        $this->db->insert('personalitipekerja',$data);
        return TRUE;
    }

}
?>