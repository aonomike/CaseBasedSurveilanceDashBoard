<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Patient extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->model('patient_model');
		$this->load->model('rbac_model');		
	}

	public function get_patients()
	{
		$county = '';
		$start_date='';
		$end_date = '';
		$facility='';
		$data['patients'] = $this->patient_model->get_patients();
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
		$data['main_content']='patient_view';
		$data['title']='Patient Report';
		$this->load->view('template',$data);

	}


	
}

 