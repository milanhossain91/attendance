<?php
namespace App\Libraries;

use TADPHP\TADFactory;
use App\Employee;

class Zk_class
{
	public $ip;
	public $tad;
	
     	public function __construct($ip) {
			include(app_path() . '/Libraries/zk-class/lib/TADFactory.php');
			include(app_path() . '/Libraries/zk-class/lib/TAD.php');
			include(app_path() . '/Libraries/zk-class/lib/TADResponse.php');
			include(app_path() . '/Libraries/zk-class/lib/Providers/TADSoap.php');
			include(app_path() . '/Libraries/zk-class/lib/Providers/TADZKLib.php');
			include(app_path() . '/Libraries/zk-class/lib/Exceptions/ConnectionError.php');
			include(app_path() . '/Libraries/zk-class/lib/Exceptions/FilterArgumentError.php');
			include(app_path() . '/Libraries/zk-class/lib/Exceptions/UnrecognizedArgument.php');
			include(app_path() . '/Libraries/zk-class/lib/Exceptions/UnrecognizedCommand.php');

			$this->ip = $ip;
        }
       

        public function connect()
		{
			$ip = $this->ip;
			$tad_factory = new TADFactory(['ip'=>$ip]);
            
			return $tad_factory->get_instance();
        }

		public function getUserLog()
		{
			$ip = $this->ip;
			$tad_factory = new TADFactory(['ip'=>$ip]);
			//$tad_factory = new TADPHP\TADFactory(['ip'=>$ip]);
			$tad = $tad_factory->get_instance();
			/*$r = $tad->set_user_info([
					'pin' => 4,
					'name'=> 'sumon3',
					'privilege'=> 0
			]);
			dd($r); *///dd(Employee::max('pin2'));
			//dd($tad->get_all_user_info()->to_array());
			//dd($tad->get_all_user_info()->to_array());dd('stop');
			//dd($tad->delete_user_password(['pin'=>'6']));dd('stop');
			//dd($tad->delete_template(['pin'=>'6']));dd('stop');
			$logs = $tad->get_att_log()->to_array();
			if($logs):
				$data['logs'] 	= $logs;
				$data['users'] 	= $tad->get_all_user_info()->to_array();
				$data['tad'] 	= $tad;
			else:
				$data['logs']  	= 0;
				$data['users'] 	= $tad->get_all_user_info()->to_array();
				$data['tad'] 	= $tad;
			endif;

			return $data;
		}
        
}