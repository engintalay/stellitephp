<?php


namespace Stellite;


class Coins{
	const COIN_UNIT=100;
	
	static public function toCoinUnit($amount){
		return $amount / self::COIN_UNIT;
	}
}