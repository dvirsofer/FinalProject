<?php

class DB
{

    private static $instance;

    /**
     * @var PDO
     */
    private static $db;

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

    function isLogin($userName, $password)
    {
        $sql = "SELECT * FROM users WHERE user_name='$userName' and user_password='$password'";
        $res =  self::$db->query($sql);
        $res = $res->fetchAll(PDO::FETCH_OBJ);
        if($res == null) {
            return false;
        }
        return true;
    }

    function getUserInfo($userName, $password)
    {
        $sql = "SELECT * FROM users WHERE user_name='$userName' and user_password='$password'";
        $user = self::$db->query($sql);
        $user = $user->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }

    function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE id='$userId'";
        $user = self::$db->query($sql);
        $user = $user->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }

    function getPassportInfo($passportId)
    {
        $sql = "SELECT * FROM passport WHERE worker_id='$passportId'";
        $user = self::$db->query($sql);
        $user = $user->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }

    function getAllWorkersOfCustomer($customerId)
    {
        $sql = "SELECT * FROM forgen_workes WHERE current_customer_id='$customerId'";
        $workers = self::$db->query($sql);
        $workers = $workers->fetchAll(PDO::FETCH_OBJ);
        return $workers;
    }

    function updateUserInfo($id, $userName, $userEmail, $userPhone, $userFirstName, $userLastName)
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

    function updateUserPassword($id, $userPassword)
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

    function getUserType($typeId)
    {
        $sql = "SELECT * FROM users_type WHERE id='$typeId'";
        $user = self::$db->query($sql);
        $user = $user->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }

    function getSettlement($sid)
    {
        $sql = "SELECT * FROM settlement WHERE id='$sid'";
        $settlement = self::$db->query($sql);
        $settlement = $settlement->fetchAll(PDO::FETCH_OBJ);
        return $settlement;
    }

    function getWorkerPassportInfo($passportNumber)
    {
        $sql = "SELECT * FROM passport WHERE passport_number='$passportNumber'";
        $passportInfo = self::$db->query($sql);
        $passportInfo = $passportInfo->fetchAll(PDO::FETCH_OBJ);
        return $passportInfo;
    }

    function getWorkerInfo($workerId)
    {
        $sql = "SELECT * FROM forgen_workes WHERE worker_id='$workerId'";
        $workerInfo = self::$db->query($sql);
        $workerInfo = $workerInfo->fetchAll(PDO::FETCH_OBJ);
        return $workerInfo;
    }

    function getWorkerInfoByName($workerName)
    {
        $sql = "SELECT * FROM forgen_workes WHERE last_name='$workerName'";
        $workerInfo = self::$db->query($sql);
        $workerInfo = $workerInfo->fetchAll(PDO::FETCH_OBJ);
        return $workerInfo;
    }

    function getAllPassports()
    {
        $sql = "SELECT * FROM passport";
        $allPassport = self::$db->query($sql);
        $allPassport = $allPassport->fetchAll(PDO::FETCH_OBJ);
        return $allPassport;
    }

    function getAllWorkers()
    {
        $sql = "SELECT * FROM forgen_workes";
        $workers = self::$db->query($sql);
        $workers = $workers->fetchAll(PDO::FETCH_OBJ);
        return $workers;
    }

    function getAllCustomers()
    {
        $sql = "SELECT * FROM customer";
        $customers = self::$db->query($sql);
        $customers = $customers->fetchAll(PDO::FETCH_OBJ);
        return $customers;
    }

    function getCustomerInfo($customerId)
    {
        $sql = "SELECT * FROM customer WHERE id='$customerId'";
        $customers = self::$db->query($sql);
        $customers = $customers->fetchAll(PDO::FETCH_OBJ);
        return $customers;
    }

    function getAllCustomersOrder()
    {
        $sql = "SELECT * FROM customer ORDER BY customer_name";
        $customers = self::$db->query($sql);
        $customers = $customers->fetchAll(PDO::FETCH_OBJ);
        return $customers;
    }

    function getAllContactsOfCustomerInfo($customerId)
    {
        $sql = "SELECT * FROM contacts WHERE customer_id='$customerId'";
        $contact = self::$db->query($sql);
        $contact = $contact->fetchAll(PDO::FETCH_OBJ);
        return $contact;
    }

    function addNewUser($userFirstName, $userLastName, $userName, $userEmail, $userPhone, $userPosition, $userPassword)
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

    function newWorker($firstName, $lastName, $bDate, $phone, $nation, $passportNumber, $validPassport, $gender,
                       $arrive, $arrivalDate, $comments, $userId, $customerId)
    {
        $workerId = $this->getMaxWorkerId();
        $workerId = intval($workerId) + 1;
        $birth_country = $nation;
        $userId = intval($userId);
        $customerId = intval($customerId);
        try{
            $sql = self::$db->prepare("INSERT INTO forgen_workes (worker_id, first_name, last_name, gender, entrance_date, form_of_eravel, birth_country, birthday_date, responsible_id, phone_number, citizen, current_customer_id, note)
                                VALUES(:workerId, :firstName, :lastName, :gender, :arrivalDate, :arrive, :birth_country, :bDate, :userId, :phone, :nation, :customerId, :comments)");
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
            $sql->bindParam(':comments', $comments);
            $sql->execute();
            //$this->addPassport($workerId, $passportNumber, $validPassport);
            return $workerId;
        }
        catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }
    }

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

    /*public function getMaxWorkerId()
    {
        $sql = "SELECT MAX(worker_id) FROM forgen_workes";
        $workerId = self::$db->prepare($sql);
        $workerId->execute();
        $workerId = $workerId->fetchColumn();
        return $workerId;
    }*/

    public function getMaxWorkerId()
    {
        $sql = "SELECT MAX(worker_id) FROM passport";
        $workerId = self::$db->prepare($sql);
        $workerId->execute();
        $workerId = $workerId->fetchColumn();
        return $workerId;
    }


    /**
     * print table
     * @param $table
     * @param null $keysArray

     * @return bool|PDOStatement
     */
    function getTableData($table, $keysArray = null, $sqlFunction = null)
    {


        if (self::$db != false) {

            // only user who has the table will succeed to get a result from the query
            if(isset($sqlFunction) && $sqlFunction != null)
                $sql = 'select '.$sqlFunction.' as funcColumn from' . ' ' . $table;
                else
                $sql = 'select * from' . ' ' . $table;




                if(isset($keysArray) && $keysArray != null)
                     $sql .= $this->getSQLWhere($keysArray);

            $query = self::$db->query($sql);

            if ($query == false)
                return $query;

            $query = $query->fetchAll(PDO::FETCH_OBJ);

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


        self::$db = $this->checkConnection();
        if ( self::$db != false)
        {

            $statement =  self::$db->prepare($sql);



           return $statement->execute();
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



	



