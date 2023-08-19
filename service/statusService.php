<?php

require_once __DIR__.'/../repo/statusRepo.php';

class StatusService {
    private $statusRepository;

    public function __construct(StatusRepository $statusRepository) {
        $this->statusRepository = $statusRepository;
    }

    public function getAllStatuses() {
        return $this->statusRepository->getAllStatuses();
    }

    public function getStatusById($id) {
        return $this->statusRepository->getStatusById($id);
    }
}
?>
