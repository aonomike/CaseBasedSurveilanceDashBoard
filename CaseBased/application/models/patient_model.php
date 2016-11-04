<?php
class Patient_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//get all patients
	public function get_patients() 
	{
		$sql = 'SELECT DISTINCT p.person_id, p.first_name, p.middle_name, p.last_name, p.sex, p.birthdate, f.county, f.mflcode, f.facilityname FROM personevents pe
				JOIN person p ON p.person_id = pe.person_id
				JOIN facility f ON f.mflcode = pe.facility_mflcode';	
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $row) 
					{
						# code...
						$rows[]=$row;
					}
					return $rows;
				}
		else
		{
			return false;
		}
	}
	
	//execute sql queries that return multiple rows
	private function run_sql($sql)
	{
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
				{
					foreach ($query->result() as $row) 
							{
								# code...
								$rows[]=$row;
							}
							return $rows;
						}
				else
				{
					return false;
				}
	}



}
