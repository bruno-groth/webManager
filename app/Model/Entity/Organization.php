<?php

namespace App\Model\Entity;

class Organization
{

  public function __construct(
    public int $id = 1,
    public string $name = 'WebManager',
    public string $site = 'https://webmanager.com.br',
    public string $description =  'Lorem',
  ) {
  }
}
