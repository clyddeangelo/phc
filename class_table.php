<?php
class PHCT {

    private array $table;

    private function get() {
        return $this->table;
    }

    function __construct($table = [[]]) {
        $this->table = $table;
    }
    

    function set($array) {
        $this->table = $array;
    }

    static function IF_COL_LONGER(string $key, string $value):int {
        $klen = strlen($key);
        $vlen = strlen($value);

        if($klen >= $vlen)
            return $klen;
        return $vlen;
    }

    static function column_largest_string(array $table, $key /* column name */ ):int {
        $strings = [];
        foreach($table as $row) {
            $strings[] = strlen($row[$key]);
        }
        $strings[] = strlen($key);
        return max($strings) + 1;
    }

    static function header_decoration(array $cols, array $lens) {
        $header = "";
        foreach($cols as $col) {
            $header .= sprintf("+%'-{$lens[$col]}s", "");
        }
        return $header."+\n";
    }

    static function header(array $cols, array $lens) {
        $header = "";
        foreach($cols as $col) {
            $header .= sprintf("|%{$lens[$col]}s", $col);
        }
        return $header."|\n";
    }

    static function row_builder($row, $lengths) {
        $strrow = "";
        foreach($row as $k=>$v):

            $strrow.= sprintf("|%{$lengths[$k]}s", $v);
        endforeach;
        $strrow .= "|\n";
        return $strrow;
    }

    static function longest_lengths(array $table, &$store) {
        $keys = array_keys($table[0]);
        foreach($keys as $k):  
            $store[$k] = self::column_largest_string($table, $k);
        endforeach; 
    }

    function console_table() { 

        $signature = "by clydde";
        $longest_lengths = array();
        $columns = array_keys($this->table[0]);
        self::longest_lengths($this->table, $longest_lengths); 
        // the longest lengths for each columns, are stored in the 'reference variable $longest_lengths'
        $table_width = array_sum($longest_lengths);
        // These are the functions that deal with the headers
        echo self::header_decoration($columns, $longest_lengths);
        echo self::header($columns, $longest_lengths);
        echo self::header_decoration($columns, $longest_lengths);

        // These loops over the rows and echoes the row as a formatted string
        foreach($this->table as $row)
            echo self::row_builder($row, $longest_lengths);
        
        $closing_line = $table_width + count($columns) + 1;
        echo str_repeat("-", $closing_line)."\n";

        $leftPad = $closing_line - strlen($signature);
        echo sprintf("%{$leftPad}s", " ").$signature."\n";

        echo "Any bugs? send mail here: clyddeangelocorpuz@gmail.com";
    }

};

/*

    To print a table in the console
    
    1. Initialize a PHCT object.
        $PHCObj = new PHCT($table);
    2. To print the table call console_table().
        $PHCObj->console_table();
    
    This is a sample run from c_codes' computer:
    +-----+-------------------------------+--------+-----+
    | udid|                         udname| udchair| ubid|
    +-----+-------------------------------+--------+-----+
    |    1|          Department of Physics|       1|    3|
    |    2|         Department of Medicine|       2|    3|
    |    3|        Department of Economics|       3|    3|
    |    4|             Department of Arts|       7|    3|
    |    5| Department of Computer Science|       4|    3|
    ------------------------------------------------------
                                                 by clydde
    Any bugs? send mail here: clyddeangelocorpuz@gmail.com


*/

?>
