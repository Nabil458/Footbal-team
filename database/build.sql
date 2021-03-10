DROP TABLE IF EXISTS ranking;
DROP TABLE IF EXISTS matches;
DROP TABLE IF EXISTS teams;
DROP TABLE IF EXISTS users;

CREATE TABLE teams(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(50) NOT NULL
);


  CREATE TABLE matches(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  team0 int NOT NULL,
  team1 int NOT NULL,
  score0 int NOT NULL,
  score1 int NOT NULL,
  date DATETIME NOT NULL,
  FOREIGN KEY(team0) REFERENCES teams(id),
  FOREIGN KEY(team1) REFERENCES teams(id),
  UNIQUE (team0, team1),
  check(team0!=team1)
);  
    

CREATE TABLE ranking(
  rank INTEGER PRIMARY KEY NOT NULL,
  team_id int  NOT NULL,
  goal_for_count int NOT NULL,
  goal_against_count int NOT NULL,
  goal_difference int NOT NULL,
  match_played_count int NOT NULL,
  won_match_count int NOT NULL,
  lost_match_count int NOT NULL,
  draw_match_count int NOT NULL,
  points int NOT NULL,
  FOREIGN KEY (team_id) REFERENCES teams(id),
  UNIQUE (rank)
);

CREATE TABLE users(
   id INTEGER PRIMARY KEY AUTOINCREMENT,
   email VARCHAR(128) NOT NULL,
   password_hash VARCHAR(128) NOT NULL,
    UNIQUE (email)
);