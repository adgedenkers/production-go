<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('va-head');
		$this->load->view('va-foot');
	}
}

/* End of file welcome.php */