#!/usr/bin/php
<?php
declare(ticks=1);

require_once '../lib/component.php';
require_once '../lib/php_serial.class.php';

class display extends component {
    private $beckhoffOld = array();
    
    function startup() {
        $this->s = new phpSerial();
        $this->s->deviceSet( "/dev/ttyUSB1" );
        $this->s->conf( "9600 -parenb cs7 -cstopb clocal -crtscts -ixon -ixoff -echo raw" );
        $this->s->deviceOpen();

        $this->broadcast(array('type'=>'hello'));
    }

    function event($pkt) {
        if ( isset($pkt['type']) && $pkt['type'] == 'state' && $pkt['from'] == 'beckhoff' ) {
            $this->beckhoff = $pkt['data']['Interface'];

            $diff = array_diff_assoc($this->beckhoff,$this->beckhoffOld);
            $this->beckhoffOld = $this->beckhoff;
            if ( isset($diff['onState']) && $diff['onState'] == 0 ) {
                $this->show(intval(file_get_contents("http://kanan.vassaro.net/counter")));
            }
        }
    }

    function show($text) {
        echo $text."\n";
        $this->s->sendMessage("<01@@@".str_pad($text,4," ",STR_PAD_LEFT).">");
    }
}

$t = new display();
$t->start('display');

?>
