
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
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            BsonDocument[] documents = new BsonDocument[]
            {
                new BsonDocument { 
                { "playerid", id }, 
                { "deck", new BsonArray { /* deck */ "PLACEHOLDER"}  }, 
                { "player", new BsonArray { /* player */ "PLACEHOLDER"}  }, 
                { "dealer", new BsonArray { /* dealer */ "PLACEHOLDER"}  }, 
                { "gameStatus", gameStatus }
                }
            };
            collection.InsertMany(documents);
        }
        public Game GetGame(int id)
        {
            Game game = new Game();
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            var result = collection.Find(filter).ToList().LastOrDefault();
            game.PlayerId = id;
            game.Deck = (Array[])BsonSerializer.Deserialize<object[]>(result["deck"].ToJson());
            game.Player = (Array[])BsonSerializer.Deserialize<object[]>(result["player"].ToJson());
            game.Dealer = (Array[])BsonSerializer.Deserialize<object[]>(result["dealer"].ToJson());
            game.GameStatus = result["gamesesult"].AsString;
            return game;
        }
        
            /* var client = new MongoClient(_config.GetSection("MongoDb:ConnectionString").Value);
            var database = client.GetDatabase(_config.GetSection("MongoDb:blackjackapi").Value);
            var collection = database.GetCollection<BsonDocument>(_config.GetSection("MongoDb:blackjack").Value); */
    }
}