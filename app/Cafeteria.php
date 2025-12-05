<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Range;

	class Diet implements \Stringable
	{
		/** @var Range[] */
		public array $data = [];

		public function add(Range $range): void
		{
			for ($index = 0; $index < count($this->data); $index++)
			{
				// if intersects
				if ($range->intersects($this->data[$index]))
				{
					// merge,
					$range->merge($this->data[$index]);
					// remove existing,
					array_splice($this->data, $index, 1);
					$index--;
				}
				else
				{
					// maybe able to add a shortcircuit here
				}
			}

			$this->data[] = $range;
		}

		public function count(): int
		{
			return array_reduce(
				$this->data,
				fn($carry, $range) => $carry + count($range),
			);
		}


		public function __toString(): string
		{
			return implode(" : ", array_map(fn($range) => (string)$range, $this->data));
		}
	}

	class Cafeteria extends Helper
	{
		/** @var Range[] */
		private array $freshRanges;

		/** @var int[] */
		private array $ingredients;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			[$freshRanges, $ingredients] = explode(PHP_EOL . PHP_EOL, $raw);

			$this->freshRanges = array_map(
				fn($line) => new Range(...array_map("intval", explode("-", $line))),
				explode(PHP_EOL, $freshRanges)
			);

			$this->ingredients = array_map("intval", explode(PHP_EOL, $ingredients));
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			// sort
			$ranges = $this->freshRanges;
			sort($ranges);

			// reduce
			for ($index = 0; $index < count($ranges) - 1; $index++)
			{
				$current = $ranges[$index];
				$next = $ranges[$index + 1];

				$this->output("Checking ranges: " . $current . " and " . $next);

				if ($current->intersects($next))
				{
					$this->output("Intersecting");
					$ranges[$index] = $current->merge($next);
					array_splice($ranges, $index + 1, 1);
					$index--;
				}
			}

			foreach ($this->ingredients as $ingredient)
			{
				foreach ($ranges as $range)
				{
					if ($range->contains($ingredient))
					{
						$result->part1 += 1;
						break;
					}
				}
			}

			foreach ($ranges as $range)
			{
				$result->part2 += count($range);
			}

			return $result;
		}
	}
?>
