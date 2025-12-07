<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Grid;

	class Laboratories extends Helper
	{
		private Grid $grid;
		private array $beams = [];

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$this->grid = new Grid($raw);
			$this->beams[array_find_key($this->grid->row(0), fn($value) => $value === "S")] = 1;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$this->output($this->grid);

			foreach ($this->grid->dimensions->y as $y)
			{
				$this->output("Processing row " . $y);

				foreach ($this->beams as $x => $count)
				{
					$this->output($x . " " . $count . " " . $this->grid->get($x, $y));

					if ($this->grid->get($x, $y) === "^")
					{
						$this->output("Split beam " . $x . " (" . $count . ")");
						$result->part1++;

						unset($this->beams[$x]);
						$this->beams[$x-1] = ($this->beams[$x-1] ?? 0) + $count;
						$this->beams[$x+1] = ($this->beams[$x+1] ?? 0) + $count;
					}
				}
			}

			$result->part2 = array_sum($this->beams);

			return $result;
		}
	}
?>
