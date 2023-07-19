<?php

// @phpstan-ignore-next-line
test('globals')->expect(['dd', 'dump'])->not->toBeUsed();
