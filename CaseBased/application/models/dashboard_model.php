<?php
class Dashboard_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		
	}


	//get event counts with logic
	public function get_event_counts_with_logic()
	{
		$sql='	SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
						p_e.event_id,e.verbose_name, 
				        e.name AS event_name, e.description,
				        ((SELECT COUNT( p.event_id ) AS total_event_count
								FROM personevents p)) AS total_event_count
				FROM personevents p_e
				JOIN EVENTS e ON e.idevent = p_e.event_id
				GROUP BY p_e.event_id';
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
//90 90 90
	public function get_diagnosis_vs_initiation_vs_vl_suppression($start_date, $end_date, $county, $facility) {
		$sql = "select count(distinct person_id)  total_count,
				(select count(*) from personevents pe JOIN events e ON e.idevent = pe.event_id 
				JOIN facility f ON pe.facility_mflcode = f.mflcode ";
		$sql =	$this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= "  AND e.name = 'HIV_CARE_INITIATION' ) AS number_initiated_to_care, (select count(person_id) from personevents pe JOIN events e ON e.idevent = pe.event_id  
					JOIN facility f ON pe.facility_mflcode = f.mflcode  ";
		$sql =	$this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date); 
		$sql .= " and e.name = 'VIRAL_LOAD' AND pe.value_numeric < 1000 ) vl_below_1000 from personevents pe
				JOIN events e ON e.idevent = pe.event_id
				JOIN facility f ON pe.facility_mflcode = f.mflcode ";
		$sql =	$this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		
		$query=$this->db->query($sql);
		try {
			if($query->num_rows()==1)
				{
					return $query->row();
				}
				else
				{
					return false;
				}
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
		

	}
//get event counts
	public function get_event_counts_per_event($start_date, $end_date, $county, $facility) {
		$sql = '	SELECT count(event_id) AS event_count, e.name as event_name, e.verbose_name FROM personevents pe 
					JOIN events e ON e.idevent = pe.event_id
					JOIN facility f ON pe.facility_mflcode = f.mflcode ';
		$sql =	$this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql.=  '		GROUP BY pe.event_id';
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

	
	//filter events by start date
	 public function filter_events_by_end_date($end_date) {
		$sql=	"SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
   						 p_e.event_id,e.verbose_name, e.name AS event_name, e.description, ((SELECT COUNT( p.event_id ) AS total_event_count
				FROM personevents p WHERE p.eventdatetime<= '";
		$sql.=$end_date;
		$sql.="' )) AS total_event_count FROM personevents p_e JOIN EVENTS e ON e.idevent = p_e.event_id WHERE p_e.eventdatetime <= '";
		$sql.=$end_date;
		$sql.="'	GROUP BY p_e.event_id";
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

	//filter events by start date and end date
	public function filter_events_by_start_date_and_end_date($start_date, $end_date)
	{
		$sql="SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
   						 p_e.event_id,e.verbose_name, e.name AS event_name, e.description, ((SELECT COUNT( p.event_id ) AS total_event_count
				FROM personevents p WHERE p.eventdatetime>= '";
		$sql.=$start_date;
		$sql.="' AND p.eventdatetime<= '";
		$sql.=$end_date;
		$sql.="' )) AS total_event_count FROM personevents p_e JOIN EVENTS e ON e.idevent = p_e.event_id WHERE p_e.eventdatetime>= '";
		$sql.=$start_date;
		$sql.="' AND p_e.eventdatetime<= '";
		$sql.=$end_date;
		$sql.="'	GROUP BY p_e.event_id";
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

	//filter events by facility
	public function filter_events_by_facility($facility){
		$sql="SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
   						p_e.event_id,e.verbose_name, e.name AS event_name, e.description, ((SELECT COUNT( p.event_id ) AS total_event_count
				FROM personevents p JOIN facility fac ON fac.mflcode = p.facility_mflcode where p.facility_mflcode= ";
		$sql.= $facility;
		$sql.=" )) AS total_event_count, f.facilityname AS facility_name, f.mflcode AS facility_mflcode, f.county AS facility_county	FROM personevents p_e ";
		$sql.="	JOIN EVENTS e ON e.idevent = p_e.event_id ";
        $sql.="	JOIN facility f ON f.mflcode = p_e.facility_mflcode";
        $sql.="	WHERE f.mflcode= ";
        $sql.=$facility;
        $sql.=" GROUP BY p_e.event_id";

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

	
	//filter events by county 
	public function filter_events_by_county($county) {
		$sql="SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
   						p_e.event_id,e.verbose_name, e.name AS event_name, e.description, ((SELECT COUNT( p.event_id ) AS total_event_count
				FROM personevents p JOIN facility fac ON fac.mflcode = p.facility_mflcode where fac.county= '";
		$sql.= $county;
		$sql.="'";
		$sql.=" )) AS total_event_count, f.facilityname AS facility_name, f.mflcode AS facility_mflcode, f.county AS facility_county	FROM personevents p_e ";
		$sql.="	JOIN EVENTS e ON e.idevent = p_e.event_id ";
        $sql.="	JOIN facility f ON f.mflcode = p_e.facility_mflcode";
        $sql.="	WHERE f.county= '";
        $sql.=$county;
        $sql.="'";
        $sql.=" GROUP BY p_e.event_id";

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


	//function to filter events by county and end date
	public function filter_events_by_county_and_end_date($county,$end_date){
		$sql=	"SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
			    		p_e.event_id,e.verbose_name, e.name AS event_name, e.description, ((SELECT COUNT( p.event_id ) AS total_event_count
				 FROM personevents p JOIN facility fac ON fac.mflcode = p.facility_mflcode WHERE fac.county  = '";
		$sql.=	$county;
        $sql.=  "' AND p.eventdatetime <= '";
        $sql.=	$end_date;
        $sql.=	"'  )) AS total_event_count, f.facilityname AS facility_name, f.mflcode AS facility_mflcode, f.county AS facility_county	
                FROM personevents p_e  
                JOIN EVENTS e ON e.idevent = p_e.event_id
                JOIN facility f ON f.mflcode = p_e.facility_mflcode
                WHERE f.county= '";                
        $sql.=	$county;
 		$sql.=  "' AND p_e.eventdatetime <= '";
        $sql.=	$end_date;
        $sql.="' GROUP BY p_e.event_id";

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


	//function to filter events by facility and end date
	public function filter_events_by_facility_and_end_date($facility,$end_date){
		$sql=	"SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
   						p_e.event_id,e.verbose_name, e.name AS event_name, e.description, ((SELECT COUNT( p.event_id ) AS total_event_count
				FROM personevents p JOIN facility fac ON fac.mflcode = p.facility_mflcode WHERE p.facility_mflcode  = ";
		$sql.=	$facility;
        $sql.=  " AND p.eventdatetime <= '";
        $sql.=	$end_date;
        $sql.=	"'  )) AS total_event_count, f.facilityname AS facility_name, f.mflcode AS facility_mflcode, f.county AS facility_county	
                FROM personevents p_e  
                JOIN EVENTS e ON e.idevent = p_e.event_id
                JOIN facility f ON f.mflcode = p_e.facility_mflcode
                WHERE f.mflcode= ";                
        $sql.=	$facility;
 		$sql.=  " AND p_e.eventdatetime <= '";
        $sql.=	$end_date;
        $sql.="' GROUP BY p_e.event_id";

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

	//fitler events by facility and start date 
	public function filter_events_by_facility_and_start_date($facility,$start_date){
		$sql=	"SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
   						p_e.event_id,e.verbose_name, e.name AS event_name, e.description, ((SELECT COUNT( p.event_id ) AS total_event_count
				FROM personevents p JOIN facility fac ON fac.mflcode = p.facility_mflcode WHERE p.facility_mflcode  = ";
		$sql.=	$facility;
        $sql.=  " AND p.eventdatetime >= '";
        $sql.=	$start_date;
        $sql.=	"'  )) AS total_event_count, f.facilityname AS facility_name, f.mflcode AS facility_mflcode, f.county AS facility_county	
                FROM personevents p_e  
                JOIN EVENTS e ON e.idevent = p_e.event_id
                JOIN facility f ON f.mflcode = p_e.facility_mflcode
                WHERE f.mflcode= ";                
        $sql.=	$facility;
 		$sql.=  " AND p_e.eventdatetime >= '";
        $sql.=	$start_date;
        $sql.="' GROUP BY p_e.event_id";

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


	//function to filter events by county and start date
	public function filter_events_by_county_and_start_date($county,$start_date){
		$sql=	"SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
   						p_e.event_id,e.verbose_name, e.name AS event_name, e.description, ((SELECT COUNT( p.event_id ) AS total_event_count
				 FROM personevents p JOIN facility fac ON fac.mflcode = p.facility_mflcode WHERE fac.county  = '";
		$sql.=	$county;
        $sql.=  "' AND p.eventdatetime >= '";
        $sql.=	$start_date;
        $sql.=	"'  )) AS total_event_count, f.facilityname AS facility_name, f.mflcode AS facility_mflcode, f.county AS facility_county	
                FROM personevents p_e  
                JOIN EVENTS e ON e.idevent = p_e.event_id
                JOIN facility f ON f.mflcode = p_e.facility_mflcode
                WHERE f.county= '";                
        $sql.=	$county;
 		$sql.=  "' AND p_e.eventdatetime >= '";
        $sql.=	$start_date;
        $sql.="' GROUP BY p_e.event_id";

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


	//filter events by facility, start date and end date filter_events_by_facility_and_start_date_and_end_date

	public function filter_events_by_facility_and_start_date_and_end_date($facility,$start_date, $end_date){
		$sql=	"SELECT CASE WHEN  p_e.event_id=8 THEN
								(SELECT COUNT(C.person_id) FROM (select count(person_id), person_id, min(eventdatetime) 
						        FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C )
							WHEN p_e.event_id=21 THEN
						        (SELECT COUNT(person_id) FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) 
								FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C)
							WHEN p_e.event_id = 6 THEN 
						        (SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C)
					        WHEN p_e.event_id=7 THEN
								(SELECT COUNT(C.person_id) FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime)
								FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C)	
	        				ELSE COUNT( p_e.event_id )
			    		END AS event_count,
   				p_e.event_id,e.verbose_name, e.name AS event_name, e.description, ((SELECT COUNT( p.event_id ) AS total_event_count
				FROM personevents p JOIN facility fac ON fac.mflcode = p.facility_mflcode WHERE p.facility_mflcode  = ";
		$sql.=	$facility;
        $sql.=  " AND p.eventdatetime >= '";
        $sql.=	$start_date;
         $sql.=  "' AND p.eventdatetime <= '";
        $sql.=	$end_date;
        $sql.=	"'  )) AS total_event_count, f.facilityname AS facility_name, f.mflcode AS facility_mflcode, f.county AS facility_county	
                FROM personevents p_e  
                JOIN EVENTS e ON e.idevent = p_e.event_id
                JOIN facility f ON f.mflcode = p_e.facility_mflcode
                WHERE f.mflcode= ";                
        $sql.=	$facility;
 		$sql.=  " AND p_e.eventdatetime >= '";
        $sql.=	$start_date;
        $sql.=  "' AND p_e.eventdatetime <= '";
        $sql.=	$end_date;
        $sql.="' GROUP BY p_e.event_id";

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

	//filter events by facility, conty, start date and end date filter_events_by_facility_and_start_date_and_end_date

	public function filter_events_by_facility_and_county_and_start_date_and_end_date($facility, $county,$start_date, $end_date) {
		$sql=	" SELECT e.name, e.verbose_name, count(pe.personevents_id) AS event_count, 
				   f.facilityname AS facility_name, f.mflcode AS facility_mflcode, f.county AS facility_county	 FROM personevents pe 
				JOIN events e ON pe.event_id = e.idevent 
                JOIN facility f ON f.mflcode = pe.facility_mflcode ";
   		$sql =	 $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql.=" GROUP BY pe.event_id";
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
	

	// get total event counts
	public function get_total_event_counts_first()
	{

		$sql='SELECT SUM(TOTALS) AS total_event_count FROM (SELECT COUNT(C.person_id) as totals FROM (select count(person_id), person_id, min(eventdatetime) FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=8 and value_numeric=3 or value_numeric=4) E GROUP BY E.PERSON_ID) C 
				UNION
				SELECT COUNT(person_id) as total_event_count FROM ( SELECT COUNT(person_id), person_id, MIN(eventdatetime) FROM( SELECT DISTINCT person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource FROM personevents WHERE event_id=21) E GROUP BY person_id) C
				UNION
				SELECT COUNT(C.person_id)  as total_event_count FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime) FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=6) E GROUP BY E.PERSON_ID) C
				UNION 
				SELECT COUNT(C.person_id)  as total_event_count FROM (SELECT COUNT(person_id), person_id, MIN(eventdatetime) FROM( select distinct person_id, eventdatetime, value_boolean, value_coded, value_datetime, value_numeric, value_text, valuesource from personevents where event_id=7) E GROUP BY E.PERSON_ID) C	
				UNION
				SELECT COUNT( p_e.event_id )  as total_event_count FROM personevents p_e WHERE p_e.event_id NOT IN(8,7, 21, 6)
				) D';

		$query=$this->db->query($sql);

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}

	}
	
	

	//get total event counts
	public function get_total_event_counts($start_date, $end_date, $county, $facility)
	{
		$sql=" SELECT	count(pe.event_id)  AS total_event_count FROM personevents pe JOIN facility f ON f.mflcode = pe.facility_mflcode ";
		$sql =	 $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$query=$this->db->query($sql);

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}

	}

	// get total number of patiensts
	public function get_total_person_counts($start_date, $end_date, $county, $facility)
	{

		$sql = ' SELECT count(person_id) FROM person p';

		$query=$this->db->query($sql);

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}

	}

	// get total number of patiensts
	public function get_total_person_counts_with_events($start_date, $end_date, $county, $facility)
	{

		$sql=' SELECT count( distinct person_id) total_person_count FROM personevents pe
				JOIN  facility f ON f.mflcode = pe.facility_mflcode ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters($sql, $county, $facility, $start_date, $end_date);
		$query=$this->db->query($sql);

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}

	}
	//get gender based monthly event distribution by event and county
	public function get_gender_based_monthly_event_distribution_by_event_id_and_county($event_id,$county)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county

						) AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county

						) AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id =";
				$sql.=$event_id;
				$sql.=" AND fac.county = '";
				$sql.=$county;
				$sql.="' ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by county
	public function get_gender_based_monthly_event_distribution_by_county($county)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND f.county = A.county

						) AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND f.county = A.county

						) AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE fac.county = '";
				$sql.=$county;
				$sql.="' ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}



	//get gender based monthly event distribution by event id and facility
	public function get_gender_based_monthly_event_distribution_by_event_id_and_facility($event_id, $facility)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode

						) AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode

						) AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id =";
				$sql.=$event_id;
				$sql.=" AND fac.mflcode = '";
				$sql.=$facility;
				$sql.="' ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by facility
	public function get_gender_based_monthly_event_distribution_by_facility($facility)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode

						) AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode

						) AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE fac.mflcode = '";
				$sql.=$facility;
				$sql.="' ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	
	//get gender based monthly event distribution by event_id and county and start date
	public function get_gender_based_monthly_event_distribution_by_event_id_and_county_and_start_date($event_id,$county,$start_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county
							AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id =";
				$sql.=$event_id;
				$sql.=" AND fac.county = '";
				$sql.=$county;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by county and start date
	public function get_gender_based_monthly_event_distribution_by_county_and_start_date($county,$start_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county
							AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE  fac.county = '";
				$sql.=$county;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}


//get gender based monthly event distribution by event id and county and end date
	public function get_gender_based_monthly_event_distribution_by_event_id_and_county_and_end_date($event_id, $county, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county
							AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id =";
				$sql.=$event_id;
				$sql.=" AND fac.county = '";
				$sql.=$county;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by county and end date
	public function get_gender_based_monthly_event_distribution_by_county_and_end_date($county, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county
							AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE fac.county = '";
				$sql.=$county;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}


//get gender based monthly event distribution by event id and facility and end date
	public function get_gender_based_monthly_event_distribution_by_event_id_and_facility_and_end_date($event_id, $facility, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode
							AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id =";
				$sql.=$event_id;
				$sql.=" AND fac.mflcode = '";
				$sql.=$facility;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ORDER BY p_e.eventdatetime";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY MONTH, YEAR ORDER BY YEAR, MONTH ";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by facility and end date
	public function get_gender_based_monthly_event_distribution_by_facility_and_end_date( $facility, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode
							AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE fac.mflcode = '";
				$sql.=$facility;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ORDER BY p_e.eventdatetime";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY MONTH, YEAR ORDER BY YEAR, MONTH ";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}


	//get gender based monthly event distribution by event id and county and start date and end date
	public function get_gender_based_monthly_event_distribution_by_event_id_and_county_and_start_date_and_end_date($event_id, $county, $start_date, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county
							AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id =";
				$sql.=$event_id;
				$sql.=" AND fac.county = '";
				$sql.=$county;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ORDER BY p_e.eventdatetime ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}


	//get gender based monthly event distribution by county and start date and end date
	public function get_gender_based_monthly_event_distribution_by_county_and_start_date_and_end_date($county, $start_date, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.county = A.county
							AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE fac.county = '";
				$sql.=$county;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ORDER BY p_e.eventdatetime ";
				$sql.=" ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}


//get gender based monthly event distribution by event id and facility and start date and end date
	public function get_gender_based_monthly_event_distribution_by_event_id_and_facility_and_start_date_and_end_date($event_id, $facility, $start_date, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode
							AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id = ";
				$sql.=$event_id;
				$sql.=" AND fac.mflcode = ";
				$sql.=$facility;
				$sql.=" ";
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ";
				$sql.=" ORDER BY p_e.eventdatetime ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by facility and start date and end date
	public function get_gender_based_monthly_event_distribution_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode
							AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE  fac.mflcode = ";
				$sql.=$facility;
				$sql.=" ";
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ";
				$sql.=" ORDER BY p_e.eventdatetime ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}



//get gender based monthly event distribution by facility and start date 
	public function get_gender_based_monthly_event_distribution_by_event_id_and_facility_and_start_date($event_id, $facility, $start_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode AND pe.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode
							AND pe.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id = ";
				$sql.=$event_id;
				$sql.=" AND fac.mflcode = ";
				$sql.=$facility;
				$sql.=" ";
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";				
				$sql.=" ORDER BY p_e.eventdatetime ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by facility and start date 
	public function get_gender_based_monthly_event_distribution_by_facility_and_start_date($facility, $start_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode AND pe.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND f.mflcode = A.mflcode
							AND pe.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE fac.mflcode = ";
				$sql.=$facility;
				$sql.=" ";
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";				
				$sql.=" ORDER BY p_e.eventdatetime ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}


//get gender based monthly event distribution by event id and start date and end date
	public function get_gender_based_monthly_event_distribution_by_event_id_start_date_and_end_date($event_id, $start_date, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id = ";
				$sql.=$event_id;
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ";
				$sql.=" ORDER BY p_e.eventdatetime ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by event id and start date and end date
	public function get_gender_based_monthly_event_distribution_by_start_date_and_end_date($start_date, $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' AND pe.eventdatetime <= '";
				$sql.=$end_date;
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.eventdatetime >= '";
				$sql.=$start_date;
				$sql.="' ";
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;
				$sql.="' ";
				$sql.=" ORDER BY p_e.eventdatetime ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR, MONTH";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

//get gender based monthly event distribution by event id andstart date
	public function get_gender_based_monthly_event_distribution_by_event_id_and_start_date($event_id,  $start_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH, EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR  , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id = ";
				$sql.=$event_id;
				$sql.=" AND p_e.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.="' ORDER BY p_e.eventdatetime) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by start date
	public function get_gender_based_monthly_event_distribution_by_start_date($start_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH, EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR  , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE  p_e.eventdatetime >= '";
				$sql.=$start_date;				
				$sql.="' ORDER BY p_e.eventdatetime) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}


	//get gender based monthly event distribution by event id and end date
	public function get_gender_based_monthly_event_distribution_by_event_id_and_end_date($event_id,  $end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime <= '";
				$sql.=$end_date;				
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime <= '";
				$sql.=$end_date;				
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE p_e.event_id = ";
				$sql.=$event_id;
				$sql.=" AND p_e.eventdatetime <= '";
				$sql.=$end_date;				
				$sql.="' ORDER BY p_e.eventdatetime) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get gender based monthly event distribution by end date
	public function get_gender_based_monthly_event_distribution_by_end_date($end_date)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime <= '";
				$sql.=$end_date;				
				$sql.=" ') AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							JOIN facility f ON f.mflcode = pe.facility_mflcode
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id
							AND pe.eventdatetime <= '";
				$sql.=$end_date;				
				$sql.=" ') AS FEMALE_COUNT
						FROM (

						SELECT p_e.eventdatetime, p_e.event_id, fac.county, fac.facilityname, fac.mflcode
						FROM personevents p_e
						JOIN facility fac ON fac.mflcode = p_e.facility_mflcode
						WHERE  p_e.eventdatetime <= '";
				$sql.=$end_date;				
				$sql.="' ORDER BY p_e.eventdatetime) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}




//get specific event count grouped by month and gender and event_id
	public function get_event_count_by_month_and_event_id($event_id)
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id

						) AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id)
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id

						) AS FEMALE_COUNT
						FROM (
						SELECT eventdatetime, event_id
						FROM personevents
						WHERE event_id =";
				$sql.=$event_id;
				$sql.=" ORDER BY eventdatetime ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR ";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}


	//get specific event count grouped by month and gender and event_id
	public function get_event_count_by_month()
	{
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count, verbose_name,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						event_id,

						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id

						) AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id)
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
							AND pe.event_id =A.event_id

						) AS FEMALE_COUNT
						FROM (
						SELECT eventdatetime, event_id
						FROM personevents ";
				$sql.=" ORDER BY eventdatetime ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR ";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get specific event count grouped by month and gender

	public function get_gender_based_monthly_event_distribution() {
		try {
				$sql="	SELECT EXTRACT(
						MONTH FROM eventdatetime ) AS
						MONTH , EXTRACT(
						YEAR FROM eventdatetime ) AS
						YEAR , count( event_id ) AS event_count,
						CASE EXTRACT(MONTH FROM eventdatetime )
						WHEN 1
						THEN 'January'
						WHEN 2
						THEN 'February'
						WHEN 3
						THEN 'March'
						WHEN 4
						THEN 'April'
						WHEN 5
						THEN 'May'
						WHEN 6
						THEN 'June'
						WHEN 7
						THEN 'July'
						WHEN 8
						THEN 'August'
						WHEN 9
						THEN 'September'
						WHEN 10
						THEN 'October'
						WHEN 11
						THEN 'November'
						WHEN 12
						THEN 'December'
						ELSE 'xxxxx'
						END AS MONTH_NAME,
						(
							SELECT COUNT( pe.event_id )
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							WHERE p.Sex = 'MALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )
						) AS MALE_COUNT,
						
						(
							SELECT COUNT( pe.event_id)
							FROM personevents pe
							JOIN person p ON p.person_id = pe.person_id
							WHERE p.Sex = 'FEMALE'
							AND EXTRACT(
							MONTH FROM pe.eventdatetime ) = EXTRACT( MONTH FROM A.eventdatetime )

						) AS FEMALE_COUNT
						FROM (
						SELECT eventdatetime, event_id
						FROM personevents ";
				$sql.=" ORDER BY eventdatetime ) A JOIN EVENTS e ON e.idevent = A.event_id GROUP BY YEAR, MONTH ORDER BY YEAR ";
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
	
		} catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}




	//get all counties
	public function get_counties()
	{
		try {

				$sql='	SELECT DISTINCT f.county
						FROM facility f
						JOIN personevents pe ON pe.facility_mflcode = f.mflcode ORDER BY county';

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
		catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get all facilities
	public function get_facilities()
	{
		try {

				$sql='	SELECT DISTINCT f.mflcode, f.facilityname
						FROM facility f
						JOIN personevents pe ON pe.facility_mflcode = f.mflcode
						ORDER BY facilityname';

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
		catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get all facilities by county
	public function get_facilities_by_county($county_name)
	{
		try {

				$sql='	SELECT DISTINCT mflcode, facilityname
						FROM facility f 
						JOIN personevents pe ON pe.facility_mflcode = f.mflcode
						WHERE county = ';
				$sql.= '"'.$county_name.'"';
				$sql.='	ORDER BY facilityname ';

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
		catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}

	//get county by facility code
	public function get_county_by_facility_code($mflcode)
	{
		try {

				$sql='	SELECT DISTINCT county
						FROM facility
						WHERE mflcode = ';
				$sql.= $mflcode;

				$query=$this->db->query($sql);

				if($query->num_rows()==1)
				{
					return $query->row();
				}
				else
				{
					return false;
				}
		}
		catch (Exception $e) {
			echo "Error Message".$e->getMessage();
		}
	}


	//populatin infected and seeking care

	public function get_population_infected_and_seeking_care_summary($start_date, $end_date,$county, $facility) 	  
	{
		try {
				$sql = "SELECT  CASE WHEN age <= 4 THEN 'Under 4' WHEN age BETWEEN 5 and 9 THEN '5 - 9' ";
				$sql.= " WHEN age BETWEEN 10 and 14 THEN '10 - 14' WHEN age BETWEEN 15 and 19 THEN '15 - 19' ";
	       		$sql.= " WHEN age BETWEEN 20 and 24 THEN '20 - 24' WHEN age BETWEEN 25 and 29 THEN '25 - 29' ";
	        	$sql.= " WHEN age BETWEEN 30 and 34 THEN '30 - 34' WHEN age BETWEEN 35 and 39 THEN '35 - 39' ";
	        	$sql.= " WHEN age BETWEEN 40 and 44 THEN '40 - 44' WHEN age BETWEEN 45 and 49 THEN '45 - 49' ";
	       		$sql.= " WHEN age BETWEEN 50 and 54 THEN '50 - 54' WHEN age BETWEEN 55 and 59 THEN '55 - 59' ";
				$sql.= " WHEN age BETWEEN 60 and 64 THEN '60 - 64' WHEN age BETWEEN 65 and 69 THEN '65 - 69' ";
	       		$sql.= " WHEN age >= 70 THEN 'Over 70' WHEN age IS NULL THEN 'Age Not Specified(null)'  "   ;  
	     		$sql.= " END as age_range, count(distinct person_id) number_seeking_care,  CASE WHEN age <= 4 THEN 1 ";
	        	$sql.= " WHEN age BETWEEN 5 and 9 THEN 2  WHEN age BETWEEN 10 and 14 THEN 3  WHEN age BETWEEN 15 and 19 THEN 4 " ;
	        	$sql.= " WHEN age BETWEEN 20 and 24 THEN 5  WHEN age BETWEEN 25 and 29 THEN 6 "   ;
	        	$sql.= " WHEN age BETWEEN 30 and 34 THEN 7  WHEN age BETWEEN 35 and 39 THEN 8 WHEN age BETWEEN 40 and 44 THEN 9 ";
	        	$sql.= " WHEN age BETWEEN 45 and 49 THEN 10 WHEN age BETWEEN 50 and 54 THEN 11 WHEN age BETWEEN 55 and 59 THEN 12 ";
				$sql.= " WHEN age BETWEEN 60 and 64 THEN 13 WHEN age BETWEEN 65 and 69 THEN 14 WHEN age >= 70 THEN 15 ";
	        	$sql.= " WHEN age IS NULL THEN 16 END as ordinal FROM (SELECT TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age,  pe.person_id FROM personevents pe ";
				$sql.= " JOIN person p ON p.person_id = pe.person_id ";
				$sql.= " JOIN facility f ON f.mflcode = pe.facility_mflcode ";
				$new_sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
				
				$new_sql.= " ) as derived ";
				$new_sql.= " GROUP BY age_range  ORDER BY  ordinal ";

				$query=$this->db->query($new_sql);

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
			
		} catch (Exception $e) {
			echo "Failed to fetch population".$e->getMessage();
		}
	}


	//report based on various indicators
	public function get_report_based_on_various_indicators($county, $facility, $start_date, $end_date)
	{ 			
		$sql = ' SELECT COUNT(DISTINCT pe.person_id) AS TOTAL_EVER_POSITIVE, ';
		$sql .= ' (SELECT COUNT(*) FROM (SELECT DISTINCT pe.person_id  FROM person p JOIN personevents pe ON pe.person_id = p.person_id JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND p.SEX = "FEMALE" ) a ) AS FEMALES_EVER_POSITIVE ';
		$sql .= ', (SELECT COUNT(*) FROM (SELECT DISTINCT pe.person_id FROM person p JOIN personevents pe ON pe.person_id = p.person_id JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND p.SEX = "MALE") a )AS MALES_EVER_POSITIVE, ';
		$sql .= ' (SELECT COUNT(*) FROM (SELECT DISTINCT pe.person_id FROM person p JOIN personevents pe ON pe.person_id = p.person_id JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND p.SEX  NOT IN( "MALE","FEMALE")) a) AS GENDER_UNKNOWN_EVER_POSITIVE,';
		$sql .= ' (select count(*) from (SELECT DISTINCT pe.person_id  FROM person p JOIN personevents pe ON pe.person_id = p.person_id JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND pe.event_id IN( 3,14,15)) AS arv) as TOTAL_NUMBER_EVER_ON_ARV, ';
		$sql .= ' (select count(*) from (SELECT DISTINCT pe.person_id  FROM person p ';
		$sql .= ' JOIN personevents pe ON pe.person_id = p.person_id JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND pe.event_id IN( 3,14,15) AND p.SEX = "MALE")  AS arv) as MALES_EVER_ON_ARV, ';
		$sql .= ' (select count(*) from (SELECT DISTINCT pe.person_id  FROM person p JOIN personevents pe ON pe.person_id = p.person_id JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND pe.event_id IN( 3,14,15) AND p.SEX = "FEMALE")  AS arv) as FEMALES_EVER_ON_ARV, ';
		$sql .= ' (select count(*) from (SELECT DISTINCT pe.person_id  FROM person p ';
		$sql .= ' JOIN personevents pe ON pe.person_id = p.person_id JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND pe.event_id IN( 3,14,15) AND p.SEX NOT IN( "MALE","FEMALE"))  AS arv) as GENDER_UNKNOWN_EVER_ON_ARV, ';
 		$sql .= '(select count(*) from (SELECT DISTINCT pe.person_id  FROM person p ';
		$sql .= ' JOIN personevents pe ON pe.person_id = p.person_id JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND  pe.event_id = 6 AND pe.value_numeric > 500) AS arv) as NUMBER_WITH_CD4_COUNT_OVER_500, ';
  		$sql .=  '(select count(*) from (SELECT DISTINCT pe.person_id  FROM person p ';
  		$sql .= ' JOIN personevents pe ON pe.person_id = p.person_id  JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND  pe.event_id = 6 AND pe.value_numeric <= 500) AS arv) as NUMBER_WITH_CD4_COUNT_BELOW_500, ';
  		$sql .= ' (select count(*) from (SELECT DISTINCT pe.person_id  FROM person p JOIN personevents pe ON pe.person_id = p.person_id  JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND  pe.event_id = 6 ) AS arv) as NUMBER_WITH_CD4_COUNT, ';
  		$sql .= ' (select count(*) from (SELECT DISTINCT pe.person_id  FROM person p JOIN personevents pe ON pe.person_id = p.person_id  JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND  pe.event_id = 7 and pe.value_numeric > 1000 ) AS arv) as NUMBER_WITH_VIRAL_LOAD_OVER_1000, ';
  		$sql .= ' (select count(*) from (SELECT DISTINCT pe.person_id  FROM person p ';
		$sql .= ' JOIN personevents pe ON pe.person_id = p.person_id  JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND  pe.event_id = 7 and pe.value_numeric<= 1000) AS arv) as NUMBER_WITH_VIRAL_LOAD_BELOW_1000, ';
  		$sql .= ' (select count(*) from (SELECT DISTINCT pe.person_id  FROM person p JOIN personevents pe ON pe.person_id = p.person_id  JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND  pe.event_id = 7 ) AS vl) as NUMBER_WITH_VIRAL_LOAD, ';
		$sql .= ' (select count(*) from (SELECT DISTINCT pe.person_id  FROM person p JOIN personevents pe ON pe.person_id = p.person_id  JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND  pe.event_id = 12 ) AS dead) as NUMBER_DEAD  FROM PERSON p  JOIN personevents pe ON pe.person_id = p.person_id  JOIN facility f ON f.mflcode = pe.facility_mflcode  ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		
		$query=$this->db->query($sql);

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}

	}
	//get existing events
	public function get_existing_events($start_date, $end_date,$county, $facility)
	{
		$sql = 'select distinct event_id, verbose_name from personevents pe join events e ON e.idevent = pe.event_id ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		$sql .= ' AND e.name IN ("DECEASED", "HIV_DIAGNOSIS", "HIV_CARE_INITIATION", "PMTCT_INITIATION_DATE", "ART_START", "TB_DIAGNOSIS", "TB_TREATMENT_STARTED") ';
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
	//get yearly event distribution based on gender

	public function get_gender_based_yearly_event_distribution($start_date, $end_date,$county, $facility, $event_id)
	{
		$sql = 'SELECT EXTRACT(YEAR FROM pe.eventdatetime) AS YEAR, COUNT(pe.event_id) AS EVENT_COUNT, p.Sex , ';
		$sql .= ' (SELECT COUNT(p_e.event_id) FROM personevents p_e  where (EXTRACT(YEAR FROM p_e.eventdatetime)) = (EXTRACT(YEAR FROM pe.eventdatetime))) as total_events ';
		$sql .= ' FROM personevents pe JOIN person p ON p.person_id = pe.person_id JOIN facility f ON f.mflcode = pe.facility_mflcode ';
		$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
		if ($event_id != "") {
			$sql .= ' AND pe.event_id = ';
			$sql .= $event_id;
			$sql .= ' ';
		}
		$sql .= ' GROUP BY YEAR, p.sex ORDER BY YEAR, p.Sex ';

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
	//generate sql statement where clause given the parameters county, facility, start date, end date
	public function generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date)
	{
		if($county!="" && $start_date == "" && $end_date =="" && $facility=="") {
				$sql.="	WHERE f.county= '";
		        $sql.=$county;
		        $sql.="'";

		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility=="") {
			$sql.=  " WHERE f.county= '";                
	        $sql.=	$county;
	 		$sql.=  "' AND pe.eventdatetime >= '";
	        $sql.=	$start_date;
	        $sql.="'";
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility=="") {
			$sql.=  " WHERE f.county= '";                
	        $sql.=	$county;
	 		$sql.=  "' AND pe.eventdatetime >= '";
	        $sql.=	$start_date;
	        $sql.=  "' AND pe.eventdatetime <= '";
	        $sql.=	$end_date;
	        $sql.="'";
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility!="") {
			$sql.=  " WHERE f.mflcode= ";                
	        $sql.=	$facility;
	 		$sql.=  " AND pe.eventdatetime >= '";
	        $sql.=	$start_date;
	        $sql.="'";

		}
		else if($county=="" && $start_date != "" && $end_date =="" && $facility=="") {
			$sql.=  " WHERE pe.eventdatetime>= '";
			$sql.=	$start_date;
			$sql.="'";
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility=="") {
			$sql.=  " WHERE pe.eventdatetime>= '";
			$sql.=$start_date;
			$sql.="' AND pe.eventdatetime<= '";
			$sql.=$end_date;
			$sql.="'";
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility!="") {
			$sql.=  "  WHERE f.mflcode= ";                
	        $sql.=	$facility;
	 		$sql.=  " AND pe.eventdatetime >= '";
	        $sql.=	$start_date;
	        $sql.=  "' AND pe.eventdatetime <= '";
	        $sql.=	$end_date;
	        $sql.="'";
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility=="") {
			$sql.=  " WHERE f.county= '";                
        	$sql.=	$county;
 			$sql.=  "' AND pe.eventdatetime <= '";
       		$sql.=	$end_date;
       		$sql.="'";
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility!="") {
			 $sql.="	WHERE f.mflcode= ";
        	 $sql.=$facility;
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility!="") {
			$sql.=  " WHERE f.mflcode= ";                
	        $sql.=	$facility;
	 		$sql.=  " AND pe.eventdatetime <= '";
	        $sql.=	$end_date;
	        $sql.="'";
		}
		else if($county=="" && $start_date == "" && $end_date !="" && $facility=="") {
			$sql.=  " WHERE pe.eventdatetime<= '";
			$sql.=$end_date;
			$sql.="'";
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility!="") {
			$sql.=  " WHERE f.mflcode= ";                
	        $sql.=	$facility;
	 		$sql.=  " AND pe.eventdatetime >= '";
	        $sql.=	$start_date;
	        $sql.="'";
		}
		else if($county=="" && $start_date == "" && $end_date =="" && $facility!="") {
					 $sql.="	WHERE f.mflcode= ";
		        	 $sql.=$facility;
				}

				return $sql;
	}


	public function get_gender_based_event_distribution($start_date, $end_date,$county, $facility) 	  
	{
		try {
				$sql = "select count(*) as event_count, sex as gender, e.name, e.verbose_name, case e.name 
							when 'HIV_DIAGNOSIS' then 1
						    when 'HIV_CARE_INITIATION' then 2
						    when 'COTRIMOXAZOLE' then 3
						    when 'ART_START' then 4
						    when 'TB_DIAGNOSIS' then 5
						    when 'TB_TREATMENT_STARTED' then 6
						    when 'DECEASED' then 7
						end
						as ordinal from personevents pe 
						join person p on p.person_id = pe.person_id
						join events e on pe.event_id = e.idevent 
						join facility f ON f.mflcode = pe.facility_mflcode  ";
				$sql = $this->generate_sql_statement_where_clause_given_parameters ($sql, $county, $facility, $start_date, $end_date);
				$sql .= " and p.sex in ('MALE', 'FEMALE') AND e.name  in ( 'HIV_DIAGNOSIS', 'HIV_CARE_INITIATION', 'COTRIMOXAZOLE', 'ART_START', 'TB_DIAGNOSIS', 'TB_TREATMENT_STARTED', 'DECEASED') group by  e.name, p.sex order by ordinal, gender";

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
				return false;
			
		} catch (Exception $e) {
			echo "Failed to fetch population".$e->getMessage();
		}
	}

}
