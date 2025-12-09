# Advent of Code 2025

https://adventofcode.com/2025/

| Day | Name                |        Part 1 |          Part 2 | Time       |      Memory |
|----:|:--------------------|--------------:|----------------:|:-----------|------------:|
|   1 | Secret Entrance     |          1102 |            6172 | 42.3287ms  |  1.8947 MiB |
|   2 | Gift Shop           |   40214376723 |     50793864718 | 207.2846ms |  1.2513 MiB |
|   3 | Lobby               |         17443 | 172167155440541 | 1.9539ms   |  2.4475 MiB |
|   4 | Printing Department |          1395 |            8451 | 162.48ms   |  2.8751 MiB |
|   5 | Cafeteria           |           821 | 344771884978261 | 1.6384ms   |  1.2505 MiB |
|   6 | Trash Compactor     | 4693419406682 |   9029931401920 | 9.3769ms   |  3.4289 MiB |
|   7 | Laboratories        |          1553 |  15811946526915 | 5.0267ms   |  2.9952 MiB |
|   8 | Playground          |        163548 |       772452514 | 420.0515ms | 52.2304 MiB |
|   9 | Movie Theater       |    4737096935 |      1644094530 | 2.953s     |  1.7637 MiB |

## Notes

##### Day 01: Secret Entrance

Got to use the CircularLinkedList from the Cruxoft AoC utilities package again! Thought part 2 might require an alternative but was an instant result.

##### Day 02: Gift Shop

Lovely bit of regex. It was nice to use backreference as I've never really needed to use it before.

##### Day 03: Lobby

Implemented a sliding window approach, which I then tweaked for part 2 to have a dynamic window size. Saw that a monotonic stack was a good approach so also implemented that, but it runs slower than the sliding window. Turns out I implemented a lot of efficiency shortcuts.

##### Day 04: Printing Department

Simple grid traversal and a cheeky little do-while loop.

##### Day 05: Cafeteria

Turns out I accidentally created a Discrete Interval Encoding Tree, so I pulled it out into my aoc package incase I need it again!

##### Day 06: Trash Compactor

Well, regex failed me on the parsing today, although it did simplify things a bit. Part 2 was a fun challenge to get right, I loaded the raw row data into a grid and then rotated it 90 degrees to get the correct orientation to parse line by line.

##### Day 07: Laboratories

Merging a beam part way along a previous beam was tricky with my first attempt, so started again and processed line by line rather than per beam. Kept track of beam strength from the start, so part 2 was a simple array sum.

##### Day 08: Playground

Added a rudimentary DSU implementation to the AoC package. Even without optimisations, it's pretty fast due to PHP's arrays. Also added N-Dimensional Vector and Position classes to the package. Couldn't find a way to reduce the memory usage today, though. It's a lot of possible connections!

##### Day 09: Movie Theater

Slow runner today a I used a brute-force approach to part 2, added some aggressive caching and got the time down from 6 to 3 seconds. Might have to revisit this one later to see if I can do better.
