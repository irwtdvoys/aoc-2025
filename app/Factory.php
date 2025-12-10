<?php
	declare(strict_types=1);

	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Factory\Machine;

	class Factory extends Helper
	{
		/** @var Machine[] */
		private array $machines;

		public function __construct(int $day, bool $verbose = false, ?string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$this->machines = array_map(
				fn ($line) => new Machine($line),
				explode(PHP_EOL, $raw)
			);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			return $result;
		}
	}
?>
