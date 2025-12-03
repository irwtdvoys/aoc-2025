<?php
    namespace App\Lobby;

	enum Strategy: string
	{
		case SlidingWindow = "slidingWindow";
		case MonotonicStack = "monotonicStack";
	}
?>
