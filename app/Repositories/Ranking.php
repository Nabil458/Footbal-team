<?php 
namespace App\Repositories;
class Ranking 
{   function points(int $wonMatchCount, int $drawMatchCount): int
    {
        return 3*$wonMatchCount + $drawMatchCount;
    }
    function goalDifference(int $goalFor, int $goalAgainst): int 
    {
       return $goalFor - $goalAgainst;
    }
    function teamWinsMatch(int $teamId, array $match): bool
    { 
      return ($teamId == $match['team0'] && $match['score0'] > $match['score1'])
          || ($teamId == $match['team1'] && $match['score0'] < $match['score1']);
    }

    function teamLosesMatch(int $teamId, array $match): bool
    {
      return ($teamId == $match['team0'] && $match['score0'] < $match['score1'])
      || ($teamId == $match['team1'] && $match['score0'] > $match['score1']);
    }

    function teamMakesADraw(int $teamId, array $match): bool
    {
      return ($teamId == $match['team0'] && $match['score0'] == $match['score1'])
      || ($teamId == $match['team1'] && $match['score0'] == $match['score1']);
    }
    function goalForCountDuringAMatch(int $teamId, array $match): int
    {
        return $teamId == $match['team0'] ?  $match['score0']:($teamId == $match['team1'] ?  $match['score1']:0 );

    }
    function goalAgainstCountDuringAMatch(int $teamId, array $match): int
    {
        return $teamId == $match['team0'] ?  $match['score1']:($teamId == $match['team1'] ?  $match['score0']:0 );
    }
    function goalForCount(int $teamId, array $matches): int
    {  $sum=0;
      foreach($matches as $value){
        $sum+=$this->goalForCountDuringAMatch($teamId, $value);
      }
         
    return $sum;
    }

    function goalAgainstCount(int $teamId, array $matches): int
    {
      $sum=0;
      foreach($matches as $value){
        $sum+=$this->goalAgainstCountDuringAMatch($teamId, $value);
      }
         
    return $sum;
    }
    function wonMatchCount(int $teamId, array $matches): int
     { $count=0;
       foreach($matches as $value){
       if($this->teamWinsMatch($teamId, $value)==true )
          $count++;
     }
    return $count;
     }

    function lostMatchCount(int $teamId, array $matches): int
    {
      $count=0;
       foreach($matches as $value){
       if($this->teamLosesMatch($teamId, $value)==true )
          $count++;
     }
    return $count;
    }

    function drawMatchCount(int $teamId, array $matches): int
    {
      $count=0;
      foreach($matches as $value){
      if($this->teamMakesADraw($teamId, $value)==true )
         $count++;
    }
   return $count;
    }
    function rankingRow(int $teamId, array $matches): array
    {
    
        return [
        'team_id'            => $teamId,
        'match_played_count' => $this-> wonMatchCount($teamId, $matches)+$this->drawMatchCount($teamId, $matches)+$this->lostMatchCount($teamId, $matches),
        'won_match_count'    => $this-> wonMatchCount($teamId, $matches),
        'lost_match_count'   => $this->lostMatchCount($teamId, $matches),
        'draw_match_count'   => $this->drawMatchCount($teamId, $matches),
        'goal_for_count'     => $this -> goalForCount($teamId, $matches),
        'goal_against_count' => $this -> goalAgainstCount($teamId, $matches),
        'goal_difference'    =>  $this -> goalForCount($teamId, $matches) - $this -> goalAgainstCount($teamId, $matches),
        'points'             => $this -> points($this-> wonMatchCount($teamId, $matches), $this->drawMatchCount($teamId, $matches))
      ];
    }
    function unsortedRanking(array $teams, array $matches): array
{

    $result = [];
    foreach($teams as $row)
    {
        $result[] = $this->rankingRow($row['id'],$matches);
    }
    
    return $result;
}
    static function compareRankingRow(array $row1, array $row2): int
{
  /*un nombre strictement négatif si et seulement si $row1 doit être avant $row2 dans le classement ;*/
  if($row1['points']>$row2['points']) return -1;
  /*un nombre strictement positif si et seulement si $row1 doit être après $row2 dans le classement ;*/
  else if($row1['points']<$row2['points']) return 1;
  /*zéro si les deux lignes ne peuvent pas être départagées en fonction des critères évoqués au-dessus.*/
  else if($row1['goal_difference']>$row2['goal_difference']) return -1;
  else if($row1['goal_difference']<$row2['goal_difference']) return 1;
  else if($row1['goal_for_count']>$row2['goal_for_count']) return -1;
  else if($row1['goal_for_count']<$row2['goal_for_count']) return 1;
  else 
  return 0;
}

function sortedRanking(array $teams, array $matches): array
{
  
  $result = $this->unsortedRanking($teams, $matches);
  usort($result, ['App\Repositories\Ranking', 'compareRankingRow']);
  for ($rank = 1; $rank <= count($teams); $rank++) {
    $result[$rank - 1]['rank'] = $rank;
  }
 
  
  return $result;
}

}