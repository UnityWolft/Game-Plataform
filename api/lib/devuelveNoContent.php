<?php

function devuelveNoContent(): void
{
  http_response_code(204);
  exit();
}