<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Errors_page extends CI_Controller
{
	public function not_found()
	{
		$this->load->view('errors/404');
	}
    
	public function unauthorized()
	{
		$this->load->view('errors/403');
	}
}
