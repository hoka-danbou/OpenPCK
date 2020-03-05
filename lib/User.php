<?php
class User
{
    public $base_dir = '../userdata';

    public $name = '';
    public $userid = '';
    public $password = '';
    public $hashed_password = '';
    public $status = array();

    public function auth_from_text($filename) {
        $passwords = file_get_contents($filename);
        $lines = explode("\n", $passwords);
        foreach($lines as $line) {
            if(trim($line) == '') continue;

            $fields = explode(' ', $line);
            if($this->userid == trim($fields[0])) {
                if($this->password == trim($fields[1])) {
                    if(!file_exists($this->base_dir.'/'.$this->userid)) {
                        $this->createUserDir();
                    }
                    return true;
                }else{
                    return false;
                }
            }
        }
        return false;
    }

    public function auth_from_ldap($ldaphost, $ldap_domain_name) {
        $ldapport = 389;
        $ldapconn = ldap_connect($ldaphost, $ldapport) or die('Unabled to connect to the server');
        if($ldapconn){
            $ldapbind = ldap_bind($ldapconn, $this->userid . '@' . $ldap_domain_name , $this->password);
            if($ldapbind){
                if(!file_exists($this->base_dir.'/'.$this->userid)) {
                    $this->createUserDir();
                }
                return true;
            }else{
                return false;
            }
        }else{
            echo 'LDAP connect failed.';
        }
    }

    public function createUserDir() {
        mkdir($this->base_dir.'/'.$this->userid);
    }

    public function changeUserData() {
    }

    public function getSource($cource_id, $quiz_id) {
        //return file_get_contents($this->base_dir.'/'.$this->userid.'/'.$cour
    }
    private function getUserStatus() {
        $this->status = array(
            'level' => 1,
        );
    }

}
