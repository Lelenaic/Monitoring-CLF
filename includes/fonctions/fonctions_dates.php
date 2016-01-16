<?php

function dateUS2FR($dateus){
	$datefr=explode('-',$dateus);
	return $datefr[2].'/'.$datefr[1].'/'.$datefr[0];
}

function dateFR2US($datefr){
	$dateus=explode('/',$datefr);
	return $dateus[2].'-'.$dateus[1].'-'.$dateus[0];
}
