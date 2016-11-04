<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->model('rbac_model');		
	}
	public function indexes() {
		$data['person_count']=$this->dashboard_model->get_total_person_counts();
		$data['event_counts']= $this->dashboard_model->get_event_counts();
		$data['totals']=$this->dashboard_model->get_total_event_counts();
		$data['counties']=$this->dashboard_model->get_counties();
		$data['facilities']=$this->dashboard_model->get_facilities();
		$data['template_header']='template_header';
		$data['template_footer']='template_footer';
		$data['main_content']='view_dashboard';
		$data['title']='Case Based Surveilance Dashboard';
		$this->load->view('template',$data);
	}

	public function refresh_events()
	{
		$event_counts=$this->dashboard_model->get_event_counts();
		echo json_encode($event_counts);

	}

	//get events by facility and county start date and end date
	public function filter_events()
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		if($county=="" && $facility=="" && $start_date=="" && $end_date== "")
		{
			$event_counts=$this->dashboard_model->get_event_counts();
			echo json_encode($event_counts);		
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility=="") {
			$event_counts = $this->dashboard_model->filter_events_by_county($county);
			echo json_encode($event_counts);		
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility=="") {
			$event_counts = $this->dashboard_model->filter_events_by_county_and_start_date($county, $start_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility=="") {
			$event_counts= $this->dashboard_model->filter_events_by_county_and_start_date_and_end_date( $county, $start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility!="") {
			$event_counts= $this->dashboard_model->filter_events_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date =="" && $facility=="") {
			$event_counts= $this->dashboard_model->filter_events_by_start_date($start_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility=="") {
			$event_counts= $this->dashboard_model->filter_events_by_start_date_and_end_date($start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility!="") {
			$event_counts= $this->dashboard_model->filter_events_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility=="") {
			$event_counts= $this->dashboard_model->filter_events_by_county_and_end_date( $county, $end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility!="") {
			$event_counts=$this->dashboard_model->filter_events_by_facility($facility);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility!="") {
			$event_counts= $this->dashboard_model->filter_events_by_facility_and_end_date( $facility, $end_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date == "" && $end_date !="" && $facility=="") {
			$event_counts = $this->dashboard_model->filter_events_by_end_date($end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility!="") {
			$event_counts= $this->dashboard_model->filter_events_by_facility_and_start_date($facility, $start_date);
			echo json_encode($event_counts);
		}
		else
		{		
			$event_counts= "other tests";
			echo json_encode($event_counts);
		}
	}

	

	//get events total number of events
	public function get_total_number_of_events()
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		if($county=="" && $facility=="" && $start_date=="" && $end_date== "")
		{
			$event_counts=$this->dashboard_model->get_total_event_counts();
			echo json_encode($event_counts);		
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility=="") {
			$event_counts = $this->dashboard_model->get_total_event_counts_by_county($county);
			echo json_encode($event_counts);		
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility=="") {
			$event_counts = $this->dashboard_model->get_total_event_counts_by_county_and_start_date($county, $start_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility=="") {
			$event_counts= $this->dashboard_model->get_total_event_counts_by_county_and_start_date_and_end_date( $county, $start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_event_counts_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date =="" && $facility=="") {
			$event_counts= $this->dashboard_model->get_total_event_counts_by_start_date($start_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility=="") {
			$event_counts= $this->dashboard_model->get_total_event_counts_by_start_date_and_end_date($start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_event_counts_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility=="") {
			$event_counts= $this->dashboard_model->get_total_event_counts_by_county_and_end_date( $county, $end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_event_counts_by_facility($facility);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_event_counts_by_facility_and_end_date( $facility, $end_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date == "" && $end_date !="" && $facility=="") {
			$event_counts = $this->dashboard_model->get_total_event_counts_by_end_date($end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_event_counts_by_facility_and_start_date($facility, $start_date);
			echo json_encode($event_counts);
		}
		else
		{		
			$event_counts= "other tests";
			echo json_encode($event_counts);
		}
	}

	//get events for tabular display
	public function display_events_in_table_form()
	{
		
	} 

	//function to get the total number of patients in facilities
	public function get_total_patient_count()
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		if($county=="" && $facility=="" && $start_date=="" && $end_date== "")
		{
			$event_counts=$this->dashboard_model->get_total_person_counts();
			echo json_encode($event_counts);		
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility=="") {
			$event_counts = $this->dashboard_model->get_total_person_counts_by_county($county);
			echo json_encode($event_counts);		
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility=="") {
			$event_counts = $this->dashboard_model->get_total_person_counts_by_county_and_start_date($county, $start_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility=="") {
			$event_counts= $this->dashboard_model->get_total_person_counts_by_county_and_start_date_and_end_date( $county, $start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_person_counts_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date =="" && $facility=="") {
			$event_counts= $this->dashboard_model->get_total_person_counts_by_start_date($start_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility=="") {
			$event_counts= $this->dashboard_model->get_total_person_counts_by_start_date_and_end_date($start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_person_counts_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility=="") {
			$event_counts= $this->dashboard_model->get_total_person_counts_by_county_and_end_date( $county, $end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_person_counts_by_facility($facility);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_person_counts_by_facility_and_end_date( $facility, $end_date);
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date == "" && $end_date !="" && $facility=="") {
			$event_counts = $this->dashboard_model->get_total_person_counts_by_end_date($end_date);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility!="") {
			$event_counts= $this->dashboard_model->get_total_person_counts_by_facility_and_start_date($facility, $start_date);
			echo json_encode($event_counts);
		}
		else
		{		
			$event_counts= "other tests";
			echo json_encode($event_counts);
		}
	}


	public function filter_events_by_facility_and_county_and_start_date_and_end_date() {
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$event_counts = $this->dashboard_model->filter_events_by_facility_and_county_and_start_date_and_end_date($facility,$county, $start_date, $end_date);
		echo json_encode($event_counts);
	}

	//get events by start date
	public function filter_events_by_start_date()
	{
		$start_date=$this->input->post("start_date");
		$event_counts=$this->dashboard_model->filter_events_by_start_date($start_date);
		echo json_encode($event_counts);
	}

	//get events by end date
	public function filter_events_by_end_date()
	{
		$end_date=$this->input->post("end_date");
		$event_counts=$this->dashboard_model->filter_events_by_end_date($end_date);
		echo json_encode($event_counts);
	}

	//filter events by start date and end date

	public function filter_events_by_start_date_and_end_date()
	{
		$start_date=$this->input->post("start_date");
		$end_date=$this->input->post("end_date");
		$event_counts=$this->dashboard_model->filter_events_by_start_date_and_end_date($start_date,$end_date);
		echo json_encode($event_counts);
	}

	//get events by facility
	public function filter_events_by_facility()
	{
		$facility = $this->input->post('facility');
		$event_counts = $this->dashboard_model->filter_events_by_facility($facility);
		echo json_encode($event_counts);
	}

	//filter events by county
	public function filter_events_by_county() 
	{
		$county=$this->input->post("county");
		$event_counts=$this->dashboard_model->filter_events_by_county($county);
		echo json_encode($event_counts);
	}

	//filter events by end date and facility
	public function filter_events_by_facility_and_end_date()
	{
		$facility = $this->input->post('facility');
		$end_date = $this->input->post('end_date');
		$event_counts = $this->dashboard_model->filter_events_by_facility_and_end_date($facility,$end_date);
		echo json_encode($event_counts);
	}

	//filter events by end date and county
	public function filter_events_by_county_and_end_date()
	{
		$county = $this->input->post('county');
		$end_date = $this->input->post('end_date');
		$event_counts = $this->dashboard_model->filter_events_by_county_and_end_date($county,$end_date);
		echo json_encode($event_counts);
	}


	// filter events by start date and facility
	public function filter_events_by_facility_and_start_date()
	{
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$event_counts = $this->dashboard_model->filter_events_by_facility_and_start_date($facility,$start_date);
		echo json_encode($event_counts);
	}

	// filter events by county and start
	public function filter_events_by_county_and_start_date()
	{
		$county = $this->input->post('county');
		$start_date = $this->input->post('start_date');
		$event_counts = $this->dashboard_model->filter_events_by_county_and_start_date($county, $start_date);
		echo json_encode($event_counts);
	}


	// filter events by end date and facility and start date
	public function filter_events_by_facility_and_start_date_and_end_date()
	{
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$event_counts = $this->dashboard_model->filter_events_by_facility_and_start_date_and_end_date($facility, $start_date ,$end_date );
		echo json_encode($event_counts);
	}

	// filter events by end date and county and start date
	public function filter_events_by_county_and_start_date_and_end_date()
	{
		$county = $this->input->post('county');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$event_counts = $this->dashboard_model->filter_events_by_county_and_start_date_and_end_date($county,$start_date,$end_date );
		echo json_encode($event_counts);
	}

	
	//get total event count by county
	public function get_total_event_counts_by_county()
	{
		$county = $this->input->post('county');
		$event_counts=$this->dashboard_model->get_total_event_counts_by_county($county);
		echo json_encode($event_counts);
	}


	// get total event count by facility and end date
	public function get_total_event_counts_by_facility_and_end_date()
	{
		$facility = $this->input->post('facility');
		$end_date = $this->input->post('end_date');
		$event_counts=$this->dashboard_model->get_total_event_counts_by_facility_and_end_date($facility,$end_date);
		echo json_encode($event_counts);
	}

	// get total event count by county and end date
	public function get_total_event_counts_by_county_and_end_date()
	{
		$county = $this->input->post('county');
		$end_date = $this->input->post('end_date');
		$event_counts=$this->dashboard_model->get_total_event_counts_by_county_and_end_date($county, $end_date);
		echo json_encode($event_counts);
	}

	// get total event count by facility and start date
	public function get_total_event_counts_by_facility_and_start_date()
	{
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$event_counts=$this->dashboard_model->get_total_event_counts_by_facility_and_start_date($facility,$start_date);
		echo json_encode($event_counts);
	}

	// get total event count by facility and start date
	public function get_total_event_counts_by_county_and_start_date()
	{
		$county = $this->input->post("county");
		$start_date = $this->input->post("start_date");
		$event_counts=$this->dashboard_model->get_total_event_counts_by_county_and_start_date($county,$start_date);
		echo json_encode($event_counts);
	}

	// get total event count by facility and start date and end date
	public function get_total_event_counts_by_facility_and_start_date_and_end_date()
	{
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$event_counts=$this->dashboard_model->get_total_event_counts_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date);
		echo json_encode($event_counts);
	}

	// get total event count by county and start date and end date
	public function get_total_event_counts_by_county_and_start_date_and_end_date()
	{
		$county = $this->input->post('county');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$event_counts=$this->dashboard_model->get_total_event_counts_by_county_and_start_date_and_end_date($county, $start_date, $end_date);
		echo json_encode($event_counts);
	}

	//get total event counts by start date
	public function get_total_event_counts_by_start_date()
	{
		$start_date=$this->input->post("start_date");
		$event_counts=$this->dashboard_model->get_total_event_counts_by_start_date($start_date);
		echo json_encode($event_counts);
	}

	//get total event counts by end date
	public function get_total_event_counts_by_end_date()
	{
		$end_date=$this->input->post("end_date");
		$event_counts=$this->dashboard_model->get_total_event_counts_by_end_date($end_date);
		echo json_encode($event_counts);
	}


	// get total event count by start date and end date
	public function get_total_event_counts_by_start_date_and_end_date()
	{
		$start_date=$this->input->post("start_date");
		$end_date=$this->input->post("end_date");
		$event_counts=$this->dashboard_model->get_total_event_counts_by_start_date_and_end_date($start_date, $end_date);
		echo json_encode($event_counts);
	}
	

	public function get_total_person_counts()
	{
		$person_count=$this->dashboard_model->get_total_person_counts();
		echo json_encode($person_count);
	}

	// get total patient count by start date
	public function get_total_person_counts_by_start_date()
	{
		$start_date=$this->input->post("start_date");
		$person_count=$this->dashboard_model->get_total_person_counts_by_start_date($start_date);
		echo json_encode($person_count);
	}

	// get total patient count by end date
	public function get_total_person_counts_by_end_date()
	{
		$end_date=$this->input->post("end_date");
		$person_count=$this->dashboard_model->get_total_person_counts_by_end_date($end_date);
		echo json_encode($person_count);
	}

	// get total patient count by start date and end date
	public function get_total_person_counts_by_start_date_and_end_date()	
	{
		$start_date=$this->input->post("start_date");
		$end_date=$this->input->post("end_date");
		$person_count=$this->dashboard_model->get_total_person_counts_by_start_date_and_end_date($start_date, $end_date);
		echo json_encode($person_count);
	}

	//get total person count by facility
	public function get_total_person_counts_by_facility()
	{
		$facility=$this->input->post("facility");
		$person_count=$this->dashboard_model->get_total_person_counts_by_facility($facility);
		echo json_encode($person_count);
	}

	//get total person count by county
	public function get_total_person_counts_by_county()
	{
		$county=$this->input->post("county");
		$person_count=$this->dashboard_model->get_total_person_counts_by_county($county);
		echo json_encode($person_count);
	}


	//get total patient count by facility and end date
	public function get_total_person_counts_by_facility_and_end_date(){
		$facility=$this->input->post("facility");
		$end_date=$this->input->post("end_date");
		$person_count=$this->dashboard_model->get_total_person_counts_by_facility_and_end_date($facility, $end_date);
		echo json_encode($person_count);
	}

	//get total patient count by county and end date
	public function get_total_person_counts_by_county_and_end_date()
	{
		$county=$this->input->post("county");
		$end_date=$this->input->post("end_date");
		$person_count=$this->dashboard_model->get_total_person_counts_by_county_and_end_date($county, $end_date);
		echo json_encode($person_count);
	}

	//get total patient count by facility and start date
	public function get_total_person_counts_by_facility_and_start_date()
	{
		$facility=$this->input->post("facility");
		$start_date=$this->input->post("start_date");
		$person_count=$this->dashboard_model->get_total_person_counts_by_facility_and_start_date($facility, $start_date);
		echo json_encode($person_count);
	}

	//get total patient count by facility and start date
	public function get_total_person_counts_by_county_and_start_date()
	{
		$county=$this->input->post("county");
		$start_date=$this->input->post("start_date");
		$person_count=$this->dashboard_model->get_total_person_counts_by_county_and_start_date($county, $start_date);
		echo json_encode($person_count);
	}

	//get total patient count by facility and start date and end date
	public function get_total_person_counts_by_facility_and_start_date_and_end_date()
	{
		$facility=$this->input->post("facility");
		$start_date=$this->input->post("start_date");
		$end_date=$this->input->post("end_date");
		$person_count=$this->dashboard_model->get_total_person_counts_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date);
		echo json_encode($person_count);
	}

	//get total patient count by county and start date and end date
	public function get_total_person_counts_by_county_and_start_date_and_end_date()
	{
		$county=$this->input->post("county");
		$start_date=$this->input->post("start_date");
		$end_date=$this->input->post("end_date");
		$person_count=$this->dashboard_model->get_total_person_counts_by_county_and_start_date_and_end_date($county, $start_date, $end_date);
		echo json_encode($person_count);
	}

	public function load_bar_chart($event_id)
	{		
		$data['event_id']=$event_id;
		$data['person_count']=$this->dashboard_model->get_total_person_counts();
		$data['event_counts']= $this->dashboard_model->get_event_counts();
		$data['totals']=$this->dashboard_model->get_total_event_counts();
		$data['counties']=$this->dashboard_model->get_counties();
		$data['facilities']=$this->dashboard_model->get_facilities();
		$data['template_header']='template_header';
		$data['template_footer']='template_footer';
		$data['main_content']='view_barchart_monthly_event_distribution';
		$data['title']='Case Based Surveilance Dashboard';
		$this->load->view('template',$data);
	}

	public function load_bar_chart_using_jpost()
	{	


		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$event_id = $this->input->post('event_id');		
		if($county=="" && $facility=="" && $start_date=="" && $end_date== "")
		{
			if($event_id==-1) {
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution();			
				echo json_encode($event_counts);
			}
			else {
				$event_counts= $this->dashboard_model->get_event_count_by_month($event_id);			
				echo json_encode($event_counts);
			}			
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility=="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_county($county);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_county($event_id, $county);
				echo json_encode($event_counts);	
			}			
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility=="") {
			if($event_id == -1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_county_and_start_date($county,$start_date);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_county_and_start_date($event_id, $county,$start_date);
				echo json_encode($event_counts);
			}			
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility=="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_county_and_start_date_and_end_date($county,$start_date,$end_date);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_county_and_start_date_and_end_date($event_id, $county,$start_date,$end_date);
				echo json_encode($event_counts);
			}			
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility!="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_facility_and_start_date_and_end_date($event_id, $facility, $start_date, $end_date);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_facility_and_start_date_and_end_date($event_id, $facility, $start_date, $end_date);
				echo json_encode($event_counts);
			}
		}
		else if($county=="" && $start_date != "" && $end_date =="" && $facility=="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_start_date($start_date);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_start_date($event_id, $start_date);
				echo json_encode($event_counts);				
			}
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility=="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_start_date_and_end_date($start_date, $end_date);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_start_date_and_end_date($event_id, $start_date, $end_date);
				echo json_encode($event_counts);
			}			
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility!="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_facility_and_start_date_and_end_date($facility, $start_date, $end_date);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_facility_and_start_date_and_end_date($event_id, $facility, $start_date, $end_date);
				echo json_encode($event_counts);
			}
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility=="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_county_and_end_date($county, $end_date);
				echo json_encode($event_counts);
			}	
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_county_and_end_date($event_id, $county, $end_date);
				echo json_encode($event_counts);
			}		
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility!="") {
			if($event_id==-1)
			{
				$event_counts = $this->dashboard_model->get_gender_based_monthly_event_distribution_by_facility($facility);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_facility($event_id, $facility);
				echo json_encode($event_counts);
			}			
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility!="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_facility_and_end_date($facility, $end_date);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_facility_and_end_date($event_id, $facility, $end_date);
				echo json_encode($event_counts);
			}			
		}
		else if($county=="" && $start_date == "" && $end_date !="" && $facility=="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_end_date($end_date);
				echo json_encode($event_counts);
			}
			else 
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_end_date($event_id, $end_date);
				echo json_encode($event_counts);
			}
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility!="") {
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_facility_and_start_date($facility, $start_date);
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_gender_based_monthly_event_distribution_by_event_id_and_facility_and_start_date($event_id, $facility, $start_date);
				echo json_encode($event_counts);
			}
			
		}
		else
		{		
			$event_counts= "other tests";
			echo json_encode($event_counts);
		}		
	}

	public function get_event_count_by_month()
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$event_id = $this->input->post('event_id');		
		if($county=="" && $facility=="" && $start_date=="" && $end_date== "")
		{
			if($event_id==-1)
			{
				$event_counts= $this->dashboard_model->get_event_count_by_month();
				echo json_encode($event_counts);
			}
			else
			{
				$event_counts= $this->dashboard_model->get_event_count_by_month_and_event_id($event_id);
				echo json_encode($event_counts);
			}			
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility=="") {
			$event_counts=  $this->dashboard_model->get_gender_based_monthly_event_distribution_by_county($event_id,$county);
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility=="") {
			$event_counts= "COUNTY AND START DATE";
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility=="") {
			$event_counts= "COUNTY AND START DATE AND END DATE";
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date !="" && $facility!="") {
			$event_counts= "COUNTY AND START DATE AND END DATE AND FACILITY";
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date =="" && $facility=="") {
			$event_counts= "START DATE";
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility=="") {
			$event_counts= "START DATE AND END DATE";
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date != "" && $end_date !="" && $facility!="") {
			$event_counts= "START DATE AND FACILITY";
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility=="") {
			$event_counts= "COUNTY AND END DATE";
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date =="" && $facility!="") {
			$event_counts= "COUNTY AND FACILITY";
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date == "" && $end_date !="" && $facility!="") {
			$event_counts= "COUNTY AND END DATE AND FACILIY";
			echo json_encode($event_counts);
		}
		else if($county=="" && $start_date == "" && $end_date !="" && $facility=="") {
			$event_counts= "FACILITY";
			echo json_encode($event_counts);
		}
		else if($county!="" && $start_date != "" && $end_date =="" && $facility!="") {
			$event_counts= "START DATE AND FACILITY";
			echo json_encode($event_counts);
		}
		else
		{		
			$event_counts= "other tests";
			echo json_encode($event_counts);
		}		
	}

	public function get_facilities_by_county()
	{
		$county = $this->input->post('county');
		$facilities= $this->dashboard_model->get_facilities_by_county($county);
		echo json_encode($facilities);
	}

	public function get_all_facilities()
	{
		$facilities= $this->dashboard_model->get_facilities();
		echo json_encode($facilities);
	}

	public function get_county_by_facility_code()
	{
		$facility = $this->input->post('facility_code');
		$county= $this->dashboard_model->get_county_by_facility_code($facility);
		echo json_encode($county);
	}	

	public function get_population_infected_and_seeking_care_summary () 
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$population = $this->dashboard_model->get_population_infected_and_seeking_care_summary($start_date, $end_date,$county, $facility);

		echo json_encode($population);
	}

	// get report on various indicators
	public function get_report_based_on_various_indicators()
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$data = $this->dashboard_model->get_report_based_on_various_indicators($county, $facility, $start_date, $end_date);
		echo json_encode($data);

	}

	public function get_event_counts_per_event()
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$data = $this->dashboard_model->get_event_counts_per_event($start_date, $end_date, $county, $facility);
		echo json_encode($data);
	}

	public function get_diagnosis_vs_initiation_vs_vl_suppression()
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$data = $this->dashboard_model->get_diagnosis_vs_initiation_vs_vl_suppression($start_date, $end_date, $county, $facility);
		echo json_encode($data);
	}

	public function get_gender_based_event_distribution()
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		try {
			$data = $this->dashboard_model->get_gender_based_event_distribution($start_date, $end_date, $county, $facility);			
		
		} catch (Exception $e) {
			echo "Error :" .$e->getMessage();
		}
		
		echo json_encode($data);
	}

	public function index()
	{
		$county = '';
		$start_date='';
		$end_date = '';
		$facility='';
		$data['existing_events'] = $this->dashboard_model->get_existing_events($start_date, $end_date,$county, $facility);
		$data['counties']=$this->dashboard_model->get_counties();
		$data['facilities']=$this->dashboard_model->get_facilities();
		$data['events'] = $this->dashboard_model->filter_events_by_facility_and_county_and_start_date_and_end_date($facility, $county,$start_date, $end_date);
		$data['person_count']=$this->dashboard_model->get_total_person_counts_with_events($start_date, $end_date, $county, $facility);
		$data['population']=$this->dashboard_model->get_population_infected_and_seeking_care_summary($start_date, $end_date,$county, $facility);
		$data['indicator_data']=$this->dashboard_model->get_report_based_on_various_indicators($county, $facility, $start_date, $end_date);
		$data['event_counts']= $this->dashboard_model->get_event_counts_per_event($start_date, $end_date, $county, $facility);
		$data['totals']=$this->dashboard_model->get_total_event_counts($start_date, $end_date, $county, $facility);
		$data['counties']=$this->dashboard_model->get_counties();
		$data['facilities']=$this->dashboard_model->get_facilities();
		$data['template_header']='template_header';
		$data['template_footer']='template_footer';
		$data['main_content']='dashboard_view';
		$data['title']='Case Based Surveilance Dashboard';
		$this->load->view('template',$data);

	}

	public function table_view() {
		$county = '';
		$start_date='';
		$end_date = '';
		$facility='';
		$data['existing_events'] = $this->dashboard_model->get_existing_events($start_date, $end_date,$county, $facility);
		$data['counties']=$this->dashboard_model->get_counties();
		$data['facilities']=$this->dashboard_model->get_facilities();
		$data['events'] = $this->dashboard_model->filter_events_by_facility_and_county_and_start_date_and_end_date($facility, $county,$start_date, $end_date);
		$data['person_count']=$this->dashboard_model->get_total_person_counts_with_events($start_date, $end_date, $county, $facility);
		$data['population']=$this->dashboard_model->get_population_infected_and_seeking_care_summary($start_date, $end_date,$county, $facility);
		$data['indicator_data']=$this->dashboard_model->get_report_based_on_various_indicators($county, $facility, $start_date, $end_date);
		$data['event_counts']= $this->dashboard_model->get_event_counts_per_event($start_date, $end_date, $county, $facility);
		$data['totals']=$this->dashboard_model->get_total_event_counts($start_date, $end_date, $county, $facility);
		$data['counties']=$this->dashboard_model->get_counties();
		$data['facilities']=$this->dashboard_model->get_facilities();
		$data['template_header']='template_header';
		$data['template_footer']='template_footer';
		$data['main_content']='view_table_data';
		$data['title']='Case Based Surveilance Dashboard';
		$this->load->view('template',$data);
	}

	public function get_total_person_counts_with_events() 
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$count = $this->dashboard_model->get_total_person_counts_with_events($start_date, $end_date, $county, $facility);
		echo json_encode($count);
	}

	
	public function get_gender_based_yearly_event_distribution()
	{
		$county = $this->input->post('county');
		$facility = $this->input->post('facility');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$event_id = $this->input->post('event_id');

		$yearly_distribution = $this->dashboard_model->get_gender_based_yearly_event_distribution($start_date, $end_date,$county, $facility,$event_id);

		echo json_encode($yearly_distribution);
	}
}

 