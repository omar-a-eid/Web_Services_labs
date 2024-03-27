<?php
interface DbHandler_Interface
{
    public function connect();
    public function get_data();
    public function disconnect();
    public function get_record_by_id($id);


}