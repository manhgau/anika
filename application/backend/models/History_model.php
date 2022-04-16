<?php
    class History_model extends MY_Model {

        private $month;
        private $year;
        private $data_table;

        public function __construct()
        {
            parent::__construct();
            $this->month = date('m',time());
            $this->year = date('Y',time());
            $this->data_table = "history_{$this->year}_{$this->month}";
            // if ( ! $this->table_exist())
            // {
            //     $this->create_data_table();
            // }
        }

        private function table_exist($table_name = '')
        {
            if ( ! $table_name) $table_name = $this->data_table;
            if ($this->db->table_exists($table_name)) return TRUE;
            return FALSE;
        }

        private function create_data_table()
        {
            $this->load->dbforge();
            $this->dbforge->add_field(array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'user_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                ),
                'time' => array(
                    'type' => 'INT',
                    'constraint' => 15,
                ),
                'action' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => FALSE
                ),
                'item_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                ),
                'item_table' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => TRUE
                )
            ));
            $this->dbforge->add_key('id',TRUE);
            $this->dbforge->create_table($this->data_table);
        }

        public function add_history($user_id=NULL,$action,$item_id=NULL,$item_table=NULL) {
            return true;
            
            $user_logedin = $this->session->all_userdata();
            if(!$user_id) $user_id = $user_logedin['id'];
            if ( ! $user_id) {
                $this->session->sess_destroy();
                return TRUE;
            }
            $data = array(
                'user_id' => $user_id,
                'time' => time(),
                'action' => $action,
                'item_id' => $item_id,
                'item_table' => $item_table
            );
            if ($this->db->insert($this->data_table,$data)) return TRUE;
            return FALSE;
        }
        
        public function get_history_by_month($month,$year) {
            return true;
            
            $table_name = "history_{$year}_{$month}";
            if ( ! $this->table_exist($table_name)) return FALSE;
            $this->db->select('*');
            $this->db->from($table_name);
            $this->db->order_by('time DESC');
            return $this->get();
        }

}