<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Grid;
	use App\TrashCompactor\Operator;
	use App\TrashCompactor\Problem;

	class TrashCompactor extends Helper
	{
		/** @var Problem[] */
		private array $problems1 = [];
		/** @var Problem[] */
		private array $problems2 = [];

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$tmp = array_map(
				function ($line)
				{
					preg_match_all('/\S+/', $line, $matches);
					return $matches[0];
				},
				explode(PHP_EOL, $raw)
			);

			for ($index = 0; $index < count($tmp[0]); $index++)
			{
				$one = new Problem();
				$two = new Problem();

				foreach ($tmp as $next)
				{
					if (in_array($next[$index], Operator::values()))
					{
						$one->operator = Operator::tryFrom($next[$index]);
						$two->operator = $one->operator;
					}
					else
					{
						$one->values[] = $next[$index];
					}
				}

				$this->problems1[] = $one;
				$this->problems2[] = $two;
			}

			$grid = new Grid(substr($raw, 0, strrpos($raw, PHP_EOL)));
			$grid->rotate();

			$index = count($this->problems2) - 1;

			foreach ($grid->dimensions->y as $y)
			{
				$value = trim(implode("", $grid->row($y)));

				if ($value === "")
				{
					$index--;
				}
				else
				{
					$this->problems2[$index]->values[] = (int)$value;
				}
			}
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$this->output("--- Part 1 ---");

			foreach ($this->problems1 as $problem)
			{
				$value = $problem->calculate();

				$this->output($problem . " = " . $value);
				$result->part1 += $value;
			}

			$this->output(PHP_EOL . "--- Part 2 ---");

			foreach ($this->problems2 as $problem)
			{
				$value = $problem->calculate();

				$this->output($problem . " = " . $value);
				$result->part2 += $value;
			}

			return $result;
		}
	}
?>
