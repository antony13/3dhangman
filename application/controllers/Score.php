<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Score extends CI_Controller {
	public function __construct()
        {       
                parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('date');
        }

	public function highScores()
	{
		$data['title'] = 'High Scores!';
		$this->load->view('header',$data);
		$data['scores'] = $this->getScores();
		$this->load->view('modal_results',$data);
		$this->load->view('footer');
	}

	public function setScore()
	{
		$score = $this->input->post('score',true);
		if ($score <= 0)
		{
			die('O not allowed!');//error_log('Its 0',0);
		}
		$date_today = '%d/%M/%Y';
		$date_str = mdate($date_today);
		$pen_name = $this->input->post('pen_name',true);
		if (strlen($pen_name) <= 15)
		{
			$data = array('name' => $pen_name, 'score' => $score, 'date' => $date_str);
			$scores = $this->getScores();//array of scores
			array_push($scores,$data);
			$this->load->model('score_model');
			$this->score_model->saveFile($scores);
			redirect('score/results');
		} else {
			die('Maximum name length of 15 exceeded, exiting now.'); //needs to be a view
		}
	}

	public function results()
	{
		$data['scores'] = $this->getScores();
		$this->load->view('modal_results',$data);
	}

	/**
	 * Return an array with scores
	**/
	private function getScores()
	{
		$this->load->model('score_model');
		$arr = $this->score_model->getScores();
		return $arr;
	}
}

