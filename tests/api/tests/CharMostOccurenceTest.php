<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\CharOccurence;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class CharMostOccurenceTest extends ApiTestCase
{
  use RefreshDatabaseTrait;

  public function testGetCollection(): void
  {
    $response = static::createClient()->request('GET', '/api/history');

    $this->assertResponseIsSuccessful();
    $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    $this->assertJsonContains([
      '@context' => '/api/contexts/CharOccurence',
      '@id' => '/api/history',
      '@type' => 'hydra:Collection',
      'hydra:totalItems' => 100,
      'hydra:view' => [
        '@id' => '/history?page=1',
        '@type' => 'hydra:PartialCollectionView',
        'hydra:first' => '/history?page=1',
        'hydra:last' => '/history?page=4',
        'hydra:next' => '/history?page=2',
      ],
    ]);
    $this->assertCount(30, $response->toArray()['hydra:member']);
    $this->assertMatchesResourceCollectionJsonSchema(CharOccurence::class);
  }

  public function testFindMostOccurence(): void
  {
    $response = static::createClient()->request('GET', '/api/find_most_occurence/aaaab', ['json' => [
      'top_char' => 'a',
      'occurence_number' => 4
    ]]);

    $this->assertResponseStatusCodeSame(201);
    $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    $this->assertJsonContains([
      '@context' => '/api/contexts/CharOccurence',
      '@type' => 'CharOccurence',
      'top_char' => 'a',
      'occurence_number' => 4
    ]);
    $this->assertMatchesRegularExpression('~^/find_most_occurence/\d+$~', $response->toArray()['@id']);
    $this->assertMatchesResourceItemJsonSchema(CharOccurence::class);
  }
}
