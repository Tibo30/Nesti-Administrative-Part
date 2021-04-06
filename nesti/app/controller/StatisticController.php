<?php
require_once(PATH_VIEW . 'View.php');

class StatisticController extends BaseController
{
    private $statisticsDAO;

    public function initialize()
    {
        $this->statistic();
    }

    private function statistic()
    {
        $this->statisticsDAO = new StatisticDAO();

        $statistic = $this->statisticsDAO->getStatistics();
        $data[] = null;
        $this->statisticsDAO = new StatisticDAO();


        //  ------------------------------ GET ALL THE LOGS --------------------------------- //

        $userLogDAO = new UserLogsDAO();
        $allLogs = $userLogDAO->getLogs(); // get all the logs

        foreach ($allLogs as $log) {
            $format = 'Y-m-d H:i:s';
            $logDate = DateTime::createFromFormat($format, $log->getConnectionDate()); // fromat each connection date
            //var_dump( $logDate);
            $hoursLog[$logDate->format('H')][] = $log; // sort the list of the logs by hours (hour is the key of the array $hoursLog)
        }
        //var_dump($hoursLog);

        foreach ($hoursLog as $key => $logs) {
            $connexionByHour[] = (object) array("hour" => $key, "number" => count($logs)); // count the number of logs for a given hour
        }
        //var_dump($connexionByHour);


        //  ------------------------------ GET ALL THE USERS --------------------------------- //

        $userDAO = new UserDAO();
        $users = $userDAO->getUsers(); // get all the users

        usort($users, function ($u1, $u2) { // sort the array DESC according to the number of logs for each user
            return count($u2->getLogs()) <=> count($u1->getLogs());
        });
        var_dump($users);
        $users = array_slice($users, 0, 10); // we keep the first 10

        $mostConectedUsers = [];
        foreach ($users as $user) {
            $mostConectedUsers[] = ["id" => $user->getIdUser(), "name" => $user->getLastName() . ' ' . $user->getFirstName()];
        }
        // FormatUtil::dump($allOrders);
        $startDate = new DateTime;
        $startDate->add(DateInterval::createFromDateString("-10 days"));


        //  ------------------------------ GET ALL THE CHIEFS --------------------------------- //

        $chiefs = $userDAO->getChiefs();
        usort($chiefs, function ($c1, $c2) { // sort the array DESC according to the number of recipes for each chief
            return count($c2->getRecipes()) <=> count($c1->getRecipes());
        });
        var_dump($chiefs);
        $chiefs = array_slice($chiefs, 0, 10); // we keep the first 10


        //  ------------------------------ GET ALL THE RECIPES --------------------------------- //
        $recipeDAO = new RecipeDAO();
        $recipes = $recipeDAO->getRecipes();
        usort($recipes, function ($r1, $r2) { // sort the array DESC according to the grade of the recipe
            return count($r2->getGrade()) <=> count($r1->getGrade());
        });
        var_dump($recipes);
        $recipes = array_slice($recipes, 0, 10); // we keep the first 10


        //  ------------------------------ GET ALL THE RECIPES --------------------------------- //
        $orderDAO = new OrderDAO();
        $orders = $orderDAO->getOrders();
        usort($orders, function ($o1, $o2) { // sort the array DESC according to the price of the order
            return count($o2->getAmount()) <=> count($o1->getAmount());
        });
        var_dump($orders);
        $orders = array_slice($orders, 0, 10); // we keep the first 10





        $this->_view = new View('Statistic');
        $this->_data = ['statistic' => $statistic, 'url' => $this->_url, "title" => "Statistic"];
    }
}
