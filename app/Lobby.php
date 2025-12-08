<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use AoC\Utils\Range;
	use App\Lobby\Bank;

	class Lobby extends Helper
	{
		/** @var Bank[] */
		private array $banks;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$this->banks = array_map(
				fn($line) => new Bank(str_split($line)),
				explode(PHP_EOL, $raw)
			);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->banks as $bank)
			{
				$joltage = $bank->joltage();
				$result->part1 += $joltage;

				$emergency = $bank->joltage(12);
				$result->part2 += $emergency;

				$this->output($bank . " " . $joltage . " " . $emergency);
			}

			return $result;
		}
	}
?>
