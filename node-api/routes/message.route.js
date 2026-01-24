module.exports = app => {
  const message = require("../controller/message.controller.js");
  var router = require("express").Router();

  //send message
  router.post("/sendMessage",message.sendMessage);

  //get all received messages
  router.get("/received",message.receivedMessages);

  //get all sent messages
  router.get("/sent",message.sentMessages);

  //get all message by query
  router.get("/query",message.findByQuery);  

  //find message by msg_id
  router.get("/:msg_id", message.findOne);

  app.use('/api/message', router);
};