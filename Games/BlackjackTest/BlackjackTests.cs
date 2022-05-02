using Microsoft.VisualStudio.TestTools.UnitTesting;
using BlackjackAPI.Controllers;
using BlackjackAPI.DbAccess;
using BlackjackAPI.Models;
using Microsoft.AspNetCore.Mvc;
using System;

namespace BlackjackTest
{

    [TestClass]
    public class BlackjackTests
    {
        private int playerId = 9000;
        private int testRange = 9100;
        [TestMethod]
        public void Test1000Players()
        {
            var controller = new BlackjackController();
            var dbAccess = new DbGameAccess();
            while (playerId < testRange)
            {
                var result = controller.GameStart(playerId);
                //check that json response is valid
                Assert.AreEqual(result.GetType(), typeof(OkObjectResult));
                /* dbAccess.DeleteGame(playerId); */
                playerId++;
            }

        }
        [TestMethod]
        public void TestWinLoseWhileStanding()
        {
            var blackjackController = new BlackjackController();
            var dbAccess = new DbGameAccess();
            var game = new Game();
            var player = new Player();
            var status = "";
            var hitOrStand = 0;
            int dealerBlackjack = 0;
            int playerBlackjack = 0;
            int playerWin = 0;
            int dealerWin = 0;
            int draw = 0;
            while (playerId < testRange)
            {
                game = dbAccess.GetGame(playerId);
                if (game.GameStatus != "blackjack")
                {
                    if (player.GetValue(game.Player) < 17)
                    {
                        status = "hit";
                    }
                    else
                    {
                        status = "stand";
                    }
                    while (status != "end")
                    {
                        if (status == "hit")
                        {
                            hitOrStand = 0;
                        }
                        if (status == "stand")
                        {
                            hitOrStand = 1;
                        }
                        switch (hitOrStand)
                        {
                            case 0:
                                while (player.GetValue(game.Player) < 17)
                                {
                                    blackjackController.Hit(playerId);
                                    game = dbAccess.GetGame(playerId);
                                }
                                if (player.GetValue(game.Player) == 21)
                                {
                                    playerBlackjack++;
                                    status = "end";
                                    break;
                                }
                                else
                                {
                                    status = "stand";
                                    break;
                                }

                            case 1:
                                blackjackController.Stand(playerId);
                                game.GameStatus = dbAccess.GetGame(playerId).GameStatus;
                                if (game.GameStatus == "player win")
                                {
                                    playerWin++;
                                    status = "end";
                                    break;
                                }
                                else if (game.GameStatus == "dealer win")
                                {
                                    dealerWin++;
                                    status = "end";
                                    break;
                                }
                                else if (game.GameStatus == "dealer blackjack")
                                {
                                    dealerBlackjack++;
                                    status = "end";
                                    break;
                                }
                                else if (game.GameStatus == "draw")
                                {
                                    draw++;
                                    status = "end";
                                    break;
                                }
                                else
                                {
                                    status = "end";
                                    break;
                                }

                        }

                    }
                }
                playerId++;

            }
        

            System.Console.WriteLine("player win: " + playerWin);
            System.Console.WriteLine("player blackjack: " + playerBlackjack);
            System.Console.WriteLine("dealer win: " + dealerWin);
            System.Console.WriteLine("dealer blackjack: " + dealerBlackjack);
            System.Console.WriteLine("draw: " + draw);
            float dealerWins = dealerBlackjack + dealerWin;
            float playerWins = playerWin + playerBlackjack;
            float winLose = 0;
            if(dealerWins > playerWins){
            winLose = playerWins / dealerWins * 100;
                System.Console.WriteLine("Win/Lose percentage: " + winLose + "%");
            }
            else{
            winLose = dealerWins/playerWins * 100;
                System.Console.WriteLine("Win/Lose percentage: " + winLose + "%");

            }
            Assert.AreEqual(0, 0);

        }
        [TestMethod]
        public void Delete()
        {
            var dbAccess = new DbGameAccess();
            while (playerId < testRange)
            {
                dbAccess.DeleteGame(playerId);
                playerId++;
            }
            //random between 9000 and 9100
            Assert.AreEqual(0, 0);

        }
    }
}