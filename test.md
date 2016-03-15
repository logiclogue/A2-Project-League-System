## FixturesGet

*Model that returns fixture list for a tournament or user.
Lists all matches that are still to be played.*

Line: 10 in file /home/jordan/workspace/sites/computing-project/models/FixturesGet.php

Extends: Model

### Properties:

#### query

*SQL query string that fetches the matches to be played.*

Line: 36

Access: private

Type: 

### Methods:

#### attachRatings

*Method that gets the user ratings and puts them in every fixture including the expected result for player 1.*

Line: 85

Access: private

#### main

*Main method that execute @property query and binds input data.*

Line: 100

Access: protected

## Login

*Login model for logging into the system.*

Line: 9 in file /home/jordan/workspace/sites/computing-project/models/Login.php

Extends: Model

### Properties:

#### query

*SQL query string for getting the details of the user.
Finds user by email.*

Line: 21

Access: 

Type: String

#### stmt

*Connects to the database.
Binds query and parameters.*

Line: 34

Access: private

Type: Object

#### user

*Stores result from database.
User data.*

Line: 43

Access: private

Type: Object

### Methods:

#### storeSession

*Stores the user details in the current user session.*

Line: 54

Access: private

#### verify

*Checks to see if password entered matches the password associated to the email entered.*

Line: 68

Access: private

#### main

*Defines @property result.
Binds parameters to @property query.*

Line: 88

Access: protected

## Logout

*Logout model called when the user logs out.*

Line: 8 in file /home/jordan/workspace/sites/computing-project/models/Logout.php

Extends: Model

### Properties:

### Methods:

#### main

*Method that destroys the session.*

Line: 18

Access: protected

## Register

*Register model used to register onto the system.*

Line: 10 in file /home/jordan/workspace/sites/computing-project/models/Register.php

Extends: Model

### Properties:

#### query

*SQL query string for inserting user data into the database.*

Line: 26

Access: private

Type: String

#### query_email

*SQL query string for checking whether email is already in use.*

Line: 38

Access: private

Type: String

#### result

*For executing the query string.*

Line: 51

Access: private

Type: Object

#### hash

*Hash of the password entered.*

Line: 59

Access: private

Type: String

### Methods:

#### bindParams

*Used to bind the parameters to @property query.
Data inputted by user is bound.*

Line: 69

Access: private

#### checkEmail

*Method that will check whether email is already in use.*

Line: 83

Access: 

#### validate

*Validate email, first name, last name, and password.*

Line: 101

Access: private

#### main

*Prepares query.
Hashes password.
Executes query.*

Line: 143

Access: public

## ResultEnter

*Model used for entering a result.*

Line: 12 in file /home/jordan/workspace/sites/computing-project/models/ResultEnter.php

Extends: Tournament

### Properties:

#### query

*SQL query string for deleting a result.
Also deletes the users' association with the result.*

Line: 21

Access: private

Type: String

#### result_data

*Data associated with the result that the user wants to delete.*

Line: 37

Access: private

Type: Array

#### query_info

*SQL query string for inserting result info.*

Line: 27

Access: private

Type: String

#### query_score

*SQL query string for inserting result score.*

Line: 38

Access: private

Type: String

#### id_of_result

*Id of the result that is being entered.*

Line: 50

Access: private

Type: Integer

### Methods:

#### ResultDelete

*Model that is called to delete a particular result.*

Line: 10

Access: 

#### delete

*Method that actually deletes the result.*

Line: 47

Access: private

#### validate

*Validates whether the user can delete the result.*

Line: 64

Access: private

#### getResult

*Method that gets the result data from @class ResultGet.*

Line: 94

Access: private

#### main

*Main method.*

Line: 108

Access: protected

#### validScore

*Method that checks whether the entered score is valid.*

Line: 60

Access: private

#### validate

*Main validation method.*

Line: 80

Access: private

#### insertScore

*Method for inserting the score of a player.*

Line: 133

Access: private

**Parameters**

* user_id: Integer (*Id of the user whose score to input.*)

* score: Integer (*Score that the user achieved.*)

* new_rating: Integer (*New rating of the user.*)

* rating_change: Integer (*Rating change.*)

#### insertInfo

*Method used to insert general result info.*

Line: 155

Access: private

#### general

*Calls all general methods.*

Line: 177

Access: private

#### main

*Checks login.*

Line: 197

Access: protected

## ResultGet

*Model for retrieving information on a particular result.*

Line: 7 in file /home/jordan/workspace/sites/computing-project/models/ResultGet.php

Extends: Model

### Properties:

#### query

*SQL query string for getting result information.*

Line: 37

Access: private

Type: String

### Methods:

#### main

*Main method that executes @property query.*

Line: 92

Access: protected

## Status

*Model for getting the status of the current user.*

Line: 9 in file /home/jordan/workspace/sites/computing-project/models/Status.php

Extends: Model

### Properties:

### Methods:

#### logged_in

*Method that stores user data in @property return_data.*

Line: 26

Access: private

#### main

*Method that checks if the user is logged in.
Then sets @property return_data.*

Line: 36

Access: protected

## TournamentCreate

*Model for users to create tournaments.*

Line: 9 in file /home/jordan/workspace/sites/computing-project/models/TournamentCreate.php

Extends: Tournament

### Properties:

#### query

*SQL query string for creating a tournament.*

Line: 23

Access: private

Type: String

#### query_add_league_manager

*Query for making the creator of the league a league manager.*

Line: 34

Access: private

Type: String

#### stmt

*Statement object for executing @property query.*

Line: 46

Access: private

Type: Object

#### tournament_id

*Id of the tournament that has just been created.*

Line: 55

Access: private

Type: 

### Methods:

#### returnTournamentData

*Method which returns the tournament data.
Data collected from @class TournamentGet.*

Line: 64

Access: private

#### addLeagueManager

*Method for attaching the current user as the league manager.*

Line: 75

Access: private

#### create

*Main function for creating database object, binding params, and executing query.*

Line: 97

Access: private

#### main

*Main function for checking whether user is logged in.*

Line: 122

Access: protected

## TournamentDelete

*Class that deletes a tournament.*

Line: 8 in file /home/jordan/workspace/sites/computing-project/models/TournamentDelete.php

Extends: Tournament

### Properties:

#### query_league

*SQL query string for deleting the league.
Also deletes all associations with the league.
This includes results.*

Line: 19

Access: private

Type: String

### Methods:

#### delete

*Method that uses @property query_league to delete the league.*

Line: 40

Access: private

#### verify

*Checks whether the user can delete the league.*

Line: 57

Access: private

#### main

*Result of @method verify determines whether it calls @method delete.*

Line: 79

Access: protected

## TournamentGet

*Model that fetches tournament data based on id.*

Line: 8 in file /home/jordan/workspace/sites/computing-project/models/TournamentGet.php

Extends: Tournament

### Properties:

#### query

*SQL query string for fetching tournament data.*

Line: 32

Access: private

Type: String

#### query_players

*SQL query string for fetching the players in the tournament.*

Line: 44

Access: private

Type: String

#### query_leauge_managers

*SQL query string for fetching the league managers of the tournament.*

Line: 58

Access: private

Type: String

### Methods:

#### getPlayers

*Method that queries players in the tournament.*

Line: 74

Access: private

#### getLeagueManagers

*Method that queries league managers in the tournament.*

Line: 93

Access: private

#### getTournamentData

*Method that gets the data about the tournament.*

Line: 112

Access: private

#### main

*Method that fetches the database info.*

Line: 135

Access: protected

## TournamentLeagueTable

*Class for generating a league table.*

Line: 9 in file /home/jordan/workspace/sites/computing-project/models/TournamentLeagueTable.php

Extends: Model

### Properties:

#### table

*Array that stores the table data.*

Line: 29

Access: private

Type: Array

#### query

*SQL query string for getting the players in the leauge.*

Line: 38

Access: private

Type: String

### Methods:

#### populateTable

*If that player is unpopulated, then populate the table.*

Line: 63

Access: private

#### calcuate

*Calculate points and put in table.*

Line: 87

Access: private

#### order

*Order table and return.*

Line: 126

Access: private

#### main

*Method the executes @property query.
Returns league table.*

Line: 152

Access: protected

## TournamentManagerAttach

*Model for adding a user as a manager of a tournament.*

Line: 6 in file /home/jordan/workspace/sites/computing-project/models/TournamentManagerAttach.php

Extends: TournamentManagerAlter

### Properties:

#### is_league_manager

*User becomes a league manager.*

Line: 18

Access: protected

Type: 

### Methods:

#### main

*Main method calls @method subMain.*

Line: 27

Access: protected

## TournamentManagerRemove

*Model for removing a league manager from a tournament.*

Line: 6 in file /home/jordan/workspace/sites/computing-project/models/TournamentManagerRemove.php

Extends: TournamentManagerAlter

### Properties:

#### is_league_manager

*No longer a league manager.*

Line: 18

Access: protected

Type: 

### Methods:

#### main

*Main method that calls @method subMain.*

Line: 27

Access: protected

## TournamentPlayerAttach

*Model for adding a user as a player to a tournament.*

Line: 6 in file /home/jordan/workspace/sites/computing-project/models/TournamentPlayerAttach.php

Extends: TournamentPlayerAlter

### Properties:

#### is_player

*Player becomes true when adding a player.*

Line: 18

Access: protected

Type: 

### Methods:

#### main

*Calls @method subMain.*

Line: 27

Access: protected

## TournamentPlayerRemove

*Model for removing a player from a tournament.*

Line: 6 in file /home/jordan/workspace/sites/computing-project/models/TournamentPlayerRemove.php

Extends: TournamentPlayerAlter

### Properties:

#### is_player

*Player becomes false when removing a player.*

Line: 18

Access: protected

Type: 

### Methods:

#### main

*Calls @method subMain*

Line: 27

Access: protected

## TournamentSearch

*Model that is used to search for a tournament by name.*

Line: 7 in file /home/jordan/workspace/sites/computing-project/models/TournamentSearch.php

Extends: Model

### Properties:

#### query

*SQL query string for searching for tournaments and returning their name and id.*

Line: 22

Access: private

Type: String

### Methods:

#### main

*Main method.
Used to execute @property query.*

Line: 37

Access: protected

## TournamentUpdate

*Model that updates tournament info.*

Line: 9 in file /home/jordan/workspace/sites/computing-project/models/TournamentUpdate.php

Extends: Tournament

### Properties:

#### query

*SQL query string that updates tournament info.*

Line: 22

Access: private

Type: String

### Methods:

#### validate

*Validates whether the user can update tournament info.*

Line: 36

Access: private

#### update

*Method that executes @property query.
Thus updating tournament info.*

Line: 73

Access: private

#### main

*Method that checks login, then calls @method update.*

Line: 93

Access: protected

## UserGet

*Model for querying a user based on the id.*

Line: 10 in file /home/jordan/workspace/sites/computing-project/models/UserGet.php

Extends: Model

### Properties:

#### query

*SQL query string for fetching the user's data.*

Line: 32

Access: private

Type: String

#### query_managing

*SQL query string for getting tournaments that the user is managing.*

Line: 46

Access: private

Type: String

#### query_playing

*SQL query string for getting tournaments that the user is playing in.*

Line: 63

Access: private

Type: String

#### stmt

*Database object for executing query.*

Line: 80

Access: private

Type: Object

### Methods:

#### verifyResult

*Method that verifies whether the requested user is the one returned.*

Line: 90

Access: private

#### executeQuery

*Method that executes the query.*

Line: 109

Access: private

#### getPlaying

*Get tournament playing in.*

Line: 130

Access: private

#### getManaging

*Method for getting tournaments managing*

Line: 146

Access: private

#### getUserData

*Method for getting user data.*

Line: 162

Access: private

#### main

*Main method.
If the user exists, it gets tournament data.*

Line: 182

Access: protected

## UserRatings

*Model when called will return all the user's ratings over time.*

Line: 9 in file /home/jordan/workspace/sites/computing-project/models/UserRatings.php

Extends: Model

### Properties:

#### query

*SQL query string that fetches all the user's ratings over time.*

Line: 25

Access: private

Type: String

### Methods:

#### general

*Method that executes @property query.*

Line: 45

Access: private

#### main

*Checks whether user is logged in then calls @method general.*

Line: 65

Access: protected

## UserSearch

*Model that is used to search for a user.*

Line: 7 in file /home/jordan/workspace/sites/computing-project/models/UserSearch.php

Extends: Model

### Properties:

#### query

*SQL query string for searching for users and returning their name and id.*

Line: 22

Access: private

Type: String

### Methods:

#### main

*Main method.
Used to execute @property query.*

Line: 37

Access: protected

## UserUpdate

*This model is used to update user details.*

Line: 10 in file /home/jordan/workspace/sites/computing-project/models/UserUpdate.php

Extends: Model

### Properties:

#### query

*SQL query string to update the user's data.*

Line: 24

Access: private

Type: String

#### stmt

*Database object variable.*

Line: 41

Access: private

Type: Object

### Methods:

#### update

*Main method once @method main has checked login.*

Line: 51

Access: private

#### validate

*Method that validates the inputs.
Validating first name, last name, and phone numbers.*

Line: 71

Access: private

#### main

*Checks to see if the user is logged in.
Calls @method update if true.*

Line: 109

Access: protected

## API

*Allows the JavaScript to communicate with the PHP models.*

Line: 3 in file /home/jordan/workspace/sites/computing-project/php/API.php

Extends: 

### Properties:

#### modelName

*Name of the model to be called.*

Line: 10

Access: private

Type: String

### Methods:

#### execute

*Creates an instance of the class requested.
Therefore calling the model.*

Line: 20

Access: private

#### getData

*Gets the data from GET or POST.*

Line: 31

Access: private

#### requireAll

*Method that requires all the files.*

Line: 43

Access: private

#### __construct

*Method that is executed when the API is called.
Calls all of the other methods.*

Line: 61

Access: public

## Database

*The Database class connects the the database when the file is included.*

Line: 3 in file /home/jordan/workspace/sites/computing-project/php/Database.php

Extends: 

### Properties:

#### conn

*This variable is the connection variable for connecting to the database.*

Line: 10

Access: 

Type: Object

#### query_delete

*SQL query string for deleting all tables*

Line: 18

Access: private

Type: String

### Methods:

#### create

*This method is used to create the tables and columns in the database.
The `database.sql` file provides the SQL query string to do this.*

Line: 31

Access: public

#### delete

*Method that deletes all the tables in the database.*

Line: 47

Access: public

#### reset

*Resets database.
Deletes then recreates.*

Line: 64

Access: public

#### init

*This method is called when the file is included.
It is used to connect to the database.
Also to set @property conn to new PDO.*

Line: 80

Access: public

## Model

*Model class, the class is extended by all models.
It provides a foundation for all models.*

Line: 3 in file /home/jordan/workspace/sites/computing-project/php/Model.php

Extends: 

### Properties:

#### name

*The name of the data variable in POST.*

Line: 11

Access: private

Type: 

#### data

*The data object is used to store.*

Line: 19

Access: protected

Type: Array

#### return_data

*The object for holding all data that wants to be returned.*

Line: 28

Access: protected

Type: Array

#### success

*Whether model executed successfully.*

Line: 37

Access: protected

Type: {Boolean} Default true.

#### error_msg

*Error message string, if error.*

Line: 46

Access: protected

Type: String

### Methods:

#### returnObj

*Method that assembles the return object.*

Line: 56

Access: private

#### 

*This method is used to decode the JSON data in the post.*

Line: 78

Access: private

#### isPost

*This returns whether the post data variable is set.*

Line: 91

Access: private

#### setVars

*Resets variables when model is called.*

Line: 102

Access: private

#### call

*Call allows PHP to pass data into the model.*

Line: 115

Access: public

**Parameters**

* Data: Object (*object to interact with the model.*)

#### __construct

*Function that is called to check if it is called with Post.*

Line: 132

Access: public

**Parameters**

* notAPI: Boolean (**)

## Test

*Class for testing PHP models.*

Line: 13 in file /home/jordan/workspace/sites/computing-project/php/Test.php

Extends: 

### Properties:

### Methods:

#### requireAll

*Method that requires all the files.*

Line: 21

Access: private

#### testStart

*Method that should be called when starting a test.*

Line: 39

Access: private

**Parameters**

* testName: String (**)

#### testEnd

*Method that should be called when finished a test.*

Line: 66

Access: private

#### unitTest

*When making a single test, call this method.
Puts row in table.*

Line: 82

Access: private

#### loadTest

*Method that loads the test.*

Line: 105

Access: private

#### init

*Method that is called first.
Calls all tests individually.*

Line: 117

Access: public

## EloRating

*Class with functions for calculating new elo rating.*

Line: 6 in file /home/jordan/workspace/sites/computing-project/superclasses/EloRating.php

Extends: 

### Properties:

#### new_rating

*New rating of the player.*

Line: 13

Access: public

Type: Integer

#### rating_change

*Rating change.
New rating - old rating.*

Line: 21

Access: public

Type: Integer

#### k_factor

*K factor for the weight of rating change.*

Line: 30

Access: public

Type: Integer

#### query_get_rating

*SQL query for getting the player's latest rating.*

Line: 40

Access: private

Type: String

#### default_rating

*Start rating for all players.*

Line: 60

Access: public

Type: Integer

### Methods:

#### getPlayerRating

*Method gets rating of a user using @property query_get_rating.*

Line: 71

Access: public

**Parameters**

* user_id: Integer (*Id of the user to get rating.*)

#### expected

*Method that calculates a probability of a player winning.*

Line: 100

Access: public

**Parameters**

* rating_a: Integer (*Rating of player A.*)

* rating_b: Integer (*Rating of player B.*)

#### newRating

*Method that calculates a new rating based on the score.*

Line: 114

Access: public

**Parameters**

* rating_a: Integer (*Rating of player A.*)

* k_factor: Integer (*The k factor of the match.*)

* points_a: Float (*Result of the match (0 = defeat, 0.5 = draw, 1 = win).*)

* expected_a: Float (*Expected result as calculated from @method expected.*)

#### __construct

*Method that is called when an instance of the class is made.*

Line: 131

Access: public

**Parameters**

* player_a_id: Integer (*Id of player A.*)

* player_b_id: Integer (*Id of player B.*)

* tournament_id: Integer (*Id of tournament.*)

* player_a_score: Integer (*Score that player A achieved.*)

* player_b_score: Integer (*Score that player B achieved.*)

## ResultMethods

*Helpful functions for dealing with results.*

Line: 6 in file /home/jordan/workspace/sites/computing-project/superclasses/ResultMethods.php

Extends: 

### Properties:

#### query_result_exists

*SQL query that checks whether a result exists or not.*

Line: 13

Access: private

Type: String

### Methods:

#### resultExists

*Method that tests whether a match has already been played.*

Line: 36

Access: public

**Parameters**

* player1_id: Integer (*Id of player in match.*)

* player2_id: Integer (*Id of player in match.*)

* tournament_id: Integer (*Id of tournament the match is in.*)

## Tournament

*Parent class for general tournament stuff.*

Line: 7 in file /home/jordan/workspace/sites/computing-project/superclasses/Tournament.php

Extends: Model

### Properties:

#### query_players

*SQL query string for fetching the players in the tournament.*

Line: 15

Access: private

Type: String

#### query_player_count

*SQL query string for checking whether the user is a player in a particular league.*

Line: 29

Access: private

Type: String

#### query_user_exist

*SQL query string for telling whether a user exists.*

Line: 44

Access: private

Type: String

#### query_league_manager_count

*SQL query string for checking whether the user is league manager of a particular league.*

Line: 56

Access: private

Type: String

#### query_tournament_count

*SQL query string for checking whether a tournament exists.*

Line: 71

Access: private

Type: String

#### query_attach

*SQL query for attaching a user to a tournament.*

Line: 83

Access: private

Type: String

### Methods:

#### isPlayer

*Method for telling whether the current user is a player in the tournament.*

Line: 96

Access: protected

**Parameters**

* user_id: Integer (*Id of the user to query.*)

* tournament_id: Integer (*Id of the tournament to query.*)

#### isLeagueManager

*Method for telling whether the current user is a league manager is the tournament.*

Line: 124

Access: protected

**Parameters**

* user_id: Integer (*Id of the user to query.*)

* tournament_id: Integer (*Id of the tournament to query.*)

#### attachUser

*Attaches a user to a tournament.*

Line: 152

Access: protected

**Parameters**

* tournament_id: Integer (*Id of the tournament.*)

* user_id: Integer (*Id of the user.*)

#### tournamentExistsId

*Checks whether a tournament exists from parameter id.*

Line: 175

Access: protected

**Parameters**

* tournament_id: Integer (*Id of tournament*)

#### tournamentExists

*Checks whether a tournament exists.*

Line: 196

Access: protected

#### userExists

*Checks whether a user exists.*

Line: 207

Access: protected

**Parameters**

* user_id: Integer (*Id of the user to test.*)

## TournamentManagerAlter

*Parent class of classes that add or remove league managers.*

Line: 9 in file /home/jordan/workspace/sites/computing-project/superclasses/TournamentManagerAlter.php

Extends: Tournament

### Properties:

#### query

*SQL query string for changing league manager status.*

Line: 17

Access: private

Type: String

#### query_managers_count

*SQL query string for counting the number of league managers.*

Line: 32

Access: private

Type: String

#### stmt

*Database object for executing @property query.*

Line: 47

Access: private

Type: Object

### Methods:

#### noOfLeagueManagers

*Method for finding the number of league manager.*

Line: 57

Access: private

#### executeQuery

*Checks any faults and executes query.*

Line: 78

Access: private

#### verifyManager

*Verifies whether the user can carry out the task.
Returns false if:
- User doesn't exist.
- Tournament doesn't exist.
- Not a league manager.*

Line: 91

Access: private

#### general

*Main method for making the user a league manager*

Line: 132

Access: private

#### subMain

*Method that checks whether the user is logged in.*

Line: 157

Access: protected

## TournamentPlayerAlter

*Parent class of classes that add or remove players.*

Line: 8 in file /home/jordan/workspace/sites/computing-project/superclasses/TournamentPlayerAlter.php

Extends: Tournament

### Properties:

#### query

*SQL query string for updating a player*

Line: 16

Access: private

Type: String

#### stmt

*Database object for executing @property query.*

Line: 31

Access: private

Type: Object

### Methods:

#### executeQuery

*Checks any faults and executes query.*

Line: 41

Access: private

#### verifyPlayer

*Method for verifying whether the user can carry out the task.
Returns false if:
- User doesn't exist.
- Tournament doesn't exist.
- Either:
  - Not a league manager.
  - Altering someone else.*

Line: 54

Access: private

#### general

*Method that creates database object.
Binds parameters.
Checks to see if able to execute query.
Then execute query.*

Line: 92

Access: private

#### subMain

*Method that checks login.
Then calls @method general*

Line: 120

Access: protected

## Validate

*Class used to validate input text.*

Line: 3 in file /home/jordan/workspace/sites/computing-project/superclasses/Validate.php

Extends: 

### Properties:

### Methods:

#### returnData

*Returns standard data such as whether success, error message, and correction.*

Line: 10

Access: private

**Parameters**

* success: Boolean (*Whether a success or not.*)

* error_msg: String (*Error message.*)

#### userName

*Valididates user's name.
Can be first or last name.*

Line: 30

Access: 

**Parameters**

* name: String (*Name to be checked.*)

* variableName: String (*Name of variable e.g. 'First name' or 'Last name'.*)

#### tournamentName

*Validates tournament name.*

Line: 60

Access: 

**Parameters**

* name: String (**)

#### tournamentDescription

*Validates tournament description.*

Line: 88

Access: 

**Parameters**

* description: String (**)

#### email

*Validates email address.*

Line: 104

Access: 

**Parameters**

* email: String (**)

#### password

*Validates password.*

Line: 128

Access: 

**Parameters**

* password: String (**)

#### phoneNumber

*Validates phone number.*

Line: 145

Access: 

**Parameters**

* phoneNumber: String (**)

