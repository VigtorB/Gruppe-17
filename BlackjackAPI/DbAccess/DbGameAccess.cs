
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
                { "deck", ArrayConverter(deck)  },
                { "player", ArrayConverter(player)  },
                { "dealer", ArrayConverter(dealer)  },
                { "gameStatus", gameStatus }
                }
            };
            collection.InsertMany(documents);
        }
        public BsonArray ArrayConverter(Card[] item)
        {
            BsonArray array = new BsonArray();
            foreach (var card in item)
            {
                array.Add(card.Rank + " of " + card.Suit);
            }
            return array;
        }

        internal void UpdateGameStatus(int id, string gameStatus)
        {
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            filter = filter & Builders<BsonDocument>.Filter.Eq("gameStatus", "pending");
            var update = Builders<BsonDocument>.Update.Set("gameStatus", gameStatus);
        }

        internal void UpdateDeck(Card[] shflDeck, int id)
        {
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            var update = Builders<BsonDocument>.Update.Set("deck", ArrayConverter(shflDeck));
        }

        public void HitGame(int id, Card[] deck, Card[] player, Card[] dealer)
        {
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");

            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            var updateDeck = Builders<BsonDocument>.Update.Set("deck", new BsonArray {/*  deck  */});
            var updatePlayer = Builders<BsonDocument>.Update.Set("player", new BsonArray {/*  player  */});
            var updateDealer = Builders<BsonDocument>.Update.Set("dealer", new BsonArray {/*  dealer  */});

            collection.UpdateOne(filter, updateDeck);
            collection.UpdateOne(filter, updatePlayer);
            collection.UpdateOne(filter, updateDealer);
        }
        public void StandGame(int id)
        {
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
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
            /* game.Deck = ArrayConverter(result["deck"].AsBsonArray.Select(x => new Card(x.AsString)).ToArray());
            game.Player = ArrayConverter(result["player"].AsBsonArray.Select(x => new Card(x.AsString)).ToArray());
            game.Dealer = ArrayConverter(result["dealer"].AsBsonArray.Select(x => new Card(x.AsString)).ToArray()); */
            game.GameStatus = result["gameStatus"].AsString;
            return game;
        }
        /* public Game getAllGamesById(int id){
            var client = new MongoClient("mongodb+srv://vigtor:Password1@cluster0.7xgxe.mongodb.net/test");
            var database = client.GetDatabase("blackjackapi");
            var collection = database.GetCollection<BsonDocument>("blackjack");
            var filter = Builders<BsonDocument>.Filter.Eq("playerid", id);
            var result = collection.Find(filter).ToList();
        } */
        /* var client = new MongoClient(_config.GetSection("MongoDb:ConnectionString").Value);
        var database = client.GetDatabase(_config.GetSection("MongoDb:blackjackapi").Value);
        var collection = database.GetCollection<BsonDocument>(_config.GetSection("MongoDb:blackjack").Value); */
        /* { "player", BsonArray  {"player" } foreach (var item in player)
                {
                    new BsonDocument {
                        { "rank", item.Rank },
                        { "suit", item.Suit }
                    }
                } } },  */
    }
}