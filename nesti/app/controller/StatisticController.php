<?php
require_once(PATH_VIEW.'View.php');

class StatisticController extends BaseController{
    private $statisticsDAO;

    public function initialize(){
        $this->statistic();
    }

    private function statistic(){
        $this->statisticsDAO = new StatisticDAO();

        $statistic = $this->statisticsDAO->getStatistics();
        
        $this->_view = new View('Statistic');
        $this->_data = ['statistic'=>$statistic,'url'=>$this->_url,"title"=>"Statistic"];
  
    }
}