<?php
class Tester
{
    public $course_num;
    public $quiz_num;
    public $user_dir;
    public $test_dir;
    public $exe;
    public $test_result = [ 'ok' => 0, 'ng' => 0 ];

    public function start() {
        $ok_cnt = 0;
        $ng_cnt = 0;
        $user_dir = $this->user_dir;
        for($i = 1; $i < 100; $i++) {
            $num = sprintf('%02d', $i);
            $param_file  = $this->test_dir . '/'. $num.'-param.txt';
            $answer_file = $this->test_dir . '/'.$num.'-answer.txt';

            if(!file_exists($param_file)) break;

            //ファイルにパラメータを渡して実行
            exec($this->exe.' < '.$param_file, $ret);
            $ret = implode("\n", $ret);

            //Windows上でanswerファイル変換した場合、
            //文字コードの変換と改行コードの変換が必要
            $answer = file_get_contents($answer_file);
            //$answer = mb_convert_encoding($answer, 'utf8', 'sjis');
            $answer = str_replace("\r\n","\n", $answer);

            if(trim($ret) == trim($answer)) {
                $ok_cnt++;
            }else{
                $ng_cnt++;
            }

        }
        $this->test_result['ok'] = $ok_cnt;
        $this->test_result['ng'] = $ng_cnt;

        return ($ng_cnt == 0) ? true : false;
    }
}
