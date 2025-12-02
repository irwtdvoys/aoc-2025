<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Range;

	class GiftShop extends Helper
	{
		/** @var Range[] */
		private array $ranges;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$this->ranges = array_map(
				fn($line) => new Range(...array_map("intval", explode("-", $line))),
				explode(",", $raw)
			);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->ranges as $range)
			{
				for ($value = $range->min; $value <= $range->max; $value++)
				{
					if (preg_match('/^(\d+)\1$/', (string)$value))
					{
						$result->part1 += $value;
					}

					if (preg_match('/^(\d+)\1+$/', (string)$value))
					{
						$result->part2 += $value;
					}
				}
			}

			return $result;
		}
	}
?>
