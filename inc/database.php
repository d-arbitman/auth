<?php
class Database extends mysqli {
    protected static $instance;

    public function __construct() {
        // turn of error reporting
        mysqli_report(MYSQLI_REPORT_OFF);

        // connect to database
        parent::__construct('p:' . MySQL_HOST, MySQL_USER, MySQL_PASS, MySQL_DATABASE);
        $this->set_charset(MySQL_CHARACTER_SET);

        // check if a connection established
        if( mysqli_connect_errno() ) {
            throw new exception(mysqli_connect_error(), mysqli_connect_errno());
        }
    }

    public static function get_instance() {
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
