<?php

namespace Bruno962\BuscadorCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
  private $client;
  private $crawler;
  
  public function __construct(ClientInterface $client, Crawler $crawler)
  {
    $this->client = $client;
    $this->crawler = $crawler;
  }
  
  public function buscar(string $url) : array {
    $response = $this->client->request("GET", $url);
    
    $html = $response->getBody();
    
    $this->crawler->addHtmlContent($html);
    $cursosEls = $this->crawler->filter("span.card-curso__nome");
    $cursos = [];
    foreach($cursosEls as $el) {
      $cursos[] = $el->textContent;
    }

    return $cursos;
  }
}