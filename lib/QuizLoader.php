<?php
/**
    フォルダ構成
      tests/00_コース名/00_タイトル/
      00部分はそれぞれ01～99まで指定可能
 */
class QuizLoader
{
    public $data_dir = '../tests';
    public $user_base_dir = '../userdata';

    public function getCourses() {
        $ret = array();
		$dirs = scandir($this->data_dir);
		foreach($dirs as $q) {
            if( $q == '.' || $q == '..' ) continue;

            $ret[] = $q;
		}
        return $ret;
    }

	public function getQuizList($course_num) {
        $course  = $this->getCourseName($course_num);
		$quizzes = scandir($this->data_dir.'/'.$course);
        $ret = array();
		foreach($quizzes as $q) {
            if( $q == '.' || $q == '..' ) continue;

            $ret[] = $q;
		}
        return $ret;
	}

    public function getCourseName($course_num, $with_num = true) {
		$couses      = $this->getCourses();
        $course_name = array_shift(preg_grep('/'.$course_num . '_/', $couses));
        if(!$with_num) {
            $course_name = substr($course_name, 3);
        }
        return $course_name;
    }

    public function getQuizName($course_num, $quiz_num, $with_num = true) {
        $quizzes   = $this->getQuizList($course_num);
        $quiz_name = array_pop(preg_grep('/'.$quiz_num . '_/', $quizzes));

        if(!$with_num) {
            $quiz_name = substr($quiz_name, 3);
        }
        return $quiz_name;
    }

    public function getQuizDir($course_num, $quiz_num) {
        $course_name = $this->getCourseName($course_num);
        $quiz_name   = $this->getQuizName($course_num, $quiz_num);

        return $this->data_dir . '/' . $course_name . '/' . $quiz_name;
    }

    public function getAbout($dir_name) {
        $info = file_get_contents(
            $this->data_dir . '/' . $dir_name . '/about.txt'
        );

        return $info;
    }

    public function getUserDir() {
        $d = $_SESSION['userid'];
        return $this->user_base_dir . '/' . $d;
    }
}
