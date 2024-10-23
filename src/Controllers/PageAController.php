<?php

namespace Controllers;

use DateTime;
use Repositories\HistoryRepository;
use Repositories\UniqueLinkRepository;
use Services\LuckyService;
use Services\UniqueLinkFactory;

class PageAController {
    private $linkRepository;
    private $historyRepository;
    private $luckyService;
    private $linkFactory;

    public function __construct() {
        $this->linkRepository = new UniqueLinkRepository();
        $this->historyRepository = new HistoryRepository();
        $this->linkFactory = new UniqueLinkFactory();
        $this->luckyService = new LuckyService();
    }

    public function handlePageA($link) {
        $validLink = $this->linkRepository->findValidLink($link);
        if ($validLink) {
            require_once __DIR__ . '/../Views/pageA.php';
        } else {
            echo "Link expired or invalid.";
        }
    }

    public function generateNewLink() {
        $link = isset($_POST['linkId']) ? $_POST['linkId'] : null;
        $validLink = $this->linkRepository->findValidLink($link);

        if ($validLink) {
            $newLinkId = $this->linkFactory->createLink($validLink['user_id']);
            $this->linkRepository->deleteLink($link);
            $newLink = 'http://localhost:8000/link/' . $newLinkId;
            header('Content-Type: application/json');
            echo json_encode(['link' => $newLink]);
        } else {
            echo "Link expired or invalid.";
        }
    }

    public function deactivateLink() {
        $link = isset($_POST['linkId']) ? $_POST['linkId'] : null;
        $validLink = $this->linkRepository->findValidLink($link);
        if ($validLink) {
            $this->linkRepository->deleteLink($link);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'deactivated']);
        } else {
            echo "Link expired or invalid.";
        }
    }

    public function imFeelingLucky() {
        $link = isset($_POST['linkId']) ? $_POST['linkId'] : null;
        $validLink = $this->linkRepository->findValidLink($link);
        if ($validLink) {
            $luckyResult = $this->luckyService->calculateLuckyResult();
            $createdAt = (new DateTime())->format('Y-m-d H:i:s');
            $this->historyRepository->addLuckyResult($validLink['user_id'], $luckyResult, $createdAt);
            header('Content-Type: application/json');
            echo json_encode($luckyResult);
        } else {
            echo "Link expired or invalid.";
        }
    }

    public function getHistory() {
        $link = isset($_POST['linkId']) ? $_POST['linkId'] : null;
        $validLink = $this->linkRepository->findValidLink($link);
        if ($validLink) {
            $history = $this->historyRepository->getHistory($validLink['user_id']);
            header('Content-Type: application/json');
            echo json_encode($history);
        } else {
            echo "Link expired or invalid.";
        }
    }
}
