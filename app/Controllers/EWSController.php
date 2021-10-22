<?php
require_once("assets/php/password.php");
defined('BASEPATH') OR exit('No direct script access allowed!');

class sppuk extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url')); 
        $this->load->model('sppuk_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    //Dashboard Page DONE
    public function dashboard(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Menu Utama';
        $this->load->view('dashboard',$data);
    }

    //Login Page DONE
    public function login(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Log Masuk';
        if ($this->input->post('login-btn')) {
            $userid = $this->input->post("userid");
            $password = $this->input->post("password");
            $role = $this->input->post("role");

            if($userid == "99999" && $role == "majikan") //Super Admin
                $role = "admin";

            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            $this->form_validation->set_rules("userid", "ID Pengguna", "trim|required");
            $this->form_validation->set_rules("password", "Kata Laluan", "trim|required");
  
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('login',$data);
            }
            else {
      
                $data = array(
                    'id'   => $userid,
                    'role' => $role
                );
      
                $result = $this->sppuk_model->loginRead($data, null, null, $password);

                if($result == "OK"){
                    $sesdata = array(
                        'sppuk_logged_in'  => $userid,
                        'sppuk_logged_in_role' => $role,
                    ); 

                    $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Menu Utama';
                    $this->session->set_userdata($sesdata);
                    $this->load->view('dashboard',$data);

                }else if($result == "INACTIVE_USER"){
                    $data = array(
                        'message'  => "Pengguna ini tidak aktif!",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Log Masuk'
                    );

                    $this->load->view('login',$data);
                }
                else if($result == "INVALID_USER_ID"){
                    $data = array(
                        'message'  => "ID Pengguna/kata laluan tidak sah",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Log Masuk'
                    );

                    $this->load->view('login',$data);
                }
            }
        }
        else {
            $this->load->view('login',$data);
        }
    }

    /*                                  USER REGISTER                                     */
    //DONE
    public function daftar_pekerja(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pengguna';
        if ($this->input->post('register-btn')) {
            $nama = $this->input->post("namapekerja"); //
            $email = $this->input->post("email"); //
            $majikanId = $this->input->post("majikanid"); //
            $password = $this->input->post("password"); //
            $verifypassword = $this->input->post("verifypassword"); //
            $hash_password = password_hash($password, PASSWORD_DEFAULT); //
            $jantina = $this->input->post("jantina"); // 
            $phoneno = $this->input->post("phoneno"); //
            $statuskahwin = $this->input->post("statuskahwin");
            $kelayakan = $this->input->post("kelayakan");
            $birthdate = $this->input->post("birthdate"); //
            $gambar = $_FILES['gambar']['name']; //
            $alamat1 = $this->input->post("alamat1"); //
            $alamat2 = $this->input->post("alamat2"); //
            $postcode = $this->input->post("postcode"); //
            $city = $this->input->post("city"); // 
            $state = $this->input->post("state"); // 
            $country = $this->input->post("country"); //

            $alamat = "$alamat1, $alamat2, $postcode, $city, $state, $country";

            if($password != $verifypassword){
                $data = array(
                    'message'  => "Kata laluan tidak sama dengan semak kata laluan",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pengguna'
                );
                $this->load->view('daftar_pekerja',$data);
            }else{
                $pekerjaid = $this->sppuk_model->generatePekerjaId();

                if(!file_exists("./uploads/$pekerjaid/profile_pic/")){
                    mkdir("./uploads/$pekerjaid/profile_pic/", 0777, true);
                }

                //Load the Upload Library and set the configuration
                $pic_config = array(
                    'upload_path' => "./uploads/$pekerjaid/profile_pic/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => TRUE,
                    'max_size' => 2048000, //max 2mb
                    'max_width' => 2048,
                    'max_height' => 2048
                );
                $this->load->library('upload',$pic_config);

                $regdata = array(
                    'id'   => $pekerjaid,
                    'password' => $hash_password,
                    'role' => "pekerja",
                    'status' => "Pending"
                );
                $regdata2 = array(
                    'id'   => $pekerjaid,
                    'id_majikan' => $majikanId,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'tarikh_lahir' => $birthdate,
                    'emel' => $email,
                    'no_telefon' => $phoneno,
                    'jantina' => $jantina,
                    'status_perkahwinan' => $statuskahwin,
                    'kelayakan' => $kelayakan,
                    'picture' => $gambar
                );

                if($this->upload->do_upload('gambar')){
                    $uploadPhoto = array('upload_data' => $this->upload->data());
                    $result = $this->sppuk_model->daftarPekerja($regdata, $regdata2);
                }else{
                    $result = "UPLOAD_FAILED";
                }

                if($result == "OK"){
                    $data = array(
                        'message'  => "Pendaftaran berjaya! Sila tunggu email daripada majikan apabila pendaftaran anda sama ada diluluskan atau tidak.",
                        'messagetype' => "success",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pengguna'
                    );

                    $this->load->view('daftar_pekerja',$data);

                }else if($result == "UPLOAD_FAILED"){
                    $data = array(
                        'message'  => "Muat naik gambar gagal! Sila pastikan ia fail jenis gambar yang betul dengan saiz fail kurang daripada 2MB.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pengguna'
                    );

                    $this->load->view('daftar_pekerja',$data);
                }
                else{
                    $data = array(
                        'message'  => "Kesilapan Teknikal.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pengguna'
                    );

                    $this->load->view('daftar_pekerja',$data);
                }
            }
        }
        else {
            $this->load->view('daftar_pekerja',$data);
        }
    }

    //Log Out DONE
    public function logout(){
        $this->load->view('logout',$data);
    }
    

    /*                                  SYS ADMIN                                     */

    //List Majikan DONE
    public function list_majikan(){
        $data['result'] = $this->sppuk_model->listMajikan(null, null, null);
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Majikan';
        $this->load->view('list_majikan',$data);
    }

    //Add New Majikan DONE
    public function tambah_majikan(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Tambah Majikan Baharu';
        if ($this->input->post('submit-btn')) {
            $nama = $this->input->post("nama");
            $alamat = $this->input->post("alamat");
            $email = $this->input->post("email");
            $phoneno = $this->input->post("phoneno");
            $password = $this->input->post("password");
            $verifypassword = $this->input->post("verifypassword");
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $bil_max_pekerja = $this->input->post("bilmaxpekerja");
            $nama_pic = $this->input->post("namapic");
            $email_pic = $this->input->post("emailpic");
            $no_tel_pic = $this->input->post("notelpic");

            if($password != $verifypassword){
                $data = array(
                    'message'  => "Kata laluan tidak sama dengan semak kata laluan",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Tambah Majikan Baharu'
                );
                $this->load->view('tambah_majikan',$data);
            }else{
                $majikanid = $this->sppuk_model->generateMajikanId();

                $regdata = array(
                    'id'   => $majikanid,
                    'password' => $hash_password,
                    'role' => "majikan",
                    'status' => "Active"
                );
                $regdata2 = array(
                    'id'   => $majikanid,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'emel' => $email,
                    'no_telefon' => $phoneno,
                    'bil_max_pekerja' => $bil_max_pekerja,
                    'nama_pic' => $nama_pic,
                    'emel_pic' => $email_pic,
                    'no_tel_pic' => $no_tel_pic
                );

                $result = $this->sppuk_model->createMajikan($regdata, $regdata2);

                if($result == "OK"){
                    $data = array(
                        'message'  => "Tambah majikan berjaya! E-Mel Pendaftaran dihantar kepada majikan.",
                        'messagetype' => "success",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Majikan',
                        'result' => $this->sppuk_model->listMajikan(null, null, null)
                    );

                    $this->load->view('list_majikan',$data);

                }
                else{
                    $data = array(
                        'message'  => "Kesilapan Teknikal.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Tambah Majikan Baharu'
                    );

                    $this->load->view('tambah_majikan',$data);
                }
            }
        }else {
            $this->load->view('tambah_majikan',$data);
        }
    }

    //View/Edit Majikan Profile DONE
    public function view_majikan(){ 
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Lihat Majikan';
        if ($this->input->post('submit-btn')) {
            $majikanId = $this->uri->segment(3);
            $data['result'] = $this->sppuk_model->getMajikanById(array('id' => $majikanId), null, null);
            if($data['result'] == TRUE){
                $nama = $this->input->post("nama");
                $alamat = $this->input->post("alamat");
                $email = $this->input->post("email");
                $phoneno = $this->input->post("phoneno");
                $bil_max_pekerja = $this->input->post("bilmaxpekerja");
                $nama_pic = $this->input->post("namapic");
                $email_pic = $this->input->post("emailpic");
                $no_tel_pic = $this->input->post("notelpic");
                
                $regdata = array(
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'emel' => $email,
                    'no_telefon' => $phoneno,
                    'bil_max_pekerja' => $bil_max_pekerja,
                    'nama_pic' => $nama_pic,
                    'emel_pic' => $email_pic,
                    'no_tel_pic' => $no_tel_pic
                );
                $result = $this->sppuk_model->updateMajikan($majikanId, $regdata);

                if($result == "OK"){
                    $data = array(
                        'message'  => "Kemaskini majikan berjaya!",
                        'messagetype' => "success",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Majikan',
                        'result' => $this->sppuk_model->listMajikan(null, null, null)
                    );

                    $this->load->view('list_majikan',$data);

                }
                else{
                    $data = array(
                        'message'  => "Kesilapan Teknikal.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Tambah Majikan Baharu'
                    );

                    $id = $this->uri->segment(3);
                    $data['result'] = $this->sppuk_model->getMajikanById(array('id' => $id), null, null);
                    if($data['result'] == TRUE){
                        $this->load->view('view_majikan',$data);
                    }else{
                        $data = array(
                            'message'  => "Maaf, ID Majikan tidak dijumpai.",
                            'messagetype' => "err",
                            'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Majikan',
                            'result' => $this->sppuk_model->listMajikan(null, null, null)
                        );
    
                        $this->load->view('list_majikan',$data);
                    }
                }
            }
        }else {
            $id = $this->uri->segment(3);
            $data['result'] = $this->sppuk_model->getMajikanById(array('id' => $id), null, null);
            if($data['result'] == TRUE){
                $this->load->view('view_majikan',$data);
            }else{
                $data = array(
                    'message'  => "Maaf, ID Majikan tidak dijumpai.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Majikan',
                    'result' => $this->sppuk_model->listMajikan(null, null, null)
                );

                $this->load->view('list_majikan',$data);
            }
        }
    }
    
    //Buang Majikan
    public function buang_majikan(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Buang Majikan';
        if ($this->input->post('submit-btn')) {
            $majikanId = $this->uri->segment(3);
            $data['result'] = $this->sppuk_model->getMajikanById(array('id' => $majikanId), null, null);

            if($data['result'] == TRUE){

                //Step 1: Read all pekerja in the majikan
                $listPekerja = $this->sppuk_model->listPekerjaByMajikan($majikanId);

                foreach ($listPekerja as $record):

                    $pekerjaId = $record->id;

                    //Step 2: Read all ujian information from pekerja
                    $listUjian = $this->sppuk_model->listUjian($pekerjaId);

                    foreach($listUjian as $record2):
                        $ujianId = $record2->id;

                        $removePersonality = $this->sppuk_model->deletePersonalitiPekerjaByUjianId($ujianId);
                        $removeSoalanUjian = $this->sppuk_model->deleteSoalanUjian($ujianId);
                        $removeUjian = $this->sppuk_model->deleteUjian($ujianId, $pekerjaId);
                    endforeach;

                    $removePekerja = $this->sppuk_model->deletePekerja($pekerjaId);
                endforeach;
                
                //Step 3: Remove all Soalan In Majikan
                $removeSoalan = $this->sppuk_model->deleteAllSoalanInMajikan($majikanId);

                //Step 4: Remove The Majikan
                $removeMajikan = $this->sppuk_model->deleteMajikan($majikanId);

                if($removeMajikan == TRUE){
                    $data = array(
                        'message'  => "Majikan berjaya dibuang daripada sistem!",
                        'messagetype' => "success",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Majikan',
                        'result' => $this->sppuk_model->listMajikan(null, null, null)
                    );

                    $this->load->view('list_majikan',$data);

                }
                else{
                    $data = array(
                        'message'  => "Kesilapan Teknikal.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Tambah Majikan Baharu'
                    );

                    $id = $this->uri->segment(3);
                    $data['result'] = $this->sppuk_model->getMajikanById(array('id' => $id), null, null);
                    if($data['result'] == TRUE){
                        $this->load->view('buang_majikan',$data);
                    }else{
                        $data = array(
                            'message'  => "Maaf, ID Majikan tidak dijumpai.",
                            'messagetype' => "err",
                            'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Majikan',
                            'result' => $this->sppuk_model->listMajikan(null, null, null)
                        );
    
                        $this->load->view('list_majikan',$data);
                    }
                }
            }
        }else {
            $id = $this->uri->segment(3);
            $data['result'] = $this->sppuk_model->getMajikanById(array('id' => $id), null, null);
            if($data['result'] == TRUE){
                $this->load->view('buang_majikan',$data);
            }else{
                $data = array(
                    'message'  => "Maaf, ID Majikan tidak dijumpai.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Majikan',
                    'result' => $this->sppuk_model->listMajikan(null, null, null)
                );

                $this->load->view('list_majikan',$data);
            }
        }
    }

    //List Of Soalan Ujian (Pending) DONE
    public function verify_soalan(){
        $data['result'] = $this->sppuk_model->listPendingSoalan();
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pengesahan Soalan Ujian';
        $this->load->view('verify_soalan',$data);
    }

    //Accept Soalan Ujian
    public function accept_soalan(){
        $status = "Approved";
        $soalanId = $this->uri->segment(3);
        $data['result'] = $this->sppuk_model->getPendingSoalanById(array('id' => $soalanId),  null, null);
        
        if($data['result'] == TRUE){
            $soalanInfo = $this->sppuk_model->getSoalanByIdNoMajikan(array('id' => $soalanId), null, null);
            $soalan_name = $soalanInfo[0]->nama;
            $soalan_majikan = $soalanInfo[0]->id_majikan;

            $majikanInfo = $this->sppuk_model->getMajikanById(array('id' => $soalan_majikan), null, null);
            $majikan_email = $majikanInfo[0]->emel;
            $majikan_name = $majikanInfo[0]->nama;
            $regdata = array('status' => $status);

            $result = $this->sppuk_model->verifySoalan($soalanId, $regdata);

            if($result == "OK"){

                require 'assets/plugins/phpmailer/PHPMailerAutoload.php';

                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kckalai.ra004.it@gmail.com';
                $mail->Password = 'jkees2017';
                $mail->SMTPSecure = 'tls'; 
                $mail->Port = 587;

                $mail->From = 'kckalai.ra004.it@gmail.com';
                $mail->FromName = "SPPUK No-Reply";
                $mail->addAddress("yushairie_simcity@yahoo.com",$majikan_name);
                //$mail->addAddress($majikan_email,$majikan_name);

                $mail->isHTML(true);

                $contents = "<h4>Ini adalah mesej automatik daripada pentadbir Sistem Pengurusan Personaliti & Ujian Kendiri.</h4>";
                $contents .= "<br>Pihak pentadbir sistem telah meluluskan soalan yang bernama \"<b>$soalan_name</b>\" di dalam sistem bagi<br>";
                $contents .= "majikan anda bernama $majikan_name. Pekerja majikan anda dibenarkan untuk menjawab soalan ini.<br>";
                $contents .= "Sekian, terima kasih.<br>";

                $mail->Subject = 'SPPUK: Soalan Ujian Disahkan';
                $mail->Body    = $contents;

                $mail->send();

                $data = array(
                    'message'  => "Soalan personaliti ini telah disahkan dan boleh dijawab oleh pekerja!",
                    'messagetype' => "success",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pengesahan Soalan Ujian',
                    'result' => $this->sppuk_model->listPendingSoalan()
                );

                $this->load->view('verify_soalan',$data);
            }
            else{
                $data = array(
                    'message'  => "Kesilapan Teknikal.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pengesahan Soalan Ujian',
                    'result' => $this->sppuk_model->listPendingSoalan()
                );
    
                $this->load->view('verify_soalan',$data);
            }
        }else {
            $data = array(
                'message'  => "Maaf, ID Soalan tidak dijumpai.",
                'messagetype' => "err",
                'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pengesahan Soalan Ujian',
                'result' => $this->sppuk_model->listPendingSoalan()
            );
    
            $this->load->view('verify_soalan',$data);
        }
    }

    //Reject Soalan Ujian
    public function reject_soalan(){
        $status = "Rejected";
        $soalanId = $this->uri->segment(3);
        $data['result'] = $this->sppuk_model->getPendingSoalanById(array('id' => $soalanId),  null, null);
        if($data['result'] == TRUE){
            $soalanInfo = $this->sppuk_model->getSoalanByIdNoMajikan(array('id' => $soalanId), null, null);
            $soalan_name = $soalanInfo[0]->nama;
            $soalan_majikan = $soalanInfo[0]->id_majikan;

            $majikanInfo = $this->sppuk_model->getMajikanById(array('id' => $soalan_majikan), null, null);
            $majikan_email = $majikanInfo[0]->emel;
            $majikan_name = $majikanInfo[0]->nama;
            $regdata = array('status' => $status);

            $result = $this->sppuk_model->verifySoalan($soalanId, $regdata);

            if($result == "OK"){

                require 'assets/plugins/phpmailer/PHPMailerAutoload.php';

                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kckalai.ra004.it@gmail.com';
                $mail->Password = 'jkees2017';
                $mail->SMTPSecure = 'tls'; 
                $mail->Port = 587;

                $mail->From = 'kckalai.ra004.it@gmail.com';
                $mail->FromName = "SPPUK No-Reply";
                $mail->addAddress("yushairie_simcity@yahoo.com",$majikan_name);
                //$mail->addAddress($majikan_email,$majikan_name);

                $mail->isHTML(true);

                $contents = "<h4>Ini adalah mesej automatik daripada pentadbir Sistem Pengurusan Personaliti & Ujian Kendiri.</h4>";
                $contents .= "<br>Pihak pentadbir sistem telah membatal permohonan soalan yang bernama \"<b>$soalan_name</b>\" untuk <br>";
                $contents .= "majikan anda bernama $majikan_name kerana ia tidak memenuhi piawai atau syarat sebagai soalan personaliti.<br>";
                $contents .= "Mohon kerjasama untuk mengemaskini soalan tersebut atau membuang soalan tersebut jika tidak perlu.<br>";
                $contents .= "Sekian, terima kasih.<br>";

                $mail->Subject = 'SPPUK: Soalan Ujian Dibatalkan';
                $mail->Body    = $contents;

                $mail->send();

                $data = array(
                    'message'  => "Soalan personaliti ini telah ditolak dan majikan telah diberitahu untuk kemaskini soalan ini.",
                    'messagetype' => "success",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pengesahan Soalan Ujian',
                    'result' => $this->sppuk_model->listPendingSoalan()
                );

                $this->load->view('verify_soalan',$data);
            }
            else{
                $data = array(
                    'message'  => "Kesilapan Teknikal.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pengesahan Soalan Ujian',
                    'result' => $this->sppuk_model->listPendingSoalan()
                );
    
                $this->load->view('verify_soalan',$data);
            }
        }else {
            $data = array(
                'message'  => "Maaf, ID Soalan tidak dijumpai.",
                'messagetype' => "err",
                'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pengesahan Soalan Ujian',
                'result' => $this->sppuk_model->listPendingSoalan()
            );
    
            $this->load->view('verify_soalan',$data);
        }
    }


    /*                                  MAJIKAN                                     */

    //List Of Soalan Ujian DONE
    public function soalan_ujian(){
        $data['result'] = $this->sppuk_model->listSoalan($this->session->sppuk_logged_in);
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Soalan-Soalan Ujian';
        $this->load->view('soalan_ujian',$data);
    }

    //Tambah Soalan DONE
    public function tambah_soalan(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Tambah Soalan Ujian';
        if ($this->input->post('submit-btn')) {
            $nama = $this->input->post("namasoalan");
            $algorithm = $this->input->post("algorithm");
            $majikanId = $this->input->post("majikanid");
            $pemberat = $this->input->post("pemberat");
            $tarikh_buat = date("Y-m-d");
            $masa_buat = date("H:i:s");

            $regdata = array(
                'id_majikan' => $majikanId,
                'nama' => $nama,
                'algorithm' => $algorithm,
                'pemberat' => $pemberat,
                'status' => "Pending",
                'tarikh_buat' => $tarikh_buat,
                'masa_buat' => $masa_buat
            );

            $result = $this->sppuk_model->createSoalan($regdata);

            if($result == "OK"){
                $data = array(
                    'message'  => "Tambah soalan berjaya! Ia perlu disemak dan disahkan oleh Pentadbir Sistem sebelum soalan ini dibuka untuk menjawab.",
                    'messagetype' => "success",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Soalan Ujian',
                    'result' => $this->sppuk_model->listSoalan($this->session->sppuk_logged_in)
                );
                $this->load->view('soalan_ujian',$data);

            }
            else if($result == "DB_ERROR"){
                $data = array(
                    'message'  => "Kesilapan Teknikal.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Tambah Soalan Ujian'
                );

                $this->load->view('tambah_soalan',$data);
            }
        }else {
            $this->load->view('tambah_soalan',$data);
        }
    }

    //View/Edit Soalan Ujian DONE
    public function view_soalan(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Lihat Soalan Ujian';
        if ($this->input->post('submit-btn')) {
            $soalanId = $this->uri->segment(3);
            $majikanId = $this->session->sppuk_logged_in;
            $data['result'] = $this->sppuk_model->getSoalanById(array('id' => $soalanId), $majikanId, null, null);
            if($data['result'] == TRUE){
                $nama = $this->input->post("namasoalan");
                $algorithm = $this->input->post("algorithm");
                $pemberat = $this->input->post("pemberat");
                $tarikh_buat = date("Y-m-d");
                $masa_buat = date("H:i:s");
                
                $regdata = array(
                    'id_majikan' => $majikanId,
                    'nama' => $nama,
                    'algorithm' => $algorithm,
                    'pemberat' => $pemberat,
                    'status' => "Pending",
                    'tarikh_buat' => $tarikh_buat,
                    'masa_buat' => $masa_buat
                );
                $result = $this->sppuk_model->updateSoalan($soalanId, $regdata);

                if($result == "OK"){
                    $data = array(
                        'message'  => "Kemaskini soalan berjaya! Namun, ia perlu disemak dan disahkan oleh Pentadbir Sistem sebelum soalan ini dibuka untuk menjawab.",
                        'messagetype' => "success",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Soalan Ujian',
                        'result' => $this->sppuk_model->listSoalan($this->session->sppuk_logged_in)
                    );

                    $this->load->view('soalan_ujian',$data);

                }
                else{
                    $data = array(
                        'message'  => "Kesilapan Teknikal.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Lihat Soalan Ujian'
                    );

                    $id = $this->uri->segment(3);
                    $majikanId = $this->session->sppuk_logged_in;
                    $data['result'] = $this->sppuk_model->getSoalanById(array('id' => $id), $majikanId, null, null);
                    if($data['result'] == TRUE){
                        $this->load->view('view_soalan',$data);
                    }else{
                        $data = array(
                            'message'  => "Maaf, ID Soalan tidak dijumpai.",
                            'messagetype' => "err",
                            'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Soalan Ujian',
                            'result' => $this->sppuk_model->listSoalan($majikanId)
                        );

                        $this->load->view('soalan_ujian',$data);
                    }
                }
            }
        }else {
            $id = $this->uri->segment(3);
            $majikanId = $this->session->sppuk_logged_in;
            $data['result'] = $this->sppuk_model->getSoalanById(array('id' => $id), $majikanId, null, null);
            if($data['result'] == TRUE){
                $this->load->view('view_soalan',$data);
            }else{
                $data = array(
                    'message'  => "Maaf, ID Soalan tidak dijumpai.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Soalan Ujian',
                    'result' => $this->sppuk_model->listSoalan($majikanId)
                );

                $this->load->view('soalan_ujian',$data);
            }
        }
    }

    //Remove Soalan DONE
    public function buang_soalan(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Buang Soalan';
        if ($this->input->post('submit-btn')) {
            $id = $this->uri->segment(3);
            $result = $this->sppuk_model->deleteSoalan($id);

            if($result == TRUE){
                $data = array(
                    'message'  => "Buang soalan berjaya!",
                    'messagetype' => "success",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Soalan Ujian',
                    'result' => $this->sppuk_model->listSoalan($this->session->sppuk_logged_in)
                );

                $this->load->view('soalan_ujian',$data);

            }
        }else {
            $id = $this->uri->segment(3);
            $majikanId = $this->session->sppuk_logged_in;
            $data['result'] = $this->sppuk_model->getSoalanById(array('id' => $id), $majikanId, null, null);
            if($data['result'] == TRUE){
                $this->load->view('buang_soalan',$data);
            }else{
                $data = array(
                    'message'  => "Maaf, ID Soalan tidak dijumpai.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Soalan Ujian',
                    'result' => $this->sppuk_model->listSoalan($majikanId)
                );

                $this->load->view('soalan_ujian',$data);
            }
        }
    }

    //List Of Pekerja (Not Regietered) DONE
    public function verify_pekerja(){
        $data['result'] = $this->sppuk_model->listPekerjaNewRegister($this->session->sppuk_logged_in);
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pekerja';
        $this->load->view('verify_pekerja',$data);
    }

    //Verify/Reject New Pekerja
    public function view_pekerja_reg(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pekerja';
        if ($this->input->post('accept-btn')) {
            $status = "Active";
            $id = $this->uri->segment(3);
            $majikanId = $this->session->sppuk_logged_in;
            $majikanInfo = $this->sppuk_model->getMajikanById(array('id' => $majikanId), null, null);
            $majikan_email = $majikanInfo[0]->emel;
            $majikan_name = $majikanInfo[0]->nama;
            
            

            $data['result'] = $this->sppuk_model->getPekerjaRegById($id, $majikanId, null, null);
            if($data['result'] == TRUE){
                $pekerjaInfo = $this->sppuk_model->getPekerjaRegById($id, $majikanId, null, null);
                $pekerja_email = $pekerjaInfo[0]->emel;
                $pekerja_name = $pekerjaInfo[0]->nama;
                $regdata = array('status' => $status);
                $result = $this->sppuk_model->verifyPekerja($id, $regdata);

                if($result == "OK"){

                    //TBA Send Registration E-Mail
                    require 'assets/plugins/phpmailer/PHPMailerAutoload.php';

                    $mail = new PHPMailer;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'kckalai.ra004.it@gmail.com';
                    $mail->Password = 'jkees2017';
                    $mail->SMTPSecure = 'tls'; 
                    $mail->Port = 587;

                    $mail->From = 'kckalai.ra004.it@gmail.com';
                    $mail->FromName = "SPPUK No-Reply";
                    $mail->addAddress("yushairie_simcity@yahoo.com",$pekerja_name);
                    //$mail->addAddress($pekerja_email,$pekerja_name);

                    $mail->isHTML(true);

                    $contents = "<h4>Ini adalah mesej automatik daripada majikan Sistem Pengurusan Personaliti & Ujian Kendiri bernama $majikan_name</h4>";
                    $contents .= "<br>Majikan syarikat ini telah <b>MELULUSKAN</b> permohonan sebagai pekerja majikan untuk<br>";
                    $contents .= "mengakses ke sistem pengurusan personaliti dan ujian kendiri.<br>";
                    $contents .= "Anda boleh mengakses ke dalam sistem dan mulakan ujian personaliti anda.<br>";
                    $contents .= "Jika anda mempunyai masalah berkaitan dengan personaliti pekerja, anda boleh menghantar emel kepada majikan: <br>";
                    $contents .= "<a href='mailto:$majikan_email'>$majikan_email</a><br>";
                    $contents .= "Sekian, terima kasih.<br>";

                    $mail->Subject = 'SPPUK: Pendaftaran Pekerja Berjaya';
                    $mail->Body    = $contents;

                    $mail->send();

                    $data = array(
                        'message'  => "Pekerja ini berjaya disahkan dan email pendaftaran dihantar kepada pekerja.",
                        'messagetype' => "success",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pekerja',
                        'result' => $this->sppuk_model->listPekerjaNewRegister($this->session->sppuk_logged_in)
                    );

                    $this->load->view('verify_pekerja',$data);
                }
                else{
                    $id = $this->uri->segment(3);
                    $majikanId = $this->session->sppuk_logged_in;
                    $data['result'] = $this->sppuk_model->getPekerjaRegById($id, $majikanId, null, null);
                    if($data['result'] == TRUE){
                        $data = array(
                            'message'  => "Kesilapan Teknikal.",
                            'messagetype' => "err",
                            'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pekerja'
                        );
            
                        $this->load->view('view_pekerja_reg',$data);
                    }else{
                        $data = array(
                            'message'  => "Maaf, ID Pekerja tidak dijumpai.",
                            'messagetype' => "err",
                            'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pekerja',
                            'result' => $this->sppuk_model->listPekerjaNewRegister($this->session->sppuk_logged_in)
                        );

                        $this->load->view('verify_pekerja',$data);
                    }
                    
                }
            }

        }else if($this->input->post('reject-btn')){
            $status = "Rejected";
            $id = $this->uri->segment(3);
            $majikanId = $this->session->sppuk_logged_in;
            $majikanInfo = $this->sppuk_model->getMajikanById(array('id' => $majikanId), null, null);
            $majikan_email = $majikanInfo[0]->emel;
            $majikan_name = $majikanInfo[0]->nama;

            $data['result'] = $this->sppuk_model->getPekerjaRegById($id, $majikanId, null, null);
            if($data['result'] == TRUE){
                $result = $this->sppuk_model->deletePekerja($id);

                if($result == TRUE){
                    $data = array(
                        'message'  => "Pendaftaran pekerja berjaya dibatalkan dan telah dibuang daripada sistem.",
                        'messagetype' => "success",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pekerja',
                        'result' => $this->sppuk_model->listPekerjaNewRegister($this->session->sppuk_logged_in)
                    );

                    $this->load->view('verify_pekerja',$data);

                }
                else{
                    $id = $this->uri->segment(3);
                    $majikanId = $this->session->sppuk_logged_in;
                    $data['result'] = $this->sppuk_model->getPekerjaRegById($id, $majikanId, null, null);
                    if($data['result'] == TRUE){
                        $data = array(
                            'message'  => "Kesilapan Teknikal.",
                            'messagetype' => "err",
                            'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pekerja'
                        );
            
                        $this->load->view('view_pekerja_reg',$data);
                    }else{
                        $data = array(
                            'message'  => "Maaf, ID Pekerja tidak dijumpai.",
                            'messagetype' => "err",
                            'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pekerja',
                            'result' => $this->sppuk_model->listPekerjaNewRegister($this->session->sppuk_logged_in)
                        );

                        $this->load->view('verify_pekerja',$data);
                    }
                    
                }
            }

        }else{
            $id = $this->uri->segment(3);
            $majikanId = $this->session->sppuk_logged_in;
            $data['result'] = $this->sppuk_model->getPekerjaRegById($id, $majikanId, null, null);
            if($data['result'] == TRUE){
                $this->load->view('view_pekerja_reg',$data);
            }else{
                $data = array(
                    'message'  => "Maaf, ID Pekerja tidak dijumpai.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Pendaftaran Pekerja',
                    'result' => $this->sppuk_model->listPekerjaNewRegister($majikanId)
                );

                $this->load->view('verify_pekerja',$data);
            }
        }
    }

    //List Of Pekerja (Regietered) DONE
    public function list_pekerja(){
        $data['result'] = $this->sppuk_model->listPekerjaByMajikan($this->session->sppuk_logged_in);
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Pekerja';
        $this->load->view('list_pekerja',$data);
    }

    //View/Edit Pekerja Profile DONE
    public function view_pekerja(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Maklumat Pekerja';
        $majikanId = $this->session->sppuk_logged_in;

        if ($this->input->post('submit-btn')) {
            $nama = $this->input->post("nama");
            $pekerjaid = $this->input->post("pekerjaid");
            $email = $this->input->post("email");
            $jantina = $this->input->post("jantina");
            $phoneno = $this->input->post("phoneno");
            $statuskahwin = $this->input->post("statuskahwin");
            $kelayakan = $this->input->post("kelayakan");
            $birthdate = $this->input->post("birthdate");
            $gambar = $_FILES['gambar']['name'];
            $alamat = $this->input->post("alamat");

            if($gambar != NULL){
                $regdata2 = array(
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'tarikh_lahir' => $birthdate,
                    'emel' => $email,
                    'no_telefon' => $phoneno,
                    'jantina' => $jantina,
                    'status_perkahwinan' => $statuskahwin,
                    'kelayakan' => $kelayakan,
                    'picture' => $gambar
                );
    
                if(!file_exists("./uploads/$pekerjaid/profile_pic/")){
                    mkdir("./uploads/$pekerjaid/profile_pic/", 0777, true);
                }
    
                //Load the Upload Library and set the configuration
                $pic_config = array(
                    'upload_path' => "./uploads/$pekerjaid/profile_pic/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => TRUE,
                    'max_size' => 2048000, //max 2mb
                    'max_width' => 2048,
                    'max_height' => 2048
                );
                $this->load->library('upload',$pic_config);
    
                if($this->upload->do_upload('gambar')){
                    $uploadPhoto = array('upload_data' => $this->upload->data());
                    $result = $this->sppuk_model->updateProfilPekerjaFromMajikan($pekerjaid, $majikanId, $regdata2);
                    //Remove old file
                    unlink("./uploads/$pekerjaid/profile_pic/$oldgambar");
                }else{
                    $result = "UPLOAD_FAILED";
                }
            }else{
                $regdata2 = array(
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'tarikh_lahir' => $birthdate,
                    'emel' => $email,
                    'no_telefon' => $phoneno,
                    'jantina' => $jantina,
                    'status_perkahwinan' => $statuskahwin,
                    'kelayakan' => $kelayakan
                );

                $result = $this->sppuk_model->updateProfilPekerjaFromMajikan($pekerjaid, $majikanId, $regdata2);
            }

            if($result == "OK"){
                $id = $this->uri->segment(3);
                $data = array(
                    'message'  => "Kemaskini Profil Berjaya!",
                    'messagetype' => "success",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Maklumat Pekerja',
                    'result' => $this->sppuk_model->getPekerjaById($id, $majikanId, null, null)
                );

                if($data['result'] == TRUE){
                    $this->load->view('view_pekerja',$data);
                }else{
                    $data = array(
                        'message'  => "Maaf, ID Pekerja tidak dijumpai.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Pekerja',
                        'result' => $this->sppuk_model->listPekerjaByMajikan($majikanId)
                    );
        
                    $this->load->view('list_pekerja',$data);
                }

            }else if($result == "UPLOAD_FAILED"){
                $id = $this->uri->segment(3);
                $data = array(
                    'message'  => "Muat naik gambar gagal! Sila pastikan ia fail jenis gambar yang betul dengan saiz fail kurang daripada 2MB.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Maklumat Pekerja',
                    'result' => $this->sppuk_model->getPekerjaById($id, $majikanId, null, null)
                );

                if($data['result'] == TRUE){
                    $this->load->view('view_pekerja',$data);
                }else{
                    $data = array(
                        'message'  => "Maaf, ID Pekerja tidak dijumpai.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Pekerja',
                        'result' => $this->sppuk_model->listPekerjaByMajikan($majikanId)
                    );
        
                    $this->load->view('list_pekerja',$data);
                }
            }
            else if($result == "DB_ERROR"){
                $id = $this->uri->segment(3);
                $data = array(
                    'message'  => "Kesilapan Teknikal.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Maklumat Pekerja',
                    'result' => $this->sppuk_model->getPekerjaById($id, $majikanId, null, null)
                );

                if($data['result'] == TRUE){
                    $this->load->view('view_pekerja',$data);
                }else{
                    $data = array(
                        'message'  => "Maaf, ID Pekerja tidak dijumpai.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Pekerja',
                        'result' => $this->sppuk_model->listPekerjaByMajikan($majikanId)
                    );
        
                    $this->load->view('list_pekerja',$data);
                }
            }
        }else{
            $id = $this->uri->segment(3);
            $data['result'] = $this->sppuk_model->getPekerjaById($id, $majikanId, null, null);
            if($data['result'] == TRUE){
                $this->load->view('view_pekerja',$data);
            }else{
                $data = array(
                    'message'  => "Maaf, ID Pekerja tidak dijumpai.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Pekerja',
                    'result' => $this->sppuk_model->listPekerjaByMajikan($majikanId)
                );
    
                $this->load->view('list_pekerja',$data);
            }
        }
    }

    //Remove Pekerja
    public function buang_pekerja(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Buang Pekerja';
        if ($this->input->post('submit-btn')) {
            $id = $this->uri->segment(3);
            
            //Step 1: Read all ujian information from pekerja
            $listUjian = $this->sppuk_model->listUjian($id);

            foreach($listUjian as $record2):
                $ujianId = $record2->id;

                $removePersonality = $this->sppuk_model->deletePersonalitiPekerjaByUjianId($ujianId);
                $removeSoalanUjian = $this->sppuk_model->deleteSoalanUjian($ujianId);
                $removeUjian = $this->sppuk_model->deleteUjian($ujianId, $id);
            endforeach;

            $result = $this->sppuk_model->deletePekerja($id);

            if($result == TRUE){
                $data = array(
                    'message'  => "Buang pekerja berjaya!",
                    'messagetype' => "success",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Pekerja',
                    'result' => $this->sppuk_model->listPekerjaByMajikan($majikanId)
                );

                $this->load->view('list_pekerja',$data);

            }
        }else {
            $id = $this->uri->segment(3);
            $majikanId = $this->session->sppuk_logged_in;
            $data['result'] = $this->sppuk_model->getPekerjaById($id, $majikanId, null, null);
            if($data['result'] == TRUE){
                $this->load->view('buang_pekerja',$data);
            }else{
                $data = array(
                    'message'  => "Maaf, ID Pekerja tidak dijumpai.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Pekerja',
                    'result' => $this->sppuk_model->listPekerjaByMajikan($majikanId)
                );
    
                $this->load->view('list_pekerja',$data);
            }
        }
    }

    //Compare Pekerja
    public function compare_pekerja(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Perbandingan Pekerja';
        if ($this->input->post('compare-btn')) {
            $pekerja1 = $this->input->post("pekerja-1");
            $pekerja2 = $this->input->post("pekerja-2");

            if($pekerja1 == $pekerja2){
                $data = array(
                    'message'  => "Perbandingan pekerja tidak boleh sama.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Perbandingan Pekerja'
                );
                $this->load->view('compare_pekerja',$data);
            }else{

                $ujianInfo1 = $this->sppuk_model->getLatestUjianInfo($pekerja1);
                $ujianInfo2 = $this->sppuk_model->getLatestUjianInfo($pekerja2);

                if($ujianInfo1 == FALSE){
                    $data = array(
                        'message'  => "Pekerja #1 belum lagi menjalani ujian personaliti.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Perbandingan Pekerja'
                    );
                }else{
                   if($ujianInfo2 == FALSE){
                        $data = array(
                            'message'  => "Pekerja #2 belum lagi menjalani ujian personaliti.",
                            'messagetype' => "err",
                            'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Perbandingan Pekerja'
                        );
                   }else{
                        //Add to Session
                        $sesdata = array(
                            'comparePekerja' => TRUE,
                            'comparePekerjaSel1'  => $pekerja1,
                            'comparePekerjaSel2' => $pekerja2,
                        ); 
                        $this->session->set_userdata($sesdata);
                   }
                }
                
                $this->load->view('compare_pekerja',$data);
            }
        }else{
            $this->load->view('compare_pekerja',$data);
        }
        
    }

    //Print Compare Report
    public function comparison_report(){


        if(isset($this->session->comparePekerja)){
            $pekerja1 = $this->session->comparePekerjaSel1;
            $pekerja2 = $this->session->comparePekerjaSel2;

            $pekerjaInfo1 = $this->sppuk_model->getPekerjaById($pekerja1, $this->session->sppuk_logged_in, null, null);
            $pekerjaInfo2 = $this->sppuk_model->getPekerjaById($pekerja2, $this->session->sppuk_logged_in, null, null);

            $ujianInfo1 = $this->sppuk_model->getLatestUjianInfo($pekerja1);
            $ujian1 = $ujianInfo1[0]->id;

            $ujianInfo2 = $this->sppuk_model->getLatestUjianInfo($pekerja2);
            $ujian2 = $ujianInfo2[0]->id;

            $personalityRecord1 = $this->sppuk_model->getLatestPersonalityInfo($ujian1);
            $personalityRecord2 = $this->sppuk_model->getLatestPersonalityInfo($ujian2);

            //Set flags
            $p1points = 0;
            $p2points = 0;

            //Record 
            if($personalityRecord1[0]->extrovert > $personalityRecord2[0]->extrovert){
                $p1_extrovert = true;
                $p2_extrovert = false;
                $p1points += 1;
            }else{
                $p2_extrovert = true;
                $p1_extrovert = false;
                $p2points += 1;
            }
            if($personalityRecord1[0]->introvert > $personalityRecord2[0]->introvert){
                $p1_introvert = true;
                $p2_introvert = false;
                $p1points += 1;
            }else{
                $p2_introvert = true;
                $p1_introvert = false;
                $p2points += 1;
            }

            if($personalityRecord1[0]->intuitive > $personalityRecord2[0]->intuitive){
                $p1_intuitive = true;
                $p2_intuitive = false;
                $p1points += 1;
            }else{
                $p2_intuitive = true;
                $p1_intuitive = false;
                $p2points += 1;
            }

            if($personalityRecord1[0]->observant > $personalityRecord2[0]->observant){
                $p1_observant = true;
                $p2_observant = false;
                $p1points += 1;
            }else{
                $p2_observant = true;
                $p1_observant = false;
                $p2points += 1;
            }

            if($personalityRecord1[0]->thinking > $personalityRecord2[0]->thinking){
                $p1_thinking = true;
                $p2_thinking = false;
                $p1points += 1;
            }else{
                $p2_thinking = true;
                $p1_thinking = false;
                $p2points += 1;
            }

            if($personalityRecord1[0]->feeling > $personalityRecord2[0]->feeling){
                $p1_feeling = true;
                $p2_feeling = false;
                $p1points += 1;
            }else{
                $p2_feeling = true;
                $p1_feeling = false;
                $p2points += 1;
            }

            if($personalityRecord1[0]->judging > $personalityRecord2[0]->judging){
                $p1_judging = true;
                $p2_judging = false;
                $p1points += 1;
            }else{
                $p2_judging = true;
                $p1_judging = false;
                $p2points += 1;
            }

            if($personalityRecord1[0]->prospecting > $personalityRecord2[0]->prospecting){
                $p1_prospecting = true;
                $p2_prospecting = false;
                $p1points += 1;
            }else{
                $p2_prospecting = true;
                $p1_prospecting = false;
                $p2points += 1;
            }

            if($personalityRecord1[0]->assertive > $personalityRecord2[0]->assertive){
                $p1_assertive = true;
                $p2_assertive = false;
                $p1points += 1;
            }else{
                $p2_assertive = true;
                $p1_assertive = false;
                $p2points += 1;
            }

            if($personalityRecord1[0]->turbulent > $personalityRecord2[0]->turbulent){
                $p1_turbulent = true;
                $p2_turbulent = false;
                $p1points += 1;
            }else{
                $p2_turbulent = true;
                $p1_turbulent = false;
                $p2points += 1;
            }

            $data = array(
                'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Cetak Laporan Perbandingan Pekerja',
                'pekerjaid1' => $pekerja1,
                'pekerjaid2' => $pekerja2,
                'pekerjainfo1' => $pekerjaInfo1,
                'pekerjainfo2' => $pekerjaInfo2,
                'ujianinfo1' => $ujianInfo1,
                'ujianinfo2' => $ujianInfo2,
                'p1_points' => $p1points,
                'p2_points' => $p2points
            );

            $this->load->view('comparison_report',$data);
        }else{
            $data = array(
                'message'  => "Silih pilih pekerja #1 & pekerja #2 dulu",
                'messagetype' => "err",
                'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Perbandingan Pekerja',
            );

            $this->load->view('compare_pekerja',$data);
        }  
    }

    /*                                  PEKERJA                                     */

    //Start Ujian Personaliti
    public function start_ujian(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Jawab Ujian Personaliti';
        if ($this->input->post('submit-btn')) {

            $ujianfail = 0;

            //STEP 1: Create The Ujian Entry
            $pekerjaid = $this->input->post("pekerjaid");
            $objektif = $this->input->post("objektif");
            $tarikh_jawab = date("Y-m-d");
            $masa_jawab = date("H:i:s");
            
            $regdata = array(
                'id_pekerja' => $pekerjaid,
                'tarikh_jawab' => $tarikh_jawab,
                'masa_jawab' => $masa_jawab,
                'objektif' => $objektif,
                'status' => "Completed",
            );

            //Create new Ujian & get Ujian ID
            $ujianId = $this->sppuk_model->createUjian($regdata);

            //STEP 2: Read The number of questions
            $profile = $this->sppuk_model->myProfile($this->session->sppuk_logged_in);
            $majikanId = $profile[0]->id_majikan;
            $personalitySoalan = $this->sppuk_model->listAllPersonalityQuestions($majikanId);

            //Count for all soalan by types
            $countJiwa = $this->sppuk_model->countSoalanJiwa($majikanId);
            $countTenaga = $this->sppuk_model->countSoalanTenaga($majikanId);
            $countSifat = $this->sppuk_model->countSoalanSifat($majikanId);
            $countTaktik = $this->sppuk_model->countSoalanTaktik($majikanId);
            $countIdentiti = $this->sppuk_model->countSoalanIdentiti($majikanId);

            $totalJiwa = 0;
            $totalTenaga = 0;
            $totalSifat = 0;
            $totalTaktik = 0;
            $totalIdentiti = 0;

            $pemberatJiwa = 0;
            $pemberatTenaga = 0;
            $pemberatSifat = 0;
            $pemberatTaktik = 0;
            $pemberatIdentiti = 0;

            foreach ($personalitySoalan as $record):
                $soalanId = $record->id;

                //get the Type of Soalan
                $soalanType =  $record->algorithm;

                $qid = $this->input->post("q".$soalanId);

                switch($soalanType){
                    case "Jiwa":
                        $pemberatJiwa = $pemberatJiwa + $record->pemberat;
                        if($qid == 3){  //setuju
                            $totalJiwa = $totalJiwa + $record->pemberat;
                        }else if($qid == 2){    //tidak setuju
                            $totalJiwa = $totalJiwa + (($record->pemberat)/2);
                        }
                    case "Tenaga":
                        $pemberatTenaga = $pemberatTenaga + $record->pemberat;
                        if($qid == 3){  //setuju
                            $totalTenaga = $totalTenaga + $record->pemberat;
                        }else if($qid == 2){    //tidak setuju
                            $totalTenaga = $totalTenaga + (($record->pemberat)/2);
                        }
                        break;
                    case "Sifat":
                        $pemberatSifat = $pemberatSifat + $record->pemberat;
                        if($qid == 3){  //setuju
                            $totalSifat = $totalSifat + $record->pemberat;
                        }else if($qid == 2){    //tidak setuju
                            $totalSifat = $totalSifat + (($record->pemberat)/2);
                        }
                        break;
                    case "Taktik":
                        $pemberatTaktik = $pemberatTaktik + $record->pemberat;
                        if($qid == 3){  //setuju
                            $totalSifat = $totalSifat + $record->pemberat;
                        }else if($qid == 2){    //tidak setuju
                            $totalSifat = $totalSifat + (($record->pemberat)/2);
                        }
                        break;
                    case "Identiti":
                        $pemberatIdentiti = $pemberatIdentiti + $record->pemberat;
                        if($qid == 3){  //setuju
                            $totalIdentiti = $totalIdentiti + $record->pemberat;
                        }else if($qid == 2){    //tidak setuju
                            $totalIdentiti = $totalIdentiti + (($record->pemberat)/2);
                        }
                        break;
                }

                $regdata2 = array(
                    'id_soalan' => $soalanId,
                    'id_ujian' => $ujianId,
                    'answer' => $qid,
                );

                //Create new SoalanUjian
                $soalanUjianResult = $this->sppuk_model->createSoalanUjian($regdata2);

            endforeach;

            if($ujianfail == 0){

                //STEP 3: Produce Result of Personality
                // final = answered weight divide by total weight * 100

                $ex = 0;
                $in = 0;
                $it = 0;
                $ob = 0;
                $tk = 0;
                $fe = 0;
                $ju = 0;
                $pr = 0;
                $as = 0;
                $tu = 0;

                $finalJiwa = ($totalJiwa/$pemberatJiwa)*100;
                $ex = $finalJiwa;                       //Extrovert Score
                $in = 100 - $finalJiwa;                 //Introvert Score

                $finalTenaga = ($totalTenaga/$pemberatTenaga)*100;
                $it = $finalTenaga;                     //Intuitive Score
                $ob = 100 - $finalTenaga;               //Observant Score

                $finalSifat = ($totalSifat/$pemberatSifat)*100;
                $tk = $finalSifat;                      //Thinking Score
                $fe = 100 - $finalSifat;                //Feeling score

                $finalTaktik = ($totalTaktik/$pemberatTaktik)*100;
                $ju = $finalTaktik;                     //Judging Score
                $pr = 100 - $finalTaktik;               //Prospecting Score

                $finalIdentiti = ($totalIdentiti/$pemberatIdentiti)*100;
                $as = $finalIdentiti;                   //Assertive Score
                $tu = 100 - $finalIdentiti;             //Turbulent Score

                //STEP 4: Build the Personality Traits
                $personality = "";
                //Append Introvert/Extrovert
                if($in >= $ex){
                    $personality .= "I";
                }else{
                    $personality .= "E";
                }

                //Append Observant/Intuitive
                if($it >= $ob){
                    $personality .= "N";
                }else{
                    $personality .= "S";
                }

                //Append Feeling/Thinking
                if($tk >= $fe){
                    $personality .= "T";
                }else{
                    $personality .= "F";
                }

                //Append Judging/Prospecting
                if($ju >= $pr){
                    $personality .= "J";
                }else{
                    $personality .= "P";
                }

                //Append Assertive/Turbulent
                if($as >= $tu){
                    $personality .= "-A";
                }else{
                    $personality .= "-T";
                }

                //Step 5: Determine The Role
                if($personality == "INTJ-A" || $personality == "INTJ=T"){
                    $peranan = "Arkitek";
                }else if($personality == "INTP-A" || $personality == "INTP-T"){
                    $peranan = "Pemikir";
                }else if($personality == "ENTJ-A" || $personality == "ENTJ-T"){
                    $peranan = "Panglima";
                }else if($personality == "ENTP-A" || $personality == "ENTP-T"){
                    $peranan = "Pendebat";
                }else if($personality == "INFJ-A" || $personality == "INFJ-T"){
                    $peranan = "Peguam Bela";
                }else if($personality == "INFP-A" || $personality == "INFP-T"){
                    $peranan = "Pengantara";
                }else if($personality == "ENFJ-A" || $personality == "ENFJ-T"){
                    $peranan = "Pemberi";
                }else if($personality == "ENFP-A" || $personality == "ENFP-T"){
                    $peranan = "Juara";
                }else if($personality == "ISTJ-A" || $personality == "ISTJ-T"){
                    $peranan = "Pemeriksa";
                }else if($personality == "ISFJ-A" || $personality == "ISFJ-T"){
                    $peranan = "Pelindung";
                }else if($personality == "ESTJ-A" || $personality == "ESTJ-T"){
                    $peranan = "Pengarah";
                }else if($personality == "ESFJ-A" || $personality == "ESFJ-T"){
                    $peranan = "Pengasuh";
                }else if($personality == "ISTP-A" || $personality == "ISTP-T"){
                    $peranan = "Perajin";
                }else if($personality == "ISFP-A" || $personality == "ISFP-T"){
                    $peranan = "Artis";
                }else if($personality == "ESTP-A" || $personality == "ESTP-T"){
                    $peranan = "Pemujuk";
                }else if($personality == "ESTP-A" || $personality == "ESTP-T"){
                    $peranan = "Pelaku";
                }
                
                //Step 6: Put the Data To the Array
                $regdata3 = array(
                    'id_ujian' => $ujianId,
                    'jenis_personaliti' => $personality,
                    'extrovert' => $ex,
                    'introvert' => $in,
                    'intuitive' => $it,
                    'observant' => $ob,
                    'thinking' => $tk,
                    'feeling' => $fe,
                    'judging' => $ju,
                    'prospecting' => $pr,
                    'assertive' => $as,
                    'turbulent' => $tu,
                    'peranan' => $peranan
                );

                $personalityResult = $this->sppuk_model->createPersonalityInfo($regdata3);

                if($personalityResult == "OK"){
                    $data = array(
                        'message'  => "Anda telah menjawab soalan ujian personaliti!",
                        'messagetype' => "success",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Keputusan Ujian',
                        'result' => $this->sppuk_model->getUjianByIdPekerja($ujianId, $this->session->sppuk_logged_in)
                    );

                    $this->load->view('view_ujian',$data);

                }
                else if($personalityResult == "DB_ERROR"){
                    $data = array(
                        'message'  => "Kesilapan Teknikal.",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Jawab Ujian Personaliti',
                    );

                    $this->load->view('start_ujian',$data);
                }
            }else{
                $data = array(
                    'message'  => "Kesilapan Teknikal.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Jawab Ujian Personaliti',
                );

                $this->load->view('start_ujian',$data);
            }
        }else{
            $this->load->view('start_ujian',$data);
        }
       
    }

    //View/Edit Pekerja Profile DONE
    public function my_profile(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Profil Saya';
        if ($this->input->post('submit-btn')) {
            $nama = $this->input->post("nama");
            $pekerjaid = $this->input->post("pekerjaid");
            $email = $this->input->post("email");
            $majikanId = $this->input->post("majikanid");
            $jantina = $this->input->post("jantina");
            $phoneno = $this->input->post("phoneno");
            $statuskahwin = $this->input->post("statuskahwin");
            $kelayakan = $this->input->post("kelayakan");
            $birthdate = $this->input->post("birthdate");
            $gambar = $_FILES['gambar']['name'];
            $oldgambar = $this->input->post("old_gambar");
            $alamat = $this->input->post("alamat");

            if($gambar != NULL){
                $regdata2 = array(
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'tarikh_lahir' => $birthdate,
                    'emel' => $email,
                    'no_telefon' => $phoneno,
                    'jantina' => $jantina,
                    'status_perkahwinan' => $statuskahwin,
                    'kelayakan' => $kelayakan,
                    'picture' => $gambar
                );
    
                if(!file_exists("./uploads/$pekerjaid/profile_pic/")){
                    mkdir("./uploads/$pekerjaid/profile_pic/", 0777, true);
                }
                //Load the Upload Library and set the configuration
                $pic_config = array(
                    'upload_path' => "./uploads/$pekerjaid/profile_pic/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => TRUE,
                    'max_size' => 2048000, //max 2mb
                    'max_width' => 2048,
                    'max_height' => 2048
                );
                $this->load->library('upload',$pic_config);
    
                if($this->upload->do_upload('gambar')){
                    $uploadPhoto = array('upload_data' => $this->upload->data());
                    $result = $this->sppuk_model->updateProfilPekerja($pekerjaid, $regdata2);
                    //Remove old file
                    unlink("./uploads/$pekerjaid/profile_pic/$oldgambar");
                }else{
                    $result = "UPLOAD_FAILED";
                }
            }else{
                $regdata2 = array(
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'tarikh_lahir' => $birthdate,
                    'emel' => $email,
                    'no_telefon' => $phoneno,
                    'jantina' => $jantina,
                    'status_perkahwinan' => $statuskahwin,
                    'kelayakan' => $kelayakan
                );

                $result = $this->sppuk_model->updateProfilPekerja($pekerjaid, $regdata2);
            }

            if($result == "OK"){
                $data = array(
                    'message'  => "Kemaskini Profil Berjaya!",
                    'messagetype' => "success",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Profil Saya',
                    'result' => $this->sppuk_model->myProfile($this->session->sppuk_logged_in)
                );

                $this->load->view('my_profile',$data);

            }else if($result == "UPLOAD_FAILED"){
                $data = array(
                    'message'  => "Muat naik gambar gagal! Sila pastikan ia fail jenis gambar yang betul dengan saiz fail kurang daripada 2MB.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Profil Saya',
                    'result' => $this->sppuk_model->myProfile($this->session->sppuk_logged_in)
                );

                $this->load->view('my_profile',$data);
            }
            else if($result == "DB_ERROR"){
                $data = array(
                    'message'  => "Kesilapan Teknikal.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Profil Saya',
                    'result' => $this->sppuk_model->myProfile($this->session->sppuk_logged_in)
                );

                $this->load->view('my_profile',$data);
            }
        }else if ($this->input->post('password-btn')) {
            $oldpassword = $this->input->post("oldpassword");
            $password = $this->input->post("password");
            $verifypassword = $this->input->post("verifypassword");
            $hash_password = password_hash($password, PASSWORD_DEFAULT); //

            //Check old password
            $regdata = array(
                'id' => $this->session->sppuk_logged_in
            );
            $oldpassresult = $this->sppuk_model->checkOldPassword($regdata, $oldpassword);

            if($oldpassresult == TRUE){

                if($password != $verifypassword){
                    $data = array(
                        'message'  => "Kata laluan tidak sama dengan semak kata laluan",
                        'messagetype' => "err",
                        'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Profil Saya',
                        'result' => $this->sppuk_model->myProfile($this->session->sppuk_logged_in)
                    );

                }else{
                    //Tukar kata laluan TBA
                }


            }else{
                $data = array(
                    'message'  => "Maaf. Kata laluan lama anda tidak sama.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Profil Saya',
                    'result' => $this->sppuk_model->myProfile($this->session->sppuk_logged_in)
                );

            }

        }else {
            $data['result'] = $this->sppuk_model->myProfile($this->session->sppuk_logged_in);
            $this->load->view('my_profile',$data);
        }
    }

    //Senarai Ujian DONE
    public function senarai_ujian(){
        $data['result'] = $this->sppuk_model->listUjian($this->session->sppuk_logged_in);
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Ujian';
        $this->load->view('senarai_ujian',$data);
    }

     //Result Ujian Info DONE
     public function view_ujian(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Keputusan Ujian';
        $id = $this->uri->segment(3);
        $data['result'] = $this->sppuk_model->getUjianByIdPekerja($id, $this->session->sppuk_logged_in, null, null);
        if($data['result'] == TRUE){
            $this->load->view('view_ujian',$data);
        }else{
            $data = array(
                'message'  => "Maaf, ID Ujian tidak dijumpai.",
                'messagetype' => "err",
                'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Ujian',
                'result' => $this->sppuk_model->listUjian($this->session->sppuk_logged_in)
            );

            $this->load->view('senarai_ujian',$data);
        }
    }

    //Print Personality Report
    public function personality_report(){
        $data['title'] = 'Sistem Pengurusan Personaliti & Ujian Kendiri - Cetak Laporan Personaliti';
        $id = $this->uri->segment(3);
        if($this->session->sppuk_logged_in_role == "pekerja"){
            $data['result'] = $this->sppuk_model->getUjianByIdPekerja($id, $this->session->sppuk_logged_in, null, null);
            if($data['result'] == TRUE){
                $this->load->view('personality_report',$data);
            }else{
                $data = array(
                    'message'  => "Maaf, ID Ujian tidak dijumpai.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Ujian',
                    'result' => $this->sppuk_model->listUjian($this->session->sppuk_logged_in)
                );
    
                $this->load->view('senarai_ujian',$data);
            }
        }else if($this->session->sppuk_logged_in_role == "majikan"){
            
            $data['result'] = $this->sppuk_model->getUjianById($id, null, null);

            if($data['result'] == TRUE){
                $this->load->view('personality_report',$data);
            }else{
                $data = array(
                    'message'  => "Maaf, ID Ujian tidak dijumpai.",
                    'messagetype' => "err",
                    'title' => 'Sistem Pengurusan Personaliti & Ujian Kendiri - Senarai Pekerja',
                    'result' => $this->sppuk_model->listPekerjaByMajikan($this->session->sppuk_logged_in)
                );
    
                $this->load->view('list_pekerja',$data);
            }
        }
        
        
    }

}

?>