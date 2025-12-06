<?php
	namespace App\TrashCompactor;

	enum Operator: string
	{
		case Add = "+";
		case Multiply = "*";

		public static function values(): array
		{
			return array_map(fn ($case) => $case->value, self::cases());
		}
	}
?>
