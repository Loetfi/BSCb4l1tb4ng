<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontrak_model extends CI_Model {

	public function jumlah($id='')
	{
		return anchor('#', 'Rp.'.rupiah(50), 'data-toggle="tooltip" title="Rp.'.rupiah(5000000000).'" style="font-color:white" class="text-chart-white"');
	}

}

/* End of file Kontrak_model.php */
/* Location: ./application/models/dashboard/Kontrak_model.php */
