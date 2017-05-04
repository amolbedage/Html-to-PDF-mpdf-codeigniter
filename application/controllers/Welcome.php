<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('application/libraries/Set_default_time_zone.php');
class Welcome extends CI_Controller {

       function __construct()
    {
      ob_start();
	parent::__construct();
	$this->load->library('encrypt');
	$this->load->helper('string');
	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    }


    function index()
    {
		echo "zxczxc";
        ini_set('memory_limit', '256M');
        // load library
        $this->load->library('M_Pdf');
        $pdf = $this->m_pdf->load();
        // retrieve data from model
        $data=array();
         $html = $this->load->view('content/mpdf', $data, true);
	
	     
        // render the view into HTML
        $pdf->WriteHTML($html);
        // write the HTML into the PDF
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
		$pdf->Output('temppdf/my_filename.pdf','D');
		$pdf->Output('temppdf/my_filename.pdf','F');
		
		
	
		//echo"<a href='http://192.168.100.11/webeasystep-mpdf-codeigniter/'>click</a> ";
        // save to file because we can exit();
        // - See more at: http://webeasystep.com/blog/view_article/codeigniter_tutorial_pdf_to_create_your_reports#sthash.QFCyVGLu.dpuf
    }
}
