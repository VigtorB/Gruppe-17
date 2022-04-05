
using MongoDB.Bson;
using MongoDB.Driver;
using BlackjackAPI.Models;
using MongoDB.Bson.Serialization;

namespace BlackjackAPI.DbAccess
{
    public class DbGameAccess
    {
        private readonly IConfiguration _config;

        public DbGameAccess(IConfiguration configuration)
        {
            _config = configuration;
        }
        public void GameStart(int id, object[] deck, object[] player, object[] dealer, string gameStatus, int gameid)
        {
            var client = new MongoClient(_config.GetSection("MongoDb:ConnectionString").Value);
            var database = client.GetDatabase(_config.GetSection("MongoDb:blackjackapi").Value);
            var collection = database.GetCollection<BsonDocument>(_config.GetSection("MongoDb:blackjack").Value);
            
            BsonDocument[] documents = new BsonDocument[]
            {
                new BsonDocument { 
                { "playerid", id }, 
                { "deck", deck }, 
                { "player", player }, 
                { "dealer", dealer }, 
                { "gamesesult", gameStatus }, 
                { "gameid", gameid } }
            };
            collection.InsertMany(documents);
        }
        public Game GetGame(int id)
        {
            Game game = new Game();
            var client = new MongoClient(_config.GetSection("MongoDb:ConnectionString").Value);
            var database = client.GetDatabase(_config.GetSection("MongoDb:Database").Value);
            var collection = database.GetCollection<BsonDocument>(_config.GetSection("MongoDb:Collection").Value);
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            var result = collection.Find(filter).ToList().LastOrDefault();
            game.PlayerId = id;
            //deserialize playerid
            game.Deck = (Array[])BsonSerializer.Deserialize<object[]>(result["deck"].ToJson());
            game.Player = (Array[])BsonSerializer.Deserialize<object[]>(result["player"].ToJson());
            game.Dealer = (Array[])BsonSerializer.Deserialize<object[]>(result["dealer"].ToJson());
            game.GameStatus = result["gamesesult"].AsString;
            return game;
        }
        
    }
}