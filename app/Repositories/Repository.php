<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Repositories\Data;
use App\Repositories\Ranking;

class Repository
{
    function createDatabase(): void 
    {
        DB::unprepared(file_get_contents('database/build.sql'));
    }
    function insertTeam(array $team): int
   {
    return DB::table('teams')->insertGetId($team);
   }
   function insertMatch(array $match): int
   {
    return DB::table('matches')->insertGetId($match);
   }
   function teams(): array
   {
    return DB::table('teams')->orderBy('id')->get()->toArray();
   }

   function matches(): array
   {
    return DB::table('matches')->orderBy('id')->get()->toArray();
   }
   function fillDatabase(): void 
   {   
    $data=new Data();

    $teams = $data->teams();
    
    foreach($teams as $team){
        $this->insertTeam($team);}

    $matches = $data->matches();

    foreach($matches as $match) {
        $this->insertMatch($match);}
   }
   function team($teamId) : array
   {
        $teams=DB::table('teams')->where('id', $teamId)->get()->toArray();
       if(count($teams)==0){
        throw new Exception('Équipe inconnue');
      }
       return $teams[0];
   }
   function match(int $matchId): array
    {
        $matche= DB::table('matches')->where('id',$matchId)->get()->toArray();
        if(count($matche)==0){
            throw new Exception('Match inconnue');
        }
        return $matche[0];
    }
    function updateRanking(): void
   {
      //vider le contenu de la table ranking ;
      DB::table('ranking')->delete();
      //récupérer les matchs et les équipes avec les méthodes teams et matches de la classe Repository ;

      $matches = $this->matches();
      $teams = $this->teams();

      //calculer les lignes du classement avec la méthode sortedRanking de la classe Ranking ;
      
      $objRanking = new Ranking();
      $tabRanking = $objRanking -> sortedRanking($teams, $matches); 

      //insérer les lignes du classement dans la table ranking. 
      DB::table('ranking')->insert($tabRanking);
        
   }
   function sortedRanking(): array                    
   {
       
    return $rows = DB::table('ranking')->join('teams', 'ranking.team_id', '=', 'teams.id')->orderBy("rank")->get(['ranking.*', 'teams.name'])->toArray();
   }
   
   function teamMatches($teamId) : array
   {

       return $matches = DB::table('matches')->join('teams as teams0', 'matches.team0', '=', 'teams0.id')-> join ('teams as teams1', 'matches.team1', '=', 'teams1.id')
                                      ->where('matches.team0', $teamId)
                                      ->orWhere('matches.team1', $teamId)
                                      ->orderBy('date')
                                      ->get(['matches.*', 'teams0.name as name0', 'teams1.name as name1'])
                                      ->toArray();

   }

   function rankingRow(int $teamId):array 
    {
        $row = DB::table('ranking')->join('teams', 'ranking.team_id','=', 'teams.id')
                                    ->where('team_id',$teamId)
                                    ->orderBy('rank')
                                    ->get(['ranking.*', 'teams.name'])
                                    ->toArray();
        if(count($row)==0)
        {
            throw new Exception('Équipe inconnue');
        }
        return $row[0];
    }

    function addUser(string $email, string $password): int
    {
      $passwordHash= Hash::make($password);

      return DB::table('users')->insertGetId(['email'=>$email,'password_hash'=>$passwordHash]);

    }

    function getUser(string $email, string $password): array
    {
    // TODO
    $users=DB::table('users')->where('email',$email)->get()->toArray();                     
    if(count($users)==0 ){
        throw new Exception('Utilisateur inconnu');
    }
    $user=$users[0];
    $ok = Hash::check($password, $user['password_hash']);
    if(!$ok)
    {
        throw new Exception('Utilisateur inconnu');
    }
        return ['id' => $user['id'], 'email'=> $user['email']];
    }

    function changePassword(string $email, string $oldPassword, string $newPassword): void 
    {
    // TODO
    $this->getUser($email,$oldPassword);
    $passwordHashNew= Hash::make($newPassword);
    DB::table('users')->where('email',$email)->update(['password_hash'=>$passwordHashNew]); 
                
    }

}


