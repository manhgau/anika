<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    function do_memcache($key,$data='',$time=0,$is_set=0,$mem_host='localhost',$mem_port='11212') {
        $memcache = new Memcache;
        $memcache->connect($mem_host, $mem_port) or die ("Could not connect");
        if($is_set==1){
            $memcache->set($key, $data, false, $time) or die ("Failed to save data at the server");
            return;
        }else
            return $memcache->get($key);
        $memcache->close();    
    }

    function do_sql($query,$hostname='localhost',$user='serverviet_db14',$pass='UdgVoe5u',$db='serverviet_db14') {
        $con=mysqli_connect($hostname,$user,$pass,$db);
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }        
        $result = mysqli_query($con,$query);         
        $arr_result = array();                
        $i = 0;    
        while($row = @mysqli_fetch_array($result))
        {
            $arr_result[$i] = $row;
            $i++;
        }
        mysqli_close($con);
        return $arr_result;
    }
    
    function print_common() {
        echo 'common_helper';
    }