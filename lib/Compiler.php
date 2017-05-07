<?php
abstract class Compiler
{
    public $err ='';
    public function compile($filename) {}
}

class CompilerC extends Compiler
{
    public function compile($filename) {
        $this->err = '';

        $outfilename = dirname($filename) . '/output';
        $ret = [];
        exec('gcc ' . $filename . ' -o ' . $outfilename . ' 2>&1', $ret);

        $this->err = trim(implode("\n", $ret));
        $this->err = str_replace($filename.':', '', $this->err);

        return $outfilename;
    }
}
/*
class CompilerCPP extends Compiler
{
    public static function compile($filename) {
        $outfilename = dirname($filename) . '/output';
        $ret = array();
        passthru('g++ -o ' . $outfilename . ' ' . $filename . ' -lm -02', $ret);
        return $outfilename;
    }
}

class CompilerJava extends Compiler
{
    public static function compile($filename) {
        $outfilename = dirname($filename) . '/output';
        $ret = array();
        passthru('javac ' . $filename , $ret);
        return $filename;
    }
}

*/
