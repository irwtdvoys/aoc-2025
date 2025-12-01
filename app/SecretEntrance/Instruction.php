<?php
    namespace App\SecretEntrance;

    class Instruction implements \Stringable
    {
        public Direction $direction;
        public int $quantity;

        public function __construct(string $instruction)
        {
            $this->direction = Direction::tryFrom($instruction[0]);
            $this->quantity = (int)substr($instruction, 1);
        }

        public function __toString(): string
        {
            return $this->direction->value . $this->quantity;
        }
    }
?>
