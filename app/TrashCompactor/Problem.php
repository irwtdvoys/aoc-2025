<?php
	namespace App\TrashCompactor;

	use Stringable;

	class Problem implements Stringable
	{
		public array $values = [];
		public Operator $operator;

		public function __toString(): string
		{
			return implode(" " . $this->operator->value . " ", $this->values);
		}

		public function calculate(): int
		{
			return match ($this->operator)
			{
				Operator::Add => array_sum($this->values),
				Operator::Multiply => array_product($this->values)
			};
		}
	}
?>
