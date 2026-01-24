module.exports = app => {

  const expressinterest = require("../controller/expressinterest.controller.js");
  var router = require("express").Router();

  // send interest with message and receiver_id
  router.post("/request", expressinterest.request);

  // accept interest with response
  router.post("/respond", expressinterest.respond);
  
  //get all approved pending request for matri_id
  router.get("/pending", expressinterest.pending);

  //Received - Pending interests
  router.get("/received/pending",expressinterest.receivedPending);

  //Received - Accepted interests
  router.get("/received/accepted",expressinterest.receivedAccepted);

  //Received - Rejected interests
  router.get("/received/rejected",expressinterest.receivedRejected);

  //Sent - Pending interests
  router.get("/sent/pending",expressinterest.sentPending);

  //Sent - Accepted interests
  router.get("/sent/accepted",expressinterest.sentAccepted);

  //Sent - Rejected interests
  router.get("/sent/rejected",expressinterest.sentRejected);

  //check privacy
  router.get("/privacy",expressinterest.checkPrivacy);

  //get all by query
  router.get("/query", expressinterest.findByQuery);

  app.use('/api/expressinterest', router);
};