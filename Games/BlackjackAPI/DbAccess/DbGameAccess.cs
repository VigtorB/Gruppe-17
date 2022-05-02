
using MongoDB.Bson;
using MongoDB.Driver;
using BlackjackAPI.Models;
using MongoDB.Bson.Serialization;

namespace BlackjackAPI.DbAccess
{
    public class DbGameAccess
    {
        public void GameStart(int id, Card[] deck, Card[] player, Card[] dealer, string gameStatus)
        {
            //TODO: Få de her metoder til at ske et andet sted, så de ikke konstant skal gentages:
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            BsonDocument[] documents = new BsonDocument[]
            {
                new BsonDocument {
                { "playerid", id },
                { "dealer", ArrayConverter(dealer) },
                { "player", ArrayConverter(player) },
                { "deck", ArrayConverter(deck) },
                { "gamestatus", gameStatus }
                }
            };
            collection.InsertMany(documents);
        }
        public BsonArray ArrayConverter(Card[] item) 
        {
            BsonArray array = new BsonArray();
            foreach (var card in item)
            {
                array.Add(new BsonDocument { { "Suit", card.Suit }, { "Rank", card.Rank } });
            }
            return array;
        }

        internal void UpdateGameStatus(int id, string gameStatus)
        {
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            filter = filter & Builders<BsonDocument>.Filter.Eq("gamestatus", "pending");
            
            var update = Builders<BsonDocument>.Update.Set("gamestatus", gameStatus);
            collection.UpdateOne(filter, update);
        }

        internal void UpdateDeck(Card[] shflDeck, int id)
        {
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            var update = Builders<BsonDocument>.Update.Set("deck", ArrayConverter(shflDeck));
        }

        public void HitGame(int id, Card[] deck, Card[] player, string gameStatus)
        {
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            filter = filter & Builders<BsonDocument>.Filter.Eq("gamestatus", "pending");
            
            var update = Builders<BsonDocument>.Update.Set("player", ArrayConverter(player));
            collection.UpdateOne(filter, update);
            var update2 = Builders<BsonDocument>.Update.Set("deck", ArrayConverter(deck));
            collection.UpdateOne(filter, update2);
            UpdateGameStatus(id, gameStatus);
            
        }
        //TODO: Overvej at kombinere metoderne og lave nogle if statements
        public void StandGame(int id, Card[] deck, Card[] dealer, string gameStatus)
        {
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            filter = filter & Builders<BsonDocument>.Filter.Eq("gamestatus", "pending");

            var update = Builders<BsonDocument>.Update.Set("dealer", ArrayConverter(dealer));
            collection.UpdateOne(filter, update);
            var update2 = Builders<BsonDocument>.Update.Set("deck", ArrayConverter(deck));
            collection.UpdateOne(filter, update2);
            UpdateGameStatus(id, gameStatus);
        }
        
        public Game GetGame(int id)
        {
            Game game = new Game();
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");

            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            BsonDocument result = collection.Find(filter).ToList().LastOrDefault();

            try
            {
                game.PlayerId = result["playerid"].AsInt32;
                game.Dealer = result["dealer"].AsBsonArray.Select(x => new Card(x["Rank"].AsInt32, x["Suit"].AsString)).ToArray();
                game.Player = result["player"].AsBsonArray.Select(x => new Card(x["Rank"].AsInt32, x["Suit"].AsString)).ToArray();
                game.Deck = result["deck"].AsBsonArray.Select(x => new Card(x["Rank"].AsInt32, x["Suit"].AsString)).ToArray();
                game.GameStatus = result["gamestatus"].AsString;
            }
            catch (System.NullReferenceException)
            {
                game.PlayerId = 0;
                game.Dealer = new Card[0];
                game.Player = new Card[0];
                game.Deck = new Card[0];
                game.GameStatus = "";
            }
            return game;
        }
        public void DeleteGame(int id)
        {
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);

            collection.DeleteOne(filter);
        }
    }
}