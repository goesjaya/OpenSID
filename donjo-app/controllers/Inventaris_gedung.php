<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  File ini:
 *
 * Controller untuk modul Inventaris
 *
 * donjo-app/controllers/Inventaris_gedung.php
 *
 */
/*
 *  File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package	OpenSID
 * @author	Tim Pengembang OpenDesa
 * @copyright	Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright	Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license	http://www.gnu.org/licenses/gpl.html	GPL V3
 * @link 	https://github.com/OpenSID/OpenSID
 */

class Inventaris_gedung extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('inventaris_gedung_model');
		$this->load->model('referensi_model');
		$this->load->model('pamong_model');
		$this->modul_ini = 15;
		$this->sub_modul_ini = 61;
		$this->tab_ini = 3;
		$this->tipe = 'inventaris_gedung';
	}

	public function clear()
	{
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		redirect('inventaris');
	}

	public function index()
	{
		$data['main'] = $this->inventaris_gedung_model->list_inventaris();
		$data['total'] = $this->inventaris_gedung_model->sum_inventaris();
		$data['pamong'] = $this->pamong_model->list_data();
		$data['tip'] = 1;
		$this->set_minsidebar(1);
		$this->render('inventaris/gedung/table', $data);
	}

	public function view($id)
	{
		$data['main'] = $this->inventaris_gedung_model->view($id);
		$data['tip'] = 1;
		$this->set_minsidebar(1);
		$this->render('inventaris/gedung/view_inventaris', $data);
	}

	public function view_mutasi($id)
	{
		$data['main'] = $this->inventaris_gedung_model->view_mutasi($id);
		$data['tip'] = 2;
		$this->set_minsidebar(1);
		$this->render('inventaris/gedung/view_mutasi', $data);
	}

	public function edit($id)
	{
		$data['main'] = $this->inventaris_gedung_model->view($id);
		$data['aset'] = $this->inventaris_gedung_model->list_aset();
		$data['count_reg'] = $this->inventaris_gedung_model->count_reg();
		$data['get_kode'] = $this->header['desa'];
		$data['kd_reg'] = $this->inventaris_gedung_model->list_inventaris_kd_register();
		$data['tip'] = 1;
		$this->set_minsidebar(1);
		$this->render('inventaris/gedung/edit_inventaris', $data);
	}

	public function edit_mutasi($id)
	{
		$data['main'] = $this->inventaris_gedung_model->edit_mutasi($id);
		$data['tip'] = 2;
		$this->set_minsidebar(1);
		$this->render('inventaris/gedung/edit_mutasi', $data);
	}

	public function form()
	{
		$data['tip'] = 1;

		$data['get_kode'] = $this->header['desa'];
		$data['aset'] = $this->inventaris_gedung_model->list_aset();
		$data['count_reg'] = $this->inventaris_gedung_model->count_reg();
		$this->set_minsidebar(1);

		$this->render('inventaris/gedung/form_tambah', $data);
	}

	public function form_mutasi($id)
	{
		$data['main'] = $this->inventaris_gedung_model->view($id);
		$data['tip'] = 2;
		$this->set_minsidebar(1);
		$this->render('inventaris/gedung/form_mutasi', $data);
	}

	public function mutasi()
	{
		$data['main'] = $this->inventaris_gedung_model->list_mutasi_inventaris();
		$data['tip'] = 2;
		$this->set_minsidebar(1);
		$this->render('inventaris/gedung/table_mutasi', $data);
	}

	public function cetak($tahun, $penandatangan)
	{
		$data['header'] = $this->header['desa'];
		$data['total'] = $this->inventaris_gedung_model->sum_print($tahun);
		$data['print'] = $this->inventaris_gedung_model->cetak($tahun);
		$data['pamong'] = $this->pamong_model->get_data($penandatangan);
		$this->load->view('inventaris/gedung/inventaris_print', $data);
	}

	public function download($tahun, $penandatangan)
	{
		$data['header'] = $this->header['desa'];
		$data['total'] = $this->inventaris_gedung_model->sum_print($tahun);
		$data['print'] = $this->inventaris_gedung_model->cetak($tahun);
		$data['pamong'] = $this->pamong_model->get_data($penandatangan);
		$this->load->view('inventaris/gedung/inventaris_excel', $data);
	}
}
