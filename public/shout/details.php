<?php

require_once 'vc_shoutcast.class.php';
require_once 'vc_shoutcast_json_relay.class.php';

$vc_shoutcast = new vc_shoutcast('50.116.107.13', 8050, 'Dejavu2016!!!');

$vc_shoutcast_json_relay = new vc_shoutcast_json_relay($vc_shoutcast, 60);

$vc_shoutcast_json_relay->run('both');