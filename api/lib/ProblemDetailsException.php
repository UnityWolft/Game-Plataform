<?php
require_once __DIR__ . "/INTERNAL_SERVER_ERROR.php";

class ProblemDetailsException extends Exception
{
  public array $problemDetails;

  public function __construct(array $problemDetails)
  {
    $mensaje =
      isset($problemDetails["detail"]) && is_string($problemDetails["detail"])
        ? $problemDetails["detail"]
        : (
          isset($problemDetails["title"]) && is_string($problemDetails["title"])
            ? $problemDetails["title"]
            : "Error"
        );

    $codigo =
      isset($problemDetails["status"]) && is_int($problemDetails["status"])
        ? $problemDetails["status"]
        : INTERNAL_SERVER_ERROR;

    parent::__construct($mensaje, $codigo);
    $this->problemDetails = $problemDetails;
  }
}
