<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class Reactor extends Helper
	{
		private array $devices;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			preg_match_all('/[\w]{3,}/', $raw, $matches);

			$keys = array_unique($matches[0]);
			$this->devices = array_fill_keys($keys, []);

			foreach (explode(PHP_EOL, $raw) as $next)
			{
				$this->devices[substr($next, 0, strpos($next, ":"))] = array_values(array_filter(explode(" ", substr($next, strpos($next, ":") + 1))));
			}
		}

		protected function traverse(string $from, string $to): int
		{
			if ($from === $to)
			{
				return 1;
			}

			return array_reduce(
				$this->devices[$from],
				fn ($carry, $item) => ($carry ?? 0) + $this->memoize("traverse", [$item, $to])
			) ?? 0;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$result->part1 = $this->traverse("you", "out");

			$this->clearCache();

			$paths = [
				["svr", "dac", "fft", "out"],
				["svr", "fft", "dac", "out"]
			];

			foreach ($paths as $path)
			{
				$total = 1;

				for ($index = 0; $index < count($path) - 1; $index++)
				{
					$from = $path[$index];
					$to = $path[$index + 1];

					$count = $this->traverse($from, $to);
					$this->output($from . "->" . $to . " count = " . $count);

					if ($count === 0)
					{
						break;
					}

					$total *= $count;

					if ($to === "out")
					{
						$result->part2 += $total;
					}
				}
			}

			return $result;
		}
	}
?>
