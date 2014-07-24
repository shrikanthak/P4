<?php

class Position extends Eloquent
{
	protected $table='positions';
	public function employee()
	{
		return $this->belongsTo('Employee','position_id');

	}

		
}