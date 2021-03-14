<?php
// MSG
function show_msg($content = '', $type = 'success', $icon = 'fa-info-circle', $size = '14px')
{
	if ($content != '') {
		return  '<p class="box-msg">
				      <div class="info-box alert-' . $type . '">
					      <div class="info-box-icon">
					      	<i class="fa ' . $icon . '"></i>
					      </div>
					      <div class="info-box-content" style="font-size:' . $size . '">
				        	' . $content
			. '</div>
					  </div>
				    </p>';
	}
}

function show_succ_msg($content = '', $size = '14px')
{
	if ($content != '') {
		return   '<p class="box-msg">
				      <div class="info-box alert-success">
					      <div class="info-box-icon">
					      	<i class="fa fa-check-circle"></i>
					      </div>
					      <div class="info-box-content" style="font-size:' . $size . '">
				        	' . $content
			. '</div>
					  </div>
				    </p>';
	}
}

function show_err_msg($content = '', $size = '14px')
{
	if ($content != '') {
		return   '<p class="box-msg">
				      <div class="info-box alert-error">
					      <div class="info-box-icon">
					      	<i class="fa fa-warning"></i>
					      </div>
					      <div class="info-box-content" style="font-size:' . $size . '">
				        	' . $content
			. '</div>
					  </div>
				    </p>';
	}
}

// MODAL
function show_my_modal($content = '', $id = '', $data = '', $size = 'md')
{
	$_ci = &get_instance();
	if ($content != '') {
		$view_content = $_ci->load->view($content, $data, TRUE);
		return '<div class="modal fade" id="' . $id . '" role="dialog">
					  <div class="modal-dialog modal-' . $size . '" role="document">
					    <div class="modal-content">
					        ' . $view_content . '
					    </div>
					  </div>
					</div>';
	}
}

function show_my_confirm($id = '', $class = '', $title = 'Konfirmasi', $yes = 'Ya', $no = 'Cancel')
{
	$_ci = &get_instance();
	if ($id != '') {
		echo   '<div class="modal fade" id="' . $id . '" role="dialog">
					  <div class="modal-dialog modal-md" role="document">
					    <div class="modal-content">
					        <div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
						      <h3 style="display:block; text-align:center;">' . $title . '</h3>
							  <br>
						      <div class="col-md-6">
						        <button class="form-control btn btn-danger ' . $class . '">' . $yes . '</button>
						      </div>
						      <div class="col-md-6">
						        <button class="form-control btn btn-default btn-block" data-dismiss="modal">' . $no . '</button>
						      </div>
						    </div>
					    </div>
					  </div>
					</div>';
	}
}

function rupiah($angka)
{
	$hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
	return $hasil_rupiah;
}

function money($angka)
{
	$hasil_rupiah = number_format($angka, 2, ',', '.');
	return $hasil_rupiah;
}

function dateFormat($date)
{
	return date('d-m-Y H:i:s', strtotime($date));
}

function toDate($date)
{
	return date('d/m/Y', strtotime($date));
}

function toLongDate($date)
{
	return date('d F Y', strtotime($date));
}

function toDate2($date)
{
	return date('d/M/Y', strtotime($date));
}

function penyebut($nilai)
{
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " " . $huruf[$nilai];
	} else if ($nilai < 20) {
		$temp = penyebut($nilai - 10) . " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
	}
	return $temp;
}

function number_to_words_rupiah($nilai)
{
	if ($nilai < 0) {
		$hasil = "minus " . trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}
	return $hasil . " rupiah";
}

function saldo($nilai){
	$nilai = abs($nilai);
	$hasil_rupiah = "Rp " . number_format($nilai, 2, ',', '.');
	return $hasil_rupiah;
	
}

function saldo_money($nilai){
	$nilai = abs($nilai);
	$hasil_rupiah = number_format($nilai, 2, ',', '.');
	return $hasil_rupiah;
}

function helper_log($tipe = "", $str = "", $id = "", $ip = ""){
	$CI =& get_instance();
 
	if (strtolower($tipe) == "login"){
		$log_tipe   = 0;
	}
	elseif(strtolower($tipe) == "logout")
	{
		$log_tipe   = 1;
	}
	elseif(strtolower($tipe) == "add"){
		$log_tipe   = 2;
	}
	elseif(strtolower($tipe) == "edit"){
		$log_tipe  = 3;
	}
	elseif(strtolower($tipe) == "delete"){
		$log_tipe  = 4;
	}
	elseif(strtolower($tipe) == "export"){
		$log_tipe  = 5;
	}
	elseif(strtolower($tipe) == "import"){
		$log_tipe  = 6;
	}
	else{
		$log_tipe  = 7;
	}
 
	// parameter
	$param['log_username']  = $CI->session->userdata('username');
	$param['log_type']      = $log_tipe;
	$param['log_desc']      = $str;
	$param['log_id_act']	= $id;
	$param['log_ip']		= $ip;
 
	//load model log
	$CI->load->model('m_log');
 
	//save to database
	$CI->m_log->save_log($param);
 
}
