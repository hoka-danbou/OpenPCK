<?php
/**
 * 指定されたコースのステータスを取得・設定する。
 */
class StatusManager
{
    public $base_dir = '../userdata';
    public $data_dir = '';
    public $username = '';
    public $course_num = -1;

    public $data = [];

    public function load($course_num) {
        if(empty($this->username)) {
            $this->username = $_SESSION['userid'];
        }
        $this->data_dir = $this->base_dir.'/'.$this->username;
        $this->course_num = $course_num;
        $filename = $this->data_dir.'/status-'.$course_num.'.txt';

        if(!file_exists($filename)) return [];

        $ret = [];
        $lines = explode("\n",file_get_contents($filename));
        foreach($lines as $line) {
            $fields = explode("\t", trim($line));
            if(count($fields) < 2) continue;
            $ret[$fields[0]] = [
                'num'    => $fields[0],
                'status' => $fields[1],
            ];
        }
        $this->data = $ret;
        return $ret;
    }

    public function getSummary() {
        $ret = [
            'ok'          => 0,
            'sent'        => 0,
            'compile-err' => 0,
            'unknown'     => 0,
            'total'       => 0,
        ];
        foreach($this->data as $items) {
            if(array_key_exists($items['status'], $ret)) {
                $ret[$items['status']]++;
            }else{
                $ret['unknown']++;
            }
            $ret['total']++;
        }
        return $ret;
    }

    public function setStatus($num, $status) {
        $this->data[$num]['status'] = $status;
    }

    public function getSource($quiz_num) {
        $filename = $this->data_dir.'/'.$this->course_num.'-'.$quiz_num.'-src.c';
        if(file_exists($filename)) {
            return file_get_contents($filename);
        }else{
            return '';
        }
    }

    public function write() {
        $text = '';
        foreach($this->data as $num => $item) {
            $text .= $num . "\t" . $item['status'] . "\n";
        }

        $filename = $this->data_dir.'/status-'.$this->course_num.'.txt';
        file_put_contents($filename, $text);
    }

}
