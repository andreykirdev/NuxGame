<?php

namespace Services;

use DateTime;
use Repositories\UniqueLinkRepository;

class UniqueLinkFactory {
    private $uniqueLinkRepository;

    public function __construct() {
        $this->uniqueLinkRepository = new UniqueLinkRepository();
    }

    public function createLink($userId) {
        $link = bin2hex(random_bytes(16));
        $expiresAt = (new DateTime())->modify('+7 days')->format('Y-m-d H:i:s');
        $this->uniqueLinkRepository->createUniqueLink($userId, $link, $expiresAt);

        return $link;
    }
}
