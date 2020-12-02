# Korn Hole APIs

### 1) User Entrance
#### Request:
URL=https://dev73.myprojectstaging.com/APIs/kornhole/public/api/user/enter  
Type=POST  
FormData:  
&nbsp;&nbsp;&nbsp;&nbsp;1. user_id: required,string  
&nbsp;&nbsp;&nbsp;&nbsp;2. email: required,email,string  
&nbsp;&nbsp;&nbsp;&nbsp;3. platform: required,string,(Google, Facebook, Apple, Guest)  
&nbsp;&nbsp;&nbsp;&nbsp;4. OS: required,string,(Android, iOS)  
#### Response:
{  
&nbsp;&nbsp;&nbsp;&nbsp;"access_token": [access_token],  
&nbsp;&nbsp;&nbsp;&nbsp;"coins": null,  
&nbsp;&nbsp;&nbsp;&nbsp;"trophies": null  
}

### 2) User Info
#### Request:
URL=https://dev73.myprojectstaging.com/APIs/kornhole/public/api/user  
Type=GET  
Header={ Authorization: Bearer [access_token] }  
#### Response:
{  
&nbsp;&nbsp;&nbsp;&nbsp;"user": {  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"user_id": [user_id],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"email": [user_email],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"platform": [user_platform],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"OS": [user_OS],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"coins": [user_coins],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"trophies": [user_trophies],    
&nbsp;&nbsp;&nbsp;&nbsp;}  
}

### 3) Get User Coins And Trophies
#### Request:
URL=https://dev73.myprojectstaging.com/APIs/kornhole/public/api/coins-trophies  
Type=POST  
Header={ Authorization: Bearer [access_token] }  
FormData:  
&nbsp;&nbsp;&nbsp;&nbsp;1. coins: optional,numeric  
&nbsp;&nbsp;&nbsp;&nbsp;2. trophies: optional,numeric  
#### Response:
{  
&nbsp;&nbsp;&nbsp;&nbsp;"coins": [user_coins],  
&nbsp;&nbsp;&nbsp;&nbsp;"trophies": [user_trophies]  
}

### 4) Start Multiplayer Game
#### Request:
URL=https://dev73.myprojectstaging.com/APIs/kornhole/public/api/start-multiplayer-game  
Type=POST  
Header={ Authorization: Bearer [access_token] }  
FormData:  
&nbsp;&nbsp;&nbsp;&nbsp;1. room_id: required,string  
#### Response:
{  
&nbsp;&nbsp;&nbsp;&nbsp;"game_id": [game_id],  
}

### 5) Start Singleplayer Game
#### Request:
URL=https://dev73.myprojectstaging.com/APIs/kornhole/public/api/start-singleplayer-game  
Type=POST  
Header={ Authorization: Bearer [access_token] }  
FormData:  
&nbsp;&nbsp;&nbsp;&nbsp;1. game_mode: required,string,(Easy,Medium,Hard)  
#### Response:
{  
&nbsp;&nbsp;&nbsp;&nbsp;"game_id": [game_id],  
}

### 6) Declare Winner
#### Request:
URL=https://dev73.myprojectstaging.com/APIs/kornhole/public/api/declare-winner  
Type=POST  
Header={ Authorization: Bearer [access_token] }  
FormData:  
&nbsp;&nbsp;&nbsp;&nbsp;1. game_id: required,numeric  
&nbsp;&nbsp;&nbsp;&nbsp;2. winning_coins: required,numeric  
&nbsp;&nbsp;&nbsp;&nbsp;3. winning_trophies: required,numeric  
#### Response:
{  
&nbsp;&nbsp;&nbsp;&nbsp;"user": {  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"user_id": "456456",  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"email": "mwaqar666@yahoo.com",  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"platform": "Facebook",  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"OS": "Android",  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"coins": 25,  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"trophies": 5  
&nbsp;&nbsp;&nbsp;&nbsp;}  
}

### 7) Purchase An Item
#### Request:
URL=https://dev73.myprojectstaging.com/APIs/kornhole/public/api/purchase-item  
Type=POST  
Header={ Authorization: Bearer [access_token] }  
FormData:  
&nbsp;&nbsp;&nbsp;&nbsp;1. item_id: required,string  
&nbsp;&nbsp;&nbsp;&nbsp;2. item_name: required,string  
&nbsp;&nbsp;&nbsp;&nbsp;3. item_price: required,numeric  
#### Response:
{  
&nbsp;&nbsp;&nbsp;&nbsp;"items": [  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"user_id": [user_id],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"item_id": [item_id],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"item_name": [item_name],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"item_price": [item_price]  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;},  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...  
&nbsp;&nbsp;&nbsp;&nbsp;]  
}

### 8) Get Purchased Items
#### Request:
URL=https://dev73.myprojectstaging.com/APIs/kornhole/public/api/get-purchased-items  
Type=GET  
Header={ Authorization: Bearer [access_token] }  
#### Response:
{  
&nbsp;&nbsp;&nbsp;&nbsp;"items": [  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"user_id": [user_id],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"item_id": [item_id],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"item_name": [item_name],  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"item_price": [item_price]  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;},  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...  
&nbsp;&nbsp;&nbsp;&nbsp;]  
}