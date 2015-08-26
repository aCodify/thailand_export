<?php
class Model {
	protected $registry;
	protected $db;
	
	public function __construct() {

		// HACK DATABASE FOR CI;
		$this->db = DB(array(
		    'dbdriver' => 'mysql',
		    'char_set' => 'utf8',
		    'dbcollat' => 'utf8_general_ci',
		    'hostname' => DATABASE_HOSTNAME,
		    'username' => DATABASE_USERNAME,
		    'password' => DATABASE_PASSWORD,
		    'database' => DATABASE_NAM,
		    // 'dbprefix' => DB_PREFIX
		));

	}


	public function get( $value = '' ) {
	
		$this->db->from( 'regist_data_2013' );
		$this->db->select( 'id,page,regist_by,year,sex,f_name,l_name,nationality,company,position_name,address,street,district_sub,district,province_id,zipcode,country_id,mobile,phone,fax,email,url,data_all,visit_date,update_date,status' );

		$query = $this->db->get();
		$data = $query->result_array();
		return $data;
	}// END get 




	public function district_sub( $value = '' ) {
	
		$this->db->from( 'th_tambol' );
		$this->db->where( 'id', $value );
		$query = $this->db->get();
		$data = $query->row();
		return $retVal = ( ! empty( $data ) ) ? $data->name : '' ;
		
	}// END Namefunciton 
	public function district( $value = '' ) {
	
		$this->db->from( 'th_amphor' );
		$this->db->where( 'id', $value );
		$query = $this->db->get();
		$data = $query->row();
		return $retVal = ( ! empty( $data ) ) ? $data->name : '' ;
		
	}// END Namefunciton 
	public function province_id( $value = '' ) {
	
		$this->db->from( 'th_province' );
		$this->db->where( 'id', $value );
		$query = $this->db->get();
		$data = $query->row();
		return $retVal = ( ! empty( $data ) ) ? $data->name : '' ;
		
	}// END Namefunciton 
	public function country_id( $value = '' ) {
	
		$this->db->from( 'country' );
		$this->db->where( 'numcode', $value );
		$query = $this->db->get();
		$data = $query->row();
		return $retVal = ( ! empty( $data ) ) ? $data->printable_name : '' ;
		
	}// END Namefunciton 

	
	public function system() {


		header('Content-Type: text/html; charset=utf-8');
	
		$this->db->select( 'company , namelastname , note , status, phone' );
		$this->db->where( 'namelastname !=', '' );
		$this->db->where( 'namelastname !=', '-' );
		// $this->db->where( 'note', 'FAIR2013' );
		$this->db->order_by( 'namelastname', 'ASC' );
		$query = $this->db->get( 'sys_data_contact' );
		$data = $query->result();
		// echo $num_row = $query->num_rows();
		

		foreach ( $data as $key => $value ) {
			
			$this->db->select( 'id , company , namelastname ,status , phone' );
			// $this->db->where( 'company', $value->company );
			$this->db->where( 'status', 'No Action' );
			$this->db->where( 'namelastname', $value->namelastname );
			$this->db->where( 'phone', $value->phone );
			$this->db->where( 'phone !=', '-' );
			$this->db->where( 'phone !=', '' );
			$query = $this->db->get( 'sys_data_contact' );
			$data1 = $query->result();


			$this->db->select( 'id , company , namelastname ,status , phone' );
			// $this->db->where( 'company', $value->company );
			$this->db->where( 'namelastname', $value->namelastname );
			$this->db->where( 'phone', $value->phone );
			$this->db->where( 'phone !=', '-' );
			$this->db->where( 'phone !=', '' );			
			$query = $this->db->get( 'sys_data_contact' );
			// $data2 = $query->result();
			$num_row = $query->num_rows();


			if ( $num_row > 1 ) {

				if ( count( $data1 ) ==  $num_row  ) {
			

					// echo '<pre>';
					// print_r( $data1 );
					// echo '</pre>';

					foreach ( $data1 as $key1 => $value1 ) {
						
						if ( $key1 == 0 ) {
							continue;
						}

						$this->db->where( 'id', $value1->id );
						$this->db->delete( 'sys_data_contact' );


					}


				}


			}



		}

		
	}// END system 

	public function system1() {
	
		header('Content-Type: text/html; charset=utf-8');
	
		$this->db->select( 'id ,company , namelastname , note , status' );
		// $this->db->where( 'namelastname !=', '' );
		// $this->db->where( 'namelastname !=', '-' );
		$this->db->like( 'company', '  ' );
		// $this->db->where( 'note', 'FAIR2009' );
		$this->db->order_by( 'namelastname', 'ASC' );
		$query = $this->db->get( 'sys_data_contact' );
		$data = $query->result();


		// echo '<pre>';
		// print_r( $data );
		// echo '</pre>';

		// die();

		foreach ( $data as $key => $value ) {

			$setname = $value->company;
			// $setname = strtolower(trim(str_replace( '-', ' ' , $setname )));
			// $setname = strtolower(trim(str_replace( '.', ' ' , $setname )));
			// $setname = strtolower(trim(str_replace( '  ', ' ' , $setname )));
			// $this->db->set( 'company', $setname );
			// $this->db->where( 'id', $value->id );
			// $this->db->update( 'sys_data_contact' );

		}

		
		
	}// END system1 


	public function system2() {
	
		header('Content-Type: text/html; charset=utf-8');

		$array_volum = array( 'ติดต่อเรียนเชิญสำเร็จ'  => 10  ,  'ไม่มีผู้รับสาย'  => 5  ,  'หมายเลขโทรศัพท์ไม่ถูกต้อง'  => 2  ,  'ให้ติดต่อกลับภายหลัง'  => 9  ,  'ไม่สนใจเข้าร่วมงาน'  => 8  ,  'ข้อมูลซ้ำ'  => 1  ,  'ลูกค้าต่างชาติ' => 7 , 'No Action' => 0 );

		$this->db->select( 'id ,company , namelastname , note , status' );
		$this->db->where( 'namelastname !=', '' );
		$this->db->where( 'namelastname !=', '-' );
		// $this->db->where( 'note', 'ONLINE-FAIR-2013' );
		$this->db->order_by( 'namelastname', 'ASC' );
		// $this->db->limit(10000, 20000);
		$query = $this->db->get( 'sys_data_contact' );
		$data = $query->result();

		foreach ( $data as $key => $value ) {
			
			$this->db->select( 'id , company , namelastname ,status' );
			// $this->db->where( 'company', $value->company );
			$this->db->where( 'status', 'No Action' );
			$this->db->where( 'namelastname', $value->namelastname );
			$query = $this->db->get( 'sys_data_contact' );
			$data1 = $query->result();


			$this->db->select( 'id , company , namelastname ,status' );
			// $this->db->where( 'company', $value->company );
			$this->db->where( 'namelastname', $value->namelastname );
			$query = $this->db->get( 'sys_data_contact' );
			$data2 = $query->result();
			$num_row = $query->num_rows();


			if ( $num_row > 1 ) {

				if ( count( $data1 ) !==  $num_row  ) {
					
					$id_delete = array();


					// foreach ( $data2 as $key => $value ) {

					// 	$id_delete[$value->id] = ( ! empty( $array_volum[ $value->status ] ) ) ? (int)$array_volum[ $value->status ] : 0 ;

					// }	

					// arsort($id_delete);

					// foreach ( $id_delete as $key1 => $value1 ) {
						
						
					// 	reset($id_delete);
					// 	$key_first = key($id_delete);

					// 	if ( $key1 == $key_first) {
					// 		continue;
					// 	}
						
					// 	$this->db->where( 'id', $key1 );
					// 	$this->db->delete( 'sys_data_contact' );

					// }		

						


				}


			}



		}


		
	}// END system2 


	public function system3() {


		$this->db->where( 'ref_history_id', '1416809937' );
		$this->db->delete( 'sys_data_contact' );


		die();
	
		$this->db->select( 'ref_history_id' );
		$this->db->group_by( 'ref_history_id' );
		$query = $this->db->get( 'sys_data_contact' );
		$data = $query->result();


		foreach ( $data as $key => $value ) {
			echo "<br>";

			
			$this->db->where( 'ref_history_id', $value->ref_history_id );
			$query = $this->db->get( 'sys_data_contact' );
			$num_row = $query->num_rows();


			echo date( 'd-m-Y', $value->ref_history_id ). ' ' . $num_row;
		}
		
	}// END system3 





	function system4() {

		$query = $this->db->get( 'regist_data_2013' );
		$data = $query->result();
		
		foreach ( $data as $key => $value ) {
			
			// $this->db->where( 'id', $value->country_id );
			// $query = $this->db->get( 'regist_country' );
			// $data = $query->row();

			// $retVal = ( ! empty( $data->country_name ) ) ? $data->country_name : '';

			// if ( empty( $retVal ) ) {
			// 	continue;
			// }


			// $this->db->where( 'id', $value->province_id );
			// $query = $this->db->get( 'th_province' );
			// $data = $query->row();

			// $retVal = ( ! empty( $data->name ) ) ? $data->name : '';

			// if ( empty( $retVal ) ) {
			// 	continue;
			// }


			// $this->db->where( 'id', $value->district );
			// $query = $this->db->get( 'th_amphor' );
			// $data = $query->row();

			// $retVal = ( ! empty( $data->name ) ) ? $data->name : '';

			// if ( empty( $retVal ) ) {
			// 	continue;
			// }


			// $this->db->where( 'id', $value->district_sub );
			// $query = $this->db->get( 'th_tambol' );
			// $data = $query->row();

			// $retVal = ( ! empty( $data->name ) ) ? $data->name : '';

			// if ( empty( $retVal ) ) {
			// 	continue;
			// }




			// $this->db->where( 'sex', 2 );


			// $this->db->where( 'id', $value->id );
			// $this->db->set( 'country_id', $retVal );
			// $this->db->update( 'regist_data_2013' );


		}

	}// END system4 










function multiSort() { 
    //get args of the function 
    $args = func_get_args(); 
    $c = count($args); 
    if ($c < 2) { 
        return false; 
    } 
    //get the array to sort 
    $array = array_splice($args, 0, 1); 
    $array = $array[0]; 
    //sort with an anoymous function using args 
    usort($array, function($a, $b) use($args) { 

        $i = 0; 
        $c = count($args); 
        $cmp = 0; 
        while($cmp == 0 && $i < $c) 
        { 
            $cmp = strcmp($a[ $args[ $i ] ], $b[ $args[ $i ] ]); 
            $i++; 
        } 

        return $cmp; 

    }); 

    return $array; 

} 





}

$olx = new Model();

?>