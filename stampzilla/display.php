#!/usr/bin/php
<?php
declare(ticks=1);

require_once '../lib/component.php';
require_once '../lib/php_serial.class.php';

class migra {/*{{{*/
    const black='0';
    const green=1;
    const red=2;
    const yellow=3;
    const transparent='T';

    public $data = '';

    function connect() {
        echo "Creating serial class\n";
        $this->s = new phpSerial();
        $this->s->deviceSet( "/dev/ttyUSB0" );
        $this->s->conf( "19200 -parenb cs8 -cstopb -clocal -crtscts -ixon -ixoff -echo raw" );
        $this->s->deviceOpen();
    }

    function send($data = null) {
        if ( $data == null ) {
            $data = $this->data;

            $header = chr(129).chr(128).chr(128);

            $footer = chr(03);
            
            //$data = str_pad( $data,6,'0',STR_PAD_RIGHT );
            
            $send = chr(2).$header.$data.$footer;
            if ( !$this->s->sendMessage($send) )
                die('Skriv fel!');

            $this->data = '';

            usleep(100000);
        } else {
            $this->data .= $data;
        }
    }

    function font($size,$uniform=true) {
        if ( $size < -1 || $size > 4 )
            return false;

        $data = chr(27); //ESC
        if ( $uniform )
            $data .= 'z';
        else
            $data .= 'Z';

        $data .= '0'.$size;

        $this->send( $data );
    }

    function position( $left, $top ) {
        $data = chr(27); //ESC
        $data .= 'C';

        $data .= str_pad( $left,3,'0',STR_PAD_LEFT );
        $data .= str_pad( $top,3,'0',STR_PAD_LEFT );

        $this->send( $data );
    }

    function box( $left, $top, $right, $bottom, $border, $bg ) {
        $data = chr(27); //ESC
        $data .= 'R';
        $data .= $border;
        $data .= $bg;

        $data .= str_pad( $left,3,'0',STR_PAD_LEFT );
        $data .= str_pad( $top,3,'0',STR_PAD_LEFT );
        $data .= str_pad( $right,3,'0',STR_PAD_LEFT );
        $data .= str_pad( $bottom,3,'0',STR_PAD_LEFT );

        $this->send( $data );
    }

    function color($fg,$bg = migra::black,$blink = false) {
        $data = chr(27); //ESC
        $data .= 'A';
        
        $data .= $fg;
        $data .= $bg;

        if ( $blink )
            $data .= '1';
        else
            $data .= '0';

        $this->send( $data );
    }

    function fill($bg) {
        $data = chr(27); //ESC
        $data .= 'F';

        $data .= $bg;

        $this->send( $data );
    }
    function clear() {
        $this->fill(migra::black);
    }
    function text($text) {
        $data = chr(31); //ESC
        $data .= $text;
        $this->send( $data );
    }

    function dimRed( $lv=100 ) {
        $data = chr(27); //ESC
        $data .= 'H2';
        $lv = intval($lv);

        $data .= str_pad( $lv,3,'0',STR_PAD_LEFT );

        $this->send( $data );
    }
    function dimGreen( $lv=100 ) {
        $data = chr(27); //ESC
        $data .= 'H1';
        $lv = intval($lv);

        $data .= str_pad( $lv,3,'0',STR_PAD_LEFT );

        $this->send( $data );
    }
}/*}}}*/

class display extends component {
    private $beckhoffOld = array();
    private $time = 0;
    private $temp = 0;
    private $highscore = 0;


    function startup() {
        $this->d = new migra();
        $this->d->connect();
        $this->d->clear();
        $this->d->color(migra::red);
        $this->d->dimGreen();
        $this->d->dimRed();
        $this->d->send();
        $this->write();

        $this->broadcast(array('type'=>'hello'));
    }

    function event($pkt) {
        if ( isset($pkt['type']) && $pkt['type'] == 'state' && $pkt['from'] == 'beckhoff' ) {
            $this->beckhoff = $pkt['data']['Interface'];

            $diff = array_diff_assoc($this->beckhoff,$this->beckhoffOld);
            $this->beckhoffOld = $this->beckhoff;

            /*
                [ibPump] => 1
                [ibRelease] => 1
                [ibForceRed] =>
                [ibForceYellow] =>
                [ibForceGreen] =>
                [ibAuto] =>
                [ibCameraReady] => 1
                [obPumping] => 1
                [obReady] => 1
                [obRed] =>
                [obYellow] =>
                [obGreen] => 1
                [obFalseStart] =>
                [onTime1] => 0
                [onTime2] => 0
                [onTime3] => 14070
                [onTimeTotal] => 14070
                [onState] => 0
                [obES] =>
                [obSensorError1] =>
                [obSensorError2] =>
                [obSensorError3] =>
                [onTemperature] => 17901

            */

            if ( isset($diff['onState']) && $diff['onState'] == 0 ) {
                $this->time = $this->beckhoff['onTimeTotal'] / 1000;
                $this->highscore = file_get_contents('http://kanan.vassaro.net/fastest');
                echo "highscore: ".$this->highscore."\n";
                $update = true;
            }

            if ( isset($diff['onTemperature']) ) {
                $this->temp = $diff['onTemperature'] / 1000;
                $update = true;
            }

        }

        if ( isset($update) )
            $this->write();
    }

    function write() {
        $this->d->clear();
        $this->d->position(0,24);
        $this->d->text('Temp');
        $this->d->font(0,false);
        $this->d->position(29,24);
        $this->d->text(substr($this->temp,0,5).'   ');

        $this->d->font(2,true);


        //$this->d->box(0,0,63,16,migra::black,migra::black);
        $this->d->position(0,1);
        //$this->d->text(date('s'));
        //$this->d->font(2,false);
        //$this->d->text('.');
        //$this->d->font(2,true);
        $this->d->text($this->time,0,5);
        //$this->d->font(0,true);
        //$this->d->text(date('s'));

        $this->d->position(0,16);
        $this->d->font(0,true);
        $this->d->text('Best');
        $this->d->font(0,false);
        $this->d->position(29,16);
        $this->d->text(substr($this->highscore,0,5));

        $this->d->send();
    }
}

$t = new display();
$t->start('display');

?>
