<?php


namespace App\Controller\Api;


use App\Entity\CharOccurence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class FindMostOccurenceAction
{
  /**
   * @return CharOccurence
   */
  public function __invoke(Request $request, EntityManagerInterface $em): CharOccurence
  {
    $count_occurences = array_count_values(str_split($request->get('id')));
    asort($count_occurences);
    $data = new CharOccurence;
    $data->setTopChar(array_key_last($count_occurences));
    $data->setOccurenceNumber(end($count_occurences));
    $em->persist($data);
    $em->flush();
    return $data;
  }
}
