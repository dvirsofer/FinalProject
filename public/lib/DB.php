<?php

/**
 * Class DB
 */
class DB
{

    private static $instance;

    /**
     * @var PDO
     */
    private static $db;

    /**
     * @return DB
     */
    public static function getInstance()
    {

        if (null === self::$instance) {

            self::$instance = new self();

        }

        return self::$instance;
    }


    function test()
    {
        echo __FUNCTION__ . 'fff';
    }


    /**
     * Check connection of db.
     */
    function checkConnection()
    {

        $config = parse_ini_file("config.ini");
        if(!$config)
            $config = parse_ini_file(realpath("../../config.ini"));



        if(isset( $config['username']) &&  isset($config['password'])) {

           if(!isset(self::$db)) {

               $dbhost = $config['end_point'];
               $dbport =  $config['port'];
               $dbname = $config['dbname'];

               $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
               $username = $config['username'];
               $password =  $config['password'];


                try {
                    self::$db = new PDO($dsn, $username, $password);
                    self::$db-> exec("SET CHARACTER SET utf8");
                    self::$db-> exec("SET SQL_SAFE_UPDATES=0");

                }
                catch(PDOException  $e)
                {
                    var_dump($e->getMessage());
                }

               // var_dump( self::$db);


           }

       }

    }

    /**
     * @param $userName
     * @param $password
     * @return bool
     * true - if user name and password ok.
     * false - else.
     */
    public function isLogin($userName, $password)
    {
        $sql = "SELECT * FROM users WHERE user_name='$userName' and user_password='$password'";
        $res =  self::$db->query($sql);
        $res = $res->fetchAll(PDO::FETCH_OBJ);
        if($res == null) {
            return false;
        }
        return true;
    }

    /**
     * @param $userName
     * @param $password
     * @return array - all information of this user.
     */
    public function getUserInfo($userName, $password)
    {
        $sql = "SELECT * FROM users WHERE user_name='$userName' and user_password='$password'";
        $user = self::$db->query($sql);
        $user = $user->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }

    /**
     * @param $userId
     * @return array - all information of this user.
     */
    public function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE id='$userId'";
        $user = self::$db->query($sql);
        $user = $user->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }

    /**
     * @param $passportId
     * @return array - passport.
     */
    public function getPassportInfo($passportId)
    {
        $sql = "SELECT * FROM passport WHERE worker_id='$passportId'";
        $user = self::$db->query($sql);
        $user = $user->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }

    /**
     * @param $customerId
     * @return array - all worker of this customer.
     */
    public function getAllWorkersOfCustomer($customerId)
    {
        $sql = "SELECT * FROM forgen_workes WHERE current_customer_id='$customerId' and (worker_status IS NULL or worker_status=0)";
        $workers = self::$db->query($sql);
        $workers = $workers->fetchAll(PDO::FETCH_OBJ);
        return $workers;
    }

    /**
     * @param $id
     * @param $userName
     * @param $userEmail
     * @param $userPhone
     * @param $userFirstName
     * @param $userLastName
     * @return bool
     * true - if the update success.
     * false - else.
     */
    public function updateUserInfo($id, $userName, $userEmail, $userPhone, $userFirstName, $userLastName)
    {
        $fullName = $userFirstName . " " . $userLastName;
        try{
            $sql = "UPDATE users
                SET user_name='$userName', email='$userEmail', phone_number='$userPhone', full_name='$fullName'
                WHERE id='$id'";
            $update = self::$db->prepare($sql);
            $update = $update->execute();
            return true;
        }
        catch (Exception $e) {
            return false;
        }

    }

    /**
     * @param $id
     * @param $userPassword
     * @return bool
     * true - if update success.
     * false - else.
     */
    public function updateUserPassword($id, $userPassword)
    {
        try{
            $sql = "UPDATE users SET user_password='$userPassword'
                WHERE id='$id'";
            $update = self::$db->prepare($sql);
            $update = $update->execute();
            return true;
        }
        catch (Exception $e) {
            return false;
        }

    }

    /**
     * @param $customerId
     * @param $customerName
     * @param $customerNameEn
     * @param $settlement
     * @param $mainCustomer
     * @param $companyNumber
     * @param $agent
     * @return bool
     * true - if the update success.
     * false - else.
     */
    public function updateCustomer($customerId, $customerName, $customerNameEn, $settlement, $mainCustomer, $companyNumber, $agent)
    {
        try{
            $sql = "UPDATE customer
                SET customer_name='$customerName', name_in_english='$customerNameEn', company_number='$companyNumber',
                 settlement_id='$settlement', responsible_id='$agent', main_customer='$mainCustomer'
                WHERE id='$customerId'";
            $update = self::$db->prepare($sql);
            $update = $update->execute();
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function editWorker($workerId, $firstName, $lastName, $date, $phone, $nation,
                               $passportNumber, $validPassport, $gender, $arrive, $arrivalDate, $comments)
    {
        try{
            $sql = "UPDATE forgen_workes
                SET first_name='$firstName', last_name='$lastName', gender='$gender',
                 entrance_date='$arrivalDate', form_of_eravel='$arrive', birthday_date='$date', phone_number='$phone',
                 citizen='$nation', note='$comments'
                WHERE worker_id='$workerId'";
            $update = self::$db->prepare($sql);
            $update = $update->execute();
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function editWorkerPassport($workerId, $passportNumber, $validPassport)
    {
        try{
            $sql = "UPDATE passport
                SET passport_number='$passportNumber', validation_date='$validPassport'
                WHERE worker_id='$workerId'";
            $update = self::$db->prepare($sql);
            $update = $update->execute();
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $typeId
     * @return array - the user type.
     */
    public function getUserType($typeId)
    {
        $sql = "SELECT * FROM users_type WHERE id='$typeId'";
        $user = self::$db->query($sql);
        $user = $user->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }

    /**
     * @param $sid
     * @return array - settlement.
     */
    public function getSettlement($sid)
    {
        $sql = "SELECT * FROM settlement WHERE id='$sid'";
        $settlement = self::$db->query($sql);
        $settlement = $settlement->fetchAll(PDO::FETCH_OBJ);
        return $settlement;
    }

    /**
     * @return array - all settlements.
     */
    public function getAllSettlements()
    {
        $sql = "SELECT * FROM settlement";
        $settlement = self::$db->query($sql);
        $settlement = $settlement->fetchAll(PDO::FETCH_OBJ);
        return $settlement;
    }

    /**
     * @param $passportNumber
     * @return array - passport.
     */
    public function getWorkerPassportInfo($passportNumber)
    {
        $sql = "SELECT * FROM passport WHERE passport_number='$passportNumber'";
        $passportInfo = self::$db->query($sql);
        $passportInfo = $passportInfo->fetchAll(PDO::FETCH_OBJ);
        return $passportInfo;
    }

    /**
     * @param $workerId
     * @return array - all of the worker.
     */
    public function getWorkerInfo($workerId)
    {
        $sql = "SELECT * FROM forgen_workes WHERE worker_id='$workerId'";
        $workerInfo = self::$db->query($sql);
        $workerInfo = $workerInfo->fetchAll(PDO::FETCH_OBJ);
        return $workerInfo;
    }

    /**
     * @param $workerName
     * @return array - all of the worker.
     */
    public function getWorkerInfoByName($workerName)
    {
        $sql = "SELECT * FROM forgen_workes WHERE last_name='$workerName'";
        $workerInfo = self::$db->query($sql);
        $workerInfo = $workerInfo->fetchAll(PDO::FETCH_OBJ);
        return $workerInfo;
    }

    /**
     * @return array - all passports.
     */
    public function getAllPassports()
    {
        $sql = "SELECT * FROM passport";
        $allPassport = self::$db->query($sql);
        $allPassport = $allPassport->fetchAll(PDO::FETCH_OBJ);
        return $allPassport;
    }

    public function updateWorker($workerId)
    {
        try{
            $sql = "UPDATE forgen_workes
                SET worker_status='1'
                WHERE worker_id='$workerId'";
            $update = self::$db->prepare($sql);
            $update = $update->execute();
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return array - all workers.
     */
    public function getAllWorkers()
    {
        $sql = "SELECT * FROM forgen_workes where worker_status IS NULL or worker_status=0";
        $workers = self::$db->query($sql);
        $workers = $workers->fetchAll(PDO::FETCH_OBJ);
        return $workers;
    }

    /**
     * @return array - all workers details.
     */
    public function getAllWorkersDetails()
    {
        $sql = "select forgen_workes.id, forgen_workes.worker_id, forgen_workes.last_name, forgen_workes.first_name, forgen_workes.entrance_date, forgen_workes.start_date_of_work, forgen_workes.phone_number,  passport.passport_number, passport.validation_date
from forgen_workes
inner join passport
on forgen_workes.worker_id=passport.worker_id where worker_status IS NULL or worker_status=0";
        $workers = self::$db->query($sql);
        $workers = $workers->fetchAll(PDO::FETCH_OBJ);
        return $workers;
    }

    /**
     * @return array - all customers.
     */
    public function getAllCustomers()
    {
        $sql = "SELECT * FROM customer";
        $customers = self::$db->query($sql);
        $customers = $customers->fetchAll(PDO::FETCH_OBJ);
        return $customers;
    }

    /**
     * @return array - all customers details.
     */
    public function getAllCustomersDetails()
    {
        $sql = "select customer.id, customer.customer_name,customer.name_in_english, customer.company_number, customer.responsible_id, customer.create_date, settlement.settlement_name
from customer
inner join settlement
on customer.settlement_id=settlement.id";
        $customers = self::$db->query($sql);
        $customers = $customers->fetchAll(PDO::FETCH_OBJ);
        return $customers;
    }


    /**
     * @param $customerId
     * @return array - customer.
     */
    public function getCustomerInfo($customerId)
    {
        $sql = "SELECT * FROM customer WHERE id='$customerId'";
        $customers = self::$db->query($sql);
        $customers = $customers->fetchAll(PDO::FETCH_OBJ);
        return $customers;
    }

    /**
     * @return array - all customers.
     */
    public function getAllCustomersOrder()
    {
        $sql = "SELECT * FROM customer ORDER BY customer_name";
        $customers = self::$db->query($sql);
        $customers = $customers->fetchAll(PDO::FETCH_OBJ);
        return $customers;
    }

    /**
     * @return array - all user of type agent.
     */
    public function getAllAgent()
    {
        $sql = "SELECT * FROM users WHERE type_id=2";
        $allAgents = self::$db->query($sql);
        $allAgents = $allAgents->fetchAll(PDO::FETCH_OBJ);
        return $allAgents;
    }

    /**
     * @param $customerId
     * @return array - all contacts of this customer.
     */
    public function getAllContactsOfCustomerInfo($customerId)
    {
        $sql = "SELECT * FROM contacts WHERE customer_id='$customerId'";
        $contact = self::$db->query($sql);
        $contact = $contact->fetchAll(PDO::FETCH_OBJ);
        return $contact;
    }

    /**
     * @param $userFirstName
     * @param $userLastName
     * @param $userName
     * @param $userEmail
     * @param $userPhone
     * @param $userPosition
     * @param $userPassword
     * @return string - message.
     */
    public function addNewUser($userFirstName, $userLastName, $userName, $userEmail, $userPhone, $userPosition, $userPassword)
    {
        $userPosition = intval($userPosition);
        try{
            $sql = self::$db->prepare("INSERT INTO users (type_id, user_name, user_password, phone_number, email, full_name)
                                VALUES(:userPosition, :username, :password, :phone, :email, :fullName)");
            $sql->bindParam(':userPosition', $userPosition);
            $sql->bindParam(':username', $userName);
            $sql->bindParam(':password', $userPassword);
            $sql->bindParam(':phone', $userPhone);
            $sql->bindParam(':email', $userEmail);
            $userFullName = $userFirstName. " " . $userLastName;
            $sql->bindParam(':fullName', $userFullName);
            $sql->execute();
            return "success";
        }
        catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }

    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $bDate
     * @param $phone
     * @param $nation
     * @param $passportNumber
     * @param $validPassport
     * @param $gender
     * @param $arrive
     * @param $arrivalDate
     * @param $comments
     * @param $userId
     * @param $customerId
     * @return int - worker id.
     */
    public function newWorker($firstName, $lastName, $bDate, $phone, $nation, $passportNumber, $validPassport, $gender,
                       $arrive, $arrivalDate, $comments, $userId, $customerId)
    {
        $workerId = $this->getMaxWorkerId();
        $workerId = intval($workerId) + 1;
        $birth_country = $nation;
        $userId = intval($userId);
        $customerId = intval($customerId);
        $status = 0;
        try{
            $sql = self::$db->prepare("INSERT INTO forgen_workes (worker_id, first_name, last_name, gender, entrance_date, form_of_eravel, birth_country, birthday_date, responsible_id, phone_number, citizen, current_customer_id, worker_status, note)
                                VALUES(:workerId, :firstName, :lastName, :gender, :arrivalDate, :arrive, :birth_country, :bDate, :userId, :phone, :nation, :customerId, :status, :comments)");
            $sql->bindParam(':workerId', $workerId);
            $sql->bindParam(':firstName', $firstName);
            $sql->bindParam(':lastName', $lastName);
            $sql->bindParam(':gender', $gender);
            $sql->bindParam(':arrivalDate', $arrivalDate);
            $sql->bindParam(':arrive', $arrive);
            $sql->bindParam(':birth_country', $birth_country);
            $sql->bindParam(':bDate', $bDate);
            $sql->bindParam(':userId', $userId);
            $sql->bindParam(':phone', $phone);
            $sql->bindParam(':nation', $nation);
            $sql->bindParam(':customerId', $customerId);
            $sql->bindParam(':status', $status);
            $sql->bindParam(':comments', $comments);
            $sql->execute();
            //$this->addPassport($workerId, $passportNumber, $validPassport);
            return $workerId;
        }
        catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }
    }

    /**
     * @param $customerName
     * @param $customerNameEn
     * @param $settlement
     * @param $mainCustomer
     * @param $companyNumber
     * @param $agent
     * @return string - message.
     */
    public function addNewCustomer($customerName, $customerNameEn, $settlement, $mainCustomer, $companyNumber, $agent)
    {
        $agent = intval($agent);
        try{
            $sql = self::$db->prepare("INSERT INTO customer (customer_name, name_in_english, company_number, settlement_id, responsible_id, main_customer)
                                VALUES(:customerName, :customerNameEn, :companyNumber, :settlement, :agent, :mainCustomer)");
            $sql->bindParam(':customerName', $customerName);
            $sql->bindParam(':customerNameEn', $customerNameEn);
            $sql->bindParam(':companyNumber', $companyNumber);
            $sql->bindParam(':settlement', $settlement);
            $sql->bindParam(':agent', $agent);
            $sql->bindParam(':mainCustomer', $mainCustomer);
            $sql->execute();
            return "success";
        }
        catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }
    }

    /**
     * @param $workerId
     * @param $passportNumber
     * @param $validPassport
     * @return string - message.
     */
    public function addPassport($workerId, $passportNumber, $validPassport)
    {
        try{
            $sql = self::$db->prepare("INSERT INTO passport (worker_id, passport_number, validation_date)
                                VALUES(:workerId, :passportNumber, :validPassport)");
            $sql->bindParam(':workerId', $workerId);
            $sql->bindParam(':passportNumber', $passportNumber);
            $sql->bindParam(':validPassport', $validPassport);
            $sql->execute();
            return "success";
        }
        catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }
    }

    /**
     * @param $descriptionId
     * @param $status
     * @param $userId
     * @param $workerId
     * @param $description
     * @return string - message.
     */
    public function addActivity($descriptionId, $status, $userId, $workerId, $description)
    {
        $userId = intval($userId);
        $workerId = intval($workerId);
        try{
            $sql = self::$db->prepare("INSERT INTO activity (description_id, status_description, user_id, worker_id, description)
                                VALUES(:descriptionId, :status, :userId, :workerId, :description)");
            $sql->bindParam(':descriptionId', $descriptionId);
            $sql->bindParam(':status', $status);
            $sql->bindParam(':userId', $userId);
            $sql->bindParam(':workerId', $workerId);
            $sql->bindParam(':description', $description);
            $sql->execute();
            return "success";
        }
        catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }
    }

    /**
     * @param $descriptionId
     * @param $status
     * @param $userId
     * @param $workerId
     * @param $description
     * @param $customerId
     * @param $newEmployer
     * @return string - message.
     */
    public function addMobilityActivity($descriptionId, $status, $userId, $workerId, $description, $customerId, $newEmployer)
    {
        $userId = intval($userId);
        $workerId = intval($workerId);
        try{
            $sql = self::$db->prepare("INSERT INTO activity (description_id, status_description, user_id, worker_id, description, customer_id, new_customer_id)
                                VALUES(:descriptionId, :status, :userId, :workerId, :description, :customerId, :newEmployer)");
            $sql->bindParam(':descriptionId', $descriptionId);
            $sql->bindParam(':status', $status);
            $sql->bindParam(':userId', $userId);
            $sql->bindParam(':workerId', $workerId);
            $sql->bindParam(':description', $description);
            $sql->bindParam(':customerId', $customerId);
            $sql->bindParam(':newEmployer', $newEmployer);
            $sql->execute();
            return "success";
        }
        catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }
    }

    /**
     * @param $id
     * @return array - activity type.
     */
    public function getActivityType($id)
    {
        $sql = "SELECT * FROM description_name WHERE id='$id'";
        $activityType = self::$db->query($sql);
        $activityType = $activityType->fetchAll(PDO::FETCH_OBJ);
        return $activityType;
    }

    /**
     * @return array - all activities.
     */
    public function getAllActivities()
    {
        $sql = "SELECT * FROM activity ORDER BY id";
        $activities = self::$db->query($sql);
        $activities = $activities->fetchAll(PDO::FETCH_OBJ);
        return $activities;
    }

    /**
     * @param $activityId
     * @return array - activity.
     */
    public function getActivity($activityId)
    {
        $sql = "SELECT * FROM activity WHERE id='$activityId'";
        $activity = self::$db->query($sql);
        $activity = $activity->fetchAll(PDO::FETCH_OBJ);
        return $activity;
    }

    /**
     * @return array - all open activities.
     */
    public function getAllOpenActivities()
    {
        $sql = "SELECT * FROM activity WHERE status_description='open' ORDER BY id";
        $activities = self::$db->query($sql);
        $activities = $activities->fetchAll(PDO::FETCH_OBJ);
        return $activities;
    }

    /**
     * @param $activityId
     * @return bool
     * true - if update success.
     * false - else.
     */
    public function updateCancelActivity($activityId)
    {
        try{
            $sql = "UPDATE activity
                SET status_description='cancel'
                WHERE id='$activityId'";
            $update = self::$db->prepare($sql);
            $update = $update->execute();
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $activityId
     * @return bool
     * true - if update success.
     * false - else.
     */
    public function editActivity($activityId)
    {
        try{
            $sql = "UPDATE activity
                SET status_description='close'
                WHERE id='$activityId'";
            $update = self::$db->prepare($sql);
            $update = $update->execute();
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $workerId
     * @param $customerId
     * @return bool
     * true - if update success.
     * false - else.
     */
    public function updateCustomerOfWorker($workerId, $customerId)
    {
        try{
            $sql = "UPDATE forgen_workes
                SET current_customer_id='$customerId'
                WHERE worker_id='$workerId'";
            $update = self::$db->prepare($sql);
            $update = $update->execute();
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return PDOStatement = worker id.
     */
    public function getMaxWorkerId()
    {
        $sql = "SELECT MAX(worker_id) FROM passport";
        $workerId = self::$db->prepare($sql);
        $workerId->execute();
        $workerId = $workerId->fetchColumn();
        return $workerId;
    }

    /**
     * @return string - all workers.
     */
    public function createWorkersFile()
    {
        // we initialize the output with the headers
        $output = "id,worker_id,last_name,first_name,entrance_date,start_date_of_work,phone_number,passport_number,validation_date\n";
        // select all members
        $sql = "select forgen_workes.id, forgen_workes.worker_id, forgen_workes.last_name, forgen_workes.first_name, forgen_workes.entrance_date, forgen_workes.start_date_of_work, forgen_workes.phone_number,  passport.passport_number, passport.validation_date
from forgen_workes
inner join passport
on forgen_workes.id=passport.worker_id";
        $query = self::$db->prepare($sql);
        $query->execute();
        $list = $query->fetchAll();
        foreach ($list as $rs) {
            // add new row
            $output .= $rs['id'].",".$rs['worker_id'].",".$rs['last_name'].",".$rs['first_name'].",".$rs['entrance_date'].",".$rs['start_date_of_work'].",".$rs['phone_number'].",".$rs['passport_number'].",".$rs['validation_date']."\n";
        }
        // export the output
        return $output;
    }

    /**
     * @return string - all customers.
     */
    public function createCustomersFile()
    {
        // we initialize the output with the headers
        $output = "id,customer_name,name_in_english,company_number,responsible_id,create_date,settlement_name\n";
        // select all members
        $sql = "select customer.id, customer.customer_name,customer.name_in_english, customer.company_number, customer.responsible_id, customer.create_date, settlement.settlement_name
from customer
inner join settlement
on customer.settlement_id=settlement.id";
        $query = self::$db->prepare($sql);
        $query->execute();
        $list = $query->fetchAll();
        foreach ($list as $rs) {
            // add new row
            $output .= $rs['id'].",".$rs['customer_name'].",".$rs['name_in_english'].",".$rs['company_number'].",".$rs['responsible_id'].",".$rs['create_date'].",".$rs['settlement_name']."\n";
        }
        // export the output
        return $output;
    }


    /**
     * get table data
     * @param $table
     * @param null $keysArray
     * @param null $sqlFunction  - is sql is function
     * @param bool $sqlSingleRow - to return single row
     * @return array|bool|PDOStatement
     */
    function getTableData($table, $keysArray = null, $sqlFunction = null,$sqlSingleRow = false)
    {


        if (self::$db != false) {

            // only user who has the table will succeed to get a result from the query
            if(isset($sqlFunction) && $sqlFunction != null)
                $sql = 'select '.$sqlFunction.' as funcColumn from' . ' ' . $table;
                else
                $sql = 'select * from' . ' ' . $table;




                if(isset($keysArray) && $keysArray != null)
                     $sql .= $this->getSQLWhere($keysArray);

            if($sqlSingleRow)
                $sql .=' Limit 0,1';

            $query = self::$db->query($sql);

            if ($query == false)
                return $query;



                $query = $query->fetchAll(PDO::FETCH_OBJ);

            if($sqlSingleRow)
                return $query[0];


            return $query;

        }
        return false;

        // return $res->fetchAll(PDO::FETCH_OBJ);;


    }


    private function getSQLWhere($keysArray){
        $sql = '';
        if (is_array($keysArray))
        {

            $sql = ' where ';

            foreach ($keysArray as $k => $v) {
                $v=str_replace("'","\'",$v);
                $sql .= $k . ' = ' . $this->createQuotation($v) . ' and ';
            }
            // removing "and" from the end of $selectSuffix

            $sql = rtrim($sql,' and ');


        }

        return $sql;
    }


    /**
     * @param $tableName
     * @param $setArray (key =>value) ex 'name => 'Test'
     * @param $whereArray (key =>value) ex 'name => 'Test'
     * @return mixed
     */
    function  update($tableName, $setArray, $whereArray)
    {


        $sql = 'update ' . $tableName;

        if (is_array($setArray)) {
            $sql .= ' set ';
            foreach ($setArray as $k => $v) {
                $v=str_replace("'","\'",$v);

                $sql .= $k . ' = ' . $this->createQuotation($v) . ',';

            }

            $sql = rtrim($sql, ',');


        }


        $sql .= $this->getSQLWhere($whereArray);


        try {

            $statement = self::$db->prepare($sql);
           
            $ff = $statement->execute();

            return $ff;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }


    /**
     * @param $table
     * @param $values
     * @return bool
     */
    function  insert($table ,$values)
    {
        $sqlKeys =' (';
        $sqlValues =' (';


        foreach($values as $k => $v)
        {
            $sqlKeys .=  $k . ',';
            $sqlValues .= $this->createQuotation ( $v) . ',';


        }

        $sqlKeys = rtrim($sqlKeys, ",");
        $sqlValues = rtrim($sqlValues, ",");
        $sqlKeys .= ')';
        $sqlValues .= ')';


        $sql = 'insert into' . ' ' . $table . $sqlKeys .   ' values ' . $sqlValues;


       // self::$db = $this->checkConnection();
        if ( self::$db != false)
        {

            $statement =  self::$db->prepare($sql);



           if($statement->execute())
               self::$db->lastInsertId();
        }

        return false;
    }



    private  function createQuotation($value)
    {
        if(!is_int($value))
        {
            if (strpos($value, 'SEQ') === false && strpos($value, 'sysdate') === false)
                $value = "'" . $value . "'";

        }

        return  $value;
    }

    public function sql_query($sql)
    {

        if (self::$db != false) {

            $query = self::$db->query($sql);

            if ($query == false)
                return $query;

            $query = $query->fetchAll(PDO::FETCH_OBJ);
            return $query;
        }
    }


}



	



