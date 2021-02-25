<?php 
class Simpeg
{
   /* Arsip daftar fungsi sistem */

    function week_of_month($date) {
        $date_parts = explode('-', $date);
        $date_parts[2] = '01';
        $first_of_month = implode('-', $date_parts);
        $day_of_first = date('N', strtotime($first_of_month));
        $day_of_month = date('j', strtotime($date));
        return floor(($day_of_first + $day_of_month - 1) / 7) + 1;
    }


    function sebutan($nilaiskp){
        if($nilaiskp<=50) $sebut = "Buruk";
        else if($nilaiskp>50 and $nilaiskp<=60) $sebut = "Sedang";
        else if($nilaiskp>60 and $nilaiskp<=75) $sebut = "Cukup";
        else if($nilaiskp>75 and $nilaiskp<=90) $sebut = "Baik";
        else $sebut = "Sangat Baik";

        return $sebut;
    }
    //konversi nilai KUM PAK --tari
    function konversi($nilaiKUM){
        if($nilaiKUM<150) $masukrange = 100;
        else if($nilaiKUM>=150 and $nilaiKUM<200) $masukrange = 150;
        else if($nilaiKUM>=200 and $nilaiKUM<300) $masukrange = 200;
        else if($nilaiKUM>=300 and $nilaiKUM<400) $masukrange = 300;
        else if($nilaiKUM>=400 and $nilaiKUM<550) $masukrange = 400;
        else if($nilaiKUM>=550 and $nilaiKUM<700) $masukrange = 550;
        else if($nilaiKUM>=700 and $nilaiKUM<850) $masukrange = 700;
        else if($nilaiKUM>=850 and $nilaiKUM<1055)$masukrange = 850;
        else $masukrange = 1055;
        return $masukrange;
    }

    function MAC($_IP_ADDRESS){
    $_IP_SERVER = $_SERVER['SERVER_ADDR'];
    if($_IP_ADDRESS == $_IP_SERVER)
    {
        ob_start();
        system('ipconfig /all');
        $_PERINTAH  = ob_get_contents();
        ob_clean();
        $_PECAH = strpos($_PERINTAH, "Physical");
        $_HASIL = substr($_PERINTAH,($_PECAH+36),17);
        //echo $_HASIL;
    } else {
        $_PERINTAH = "arp -a $_IP_ADDRESS";
        ob_start();
        system($_PERINTAH);
        $_HASIL = ob_get_contents();
        ob_clean();
        $_PECAH = strstr($_HASIL, $_IP_ADDRESS);
        $_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
        $_HASIL = substr($_PECAH_STRING[1], 0, 17);
        //echo "IP Anda : ".$_IP_ADDRESS."
        //MAC ADDRESS Anda : ".$_HASIL;
    }
    return $_HASIL;
    }
    /* 1. Fungsi Modifikasi String */

    // strip semua karakter kecuali huruf dan bilangan
    function alphaNum($item) {
        return preg_replace('/[^a-zA-Z0-9]/', '$1', $item);
    }

    // jika tanggal diisi, ubah formatnya, jika kosong set null
    function cDateNull($item) {
        if($item == '')
            return 'null';
        else
            return formatDate(removeSpecial($item));
    }

    // jika $item kosong, return $sub
    function cEmChg($item,$sub) {
        if($item == '')
            return $sub;
        else
            return $item;
    }

    // bila $item kosong, return null, bila bukan angka, return 0, bila tidak, strip
    function cNumNull($item) {
        if($item == '')
            return 'null';
        else if(!is_numeric($item))
            return 0;
        else
            return removeSpecial($item);
    }

    // bila $item kosong, return 0, bila tidak, strip
    function cNumZero($item) {
        if($item == '')
            return 0;
        else
            return removeSpecial($item);
    }

    // bila $item kosong, set null, bila tidak, strip
    function cStrNull($item,$stripapp='strip') {
        if($item == '')
            return 'null';
        else
            return removeSpecial($item,$stripapp);
    }

    // untuk elemen array, lakukan cStrNull
    function cStrFill($src,$elem='',$idx=false) {
        if(is_array($elem)) {
            $retarr = array();
            for($i=0;$i<count($elem);$i++) {
                if(is_array($src[$elem[$i]])) {
                    if($idx === false)
                        $retarr[$elem[$i]] = cStrFill($src[$elem[$i]]);
                    else
                        $retarr[$elem[$i]] = cStrNull($src[$elem[$i]][$idx]);
                }
                else
                    $retarr[$elem[$i]] = cStrNull($src[$elem[$i]]);
            }
        }
        else {
            $retarr = array();
            foreach($src as $key => $val) {
                if(is_array($val)) {
                    if($idx === false)
                        $retarr[$key] = cStrFill($val);
                    else
                        $retarr[$key] = cStrNull($val[$idx]);
                }
                else
                    $retarr[$key] = cStrNull($val);
            }
        }

        return $retarr;
    }

    // menggabungkan nama dan gelar
    function namaDanGelar($gd,$nama,$gb) {
        return (empty($gd) ? '' : $gd.' ').$nama.(empty($gb) ? '' : ', '.$gb);

    }

    // memformat kode kegiatan di penilaian
    function formatKodeKegiatan($str) {
        $str = ' '.$str; // padding untuk karakter pertama
        $a_str = str_split($str,2);
        $a_str[0] = $a_str[0][1]; // strip elemen pertama
        return implode('.',$a_str);
    }

    // this page, halaman ini
    function recentURL($includeParams=false)
    {
        if ($includeParams)
            $http = $_SERVER["REQUEST_URI"];
        else
            $http = $_SERVER["PHP_SELF"];
        return htmlentities(strip_tags($http));
    }

    // melakukan string stripping (untuk masalah sekuritas)
    function removeSpecial($mystr,$stripapp='strip') {
        // $pattern = '/[%&;()\"';
        $pattern = '/[%&;\"';
        if($stripapp == 'replace') // tidak stripping ', tapi direplace jadi '', biasanya dipakai di nama
            $mystr = str_replace("'","''",$mystr);
        else if($stripapp == 'strip')
            $pattern .= "\'";
        if(preg_match('/[A-Za-z%\/]/',$mystr)) // kalau ada alfabet, %, atau /, strip <>
            $pattern .= '<>';
        $pattern .= ']|--/';

        return preg_replace($pattern, '$1', $mystr);
    }

    // mengubah 0 menjadi &nbsp;
    function zeroToNBSP($item) {
        if($item == 0)
            return '&nbsp;';
        else
            return $item;
    }

    /* 2. Fungsi Penanggalan */

    // mengubah format periode
    function convertPeriode($periode) {
        $thn = substr($periode,0,4);
        switch(substr($periode,-1)) {
            case 1: $smt = 'Gasal'; break;
            case 2: $smt = 'Genap'; break;
            case 3: $smt = 'Pendek'; break;
        }
        return 'Semester '.$smt.' '.$thn.'/'.($thn+1);
    }

    // mengubah format waktu
    function convertTime($time) {
        $time = str_pad($time,4,'0',STR_PAD_LEFT);
        return substr($time,0,2).':'.substr($time,-2);
    }

    // mengubah format tanggal dari dd-mm-yyyy menjadi yyyy-mm-dd dan sebaliknya
    function formatDate($dmy,$delim='-') {
        if($dmy == '')
            return '';
        if($dmy == 'null')
            return 'null';
        list($y,$m,$d) = explode($delim,substr($dmy,0,10));
        return $d.$delim.$m.$delim.$y;
    }

    // mengubah format tanggal, tapi ada time dibelakangnya
    function formatDateTime($dmy,$delim='-') {
        if($dmy == '')
            return '';
        if($dmy == 'null')
            return 'null';
        return formatDate(substr($dmy,0,10)).substr($dmy,10);
    }
    function convertTanggalInd($ptanggal,$dgnwaktu=true,$dgndetik=true,$blnlengkap=true) {
        if(empty($ptanggal))
            return '';
        else {
            $tglwaktu = explode(' ',$ptanggal);
            $tgl = explode('-',$tglwaktu[0]);
            $tglwaktu[0] = $tgl[2].' '.indoMonth($tgl[1],$blnlengkap).' '.$tgl[0];
            if($dgnwaktu) {
                if(empty($tglwaktu[1]))
                    $tglwaktu[1] = '00:00:00';
                if($dgndetik)
                    return $tglwaktu[0].', '.$tglwaktu[1];
                else
                    return $tglwaktu[0].', '.substr($tglwaktu[1],0,5);
            }
            else
                return $tglwaktu[0];
        }
    }
    // mengubah format tanggal dari yyyy-mm-dd menjadi format indonesia
    function s_formatDateInd($ymd,$full=true,$dmy=false,$delim='-') {
        if($ymd == '')
            return '';
        if($ymd == 'null')
            return 'null';

        if($dmy)
            list($d,$m,$y) = explode($delim,substr($ymd,0,10));
        else
            list($y,$m,$d) = explode($delim,substr($ymd,0,10));

        return (int)$d.' '.indoMonth($m,$full).' '.$y;
    }
    // nama hari di bahasa indonesia
    function indoDay($nhari,$full=true) {
        if($full) {
            switch($nhari) {
                case 0: return "Minggu";
                case 1: return "Senin";
                case 2: return "Selasa";
                case 3: return "Rabu";
                case 4: return "Kamis";
                case 5: return "Jumat";
                case 6: return "Sabtu";
            }
        }
        else {
            switch($nhari) {
                case 0: return "Min";
                case 1: return "Sen";
                case 2: return "Sel";
                case 3: return "Rab";
                case 4: return "Kam";
                case 5: return "Jum";
                case 6: return "Sab";
            }
        }
    }

    // nama bulan di bahasa indonesia
    function indoMonth($nbulan,$full=true) {
        if($full) {
            switch($nbulan) {
                case 1: return "Januari";
                case 2: return "Pebruari";
                case 3: return "Maret";
                case 4: return "April";
                case 5: return "Mei";
                case 6: return "Juni";
                case 7: return "Juli";
                case 8: return "Agustus";
                case 9: return "September";
                case 10: return "Oktober";
                case 11: return "Nopember";
                case 12: return "Desember";
            }
        }
        else {
            switch($nbulan) {
                case 1: return "Jan";
                case 2: return "Peb";
                case 3: return "Mar";
                case 4: return "Apr";
                case 5: return "Mei";
                case 6: return "Jun";
                case 7: return "Jul";
                case 8: return "Agu";
                case 9: return "Sep";
                case 10: return "Okt";
                case 11: return "Nop";
                case 12: return "Des";
            }
        }
    }

    /* 3. Fungsi HTML Helper */

    // membuat textarea
    function createTextArea($nameid,$value='',$class='',$rows='',$cols='',$edit=true,$add='') {
        if(!empty($edit)) {
            $ta = '<textarea wrap="soft" name="'.$nameid.'" id="'.$nameid.'"';
            if($class != '') $ta .= ' class="'.$class.'"';
            if($rows != '') $ta .= ' rows="'.$rows.'"';
            if($cols != '') $ta .= ' cols="'.$cols.'"';
            if($add != '') $ta .= ' '.$add;
            $ta .= '>';
            if($value != '') $ta .= $value;
            $ta .= '</textarea>';
        }
        else if($value == '')
            $ta = 'N/A';
        else
            $ta = $value;

        return $ta;
    }

    // membuat textbox
    function createTextBox($nameid,$value='',$class='',$maxlength='',$size='',$edit=true,$add='') {
        if(!empty($edit)) {
            $tb = '<input type="text" name="'.$nameid.'" id="'.$nameid.'"';
            if($value != '') $tb .= ' value="'.$value.'"';
            if($class != '') $tb .= ' class="'.$class.'"';
            if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
            if($size != '') $tb .= ' size="'.$size.'"';
            if($add != '') $tb .= ' '.$add;
            $tb .= '>';
        }
        else if($value == '')
            $tb = 'N/A';
        else
            $tb = $value;

        return $tb;
    }

    // membuat combo box
    function createSelect($nameid,$arrval='',$value='',$class='',$edit=true,$add='') {
        if(!empty($edit)) {
            $slc = '<select name="'.$nameid.'" id="'.$nameid.'"';
            if($class != '') $slc .= ' class="'.$class.'"';
            if($add != '') $slc .= ' '.$add;
            $slc .= ">\n";
            if(is_array($arrval)) {
                foreach($arrval as $key => $val) {
                    $slc .= '<option value="'.$key.'"'.(!strcasecmp($value,$key) ? ' selected' : '').'>';
                    $slc .= $val.'</option>'."\n";
                }
            }
            $slc .= '</select>';
        }
        else {
            if(is_array($arrval)) {
                foreach($arrval as $key => $val) {
                    if(!strcasecmp($value,$key)) {
                        $slc = $val;
                        break;
                    }
                }
            }
            if(!isset($slc))
                $slc = 'N/A';
        }

        return $slc;
    }

    function createSelectX($nameid,$arrval='',$value='',$class='',$edit=true,$add='') {
        if(!empty($edit)) {
            $slc = '<select name="'.$nameid.'" id="'.$nameid.'"';
            if($class != '') $slc .= ' class="'.$class.'"';
            if($add != '') $slc .= ' '.$add;
            $slc .= ">\n";
            $slc .= '<option value="" >';
            if(is_array($arrval)) {
                foreach($arrval as $key => $val) {
                    $slc .= '<option value="'.$key.'"'.(!strcasecmp($value,$key) ? ' selected' : '').'>';
                    $slc .= $val.'</option>'."\n";
                }
            }
            $slc .= '</select>';
        }
        else {
            if(is_array($arrval)) {
                foreach($arrval as $key => $val) {
                    if(!strcasecmp($value,$key)) {
                        $slc = $val;
                        break;
                    }
                }
            }
            if(!isset($slc))
                $slc = 'N/A';
        }

        return $slc;
    }
    function createSelectY($nameid,$arrval='',$value='',$class='',$edit=true,$add='') {
        if(!empty($edit)) {
            $slc = '<select name="'.$nameid.'" id="'.$nameid.'"';
            if($class != '') $slc .= ' class="'.$class.'"';
            if($add != '') $slc .= ' '.$add;
            $slc .= ">\n";
            $slc .= '<option value="" >Seminar Mhs,KP,Dosen wali, Membina kegiatan Mhs bidang Akademik dan Kemahasiswaan';
            if(is_array($arrval)) {
                foreach($arrval as $key => $val) {
                    $slc .= '<option value="'.$key.'"'.(!strcasecmp($value,$key) ? ' selected' : '').'>';
                    $slc .= $val.'</option>'."\n";
                }
            }
            $slc .= '</select>';
        }
        else {
            if(is_array($arrval)) {
                foreach($arrval as $key => $val) {
                    if(!strcasecmp($value,$key)) {
                        $slc = $val;
                        break;
                    }
                }
            }
            if(!isset($slc))
                $slc = 'N/A';
        }

        return $slc;
    }

    /* 4. Fungsi Terjemah Hardcoding */

    function arrJenisCuti() {
        return array('B' => 'Cuti Bersama', 'M' => 'Cuti Melahirkan', 'S' => 'Cuti Sakit');
    }

    function hcJenisCuti($id) {
        $arhc = arrJenisCuti();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrJenisPiagam() {
        return array('P' => 'Penghargaan', 'S' => 'Sertifikat');
    }

    function hcJenisPiagam($id) {
        $arhc = arrJenisPiagam();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrJenisTugas() {
        return array('I' => 'Tugas Internal', 'X' => 'Tugas Eksternal');
    }

    function hcJenisTugas($id) {
        $arhc = arrJenisTugas();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrJenisTugasBelajar() {
        return array('D' => 'Dalam Negeri', 'L' => 'Luar Negeri');
    }

    function hcJenisTugasBelajar($id) {
        $arhc = arrJenisTugasBelajar();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }
    //----- tambahan utk tugasbelajar mas Agus nugroho ------------//
    function arrJenisTugasBelajarJenis() {
        return array('TB' => 'Tugas Belajar', 'TI' => 'Ijin Belajar');
    }
    function arrJenisSponsor() {
        return array('M' => 'Mandiri', 'B' => 'Beasiswa');
    }
    function arrJenisJenjang() {
        return array('S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3');
    }
    //----------------//

    function arrTingkatSurat() {

        return array('I' => 'Institut', 'F' => 'Fakultas', 'L' => 'LPPM', 'P' => 'PPs','N' => 'Nasional', 'X' => 'Internasional');
    }

    function hcTingkatSurat($id) {
        $arhc = arrTingkatSurat();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrMasaTugas() {
        return array('T' => 'tahunan', 'S' => 'semester', 'H' => 'harian');
    }

    function hcMasaTugas($raw,$mode='1') {
        if($raw == null){
            return "";
        } else {
            $id = substr($raw,1,1);
            $add = substr($raw,3,strlen($raw)-3);
            $arhc = arrMasaTugas();

            if(array_key_exists($id,$arhc)) {
                switch($mode) {
                    case '1': //hanya kategorinya
                        return $arhc[$id]; break;
                    case '2': //hanya uraian (additionalnya)
                        return $add; break;
                    default: //kategori dan uraian
                        return $add.' ('.$arhc[$id].')'; break;
                }
            }
        }

    }

    function arrJenisSuratTugas() {
        return array('K' => 'Surat Keputusan', 'T' => 'Surat Penugasan');
    }

    function hcJenisSuratTugas($id) {
        $arhc = arrJenisSuratTugas();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrTemplateSuratTugas() {
        return array(
                        'T1' => 'Mengajar',
                        'T2' => 'Asisten / Responsi',
                        'T3' => 'Praktikum / Studio',
                        'T4' => 'Bimbingan Kuliah Lapangan',
                        'T5' => 'Bimbingan Seminar Mahasiswa',
                        'T8' => 'Bimbingan Akademik',
                        'T9' => 'Bimbingan Konseling',
                        'T6' => 'Bimbingan Tugas Akhir / Tesis / Disertasi',
                        'T7' => 'Menguji Tugas Akhir / Tesis / Disertasi',
                        'TA' => 'Penelitian',
                        'TB' => 'Pengabdian',
                        'TC' => 'Penunjang/Kepanitiaan/Tim AdHoc dll',
                        'TX' => 'Lainnya'

        );
    }


    function arrTemplateKegiatan() {
    return array(
                        'T1' => 'SK Bersama',



        );
    }


    function hcKategoriBebanKerja($id) {
        $arhc = arrKategoriBebanKerja();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrKategoriBebanKerja() {
        return array(	'PD' => 'Bidang Pendidikan',
                        'PL' => 'Bidang Penelitian dan Pengembangan Ilmu',
                        'PM' => 'Bidang Pengabdian Masyarakat',
                        'TD' => 'Bidang Penunjang',
                        'TF' => 'Tugas Khusus'
        );
    }

    function arrKonversiRubrik($direction = 'prof') {
        //index rubrik asli, isi rubrik profesornya
        if($direction == 'prof')
        return array(
            'B03.a' => 'T01',
            'B03.b' => 'T02',
            'B09.1' => 'T05',
            'B09.2' => 'T06',
            'B09.3' => 'T07',
            'B07.1' => 'T08',
            'B07.2' => 'T09',
            'B07.3' => 'T10');
        else
        return array(
            'T01' => 'B03.a',
            'T02' => 'B03.b',
            'T05' => 'B09.1',
            'T06' => 'B09.2',
            'T07' => 'B09.3',
            'T08' => 'B07.1',
            'T09' => 'B07.2',
            'T10' => 'B07.3'
            );
    }

    function hcTemplateSuratTugas($id) {
        $arhc = arrTemplateSuratTugas();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrPeranSeminar() {
        return array('Peserta' => 'Peserta', 'Moderator' => 'Moderator', 'Pembicara' => 'Pembicara');
    }

    function hcPeranSeminar($id) {
        $arhc = arrPeranSeminar();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrKegiatanPM() {
        return array('Pendidikan' => 'Pendidikan', 'Penelitian' => 'Penelitian', 'Perancangan' => 'Perancangan');
    }

    function hcKegiatanPM($id) {
        $arhc = arrKegiatanPM();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrJenisKategori() {
        return array('XX' => 'pilih kategori','JL' => 'Jurnal', 'SM' => 'Seminar');
    }

    function hcJenisKategori($id) {
        $arhc = arrPeranSeminar();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrTingkat() {
        return array(1 => 'Nasional',2 => 'Internasional');
    }

    function arrAkreditasi() {
        return array(1 => 'Tidak Terakreditasi',2 => 'Terakreditasi');
    }

    function arrJenisKegiatanDosen() {
        return array('BK' => 'Buku','JL' => 'Jurnal','SM'=>'Seminar','PT'=>'Penelitian');
    }

    function arrDiklatNS() {
        return array('F' => 'Fungsional', 'T' => 'Teknis');
    }

    function arrTingkatPerhargaan() {
        return array(1 => 'ITS', 2=> 'Kabupaten/Kota', 3 => 'Provinsi', 4 => 'Nasional', 5 => 'International');
    }

    function arrJenisPerhargaan() {
        return array(1 => 'Individu', 2=> 'Kelompok');
    }

    function arrPeranPenghargaan(){
        return array(1 => 'Ketua', 2=> 'Anggota/Lainnya');
    }

    
    function arrPenyelengara() {
        return array('K' => 'Kementrian', 'LE' => 'Lembaga External', 'I' => 'ITS');
    }

    function hcDiklatNS($id) {
        $arhc = arrDiklatNS();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    function arrHukuman() {
        return array('L' => 'Ringan', 'M' => 'Sedang', 'H' => 'Berat');
    }

    function hcHukuman($id) {
        $arhc = arrHukuman();

        if(array_key_exists($id,$arhc))
            return $arhc[$id];
    }

    /* 5. Fungsi dengan Koneksi DB */

    // cek otentikasi dan otorisasi role dari database
    function checkRoleAuth($conn,$xpage = true) {
        if($_SESSION['SIP_ROLE'] == '') {
            if($xpage){
                echo '<font color="red"><strong>Anda tidak berhak melihat halaman ini..</strong></font>';
            } else {
                header('Location: index.php?err=3');
            }
            exit();
        }
        else {
            // pengecekan post, cek apakah user bisa lihat data pegawai berdasarkan unit
            $namapage = basename(recentURL());
            if($xpage && substr($namapage,0,5) == 'xlita') {
                $r_nip = removeSpecial($_REQUEST['key']);
                if($r_nip != '') {
                    if(!checkAuthUnit($conn,$r_nip)) {
                        echo '<font color="red"><strong>Anda tidak berhak melihat data pegawai ini...</strong></font>';
                        exit(); // lagi saya devlop jabatan rahmad.
                    }
                }
            }

            $row = $conn->GetRow("select * from sc_targetrole where namapage = '$namapage' and idrole = '".$_SESSION['SIP_ROLE']."'");
            if(empty($row['canread'])) {
                if($xpage){
                    echo '<font color="red"><strong>Anda tidak berhak melihat halaman ini....</strong></font>';
                }
                else {
                    header('Location: home.php');

                }
                exit();
            }
            else {
                foreach($row as $key => $val) {
                    if(empty($row[$key])){
                        $row[$key] = false;
                    } else{
                        $row[$key] = true;
                    }
                }

                return $row;
            }
        }
    }

    // cek otorisasi user terhadap pegawai berdasarkan unit
    function checkAuthUnit($conn,$nip) {
        if($nip == '' or $_SESSION['SIP_ROLE'] == 'P')
            return true;
        else {
            $sql = "select 1 from ms_pegawai p join ms_satker s on s.idsatker = p.idsatker where
                    nip = '$nip' and s.info_lft >= '".$_SESSION['SIP_SATKER_L']."' and
                    s.info_rgt <= '".$_SESSION['SIP_SATKER_R']."'";
            $isauth = $conn->GetOne($sql);

            if($isauth == 1)
                return true;
            else
                return false;
        }
    }

    // tampilkan pesan error
    function pgError($conn,$tipe='simpan') {
        $errno = $conn->ErrorNo();
        $errmsg = $conn->ErrorMsg();

        if($fkey = strpos($errmsg,'DBSERROR:')) { // pesan tidak perlu diterjemahkan
            $start = $fkey + 9;
            $end = (strpos($errmsg,'CONTEXT')) - $start;
            $errview = trim(substr($errmsg,$start,$end));
            return message("ERROR: ".$errview,true);
        }

        switch($errno) {
            case -1:
                if($tipe == "hapus")
                    return message("ERROR: Data masih dijadikan referensi.",true);
                else
                    return message("ERROR: Terjadi kesalahan pada referensi data.",true);
            case -5: return message("ERROR: Terjadi duplikasi data.",true);
            case 0:
                if($tipe == "simpan")
                    return message("Penyimpanan data berhasil.");
                else if($tipe == "simpanplus")
                    return message("Penyimpanan data berhasil, silahkan klik tab kegiatan untuk merefresh halaman");
                else if($tipe == "hapus")
                    return message("Penghapusan data berhasil.");
                else
                    return message("Operasi data berhasil.");
            default: return message("ERROR: Terjadi kesalahan pada operasi data.",true);
        }
    }

    // nilai tunjangan yang akan diterima pegawai
    function nilaiTunjangan($conn,$nip,$idtunjangan) {
        // mendapatkan parameter tunjangan dan properti2nya
        $sql = "select v.idparam, v.paramvalue, v.payvalue, p.tablename, p.keycolumn, p.aggfunc, p.flaganeh from au_payparamvalue v
                join au_payparam p on v.idparam = p.idparam where v.idtunjangan = '$idtunjangan' order by v.idparam";
        $rsp = $conn->Execute($sql);

        // menghitung nilai tunjangan
        $t_tunjangan = 0;
        while(!$rsp->EOF) {
            if($rsp->fields['aggfunc'] != '')
                $rsp->fields['keycolumn'] = $rsp->fields['aggfunc'].'('.$rsp->fields['keycolumn'].')';

            $sql = "select ".$rsp->fields['keycolumn']." from ".$rsp->fields['tablename']." where nip = '$nip'";
            $c_pval = $conn->GetOne($sql);

            if(isset($c_yval))
                unset($c_yval);

            // nilai sebenarnya bisa lebih besar dari parameter, ambil nilai dengan parameter terbesar yang sesuai
            if($rsp->fields['flaganeh'] == 'L') {
                $t_idparam = $rsp->fields['idparam'];
                while($t_idparam == $rsp->fields['idparam'] and !$rsp->EOF) {
                    $t_pval = 0;
                    if($rsp->fields['paramvalue'] > $t_pval and $rsp->fields['paramvalue'] <= $c_pval) {
                        $t_pval = $rsp->fields['paramvalue'];
                        $c_yval = $rsp->fields['payvalue'];
                    }
                    $rsp->MoveNext();
                }
            }
            // default: nilai sebenarnya harus tepat sesuai parameter
            else {
                $t_idparam = $rsp->fields['idparam'];
                while($t_idparam == $rsp->fields['idparam'] and !$rsp->EOF) {
                    if($rsp->fields['paramvalue'] == $c_pval)
                        $c_yval = $rsp->fields['payvalue'];
                    $rsp->MoveNext();
                }
            }

            if(isset($c_yval))
                $t_tunjangan += $c_yval;
        }

        return $t_tunjangan;
    }

    function getSkipZone($conn,$nip,$tahun)
    {
        $a_idlebih = array();

        $count = $conn->GetOne("select sum(sksbeban * capaian/100) from se_kegiatan k where nip='$nip' and periode='$tahun' and isskip = 'N' ");

        if($count > 33)
        {
            //echo "you should be trimmed";$conn->debug = true;
            $sql = "select k.idkegiatan,k.idkategori,(k.sksbeban * (k.capaian/100)) as sks from se_kegiatan k ".
                "left join se_rubrik r on r.idrubrik = k.refidrubrik where nip='$nip' and periode='$tahun' ".
                "and idrekomendasi1 is null order by ".
                "r.idkategori,r.bobotlap desc,(r.masaberlaku - (k.periode-coalesce(year(k.tgltugas),k.periode)))";
            $rslebih = $conn->Execute($sql);
            $numsks = array();
            $ar_zonalebih = array();
            while($lebih = $rslebih->FetchRow())
            {
                $numsks[$lebih['idkategori']] += (float)$lebih['sks'];
                if(($lebih['idkategori'] == 'PL' /*or $lebih['idkategori'] == 'TF'*/ ) and ($numsks['PL']+$numsks['TF']) > 6)
                {
                    $a_idlebih[] = $lebih['idkegiatan'];
                    $numsks[$lebih['idkategori']] -= (float)$lebih['sks'];
                    $ar_zonalebih[] = $lebih;
                }
                if(($lebih['idkategori'] == 'PD') and $numsks['PD'] > 12)
                {
                    $a_idlebih[] = $lebih['idkegiatan'];
                    $numsks[$lebih['idkategori']] -= (float)$lebih['sks'];
                    $ar_zonalebih[] = $lebih;
                }
                if(($lebih['idkategori'] == 'PM' or $lebih['idkategori'] == 'TD') and ($numsks['PL']+$numsks['TF']) > 6)
                {
                    $a_idlebih[] = $lebih['idkegiatan'];
                    $numsks[$lebih['idkategori']] -= (float)$lebih['sks'];
                    $ar_zonalebih[] = $lebih;
                }
            }
        }


        return $ar_zonalebih;
    }

    function getSkipKegiatan($conn,$nip,$tahun,$periodes)
    {
        $a_idlebih = array();
        $a_idlebihx = array();

        $count = $conn->GetOne("select sum(sksbeban * capaian/100) from se_kegiatan k where nip='$nip' and periode='$tahun' and periodes='$periodes' and isskip = 'N' ");

        if($count > 17) //33
        {
            //echo "you should be trimmed";$conn->debug = true;
            $sql = "select k.idkegiatan,k.idkategori,(k.sksbeban * (k.capaian/100)) as sks from se_kegiatan k ".
                "left join se_rubrik r on r.idrubrik = k.refidrubrik where nip='$nip' and periode='$tahun' and periodes='$periodes' ".
                "and idrekomendasi1 is null order by ".
                "r.idkategori,r.bobotlap desc,(r.masaberlaku - (k.periode-coalesce(year(k.tgltugas),k.periode)))";
            $rslebih = $conn->Execute($sql);
            $numsks = array();
            $ar_zonalebih = array();
            while($lebih = $rslebih->FetchRow())
            {
                $numsks[$lebih['idkategori']] += (float)$lebih['sks'];
                $lebih['sks'] = (float)$lebih['sks'];
                if(($lebih['idkategori'] == 'PL' /*or $lebih['idkategori'] == 'TF'*/ ) and ($numsks['PL']+$numsks['TF']) > 3)//6
                {
                    $a_idlebih[] = $lebih['idkegiatan'];
          $numsks[$lebih['idkategori']] -= (float)$lebih['sks'];

                    $ar_zonalebih[] = $lebih;
                }
                if(($lebih['idkategori'] == 'PD') and $numsks['PD'] > 6)//12
                {
                    $a_idlebih[] = $lebih['idkegiatan'];
                    $numsks[$lebih['idkategori']] -= (float)$lebih['sks'];
                    $ar_zonalebih[] = $lebih;
                }
                if(($lebih['idkategori'] == 'PM' or $lebih['idkategori'] == 'TD') and ($numsks['PM']+$numsks['TD']) > 3)//6
                {
                    $a_idlebih[] = $lebih['idkegiatan'];
                    $numsks[$lebih['idkategori']] -= (float)$lebih['sks'];
                    $ar_zonalebih[] = $lebih;

                }
            }


            $skscukup = $numsks['PD'] + $numsks['PL'] + $numsks['PM'] + $numsks['TD'] + $numsks['TF'];
            if($_SERVER['REMOTE_ADDR'] == '10.199.2.14')
        echo $numsks['PD'].' + '.$numsks['PL'].' + '.$numsks['PM'].' + '.$numsks['TD'] .'+ '.$numsks['TF'];
            foreach($ar_zonalebih as $klebih => $rlebih)
            {
        $numsks[$rlebih['idkategori']] += (float)$rlebih['sks'];
        if($_SERVER['REMOTE_ADDR'] == '10.199.2.14'){
          print_r($rlebih );
          echo "<br/>";
        }
        if(($rlebih['idkategori'] == 'PL' or $rlebih['idkategori'] == 'PD') and ($numsks['PL']+$numsks['TF']+$numsks['PD']) > 12)//24
        {
          $a_idlebihx[] = $rlebih['idkegiatan'];
          $numsks[$rlebih['idkategori']] -= (float)$rlebih['sks'];
        }
        if(($rlebih['idkategori'] == 'PM' or $rlebih['idkategori'] == 'TD') and ($numsks['PM']+$numsks['TD']) > 4)//8
                {
                    if($_SERVER['REMOTE_ADDR'] == '10.199.2.14')
            echo $numsks['PM'].'+'.$numsks['TD'];
                    $a_idlebihx[] = $rlebih['idkegiatan'];
                    $numsks[$rlebih['idkategori']] -= (float)$rlebih['sks'];

                }
            }
        }
        if($_SERVER['REMOTE_ADDR'] == '10.199.2.14'){
      print_r($a_idlebihx);
        }

        return $a_idlebihx;
    }

    // mendapatkan data master
    function dbAgama($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namaagama from lv_agama where idagama = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbBank($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namabank from lv_bank where idbank = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbStatusAktif($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namastatusaktif from lv_statusaktif where idstatusaktif = '$id'");
        return ($return == '' ? $ifnull : $return);
    }
        function dbEselon($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namaeselon from ms_eselon where ideselon = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbJenisPeg($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namajenispegawai from lv_jenispeg where idjenispegawai = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbKelasjabatan($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select cast(id_kelasjabatan as char(2))+' - ' +cast(tunjangan_kelasjabatan as char(10)) as klsjabatan from ms_kelasjabatan where id_kelasjabatan = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbNamajabatan($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select cast(idjabatan as char(3))+' - '+nmjabatan as namajabatan from ms_namajabatan where idjabatan = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbKedudukan($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namakedudukan from lv_kedudukan where idkedudukan = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbKelurahan($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namakelurahan from lv_kelurahan where idkelurahan = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbPendidikan($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namapendidikan from lv_pendidikan where idpendidikan = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbSatKer($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namasatker from ms_satker where idsatker = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbStatusPeg($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select namastatuspegawai from lv_statuskepeg where idstatuspegawai = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function dbRekomendasi($conn,$id,$ifnull='') {
        $return = $conn->GetOne("select rekomendasi from se_rekomendasi where idrekomendasi = '$id'");
        return ($return == '' ? $ifnull : $return);
    }

    function toggleLockAsessment($conn,$periode,$periodes,$idsatker,$code='S') {
        $islocked = $conn->GetOne("select 1 from se_kuncisatker where periode='$periode' and periodes='$periodes' and idsatker='$idsatker' and stage='$code'");
        if($islocked == '1'){
            if($idsatker==1)
                $conn->Execute("delete from se_kuncisatker where periode='$periode' and periodes='$periodes' and stage='$code'");
            else $conn->Execute("delete from se_kuncisatker where periode='$periode' and periodes='$periodes' and idsatker='$idsatker' and stage='$code'");
        }else
            $conn->Execute("insert into se_kuncisatker values ('$periode','$idsatker','$code','$periodes') ");
    }

    function isLockAsessment($conn,$periode,$periodes,$idsatker,$code='S') {
     //if($_SESSION['SIP_USER']=='197303102002121001') $conn->debug=true;
    $setperiode = $conn->GetRow("select *  from ms_periode where idperiode=1");
    $semester= $period['semester']==1?'B':'A';
    if($periode != $setperiode['tahun'] and $periodes!= $semester)
      return true;
        $sql = "select l.idsatker, l.info_rgt from ms_satker l join ms_satker u on l.info_lft <= u.info_lft ".
                " and u.idsatker='$idsatker' order by l.info_lft desc";
        $rs = $conn->Execute($sql);
        $i = 0;
        while($row = $rs->FetchRow()) {
            if($i == 0) //initial loop
                $t_right = $row['info_rgt'];
            if($t_right <= $row['info_rgt'] )
                $ar_lookunit[] = $row['idsatker'];
            $i++;
        }

        if(count($ar_lookunit))
        $lookunit = implode("','",$ar_lookunit);
        $sql = "select count(*) from se_kuncisatker where periode='$periode'  and periodes='$periodes' and stage='$code' and idsatker in ('".$lookunit."')";
        $islocked = $conn->GetOne($sql);

        //echo "aha".$islocked;
        return ($islocked > 0);

    }

    /* 6. Fungsi Lainnya */

    // menjumlahkan elemen array
    function arrayAdd($src,$add) {
        if(!empty($add)) {
            foreach($add as $key => $val) {
                if(empty($src[$key]))
                    $src[$key] = $add[$key];
                else if(is_array($add[$key]))
                    $src[$key] = arrayAdd($src[$key],$add[$key]);
                else
                    $src[$key] += $add[$key];
            }
        }
        return $src;
    }

    // membuat foto
    function createFoto($src,$dest,$xw=0,$xh=0) {
        if(($rsize = getimagesize($src)) === false)
            return -1; // bukan image
        $rw = $rsize[0]; $rh = $rsize[1];

        if($rw > $rh or ($rw == $rh and $xw < $xh)) { // lebih kecil max width atau sama
            $nw = $xw;
            $nh = round(($nw*$rh)/$rw);
        }
        else if($rw < $rh or ($rw == $rh and $xw > $xh)) { // lebih kecil max height atau sama
            $nh = $xh;
            $nw = round(($nh*$rw)/$rh);
        }
        else { // semua parameter max ukuran 0, disamakan
            $nw = $xw;
            $nh = $xh;
        }

        switch($rsize[2]) {
            case IMAGETYPE_GIF: $rimg= imagecreatefromgif($src); break;
            case IMAGETYPE_JPEG: $rimg= imagecreatefromjpeg($src); break;
            case IMAGETYPE_PNG: $rimg= imagecreatefrompng($src); break;
            default: return -2; // format image tidak dikenali
        }
        $nimg= imagecreatetruecolor($nw,$nh);

        imagecopyresized($nimg, $rimg, 0, 0, 0, 0, $nw, $nh, $rw, $rh);
        $return= imagejpeg($nimg,$dest);
        imagedestroy($rimg);
        imagedestroy($nimg);

        if($return === true)
            return 1;
        else
            return -3; // tidak bisa menulis image tujuan
    }


    function getExtension($fileName) {
        $pos = strrchr($fileName, '.');

        if ($pos !== FALSE) {
            return strtolower(substr($pos, 0));
        } else {
            return '';
        }
    }
    // mendapatkan nama sistem operasi dari HTTP_USER_AGENT, tidak begitu detail, cost-wise :)
    function getOS() {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        if($pos = strpos($agent,'Windows ')) {
            $major = substr($agent,$pos+8,2);

            if($major == '3.') return 'Windows 3.1';
            else if($major == '95') return 'Windows 95';
            else if($major == '98') return 'Windows 98';
            else if($major == 'Me') return 'Windows Me';
            else if($major == 'NT') {
                $version = substr($agent,$pos+11,3);

                if($version == '5.0') return 'Windows 2000';
                else if($version == '5.1') return 'Windows XP';
                else if($version == '5.2') return 'Windows Server 2003';
                else if($version == '6.0') return 'Windows Vista';
                else return 'Windows NT';
            }
            else return 'Windows';
        }
        else if($pos = strpos($agent,'Linux')) return 'Linux';
        else if($pos = strpos($agent,'Symbian')) return 'Symbian';
        else if($pos = strpos($agent,'MIDP')) return 'MIDP';
        else if($pos = strpos($agent,'Mac')) return 'Macintosh';
        else if($pos = strpos($agent,'Solaris')) return 'Solaris';
        else return 'Lain-lain';
    }

    // membandingkan menu session dan menu item
    function inMenu($item) {

      $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
      $url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/';
      
        if(!isset($_SESSION['SIP_MENU'])){
            header('Location: '.$url.'index.php?err=3');
            exit();
        }

        $sess = $_SESSION['SIP_MENU'];

        $return = array();
        for($i=0;$i<count($item);$i++) {
            if(array_key_exists($item[$i], $sess)){
                if($sess[$item[$i]] === true){
                    $return[$i] = true;
                }
            }
        }

        if(empty($return))
            return false;
        else
            return $return;
    }

    // tampilkan pesan (misalnya error)
    function message($str,$error=false) {
        if($error)
            return '<strong><font color="#FF0000" size="2">'.$str.'</font></strong>';
        else
            return '<strong><font color="#00AA00" size="2">'.$str.'</font></strong>';
    }

    // isi array untuk properti pager
    function setTableArray(&$arr,$label,$tipe,$lebar=0) {
        $arr['label'] = $label;
        $arr['tipe'] = $tipe;
        $arr['lebar'] = $lebar;
    }

    // ambil elemen dari array elemen sebuah array :D
    function takeElem($arr,$idx=0) {
        $retarr = array();

        foreach($arr as $key => $val) {
            if(is_array($arr[$key]))
                $retarr[$key] = $arr[$key][$idx];
            else
                $retarr[$key] = $arr[$key];
        }

        return $retarr;
    }

    // ber di dalam tabel dengan tr
    function trbr() {
        return '<tr><td height="1">&nbsp;</td></tr>';
    }

    // membuat gradiasi warna
    function gradient() {
        $args = func_get_args();

        if(empty($args[0]))
            $scale = 5;
        else
            $scale = $args[0];

        $cols = array_slice($args,1);
        if(empty($cols)) {
            $cols = array();
            $cols[0] = '000000';
        }
        if(empty($cols[1])) {
            $cols[1] = 'ffffff';
        }

        $ncol = count($cols);

        // menghilangkan #
        for($i=0;$i<$ncol;$i++)
            if($cols[$i][0] == '#')
                $cols[$i] = substr($cols[$i],1);

        // menghitung nilai desimal dari heksadesimal
        for($i=0;$i<$ncol;$i++) {
            $r[$i] = hexdec(substr($cols[$i],0,2));
            $g[$i] = hexdec(substr($cols[$i],2,2));
            $b[$i] = hexdec(substr($cols[$i],4,2));
        }

        // menghitung variabel pelengkap
        if($scale <= $ncol) {
            $sint = 0;
        }
        else {
            $sint = floor(($scale-$ncol)/($ncol-1));
            $sind = ($scale-$ncol)%($ncol-1);
            if($sind == 0)
                $sind = $ncol-1;
        }

        $j = 0; // untuk indeks array warna
        $k = ($sint > 0 ? 0 : -1); // untuk penanda saat init warna utk gradiasi
        $l = 1; // counter batas warna
        $retc = array();

        if($k == -1)
            // tanpa gradiasi karena $scale <= $ncol
            for($i=0;$i<$scale;$i++)
                $retc[$i] = $cols[$j++];
        else {
            // dengan gradiasi karena $scale > $ncol
            for($i=0;$i<$scale;$i++) {
                if($i == $k) {
                    $nextc = $sint + ($l > $sind ? 0 : 1) + 1;
                    $k += $nextc; // saat ganti batas warna
                    $m = 0; // counter gradiasi utk setiap batas warna

                    $col1 = $cols[$j];
                    $col2 = $cols[$j+1];
                    $r1 = $r[$j]; $g1 = $g[$j]; $b1 = $b[$j];
                    $r2 = $r[$j+1]; $g2 = $g[$j+1]; $b2 = $b[$j+1];
                    $j++;

                    if($r1 > $r2) {
                        $rd = $r1-$r2;
                        $rs = -1;
                    }
                    else {
                        $rd = $r2-$r1;
                        $rs = 1;
                    }

                    if($g1 > $g2) {
                        $gd = $g1-$g2;
                        $gs = -1;
                    }
                    else {
                        $gd = $g2-$g1;
                        $gs = 1;
                    }

                    if($b1 > $b2) {
                        $bd = $b1-$b2;
                        $bs = -1;
                    }
                    else {
                        $bd = $b2-$b1;
                        $bs = 1;
                    }

                    $re = ($rd/$nextc)*$rs;
                    $ge = ($gd/$nextc)*$gs;
                    $be = ($bd/$nextc)*$bs;

                    $l++;
                }

                $retc[$i] = '#'.dechex($r1+($m*$re)).dechex($g1+($m*$ge)).dechex($b1+($m*$be));
                $m++;
            }
        }

        return $retc;
    }

function findFirstAndLastDay($anyDate){
            //$anyDate           =  '2009-08-25';    // date format should be yyyy-mm-dd
            list($yr,$mn,$dt)    =  split('-',$anyDate);    // separate year, month and date
            $timeStamp           =  mktime(0,0,0,$mn,1,$yr);    //Create time stamp of the first day from the give date.
            $firstDay            =  date('d',$timeStamp);    //get first day of the given month
            list($y,$m,$t)       =  split('-',date('Y-m-t',$timeStamp)); //Find the last date of the month and separating it
            $lastDayTimeStamp    =  mktime(0,0,0,$m,$t,$y);//create time stamp of the last date of the give month
            $lastDay             =  date('d',$lastDayTimeStamp);// Find last day of the month
            $arrDay              =  array("$firstDay","$lastDay"); // return the result in an array format.

            return $arrDay;
}

function konversitime2detik($time){
                $waktu = explode(':',$time);
                return  floor($waktu[0]*3600) + floor($waktu[1]*60) + floor($waktu[2]);
}

function differenceTime2detik($toTime, $fromTime)
{
    $detik = 0;
    $start_time = new DateTime($fromTime);
    $diff_time  = $start_time->diff(new DateTime($toTime));

    $detik += $diff_time->h * 3600;
    $detik += $diff_time->i * 60;
    $detik += $diff_time->s;
    return $detik;
}

function konversidetik2time($detik){
if($detik<>NULL){
                $hrs = floor($detik/3600);
                $min = $detik - $hrs * 3600;
                $min = floor($min/60);
                $sec = $detik - $hrs * 3600 - $min * 60;
                return str_pad($hrs,2,'0',STR_PAD_LEFT) . ':' .
                   str_pad($min,2,'0',STR_PAD_LEFT) . ':' .
                   str_pad($sec,2,'0',STR_PAD_LEFT);
   }
  return '';
}

function cek_tanggal_jenisxNEW($conn,$userid,$in_tgl) {
    $tglan = formatDate($in_tgl);
    $strSQL = "select * from (
    select a.jeniscuti,a.keterangan,a.tglawal,b.leavename,b.REPORTSYMBOL as simbol,b.color
    from pe_rwtcuti_tanggal a
    left outer join dbo.LEAVECLASS b on a.jeniscuti=b.LEAVEID
    where a.userid=$userid and a.tglawal='$in_tgl'
    /*union all
    select 10 as jeniscuti,'Pada tanggal $tglan, saudara telah absen finger' as keterangan,datelog as tglawal,'Pada tanggal $tglan, saudara telah absen finger (Hadir)' as leavename,'H' as simbol,'3398744' as color
    from dbo.PersonalLog where FingerPrintID=$userid and datelog='$in_tgl'*/
    ) as x";
    $rsQ = $conn->Execute($strSQL);
    $i=0;
    while (!$rsQ->EOF)
    {
        $i++;
        $jeniscuti = $rsQ->fields['jeniscuti'];
        $dateid    = $rsQ->fields['leavename'];
        $leavename = $rsQ->fields['leavename'];
        $tglawal   = formatDate($rsQ->fields['tglawal']);
        $ket       = $rsQ->fields['keterangan'];
        $simbol    = $rsQ->fields['simbol'];
        $color     = $rsQ->fields['color'];
        //echo "<br>i : $i - DATEID : $dateid -> ".$rsQ->fields['STARTSPECDAY'];
        $rsQ->MoveNext();
    }
    if($jeniscuti!=10 and $i>0) $dateid = "Pada tanggal $tglawal, saudara telah ".$dateid;
    return $i.'#'.$jeniscuti.'#'.$dateid.'#'.$ket.'#'.$leavename.'#'.$simbol.'#'.$color ;
    //$data = $conn->GetRow($strSQL);
    //return $data['jeniscuti'].','.$data['leavename'];
}

function cek_tanggal_jenisx($conn,$userid,$in_tgl) {
    $tglan = formatDate($in_tgl);
    $strSQL = "SELECT * from (
    select a.jeniscuti,a.keterangan,a.tglawal,b.leavename,b.REPORTSYMBOL as simbol,b.color
    from pe_rwtcuti_tanggal a
    left outer join dbo.LEAVECLASS b on a.jeniscuti=b.LEAVEID
    where a.userid=$userid and a.tglawal='$in_tgl'
    union all
    select 10 as jeniscuti,'Pada tanggal $tglan, saudara telah absen finger' as keterangan,datelog as tglawal,'Pada tanggal $tglan, saudara telah absen finger (Hadir)' as leavename,'H' as simbol,'3398744' as color
    from dbo.PersonalLog where FingerPrintID=$userid and datelog='$in_tgl'
    ) as x";
    $rsQ = $conn->Execute($strSQL);
    $i=0;
    while (!$rsQ->EOF)
    {
        $i++;
        $jeniscuti = $rsQ->fields['jeniscuti'];
        $dateid    = $rsQ->fields['leavename'];
        $leavename = $rsQ->fields['leavename'];
        $tglawal   = formatDate($rsQ->fields['tglawal']);
        $ket       = $rsQ->fields['keterangan'];
        $simbol    = $rsQ->fields['simbol'];
        $color     = $rsQ->fields['color'];
        //echo "<br>i : $i - DATEID : $dateid -> ".$rsQ->fields['STARTSPECDAY'];
        $rsQ->MoveNext();
    }
    if($jeniscuti!=10 and $i>0) $dateid = "Pada tanggal $tglawal, saudara telah ".$dateid;
    return $i.'#'.$jeniscuti.'#'.$dateid.'#'.$ket.'#'.$leavename.'#'.$simbol.'#'.$color ;
    //$data = $conn->GetRow($strSQL);
    //return $data['jeniscuti'].','.$data['leavename'];
}

function cek_tanggal_jenis($conn,$userid,$in_tgl) {
    //$in_tgl  = "2012-05-03";
    //$userid  = 321;
    $dataX   = explode('-',$in_tgl);
//echo "userid : $userid - $in_tgl";
$strSQL = "select *
from
(
/*
select
    a.userid as USERID,
    a.tglawal as STARTSPECDAY,
    a.tglawal as ENDSPECDAY,
    '7' as DATEID
from
    pe_rwttugas_person a left join
    pe_rwttugas b on a.nourut=b.nourut
where 	a.userid=$userid and
    b.jenistugas='X'

union all*/
select
    userid as USERID,
    tglawal as STARTSPECDAY,
    tglawal as ENDSPECDAY,
    jeniscuti as DATEID
from
    pe_rwtcuti_tanggal
where 	userid=$userid

) as USER_SPEDAY where ((YEAR([STARTSPECDAY])=".
$dataX[0]." AND MONTH([STARTSPECDAY])=".
$dataX[1]." AND DAY([STARTSPECDAY])=".
$dataX[2].") OR (YEAR([ENDSPECDAY])=".
$dataX[0]." AND MONTH([ENDSPECDAY])=".
$dataX[1]." AND DAY([ENDSPECDAY])=".
$dataX[2]."))";

//echo "<br><br>".$strSQL;
$rsQ = $conn->Execute($strSQL);
$i=0;
while (!$rsQ->EOF)
{
    $i++;
    $dateid = $rsQ->fields['DATEID'];
    //echo "<br>i : $i - DATEID : $dateid -> ".$rsQ->fields['STARTSPECDAY'];
    $rsQ->MoveNext();
} // end while

if($i==0){
$strSQL= "
select STARTSPECDAY,ENDSPECDAY,DATEID,datediff(day,STARTSPECDAY,ENDSPECDAY) as lama,year(STARTSPECDAY) as thn,month(STARTSPECDAY) as bln, day(STARTSPECDAY) as tgl
from
(
/*
select
    a.userid as USERID,
    a.tglawal as STARTSPECDAY,
    a.tglawal as ENDSPECDAY,
    '7' as DATEID
from
    pe_rwttugas_person a left join
    pe_rwttugas b on a.nourut=b.nourut
where 	a.userid=$userid and
    b.jenistugas='X'

union all*/
select
    userid as USERID,
    tglawal as STARTSPECDAY,
    tglakhir  as ENDSPECDAY,
    jeniscuti as DATEID
from
    pe_rwtcuti_tanggal
where 	userid=$userid
) as USER_SPEDAY
where datediff(day,STARTSPECDAY,ENDSPECDAY)>1";
        // echo "<br><br>".$strSQL;
        $rsQ = $conn->Execute($strSQL);
        $j=0;
        while (!$rsQ->EOF)
        {
            $j++;
            //echo "<br>".$rsQ->fields['thn']." - ".$rsQ->fields['bln']." - ".$rsQ->fields['tgl'];

            $lama = $rsQ->fields['lama'];//(int)$conn->GetOne($sqlama);
        //echo "<br>$j - ".$rsQ->fields['STARTSPECDAY'].' - '.$rsQ->fields['ENDSPECDAY'].' - '.$lama;
            for($k=1; $k<$lama; $k++){
                $sqlcek = "
select dateadd(day,$k,STARTSPECDAY) as caritgl,".$rsQ->fields['DATEID']." as DATEID
from
(
/*
select
    a.userid as USERID,
    a.tglawal as STARTSPECDAY,
    a.tglawal as ENDSPECDAY,
    '7' as DATEID
from
    pe_rwttugas_person a left join
    pe_rwttugas b on a.nourut=b.nourut
where 	a.userid=$userid and
    b.jenistugas='X'

union all*/
select
    userid as USERID,
    tglawal as STARTSPECDAY,
    tglakhir  as ENDSPECDAY,
    jeniscuti as DATEID
from
    pe_rwtcuti_tanggal
where 	userid=$userid
) as USER_SPEDAY
where datediff(day,STARTSPECDAY,ENDSPECDAY)>1 and year(STARTSPECDAY)=".$rsQ->fields['thn']." and month(STARTSPECDAY)=".$rsQ->fields['bln']." and day(STARTSPECDAY)=".$rsQ->fields['tgl'];
                // echo "<br>$sqlcek";
        $DATAY = $conn->GetRow($sqlcek);
        if($in_tgl== substr($DATAY['caritgl'],0,10))
        {
                    $i =1;
                    $dateid = $DATAY['DATEID'];
        }
        //echo "<BR>$k ".substr($DATAY['caritgl'],0,10).' - '.$dateid;
    }//for
        $rsQ->MoveNext();
        } // end while
    }//if i==0
    return $i.','.$dateid;
}//end function

// fungsi untuk mendapatkan hari efektif
function Find_efective_day($conn,$r_tahun,$r_bulan,$opo) {
//$r_bulan = '05';//alphaNum($_REQUEST['bulan']);
//$r_tahun = 2012;//alphaNum($_REQUEST['tahun']);
$tahunbulan= $r_tahun.$r_bulan;
$anyDate = $r_tahun.'-'.$r_bulan.'-01';
$dayArray=array();
$dayArray=findFirstAndLastDay($anyDate);
$kolom =$dayArray[1];
//echo "<br>Tahun : $r_tahun , Bulan : $r_bulan";
//echo "<br>Tanggal 01  s/d $kolom";
$sql_A = "select
    day(tanggal) as tgl,
    month(tanggal)as bln,
       (cast(day(tanggal) as char(2))+'/'+ cast(month(tanggal) as char(2))) as data
from lv_hrlbrnas
where
    year(tanggal)=$r_tahun";

//echo "<br>$sql_A";
$rs = $conn->Execute($sql_A);
while($row = $rs->FetchRow())
{
$arr_tgl = $arr_tgl.$row['tgl'].'/'.$row['bln'].',';
//echo "<br>".$arr_tgl;
}
$hdata = explode(',',$arr_tgl);
for($tanggal=1; $tanggal<=$dayArray[1]; $tanggal++)// buat tgl 1 s/d tgl akhir bln
{
    $htime = mktime(0,0,0,$r_bulan,$tanggal,$r_tahun); // time of holiday
    $w = date('w', $htime); // get weekday of holiday
    if($tanggal<10) $tanggal = '0'.$tanggal; else $tanggal=$tanggal;

    if($w!=0 && $w!=6)
    {
        $jml_hari_efektif ++;
        $ar_monthB = $tanggal.'-'.$r_bulan.'-'.$r_tahun;
        foreach ($hdata as $h1) {
            $h = explode('/', $h1);
            if($h[0]<10) $day = '0'.$h[0]; else $day=$h[0];
            if($h[1]<10) $month = '0'.$h[1]; else $month=$h[1];
            if($month == $r_bulan and $day ==$tanggal){
                $jml_hari_libur ++;
                $monthA = $day.'-'.$month.'-'.$r_tahun;
                //echo "<br>$x get holiday : ".$monthA;
                //$data_hari_libur = $data_hari_libur.$monthA.',';
                $data_hari_libur = $data_hari_libur.$day.',';

            }//if hari libur
        }
        if($monthA<>$ar_monthB){//hari efektif
            //$data_hari_efektif = $data_hari_efektif.$ar_monthB.',';
            $data_hari_efektif = $data_hari_efektif.$tanggal.',';
            //echo "<br> $x - $w - ".$ar_monthB;

        }//if not hari libur
        else $jml_hari_efektif --;
    $x++;
    }//$w!=0 && $w!=6
    else
    { //if hari sabtu minggu
        $jml_hari_sabtu_minggu ++;
        //if($w==0)
        //echo "<br> $x - $w - $tanggal-$r_bulan-$r_tahun  Minggu";
        //else
        //echo "<br> $x - $w - $tanggal-$r_bulan-$r_tahun  Sabtu";
        $data_hari_sabtuminggu = $data_hari_sabtuminggu.$tanggal.',';
    $x++;
    }
} //loop for
//echo "<br>JML Sabtu/Minggu   : $jml_hari_sabtu_minggu -> $data_hari_sabtuminggu";
//echo "<br>JML Hari libur   	 : $jml_hari_libur -> $data_hari_libur";
//echo "<br>JML Hari Efektif   : $jml_hari_efektif -> $data_hari_efektif";
//return "<br>JML Hari Efektif   : $jml_hari_efektif -> $data_hari_efektif";
if($opo==1)
    return $jml_hari_efektif;
elseif($opo==2)
    return $data_hari_efektif;
else
    return $jml_hari_efektif.'-'.$data_hari_efektif;
}

function serries($arr_data,$name){
    $data_serries = '';
        foreach($arr_data as $tahun => $dttotal)
        {
            $data_serries .= '{ name :"'.$name.'", ';
            $data_serries .= 'data: [';
            foreach($dttotal as $ttotal)
            {
                if($ttotal<>'')
                $data_serries .=$ttotal.',';
                else
                $data_serries .='0,';
            }
        $data_serries[strlen($data_serries)-1] = ' ';
        $data_serries .=']},';
        }
        $data_serries[strlen($data_serries)-1] = ' ';
        return $data_serries;
}

function serriesx($arr_data,$name){
    $data_serries = '';
        //foreach($arr_data as $tahun => $dttotal)
        {
            $data_serries .= '{ name :"'.$name.'", ';
            $data_serries .= 'data: [';
            foreach($arr_data as $ttotal)
            {
                if($ttotal<>'')
                $data_serries .=$ttotal.',';
                else
                $data_serries .='0,';
            }
        $data_serries[strlen($data_serries)-1] = ' ';
        $data_serries .=']},';
        }
        $data_serries[strlen($data_serries)-1] = ' ';
        return $data_serries;
}
    function convertZero($item,$change='&nbsp;',$strict=false) {
        if($strict)
            $comp = '0';
        else
            $comp = 0;

        if($item == $comp)
            return $change;
        else
            return $item;
    }
    // format penulisan bilangan uang pada laporan
    function formatUang($item,$sepmode=0,$dashconv=true,$strict=false) {
        if(empty($item)) {
            if($dashconv)
                return convertZero($item,'-',$strict);
            else
                return 0;
        }
        else {
            if($sepmode == 0)
                $nf = number_format(abs($item),0,'.',',');
            else
                $nf = number_format(abs($item),0,',','.');

            if($item < 0)
                return '('.$nf.')';
            else
                return $nf;
        }
    }

    // format penulisan bilangan uang pada laporan (secara default)
    function formatRep($item,$format='',$convzero=false) {
        $nf = $item;

        if(strlen($item) != '') {
            $nf = abs($nf);
            if($format != 'xls')
                $nf = number_format($nf,0,',','.');

            if($item < 0)
                $nf = '('.$nf.')';
        }

        if($convzero and empty($nf))
            $nf = convertZero($nf);

        return $nf;
    }

    function skor2indeks($nilaikinerja,$jabfungsional) {
        if($nilaikinerja<60) return 0;
        else if($nilaikinerja>=60 and $nilaikinerja<70) return 0.5;
        else if($nilaikinerja>=70 and $nilaikinerja<80 and ($jabfungsional==1 or $jabfungsional==2)) return 0.7;
        else if($nilaikinerja>=70 and $nilaikinerja<80 and ($jabfungsional==3)) return 0.75;
        else if($nilaikinerja>=70 and $nilaikinerja<80 and ($jabfungsional==4 or $jabfungsional=='')) return 0.8;

        else if($nilaikinerja>=80 and $nilaikinerja<90 and ($jabfungsional==1 or $jabfungsional==2)) return 0.85;
        else if($nilaikinerja>=80 and $nilaikinerja<90 and ($jabfungsional==3 or $jabfungsional==4 or $jabfungsional=='')) return 0.9;

        else if($nilaikinerja>=90 and $nilaikinerja<100 and ($jabfungsional==1 or $jabfungsional==2)) return 0.9;
        else if($nilaikinerja>=90 and $nilaikinerja<100 and ($jabfungsional==3 or $jabfungsional==4 or $jabfungsional=='')) return 0.95;

        else return 1;
    }


# ANGKA KREDIT
    function getLevelByParent($conn, $parent){

        if($parent){
            $sql = "select levelnya from sak_unsur where idunsur = '$parent' ";
            $level = $conn->GetOne($sql);
            $levelnya = $level+1;
        }elseif(!$parent){
            $levelnya = 0;
        }

        return $levelnya;
    }

    function updateSK($conn, $iditem){
        if($iditem){
            $sql = "select k.skid, s.jenis, k.nip, s.refidkegiatan
                from sak_kegiatandosen k
                left join sak_sk s on s.skid = k.skid
                where iditem = '$iditem'";
            $sk = $conn->GetRow($sql);
            $skid = $sk['skid'];
            $nip = $sk['nip'];

            $record = array();
            if($skid){
                if($sk['jenis'] == "K"){ # Kolektif
                    # update refiditem di sk detail = nonaktifkan sk yg digunakan
                    $record['refiditem'] = $iditem;
                    $col = $conn->Execute("select * from sak_skdetail where skid = '$skid' and kode = '$nip' ");
                    $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                    $conn->Execute($p_svsql);

                    # check sk detail yg lain
                    $sql_check = "select skid from sak_skdetail where refiditem = '$iditem' and skid!='$skid'";
                    $skid_check = $conn->GetOne($sql_check);
                    if($skid_check){ # update mengaktifkan sk yang lama
                        $record = array();
                        $record['refiditem'] = null;
                        $col = $conn->Execute("select * from sak_skdetail where skid = '$skid_check'");
                        $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                        $conn->Execute($p_svsql);
                    }



                }elseif($sk['jenis'] == "P"){ # Personal
                    # update refidkegiatan di sk = nonaktifkan sk yg digunakan
                    $record['refidkegiatan'] = $iditem;
                    $col = $conn->Execute("select * from sak_sk where skid = '$skid'");
                    $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                    $conn->Execute($p_svsql);

                    # check sk yg lain
                    $sql_check = "select skid from sak_sk where refidkegiatan = '$iditem' and skid!='$skid'";
                    $skid_check = $conn->GetOne($sql_check);
                    if($skid_check){ # update mengaktifkan sk yang lama
                        $record = array();
                        $record['refidkegiatan'] = null;
                        $col = $conn->Execute("select * from sak_sk where skid = '$skid_check'");
                        $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                        $conn->Execute($p_svsql);
                    }
                }
            }else{ # jika sk dikosongkan = mengaktifkan sk yang lama
                if($sk['jenis'] == "K"){ # Kolektif
                    $sql_check = "select skid from sak_skdetail where refiditem = '$iditem'";
                    $skid_check = $conn->GetOne($sql_check);
                    if($skid_check){ # update mengaktifkan sk yang lama
                        $record = array();
                        $record['refiditem'] = null;
                        $col = $conn->Execute("select * from sak_skdetail where skid = '$skid_check'");
                        $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                        $conn->Execute($p_svsql);
                    }
                }elseif($sk['jenis'] == "P"){ # Personal
                    $sql_check = "select skid from sak_sk where refidkegiatan = '$iditem'";
                    $skid_check = $conn->GetOne($sql_check);
                    if($skid_check){ # update mengaktifkan sk yang lama
                        $record = array();
                        $record['refidkegiatan'] = null;
                        $col = $conn->Execute("select * from sak_sk where skid = '$skid_check'");
                        $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                        $conn->Execute($p_svsql);
                    }
                }
            }
        }
    }

    function deleteRefidkegiatan($conn, $iditems){
        if($iditems){
            //$sql = "select skid from sak_kegiatandosen where iditem in ('$iditems') ";
            $sql = "select k.skid, s.jenis, k.nip, s.refidkegiatan
                from sak_kegiatandosen k
                left join sak_sk s on s.skid = k.skid
                where iditem in ('$iditems') ";
            $rs = $conn->Execute($sql);
            while ($row = $rs->FetchRow())
            {# update mengaktifkan sk yang lama
                $id = $row['skid'];
                $nip = $row['nip'];
                if($row['jenis'] == "P"){ #personel
                    $record = array();
                    $record['refidkegiatan'] = null;
                    $col = $conn->Execute("select * from sak_sk where skid = '$id';");
                    $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                    $conn->Execute($p_svsql);
                }elseif($row['jenis'] == "K"){ #kolektif
                    $record = array();
                    $record['refiditem'] = null;
                    $col = $conn->Execute("select * from sak_skdetail where skid = '$id' and kode = '$nip' ");
                    $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                    $conn->Execute($p_svsql);
                }

            }
        }
    }

    function nullkegiatan($conn, $nip){
        $sql = "update sak_kegiatandosen
            set kreditjurusan = null, kreditfakultas = null, kreditinstitut = null, valid = null,
                validfakultas = null, validinstitut = null, level_check = '0'
            where nip = '$nip' and
            (refnourutakd is null or refnourutakd='')";
        $conn->Execute($sql);
    }

    function validPengajuanAK($k_pd, $k_pl, $k_pm, $k_td, $selisih_ak, $kreditb,$idjfungsional){
        # $kreditb >= 400 utk jabatan lektor kepala ke atas nilai max nya > 0

        $kum_PM = $kum_TD = 10;
        $kum_PD = $kum_PL = 0;
        $idj = $idjfungsional; //revisi yg semula berdasarkan jabfung asal dirubah ke jabfung tujuan
        if($idj==1){
            $kum_PD = 35; $kum_PL = 45;
        }else if($idj==2){
            $kum_PD = $kum_PL = 40;
        }elseif($idj==3){
            $kum_PD = 45; $kum_PL = 35;
        }elseif($idj==4){
            $kum_PD = 55; $kum_PL = 25;
        }

        # total pengajuan
        $totalp = $k_pd + $k_pl + $k_pm + $k_td;

        # PD 30%, PL 25%, PM 15%, TD 20%
        $message = '';
        # PD -> min
        if($k_pd >= ($selisih_ak*($kum_PD/100))){
            $valid_pd = true;
        }else{
            $valid_pd = false;
            $message .= 'Total Bidang Pendidikan Belum memenuhi. <br>';
        }

        # PL -> min
        if($k_pl >= ($selisih_ak*($kum_PL/100))){
            $valid_pl = true;
        }else{
            $valid_pl = false;
            $message .= 'Total Bidang Penelitian Belum memenuhi. <br>';
        }

        # PM -> max
        if($kreditb>=400){ # lektor kepala ke atas
            if($k_pm>0){
                $valid_pm = true;
            }else{
                $valid_pm = false;
                $message .= 'Total Bidang Pengembangan Masyarakat Belum memenuhi (Min>0). <br>';
            }
        }else{
            if(($k_pm >= ($selisih_ak*($kum_PM/100))) or ($k_pm <= ($selisih_ak*($kum_PM/100)))){
                $valid_pm = true;
            }else{
                $valid_pm = false;
                $message .= 'Total Bidang Pengembangan Masyarakat Belum memenuhi. <br>';
            }
        }

        # TD -> max
        if($kreditb>=400){ # lektor kepala ke atas
            if($k_td>0){
                $valid_td = true;
            }else{
                $valid_td = false;
                $message .= 'Total Bidang Penunjang Belum memenuhi (Min>0). <br>';
            }
        }else{
            if(($k_td >= ($selisih_ak*($kum_TD/100))) or ($k_td <= ($selisih_ak*($kum_TD/100)))){
                $valid_td = true;
            }else{
                $valid_td = false;
                $message .= 'Total Bidang Penunjang Belum memenuhi. <br>';
            }
        }

        # Check Nilai Pengajuan
        if($totalp>=$selisih_ak){
            $valid_nilai = true;
        }else{
            $valid_nilai = false;
            $message .= 'Total Nilai Pengajuan Belum memenuhi (Min = '.$selisih_ak.'). <br>';
        }

        if ($valid_pd && $valid_pl && $valid_pm && $valid_td && $valid_nilai)
            $valid=1;
        else
            $valid=0;

        return $valid.'|'.$message;


    }

    function deletefile($conn, $files, $c_dirfoto){
        if($files){
            $sql = "select namafile from sak_kegiatandosendetail where iditemdetail in ('$files') ";
            $rs = $conn->Execute($sql);
            while ($row = $rs->FetchRow())
            {# update mengaktifkan sk yang lama
                if(is_file($c_dirfoto.'makalah/'.trim($row['namafile']))){
                    unlink($c_dirfoto.'makalah/'.trim($row['namafile']));
                }
            }
        }
    }

    function getnilaikredit($conn, $nip, $kodekegiatan, $level){
        if($kodekegiatan == "XXXXX"){
            $kk = "";
        }else{
            $kk = " and p.kodekegiatan like ('$kodekegiatan%')";
        }

        if($level == "A"){ # default pengajuan untuk validasi level jurusan
            $kredit = "k.kredit";
            $valid = "";
        }elseif($level == "J"){ # default pengajuan untuk validasi level jurusan
            $kredit = "k.kreditadmin";
            $valid = "and k.validadmin = 1";
        }elseif($level == "F"){ # level jurusan untuk validasi level fakultas
            $kredit = "k.kreditjurusan";
            $valid = "and k.valid = 1 ";
        }elseif($level == "I"){ # level fakultas untuk validasi level institut
            $kredit = "k.kreditfakultas";
            $valid = "and k.validfakultas = 1 ";
        }elseif($level == "P"){ # level institut untuk validasi level jakarta
            $kredit = "k.kreditinstitut";
            $valid = "and k.validinstitut = 1 ";
        }

        $sql = "select sum($kredit)
            from v_kegiatandosenAK k
            join ms_penilaian p on p.idaturan = k.idaturan
            where k.nip = '$nip' and k.refnourutakd is null $valid $kk ";//idaturan in ($idaturans)";

            //echo $sql;
        $kredits = $conn->GetOne($sql);
        if($kredits)
            return $kredits;
        else
            return '--';
    }

    function getnilaikreditrecord($conn, $nip, $kodekegiatan, $level, $id){
        if($kodekegiatan == "XXXXX"){
            $kk = "";
        }else{
            $kk = " and p.kodekegiatan like ('$kodekegiatan%')";
        }

        if($level == "A"){ # default pengajuan untuk validasi level Admin
            $kredit = "k.kredit";
            $valid = "";
        }elseif($level == "J"){ # default pengajuan untuk validasi level jurusan
            $kredit = "k.kreditadmin";
            $valid = "and k.validadmin = 1 ";
        }elseif($level == "F"){ # level jurusan untuk validasi level fakultas
            $kredit = "k.kreditjurusan";
            $valid = "and k.valid = 1 ";
        }elseif($level == "I"){ # level fakultas untuk validasi level institut
            $kredit = "k.kreditfakultas";
            $valid = "and k.validfakultas = 1 ";
        }elseif($level == "P"){ # level institut untuk validasi level jakarta
            $kredit = "k.kreditinstitut";
            $valid = "and k.validinstitut = 1 ";
        }

        $sql = "select sum($kredit)
            from v_kegiatandosenAK k
            join ms_penilaian p on p.idaturan = k.idaturan
            where k.nip = '$nip' and k.refnourutakd = '$id' $valid $kk ";//idaturan in ($idaturans)";

            //echo $sql;
        $kredits = $conn->GetOne($sql);
        if($kredits)
            return $kredits;
        else
            return '--';
    }

    # untuk pengajuan
    function getAKbyKegiatan($conn, $nip, $kegiatan, $level){

        if($level == "A"){ # default pengajuan untuk validasi level jurusan
            $kredit = "k.kredit";
            $valid = "";
        }elseif($level == "J"){ # default pengajuan untuk validasi level jurusan
            $kredit = "k.kreditadmin";
            $valid = "and k.validadmin = 1 ";
        }elseif($level == "F"){ # level jurusan untuk validasi level fakultas
            $kredit = "k.kreditjurusan";
            $valid = "and k.valid = 1 ";
        }elseif($level == "I"){ # level fakultas untuk validasi level institut
            $kredit = "k.kreditfakultas";
            $valid = "and k.validfakultas = 1 ";
        }elseif($level == "P"){ # level institut untuk validasi level jakarta
            $kredit = "k.kreditinstitut";
            $valid = "and k.validinstitut = 1 ";
        }

        $sql = "select sum($kredit)
            from v_kegiatandosenAK k
            join ms_penilaian p on p.idaturan = k.idaturan
            where k.nip = '$nip' and k.idkegiatan = '$kegiatan' $valid  and (k.refnourutakd = '' or k.refnourutakd is null)";//idaturan in ($idaturans)";
        $kredits = $conn->GetOne($sql);
        if($kredits)
            return $kredits;
        else
            return '0';
    }

    function getpejabatpenetap($conn, $idsatker, $level){
        if($level == "J"){
            $sat = str_replace(',',"','",$idsatker);
            $satker = "and r.idjabatan = '76' and p.idsatker in ('$sat') ";
            $field = "p.nip+'_##_'+dbo.f_namalengkap(p.gelardepan,p.nama,p.gelarbelakang)+'_##_'+s.namasatker+'_##_'+p.karpeg";
        }elseif($level == "F"){
            $satker = "and r.idjabatan = '11' and s.parentsatker = '$idsatker' " ;
            $field = "p.nip+'_##_'+dbo.f_namalengkap(p.gelardepan,p.nama,p.gelarbelakang)+'_##_'+f.kdsatker+'_##_'+p.karpeg+'_##_'+s.namasatker";
        }elseif($level == "I" or $level == "P"){
            $satker = "and r.idjabatan = '01'";
            $field = "p.nip+'_##_'+dbo.f_namalengkap(p.gelardepan,p.nama,p.gelarbelakang)+'_##_'+p.karpeg+'_##_'+s.namasatker";
        }

        # jabatan struktural
        $sql = "select TOP 1 $field
            from pe_rwtjabatan r
            join ms_pegawai p on p.nip = r.nip
            join ms_satker s on s.idsatker = p.idsatker
            join ms_satker f on f.idsatker = s.parentsatker
            where r.tipejabatan = 'S' and r.valid = 1 $satker
            ORDER BY r.tmtjabatan ASC ";
        $row = $conn->GetOne($sql);
        return $row;
    }

    function getjabatanfungsional($conn, $nip){
        # mendapatkan data jabatan fungsional terakhir sebelumnya
        $sql_jbtn = "SELECT TOP 1 namajfungsional
                 FROM pe_rwtjabatan p
                 left join lv_jfungsional j on j.idjfungsional = p.idjabatan
                 WHERE p.nip = '$nip' AND p.valid = 1 AND p.tipejabatan = 'F'
                 ORDER BY p.tmtjabatan DESC, p.idjabatan";
        $row_j = $conn->GetOne($sql_jbtn);
        return $row_j;
    }

    function getpangkat($conn, $nip){
        # mendapatkan data pangkat terakhir sebelumnya
        $sql_pkt = "SELECT TOP 1 j.namapangkat+' (Gol.'+j.kodepangkat+')'
                 FROM pe_rwtpangkat p
                 left join lv_pangkat j on j.idpangkat = p.idpangkat
                 join ms_pegawai m on m.nip = p.nip
                 WHERE p.nip = '$nip' AND p.valid = 1
                 ORDER BY p.tmtpangkat DESC, p.idpangkat";
        $row_p = $conn->GetOne($sql_pkt);
        return $row_p;
    }

    function getParentAturan($conn, $paturan){
        $sql = "select namakegiatan from ms_penilaian where idaturan = $paturan ";
        $row = $conn->GetOne($sql);
        return $row;
    }

    function getKodekegiatan($conn, $idaturan){
        $sql = "select kodekegiatan from ms_penilaian where idaturan = $idaturan ";
        $row = $conn->GetOne($sql);
        return $row;
    }

    # Item berdasarkan jenis kegiatanx nya
    function getItem($conn, $nip, $tahun1, $tahun2, $tipe){
        $sql = "select *
                from sak_kegiatandosen k
                left join sak_sk s on s.skid = k.skid
                where k.nip = '$nip' and
                    k.idkegiatan = '$tipe' and
                    ((year(s.tglsk) between $tahun1 and $tahun2)
                    or (right(k.periodekd,4) between $tahun1 and $tahun2)
                    or
                    (year(k.tglmulai) between $tahun1 and $tahun2)
                    or
                    (year(k.tglselesai) between $tahun1 and $tahun2)
                    )
                "; //echo $sql;
        $row = $conn->GetArray($sql);
        return $row;
    }

    # nilai angka kredit
    function getDatajfpangkat($conn, $idj, $idp){ # idjabatanf, idpangkat
        $sql = "select n.*, j.namajfungsional, p.kodepangkat, p.namapangkat
            from sak_nilaiak n
            join lv_jfungsional j on j.idjfungsional = n.idjfungsional
            join lv_pangkat p on p.idpangkat = n.idpangkat
            where n.idjfungsional = '$idj' and n.idpangkat = '$idp'
            order by n.nilaiak ";
        $row = $conn->getRow($sql);
        return $row;
    }

    function checkSK($conn,$nosk){
        $sql = "select count(*)
            from sak_sk
            where rtrim(ltrim(lower(nosk))) = rtrim(ltrim(lower('$nosk'))) ";
        $jml_sk = $conn->GetOne($sql);
        if($jml_sk>0){ # sk sudah ada
            return false;
        }elseif($jml_sk<=0){ # sk belum ada
            return true;
        }
    }

    # Aturan Penilaian
    # 1st
    function getAKKUMSemua($conn,$nip,$statusp,$level_val,$refid){
        //$conn->debug=true;

        # KUM A => PD
        $rs_a  = getAturanItem($conn,$nip,"PD",$refid,$statusp,$level_val);
        $tot_a = 0;
        foreach($rs_a as $a){
            $data  = explode("_##_",getMaksKepatutan($conn,$a['idaturan']));
            $tot_a = $tot_a + getTOTAKKUM($conn,$nip,$a['idaturan'],$data[0],$data[1],"PD",$statusp,$level_val,$refid);
        }
        $tot_aa = $tot_a;

        # KUM B => PL
        $rs_b = getAturanItem($conn,$nip,"PL",$refid,$statusp,$level_val);
        $tot_b = 0;
        foreach($rs_b as $b){
            $data  = explode("_##_",getMaksKepatutan($conn,$b['idaturan']));
            $tot_b = $tot_b + getTOTAKKUM($conn,$nip,$b['idaturan'],$data[0],$data[1],"PL",$statusp,$level_val,$refid);
        }
        $tot_bb = $tot_b;

        # KUM C => PM
        $rs_c = getAturanItem($conn,$nip,"PM",$refid,$statusp,$level_val);
        $tot_c = 0;
        foreach($rs_c as $c){
            $data  = explode("_##_",getMaksKepatutan($conn,$c['idaturan']));
            $tot_c = $tot_c + getTOTAKKUM($conn,$nip,$c['idaturan'],$data[0],$data[1],"PM",$statusp,$level_val,$refid);
        }
        $tot_cc = $tot_c;


        # KUM D => TD
        $rs_d = getAturanItem($conn,$nip,"TD",$refid,$statusp,$level_val);
        $tot_d = 0;
        foreach($rs_d as $d){
            $data  = explode("_##_",getMaksKepatutan($conn,$d['idaturan']));
            $tot_d = $tot_d + getTOTAKKUM($conn,$nip,$d['idaturan'],$data[0],$data[1],"TD",$statusp,$level_val,$refid);
        }
        $tot_dd = $tot_d;

        return $tot_aa."_##_".$tot_bb."_##_".$tot_cc."_##_".$tot_dd;

    }

    # cari aturan berdasarkan KUM dan NIP
    # 2nd
    /*function getAturanItem($conn, $nip, $kum, $refid){
        $filter = "";
        if($refid){
            $filter .= " and k.refnourutakd = '$refid' ";
        }else{
            $filter .= " and k.refnourutakd is null ";
            $tgl = getTMT($conn,$nip);
            if($tgl){
                $filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    $filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }
        }

        $sql = "select distinct k.idaturan, p.kodekegiatan, p.namakegiatan, p.parentaturan, p.level, p.kodekegiatan,
            (select namakegiatan from ms_penilaian where idaturan = p.parentaturan) parentaturan1,
            (select parentaturan from ms_penilaian where idaturan = p.parentaturan) idparent,
            (select namakegiatan from ms_penilaian where idaturan = (select parentaturan from ms_penilaian where idaturan = p.parentaturan)) parentaturan2
            from sak_kegiatandosen k
            left join ms_penilaian p on p.idaturan = k.idaturan
            left join sak_sk s on s.skid = k.skid
            where k.idkegiatan ='$kum' and k.nip = '$nip'  $filter
            order by p.kodekegiatan,p.level "; //echo $sql."<br/><br/><br/>";
        $aturan = $conn->GetArray($sql);
        return $aturan;
    }*/
    function getAturanItem($conn, $nip, $kum, $refid, $statusp, $level_val, $notnullidpengajuan = 0, $default = ""){
        if($default == "filter"){
            $table = "v_kegiatandosenPAK3";
        } else {
            $table = "v_kegiatandosenPAK";
        }

        /*$filter = "";
        if($refid){
            $filter .= " and k.refnourutakd = '$refid' ";
        }else{
            $filter .= " and k.refnourutakd is null ";
            $tgl = getTMT($conn,$nip);
            if($tgl){
                $filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    $filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }
        }*/

        $filter = "";
        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            //$filter .= " and k.refnourutakd is null ";

            $tgl = getTMT($conn,$nip);
            if($tgl){
                //$filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
                $filter .= " and ( (CONVERT(VARCHAR(11),(k.tglmulai),120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    //$filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                    $filter .= " and ( (CONVERT(VARCHAR(11),(k.tglmulai),120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }

            # filter by level
            if($level_val == "A"){ # level validasi -> Admin menggunakan data  Pengajuan atau default
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data  Admin
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data  Jurusan
                $kreditfield = "k.kreditjurusan";
                $filter .= "";// and k.valid=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data  Fakultas
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data Institut
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }

        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "A"){ # level validasi -> Admin menggunakan data sama
                $kreditfield = "k.kreditadmin";
                $filter .= " and k.validadmin=1 ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
                $kreditfield = "k.kreditjurusan";
                $filter .= " and k.valid=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }
        }

        // $sql = "select distinct k.idaturan, p.kodekegiatan, p.namakegiatan, p.parentaturan, p.level, p.kodekegiatan,
            // (select namakegiatan from ms_penilaian where idaturan = p.parentaturan) parentaturan1,
            // (select parentaturan from ms_penilaian where idaturan = p.parentaturan) idparent,
            // (select namakegiatan from ms_penilaian where idaturan = (select parentaturan from ms_penilaian where idaturan = p.parentaturan)) parentaturan2
            // from sak_kegiatandosen k
            // left join ms_penilaian p on p.idaturan = k.idaturan
            // left join sak_sk s on s.skid = k.skid
            // where k.idkegiatan ='$kum' and k.nip = '$nip'  $filter
            // order by p.kodekegiatan,p.level "; //echo $sql."<br/><br/><br/>";

        if($notnullidpengajuan){
            // /* tambahan rahmad */
            $filter .= " and k.idpengajuan is not null";
            // /* end tambahan rahmad */
        }

        $sql = "select distinct k.idaturan, p.kodekegiatan, p.namakegiatan, p.parentaturan, p.level, p.kodekegiatan,
            (select namakegiatan from ms_penilaian where idaturan = p.parentaturan) parentaturan1,
            (select parentaturan from ms_penilaian where idaturan = p.parentaturan) idparent,
            (select namakegiatan from ms_penilaian where idaturan = (select parentaturan from ms_penilaian where idaturan = p.parentaturan)) parentaturan2
            from $table k
            join ms_penilaian p on p.idaturan = k.idaturan
            where p.kategori ='$kum' and k.nip = '$nip'  $filter
            order by p.kodekegiatan,p.level ";
            // echo '<br>getAturanItem : '.$sql;
//        dump($sql);
        $aturan = $conn->GetArray($sql);
        return $aturan;
    }

    # Maks nilai Angka Kredit
    # 3rd
    function getMaksKepatutan($conn, $idaturan){
        $sql = "select * from ms_penilaian where idaturan = $idaturan ";
        $aturan = $conn->GetRow($sql);

        if(!empty($aturan['nilaikepatutan'])){
            $nilaiMaks = floatval($aturan['kredit'])*$aturan['nilaikepatutan'];
        }else{
            $nilaiMaks = 'xxx';
        }

        if(!empty($aturan['ketkepatutan'])){
            $kepatutan = $aturan['ketkepatutan'];
        }else{
            $kepatutan = 'xxx';
        }

        return $nilaiMaks.'_##_'.$kepatutan;
    }

    # 4rd
    # untuk tampilan seluruh nya depan
    function getTOTAKKUM($conn,$nip,$aturan,$max,$kepatutan,$kum,$statusp,$level_val,$refid){
        $filter = "";

        if(!$refid){
            $tgl = getTMT($conn,$nip);
            if($tgl){
                //$filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    //$filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                    $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }
        }

        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }
        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= "";
            }
        }

        # filter by level
        if($level_val == "A"){ # level validasi -> Admin menggunakan data sama
            $kreditfield = "k.kreditadmin";
            $filter .="";// " and k.validadmin=1 ";
        }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
            $kreditfield = "k.kreditjurusan";
            $filter .= " and k.valid=1 ";
        }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
            $kreditfield = "k.kreditfakultas";
            $filter .= " and k.validfakultas=1 ";
        }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
            $kreditfield = "k.kreditinstitut";
            $filter .= " and k.validinstitut=1 ";
        }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
            $kreditfield = "k.kreditinstitut";
            $filter .= " and k.validinstitut=1 ";
        }

        if($kepatutan == "tahun" and $max !== "xxx"){ # tahun di tmt sk
            $sql = "select sum(kredit) kreditak, periodenya
                from (
                    select $kreditfield kredit,
                        case 	when lower(k.semester) like '%gasal%' then left(right(k.semester,9),4)
                            when lower(k.semester) like '%genap%' then right(k.semester,4)
                        end periodenya
                    from v_kegiatandosenPAK k
                    /*left join sak_sk s on s.skid = k.skid*/
                    where k.idkegiatan = '$kum'
                    and k.idaturan = $aturan
                    and k.nip = '$nip'
                    $filter
                ) p
                group by periodenya ";
            $nilai_ak = $conn->GetArray($sql);
            $tot_ak = 0;
            foreach($nilai_ak as $ak){
                $kredit = floatval($ak['kreditak']);
                if($kredit>=$max){
                    $tot_ak = $tot_ak + $max;
                }else{
                    $tot_ak = $tot_ak + $kredit;
                }
            }
            $total_ak = $tot_ak;
        }elseif($kepatutan == "semester" and $max !== "xxx"){ # semester di sk
            $sql = "select sum($kreditfield) kreditak, k.semester
                from v_kegiatandosenPAK k
                /*left join sak_sk s on s.skid = k.skid*/
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter
                group by k.semester "; //echo $sql;
            $nilai_ak = $conn->GetArray($sql);
            $tot_ak = 0;
            foreach($nilai_ak as $ak){
                $kredit = floatval($ak['kreditak']);
                if($kredit>=$max){
                    $tot_ak = $tot_ak + $max;
                }else{
                    $tot_ak = $tot_ak + $kredit;
                }
            }
            $total_ak = $tot_ak;
            //echo $total_ak."<br/>";
        }elseif($kepatutan == "penilaian" and $max !== "xxx"){ # setiap pengajuan angka kredit
            # belum spesifik tapi udah bner c :D
            $sql = "select sum($kreditfield) kreditak
                from v_kegiatandosenPAK k
                /*left join sak_sk s on s.skid = k.skid */
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter
                group by k.nip, k.idaturan ";
            $nilai_ak = $conn->GetArray($sql);
            $tot_ak = 0;
            foreach($nilai_ak as $ak){
                $kredit = floatval($ak['kreditak']);
                if($kredit>=$max){
                    $tot_ak = $tot_ak + $max;
                }else{
                    $tot_ak = $tot_ak + $kredit;
                }
            }
            $total_ak = $tot_ak;
        }elseif($kepatutan == "program" and $max !== "xxx"){
            # semua program yang ada
            $sql = "select sum($kreditfield) kreditak, k.iditem
                from v_kegiatandosenPAK k
                /*left join sak_sk s on s.skid = k.skid */
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter
                group by k.iditem ";
            $nilai_ak = $conn->GetArray($sql);
            $tot_ak = 0;
            foreach($nilai_ak as $ak){
                $kredit = floatval($ak['kreditak']);
                if($kredit>=$max){
                    $tot_ak = $tot_ak + $max;
                }else{
                    $tot_ak = $tot_ak + $kredit;
                }
            }
            $total_ak = $tot_ak;
        }elseif($kepatutan == "kegiatan" and $max !== "xxx"){
            $sql = "select sum($kreditfield) kreditak, k.iditem
                from v_kegiatandosenPAK k
                /*left join sak_sk s on s.skid = k.skid */
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter
                group by k.iditem ";
            $nilai_ak = $conn->GetArray($sql);
            $tot_ak = 0;
            foreach($tot_ak as $ak){
                $kredit = floatval($ak['kreditak']);
                $tot_ak = $tot_ak + $kredit;
            }
            $total_ak = $tot_ak;
        }elseif($kepatutan == "penghargaan" and $max !== "xxx"){
            $sql = "select sum($kreditfield) kreditak, k.iditem
                from v_kegiatandosenPAK k
                /*left join sak_sk s on s.skid = k.skid */
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter
                group by k.iditem ";
            $nilai_ak = $conn->GetArray($sql);
            $tot_ak = 0;
            foreach($nilai_ak as $ak){
                $kredit = floatval($ak['kreditak']);
                if($kredit>=$max){
                    $tot_ak = $tot_ak + $max;
                }else{
                    $tot_ak = $tot_ak + $kredit;
                }
            }
            $total_ak = $tot_ak;
        }elseif($kepatutan == "karya" and $max !== "xxx"){
            $sql = "select sum($kreditfield) kreditak, k.iditem
                from v_kegiatandosenPAK k
                /*left join sak_sk s on s.skid = k.skid*/
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter
                group by k.iditem ";
            $nilai_ak = $conn->GetArray($sql);
            $tot_ak = 0;
            foreach($nilai_ak as $ak){
                $kredit = floatval($ak['kreditak']);
                if($kredit>=$max){
                    $tot_ak = $tot_ak + $max;
                }else{
                    $tot_ak = $tot_ak + $kredit;
                }
            }
            $total_ak = $tot_ak;
        }elseif($max !== "xxx"){ # nilai max ada namun filternya tidak ada
            $sql = "select sum($kreditfield) kreditak
                from v_kegiatandosenPAK k
                /*left join sak_sk s on s.skid = k.skid*/
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter
                group by k.idaturan ";
            $nilai_ak = $conn->GetArray($sql);
            $tot_ak = 0;
            foreach($nilai_ak as $ak){
                $kredit = floatval($ak['kreditak']);
                if($kredit>=$max){
                    $tot_ak = $tot_ak + $max;
                }else{
                    $tot_ak = $tot_ak + $kredit;
                }
            }
            $total_ak = $tot_ak;
        }else{ # xxx atau tidak ada
            $sql = "select sum($kreditfield) kreditak
                from v_kegiatandosenPAK k
                /*left join sak_sk s on s.skid = k.skid */
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter
                group by k.idaturan ";
            $nilai_ak = $conn->GetArray($sql);
            $tot_ak = 0;
            foreach($nilai_ak as $ak){
                $kredit = floatval($ak['kreditak']);
                $tot_ak = $tot_ak + $kredit;
            }
            $total_ak = $tot_ak;
        }
        //echo '<br>getTOTAKKUM : '.$sql;
        return $total_ak;
    }

    # save sk atau detail sk di detail item
    function savedetailitem($conn,$nip,$iditem,$skid){//$conn->debug = true;
        $sql_j = "select * from sak_sk where skid = $skid";
        $r_j = $conn->GetRow($sql_j);

        $record = array();
        if($r_j['jenis'] == "K" and $r_j['kategori_sk'] == "PD"){ # kolektif khusus pendidikan sajo yg iso :D
            $sql_d = "select * from sak_skdetail where skid = $skid and kode = '$nip'";
            $r_d = $conn->GetArray($sql_d);

            foreach($r_d as $rd){
                $record['iditem'] = $iditem;
                $record['skid'] = $skid;
                $record['idskdetail'] = $rd['idskdetail'];
                $record['jenis'] = $r_j['jenis'];
                $record['kredit'] = $rd['nilai'];
                $record['idaturan'] = $r_j['idaturan'];
                $record['periodesk'] = $r_j['periodesk'];
                $record['t_userid'] = $_SESSION['SIP_USER'];
                $record['t_updatetime'] = date('Y-m-d H:i:s');
                $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                $col = $conn->Execute("select * from sak_kegiatandosendetail");
                $p_svsql = $conn->GetInsertSQL($col,$record,true); //echo $p_svsql;
                $conn->Execute($p_svsql);
            }
        }
    }

    function hapusDetailkegiatan($conn,$iditem){//$conn->debug = true; var_dump($iditem);
        $conn->Execute("delete from sak_kegiatandosendetail where iditem = $iditem ");
        //foreach($iditem as $id){
            //$sql = "select count(*) from sak_kegiatandosendetail where iditem = $id ";
            //$jml = $conn->GetOne($sql);

            //if($jml){
                //$conn->Execute("delete from sak_kegiatandosendetail where iditem = $id ");
            //}
        //}
    }

    # get data detail aturan
    function getDataAturan($conn,$idaturan){
        $sql = "select * from ms_penilaian where idaturan = $idaturan";
        $row = $conn->GetRow($sql);
//        echo "$sql";
        return $row;
    }

    # get item by idaturan
    function getItemByAturan($conn,$nip,$idaturan,$kum,$level_val,$statusp,$refid){
        $filter = "";
        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";

            $tgl = getTMT($conn,$nip);
            if($tgl){
                $filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    $filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }

            # filter by level
            if($level_val == "A"){ # level validasi -> Admin menggunakan data  Pengajuan atau default
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data  Admin
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data  Jurusan
                $kreditfield = "k.kreditjurusan";
                $filter .= "";// and k.valid=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data  Fakultas
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data Institut
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }

        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "A"){ # level validasi -> Admin menggunakan data sama
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
                $kreditfield = "k.kreditjurusan";
                $filter .= " and k.valid=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }
        }

        if($kum == "PD"){
            $filter .= " and k.idkegiatan = 'PD' ";
        }elseif($kum == "PL"){
            $filter .= " and k.idkegiatan = 'PL' ";
        }elseif($kum == "PM"){
            $filter .= " and k.idkegiatan = 'PM' ";
        }elseif($kum == "TD"){
            $filter .= " and k.idkegiatan = 'TD' ";
        }

        $sql = "select k.*, s.tmtsk, s.nosk
            from sak_kegiatandosen k
            left join sak_sk s on skid = k.skid
            where k.idkegiatan = '$kum'
                and k.idaturan = $idaturan
                and k.nip = '$nip'
                $filter ";
        $rows = $conn->GetArray($sql); //echo $sql;
        return $rows;
    }

    # data filter item by kepatutan
    function getFilterItemByKepatutan($conn,$nip,$aturan,$kepatutan,$kum,$statusp,$level_val,$refid, $default = ""){
        if($default == "filter"){
            $table = "v_kegiatandosenPAK3";
        } else {
            $table = "v_kegiatandosenPAK";
        }


        $filter = "";
        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";

            $tgl = getTMT($conn,$nip);
            if($tgl){
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }

            # filter by level
            if($level_val == "A"){ # level validasi -> Admin menggunakan data  Pengajuan atau default
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data  Admin
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data  Jurusan
                $kreditfield = "k.kreditjurusan";
                $filter .= "";// and k.valid=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data  Fakultas
                $kreditfield = "k.kreditfakultas";
                $filter .= "  and k.validfakultas = 1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data Institut
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut = 1 ";
            }

        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "A"){ # level validasi -> Admin menggunakan data sama
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
                $kreditfield = "k.kreditjurusan";
                $filter .= " and k.valid=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }
        }
        /* tambahan rahmad */
        $filter .= " and k.idpengajuan is not null ";
        /* end rahmad */

        if($kepatutan == "tahun"){ # tahun di tmt sk
            $sql = "select periodenya aturan2
                from (
                    select case 	when lower(k.semester) like '%gasal%' then left(right(k.semester,9),4)
                            when lower(k.semester) like '%genap%' then right(k.semester,4)
                        end periodenya
                    from $table k
                    /*left join sak_sk s on s.skid = k.skid*/
                    where k.idkegiatan = '$kum'
                    and k.idaturan = $aturan
                    and k.nip = '$nip'
                    $filter
                ) p
                group by periodenya "; //echo $sql.";<br/><br/>";
        }elseif($kepatutan == "semester"){ # semester di sk
            $sql = "select k.semester aturan2
                from $table k
                /*left join sak_sk s on s.skid = k.skid */
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter
                group by k.semester "; //echo "<br/><br/><br/><br/><br/><br/>".$sql.";<br/><br/>";
        }else{
            $sql = "select CONVERT(INT,k.iditem) aturan2
                from $table k
                /*left join sak_sk s on s.skid = k.skid*/
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip' /*s.nosk, s.pejabatpenetap*/
                $filter
                group by k.iditem "; //echo $sql.";<br/><br/>";
        }
//        dump($sql);

        $r_filter = $conn->GetArray($sql);
        return $r_filter;
    }

    # data kegiatan by filter kepatutan
    function getDataItemByFilterKepatutan($conn,$nip,$aturan,$kepatutan,$kum,$statusp,$level_val,$refid,$fils, $default = "default"){

        if($default == "filter"){
            $table = "v_kegiatandosenPAK3";
        } else {
            $table = "v_kegiatandosenPAK";
        }

        $filter = "";
        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";

            $tgl = getTMT($conn,$nip);
            if($tgl){
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }


            # filter by level
            if($level_val == "A"){ # level validasi -> Admin menggunakan data  Pengajuan atau default
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data  Admin
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data  Jurusan
                $kreditfield = "k.kreditjurusan";
                $filter .= " ";//and k.valid=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data  Fakultas
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data Institut
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }

        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "A"){ # level validasi -> Admin menggunakan data sama
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
                $kreditfield = "k.kreditjurusan";
                $filter .= " and k.valid=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }
        }

        if($kepatutan == "tahun"){ # tahun di tmt sk
            $filter .= " and ( case when lower(semester) like '%gasal%' then left(right(semester,9),4)
                    when lower(semester) like '%genap%' then right(semester,4)
                    end = '$fils' ) ";
        }elseif($kepatutan == "semester"){ # semester di sk
            $filter .= " and k.semester = '$fils' ";
        }else{
            $filter .=" and k.iditem = $fils ";
        }

        $sql = "select k.*, k.nosk, k.pejabatpenetap, (CONVERT(VARCHAR(11),k.tglmulai,120)) tmtsk, dbo.f_item(k.iditem) header
                from $table k
                /*left join sak_sk s on s.skid = k.skid */
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter ";
        /* tambahan rahmad */
        $sql .= " and idpengajuan is not null ";
        /* end tambahan */

        // echo $sql;

//        dump($sql);
        $items = $conn->GetArray($sql); //echo $sql.";<br/><br/>";
        return $items;
    }

    function getDetailKegiatan($conn,$nip,$aturan,$kepatutan,$kum,$statusp,$level_val,$refid,$fils){
        $parentaturan = $conn->getOne("select idaturan from ms_penilaian where kodekegiatan='$aturan'");
        $filter = "";
        $filterD = "";
        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";
            $filterD .= " and k.refnourutakd is null ";

            $tgl = getTMT($conn,$nip); //echo $tgl;
            if($tgl){
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
                $filterD .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip); //var_dump($rs_tugas);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                    $filterD .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }

            # filter by level
            if($level_val == "A"){ # level validasi -> Admin menggunakan data  Pengajuan atau default
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
                $filterD .= " and (
                            (
                                d.valid != 2
                                and d.validadmin !=2
                                and d.validfakultas !=2
                                and d.validinstitut !=2
                            )
                            or
                            (
                                d.valid is null
                                or d.validadmin is null
                                or d.validfakultas is null
                                or d.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data  Admin
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
                $filterD .= " and D.validadmin=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data  Jurusan
                $kreditfield = "k.kreditjurusan";
                $filter .= "";// and k.valid=1 ";
                $filterD .= " and d.valid=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data  Fakultas
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
                $filterD .= " and d.validfakultas=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data Institut
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
                $filterD .= " and d.validinstitut=1 ";
            }

        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            $filterD .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
                $filterD .= " and (
                            (
                                d.valid != 2
                                and d.validadmin !=2
                                and d.validfakultas !=2
                                and d.validinstitut !=2
                            )
                            or
                            (
                                d.valid is null
                                or d.validadmin is null
                                or d.validfakultas is null
                                or d.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "A"){ # level validasi -> Admin menggunakan data sama
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
                $filterD .= " and d.validadmin=1 ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
                $kreditfield = "k.kreditjurusan";
                $filter .= " and k.valid=1 ";
                $filterD .= " and d.valid=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
                $filterD .= " and d.validfakultas=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
                $filterD .= " and d.validinstitut=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
                $filterD .= " and d.validinstitut=1 ";
            }
        }

        if($kepatutan == "tahun"){ # tahun di tmt sk
            $filter .= " and ( case when lower(k.semester) like '%gasal%' then left(right(k.semester,9),4)
                    when lower(k.semester) like '%genap%' then right(k.semester,4)
                    end = '$fils' ) ";
            $filterD .= " and ( case when lower(k.semester) like '%gasal%' then left(right(k.semester,9),4)
                    when lower(k.semester) like '%genap%' then right(k.semester,4)
                    end = '$fils' ) ";
        }elseif($kepatutan == "semester"){ # semester di sk
            $filter .= " and k.semester = '$fils' ";
            $filterD .= " and k.semester = '$fils' ";
        }else{
            $filter .=" and k.iditem = $fils ";
            $filterD .=" and k.iditem = $fils ";
        }

        // $sql = "select *
            // from
            // (
                // /*SK Personal*/
                // select k.judul, '' kodedetail, '' namadetail, '' satuandetail, s.nosk, 'SK Personal' sk,
                    // k.iditem, '' iditemdetail, convert(int,k.iditem) idtrasn,
                    // replace('P'+cast(k.iditem as char),' ','') idtrasnp,
                    // k.kredit, k.kreditadmin, k.kreditjurusan, k.kreditfakultas, k.kreditinstitut,
                    // k.validadmin, k.valid, k.validfakultas, k.validinstitut, k.level_check, s.type_sk,
                    // k.keterangan, s.pejabatpenetap, (CONVERT(VARCHAR(11),s.tmtsk,120)) tmtsk, p.kodekegiatan, s.namask
                // from sak_kegiatandosen k
                // left join sak_sk s on s.skid = k.skid
                // left join ms_penilaian p on p.idaturan = s.idaturan
                // where s.jenis = 'P' and k.idkegiatan = '$kum' and k.idaturan = $aturan and k.idaturan = s.idaturan and k.nip = '$nip'
                // $filter

                // union all

                // /*SK Bersama M B U */
                // select '' judul, t.kodedetail, t.namadetail, t.satuandetail, s.nosk, 'SK Bersama' sk,
                    // d.iditem, cast(d.iditemdetail as char) iditemdetail, convert(int,d.iditemdetail) idtrasn,
                    // replace('K'+cast(d.iditemdetail as char),' ','') idtrasnp,
                    // d.kredit, d.kreditadmin, d.kreditjurusan, d.kreditfakultas, d.kreditinstitut,
                    // d.validadmin, d.valid, d.validfakultas, d.validinstitut, d.level_check, s.type_sk,
                    // k.keterangan, s.pejabatpenetap, (CONVERT(VARCHAR(11),s.tmtsk,120)) tmtsk, p.kodekegiatan, s.namask
                // from sak_kegiatandosendetail d
                // left join sak_sk s on s.skid = d.skid
                // left join ms_penilaian p on p.idaturan = s.idaturan
                // join sak_kegiatandosen k on k.skid = s.skid and k.iditem = d.iditem
                // left join sak_skdetail t on t.skid = s.skid and t.idskdetail = d.idskdetail
                // where s.jenis = 'K' and k.idkegiatan = '$kum' and k.idaturan = $aturan
                    // and (s.type_sk = 'M' or s.type_sk ='B' or s.type_sk ='U')
                    // and k.idaturan = d.idaturan and k.idaturan = s.idaturan and k.nip = '$nip'
                // $filterD

                // union all

                // /*SK Bersama Selain M B U */
                // select k.judul, '' kodedetail, '' namadetail, '' satuandetail, s.nosk, 'SK Personal' sk,
                    // k.iditem, '' iditemdetail, convert(int,k.iditem) idtrasn,
                    // replace('P'+cast(k.iditem as char),' ','') idtrasnp,
                    // k.kredit, k.kreditadmin, k.kreditjurusan, k.kreditfakultas, k.kreditinstitut,
                    // k.validadmin, k.valid, k.validfakultas, k.validinstitut, k.level_check, s.type_sk,
                    // k.keterangan, s.pejabatpenetap, (CONVERT(VARCHAR(11),s.tmtsk,120)) tmtsk, p.kodekegiatan, s.namask
                // from sak_kegiatandosen k
                // left join sak_sk s on s.skid = k.skid
                // left join ms_penilaian p on p.idaturan = s.idaturan
                // where s.jenis = 'K' and k.idkegiatan = '$kum' and k.idaturan = $aturan
                    // and (s.type_sk = 'L' or s.type_sk = '' or s.type_sk is null)
                    // and k.idaturan = s.idaturan and k.nip = '$nip'
                // $filter
            // ) p
            // order by p.sk, p.nosk, p.iditem";

        $sql = "select k.* from v_kegiatandosenPAK k where k.nip='$nip'
        and /*k.parentaturan='$parentaturan' */ k.idaturan=$aturan
        $filter order by k.sk,k.nosk,k.iditem";

        $items = $conn->GetArray($sql); //echo $sql.";<br/><br/>";
        return $items;
    }

    function getJMLDetKegPrSK($conn,$nip,$aturan,$kum,$statusp,$level_val,$refid,$nosk){
    //$conn->debug=true;
        $filter = "";
        $filterD = "";

        $filter .= " and k.nosk = '$nosk' ";
        $filterD .= " and k.nosk = '$nosk' ";
        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";
            $filterD .= " and k.refnourutakd is null ";

            $tgl = getTMT($conn,$nip); //echo $tgl;
            if($tgl){
                // $filter .= " and ( (CONVERT(VARCHAR(11),(case when s.tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
                // $filterD .= " and ( (CONVERT(VARCHAR(11),(case when s.tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
                $filterD .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip); //var_dump($rs_tugas);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    // $filter .= " and ( (CONVERT(VARCHAR(11),(case when s.tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                    // $filterD .= " and ( (CONVERT(VARCHAR(11),(case when s.tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                    $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                    $filterD .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }

            # filter by level
            if($level_val == "A"){ # level validasi -> Admin menggunakan data  Pengajuan atau default
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
                $filterD .= " and (
                            (
                                d.valid != 2
                                and d.validadmin !=2
                                and d.validfakultas !=2
                                and d.validinstitut !=2
                            )
                            or
                            (
                                d.valid is null
                                or d.validadmin is null
                                or d.validfakultas is null
                                or d.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data  Admin
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
                $filterD .= " and D.validadmin=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data  Jurusan
                $kreditfield = "k.kreditjurusan";
                $filter .= "";// and k.valid=1 ";
                $filterD .= " and d.valid=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data  Fakultas
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
                $filterD .= " and d.validfakultas=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data Institut
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
                $filterD .= " and d.validinstitut=1 ";
            }

        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            $filterD .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
                $filterD .= " and (
                            (
                                d.valid != 2
                                and d.validadmin !=2
                                and d.validfakultas !=2
                                and d.validinstitut !=2
                            )
                            or
                            (
                                d.valid is null
                                or d.validadmin is null
                                or d.validfakultas is null
                                or d.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "A"){ # level validasi -> Admin menggunakan data sama
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
                $filterD .= " and d.validadmin=1 ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
                $kreditfield = "k.kreditjurusan";
                $filter .= " and k.valid=1 ";
                $filterD .= " and d.valid=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
                $kreditfield = "k.kreditfakultas";
                $filter .= " and k.validfakultas=1 ";
                $filterD .= " and d.validfakultas=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
                $filterD .= " and d.validinstitut=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
                $filterD .= " and d.validinstitut=1 ";
            }
        }

        /*if($kepatutan == "tahun"){ # tahun di tmt sk
            $filter .= " and ( case when lower(k.semester) like '%gasal%' then left(right(k.semester,9),4)
                    when lower(k.semester) like '%genap%' then right(k.semester,4)
                    end = '$fils' ) ";
            $filterD .= " and ( case when lower(k.semester) like '%gasal%' then left(right(k.semester,9),4)
                    when lower(k.semester) like '%genap%' then right(k.semester,4)
                    end = '$fils' ) ";
        }elseif($kepatutan == "semester"){ # semester di sk
            $filter .= " and k.semester = '$fils' ";
            $filterD .= " and k.semester = '$fils' ";
        }else{
            $filter .=" and k.iditem = $fils ";
            $filterD .=" and k.iditem = $fils ";
        }*/

        // $sql = "select sum(p.jml) as jumlah
            // from
            // (
                // /*SK Personal*/
                // select count(*) jml
                // from sak_kegiatandosen k
                // left join sak_sk s on s.skid = k.skid
                // where s.jenis = 'P' and k.idkegiatan = '$kum' and k.idaturan = $aturan and k.idaturan = s.idaturan and k.nip = '$nip'
                // $filter

                // union all

                // /*SK Bersama M B U */
                // select count(*) jml
                // from sak_kegiatandosendetail d
                // left join sak_sk s on s.skid = d.skid
                // join sak_kegiatandosen k on k.skid = s.skid and k.iditem = d.iditem
                // left join sak_skdetail t on t.skid = s.skid and t.idskdetail = d.idskdetail
                // where s.jenis = 'K' and k.idkegiatan = '$kum' and k.idaturan = $aturan
                    // and (s.type_sk = 'M' or s.type_sk ='B' or s.type_sk ='U')
                    // and k.idaturan = d.idaturan and k.idaturan = s.idaturan and k.nip = '$nip'
                // $filterD

                // union all

                // /*SK Bersama Selain M B U */
                // select count(*) jml
                // from sak_kegiatandosen k
                // left join sak_sk s on s.skid = k.skid
                // where s.jenis = 'K' and k.idkegiatan = '$kum' and k.idaturan = $aturan
                    // /*and (s.type_sk = 'L' or s.type_sk = '' or s.type_sk is null)*/
                    // and (s.type_sk = 'L' or s.type_sk = '' or s.type_sk is null or s.type_sk ='S' or s.type_sk ='T')
                    // and k.idaturan = s.idaturan and k.nip = '$nip'
                // $filter

            // ) p ";
// if($aturan==30) $aturan = 29;
// if($aturan==33) $aturan = 32;

// from v_kegiatandosenPAK k
$sql = "select sum(p.jml) as jumlah
            from
            (
                select count(*) jml
                from v_kegiatandosenPAK k
                where k.idkegiatan = '$kum' and k.idaturan = $aturan and k.nip = '$nip'
                $filter
            ) p ";

        $items = $conn->GetOne($sql); //echo $sql.";<br/><br/>";
        return $items;
    }

    function updateIndukDetailItem($conn,$iditem,$f_kredit,$f_valid,$level_check){
        $sql = "select sum($f_kredit)
            from sak_kegiatandosendetail
            where iditem = $iditem and $f_valid = '1'";
        $kredit_item = $conn->GetOne($sql);

        if($kredit_item>0){
            $p_valsql = "update sak_kegiatandosen set $f_kredit = '$kredit_item', $f_valid = '1', level_check = '$level_check' where iditem = $iditem ";
            $conn->Execute($p_valsql);
        }elseif($kredit_item == 0){
            $p_valsql = "update sak_kegiatandosen set $f_kredit = '$kredit_item', $f_valid = '2', level_check = '$level_check' where iditem = $iditem ";
            $conn->Execute($p_valsql);
        }


    }


    #MSG
    // tampilkan pesan error
    function pgErrorN($conn,$tipe='simpan') {
        $errno = $conn->ErrorNo();
        $errmsg = $conn->ErrorMsg();

        if($fkey = strpos($errmsg,'DBSERROR:')) { // pesan tidak perlu diterjemahkan
            $start = $fkey + 9;
            $end = (strpos($errmsg,'CONTEXT')) - $start;
            $errview = trim(substr($errmsg,$start,$end));
            return messageN("ERROR: ".$errview,true);
        }

        switch($errno) {
            case -1:
                if($tipe == "hapus")
                    return messageN("ERROR: Data masih dijadikan referensi.",true);
                else
                    return messageN("ERROR: Terjadi kesalahan pada referensi data.",true);
            case -5: return messageN("ERROR: Terjadi duplikasi data.",true);
            case 0:
                if($tipe == "simpan")
                    return messageN("Penyimpanan data berhasil.");
                else if($tipe == "hapus")
                    return messageN("Penghapusan data berhasil.");
                else
                    return messageN("Operasi data berhasil.");
            default: return messageN("ERROR: Terjadi kesalahan pada operasi data.",true);
        }
    }

    // tampilkan pesan (misalnya error)
    function messageN($str,$error=false) {
        if($error)
            return $str."_##_2";//'<strong><font color="#FF0000" size="2">'.$str.'</font></strong>';
        else
            return $str."_##_1";//'<strong><font color="#00AA00" size="2">'.$str.'</font></strong>';
    }

    # untuk update data pegawai pangkat
    # jika pangkat lebih besar
    function updatePangkatPegawai($conn,$nip){
        $sql = "select max(idpangkat) idpangkat
            from
            (
                select idpangkat, 'SKCPNS' SK
                from pe_skcpns
                where nip = '$nip' and valid = '1'

                union all

                select idpangkat, 'SKPNS' SK
                from pe_skpns
                where nip = '$nip' and valid = '1'

                union all

                select max(idpangkat), 'PANGKAT' SK
                from pe_rwtpangkat
                where nip = '$nip' and valid = '1'
            ) S ";

        $pangkat_now = $conn->GetOne($sql);

        if($pangkat_now){
            $update = true;
        }else{
            $pangkat_now = '';
            $update = true;
        }

        if($update){
            $record = array();
            $record['pangkat_now'] = $pangkat_now;
            $col = $conn->Execute("select * from ms_pegawai where nip = '$nip' ");
            $p_svsql = $conn->GetUpdateSQL($col,$record,true);
            $conn->Execute($p_svsql);
        }
    }

    # untuk update data pegawai jfungsional
    # jika jfungsional lebih besar
    function updateJFungsionalPegawai($conn,$nip){
        $sql = "select min(idjabatan) idjabatan
                from pe_rwtjabatan
                where valid = 1 and tipejabatan = 'F' and nip = '$nip' ";
        $jfungsional_now = $conn->GetOne($sql);

        if($jfungsional_now){
            $update = true;
        }else{
            $jfungsional_now = '';
            $update = true;
        }

        if($update){
            $record = array();
            $record['jfungsional_now'] = $jfungsional_now;
            $col = $conn->Execute("select * from ms_pegawai where nip = '$nip' ");
            $p_svsql = $conn->GetUpdateSQL($col,$record,true);
            $conn->Execute($p_svsql);
        }
    }

    # untuk riwayat pangkat
    function riwayatPangkat($conn,$nip,$jenis,$pangkat){
        if($jenis=="P"){ # Pengajuan
            $filter = "";
        }elseif($jenis=="S"){ # Setuju
            $filter = " and p.idpangkat = $pangkat ";
        }

        # sql check riwayat pangkat
        $sql_c = "select count(*) from pe_rwtpangkat p where p.nip = '$nip' $filter "; //echo $sql_c;
        $count = $conn->GetOne($sql_c);
        if($count){# ada
            # riawayat pangkat
            $sql = "SELECT TOP 1 *, dbo.f_namalengkap(m.gelardepan,m.nama,m.gelarbelakang) nama,coalesce(rf.nilaitotalpusat,0) as nilaitotalpusat
                FROM pe_rwtpangkat p
                left join lv_pangkat j on j.idpangkat = p.idpangkat
                LEFT OUTER JOIN dbo.pe_rwtjabatan AS rf ON rf.nourutrj =
                          (SELECT     TOP (1) nourutrj
                            FROM          dbo.pe_rwtjabatan
                            WHERE      (nip = p.nip) AND (valid = 1) AND (tipejabatan = 'F')
                            ORDER BY tmtjabatan DESC, idjabatan)
                left join sak_nilaiAK n on n.idpangkat = j.idpangkat
                join ms_pegawai m on m.nip = p.nip
                WHERE p.nip = '$nip' AND p.valid = 1 $filter
                ORDER BY p.tmtpangkat DESC, p.idpangkat "; //echo "RWT PANGKAT : ".$sql;
            $rs = $conn->GetRow($sql);
        }else{# g ada
            # riwayat pns
            $sql = "SELECT TOP 1 *, dbo.f_namalengkap(m.gelardepan,m.nama,m.gelarbelakang) nama, tmtpns tmtpangkat ,coalesce(rf.nilaitotalpusat,0) as  nilaitotalpusat
                FROM pe_skpns p
                left join lv_pangkat j on j.idpangkat = p.idpangkat
                LEFT OUTER JOIN dbo.pe_rwtjabatan AS rf ON rf.nourutrj =
                          (SELECT     TOP (1) nourutrj
                            FROM          dbo.pe_rwtjabatan
                            WHERE      (nip = p.nip) AND (valid = 1) AND (tipejabatan = 'F')
                            ORDER BY tmtjabatan DESC, idjabatan)
                left join sak_nilaiAK n on n.idpangkat = j.idpangkat
                join ms_pegawai m on m.nip = p.nip
                WHERE p.nip = '$nip' AND p.valid = 1 $filter
                ORDER BY p.tmtpns DESC, p.idpangkat "; //echo "RWT PNS : ".$sql;
            $rs = $conn->GetRow($sql);
        }

        return $rs;
    }

    function xlsHTMLArray($html) {
        $data = array();

        $i = 1;
        $arrtr = explode('</tr>',$html);

        foreach($arrtr as $tr) {
            $j = 1;
            $arrtd = explode('</td>',$tr);

            foreach($arrtd as $td) {
                $posopn = strpos($td,'<td');
                if($posopn === false)
                    continue;

                $poscls = strpos(substr($td,$posopn),'>');
                if($poscls === false)
                    continue;

                $td = substr($td,$posopn+$poscls+1);

                $data[$i][$j] = $td;
                $j++;
            }

            $i++;
        }

        return $data;
    }

    function getIdAturan($kode,$conn){
        $sql = "SELECT idaturan from ms_penilaian where kodekegiatan = '$kode' ";//echo $sql;
        $row = $conn->GetOne($sql);
        return $row;
    }

    function dataPegawai($nip,$conn){
        $sql = "SELECT * from dbo.v_listpegawai where nip = '$nip'";
        $row = $conn->GetRow($sql);
        return $row;
    }

    function dataMhs($nim,$conn){
        $sql = "SELECT * from sak_mahasiswa where nrp_mahasiswa = '$nim'";
        $row = $conn->GetRow($sql);
        return $row;
    }

    function dataMatkul($kode,$conn){
        $sql = "SELECT * from sak_matakuliah where kode_matakuliah = '$kode'";
        $row = $conn->GetRow($sql);
        return $row;
    }

    function dataSK($nosk,$conn){
        $sql = "SELECT * from sak_sk where nosk = '$nosk'";
        $row = $conn->GetRow($sql);
        return $row;
    }

    function dataSKd($skid,$conn){
        $sql = "SELECT * from sak_sk where skid = '$skid'";
        $row = $conn->GetRow($sql);
        return $row;
    }

    function kkAturan($idAturan,$conn){
        $sql = "SELECT * from ms_penilaian where idaturan = '$idAturan'";
        $row = $conn->GetRow($sql);
        return $row;
    }

    # untuk memasukkan data SK ke item kegiatan dosen
    function itemAngkaKredit($skid,$nip,$jenissk,$idskdetail,$type,$conn){
        # get data sk
        $row_sk = dataSKd($skid,$conn);

        if($type == "S"){ # Save
            # cek kegiatan
            $csql = "select * from sak_kegiatandosen where skid = $skid and nip = '$nip' ";
            $row = $conn->GetRow($csql);

            if(!empty($row)){
                $item = $row['iditem'];
                if($jenissk == "K"){
                    # get nilai angka kredit by detail sk
                    $nilaiitem = getSumNilaiAKSKDetail($skid,$nip,$conn);

                    # update nilai angka kredit di item pengajuan angka kredit
                    $record = array();
                    $record['kredit'] = $nilaiitem;
                    $record['t_userid'] = $_SESSION['SIP_USER'];
                    $record['t_updatetime'] = date('Y-m-d H:i:s');
                    $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                    $col = $conn->Execute("select * from sak_kegiatandosen where iditem = $item ");
                    $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                    $conn->Execute($p_svsql);

                    # update detail item pengajuan angka kredit by detail sk
                    if($idskdetail){
                        # get data sk detail
                        $row_skd = SKDetail($idskdetail,$conn);

                        # cek detail kegiatan
                        $csql_d = "select * from sak_kegiatandosendetail where idskdetail = $idskdetail and skid = $skid and iditem = $item ";
                        $row_d = $conn->GetRow($csql_d);

                        if(!empty($row_d)){ //echo "kesini lho y";die();
                            $item_d = $row_d['iditemdetail'];
                            # update nilai kredit detail kegiatan
                            $record = array();
                            $record['kredit'] = $row_skd['nilai'];
                            $record['t_userid'] = $_SESSION['SIP_USER'];
                            $record['t_updatetime'] = date('Y-m-d H:i:s');
                            $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                            $col = $conn->Execute("select * from sak_kegiatandosendetail where iditemdetail = $item_d ");
                            $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                            $conn->Execute($p_svsql);

                            # update sk personal refidkegiatan
                            $record = array();
                            $record['refiditem'] = $item_d;
                            $col = $conn->Execute("select * from sak_skdetail where idskdetail = $idskdetail ");
                            $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                            $conn->Execute($p_svsql);
                        }else{
                            # insert detail hanya untuk selain PL karena PL tidak bisa ostosmastis :p
                            if($row_sk['kategori_sk'] != "PL"){
                                # insert detail kegiatan
                                $record = array();
                                $record['iditem'] = $item;
                                $record['skid'] = $skid;
                                $record['idskdetail'] = $idskdetail;
                                $record['jenis'] = $row_sk['jenis'];
                                $record['kredit'] = $row_skd['nilai'];
                                $record['idaturan'] = $row_sk['idaturan'];
                                $record['periodesk'] = $row_sk['periodesk'];
                                $record['t_userid'] = $_SESSION['SIP_USER'];
                                $record['t_updatetime'] = date('Y-m-d H:i:s');
                                $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                                $col = $conn->Execute("select * from sak_kegiatandosendetail");
                                $p_svsql = $conn->GetInsertSQL($col,$record,true);
                                $conn->Execute($p_svsql);

                                if($conn->ErrorNo() == 0) {
                                    if($itemd == '')
                                        $itemd = $conn->Insert_ID();

                                    # update sk personal refidkegiatan
                                    $record = array();
                                    $record['refiditem'] = $itemd;
                                    $col = $conn->Execute("select * from sak_skdetail where idskdetail = $idskdetail ");
                                    $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                                    $conn->Execute($p_svsql);
                                }
                            } # end of insert selain PL
                        } # end of data detail gak ada
                    } # end of detail sk

                # SK Personal
                }elseif($jenissk == "P"){ //echo "update";die();
                    # update nilai angka kredit di item pengajuan angka kredit
                    $record = array();
                    $record['judul'] = $row_sk['namask'];
                    $record['kredit'] = $row_sk['kredit'];
                    $record['semester'] = $row_sk['periodesk'];
                    $record['t_userid'] = $_SESSION['SIP_USER'];
                    $record['t_updatetime'] = date('Y-m-d H:i:s');
                    $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                    $col = $conn->Execute("select * from sak_kegiatandosen where iditem = $item ");
                    $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                    $conn->Execute($p_svsql);

                    # update sk personal refidkegiatan
                    $record = array();
                    $record['refidkegiatan'] = $item;
                    $col = $conn->Execute("select * from sak_sk where skid = $skid ");
                    $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                    $conn->Execute($p_svsql);
                }

            }else{ # belum ada
                # selain Penelitian
                if($row_sk['kategori_sk'] != "PL"){
                    if($jenissk == "K"){ //echo $skid."<br/>".$nip."<br/>".$idskdetail; //die();
                        # get nilai angka kredit by detail sk
                        $nilaiitem = getSumNilaiAKSKDetail($skid,$nip,$conn);

                        # get data sk detail
                        $row_skd = SKDetail($idskdetail,$conn);

                        # insert kegiatan
                        $record = array();
                        $record['idaturan'] = $row_sk['idaturan'];
                        $record['skid'] = $skid;
                        $record['judul'] = $row_sk['namask'];
                        $record['idkegiatan'] = $row_sk['kategori_sk'];
                        $record['kredit'] = $nilaiitem;
                        $record['semester'] = $row_sk['periodesk'];
                        $record['keterangan'] = $row_sk['keterangan'];
                        $record['nip'] = $row_skd['kode'];
                        $record['t_userid'] = $_SESSION['SIP_USER'];
                        $record['t_updatetime'] = date('Y-m-d H:i:s');
                        $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                        $col = $conn->Execute("select * from sak_kegiatandosen");
                        $p_svsql = $conn->GetInsertSQL($col,$record,true);
                        $conn->Execute($p_svsql);

                        if($conn->ErrorNo() == 0 and !$p_errcheck) {
                            if($item == '')
                                $item = $conn->Insert_ID();


                            if($item){
                                //if($row_sk['kategori_sk'] == "PD"){ # just Pendidikan Only
                                    # insert detail kegiatan
                                    $record = array();
                                    $record['iditem'] = $item;
                                    $record['skid'] = $skid;
                                    $record['idskdetail'] = $idskdetail;
                                    $record['jenis'] = $row_sk['jenis'];
                                    $record['kredit'] = $row_skd['nilai'];
                                    $record['idaturan'] = $row_sk['idaturan'];
                                    $record['periodesk'] = $row_sk['periodesk'];
                                    $record['t_userid'] = $_SESSION['SIP_USER'];
                                    $record['t_updatetime'] = date('Y-m-d H:i:s');
                                    $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                                    $col = $conn->Execute("select * from sak_kegiatandosendetail");
                                    $p_svsql = $conn->GetInsertSQL($col,$record,true);
                                    $conn->Execute($p_svsql);

                                    if($conn->ErrorNo() == 0) {
                                        if($itemd == '')
                                            $itemd = $conn->Insert_ID();

                                        # update sk personal refidkegiatan
                                        $record = array();
                                        $record['refiditem'] = $itemd;
                                        $col = $conn->Execute("select * from sak_skdetail where idskdetail = $idskdetail ");
                                        $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                                        $conn->Execute($p_svsql);
                                    }
                                //} # end of pendidikan Only
                                # selain pendidikan
                                //else{
                                    # update sk personal refidkegiatan
                                    //$record = array();
                                    //$record['refiditem'] = $item;
                                    //$col = $conn->Execute("select * from sak_skdetail where idskdetail = $idskdetail ");
                                    //$p_svsql = $conn->GetUpdateSQL($col,$record,true);
                                    //$conn->Execute($p_svsql);

                                //} # end of selain pendidikan
                            }

                        }


                    }elseif($jenissk == "P"){ //echo "insert";die();
                        # insert kegiatan
                        $record = array();
                        $record['idaturan'] = $row_sk['idaturan'];
                        $record['skid'] = $skid;
                        $record['judul'] = $row_sk['namask'];
                        $record['idkegiatan'] = $row_sk['kategori_sk'];
                        $record['kredit'] = $row_sk['kredit'];
                        $record['semester'] = $row_sk['periodesk'];
                        $record['keterangan'] = $row_sk['keterangan'];
                        $record['nip'] = $row_sk['penerima_sk'];
                        $record['t_userid'] = $_SESSION['SIP_USER'];
                        $record['t_updatetime'] = date('Y-m-d H:i:s');
                        $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                        $col = $conn->Execute("select * from sak_kegiatandosen");
                        $p_svsql = $conn->GetInsertSQL($col,$record,true);
                        $conn->Execute($p_svsql);

                        if($conn->ErrorNo() == 0 and !$p_errcheck) {
                            if($item == '')
                                $item = $conn->Insert_ID();

                            # update sk personal refidkegiatan
                            $record = array();
                            $record['refidkegiatan'] = $item;
                            $col = $conn->Execute("select * from sak_sk where skid = $skid ");
                            $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                            $conn->Execute($p_svsql);
                        }
                    }
                }# end of not PL
            } # end of belum ada
        }# end of add/edit item kegiatan by sk/skdetail
        elseif($type == "D"){
            if($jenissk == "P"){
                # cek data ada atau tidak
                $itemc = checkItem($skid,$nip,$conn);
                if(!empty($itemc)){
                    # Hanya PD
                    # Karena Hanya PD yang dilakukan Validasi sampek Detail
                    if($row_sk['kategori_sk'] == "PD"){
                        # Cek apakah sudah ada validasi pengajuan Angka Kredit / Sudah Digunakan
                        $item_c = checkItemBersih($skid,$nip,$conn);
                        if(!empty($item_c)){ # Belum digunakan
                            $item = $item_c['iditem'];
                            # delete item kegiatan
                            $conn->Execute("delete from sak_kegiatandosen where iditem=$item ");

                            # delete sk personal
                            $conn->Execute("delete from sak_sk where skid=$skid ");
                        }
                    }elseif($row_sk['kategori_sk'] != "PL"){
                        # delete sk personal
                        $conn->Execute("delete from sak_sk where skid=$skid ");
                    }
                }elseif(empty($itemc)){
                    # delete sk personal
                    $conn->Execute("delete from sak_sk where skid=$skid ");
                }
            }elseif($jenissk == "K"){
                # Delete SK tanpa detail bisa langsung di delete
                # Kalau SK ada detail maka harus delete detail
                # delete detail harus dicek ke item, apakah item digunakan atau tidak
                # sekarang di fungsi ini asumsinya delete detailnya

                # jika pendidikan
                # 0. cek detail item ada berapa
                # 1. kalau satu, bisa sekalian delete item kegiatannya juga beserta detail sk
                # 2. kalau lebih dari satu maka cuma delete detail item nya saja dan detail sk

                # jika bukan pendidikan
                # delete detail sk dan item

                if($row_sk['kategori_sk'] == "PD"){
                    # 0
                    $sql_c = "select count(*)
                        from sak_kegiatandosendetail
                        where iditem = (select iditem from sak_kegiatandosen where skid = $skid and nip = '$nip' )";
                    $jml_d = $conn->GetOne($sql_c);

                    if($jml_d == 1){ # 1
                        # cek data ada atau tidak
                        $rowd = checkItemDetail($skid,$nip,$idskdetail,$conn);
                        if(!empty($rowd)){ # data ada
                            # check data digunakan atau tidak
                            $row_d = checkItemDetailBersih($skid,$nip,$idskdetail,$conn);
                            if(!empty($row_d)){ # belum digunakan
                                $itemd = $row_d['iditemdetail'];
                                $item = $row_d['iditem'];

                                # delete detail item
                                $conn->Execute("delete from sak_kegiatandosendetail where iditemdetail = $itemd ");

                                # delete item
                                $conn->Execute("delete from sak_kegiatandosen where iditem = $item ");

                                # delete detail sk
                                $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");
                            }
                        }else{ # data tidak ada
                            # delete detail sk
                            $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");
                        }
                    }elseif($jml_d > 1){ # 2
                        # cek data ada atau tidak
                        $rowd = checkItemDetail($skid,$nip,$idskdetail,$conn);
                        if(!empty($rowd)){ # data ada
                            # check data digunakan atau tidak
                            $row_d = checkItemDetailBersih($skid,$nip,$idskdetail,$conn);
                            if(!empty($row_d)){ # belum digunakan
                                $itemd = $row_d['iditemdetail'];
                                $item = $row_d['iditem'];

                                # delete detail item
                                $conn->Execute("delete from sak_kegiatandosendetail where iditemdetail = $itemd ");

                                # delete detail sk
                                $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");

                                # update nilai kredit item
                                # get nilai angka kredit by detail sk
                                $nilaiitem = getSumNilaiAKSKDetail($skid,$nip,$conn);

                                # update nilai angka kredit di item pengajuan angka kredit
                                $record = array();
                                $record['kredit'] = $nilaiitem;
                                $record['t_userid'] = $_SESSION['SIP_USER'];
                                $record['t_updatetime'] = date('Y-m-d H:i:s');
                                $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                                $col = $conn->Execute("select * from sak_kegiatandosen where iditem = $item ");
                                $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                                $conn->Execute($p_svsql);
                            }
                        }else{ # data tidak ada
                            # delete detail sk
                            $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");
                        }
                    }else{ # data tidak ada
                        # delete detail sk
                        $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");

                    }
                }
                # penelitian
                else if($row_sk['kategori_sk'] == "PL"){
                    $itemc = checkItem($skid,$nip,$conn);
                    # Jika Item PL nya tidak ada
                    if(empty($itemc)){
                        # delete detail sk kolektif
                        $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");
                    }
                }
                # selain pendidikan dan selain penelitian
                else{
                    # cek data ada atau tidak
                    $itemc = checkItem($skid,$nip,$conn);
                    if(!empty($itemc)){
                        $sql_c = "select count(*)
                            from sak_kegiatandosendetail
                            where skid = $skid and idskdetail = $idskdetail ";
                        $jml_d = $conn->GetOne($sql_c);
                        // var_dump($jml_d);
                        if($jml_d == 1){//echo "1";die();
                            # delete detail item
                            $conn->Execute("delete from sak_kegiatandosendetail where idskdetail = $idskdetail and skid = $skid ");

                            # delete item
                            $conn->Execute("delete from sak_kegiatandosen where skid = $skid and nip = '$nip' ");

                            # delete detail sk
                            $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");
                        }elseif($jml_d>1){//echo "lebih dari 1";die();
                            # delete detail item
                            $conn->Execute("delete from sak_kegiatandosendetail where idskdetail = $idskdetail and skid = $skid ");

                            # delete detail sk
                            $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");

                            # update nilai kredit item
                            # get nilai angka kredit by detail sk
                            $nilaiitem = getSumNilaiAKSKDetail($skid,$nip,$conn);

                            # update nilai angka kredit di item pengajuan angka kredit
                            $record = array();
                            $record['kredit'] = $nilaiitem;
                            $record['t_userid'] = $_SESSION['SIP_USER'];
                            $record['t_updatetime'] = date('Y-m-d H:i:s');
                            $record['t_ipaddress'] = $_SERVER['REMOTE_ADDR'];
                            $col = $conn->Execute("select * from sak_kegiatandosen where skid = $skid and nip = '$nip' ");
                            $p_svsql = $conn->GetUpdateSQL($col,$record,true);
                        }else{ //echo "0";die();
                            # delete detail sk
                            $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");
                        }
                    }else{//echo "0";die();
                        # delete detail sk kolektif
                        $conn->Execute("delete from sak_skdetail where idskdetail = $idskdetail ");
                    }
                } # end of selain pendidikan
            } # end of kolektif
        } # end of delete
    }

    function checkItem($skid,$nip,$conn){
        # Cek apakah data ada
        $sql = "select * from sak_kegiatandosen where skid = $skid and nip = '$nip' ";
        $row = $conn->GetRow($sql);//echo $sql."<br/><br/><br/>";
        return $row;
    }

    function checkItemBersih($skid,$nip,$conn){
        # Cek apakah sudah ada validasi pengajuan Angka Kredit / Sudah Digunakan
        $sql = "select * from sak_kegiatandosen where skid = $skid and nip = '$nip'
            and kreditadmin is null
            and kreditjurusan is null
            and kreditfakultas is null
            and kreditinstitut is null
            and refnourutakd is null
            and idpengajuan is null ";
        $row = $conn->GetRow($sql);//echo $sql;
        return $row;
    }

    function checkItemDetail($skid,$nip,$idskdetail,$conn){
        # Cek apakah data ada
        $sql = "select d.*
            from sak_kegiatandosendetail d
            join sak_kegiatandosen k on k.iditem = d.iditem
                        and k.skid = d.skid
                        and k.nip = '$nip'
            where d.skid = $skid
            and d.idskdetail = $idskdetail ";
        $row = $conn->GetRow($sql); //echo $sql."<br/><br/><br/>";
        return $row;
    }

    function checkItemDetailBersih($skid,$nip,$idskdetail,$conn){
        # Cek apakah sudah ada validasi pengajuan Angka Kredit / Sudah Digunakan
        $sql = "select d.*
            from sak_kegiatandosendetail d
            join sak_kegiatandosen k on k.iditem = d.iditem
                        and k.skid = d.skid
                        and k.idpengajuan is null
                        and k.nip = '$nip'
            where d.kreditadmin is null
            and d.kreditjurusan is null
            and d.kreditfakultas is null
            and d.kreditinstitut is null
            and d.skid = $skid
            and d.idskdetail = $idskdetail ";
        $row = $conn->GetRow($sql); //echo $sql."<br/><br/><br/>";
        return $row;
    }

    function getSumNilaiAKSKDetail($skid,$nip,$conn){
        $sql = "select sum(nilai) from sak_skdetail where skid = $skid and kode = '$nip'";
        $jml = $conn->GetOne($sql);
        return $jml;
    }

    function SKDetail($idskdetail,$conn){
        $sql = "select * from sak_skdetail where idskdetail = $idskdetail";
        $row = $conn->GetRow($sql);
        return $row;
    }

    # update kegiatan pada saat pengajuan awal
    function updateKegiatanPengajuan($idpengajuan,$nip,$conn){
        $tgl = getTMT($conn,$nip);
        if($tgl){
            $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai ,120))> '$tgl' )  ";
        }

        $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
        if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
            foreach($rs_tugas as $tugas){
                $tglmulai = $tugas['tglmulai'];
                $tglselesai = $tugas['tglselesai'];
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
            }
        }

        //--data sak_skdetail--//
        $sql = "select iditem,tbl from v_kegiatandosenPAK k
            where (k.refnourutakd = '' or k.refnourutakd is null)
            and k.tbl='sak_skdetail'
            and k.kreditadmin is null
            and k.kreditjurusan is null
            and k.kreditfakultas is null
            and k.kreditinstitut is null
            and k.nip = '$nip' $filter " ;
        $row = $conn->GetArray($sql);
        $arr = array();
        foreach ($row as $rs) {
            $arr[] = $rs['iditem'];
        }
        $iditem = implode(',', $arr);
        if($iditem)
            $f = " and idskdetail in ($iditem) ";

        # data kegiatan yang belum digunakan untuk pengajuan
        $record = array();
        $record['idpengajuan'] = $idpengajuan;
        $col = $conn->Execute("select * from sak_skdetail
                    where (refnourutakd = '' or refnourutakd is null)
                    and kreditadmin is null
                    and kreditjurusan is null
                    and kreditfakultas is null
                    and kreditinstitut is null
                    and nip = '$nip' $f ");
        $p_svsql = $conn->GetUpdateSQL($col,$record,true); //echo $p_svsql;
        $conn->Execute($p_svsql);
        //--pe_detailkegdosennip--//
        $sql = "select iditem,tbl from v_kegiatandosenPAK k
            where (k.refnourutakd = '' or k.refnourutakd is null)
            and k.tbl='pe_detailkegdosennip'
            and k.kreditadmin is null
            and k.kreditjurusan is null
            and k.kreditfakultas is null
            and k.kreditinstitut is null
            and k.nip = '$nip' $filter " ;
        $row = $conn->GetArray($sql);
        $arr = array();
        foreach ($row as $rs) {
            $arr[] = $rs['iditem'];
        }
        $iditem = implode(',', $arr);
        if($iditem)
            $f = " and iditem in ($iditem) ";

        # data kegiatan yang belum digunakan untuk pengajuan
        $record = array();
        $record['idpengajuan'] = $idpengajuan;
        $col = $conn->Execute("select * from pe_detailkegdosennip
                    where (refnourutakd = '' or refnourutakd is null)
                    and kreditadmin is null
                    and kreditjurusan is null
                    and kreditfakultas is null
                    and kreditinstitut is null
                    and nippeneliti = '$nip' $f ");
        $p_svsql = $conn->GetUpdateSQL($col,$record,true); //echo $p_svsql;
        $conn->Execute($p_svsql);


    }

    # update kegiatan pada saat validasi pengajuan *untuk kasus item tambahan setelah penginputan pengajuan
    function updateKegiatanVal($idpengajuan,$nip,$conn){
        $tgl = getTMT($conn,$nip);
        if($tgl){
            $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
        }

        $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
        if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
            foreach($rs_tugas as $tugas){
                $tglmulai = $tugas['tglmulai'];
                $tglselesai = $tugas['tglselesai'];
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai ,120)) not between '$tglmulai' and '$tglselesai' )";
            }
        }
        //--sak_skdetail--//
        $sql = "select iditem from v_kegiatandosenPAK k
            where (k.refnourutakd = '' or k.refnourutakd is null)
            and k.tbl='sak_skdetail'
            and k.kreditadmin is null
            and k.kreditjurusan is null
            and k.kreditfakultas is null
            and k.kreditinstitut is null
            and k.nip = '$nip' $filter " ;
        $row = $conn->GetArray($sql);
        $arr = array();
        foreach ($row as $rs) {
            $arr[] = $rs['iditem'];
        }
        $iditem = implode(',', $arr);
        if($iditem)
            $f = " and idskdetail in ($iditem) ";

        # data kegiatan yang belum digunakan untuk pengajuan
        $record = array();
        $record['idpengajuan'] = $idpengajuan;
        $col = $conn->Execute("select * from sak_skdetail
                    where (refnourutakd = '' or refnourutakd is null)
                    and idpengajuan is null and nip = '$nip' $f");
        $p_svsql = $conn->GetUpdateSQL($col,$record,true);
        $conn->Execute($p_svsql);
        //--pe_detailkegdosennip--//
        $sql = "select iditem from v_kegiatandosenPAK k
            where (k.refnourutakd = '' or k.refnourutakd is null)
            and k.tbl='pe_detailkegdosennip'
            and k.kreditadmin is null
            and k.kreditjurusan is null
            and k.kreditfakultas is null
            and k.kreditinstitut is null
            and k.nip = '$nip' $filter " ;
        $row = $conn->GetArray($sql);
        $arr = array();
        foreach ($row as $rs) {
            $arr[] = $rs['iditem'];
        }
        $iditem = implode(',', $arr);
        if($iditem)
            $f = " and iditem in ($iditem) ";

        # data kegiatan yang belum digunakan untuk pengajuan
        $record = array();
        $record['idpengajuan'] = $idpengajuan;
        $col = $conn->Execute("select * from pe_detailkegdosennip
                    where (refnourutakd = '' or refnourutakd is null)
                    and idpengajuan is null and nippeneliti = '$nip' $f");
        $p_svsql = $conn->GetUpdateSQL($col,$record,true);
        $conn->Execute($p_svsql);

    }

    # update pas delete pengajuan penilaian angka kredit
    function updateNullKegiatan($idpengajuan,$nip,$conn){
        $record = array();
        $record['kreditjurusan'] 	= null;
        $record['kreditfakultas'] 	= null;
        $record['kreditinstitut'] 	= null;
        $record['valid'] 			= null;
        $record['validadmin'] 		= null;
        $record['validfakultas'] 	= null;
        $record['validinstitut'] 	= null;
        $record['idpengajuan'] 		= null;
        $col = $conn->Execute("select * from sak_skdetail
                    where idpengajuan = '$idpengajuan' and nip = '$nip' ");
        $p_svsql = $conn->GetUpdateSQL($col,$record,true);
        $conn->Execute($p_svsql);

        $col = $conn->Execute("select * from pe_detailkegdosennip
                    where idpengajuan = '$idpengajuan' and nippeneliti = '$nip' ");
        $p_svsql = $conn->GetUpdateSQL($col,$record,true);
        $conn->Execute($p_svsql);

        }

    # cek apakah semua item pengajuan belum divalidasi
    function cekValidasiKegiatanPengajuan($idpengajuan,$nip,$conn){
        $valid = false;

        $sqlj = "select count(*) from sak_skdetail where idpengajuan = '$idpengajuan' and nip = '$nip' ";
        $jmla = $conn->GetOne($sqlj);

        $sqlj = "select count(*) from pe_detailkegdosennip where idpengajuan = '$idpengajuan' and nippeneliti = '$nip' ";
        $jmlb = $conn->GetOne($sqlj);
        $jml  = $jmla + $jmlb;

        $sqljv = "select count(*)
            from v_kegiatandosenPAK
            where idpengajuan = '$idpengajuan' and nip = '$nip'
                /*and kreditadmin is null
                and kreditjurusan is null*/
                and kreditfakultas is null
                and kreditinstitut is null ";
        $jmlv = $conn->GetOne($sqljv);

        if($jml == $jmlv){
            $valid = true;
        }else{
            $valid = false;
        }

        return $valid;
    }

    # cek apakah semua item pengajuan sdh diberinilai baik valid maupun tidak valid, baikkredit 0 atau tdk
    # digunakan untuk status pengajuan apakah belum dinilai,proses dinilai atau sudah dinilai semua
    function cekStatusPengajuan($idpengajuan,$nip,$conn,$level){
        //$conn->debug=true;
        $status= ''; $whr = ''; $whr2= " AND kreditfakultas IS NOT NULL ";
        if($level=='I') {
            $whr  = " AND validfakultas=1 ";
            $whr2 = " AND kreditinstitut is not null ";
        }

        $sql = "SELECT (SELECT count(nip) FROM v_kegiatandosenPAK WHERE idpengajuan = a.nourutakd AND nip = a.nip $whr) AS jml,(SELECT count(nip)	FROM v_kegiatandosenPAK WHERE idpengajuan = a.nourutakd AND nip = a.nip $whr $whr2) AS jmln FROM sak_pengajuanAK a WHERE a.nourutakd='$idpengajuan'	";
        $jmlv = $conn->GetRow($sql);

        if($jmlv['jml'] == $jmlv['jmln'])
        {
            $status .= '<font color=green>Sudah dinilai semua</font>';
        }
        else if($jmlv['jml'] > $jmlv['jmln'] and $jmlv['jmln']>0)
        {
            $status .= '<font color=blue>Sedang dinilai</font>';
        }
        else
        {
            $status.= '<font color=red>Belum dinilai</font>';
        }
        return $status;
    }


    # untuk mengetahui apakah item masuk dalam pengajuan
    function getIdPengajuanItem($skid,$idskdetail,$nip,$conn){
        $sql = "select k.idpengajuan
            from v_kegiatandosenPAK k
            where k.skid = '$skid' and k.iditem = '$idskdetail' and nip = '$nip' ";
        $row = $conn->GetOne($sql); //echo $sql;
        return $row;
    }

    # Get Tanggal acuan pengajuan angka kredit by pangkat dan jabatan fungsional
    function getTMT($conn,$nip){
        # pangkat
        $sql_p = "select TOP 1 *
            from
            (
                select p.idpangkat, j.namapangkat, 'SKCPNS' SK, (CONVERT(VARCHAR(11),p.tmtcpns,120)) tmt, DATEDIFF(day,p.tmtcpns,GETDATE()) AS lama
                from pe_skcpns p
                left join lv_pangkat j on j.idpangkat = p.idpangkat
                where p.nip = '$nip' and p.valid = '1'

                union all

                select p.idpangkat, j.namapangkat, 'SKPNS' SK, (CONVERT(VARCHAR(11),p.tmtpns,120)) tmt, DATEDIFF(day,p.tmtpns,GETDATE()) AS lama
                from pe_skpns p
                left join lv_pangkat j on j.idpangkat = p.idpangkat
                where p.nip = '$nip' and p.valid = '1'

                union all

                select p.idpangkat, j.namapangkat, 'PANGKAT' SK, (CONVERT(VARCHAR(11),p.tmtpangkat,120)) tmt, DATEDIFF(day,p.tmtpangkat,GETDATE()) AS lama
                from pe_rwtpangkat p
                left join lv_pangkat j on j.idpangkat = p.idpangkat
                where p.nip = '$nip' and p.valid = '1'
            ) S
            order by idpangkat desc ";
        $rs_p = $conn->GetRow($sql_p); //echo $sql_p."<br/><br/><br/>";
        $idpangkat = $rs_p['idpangkat'];

        # jabatan fungsional
        $sql_j = "select TOP 1 p.idjabatan, j.namajfungsional, (CONVERT(VARCHAR(11),p.tmtjabatan,120)) tmt, DATEDIFF(day,p.tmtjabatan,GETDATE()) AS lama
                from pe_rwtjabatan p
                left join lv_jfungsional j on j.idjfungsional = p.idjabatan
                where p.nip = '$nip' and p.valid = '1' and p.tipejabatan = 'F' and p.idpangkat = '$idpangkat'
                order by idjabatan asc";
        $rs_j = $conn->GetRow($sql_j); //echo $sql_j."<br/><br/><br/>";

        //if(cekPangkatJFungsional($conn,$rs_p['idpangkat'],$rs_j['idjabatan'])){ # ada yang sesuai
        if(count($rs_p) and count($rs_j)){ # keduax ada nilainya
            if($rs_p['lama']>$rs_j['lama']){
                $tgl = $rs_p['tmt'];
            }elseif($rs_j['lama']>$rs_p['lama']){
                $tgl = $rs_j['tmt'];
            }elseif($rs_p['lama'] == $rs_j['lama']){
                $tgl = $rs_p['tmt'];
            }
        }else{ # tidak sesuai / tidak ada datanya
            if($rs_p['lama']){
                $tgl = $rs_p['tmt'];
            }elseif($rs_j['lama']){
                $tgl = $rs_j['tmt'];
            }else{
                $tgl = '';
            }
        }
        return $tgl;
    }

    function getRiwayatTugasBelajar($conn,$nip){
        $sql = "select (CONVERT(VARCHAR(11),tglmulai,120)) tglmulai, (CONVERT(VARCHAR(11),tglselesai,120)) tglselesai from pe_tugasbelajar where nip = '$nip'";
        $row = $conn->GetArray($sql); //echo $sql."<br/><br/><br/>";
        return $row;
    }

    # cek SK Jenjang Pendidikan
    function SKJenjangPendidikan($conn,$nip,$idaturan){
        $ok = false;

        $sql = "select TOP 1 idaturan, kodekegiatan, tmtsk
            from (
                select TOP 1 s.idaturan, p.kodekegiatan, (CONVERT(VARCHAR(11),s.tmtsk,120)) tmtsk
                from sak_sk s
                join ms_penilaian p on p.idaturan = s.idaturan
                where s.jenis = 'P' and s.penerima_sk = '$nip' and p.kodekegiatan like '101010%'
                order by s.tmtsk desc

                union all

                select TOP 1 s.idaturan, p.kodekegiatan, (CONVERT(VARCHAR(11),s.tmtsk,120)) tmtsk
                from sak_sk s
                join sak_skdetail d on d.skid = s.skid
                join ms_penilaian p on p.idaturan = s.idaturan
                where s.jenis = 'K' and d.kode = '$nip' and p.kodekegiatan like '101010%'
                order by s.tmtsk desc
            ) p
            order by p.tmtsk desc ";
        $pendpeg = $conn->GetRow($sql);

        # data aturan
        $sqk = "select kredit, kodekegiatan  from ms_penilaian where idaturan = $idaturan ";
        $kredit = $conn->GetRow($sqk);

        if($pendpeg['kodekegiatan'] == "1010101"){ # S3
            if($kredit['kodekegiatan'] == "1010101" or $kredit['kodekegiatan'] == "1010102" or $kredit['kodekegiatan'] == "1010103"){
                $nilai = "";
                $ok = false;
            }else{
                $nilai = $kredit['kredit'];
                $ok = true;
            }
        }elseif($pendpeg['kodekegiatan'] == "1010102"){ # S2
            if($kredit['kodekegiatan'] == "1010102" or $kredit['kodekegiatan'] == "1010103"){ # S2 & S1
                $nilai = "";
                $ok = false;
            }elseif($kredit['kodekegiatan'] == "1010101"){ # S3
                $nilai = $kredit['kredit']-150;
                $ok = true;
            }else{
                $nilai = $kredit['kredit'];
                $ok = true;
            }
        }elseif($pendpeg['kodekegiatan'] == "1010103"){ # S1
            if($kredit['kodekegiatan'] == "1010103"){ # S1
                $nilai = "";
                $ok = false;
            }elseif($kredit['kodekegiatan'] == "1010102"){ # S3
                $nilai = $kredit['kredit']-100;
                $ok = true;
            }elseif($kredit['kodekegiatan'] == "1010101"){ # S3
                $nilai = $kredit['kredit']-100;
                $ok = true;
            }else{
                $nilai = $kredit['kredit'];
                $ok = true;
            }
        }else{
            $nilai = $kredit['kredit'];
            $ok = true;
        }

        if($ok){
            return $nilai;
        }else{
            return false;
        }
    }

    function detailKum($conn,$nip,$idaturan){
        $sql_kode = "select kodekegiatan from ms_penilaian where idaturan = $idaturan ";
        $kode = $conn->GetOne($sql_kode);

        if($kode == "1010101" or $kode == "1010102" or $kode == "1010103"){
            if($kode == "1010101"){ # S3
                $s = "S3";
            }elseif($kode == "1010102"){ # S2
                $s = "S2";
            }elseif($kode == "1010103"){ # S1
                $s = "S1";
            }

            $sql_jenjang = "select * from pe_rwtpendidikan where nip = '$nip' and idpendidikan = '$s' ";
            $row = $conn->GetRow($sql_jenjang);

            $view = "";
            if($row){
                //$view .= "<br/><br/>";
                $view .= "Jurusan ".$row['jurusan']."<br/>";
                $view .= $row['namainstitusi']."<br/>";
                $view .= $row['alamatinstitusi']."<br/>";
                $view .= "No. Ijazah : ".$row['noijazah']."<br/>";
            }
        }

        return $view;
    }

    function getTampilItem($item,$type){
        $tampil = "";
        if($item['idkegiatan'] != "PD"){

            if($type == "j"){ # judul
                //$tampil .= ""; # belum diset
                if($item['jenis_pl'] == "MI"){
                    $tampil .=  "<span style=\"font-weight: bold;\"> - ".$item['namaitem']."</span><br/>";
                    $tampil .= "<div style=\"font-size: 11px; font-style: italic; padding-left:9px;\">".'" '.$item['judul'].' "'."</div>";
                    $tampil .= "<div style=\"font-size: 10px;\">";
                    $tampil .=  "<span style=\"font-weight: bold;\">Penulis</span> : ".$item['aktor']."</div>";
                    $tampil .=  "<div style=\"padding-top:6px;font-weight: bold;font-size: 10px; text-decoration:underline; color:#0E71A7;\">".$item['sumber']."</div><br/><br/>";
                }elseif($item['jenis_pl'] == "SM"){
                    $tampil .=  "<span style=\"font-weight: bold;\"> - ".$item['acara']."</span><br/>";
                    $tampil .= "<div style=\"font-size: 11px; font-style: italic; padding-left:9px;\">".'" '.$item['topik_acara'].' "'."</div>";
                    $tampil .= "<div style=\"font-size: 10px;\">";
                    $tampil .= "<div style=\"font-size: 11px;font-weight: bold;\">Judul Makalah : </div>";
                    $tampil .= "<div style=\"font-size: 11px; font-style: italic; padding-left:9px;\">".'" '.$item['judul'].' "'."</div>";
                    $tampil .= "<div style=\"font-size: 10px;\">";
                    $tampil .= "<div style=\"font-size: 10px;\">";
                    $tampil .=  "<span style=\"font-weight: bold;\">Penulis</span> : ".$item['aktor']."</div>";
                    $tampil .=  "<div style=\"padding-top:6px;font-weight: bold;font-size: 10px; text-decoration:underline; color:#0E71A7;\">".$item['sumber']."</div><br/><br/>";
                }else{
                    $tampil .= $item['judul'].$item['terlibat']."<br/><br/>";
                }
            }elseif($type == "k"){  # keterangan
                if($item['jenis_pl'] == "MI"){
                    $tampil .=  "<span style=\"font-weight: bold;\">".$item['header']." Vol ".$item['volume']."</span><br/>";
                    $tampil .= "ISSN ".$item['issn']."<br/>";
                    $prd = split("/",$item['periodekd']);
                    $tampil .= "<span style=\"font-size: 10px;\">".indoMonth($prd[0])." ".$prd[1]."</span><br/>";
                    $tampil .= "<span style=\"font-size: 10px; font-style: italic;\">Halaman (".$item['halaman'].")</span>";//<br/>";
                }elseif($item['jenis_pl'] == "SM"){
                    if(trim($item['publikasi']) == "Y"){
                        $tampil .= "- Copy : <br/>";
                        $tampil .= "&nbsp;&nbsp;- Sertifikat<br/>";
                        $tampil .= "&nbsp;&nbsp;- Cover & Daftar isi<br/>";
                        $tampil .= "&nbsp;&nbsp;- Jadwal Acara<br/>";
                        $tampil .= "&nbsp;&nbsp;- Makalah<br/><br/>";
                        //$tampil .= "- Halaman (".$item['halaman'].") dari ".$item['tebal'];
                    }elseif(trim($item['publikasi']) == "N"){
                        if($item['nosk']){
                            $tampil .= "- <span style=\"font-weight: bold;\">SK. ".$item['pejabatpenetap']."</span><br/>";
                            $tampil .= "&nbsp;&nbsp;<span style=\"font-size: 10px\">No. SK : ".$item['nosk']."</span><br/>";
                            $tampil .= "&nbsp;&nbsp;Tgl ".s_formatDateInd($item['tmtsk'])."<br/>";
                            $tampil .= "- <span style=\"font-weight: bold;\">Buku Laporan</span>";
                        }
                    }
                }else{
                    if($item['nosk']){
                        $tampil .= "<span style=\"font-weight: bold;\">- SK. ".$item['pejabatpenetap']."</span><br/>";
                        $tampil .= "&nbsp;<span style=\"font-size: 10px\">No. SK : ".$item['nosk']."</span><br/>";
                        $tampil .= "&nbsp;Tgl ".s_formatDateInd($item['tmtsk']);//."<br/>";
                        if($item['idkegiatan'] != "TD"){
                            $tampil .= "<br/>- <span style=\"font-weight: bold;\">Buku Laporan</span>";
                        }
                    }
                }
            }
        }elseif($item['idkegiatan'] == "PD"){
            $tampil .= "";
        }

        return $tampil;
    }

    # Jumlah total kredit per KUM terbaru

    function getDataKUM($conn,$nip,$jenisKegiatan){
        
        $sql = "SELECT nip, namalengkap, totalkuma, totalkumb, totalkumc, totalkumd
                FROM pe_capaiankumdosen
                WHERE nip = '$nip' AND tmtjfungsional = '$tmtjabfung'";

        $result = $conn->GetRow($sql);
        return $result;
    }

    # Jumlah total kredit per KUM tanpa Kepatutan
    function getKreditKUM($conn,$nip,$statusp,$level_val,$refid){

        # KUM A => PD
        $tot_aa = getTOTKreditKUM($conn,$nip,"PD",$statusp,$level_val,$refid);

        # KUM B => PL
        $tot_bb = getTOTKreditKUM($conn,$nip,"PL",$statusp,$level_val,$refid);

        # KUM C => PM
        $tot_cc = getTOTKreditKUM($conn,$nip,"PM",$statusp,$level_val,$refid);


        # KUM D => TD
        $tot_dd = getTOTKreditKUM($conn,$nip,"TD",$statusp,$level_val,$refid);

        return $tot_aa."_##_".$tot_bb."_##_".$tot_cc."_##_".$tot_dd;

    }

    # 4rd
    # untuk tampilan seluruh nya depan
    function getTOTKreditKUM($conn,$nip,$kum,$statusp,$level_val,$refid){
        $filter = "";
        //$conn->debug=true;
        if(!$refid){
            $tgl = getTMT($conn,$nip);
            if($tgl){
                //$filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    //$filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                    $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }
        }

        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }
        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= "";
            }
        }

        # filter by level
        if($level_val == "A"){ # level validasi -> Admin menggunakan data sama
            $kreditfield = "k.kreditadmin";
            $filter .="";// " and k.validadmin=1 ";
        }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
            $kreditfield = "k.kreditjurusan";
            $filter .= " and k.valid=1 ";
        }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
            $kreditfield = "k.kreditfakultas";
            $filter .= "";// and k.validfakultas=1 ";
        }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
            $kreditfield = "k.kreditinstitut";
            $filter .= " and k.validinstitut=1 ";
        }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
            $kreditfield = "k.kreditinstitut";
            $filter .= " and k.validinstitut=1 ";
        }

        $sql = "select sum($kreditfield) kreditak
            from v_kegiatandosenPAK k
            where k.idkegiatan = '$kum'
            and k.nip = '$nip'
            $filter
            group by k.nip, k.idkegiatan ";
//         if($kum == "PL"){
//            dump($sql);
//         }
        $total_ak = $conn->GetOne($sql);

        return floatval($total_ak);
    }


    # function perubahan cetak request tgl 11 Maret 2013
    # cari aturan berdasarkan KUM dan NIP
    # 2nd
    function getAturanKegiatan($conn, $nip, $kum, $refid, $level_val, $statusp, $tmtJabfung){
        $filter = "";
        //$conn->debug=true;
        if(!$refid){
            // $tgl = getTMT($conn,$nip);
            $tgl = $tmtJabfung;
            if($tgl){
                //$filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    //$filter .= " and ( (CONVERT(VARCHAR(11),(case when tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                    $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }
        }

        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }
        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= "";
            }
        }

        # filter by level
        if($level_val == "A"){ # level validasi -> Admin menggunakan data sama
            $kreditfield = "k.kreditadmin";
            $filter .="";// " and k.validadmin=1 ";
        }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
            $kreditfield = "k.kreditjurusan";
            $filter .= " and k.valid=1 ";
        }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
            $kreditfield = "k.kreditfakultas";
            $filter .= "";// and k.validfakultas=1 ";
        }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
            $kreditfield = "k.kreditinstitut";
            $filter .= " and k.validinstitut=1 ";
        }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
            $kreditfield = "k.kreditinstitut";
            $filter .= " and k.validinstitut=1 ";
        }

        if($kum == "PD"){
            $filter .= " and k.idkegiatan = 'PD' ";
        }elseif($kum == "PL"){
            $filter .= " and k.idkegiatan = 'PL' ";
        }elseif($kum == "PM"){
            $filter .= " and k.idkegiatan = 'PM' ";
        }elseif($kum == "TD"){
            $filter .= " and k.idkegiatan = 'TD' ";
        }

        // $sql = "select distinct SUBSTRING(p.kodekegiatan, 1, datalength(p.kodekegiatan)-2) kodekegiatan
            // from sak_kegiatandosen k
            // left join ms_penilaian p on p.idaturan = k.idaturan
            // left join sak_sk s on s.skid = k.skid
            // where k.nip = '$nip' $filter
            // order by p.kodekegiatan "; //echo $sql."<br/><br/><br/>"; cast(p.level as char(1))+

        // from v_kegiatandosenPAK k
        $sql = "SELECT SUBSTRING(p.kodekegiatan, 1, datalength(p.kodekegiatan)-2) kodekegiatan
            FROM v_kegiatandosenPAK k
            LEFT JOIN ms_penilaian p ON p.idaturan = k.idaturan
            WHERE k.nip = '$nip' $filter
            GROUP BY p.kodekegiatan
            ORDER BY p.kodekegiatan "; //echo $sql."<br/><br/><br/>"; cast(p.level as char(1))+
        $aturan = $conn->GetArray($sql);
        return $aturan;
    }

    function getAturanByKode($kode,$conn){
        $sql = "SELECT * from ms_penilaian where kodekegiatan = '$kode' ";//echo $sql;
        $row = $conn->GetRow($sql);
        return $row;
    }



    # data kegiatan by filter kepatutan
    function getItemByFilterKepatutan($conn,$nip,$aturan,$kepatutan,$kum,$statusp,$level_val,$refid,$fils){
        $filter = "";
        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";

            $tgl = getTMT($conn,$nip);
            if($tgl){
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    $filter .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }


            # filter by level
            if($level_val == "A"){ # level validasi -> Admin menggunakan data  Pengajuan atau default
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data  Admin
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data  Jurusan
                $kreditfield = "k.kreditjurusan";
                $filter .= "";// and k.valid=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data  Fakultas
                $kreditfield = "k.kreditfakultas";
                $filter .= "";// and k.validfakultas=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data Institut
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }

        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "A"){ # level validasi -> Admin menggunakan data sama
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
                $kreditfield = "k.kreditjurusan";
                $filter .= " and k.valid=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
                $kreditfield = "k.kreditfakultas";
                $filter .= "";// and k.validfakultas=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
            }
        }

        if($kepatutan == "tahun"){ # tahun di tmt sk
            $filter .= " and ( case when lower(semester) like '%gasal%' then left(right(semester,9),4)
                    when lower(semester) like '%genap%' then right(semester,4)
                    end = '$fils' ) ";
        }elseif($kepatutan == "semester"){ # semester di sk
            $filter .= " and k.semester = '$fils' ";
        }else{
            $filter .=" and k.iditem = $fils ";
        }

        $sql = "select k.*, k.nosk, k.pejabatpenetap, (CONVERT(VARCHAR(11),k.tglmulai,120)) tmtsk, dbo.f_item(k.iditem) header
                from v_kegiatandosenPAK k
                /*left join sak_sk s on s.skid = k.skid*/
                where k.idkegiatan = '$kum'
                and k.idaturan = $aturan
                and k.nip = '$nip'
                $filter ";
        $items = $conn->GetArray($sql); //echo $sql.";<br/><br/>";
        return $items;
    }

    function getDetKegiatan($conn,$nip,$aturan,$kum,$statusp,$level_val,$refid){
        $parentaturan = $conn->getOne("select idaturan from ms_penilaian where kodekegiatan='$aturan'");
    //$conn->debug=true;
        // var_dump($parentaturan);
        $filter = "";
        $filterD = "";
        if($statusp == "P"){ # Status Pengajuan => Proses / Masih diajukan
            $filter .= " and k.refnourutakd is null ";
            $filterD .= " and d.refnourutakd is null ";

            $tgl = getTMT($conn,$nip); //echo $tgl;
            if($tgl){
                // $filter .= " and ( (CONVERT(VARCHAR(11),(case when s.tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
                // $filterD .= " and ( (CONVERT(VARCHAR(11),(case when s.tmtsk is null then k.tglmulai else s.tmtsk end ),120))> '$tgl' )  ";
                $filter .= " and ( (CONVERT(VARCHAR(11),k.tmtsk,120))> '$tgl' )  ";
                $filterD .= " and ( (CONVERT(VARCHAR(11),k.tglmulai,120))> '$tgl' )  ";
            }

            $rs_tugas = getRiwayatTugasBelajar($conn,$nip); //var_dump($rs_tugas);
            if($rs_tugas and $kum != "PL"){ # ada tugas belajar & bukan penelitian
                foreach($rs_tugas as $tugas){
                    $tglmulai = $tugas['tglmulai'];
                    $tglselesai = $tugas['tglselesai'];
                    // $filter .= " and ( (CONVERT(VARCHAR(11),(case when s.tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                    // $filterD .= " and ( (CONVERT(VARCHAR(11),(case when s.tmtsk is null then k.tglmulai else s.tmtsk end ),120)) not between '$tglmulai' and '$tglselesai' )";
                    $filter .= " and ( (CONVERT(VARCHAR(11),k.tmtsk,120)) not between '$tglmulai' and '$tglselesai' )";
                    $filterD .= " and ( (CONVERT(VARCHAR(11),s.tglmulai,120)) not between '$tglmulai' and '$tglselesai' )";
                }
            }

            # filter by level
            if($level_val == "A"){ # level validasi -> Admin menggunakan data  Pengajuan atau default
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
                $filterD .= " and (
                            (
                                d.valid != 2
                                and d.validadmin !=2
                                and d.validfakultas !=2
                                and d.validinstitut !=2
                            )
                            or
                            (
                                d.valid is null
                                or d.validadmin is null
                                or d.validfakultas is null
                                or d.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data  Admin
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
                $filterD .= " and d.validadmin=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data  Jurusan
                $kreditfield = "k.kreditjurusan";
                $filter .= "";// and k.valid=1 ";
                $filterD .= " and d.valid=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data  Fakultas
                $kreditfield = "k.kreditfakultas";
                $filter .= "";// and k.validfakultas=1 ";
                $filterD .= " and d.validfakultas=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data Institut
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
                $filterD .= " and d.validinstitut=1 ";
            }

        }elseif($statusp == "S"){ # Status Pengajuan => Setuju
            $filter .= " and k.refnourutakd = $refid ";
            $filterD .= " and k.refnourutakd = $refid ";
            # filter by level
            if($level_val == "D"){ # level validasi -> Pengajuan atau default menggunakan data sama
                $kreditfield = "k.kredit";
                $filter .= " and (
                            (
                                k.valid != 2
                                and k.validadmin !=2
                                and k.validfakultas !=2
                                and k.validinstitut !=2
                            )
                            or
                            (
                                k.valid is null
                                or k.validadmin is null
                                or k.validfakultas is null
                                or k.validinstitut is null
                            )
                        ) ";
                $filterD .= " and (
                            (
                                d.valid != 2
                                and d.validadmin !=2
                                and d.validfakultas !=2
                                and d.validinstitut !=2
                            )
                            or
                            (
                                d.valid is null
                                or d.validadmin is null
                                or d.validfakultas is null
                                or d.validinstitut is null
                            )
                        ) ";
            }elseif($level_val == "A"){ # level validasi -> Admin menggunakan data sama
                $kreditfield = "k.kreditadmin";
                $filter .="";// " and k.validadmin=1 ";
                $filterD .= " and d.validadmin=1 ";
            }elseif($level_val == "J"){ # level validasi -> Jurusan menggunakan data sama
                $kreditfield = "k.kreditjurusan";
                $filter .= " and k.valid=1 ";
                $filterD .= " and d.valid=1 ";
            }elseif($level_val == "F"){ # level validasi -> Fakultas menggunakan data sama
                $kreditfield = "k.kreditfakultas";
                $filter .= "";// and k.validfakultas=1 ";
                $filterD .= " and d.validfakultas=1 ";
            }elseif($level_val == "I"){ # level validasi -> Institut menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
                $filterD .= " and d.validinstitut=1 ";
            }elseif($level_val == "P"){ # level validasi -> Pusat menggunakan data sama
                $kreditfield = "k.kreditinstitut";
                $filter .= " and k.validinstitut=1 ";
                $filterD .= " and d.validinstitut=1 ";
            }
        }

        if($kum == "PD"){
            //$orderby = "left(right(k.semester,9),9), left(right(k.semester,15),5), k.tglmulai,k.kodekegiatan, k.nosk+k.kodekegiatan+cast(k.idaturan as varchar(4))";
            $orderby = "left(right(k.semester,9),9), left(right(k.semester,15),5)
            , /*k.tglmulai,*/k.kodekegiatan, /*k.nosk+k.kodekegiatan+*/cast(k.idaturan as varchar(4))";
        }else{
            $orderby = "k.kodekegiatan,k.idaturan";
        }

// $sql = "select *
            // from
            // (

                // /*SK Bersama Selain M B U */
                // select s.namask judul, k.kodedetail, k.namadetail, k.satuandetail, s.nosk, 'SK Bersama' sk,
                    // k.idskdetail as iditem, cast(k.idskdetail as char) iditemdetail, convert(int,k.idskdetail) idtrasn,
                    // replace('K'+cast(k.idskdetail as char),' ','') idtrasnp,
                    // p.kredit, k.kreditadmin, k.kreditjurusan, k.kreditfakultas, k.kreditinstitut,
                    // k.validadmin, k.valid, k.validfakultas, k.validinstitut, k.level_check, s.type_sk,
                    // s.keterangan, s.pejabatpenetap, (CONVERT(VARCHAR(11),s.tmtsk,120)) tmtsk, p.kodekegiatan, s.namask,
                    // p.namakegiatan, s.periodesk as semester, dbo.f_item(s.skid) header, (case when s.idaturan is null then k.idaturandet else s.idaturan end ) idaturan,
                    // null as jenis_pl, null as publikasi, null as volume, null as halaman, null as tebal, null as issn, null as lokasi, null as aktor, s.tmtsk as tglmulai, s.tmtsk tglselesai, null as topik_acara, null as acara, null as edisi,
                    // null penerbit, null sumber, s.periodesk as periodekd, null as namaitem ,k.refnourutakd
                // from sak_skdetail k
                // join sak_sk s on s.skid = k.skid
                // join ms_penilaian p on p.idaturan = k.idaturandet
                // where s.jenis = 'K' and p.parentaturan='$parentaturan'
                // and k.nip = '$nip' $filter

                // union all

                // /*Tanpa SK */
                // select s.judul, '' kodedetail, '' namadetail, '' satuandetail, 'tidak ada SK dari profil ' as nosk, 'SK Personal' sk,
                    // s.iditem, '' iditemdetail, convert(int,s.iditem) idtrasn,
                    // replace('P'+cast(s.iditem as char),' ','') idtrasnp,
                    // p.kredit, d.kreditadmin, d.kreditjurusan, d.kreditfakultas, d.kreditinstitut,
                    // d.validadmin, d.valid, d.validfakultas, d.validinstitut, d.level_check, s.idkegiatan as type_sk,
                    // s.keterangan,'tidak ada penetap' as pejabatpenetap, (CONVERT(VARCHAR(11),s.tglmulai,120)) tmtsk, p.kodekegiatan, s.namaitem as namask,p.namakegiatan
                    // ,case when MONTH(tglmulai)<=6 then 'Semester Genap '+CAST((year(tglmulai)-1) as varchar(4))+'/'+CAST((year(tglmulai)) as varchar(4))
                    // else  'Semester Gasal '+CAST((year(tglmulai)) as varchar(4))+'/'+CAST((year(tglmulai)+1) as varchar(4))  end as semester, dbo.f_item(d.iditem) header, (case when s.idaturan is null then s.idaturan else s.idaturan end ) idaturan,
                    // null as jenis_pl, s.media_publikasi as publikasi, s.volume, s.halaman, s.tebal, s.issn, s.lokasi, s.aktor, s.tglmulai, s.tglselesai, null as topik_acara, null as acara, s.edisi,
                    // null as penerbit, null as sumber
                    // ,case when MONTH(tglmulai)<=6 then 'Semester Genap '+CAST((year(tglmulai)-1) as varchar(4))+'/'+CAST((year(tglmulai)) as varchar(4))
                    // else  'Semester Gasal '+CAST((year(tglmulai)) as varchar(4))+'/'+CAST((year(tglmulai)+1) as varchar(4))  end as periodekd, s.namaitem ,d.refnourutakd
                // from pe_detailkegdosennip d
                // join pe_detailkegdosen s on s.iditem = d.iditem
                // join ms_penilaian p on p.idaturan = s.idaturan
                // /*and p.kodekegiatan like '$aturan%' */
                // and p.parentaturan='$parentaturan'
                // where d.nippeneliti = '$nip' $filterD

            // ) p
            // order by $orderby";

        // from v_kegiatandosenPAK k
        $sql = "select k.* from v_kegiatandosenPAK k where k.nip='$nip' and k.parentaturan='$parentaturan' $filter order by $orderby";
        $items = $conn->GetArray($sql); //echo $sql.";<br/><br/>";
        // echo $sql;
        return $items;
        // var_dump($sql);
    }

    function getJurusan($conn, $nosk, $type){
        if($type == "M"){
            $table = "sak_matakuliah";
            $f1 = "idsatker";
            $f2 = "kode_matakuliah";
        }elseif($type == "B" or $type == "U"){
            $table = "sak_mahasiswa";
            $f1 = "kode_jurusan";
            $f2 = "nrp_mahasiswa";
        }

        $sql = "select top 1 t.namasatker
            from ms_satker t
            join $table m on t.idsatker = m.$f1
            where m.$f2 = (select top 1 d.kodedetail
                        from sak_skdetail d
                        join sak_sk s on s.skid = d.skid
                        where s.nosk = '$nosk')";
        $jurusan = $conn->GetOne($sql);

        if($jurusan)
            echo strtoupper(" - ".$jurusan);
        else
            echo "";
    }

    function getRealIpAddr()
    {
        $headers = apache_request_headers();
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif (empty($headers)) {
          $ip=$headers["X-Forwarded-For"];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function get_Absensi_new($conn,$nipx,$r_tahun,$r_bulan,$r_tanggal)//khusus utk pns n hon non shift
    {
        // $tabel = "PersonalLog";
        // if($r_tahun<=2013)
        // $tabel = "PersonalLogOLD";
        // $dataP = $conn->GetRow("select * from v_listpegawai where nip='".$nipx."'");
        // $fingerid 				= $dataP['fingerid'];
        // $datasetting			= $conn->GetRow("select * from ms_setting where tahun=".$r_tahun);//date("Y"));
        // $jabatan 				= $conn->GetOne("select namajfungsional from v_datapegawai where nip='".$nipx."'");

        // $paramtepatwaktu1 		= konversitime2detik($datasetting['jammasuk']);
        // $paramtepatwaktu2 		= konversitime2detik($datasetting['jammasuk']);
        // $paramtepatwaktujumat 	= konversitime2detik($datasetting['jammasukjumat']);
        // $paramtepatwaktukhusus	= konversitime2detik($datasetting['jammasukkhusus']);
        // $parampulang     		= konversitime2detik($datasetting['jampulang']);
        // $parampulangkhusus		= konversitime2detik($datasetting['jampulangkhusus']);
        // $paramlamakerja			= $parampulang-$paramtepatwaktu1-3600;
        // $paramlamakerjajumat	= $parampulang-$paramtepatwaktujumat-3600;
        // $paramlamakerjakhusus	= $parampulangkhusus-$paramtepatwaktukhusus-3600;
        // $param_no_absen_plg 	= konversitime2detik($datasetting['noabsenpulang']);
        // $batasTL1 				= konversitime2detik('09:00:00');
        // $batasTL2 				= konversitime2detik('09:30:00');
        // $batasPSW1				= konversitime2detik('15:30:00');
        // $batasPSW2				= konversitime2detik('15:00:00');
        // $batasPSW3				= konversitime2detik('14:30:00');

// if( (int) $r_bulan<=7)
        // $SQL = "select
// case when dtmasuk=dtpulang then dtmasuk+'#1'
// else dtmasuk+'#0' end as dtmasuk,
// dtpulang

 // from (select top 1
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+b.description as msk from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal and fingerprintid=$fingerid order by datetime) as dtmasuk,
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+b.description as plg from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal and fingerprintid=$fingerid order by datetime desc) as dtpulang
                 // from $tabel ) as x";
// else
        // $SQL = "select * from dbo.f_kehadiran($fingerid,$r_tahun ,$r_bulan,$r_tanggal)";
        $SQL = "select * from dbo.f_kehadiran($fingerid,$r_tahun ,$r_bulan,$r_tanggal)";
        $data = $conn->GetRow($SQL);


        $pchmsk = explode('-',trim($data['dtmasuk']));
        $pchplg = explode('-',trim($data['dtpulang']));

        if(!empty($data['dtmasuk'])){
            $dtkmsk			= konversitime2detik($pchmsk[0]);
            $dtkplg			= konversitime2detik($pchplg[0]);
            $batas			= 3600 * 12;

            $jammsk			= $pchmsk[0];
            $id_terminal_msk= $pchmsk[1];
            $nm_terminal_msk= $pchmsk[2];

            $jamplg			= $pchplg[0];
            $id_terminal_plg= $pchplg[1];
            $nm_terminal_plg= $pchplg[2];
            if(1==1){
                $mecah = explode('#',$nm_terminal_msk);
                if($mecah[1]==1){//if ada satu record
                    if($dtkmsk<=$batas){
                        $jammsk			= $jammsk;
                        $id_terminal_msk= $id_terminal_msk;
                        $nm_terminal_msk= $nm_terminal_msk;
                        $jamplg			= '';
                        $id_terminal_plg= '';
                        $nm_terminal_plg= '';
                    }else{
                        $jammsk			= '';
                        $id_terminal_msk= '';
                        $nm_terminal_msk= '';
                        $jamplg			= $jamplg;
                        $id_terminal_plg= $id_terminal_plg;
                        $nm_terminal_plg= $nm_terminal_plg;
                    }
                }else{//if > 1 record


                }
            }else{
                if($data['dtmasuk']==$data['dtpulang']){
                    $jamplg			= '';
                    $id_terminal_plg= '';
                    $nm_terminal_plg= '';
                }else{
                    $jamplg			= $pchplg[0];
                    $id_terminal_plg= $pchplg[1];
                    $nm_terminal_plg= $pchplg[2];
                }
            }
        return $jammsk.'-'.$id_terminal_msk.'-'.$nm_terminal_msk.'-'.$jamplg.'-'.$id_terminal_plg.'-'.$nm_terminal_plg;
        }
    }

    function get_Absensi($conn,$nipx,$r_tahun,$r_bulan,$r_tanggal)
    {
        $tabel = "PersonalLog";
        if($r_tahun<=2013)
        $tabel = "PersonalLogOLD";
        $dataP = $conn->GetRow("select * from v_listpegawai where nip='".$nipx."'");
        $fingerid 				= $dataP['fingerid'];
        // $datasetting			= $conn->GetRow("select * from ms_setting where tahun=".$r_tahun);//date("Y"));
        // $jabatan 				= $conn->GetOne("select namajfungsional from v_datapegawai where nip='".$nipx."'");

        // $paramtepatwaktu1 		= konversitime2detik($datasetting['jammasuk']);
        // $paramtepatwaktu2 		= konversitime2detik($datasetting['jammasuk']);
        // $paramtepatwaktujumat 	= konversitime2detik($datasetting['jammasukjumat']);
        // $paramtepatwaktukhusus	= konversitime2detik($datasetting['jammasukkhusus']);
        // $parampulang     		= konversitime2detik($datasetting['jampulang']);
        // $parampulangkhusus		= konversitime2detik($datasetting['jampulangkhusus']);
        // $paramlamakerja			= $parampulang-$paramtepatwaktu1-3600;
        // $paramlamakerjajumat	= $parampulang-$paramtepatwaktujumat-3600;
        // $paramlamakerjakhusus	= $parampulangkhusus-$paramtepatwaktukhusus-3600;
        // $param_no_absen_plg 	= konversitime2detik($datasetting['noabsenpulang']);
        // $batasTL1 				= konversitime2detik('09:00:00');
        // $batasTL2 				= konversitime2detik('09:30:00');
        // $batasPSW1				= konversitime2detik('15:30:00');
        // $batasPSW2				= konversitime2detik('15:00:00');
        // $batasPSW3				= konversitime2detik('14:30:00');

// if( (int) $r_bulan<=7 and $r_tahun>2014)
        // $SQL = "select
// case when dtmasuk=dtpulang then dtmasuk+'#1'
// else dtmasuk+'#0' end as dtmasuk,
// dtpulang

 // from (select top 1
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+b.description as msk from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal and fingerprintid=$fingerid order by datetime) as dtmasuk,
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+b.description as plg from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal and fingerprintid=$fingerid order by datetime desc) as dtpulang
                 // from $tabel ) as x";
// else
        $SQL = "select * from dbo.f_kehadiran($fingerid,$r_tahun ,$r_bulan,$r_tanggal)";

        $data = $conn->GetRow($SQL);
        $pchmsk = explode('-',trim($data['dtmasuk']));
        $pchplg = explode('-',trim($data['dtpulang']));

        if(!empty($data['dtmasuk'])){
            $dtkmsk			= konversitime2detik($pchmsk[0]);
            $dtkplg			= konversitime2detik($pchplg[0]);
            $batas			= 3600 * 12;

            $jammsk			= $pchmsk[0];
            $id_terminal_msk= $pchmsk[1];
            $nm_terminal_msk= $pchmsk[2];

            $jamplg			= $pchplg[0];
            $id_terminal_plg= $pchplg[1];
            $nm_terminal_plg= $pchplg[2];
            if(1==1){
                $mecah = explode('#',$nm_terminal_msk);
                if($mecah[1]==1){//if ada satu record
                    if($dtkmsk<=$batas){
                        $jammsk			= $jammsk;
                        $id_terminal_msk= $id_terminal_msk;
                        $nm_terminal_msk= $nm_terminal_msk;
                        $jamplg			= '';
                        $id_terminal_plg= '';
                        $nm_terminal_plg= '';
                    }else{
                        $jammsk			= '';
                        $id_terminal_msk= '';
                        $nm_terminal_msk= '';
                        $jamplg			= $jamplg;
                        $id_terminal_plg= $id_terminal_plg;
                        $nm_terminal_plg= $nm_terminal_plg;
                    }
                }else{//if > 1 record


                }
            }else{
                if($data['dtmasuk']==$data['dtpulang']){
                    $jamplg			= '';
                    $id_terminal_plg= '';
                    $nm_terminal_plg= '';
                }else{
                    $jamplg			= $pchplg[0];
                    $id_terminal_plg= $pchplg[1];
                    $nm_terminal_plg= $pchplg[2];
                }
            }
        return $jammsk.'-'.$id_terminal_msk.'-'.$nm_terminal_msk.'-'.$jamplg.'-'.$id_terminal_plg.'-'.$nm_terminal_plg;
        }
    }


function get_Absensishift($conn,$nipx,$r_tahun,$r_bulan,$r_tanggal,$r_tanggalY,$shiftX,$shiftY,$akhirbln)
{
    $SS = true;
    $r_tahun2	= $r_tahun;
    $r_bulan2	= $r_bulan;
    $r_tanggal2 = $r_tanggal+1;
    $duaempat = konversitime2detik('24:00:00');
    if($akhirbln==true){
        $r_bulan2	= $r_bulan + 1;
        $r_tanggal2 = '01';
        if($r_bulan==12){
            $r_tahun2   = $r_tahun+1;
            $r_bulan2	= '01';
        }
    }
    $tabel 		= "PersonalLog";
    if($r_tahun<=2013)
    $tabel 		= "PersonalLogOLD";
    $dataP 		= $conn->GetRow("select * from v_listpegawai where nip='".$nipx."'");
    $fingerid 	= $dataP['fingerid'];

    // if($fingerid==2086 and $_SESSION['SIP_USER']=='197303102002121001' and $r_tanggal>27 and $r_tanggal<=28 and $r_bulan=10)
    // $conn->debug=true;
    // else $conn->debug=false;

    if($shiftX=='M' and $shiftY=='M'){
    // if( (int) $r_bulan<=7)
                // $SQL = "select case when dtmasuk=dtpulang then dtmasuk+'#1' else dtmasuk+'#0' end as dtmasuk, dtpulang
                // from (select top 1
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as plg from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal
                // and fingerprintid=$fingerid order by datetime desc) as dtmasuk,
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as msk from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun2 and month(DateTime)=$r_bulan2 and day(DateTime)=$r_tanggal2
                // and fingerprintid=$fingerid order by datetime) as dtpulang
                 // from $tabel ) as x";
    // else
        $SQL = "select * from dbo.f_kehadiranMM($fingerid,$r_tahun ,$r_bulan,$r_tanggal,$r_tahun2 ,$r_bulan2,$r_tanggal2)";

                $data = $conn->GetRow($SQL);
                $pchmsk = explode('-',trim($data['dtmasuk']));
                $pchplg = explode('-',trim($data['dtpulang']));
                if(!empty($data['dtpulang'])) $pchplg[0] = konversidetik2time(konversitime2detik($pchplg[0])+$duaempat);
                $batas			= 3600 * 24;
    }
    if($shiftX=='M' and $shiftY=='S'){
        //echo 'MS';
        // if( (int) $r_bulan<=7)
                // $SQL = "select case when dtmasuk=dtpulang then dtmasuk+'#1' else dtmasuk+'#0' end as dtmasuk, dtpulang
                // from (select top 1
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as plg from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal
                // and fingerprintid=$fingerid order by datetime desc) as dtmasuk,
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as msk from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun2 and month(DateTime)=$r_bulan2 and day(DateTime)=$r_tanggal2
                // and fingerprintid=$fingerid order by datetime) as dtpulang
                 // from $tabel ) as x";
        // else
        $SQL = "select * from dbo.f_kehadiranMM($fingerid,$r_tahun ,$r_bulan,$r_tanggal,$r_tahun2 ,$r_bulan2,$r_tanggal2)";
                $data = $conn->GetRow($SQL);
                $pchmsk = explode('-',trim($data['dtmasuk']));
                $pchplg = explode('-',trim($data['dtpulang']));
                if(!empty($data['dtpulang'])) $pchplg[0] = konversidetik2time(konversitime2detik($pchplg[0])+$duaempat);
                $batas			= 3600 * 24;

    }
    if(($shiftX=='S' and $shiftY=='S')){

    // if( (int) $r_bulan<=7)
        // $SQL = "select case when dtmasuk=dtpulang then dtmasuk+'#1' else dtmasuk+'#0' end as dtmasuk, dtpulang
                // from (select top 1
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as plg from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal
                 // and datepart(hour,datetime)>12 and fingerprintid=$fingerid order by datetime) as dtmasuk,
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as msk from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal
                // and fingerprintid=$fingerid order by datetime desc) as dtpulang
                 // from $tabel ) as x";
        // else
        $SQL = "select * from dbo.f_kehadiranSS($fingerid,$r_tahun ,$r_bulan,$r_tanggal)";
                $data = $conn->GetRow($SQL);
                $pchmsk = explode('-',trim($data['dtmasuk']));
                $pchplg = explode('-',trim($data['dtpulang']));
                $batas			= 3600 * 18;
                if(konversitime2detik($pchmsk[0])<36000 and $pchmsk[0]==$pchplg[0])
                {
                $pchmsk[0]=''; $pchplg[0] =''; $pchmsk[1]=''; $pchplg[1] =''; $pchmsk[2]=''; $pchplg[2] ='';
                $SS = false;
                }  else $SS = true;
    }
    if(($shiftX=='P' and $shiftY=='P') or ($shiftX=='P' and $shiftY=='')  or $shiftX=='P' or ($shiftX=='P' and $shiftY=='S')){
        // if( (int) $r_bulan<=7)
        // $SQL = "select case when dtmasuk=dtpulang then dtmasuk+'#1' else dtmasuk+'#0' end as dtmasuk, dtpulang
                // from (select top 1
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as plg from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal
                 // and fingerprintid=$fingerid order by datetime) as dtmasuk,
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as msk from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal
                // and fingerprintid=$fingerid order by datetime desc) as dtpulang
                 // from $tabel ) as x";
        // else
        $SQL = "select * from dbo.f_kehadiran($fingerid,$r_tahun ,$r_bulan,$r_tanggal)";
                $data = $conn->GetRow($SQL);
                $pchmsk = explode('-',trim($data['dtmasuk']));
                $pchplg = explode('-',trim($data['dtpulang']));
                $batas			= 3600 * 11;
    }
    if(($shiftX=='S' and $shiftY=='P') or ($shiftX=='P' and $shiftY=='S') or ($shiftX=='S' and $shiftY=='L')){
        // if( (int) $r_bulan<=7)
        // $SQL = "select case when dtmasuk=dtpulang then dtmasuk+'#1' else dtmasuk+'#0' end as dtmasuk, dtpulang
                // from (select top 1
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as plg from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal
                 // and fingerprintid=$fingerid order by datetime) as dtmasuk,
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as msk from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal
                // and fingerprintid=$fingerid order by datetime desc) as dtpulang
                 // from $tabel ) as x";
        // else
        $SQL = "select * from dbo.f_kehadiran($fingerid,$r_tahun ,$r_bulan,$r_tanggal)";
                $data = $conn->GetRow($SQL);
                $pchmsk = explode('-',trim($data['dtmasuk']));
                $pchplg = explode('-',trim($data['dtpulang']));
                $batas			= 3600 * 18;
    }
    if(!empty($data['dtmasuk'])){
        $dtkmsk			= konversitime2detik($pchmsk[0]);
        $dtkplg			= konversitime2detik($pchplg[0]);


        $jammsk			= $pchmsk[0];
        $id_terminal_msk= $pchmsk[1];
        $nm_terminal_msk= $pchmsk[2];

        $jamplg			= $pchplg[0];
        $id_terminal_plg= $pchplg[1];
        $nm_terminal_plg= $pchplg[2];
        if(1==1){
            $mecah = explode('#',$nm_terminal_msk);
            if($mecah[1]==1){//if ada satu record
                if($dtkmsk<=$batas){
                    $jammsk			= $jammsk;
                    $id_terminal_msk= $id_terminal_msk;
                    $nm_terminal_msk= $nm_terminal_msk;
                    $jamplg			= '';
                    $id_terminal_plg= '';
                    $nm_terminal_plg= '';
                }else{
                    $jammsk			= '';
                    $id_terminal_msk= '';
                    $nm_terminal_msk= '';
                    $jamplg			= $jamplg;
                    $id_terminal_plg= $id_terminal_plg;
                    $nm_terminal_plg= $nm_terminal_plg;
                }
            }
        }
        if($SS == true)
        return $jammsk.'-'.$id_terminal_msk.'-'.$nm_terminal_msk.'-'.$jamplg.'-'.$id_terminal_plg.'-'.$nm_terminal_plg;
        else return  '';
    }

}

    function get_Absensishift3($conn,$nipx,$r_tahun,$r_bulan,$r_tanggal)
    {
        $tabel = "PersonalLog";
        if($r_tahun<=2013)
        $tabel = "PersonalLogOLD";
        $dataP = $conn->GetRow("select * from v_listpegawai where nip='".$nipx."'");
        $fingerid 				= $dataP['fingerid'];
        // $datasetting			= $conn->GetRow("select * from ms_setting where tahun=".$r_tahun);//date("Y"));
        // $jabatan 				= $conn->GetOne("select namajfungsional from v_datapegawai where nip='".$nipx."'");

        // $paramtepatwaktu1 		= konversitime2detik($datasetting['jammasuk']);
        // $paramtepatwaktu2 		= konversitime2detik($datasetting['jammasuk']);
        // $paramtepatwaktujumat 	= konversitime2detik($datasetting['jammasukjumat']);
        // $paramtepatwaktukhusus	= konversitime2detik($datasetting['jammasukkhusus']);
        // $parampulang     		= konversitime2detik($datasetting['jampulang']);
        // $parampulangkhusus		= konversitime2detik($datasetting['jampulangkhusus']);
        // $paramlamakerja			= $parampulang-$paramtepatwaktu1-3600;
        // $paramlamakerjajumat	= $parampulang-$paramtepatwaktujumat-3600;
        // $paramlamakerjakhusus	= $parampulangkhusus-$paramtepatwaktukhusus-3600;
        // $param_no_absen_plg 	= konversitime2detik($datasetting['noabsenpulang']);
        // $batasTL1 				= konversitime2detik('09:00:00');
        // $batasTL2 				= konversitime2detik('09:30:00');
        // $batasPSW1				= konversitime2detik('15:30:00');
        // $batasPSW2				= konversitime2detik('15:00:00');
        // $batasPSW3				= konversitime2detik('14:30:00');
// if( (int) $r_bulan<=7)
        // $SQL = "select
// case when dtmasuk=dtpulang then dtmasuk+'#1'
// else dtmasuk+'#0' end as dtmasuk,
// dtpulang

 // from (select top 1
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+b.description as msk from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=($r_tanggal+1) and fingerprintid=$fingerid order by datetime) as dtpulang,
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+b.description as plg from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal and fingerprintid=$fingerid order by datetime desc) as dtmasuk
                 // from $tabel ) as x";
// else
        $SQL = "select * from dbo.f_kehadiran($fingerid,$r_tahun ,$r_bulan,$r_tanggal)";
        $data = $conn->GetRow($SQL);
        $pchmsk = explode('-',trim($data['dtmasuk']));
        $pchplg = explode('-',trim($data['dtpulang']));

        if(!empty($data['dtmasuk'])){
            $dtkmsk			= konversitime2detik($pchmsk[0]);
            $dtkplg			= konversitime2detik($pchplg[0]);
            $batas			= 3600 * 12;

            $jammsk			= $pchmsk[0];
            $id_terminal_msk= $pchmsk[1];
            $nm_terminal_msk= $pchmsk[2];

            $jamplg			= $pchplg[0];
            $id_terminal_plg= $pchplg[1];
            $nm_terminal_plg= $pchplg[2];
            if(1==1){
                $mecah = explode('#',$nm_terminal_msk);
                if($mecah[1]==1){//if ada satu record
                    if($dtkmsk<=$batas){
                        $jammsk			= $jammsk;
                        $id_terminal_msk= $id_terminal_msk;
                        $nm_terminal_msk= $nm_terminal_msk;
                        $jamplg			= '';
                        $id_terminal_plg= '';
                        $nm_terminal_plg= '';
                    }else{
                        $jammsk			= '';
                        $id_terminal_msk= '';
                        $nm_terminal_msk= '';
                        $jamplg			= $jamplg;
                        $id_terminal_plg= $id_terminal_plg;
                        $nm_terminal_plg= $nm_terminal_plg;
                    }
                }else{//if > 1 record


                }
            }else{
                if($data['dtmasuk']==$data['dtpulang']){
                    $jamplg			= '';
                    $id_terminal_plg= '';
                    $nm_terminal_plg= '';
                }else{
                    $jamplg			= $pchplg[0];
                    $id_terminal_plg= $pchplg[1];
                    $nm_terminal_plg= $pchplg[2];
                }
            }
        return $jammsk.'-'.$id_terminal_msk.'-'.$nm_terminal_msk.'-'.$jamplg.'-'.$id_terminal_plg.'-'.$nm_terminal_plg;
        }
    }

function get_Absensimalam($conn,$nipx,$r_tahun,$r_bulan,$r_tanggal,$r_tanggalY,$akhirbln)
{
    // if($_SESSION['SIP_USER']=='130911601')
    // $conn->debug=true;
    $r_tahun2	= $r_tahun;
    $r_bulan2	= $r_bulan;
    $r_tanggal2 = $r_tanggal+1;
    $duaempat = konversitime2detik('24:00:00');
    if($akhirbln==true){
        $r_bulan2	= $r_bulan + 1;
        $r_tanggal2 = '01';
        if($r_bulan==12){
            $r_tahun2   = $r_tahun+1;
            $r_bulan2	= '01';
        }
    }
    $tabel 		= "PersonalLog";
    if($r_tahun<=2013)
    $tabel 		= "PersonalLogOLD";
    $dataP 		= $conn->GetRow("select * from v_listpegawai where nip='".$nipx."'");
    $fingerid 	= $dataP['fingerid'];
    // if( (int) $r_bulan<=7)
                // $SQL = "select case when dtmasuk=dtpulang then dtmasuk+'#1' else dtmasuk+'#0' end as dtmasuk, dtpulang
                // from (select top 1
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as plg from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun and month(DateTime)=$r_bulan and day(DateTime)=$r_tanggal
                // and fingerprintid=$fingerid order by datetime desc) as dtmasuk,
                // (select top 1 convert(char(8),a.DateTime,108)+'-'+cast(a.terminalid as char(5))+'-'+
                // b.description as msk from $tabel a left join terminalinfo b on a.terminalid=b.terminalid
                // where year(DateTime)=$r_tahun2 and month(DateTime)=$r_bulan2 and day(DateTime)=$r_tanggal2
                // and fingerprintid=$fingerid order by datetime) as dtpulang
                 // from $tabel ) as x";
        // else
        $SQL = "select * from dbo.f_kehadiranMM($fingerid,$r_tahun ,$r_bulan,$r_tanggal,$r_tahun2 ,$r_bulan2,$r_tanggal2)";
                $data = $conn->GetRow($SQL);
                $pchmsk = explode('-',trim($data['dtmasuk']));
                $pchplg = explode('-',trim($data['dtpulang']));
                if(!empty($data['dtpulang'])) $pchplg[0] = konversidetik2time(konversitime2detik($pchplg[0])+$duaempat);
                $batas			= 3600 * 24;


    if(!empty($data['dtmasuk'])){
        $dtkmsk			= konversitime2detik($pchmsk[0]);
        $dtkplg			= konversitime2detik($pchplg[0]);


        $jammsk			= $pchmsk[0];
        $id_terminal_msk= $pchmsk[1];
        $nm_terminal_msk= $pchmsk[2];

        $jamplg			= $pchplg[0];
        $id_terminal_plg= $pchplg[1];
        $nm_terminal_plg= $pchplg[2];
        if(1==1){
            $mecah = explode('#',$nm_terminal_msk);
            if($mecah[1]==1){//if ada satu record
                if($dtkmsk<=$batas){
                    $jammsk			= $jammsk;
                    $id_terminal_msk= $id_terminal_msk;
                    $nm_terminal_msk= $nm_terminal_msk;
                    $jamplg			= '';
                    $id_terminal_plg= '';
                    $nm_terminal_plg= '';
                }else{
                    $jammsk			= '';
                    $id_terminal_msk= '';
                    $nm_terminal_msk= '';
                    $jamplg			= $jamplg;
                    $id_terminal_plg= $id_terminal_plg;
                    $nm_terminal_plg= $nm_terminal_plg;
                }
            }
        }
        return $jammsk.'-'.$id_terminal_msk.'-'.$nm_terminal_msk.'-'.$jamplg.'-'.$id_terminal_plg.'-'.$nm_terminal_plg;
    }

}

function cek_ijin_dll($conn,$userid,$in_tgl) {
    $tglan = formatDate($in_tgl);
    $strSQL = "
    select a.jeniscuti,a.keterangan,a.tglawal,b.leavename,b.REPORTSYMBOL as simbol,b.color
    from pe_rwtcuti_tanggal a
    left outer join dbo.LEAVECLASS b on a.jeniscuti=b.LEAVEID
    where a.userid=$userid and a.tglawal='$in_tgl' and jeniscuti not in ('15','16','17')";
    $rsQ = $conn->Execute($strSQL);
    $i=0;
    while (!$rsQ->EOF)
    {
        $i++;
        $jeniscuti = $rsQ->fields['jeniscuti'];
        $dateid    = $rsQ->fields['leavename'];
        $leavename = $rsQ->fields['leavename'];
        $tglawal   = formatDate($rsQ->fields['tglawal']);
        $ket       = $rsQ->fields['keterangan'];
        $simbol    = $rsQ->fields['simbol'];
        $color     = $rsQ->fields['color'];
        //echo "<br>i : $i - DATEID : $dateid -> ".$rsQ->fields['STARTSPECDAY'];
        $rsQ->MoveNext();
    }
    if($jeniscuti!=10 and $i>0) $dateid = "Pada tanggal $tglawal, saudara telah ".$dateid;
    return $i.'#'.$jeniscuti.'#'.$dateid.'#'.$ket.'#'.$leavename.'#'.$simbol.'#'.$color ;
    //$data = $conn->GetRow($strSQL);
    //return $data['jeniscuti'].','.$data['leavename'];
}

function cek_ijin_dll_tukin($conn,$userid,$in_tgl) {
//if($_SESSION['SIP_USER']=='19303102002121001') $conn->debug=true;
    $tglan = formatDate($in_tgl);
    $strSQL = "
    select a.jeniscuti,a.keterangan,a.tglawal,b.leavename,b.REPORTSYMBOL as simbol,b.color
    from pe_rwtcuti_tanggal a
    left outer join dbo.LEAVECLASS b on a.jeniscuti=b.LEAVEID
    where a.userid=$userid and a.tglawal='$in_tgl' and status=1 and jeniscuti not in ('15','16','17')";
    $rsQ = $conn->Execute($strSQL);
    $i=0;
    while (!$rsQ->EOF)
    {
        $i++;
        $jeniscuti = $rsQ->fields['jeniscuti'];
        $dateid    = $rsQ->fields['leavename'];
        $leavename = $rsQ->fields['leavename'];
        $tglawal   = formatDate($rsQ->fields['tglawal']);
        $ket       = $rsQ->fields['keterangan'];
        $simbol    = $rsQ->fields['simbol'];
        $color     = $rsQ->fields['color'];
        //echo "<br>i : $i - DATEID : $dateid -> ".$rsQ->fields['STARTSPECDAY'];
        $rsQ->MoveNext();
    }
    if($jeniscuti!=10 and $i>0) $dateid = "Pada tanggal $tglawal, saudara telah ".$dateid;
    return $i.'#'.$jeniscuti.'#'.$dateid.'#'.$ket.'#'.$leavename.'#'.$simbol.'#'.$color ;
    //$data = $conn->GetRow($strSQL);
    //return $data['jeniscuti'].','.$data['leavename'];
}

// START add varis: tambah fungsi ekspor ke BKD
    function eksporBKD($idkegiatan, $nip, $arr_iditem) {
        include('inc_dbconn.php');
        // mapping rubrik from idkegiatan and kodekegiatan
        $map_rubrik = array(
            'BK' => array(
                '102010801' => 'B03.a',
                '102010802' => 'B03.c',
                'default' => 'B03.c'
            ),
            'JL' => array(
                '1020201010201' => 'B07.3',
                '1020201010202' => 'B07.2',
                '1020201010203' => 'B07.1',
                'default' => 'B07.1'
            ),
            'SM' => array(
                '102020101030101' => 'B08.3',
                '102020101030102' => 'B08.2',
                'default' => 'B08.2'
            ),
            'PT' => array(
                '102020102' => 'B01',
                'default' => 'B01'
            ),
            'PM' => array(
                '102030101' => 'C01',
                '102030201' => 'C02',
                'default' => 'C01'
            ),
            'PN' => array(
                'A' => 'B09.1',
                'B' => 'B09.2',
                'C' => 'B09.3',
                // Sederhana => 'B09.1'
                // Biasa => 'B09.2'
                // Internasional => 'B09.3'
                'default' => 'B09.1'
            )

        );

        // mapping idkategori from idkegiatan
        $map_idkategori = array(
            'BK' => 'PL',
            'JL' => 'PL',
            'SM' => 'PL',
            'PT' => 'PL',
            'PN' => 'PL',
            'PM' => 'PM'
        );

        $total = count($arr_iditem);
        $sukses = 0;
        $tmp = join(',',$arr_iditem);

        // Check data yang blum diekspor saja
        $tsql = "select count(*) as total  from pe_detailkegdosennip where (ref_se_kegiatan is NULL or ref_se_kegiatan='0') and iditem in ($tmp) and nippeneliti='$nip'";
        $tmp2 = $conn->execute($tsql);
        $tmp3 = $tmp2->FetchRow();
        if($tmp3['total'] != $total)
        {
            echo '<div id="exportmessage" align="center"><strong><font color="#AA0000" size="2">Ekspor ke BKD gagal. Pilih hanya data yang belum diekspor..</font></strong></div>';
            return;
        }
        $kadaluarsa = 0;
        $data_kadaluarsa = array();
        foreach ($arr_iditem as $iditem) {
            $sql = "select * from pe_detailkegdosen where iditem='$iditem'";
            $r = $conn->getRow($sql);
            if(($r['idkegiatan']=='SM' && !empty($r['tglselesai'])) || ($r['idkegiatan']=='JL' && !empty($r['periodekd'])) || ($r['idkegiatan']=='PT' or $r['idkegiatan']=='PM' && !empty($r['tglmulai'])) || $r['idkegiatan']=='BK' || $r['idkegiatan']=='PN' ) {
                switch($r['idkegiatan']){
                    case 'BK':
                        break;
                    case 'JL':
                        if($r['media_publikasi']=='G'){
                            if(!empty($r['tglmulai'])){
                                $waktudata =  $r['tglmulai'];
                                $expire =date('Y-m-d', strtotime("now -4 year") );

                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }else{
                                if(!empty($r['periodekd']))
                                {
                                    $waktudata = substr($r['periodekd'],0,4).'-01-01';
                                    $expire =date('Y-m-d', strtotime("now -4 year") );
                                    $waktudata_time = strtotime($waktudata);
                                    $expire_time = strtotime($expire);
                                    if ($expire_time > $waktudata_time) {
                                        array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                        $kadaluarsa++;
                                    }
                                } else{
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }
                        }elseif($r['media_publikasi']=='F'){
                            if(!empty($r['tglmulai'])){
                                $waktudata =  $r['tglmulai'];
                                $expire =date('Y-m-d', strtotime("now -3 year") );
                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;

                                }
                            }else{
                                if(!empty($r['periodekd']))
                                {
                                    $waktudata = substr($r['periodekd'],0,4).'-01-01';
                                    $expire =date('Y-m-d', strtotime("now -3 year") );
                                    $waktudata_time = strtotime($waktudata);
                                    $expire_time = strtotime($expire);
                                    if ($expire_time > $waktudata_time) {
                                        array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                        $kadaluarsa++;
                                    }
                                } else{
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }

                        }elseif($r['media_publikasi']=='E'){
                            if(!empty($r['tglmulai'])){
                                $waktudata =  $r['tglmulai'];
                                $expire =date('Y-m-d', strtotime("now -2 year") );
                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;

                                }

                            }else{
                                if(!empty($r['periodekd']))
                                {
                                    $waktudata = substr($r['periodekd'],0,4).'-01-01';
                                    $expire =date('Y-m-d', strtotime("now -2 year") );
                                    $waktudata_time = strtotime($waktudata);
                                    $expire_time = strtotime($expire);
                                    if ($expire_time > $waktudata_time) {
                                        array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                        $kadaluarsa++;
                                    }
                                } else{
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }
                        }
                        break;
                    case 'SM':
                        if($r['media_publikasi']=='C'){
                            if(!empty($r['tglselesai'])){
                                $waktudata = $r['tglselesai'];
                                $expire =date('Y-m-d', strtotime("now -3 year") );
                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }else{
                                if(!empty($r['periodekd']))
                                {
                                    $waktudata = substr($r['periodekd'],0,4).'-01-01';
                                    $expire =date('Y-m-d', strtotime("now -2 year") );
                                    $waktudata_time = strtotime($waktudata);
                                    $expire_time = strtotime($expire);
                                    if ($expire_time > $waktudata_time) {
                                        array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                        $kadaluarsa++;
                                    }
                                } else{
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }

                            }
                        }elseif($r['media_publikasi']=='B'){
                            if(!empty($r['tglselesai'])){
                                $waktudata = $r['tglselesai'];
                                $expire =date('Y-m-d', strtotime("now -2 year") );
                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }else{
                                if(!empty($r['periodekd']))
                                {
                                    $waktudata = substr($r['periodekd'],0,4).'-01-01';
                                    $expire =date('Y-m-d', strtotime("now -2 year") );
                                    $waktudata_time = strtotime($waktudata);
                                    $expire_time = strtotime($expire);
                                    if ($expire_time > $waktudata_time) {
                                        array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                        $kadaluarsa++;
                                    }
                                } else{
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }
                        }
                        break;
                    case 'PT':
                        if(!empty($r['tglmulai'])){
                            $waktudata = $r['tglmulai'];
                            $expire =date('Y-m-d', strtotime("now -2 year") );
                            $waktudata_time = strtotime($waktudata);
                            $expire_time = strtotime($expire);
                            if ($expire_time > $waktudata_time) {
                                array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                $kadaluarsa++;
                            }
                        }
                        else{
                            if(!empty($r['periodekd']))
                            {
                                $waktudata = substr($r['periodekd'],0,4).'-01-01';
                                $expire =date('Y-m-d', strtotime("now -2 year") );
                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            } else{
                                array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                $kadaluarsa++;
                            }
                        }
                        break;
                    case 'PM':
                        if(!empty($r['tglmulai'])){
                            $waktudata = $r['tglmulai'];
                            $expire =date('Y-m-d', strtotime("now -2 year") );
                            $waktudata_time = strtotime($waktudata);
                            $expire_time = strtotime($expire);
                            if ($expire_time > $waktudata_time) {
                                array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                $kadaluarsa++;
                            }
                        }
                        else{
                            if(!empty($r['periodekd']))
                            {
                                $waktudata = substr($r['periodekd'],0,4).'-01-01';
                                $expire =date('Y-m-d', strtotime("now -2 year") );
                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            } else{
                                array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                $kadaluarsa++;
                            }
                        }
                        break;
                    case 'PN':
                        if(!empty($r['tingkat']))
                        {
                            if($r['tingkat'] == 'A')
                            {
                                $waktudata = $r['tglmulai'];
                                $expire =date('Y-m-d', strtotime("now -2 year") );
                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }elseif ($r['tingkat'] == 'B') {
                                $waktudata = $r['tglmulai'];
                                $expire =date('Y-m-d', strtotime("now -3 year") );
                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }elseif ($r['tingkat'] == 'C') {
                                $waktudata = $r['tglmulai'];
                                $expire =date('Y-m-d', strtotime("now -4 year") );
                                $waktudata_time = strtotime($waktudata);
                                $expire_time = strtotime($expire);
                                if ($expire_time > $waktudata_time) {
                                    array_push($data_kadaluarsa,substr($r['judul'],0,150));
                                    $kadaluarsa++;
                                }
                            }
                        }else{
                            array_push($data_kadaluarsa,substr($r['judul'],0,150));
                            $kadaluarsa++;
                        }
                        break;
                }
            }else{
                array_push($data_kadaluarsa,substr($r['judul'],0,150));
                $kadaluarsa++;
            }
        }
        if($kadaluarsa>0)
        {
            $html = '<ul>';
            foreach($data_kadaluarsa as $row_t)
                $html .= '<li>'.$row_t.'</li>';
            $html .= '</ul>';
            echo '<div id="exportmessage" align="center"><strong><font color="#AA0000" size="2">Ekspor ke BKD gagal. Terdapat '. $kadaluarsa .' data kadaluarsa.</font></strong>'.$html.'</div>';

            return;
        }
        foreach ($arr_iditem as $iditem) {

            $namalengkap = '';
            $sqql ="select x.nippeneliti, x.nama,x.kodejnspeneliti from
                        (
                        select
                            p.iditem,p.nippeneliti,p.kodejnspeneliti,v.nama,jp.jenispeneliti, p.urutan
                        from
                            pe_detailkegdosennip p
                        join ms_pegawai v on p.nippeneliti=v.nip
                        join lv_jenispeneliti jp on jp.kodepeneliti=p.kodejnspeneliti
                        where iditem='$iditem'
                        union
                            select
                                p.iditem,p.nippeneliti,p.kodejnspeneliti,p.namapenelitix,jp.jenispeneliti, p.urutan
                            from pe_detailkegdosennip p
                            join
                                lv_jenispeneliti jp on jp.kodepeneliti=p.kodejnspeneliti
                                where iditem='$iditem' and namapenelitix is not null AND namapenelitix != ''
                        ) as x
            order by x.kodejnspeneliti ASC, x.urutan ASC";

            $rs = $conn->Execute($sqql);
            $kodejnspeneliti = 'B';
            while($row = $rs->FetchRow())
            {
                if($namalengkap == '')
                $namalengkap = $row['nama'];
                else
                $namalengkap = $namalengkap." , ".$row['nama'];
                if($nip == $row['nippeneliti'])
                    $kodejnspeneliti=$row['kodejnspeneliti'];
            }
            $capaian = 100;
            if($kodejnspeneliti == 'A')
                $capaian = 60;
            elseif($kodejnspeneliti == 'B')
                $capaian = 40;
            elseif($kodejnspeneliti == 'C')
                $capaian = 100;


            $row = $conn->GetRow("select * from pe_detailkegdosen where iditem = '$iditem'");
            $idaturan = $row['idaturan'];
            $kodekegiatan = '';
            if($idaturan > 0) {
                $kodekegiatan = $conn->GetOne("select kodekegiatan from ms_penilaian where idaturan = '$idaturan'");
            }
            else {
                $kodekegiatan = 'default';
            }
            $norubrik = '';
            if($row['idkegiatan'] == 'PN'){
                $norubrik = $map_rubrik[$row['idkegiatan']][$row['tingkat']];
            }else{
                $norubrik = $map_rubrik[$row['idkegiatan']][$kodekegiatan];
            }



            if(empty($norubrik))
            {
                $norubrik = $map_rubrik[$row['idkegiatan']]['default'];
            }
            $refidrubrik = $conn->GetOne("select idrubrik from se_rubrik where norubrik = '$norubrik'");

            $jeniskegiatan = $namalengkap.", ".$row['judul'];

            if($row['namaitem'] != '') {
                $jeniskegiatan = $jeniskegiatan . ', ' . $row['namaitem'];
            }

            date_default_timezone_set('Asia/Jakarta');
            $periode=date("Y", time());
            $temp=$conn->Execute("select tahun,semester from ms_periode where (idperiode = '1')")->FetchRow();
            $periode=$temp['tahun'];
            $periode2=(int)$periode + 1;
            $masatugas = '';
            if($temp['semester']=='2')
            {
                $periodes='A';
                $masa='Genap';
                $periode2 = $periode;
                $masatugas = '[S]'.$masa.' ' . intval($periode)-1 . '/' .$periode2;
            }else{
                $periodes='B';
                $masa='Gasal';
                $masatugas = '[S]'.$masa.' ' . $periode . '/' .$periode2;
            }




            $idkategori = $map_idkategori[$row['idkegiatan']];
            $sksbeban = $conn->GetOne("select sksbeban from se_rubrik where idrubrik = '$refidrubrik'");
            $idsk = '';
            $dt=date('Y-m-d H:i:s');

            if($row['idkegiatan'] == 'PT' || $row['idkegiatan'] == 'PM')
            { //echo 'masuk a';
                if($idkategori == 'PL'){
                    $swhere = " and (t.template in ('TA'))";//,'TX')) ";
                }elseif($idkategori == 'PM'){
                    $swhere = " and (t.template in ('TB','TX')) ";
                }
                if($row['idkegiatan'] == 'PT')
                {
                    if($kodejnspeneliti == 'A')
                    {
                        $sksbeban = '2';
                    }else{
                        $sksbeban = '1';
                    }
                }elseif ($row['idkegiatan'] == 'PM') {
                    $sksbeban = '1';
                }


                $sk = $row['nosk'];
                $t_sql = "SELECT s.idskkolektifnip as idskkolektifnip, t.nosk AS nosk, t.tglsk AS tglsk, t.jenis AS jenis, t.pejabatpenetap, t.namask
                    FROM pe_skkolektifnip s INNER JOIN
                    pe_skkolektif t ON s.skid = t.skid LEFT OUTER JOIN
                    se_kegiatan k ON k.idkegiatan = s.refidkegiatan
                    WHERE (s.nip = '$nip') $swhere AND (t.nosk = '$sk')";
                $temp = $conn->GetRow($t_sql);
                $idsk = $temp['idskkolektifnip'];
                if(empty($row['url']))
                    $row['url'] = '';
                $sql = "insert into se_kegiatan
                    (periode, nip, jeniskegiatan, sksbeban, masatugas, capaian, refidrubrik, idkategori,periodes,nomortugas,tgltugas,pejabat,jenistugas,t_updatetime,ref_pe_detailkeg,url)
                values
                    ('".$periode."', '".$nip."', '".$jeniskegiatan."', '".$sksbeban."', '".$masatugas."', '".$capaian."', '".$refidrubrik."', '".$idkategori."','".$periodes."','".$temp['nosk']."','".$temp['tglsk']."','".$temp['pejabatpenetap']."','".$temp['jenis']."','".$dt."','".$iditem."', '".$row['url']."')
                ";
                $ok = $conn->Execute($sql);
                // $ok = $conn->Execute("
                // insert into se_kegiatan
                // 	(periode, nip, jeniskegiatan, sksbeban, masatugas, capaian, refidrubrik, idkategori,periodes,nomortugas,tgltugas,pejabat,jenistugas,t_updatetime,ref_pe_detailkeg,url)
                // values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                // array($periode, $nip, $jeniskegiatan, $sksbeban, $masatugas, $capaian, $refidrubrik, $idkategori,$periodes,$temp['nosk'],$temp['tglsk'],$temp['pejabatpenetap'],$temp['jenis'],$dt,$iditem, $row['url']));


            }else{
                $jeniskegiatan=str_replace("'","''",$jeniskegiatan);
                //print_r($jeniskegiatan);
                if(empty($row['url']))
                    $row['url'] = '';
                $url_t = $row['url'];
                $sql ="insert into se_kegiatan
                    (periode, nip, jeniskegiatan, sksbeban, masatugas, capaian, refidrubrik, idkategori,periodes,t_updatetime,ref_pe_detailkeg,url)
                values ('".$periode."','".$nip."','".$jeniskegiatan."','".$sksbeban."','".$masatugas."','".$capaian."','".$refidrubrik."','".$idkategori."','".$periodes."','".$dt."','".$iditem."','".$url_t."')";
                //print_r($sql);
                $ok = $conn->Execute($sql);


             } //exit();



            if ($ok) {
                $insert_id = $conn->GetOne("select max(idkegiatan) from se_kegiatan");
                $ok = $conn->Execute("update pe_detailkegdosen set ref_se_kegiatan = ? where iditem = ?", array($insert_id, $iditem));
                $conn->Execute("update pe_detailkegdosennip set ref_se_kegiatan = ? where iditem = ? and nippeneliti= ?", array($insert_id, $iditem, $nip));
                $sukses++;
                if($idsk!='')
                $conn->Execute("update pe_skkolektifnip set refidkegiatan='$insert_id' where idskkolektifnip='".$idsk."'");

            }
        }

        if ($sukses == $total) {
            echo '<div id="exportmessage" align="center"><strong><font color="#00AA00" size="2">Ekspor ke BKD berhasil</font></strong></div>';
        }
    }
    // END add ifan: tambah fungsi ekspor ke BKD
    // Start Varis : pembatalan BKD
    function batalEksporBKD($idkegiatan, $nip, $arr_iditem) {
        include('inc_dbconn.php');

        $total = count($arr_iditem);
        $sukses = 0;
        $tmp = join(',',$arr_iditem);
        $tsql = "select count(*) as total  from pe_detailkegdosennip where (ref_se_kegiatan is not NULL) and iditem in ($tmp) and nippeneliti='$nip'";

        $tmp2 = $conn->execute($tsql);
        $tmp3 = $tmp2->FetchRow();

        if($tmp3['total'] != $total)
        {
            echo '<div id="exportmessage" align="center"><strong><font color="#AA0000" size="2">Pembatalan Ekspor BKD gagal. Pilih hanya data yang sudah diekspor.</font></strong></div>';
            return;
        }

        foreach ($arr_iditem as $iditem) {
            $sql = "select ref_se_kegiatan from pe_detailkegdosennip where iditem='$iditem' and nippeneliti='$nip'";
            $idkegiatan = $conn->getOne($sql);
            $p_delsql = "delete from se_kegiatan where nip = '$nip' and idkegiatan = '$idkegiatan'";

            $conn->Execute($p_delsql);
            $conn->Execute("update pe_skkolektifnip set refidkegiatan = null where refidkegiatan='$idkegiatan'");
            /* varis: START untuk mengubah state ekspor pada profil dosen*/

            $sqll="update pe_detailkegdosennip set ref_se_kegiatan = null where  nippeneliti='$nip' and iditem = '$iditem'";
            $conn->Execute($sqll);
            $sukses++;
        }

        if ($sukses == $total) {
            echo '<div id="exportmessage" align="center"><strong><font color="#00AA00" size="2">Pembatalan Ekspor BKD berhasil</font></strong></div>';
        }
    }

    // START add ifan: tambah fungsi untuk select jenis jurnal & seminar
    function arrJenisJurnal() {
        return array('E' => 'Jurnal Nasional Belum Terakreditasi', 'F' => 'Jurnal Nasional Terakreditasi', 'G' => 'Jurnal Internasional');
    }

    function arrJenisSeminar() {
        return array('B' => 'Seminar Nasional', 'C' => 'Seminar Internasional');
    }
    // END add ifan: tambah fungsi untuk select jenis jurnal & seminar

function batalajukan($conn,$r_tahun,$r_sem,$r_nip) {
    $ok = $conn->Execute("delete from se_pengajuan where periode='$r_tahun' and periodes='$r_sem' and nip='$r_nip'");
        $conn->Execute("update se_kegiatan set isskip='N',idrekomendasi1=null, idrekomendasi2=null where periode='$r_tahun' and periodes='$r_sem' and nip='$r_nip' and isskip='Y'");
    if($ok) {
        $conn->Execute("update se_historis_pengajuan set status='D',openkey=1 where periode='$r_tahun' and periodes='$r_sem' and nip='$r_nip'");
    }
}
/*
function log($conn,$userid,$actionx,$r_nip) {
    $record = array();
    $record['userid']     = $_SESSION['SIP_USER'];
    $record['actionx'] 	  = $_POST["keterangan"];
    $record['actiontime'] = date("Y-m-d H:i:s");
    $record['ipaddress']  = getRealIpAddr();
    $record['hostname']   = gethostbyaddr($_SERVER['REMOTE_ADDR']);

            $col = $conn->SelectLimit("select * from $p_dbtable",0);
            $p_svsql = $conn->GetInsertSQL($col,$record);
            $ok = $conn->Execute($p_svsql);
}
*/

function s_get_browser() {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        if(($pos = strpos($agent,'Opera')) !== false) $posp = $pos+5;
        else if(($pos = strpos($agent,'Flock')) !== false) $posp = $pos+5;
        else if(($pos = strpos($agent,'Firefox')) !== false) $posp = $pos+7;
        else if(($pos = strpos($agent,'Chrome')) !== false) $posp = $pos+6;
        else if(($pos = strpos($agent,'Safari')) !== false) $posp = $pos+6;
          else if(($pos = strpos($agent,'Konqueror')) !== false) $posp = $pos+9;
        else if(($pos = strpos($agent,'MSIE')) !== false) $posp = $pos+4;
        else return 'Lain-lain';

        $posv = strpos($agent,' ',$posp+1);

        if($posv === false)
            $return = substr($agent,$pos);
        else
            $return = substr($agent,$pos,($posv-$pos));

        if($return[strlen($return)-1] == ';')
            $return = substr($return,0,strlen($return)-1);

        return $return;
    }

function divPopUpAdmin($treeid,$treename,$arrdata,$idxid,$idxlabel) {
    //if($idxlabel=='namapak'){
    //	$idxlabel='nama';
    //	$no_induk   = true;
    //}

        $tree = '<ul id="'.$treeid.'"><li><span style="font-weight:bold;">'.$treename.'</span><ul>';
        $n = count($arrdata);
        for($i=0;$i<$n;$i++) {
            $row = $arrdata[$i];
            $tree .= '<li style="font-size:10px;">';

            //if($no_induk) $row['isparent'] = 0 ;
            if($row['isparent'] == 0)
                $tree .= $row[$idxid].' - '.$row[$idxlabel];
            else
                $tree .= '<a style="TEXT-DECORATION: underline" id="menulink" name="'.$row[$idxid].'">'.$row[$idxid].' - '.$row[$idxlabel].'</a>';

            if($i == ($n-1)) {
                $tree .= str_repeat('</ul></li>',$row['level']);
            }
            else {
                $t_selisih = $row['level'] - $arrdata[$i+1]['level'];

                if($t_selisih >= 0)
                    $tree .= '</li>';
                else if($t_selisih < 0)
                    $tree .= '<ul>';

                if($t_selisih > 0)
                    $tree .= str_repeat('</ul></li>',$t_selisih);
            }
        }
        $tree .= '</ul></li></ul>';

        return $tree;
}

    // Start YASIN: buat fungsi check auth untuk profil versi laravel
    function checkRoleAuthNewProfil($conn,$mainpage,$xpage = true) {
        if($_SESSION['SIP_ROLE'] == '') {
            if($xpage)
                echo '<font color="red"><strong>Anda tidak berhak melihat halaman ini.</strong></font>';
            else
                header('Location: index.php?err=3');
            exit();
        }
        else {
            // pengecekan post, cek apakah user bisa lihat data pegawai berdasarkan unit
            if(basename(recentURL())==$mainpage) $namapage = basename(recentURL());
            else $namapage = $mainpage.'/'.basename(recentURL());

            if($xpage and substr($namapage,0,5) == 'xlita') {
                $r_nip = removeSpecial($_REQUEST['key']);
                if($r_nip != '') {
                    if(!checkAuthUnit($conn,$r_nip)) {
                        echo '<font color="red"><strong>Anda tidak berhak melihat data pegawai ini.</strong></font>';
                        exit();
                    }
                }
            }

            $row = $conn->GetRow("select * from sc_targetrole where namapage = '$namapage' and idrole = '".$_SESSION['SIP_ROLE']."'");
            if(empty($row['canread'])) {
                if($xpage){
                    echo '<font color="red"><strong>Anda tidak berhak melihat halaman ini.</strong></font>';
                }
                else
                    header('Location: home.php');
                exit();
            }
            else {
                foreach($row as $key => $val) {
                    if(empty($row[$key]))
                        $row[$key] = false;
                    else
                        $row[$key] = true;
                }

                return $row;
            }
        }
    }
    // End YASIN


    // Start Rahmad
    function getLevelJabatan($conn){
        $sql = "select p.nip,p.old_nip, p.nama, p.nama2, p.idjenisdosen, lf.idjfungsional, lf.namajfungsional, ls.idjstruktural, ls.namajstruktural, p.idstatusaktif, ls.level_jabatan, ls.nilai_jabatan
            from ms_pegawai p
            LEFT OUTER JOIN

                 dbo.pe_rwtjabatan AS rf ON rf.nourutrj =
                     (SELECT        TOP (1) nourutrj
                       FROM            dbo.pe_rwtjabatan
                       WHERE        (nip = p.nip) AND (valid = 1) AND (tipejabatan = 'F')
                       ORDER BY tmtjabatan DESC, idjabatan) LEFT OUTER JOIN
                 dbo.lv_jfungsional AS lf ON lf.idjfungsional = rf.idjabatan

            LEFT OUTER JOIN

                 dbo.pe_rwtjabatan AS rs ON rs.nourutrj =
                     (SELECT        TOP (1) nourutrj
                       FROM            dbo.pe_rwtjabatan
                       WHERE        (nip = p.nip) AND (valid = 1) AND (tipejabatan = 'S') AND tglexpire > GETDATE()
                       ORDER BY tglexpire DESC, tmtjabatan DESC, idjabatan) LEFT OUTER JOIN
                 dbo.lv_jstruktural AS ls ON ls.idjstruktural = rs.idjabatan AND ls.level_jabatan IS NOT NULL

            where p.isdosen=1
            and p.idstatusaktif in ('A','TB','TI')
            order by p.idjenisdosen, idjfungsional, idjstruktural";
        $result = $conn->GetArray($sql);
        return $result;
    }
    // End Rahmad


    function truncateStr($input, $length)
    {
        //only truncate if input is actually longer than $length
        if(strlen($input) > $length)
        {
        //check if there are any spaces at all and if the last one is within the given length if so truncate at space else truncate at length.
            if(strrchr($input, " ") && strrchr($input, " ") < $length)
            {
                return substr( $input, 0, strrpos( substr( $input, 0, $length), ' ' ) )."...";
            }
            else
            {
                return substr( $input, 0, $length )."...";
            }
        }
        else
        {
            return $input;
        }
    }

    function redirectTo($url){
        if(isset($_SERVER['HTTPS'])){
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . $url;
    }

    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    function does_url_exists($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }
    
//   function dd($datas) {
//       print "<pre>";
//
//       if (is_array($datas)) {
//           foreach ($datas as $key => $value) {
//               print_r($value);
//               print "\n";
//               print "\n";
//           }
//       } else {
//           print_r($datas);
//       }
//
//       print "</pre>";
//
//       exit();
//   }
};
?>